<?php

namespace App\Tests\Services;

use App\Services\Day12Services;
use PHPUnit\Framework\TestCase;

class Day12ServicesTest extends TestCase
{
    public function testCaveHasFollowablePath()
    {
        $service = new Day12Services();

        $cave = [
            'a' => ['b', 'A', 'c'],
            'b' => ['b', 'end', 'c'],
            'c' => ['b', 'z', 'c']
        ];

        $this->assertTrue($service->caveHasFollowablePath($cave['a']));
        $this->assertTrue($service->caveHasFollowablePath($cave['b']));
        $this->assertFalse($service->caveHasFollowablePath($cave['c']));
    }

    public function testRemoveUnfollowablePaths()
    {
        $service = new Day12Services();

        $cave = [
            'a' => ['b', 'A', 'c'],
            'b' => ['b', 'end', 'c'],
            'c' => ['b', 'z', 'c']
        ];

        $service->removeUnfollowablePaths($cave);
        $this->assertArrayNotHasKey('c', $cave);
    }
}