<?php

namespace App\Http\Controllers\Pages;

use App\Stepn\InteractsWithSneakers;
use Illuminate\Http\Request;
use Inertia\Response;
use Laravel\Jetstream\Jetstream;

class DealsController
{
    use InteractsWithSneakers;

    public function __invoke(Request $request): Response
    {
        return Jetstream::inertia()
            ->render($request, 'Deals', [
                'sneakers' => $this->getSneakers()
            ]);
    }
}