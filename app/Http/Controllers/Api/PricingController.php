<?php

namespace App\Http\Controllers\Api;

use App\Pricing\Price;
use Illuminate\Http\JsonResponse;

class PricingController
{
    public function __invoke(): JsonResponse
    {
        return response()->json([
            'GMT' => Price::symbol('GMT'),
            'SOL' => Price::symbol('SOL'),
            'BTC' => Price::symbol('BTC'),
            'BNB' => Price::symbol('BNB'),
            'ACH' => Price::symbol('ACH'),
            'AXS' => Price::symbol('AXS'),
        ]);
    }
}