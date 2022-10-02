<?php

namespace App\Http\Controllers\Pages;

use Illuminate\Http\Request;
use Inertia\Response;
use Laravel\Jetstream\Jetstream;

class HealthPointRestoreCostCalculatorController
{
    public function __invoke(Request $request): Response
    {
        return Jetstream::inertia()
            ->render($request, 'HealthPointRestoreCostCalculator');
    }
}