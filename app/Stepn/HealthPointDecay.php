<?php

namespace App\Stepn;

class HealthPointDecay
{
    protected array $decay = [
        // type (1: common...)
        // range: int|array
        // hp lost
        [
            1,
            1,
            0.75
        ],
        [
            1,
            2,
            0.56
        ],
        [
            1,
            3,
            0.47
        ],
        [
            1,
            4,
            0.42
        ],
        [
            1,
            5,
            0.38
        ],
        [
            1,
            6,
            0.36
        ],
        [
            1,
            7,
            0.33
        ],
        [
            1,
            8,
            0.32
        ],
        [
            1,
            9,
            0.3
        ],
        [
            1,
            10,
            0.29
        ],
        [
            1,
            11,
            0.28
        ],
        [
            1,
            12,
            0.27
        ],
        [
            1,
            13,
            0.26
        ],
        [
            1,
            14,
            0.25
        ],
        [
            1,
            [15, 16],
            0.24
        ],
        [
            1,
            [17, 18],
            0.23
        ],
        [
            1,
            [19, 20],
            0.22
        ],
        [
            1,
            [21, 22],
            0.21
        ],
        [
            1,
            [23, 25],
            0.2
        ],
        [
            1,
            [26, 29],
            0.19
        ],
        [
            1,
            [30, 33],
            0.18
        ],
        [
            1,
            [34, 38],
            0.17
        ],
        [
            1,
            [39, 44],
            0.16
        ],
        [
            1,
            [45, 52],
            0.15
        ],
        [
            1,
            [53, 62],
            0.14
        ],
        [
            1,
            [63, 75],
            0.13
        ],
        [
            1,
            [76, 92],
            0.12
        ],
        [
            1,
            [93, 114],
            0.11
        ],
        [
            1,
            [115, 9999],
            0.1
        ],
    ];

    protected float $comfort = 1;

    public function __construct(float $comfort = 1)
    {
        $this->comfort = $comfort;
    }

    public function getDecaySpeed()
    {
        $found = collect($this->decay)
            ->filter(function ($item) {
                if (is_numeric($item[1])) {
                    return floor($item[1]) === floor($this->comfort);
                }

                return $item[1][0] <= $this->comfort && $this->comfort <= $item[1][1];
            })
            ->first();

        if ($found && is_array($found)) {
            return $found[2];
        }

        return null;
    }
}