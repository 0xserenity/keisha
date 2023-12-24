<?php

namespace App\Stepn;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class SneakersFinder
{
    public static function getTopLuckSneakers(): Collection
    {
        return DB::table('sneakers')
            ->where('luck_base', '>=', 70)
            ->where('comfort', '>=', 1000)
            ->where('luck_socket', '>=', 1)
            ->where('level', '=', 30)
            ->where('updated_at', '>', now()->subHours(24))
            ->orderBy('price')
            ->orderByDesc('updated_at')
            ->limit(20)
            ->get();
    }
}