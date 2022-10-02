<?php

namespace App\Stepn;

use App\Pricing\Price;
use Illuminate\Support\Collection;

class Level
{
    protected array $costs = [
        0 => [
            0,
            0,
            0
        ],
        // Level 1
        1 => [
            1, // GST Cost
            0, // GMT Cost
            60 // Time in minutes
        ],
        2 => [
            2,
            0,
            120
        ],
        3 => [
            3,
            0,
            180
        ],
        4 => [
            4,
            0,
            240
        ],
        5 => [
            10,
            10,
            300
        ],
        6 => [
            6,
            0,
            360
        ],
        7 => [
            7,
            0,
            420
        ],
        8 => [
            8,
            0,
            480
        ],
        9 => [
            9,
            0,
            540
        ],
        10 => [
            30,
            30,
            600
        ],
        11 => [
            11,
            0,
            660
        ],
        12 => [
            12,
            0,
            720
        ],
        13 => [
            13,
            0,
            780
        ],
        14 => [
            14,
            0,
            840
        ],
        15 => [
            15,
            0,
            900
        ],
        16 => [
            16,
            0,
            960
        ],
        17 => [
            17,
            0,
            1020
        ],
        18 => [
            18,
            0,
            1080
        ],
        19 => [
            19,
            0,
            1140
        ],
        20 => [
            60,
            60,
            1200
        ],
        21 => [
            21,
            0,
            1260
        ],
        22 => [
            22,
            0,
            1320
        ],
        23 => [
            23,
            0,
            1380
        ],
        24 => [
            24,
            0,
            1440
        ],
        25 => [
            25,
            0,
            1500
        ],
        26 => [
            26,
            0,
            1560
        ],
        27 => [
            27,
            0,
            1620
        ],
        28 => [
            28,
            0,
            1680
        ],
        29 => [
            29,
            29,
            1740
        ],
        30 => [
            100,
            100,
            1800
        ],
    ];

    protected int $from;

    protected int $to;

    public function __construct(int $from = 0, int $to = 30)
    {
        $this->from = $from;
        $this->to = $to;
    }

    public function costs(): Collection
    {
        return collect($this->costs)->filter(function ($item, $key) {
            return ($this->from + 1) <= $key && $this->to >= $key;
        });
    }

    public function getGst()
    {
        return $this->costs()->sum(0);
    }

    public function getGmt()
    {
        return $this->costs()->sum(1);
    }

    public function getMinutes()
    {
        return $this->costs()->sum(2);
    }

    public function getHours(): float|int
    {
        return $this->getMinutes() / 60;
    }

    public function getTotalSol(): float|int
    {
        $gmtInUsd = $this->getGmt() * Price::symbol('GMT');
        $gstInUsd = $this->getGst() * Price::symbol('GST');

        return ($gmtInUsd + $gstInUsd) / Price::symbol('SOL');
    }
}