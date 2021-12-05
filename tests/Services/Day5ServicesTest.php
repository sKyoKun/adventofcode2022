<?php

namespace App\Tests\Services;

use App\Services\Day5Services;
use PHPUnit\Framework\TestCase;

class Day5ServicesTest extends TestCase
{
    public function testGetMaxXPosition()
    {
        $day5service = new Day5Services();

        $segments = [
          0 => ['x' => [2,9], 'y' => [0, 6]],
          1 => ['x' => [1,4], 'y' => [0, 8]]
        ];

        $this->assertEquals(9, $day5service->getMaxXPosition($segments));
    }

    public function testGetMaxYPosition()
    {
        $day5service = new Day5Services();

        $segments = [
            0 => ['x' => [2,9], 'y' => [0, 6]],
            1 => ['x' => [1,4], 'y' => [0, 8]]
        ];

        $this->assertEquals(8, $day5service->getMaxYPosition($segments));
    }

    public function testValidSegmentOK()
    {
        $day5service = new Day5Services();

        $segmentX = ['x' => [2,2], 'y' => [0, 6]];
        $segmentY = ['x' => [2,4], 'y' => [6, 6]];

        $this->assertTrue($day5service->isValidSegment($segmentX));
        $this->assertTrue($day5service->isValidSegment($segmentY));
    }

    public function testUpdateGridWithSegment()
    {
        $day5service = new Day5Services();

        $segmentX = ['x' => [2,2], 'y' => [0, 4]];
        $segmentY = ['x' => [0,4], 'y' => [4, 4]];

        $grid = [];

        $day5service->updateGridWithSegment($segmentX, $grid);
        $expectedGrid = [2 => [
                0 => 1,
                1 => 1,
                2 => 1,
                3 => 1,
                4 => 1,
            ]
        ];

        $this->assertEquals($expectedGrid, $grid);
        $day5service->updateGridWithSegment($segmentY, $grid);

        $expectedGrid =
        [
             2 => [
                0 => 1,
                1 => 1,
                2 => 1,
                3 => 1,
                4 => 2,
            ],
            0 => [4 => 1],
            1 => [4 => 1],
            3 => [4 => 1],
            4 => [4 => 1]
        ];
        $this->assertEquals($expectedGrid, $grid);
    }

    public function testSuperior2()
    {
        $day5service = new Day5Services();

        $segmentX = ['x' => [2,2], 'y' => [0, 4]];
        $segmentY = ['x' => [0,4], 'y' => [4, 4]];

        $grid = [];

        $day5service->updateGridWithSegment($segmentX, $grid);
        $day5service->updateGridWithSegment($segmentY, $grid);

        $this->assertEquals(1, $day5service->countSuperior2($grid, 4, 4));
    }

    public function testUpdateGridWithSegmentDiagonal()
    {
        $day5service = new Day5Services();

        $segmentX = ['x' => [2,2], 'y' => [0, 4]];
        $segmentY = ['x' => [0,4], 'y' => [4, 4]];
        $segmentDiag = ['x' => [0,2], 'y' => [2, 0]];

        $grid = [];

        $day5service->updateGridWithSegment($segmentX, $grid);
        $expectedGrid = [2 => [
            0 => 1,
            1 => 1,
            2 => 1,
            3 => 1,
            4 => 1,
            ]
        ];

        $this->assertEquals($expectedGrid, $grid);
        $day5service->updateGridWithSegment($segmentY, $grid);

        $expectedGrid =
            [
                2 => [
                    0 => 1,
                    1 => 1,
                    2 => 1,
                    3 => 1,
                    4 => 2,
                ],
                0 => [4 => 1],
                1 => [4 => 1],
                3 => [4 => 1],
                4 => [4 => 1]
            ];
        $this->assertEquals($expectedGrid, $grid);

        $day5service->updateGridWithDiagonalSegment($segmentDiag, $grid);
        $expectedGrid =
            [
                2 => [
                    0 => 2,
                    1 => 1,
                    2 => 1,
                    3 => 1,
                    4 => 2,
                ],
                0 => [4 => 1, 2 => 1],
                1 => [4 => 1, 1 => 1],
                3 => [4 => 1],
                4 => [4 => 1]
            ];

        $this->assertEquals($expectedGrid, $grid);
    }
}