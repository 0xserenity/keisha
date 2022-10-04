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

    public static function solToGmt($amount): float|int
    {
        return $amount * self::symbol('SOL') / self::symbol('GMT');
    }
}