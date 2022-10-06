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

    public static function gmtToSol(float|int $amount): float|int
    {
        return $amount * self::symbol('GMT') / self::symbol('SOL');
    }

    public static function solToGst(float $amount): float
    {
        return $amount * self::symbol('SOL') / self::symbol('GST');
    }

    public static function floorSol(int $quality = 1, int $level = 30): float|int
    {
        return DB::table('sneakers')
                ->where('quality', $quality)
                ->where('level', $level)
                ->orderBy('price')
                ->limit(1)
                ->value('price') / 1000000;
    }

    public static function gstToSol($amount): float|int
    {
        return $amount * self::symbol('GST') / self::symbol('SOL');
    }
}