<?php

namespace App\Stepn;

use App\Pricing\Price;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

trait InteractsWithSneakers
{
    public function getSneakers(): array
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
                price / 1000000 as price_sol, 
                (price + (%3$f*1000000*comfort_socket))/1000000 as price_max_sol,
                comfort_socket,
                is_fresh
                ',
                $gemBoostPercentage,
                $gemBoost,
                $gemPrice
            ))
            ->where('otd', '>', 0)
            ->where('level', '=', 30)
            ->where(function ($query) {
                $query->where('is_fresh', '=', true)
                    ->orWhere('comfort', '>=', 280);
            })
            ->orderByDesc('updated_at')
            ->orderByDesc('comfort_max')
            ->orderBy('price_max_sol')
            ->get();

        $sneakers->map(function ($sneaker) {
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
            $energy = 2;

            // Overriding comfort_max if sneakers fresh
            if ($sneaker->is_fresh) {
                $sneaker->comfort_max = $sneaker->comfort + $this->getAvailableComfort($sneaker->quality);
                $sneaker->comfort = $sneaker->comfort_max;
            }

            // Calculate earning
            $sneaker->daily_earn_gmt = $this->calculateDailyEarnGmt($sneaker->comfort) * $energy;
            $sneaker->daily_earn_max_gmt = $this->calculateDailyEarnGmt($sneaker->comfort_max) * $energy;
            $sneaker->daily_earn_sol = Price::gmtToSol($sneaker->daily_earn_gmt);
            $sneaker->daily_earn_max_sol = Price::gmtToSol($sneaker->daily_earn_max_gmt);

            // Calculate expense

            $sneaker->daily_repair_gst = Price::solToGst(0.2 * $sneaker->daily_earn_sol);
            $sneaker->daily_expense_sol = $hp->getTotalInSol() / (78 / ($decay * $energy)) + 0.2 * $sneaker->daily_earn_sol;
            $sneaker->daily_expense_gmt = Price::solToGmt($sneaker->daily_expense_sol);

            // Calculate ROI
            $sneaker->daily_roi = ($sneaker->daily_earn_sol - $sneaker->daily_expense_sol) / $sneaker->price_sol * 100;
            $sneaker->daily_roi_max = ($sneaker->daily_earn_max_sol - $sneaker->daily_expense_sol) / $sneaker->price_max_sol * 100;
            $sneaker->apy = $sneaker->daily_roi * 365;
            $sneaker->apy_max = $sneaker->daily_roi_max * 365;

            // Calculate payback period
            $sneaker->payback_period = Carbon::now()->addDays(100 / $sneaker->daily_roi)->diffForHumans();
            $sneaker->payback_period_max = Carbon::now()->addDays(100 / $sneaker->daily_roi_max)->diffForHumans();

            // Calculate liquidity
            $sneaker->liquidity = $this->getFloorPrices()[$sneaker->quality] / $sneaker->price_sol;
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

        if ($comfort < 1000) {
            return 1.16;
        }

        if ($comfort < 2000) {
            return 1.65;
        }

        if ($comfort < 3000) {
            return 2.2;
        }

        if ($comfort < 4000) {
            return 2.16;
        }

        if ($comfort < 5000) {
            return 3.29;
        }

        return 3.71;
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
            1 => Price::floorSol(),
            2 => Price::floorSol(2),
            3 => Price::floorSol(3),
            4 => Price::floorSol(4)
        ];
    }
}