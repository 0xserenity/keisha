<?php

namespace App\Http\Controllers\Api;

use App\Pricing\Price;
use Illuminate\Http\JsonResponse;

class StepnPricingController
{
    public function __invoke(): JsonResponse
    {
        return response()->json([
            'GMT' => Price::symbol('GMT'),
            'SOL' => Price::symbol('SOL'),
            'GST' => Price::symbol('GST'),
            'COMFORT1' => Price::symbol('COMFORT1'),
            'COMFORT2' => Price::symbol('COMFORT2'),
            'COMFORT3' => Price::symbol('COMFORT3')
        ]);
    }
}