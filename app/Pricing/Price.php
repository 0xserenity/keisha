<?php

namespace App\Pricing;

use Illuminate\Support\Facades\DB;

class Price
{
    public static function symbol(string $symbol)
    {
        return DB::table('pricing')
            ->where('symbol', '=', $symbol)
            ->value('price');
    }
}