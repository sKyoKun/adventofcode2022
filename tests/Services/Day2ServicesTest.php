<?php

namespace App\Tests\Services;

use App\Services\Day2Services;
use PHPUnit\Framework\TestCase;

class Day2ServicesTest extends TestCase
{
    private const TEST_ARRAY = [
        'forward 5',
        'down 5',
        'forward 8',
        'up 3',
        'down 8',
        'forward 2'
    ];

    public function testParseInput()
    {
        $day2Service = new Day2Services();

        $expectedResult = ['forward' => 15, 'down' => 13, 'up' => 3];

        $this->assertEquals($expectedResult, $day2Service->parseInput(self::TEST_ARRAY));
    }

    public function testCalculateDepth()
    {
        $day2Service = new Day2Services();

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