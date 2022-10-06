<?php

namespace App\Stepn;

class Repair
{
    protected array $cost = [
        // type (1: common...)
        // range: int|array
        // repair cost in GST
        [
            1,
            1,
            18.9
        ],
        [
            1,
            2,
            12.6
        ],
        [
            1,
            3,
            9.9
        ],
        [
            1,
            4,
            8.1
        ],
        [
            1,
            5,
            7.2
        ],
        [
            1,
            [6, 7],
            6.3
        ],
        [
            1,
            [8, 9],
            5.4
        ],
        [
            1,
            [10, 13],
            4.5
        ],
        [
            1,
            [14, 21],
            3.6
        ],
        [
            1,
            [22, 39],
            2.7
        ],
        [
            1,
            [40, 118],
            1.8
        ],
        [
            1,
            [119, 9999],
            0.9
        ],
        [
            2,
            [8, 9],
            7.2
        ],
        [
            2,
            [10, 13],
            6
        ],
        [
            2,
            [14, 21],
            4.8
        ],
        [
            2,
            [22, 39],
            3.6
        ],
        [
            2,
            [40, 118],
            2.4
        ],
        [
            2,
            [119, 9999],
            1.2
        ],
        [
            3,
            [15, 21],
            6
        ],
        [
            3,
            [22, 39],
            4.5
        ],
        [
            3,
            [40, 118],
            3
        ],
        [
            3,
            [119, 9999],
            1.5
        ],
        [
            4,
            [28, 39],
            5.4
        ],
        [
            4,
            [40, 118],
            3.6
        ],
        [
            4,
            [119, 9999],
            1.8
        ],
    ];

    protected float $resilience = 1;

    protected int $quality = 1;

    public function __construct(float $resilience = 1, int $quality = 1)
    {
        $this->resilience = $resilience;
        $this->quality = $quality;
    }

    public function getCostGst()
    {
        $found = collect($this->cost)
            ->filter(function ($item) {
                if ($this->quality === $item[0]) {
                    if (is_numeric($item[1])) {
                        return floor($item[1]) === floor($this->resilience);
                    }

                    return $item[1][0] <= $this->resilience && $this->resilience <= $item[1][1];
                }

                return false;
            })
            ->first();

        if ($found && is_array($found)) {
            return $found[2];
        }

        return null;
    }
}