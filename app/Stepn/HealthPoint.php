<?php

namespace App\Stepn;

use App\Pricing\Price;

class HealthPoint
{
    protected array $comfortGemRestoreMap = [
        // Common
        1 => [
            // COMFORT 1
            1 => 3,
            // COMFORT 2
            2 => 39,
            // COMFORT 3
            3 => 100,
        ],
        // Uncommon
        2 => [
            1 => 1.8,
            2 => 23,
            3 => 100,
        ],
        // Rare
        3 => [
            1 => 1.2,
            2 => 16,
            3 => 92,
        ],
        // Epic
        4 => [
            1 => 0.88,
            2 => 11,
            3 => 67,
        ],
    ];

    protected array $gstCosts = [
        1 => 10,
        2 => 30,
        3 => 100
    ];

    protected int $gem;

    protected int $sneaker;

    protected int $hpToRestore = 80;

    public function __construct($hp = 80, $sneaker = 1, $gem = 1)
    {
        $this->hpToRestore = $hp;
        $this->sneaker = $sneaker;
        $this->gem = $gem;
    }

    public function getCost()
    {
        return $this->gstCosts[$this->gem];
    }

    public function getQuantity(): float
    {
        return ceil($this->hpToRestore / $this->comfortGemRestoreMap[$this->sneaker][$this->gem]);
    }

    public function getTotalInSol(): float|int
    {
        $costGstInUsd = $this->getQuantity() * $this->getCost() * Price::symbol('GST');
        $costGemInSol = $this->getQuantity() * Price::symbol(sprintf('COMFORT%d', $this->gem));
        return $costGstInUsd / Price::symbol('SOL') + $costGemInSol;
    }
}