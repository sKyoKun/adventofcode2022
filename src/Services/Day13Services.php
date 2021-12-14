<?php

namespace App\Services;

class Day13Services
{
    public function createGrid(array $lines)
    {
        $grid = [];
        $maxKeyY = 0;
        foreach ($lines as $line) {
            if (strstr($line, ',')) {
                $arrLine = explode(',', $line);
                $grid[(int)$arrLine[1]][(int)$arrLine[0]] = '#';
                $maxKeyY = max($maxKeyY, (int)$arrLine[0]);
            }
        }

        $maxKeyX = max(array_keys($grid));

        for($x = 0; $x <= $maxKeyX; $x++) {
            for($y = 0; $y < $maxKeyY; $y++) {
                if (false === isset($grid[$x][$y])) {
                    $grid[$x][$y] = null;
                }
                ksort($grid[$x]);
            }
        }

        ksort($grid);

        return $grid;
    }

    public function getInstructions(array $lines)
    {
        $instructions = [];

        foreach ($lines as $line) {
            if (strstr($line, 'fold')) {
                $parsedLine = explode(' ', $line);
                $instructions[] = $parsedLine[2];
            }
        }

        return $instructions;
    }

    public function foldAlongY(array &$grid, int $lineNumber)
    {
        $inversedGrid = array_reverse($grid);

        $normalGridX = 0;
        foreach($inversedGrid as $key => $line) {
            if ($key >= $lineNumber) { // kill the lines that have been folded
                unset($grid[$key]);
                $normalGridX++;
                continue;
            }

            foreach($line as $y => $value) {
                if (null !== $value) {
                    $grid[$normalGridX][$y] = '#';
                }
            }
            ksort($grid[$normalGridX]);

            $normalGridX++;
        }
    }

    public function foldAlongX(array &$grid, int $columnNumber): void
    {
        $lineSize = count($grid[0]);

        foreach($grid as $x => $line) {
            $secondPart = array_slice($line, $columnNumber+1);
            $originalY = $columnNumber - 1;

            for($y=$columnNumber; $y <= $lineSize; $y++) {
                unset($grid[$x][$y]);
            }

            foreach($secondPart as $y => $value) {
                if (null !== $value) {
                    $grid[$x][$originalY] = '#';
                }
                $originalY--;
            }

            ksort($grid[$x]);
        }
    }

    public function countHashtags(array $grid): int
    {
        $hashtags = 0;
        foreach ($grid as $x => $line) {
            foreach ($line as $y => $value) {
                if ('#' === $value) {
                    $hashtags++;
                }
            }
        }

        return $hashtags;
    }

    public function hasOnlyEmptyValues(array $line)
    {
        $nonEmptyValues = array_filter($line);

        return 0 === count($nonEmptyValues);
    }
}