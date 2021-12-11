<?php

namespace App\Tests\Services;

use App\Services\Day10Services;
use PHPUnit\Framework\TestCase;

class Day10ServicesTest extends TestCase
{
    public function testReturnInvalidCharValue()
    {
        $service = new Day10Services();

        $invalidString = '{([(<{}[<>[]}>{[]{[(<()>';

        $this->assertEquals(1197, $service->returnInvalidCharValue($invalidString));
    }

    public function testReturnInvalidCharValueWithValidString()
    {
        $service = new Day10Services();

        $invalidString = '{(<>)}';

        $this->assertEquals(0, $service->returnInvalidCharValue($invalidString));
    }

    public function testReturnInvalidCharValueWithValidStringIncomplete()
    {
        $service = new Day10Services();

        $invalidString = '{(<>)}<';

        $this->assertEquals(0, $service->returnInvalidCharValue($invalidString));
    }

    public function testIncompleteStringCalculation()
    {
        $service = new Day10Services();

        $invalidString = '<{([{{}}[<[[[<>{}]]]>[]]';

        $this->assertEquals(294, $service->incompleteStringCalculation($invalidString));
    }
}