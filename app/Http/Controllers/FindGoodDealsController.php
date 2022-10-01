<?php

namespace App\Http\Controllers;

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
        return DB::table('sneakers')
            ->selectRaw(
                'otd, 
                level, 
                quality, 
                comfort, 
                (comfort+(comfort_base*0.7+8)*comfort_socket) as comfort_max, 
                price / 1000000 as price_sol, 
                IF( level<30, (price + (0.74*1000000*comfort_socket))/1000000 +2, (price + (0.74*1000000*comfort_socket))/1000000 ) as price_max'
            )
            ->where('otd', '>', 0)
            ->orderByDesc('comfort_max')
            ->orderByDesc('updated_at')
            ->orderBy('price_max')
            ->limit(10)
            ->get()
            ->toArray();
    }
}