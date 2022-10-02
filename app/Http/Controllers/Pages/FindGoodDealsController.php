<?php

namespace App\Http\Controllers\Pages;

use App\Pricing\Price;
use App\Stepn\Level;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Response;
use Laravel\Jetstream\Jetstream;

class FindGoodDealsController
{
    public function __invoke(Request $request): Response
    {
        return Jetstream::inertia()
            ->render($request, 'FindGoodDeals', [
                'sneakers' => $this->getSneakers()
            ]);
    }

    public function getSneakers(): array
    {
        // Use gem lv2
        $gemPrice = Price::symbol('COMFORT2');
        $gemBoost = 8;
        $gemBoostPercentage = 0.7;
        $gmtPrice = Price::symbol('GMT');
        $solPrice = Price::symbol('SOL');

        return DB::table('sneakers')
            ->selectRaw(sprintf(
                'otd, 
                level, 
                quality, 
                comfort, 
                (comfort+(comfort_base*%f+%d)*comfort_socket) as comfort_max, 
                price / 1000000 as price_sol, 
                IF( level<30, (price + (%3$f*1000000*comfort_socket))/1000000 + %4$f, (price + (%3$f*1000000*comfort_socket))/1000000 ) as price_max,
                ((((CASE
                    WHEN comfort < 1000 THEN 1.07
                    WHEN comfort >= 1000 AND comfort < 2000 THEN 1.72
                    WHEN comfort >= 2000 AND comfort < 3000 THEN 1.92
                    WHEN comfort >= 3000 AND comfort < 4000 THEN 1.99
                    WHEN comfort >= 4000 AND comfort < 5000 THEN 3.37
                    ELSE 3.71
                END)*%5$f/%6$f)*1000000/price)*100) as daily_roi',
                $gemBoostPercentage,
                $gemBoost,
                $gemPrice,
                (new Level(29))->getTotalSol(),
                $gmtPrice,
                $solPrice
            ))
            ->where('otd', '>', 0)
            ->where('comfort', '>', 300)
            ->where('level', '=', 30)
            ->orderByDesc('updated_at')
            ->orderByDesc('daily_roi')
            ->orderByDesc('comfort_max')
            ->orderBy('price_max')
            ->limit(10)
            ->get()
            ->toArray();
    }
}