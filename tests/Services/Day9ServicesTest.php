<?php

namespace App\Tests\Services;

use App\Services\Day9Services;
use PHPUnit\Framework\TestCase;

class Day9ServicesTest extends TestCase
{
    public function testGetMinimumOfAdjacentCells()
    {
        $service = new Day9Services();

        $inputArray = [
            0 => [1, 8, 9],
            1 => [0, 3, 5],
            2 => [4, 7, 1]
        ];

        $this->assertEquals(0, $service->getMinimumOfAdjacentCells(1, 1, $inputArray));
    }

    public function testCountLocationsForBasin()
    {
        $service = new Day9Services();

        $inputArray = [
            0 => [1, 8, 9],
            1 => [0, 3, 9],
            2 => [9, 9, 1]
        ];

        $this->assertEquals(4, $service->countLocationsForBasin(1, 0, $inputArray));
    }
}