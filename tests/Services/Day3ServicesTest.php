<?php

namespace App\Tests\Services;

use App\Services\Day3Services;
use PHPUnit\Framework\TestCase;

class Day3ServicesTest extends TestCase
{
    private const TEST_ARRAY = [
        00100,
        11110,
        10110,
        10111,
        10101,
        01111,
        00111,
        11100,
        10000,
        11001,
        00010,
        01010,
    ];

    public function testParseInput()
    {
        $day2Service = new Day3Services();

        $expectedResult = ['forward' => 15, 'down' => 13, 'up' => 3];

        $this->assertEquals($expectedResult, $day2Service->parseInput(self::TEST_ARRAY));
    }

    public function testCalculateDepth()
    {
        $day2Service = new Day3Services();

        $parsedInputs = $day2Service->parseInput(self::TEST_ARRAY);

        $this->assertEquals(10, $day2Service->calculateDepth($parsedInputs));
    }

    public function testCalculateHorizontal()
    {
        $day2Service = new Day2Services();

        $parsedInputs = $day2Service->parseInput(self::TEST_ARRAY);

        $this->assertEquals(15, $day2Service->calculateHorizontalPosition($parsedInputs));
    }

    public function testDepthWithAim()
    {
        $day2Service = new Day2Services();

        $this->assertEquals(60, $day2Service->calculateDepthWithAim(self::TEST_ARRAY));
    }
}