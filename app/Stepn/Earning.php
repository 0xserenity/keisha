<?php

namespace App\Stepn;

use App\Pricing\Price;
use Illuminate\Support\Collection;

class Earning
{
    public static function gmt(int $comfort)
    {
        if ($comfort < 100) {
            return 1.07;
        }

        if (101 < $comfort && $comfort < 200) {
            return 1.72;
        }

        if (201 < $comfort && $comfort < 300) {
            return 1.92;
        }

        if (301 < $comfort && $comfort < 400) {
            return 1.99;
        }

        if (401 < $comfort && $comfort < 500) {
            return 3.37;
        }

        if ($comfort > 501) {
            return 3.71;
        }
    }
}