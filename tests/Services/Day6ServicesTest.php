<?php

namespace App\Tests\Services;

use App\Services\Day6Services;
use PHPUnit\Framework\TestCase;

class Day6ServicesTest extends TestCase
{
    public function testFishesPerHP()
    {
        $day6service = new Day6Services();

        $fishes = ['3, 2, 1, 4, 2'];

        $expected = [
            8 => 0,
            7 => 0,
            6 => 0,
            5 => 0,
            4 => 1,
            3 => 1,
            2 => 2,
            1 => 1,
            0 => 0
        ];

        $this->assertEquals($expected, $day6service->getFishesPerHP($fishes));
    }
}