<?php

namespace Tests\Unit\Stepn;

use App\Stepn\HealthPointDecay;
use PHPUnit\Framework\TestCase;

class HealthPointDecayTest extends TestCase
{
    public function test_it_can_get_decay_speed_from_a_given_comfort()
    {
        $this->assertEquals(0.75, (new HealthPointDecay(1))->getDecaySpeed());
        $this->assertEquals(0.18, (new HealthPointDecay(32))->getDecaySpeed());
    }
}
