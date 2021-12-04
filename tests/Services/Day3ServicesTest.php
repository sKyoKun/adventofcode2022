<?php

namespace App\Tests\Services;

use App\Services\Day3Services;
use PHPUnit\Framework\TestCase;

class Day3ServicesTest extends TestCase
{
    private const TEST_ARRAY = [
        '00100',
        '11110',
        '10110',
        '10111',
        '10101',
        '01111',
        '00111',
        '11100',
        '10000',
        '11001',
        '00010',
        '01010',
    ];

    private const COMMON_VALUES_TIED = [1,0,1,0];
    private const COMMON_VALUES = [1,0,1];

    public function testDetermineRightNumberOxygen()
    {
        $day3service = new Day3Services();

        $expectedResult =  '10111';

        $this->assertEquals($expectedResult, $day3service->determineRightNumberOxygen(self::TEST_ARRAY,0));
    }

    public function testDetermineRightNumberCo2()
    {
        $day3service = new Day3Services();

        $expectedResult =  '01010';

        $this->assertEquals($expectedResult, $day3service->determineRightNumberCo2(self::TEST_ARRAY,0));
    }

    public function testMostCommonValueWithMax()
    {
        $day3service = new Day3Services();

        $this->assertEquals(1, $day3service->getMostCommonValue(self::COMMON_VALUES));
    }

    public function testMostCommonValueTied()
    {
        $day3service = new Day3Services();

        $this->assertEquals(1, $day3service->getMostCommonValue(self::COMMON_VALUES_TIED));
    }

    public function testLeastCommonValueWithMin()
    {
        $day3service = new Day3Services();

        $this->assertEquals(0, $day3service->getLeastCommonValue(self::COMMON_VALUES));
    }

    public function testLeastCommonValueTied()
    {
        $day3service = new Day3Services();

        $this->assertEquals(0, $day3service->getLeastCommonValue(self::COMMON_VALUES_TIED));
    }
}