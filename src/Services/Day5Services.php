<?php

namespace App\Services;

class Day5Services
{
    public function parseInputs(array $lines): array
    {
        $segments = [];
        foreach ($lines as $key => $line) {
            $line = str_replace(' -> ', ',', $line);
            $coordinates = explode(',', $line);
            $x = [(int)$coordinates[0], (int)$coordinates[2]];
            $y = [(int)$coordinates[1], (int)$coordinates[3]];
            $segments[$key]['x'] = $x;
            $segments[$key]['y'] = $y;
        }

        return $segments;
    }

    public function isValidSegment(array $segment): bool
    {
       return ($segment['x'][0] === $segment['x'][1] || $segment['y'][0] === $segment['y'][1]);
    }

    public function getMaxXPosition(array $segments): int
    {
        $currentMax = 0;

        foreach ($segments as $segment) {
            $currentMax = max(max($segment['x']), $currentMax);
        }

        return $currentMax;
    }

    public function getMaxYPosition(array $segments): int
    {
        $currentMax = 0;

        foreach ($segments as $segment) {
            $currentMax = max(max($segment['y']), $currentMax);
        }

        return $currentMax;
    }

    public function updateGridWithSegment(array $segment, array &$grid): void
    {
        $rangeX = range($segment['x'][0], $segment['x'][1]);
        $rangeY = range($segment['y'][0], $segment['y'][1]);
        foreach ($rangeX as $indexX => $x) {
            foreach ($rangeY as $indexY => $y) {
                if(!isset($grid[$x][$y])) {
                    $grid[$x][$y] = 1;
                } else {
                    $grid[$x][$y] = $grid[$x][$y]+1;
                }
            }
        }
    }

    public function updateGridWithDiagonalSegment(array $segment, array &$grid): void
    {
        $rangeX = range($segment['x'][0], $segment['x'][1]);
        $rangeY = range($segment['y'][0], $segment['y'][1]);

        foreach ($rangeX as $idx => $x) {
            if (!isset($grid[$x][$rangeY[$idx]])) {
                $grid[$x][$rangeY[$idx]] = 1;
            } else {
                $grid[$x][$rangeY[$idx]] = $grid[$x][$rangeY[$idx]] + 1;
            }
        }
    }

    public function countSuperior2(array $grid, int $maxX, int $maxY): int
    {
        $count = 0;

        for ($x = 0; $x < $maxX +1; $x++) {
            for ($y = 0; $y < $maxY +1; $y++) {
                if (isset($grid[$x][$y]) && $grid[$x][$y] >= 2) {
                    $count++;
                }
            }
        }

        return $count;
    }
}