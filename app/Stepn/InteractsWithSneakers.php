<?php

namespace App\Stepn;

use App\Pricing\Price;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

trait InteractsWithSneakers
{
    public function getSneakers($otd = null): array
    {
        // Use gem lv2
        $gemPrice = Price::symbol('COMFORT2');
        $gemBoost = 8;
        $gemBoostPercentage = 0.7;

        $sneakers = DB::table('sneakers')
            ->selectRaw(sprintf(
                'otd, 
                level, 
                quality, 
                comfort,
                luck,
                efficiency,
                resilience,
                comfort_base,
                luck_base,
                efficiency_base,
                resilience_base,
                type, 
                (comfort+(comfort_base*%f+%d)*comfort_socket) as comfort_max, 
                price / 100 as price_gmt, 
                (price + (%3$f*100*comfort_socket))/100 as price_max_gmt,
                comfort_socket,
                is_fresh
                ',
                $gemBoostPercentage,
                $gemBoost,
                $gemPrice
            ));

        if ($otd) {
            $sneakers->where('otd', '=', $otd);
        } else {
            $sneakers->where('otd', '>', 0)
                ->where('updated_at', '>', now()->subHours(24));
        }

        $sneakers = $sneakers->where('level', '=', 30)
            ->where(function ($query) {
                $query->where('is_fresh', '=', true)
                    ->orWhere('comfort', '>=', 280);
            })
            ->orderByDesc('updated_at')
            ->orderByDesc('comfort_max')
            ->get();

        $sneakers->map(function ($sneaker) use ($gemBoostPercentage, $gemBoost, $gemPrice) {
            $hp = new HealthPoint(
                78,
                $sneaker->quality,
                2
            );
            // 78 is HP to restore (best price)
            // 0.15 is %HP reduce for 1 Energy
            // 2 is minimum Energy spent daily
            // 0.2 is 20% of GST cost to repair sneakers after running
            $decay = (new HealthPointDecay($sneaker->comfort, $sneaker->quality, 2))->getDecaySpeed();
            if($sneaker->comfort >= 1000) {
                $decay = $decay / 2;
            }
            $energy = 2;

            // Overriding comfort_max if sneakers fresh
            if ($sneaker->is_fresh) {
                $sneaker->comfort = $sneaker->comfort + $this->getAvailableComfort($sneaker->quality);
                $sneaker->comfort_max = $sneaker->comfort + ($sneaker->comfort_base * $gemBoostPercentage + $gemBoost) * $sneaker->comfort_socket;
            }

            // Calculate earning
            $sneaker->daily_earn_gmt = $this->calculateDailyEarnGmt($sneaker->comfort) * $energy * 0.4 * 0.6859504132;
            $sneaker->daily_earn_max_gmt = $this->calculateDailyEarnGmt($sneaker->comfort_max) * $energy * 0.4 * 0.6859504132;

            // Calculate expense
            $repair = new Repair($sneaker->resilience, $sneaker->quality);

            $sneaker->daily_repair_gst = $repair->getCostGst() * 3;
            $sneaker->daily_expense_gmt = $hp->getTotalInGmt() / (78 / ($decay * $energy)) + Price::gstToGmt($sneaker->daily_repair_gst);

            // Calculate ROI
            $sneaker->daily_roi = ($sneaker->daily_earn_gmt - $sneaker->daily_expense_gmt) / $sneaker->price_gmt * 100;
            $sneaker->daily_roi_max = ($sneaker->daily_earn_max_gmt - $sneaker->daily_expense_gmt) / $sneaker->price_max_gmt * 100;
            $sneaker->apy = $sneaker->daily_roi * 365;
            $sneaker->apy_max = $sneaker->daily_roi_max * 365;

            // Calculate payback period
            $sneaker->payback_period = Carbon::now()->addDays(100 / $sneaker->daily_roi)->diffForHumans();
            $sneaker->payback_period_max = Carbon::now()->addDays(100 / $sneaker->daily_roi_max)->diffForHumans();

            // Calculate liquidity
            $sneaker->liquidity = $this->getFloorPrices()[$sneaker->quality] / $sneaker->price_gmt;
        });

        return $sneakers
            ->sortByDesc(function ($sneaker) {
                return $sneaker->daily_roi;
            })
            ->values()
            ->toArray();
    }

    private function getAvailableComfort(int $quality): int
    {
        if (1 === $quality) {
            return 1200;
        }

        if (2 === $quality) {
            return 1800;
        }

        if (3 === $quality) {
            return 2400;
        }

        if (4 === $quality) {
            return 3000;
        }

        return 0;
    }

    private function calculateDailyEarnGmt($comfort): float
    {
        if ($comfort < 280) {
            return 0;
        }

        if ($comfort < 500) {
            return 1.03;
        }

        if ($comfort < 1000) {
            return 1.18;
        }

        if ($comfort < 2000) {
            return 1.51;
        }

        if ($comfort < 3000) {
            return 2.1;
        }

        if ($comfort < 4000) {
            return 2.11;
        }

        if ($comfort < 5000) {
            return 3.23;
        }

        return 3.51;
    }

    public function getLastSync(): string
    {
        return Carbon::parse(DB::table('sneakers')
            ->orderByDesc('updated_at')
            ->limit(1)
            ->value('updated_at'))->diffForHumans();
    }

    public function getFloorPrices(): array
    {
        return [
            1 => Price::floorGmt(),
            2 => Price::floorGmt(2),
            3 => Price::floorGmt(3),
            4 => Price::floorGmt(4)
        ];
    }
}
