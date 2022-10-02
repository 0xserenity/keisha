<?php

namespace Tests\Unit\Stepn;

use PHPUnit\Framework\TestCase;
use App\Stepn\Level;

class LevelTest extends TestCase
{
    public function test_it_can_get_cost_of_leveling_full_range()
    {
        $level = new Level();
        $this->assertEquals(600, $level->getGst());
        $this->assertEquals(229, $level->getGmt());
        $this->assertEquals(465, $level->getHours());
    }

    public function test_it_can_get_cost_of_leveling_29_30_range()
    {
        $level = new Level(29);
        $this->assertEquals(100, $level->getGst());
        $this->assertEquals(100, $level->getGmt());
        $this->assertEquals(30, $level->getHours());
    }
}
