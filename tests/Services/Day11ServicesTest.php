<?php

namespace App\Tests\Services;

use App\Services\Day11Services;
use PHPUnit\Framework\TestCase;

class Day11ServicesTest extends TestCase
{
    public function testHasFlashingOctopus()
    {
        $service = new Day11Services();

        $flashedOctopuses = ['1:0' => true];
        $octopuses = [0 => [ 1, 10, 4], 1 => [ 10, 3, 7]];

        $this->assertTrue($service->hasFlashingOctopuses($octopuses, $flashedOctopuses));
    }

    public function testHasFlashingOctopusKO()
    {
        $service = new Day11Services();

        $flashedOctopuses = ['1:0' => true, '0:1' => true];
        $octopuses = [0 => [ 1, 10, 4], 1 => [ 10, 3, 7]];

        $this->assertFalse($service->hasFlashingOctopuses($octopuses, $flashedOctopuses));
    }

    public function testUpdateAdjacentOctopuses()
    {
        $service = new Day11Services();

        $array = [0 => [0,0,0], 1 => [0,1,0], 2 => [0,0,0]];
        $expectedArray = [0 => [1,1,1], 1 => [1,1,1], 2 => [1,1,1]];

        $service->updateAdjacentOctopuses($array, 1, 1);

        $this->assertEquals($expectedArray, $array);
    }
}