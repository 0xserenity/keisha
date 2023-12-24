<?php

namespace App\Http\Controllers\Pages;

use Illuminate\Http\Request;
use Inertia\Response;
use Laravel\Jetstream\Jetstream;
use App\Stepn\SneakersFinder;

class FindLuckDealsController
{
    public function __invoke(Request $request): Response
    {
        return Jetstream::inertia()
            ->render($request, 'FindLuckDeals', [
                'sneakers' => SneakersFinder::getTopLuckSneakers()
                    ->map(function ($sneaker) {
                        $sneaker->price = $sneaker->price / 100;
                        $sneaker->luck_base = $sneaker->luck_base / 10;
                        $sneaker->comfort = $sneaker->comfort / 10;
                        $sneaker->resilience = $sneaker->resilience / 10;

                        return $sneaker;
                    })]);
    }
}