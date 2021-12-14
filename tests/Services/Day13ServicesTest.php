<?php

namespace App\Tests\Services;

use App\Services\Day13Services;
use PHPUnit\Framework\TestCase;

class Day13ServicesTest extends TestCase
{
    public function testHasOnlyEmptyValues()
    {
        $service = new Day13Services();

        $array = [0 => null, 1 => null];
        $this->assertTrue($service->hasOnlyEmptyValues($array));

        $array = [0 => '#', 1 => null];
        $this->assertFalse($service->hasOnlyEmptyValues($array));
    }
}