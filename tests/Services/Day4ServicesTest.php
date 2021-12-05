<?php

namespace App\Tests\Services;

use App\Services\Day4Services;
use PHPUnit\Framework\TestCase;

class Day4ServicesTest extends TestCase
{
    public function testDetermineIfCanScreamBingoOK()
    {
        $day4service = new Day4Services();

        $bingoLine = [0 => 5, 1 => 4, 2 => 2, 3 => 2, 4 => 2];
        $column = [0 => 4, 1 => 0, 2 => 1, 3 => 3, 4 => 4];

        $this->assertTrue($day4service->determineIfCanScreamBingo($bingoLine, $column));
    }

    public function testGetSumOfUncalledNumbers()
    {
        $day4service = new Day4Services();

        $playerNumbers = [5 => true, 3 => false, 7 => false];

        $this->assertEquals(10, $day4service->getSumOfUncalledNumbers($playerNumbers));
    }

    public function testGetLineNumbers()
    {
        $day4service = new Day4Services();

        $line = '20  5 52';
        $expected = [20, 5, 52];

        $this->assertEquals($expected, $day4service->getLineNumbers($line));
    }

    public function testUpdateLineAndColumnCount()
    {
        $day4service = new Day4Services();

        $numbers = [10,11 ,12];

        $grid[] = '20  5 52';
        $grid[] = '12  11 10';
        $grid[] = '65  8 55';

        $playerLine[0] = [0 => 0, 1 => 0, 2 => 0];
        $playerColumn[0] = [0 => 0, 1 => 0, 2 => 0];

        $expected['lines'] = [0 => 0, 1 => 3, 2 => 0];
        $expected['column'] = [0 => 1, 1 => 1, 2 => 1];

        foreach ($numbers as $number) {
            $day4service->updateLineAndColumnCount($grid, $number, $playerLine[0], $playerColumn[0]);
        }

        $this->assertEquals($expected['lines'], $playerLine[0]);
        $this->assertEquals($expected['column'], $playerColumn[0]);
    }
}