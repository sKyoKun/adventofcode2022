<?php

namespace App\Tests\Services;

use App\Services\Day8Services;
use PHPUnit\Framework\TestCase;

class Day8ServicesTest extends TestCase
{
    public function testCountEasyDigits()
    {
        $day8service = new Day8Services();

        $array = [['abc', 'abcf', 'abcdefg', 'bbbbbbbbbbbbbbbb'], ['ab', 'aaaaaaaaaaaa','aaaaa','aaaa']];

        $this->assertEquals(5, $day8service->countEasyDigits($array));
    }

    public function testGetEasyDigits()
    {
        $day8service = new Day8Services();

        $array = [['abc', 'abcf', 'abcdefg', 'bbbbbbbbbbbbbbbb'], ['ab', 'aaaaaaaaaaaa','aaaaa','aaaa']];
        $expected = [['abc', 'abcf', 'abcdefg'], ['ab','aaaa']];

        $this->assertEquals($expected, $day8service->getEasyDigits($array));
    }

    public function testDetermineLineValue()
    {
        $day8service = new Day8Services();

        $inputs = ['acedgfb cdfbe gcdfa fbcad dab cefabd cdfgeb eafb cagedb ab | cdfeb fcadb cdfeb cdbaf'];
        $line = $day8service->parseLines($inputs);

        $this->assertEquals(5353, $day8service->determineLineValue($line[0]));
    }
}