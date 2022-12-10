<?php

namespace App\Services;

class Day9Services
{
    public function executeFullmove(array &$headPositions, array &$tailPositions, string $direction, int $number)
    {
        for($i=0; $i<$number; $i++) {
            $currentHeadPosition = end($headPositions);
            $currentTailPosition = end($tailPositions);

            match ($direction) {
                'U' => $this->moveUp($headPositions,$tailPositions,$currentHeadPosition,$currentTailPosition),
                'D' => $this->moveDown($headPositions,$tailPositions,$currentHeadPosition,$currentTailPosition),
                'R' => $this->moveRight($headPositions,$tailPositions,$currentHeadPosition,$currentTailPosition),
                'L' => $this->moveLeft($headPositions,$tailPositions,$currentHeadPosition,$currentTailPosition)
            };
        }
    }

    public function moveUp(&$headPositions, &$tailPositions, $currentHeadPosition, $currentTailPosition)
    {
        $currentHeadPosition = [$currentHeadPosition[0]-1, $currentHeadPosition[1]];
        $headPositions[] = $currentHeadPosition;

        if ($currentHeadPosition[0] - $currentTailPosition[0] == -1) {
            return;
        } elseif ($currentHeadPosition[0] - $currentTailPosition[0] == -2 && $currentHeadPosition[1] !== $currentTailPosition[1]) {
            $direction = $currentHeadPosition[1] > $currentTailPosition[1] ? 1 : -1;
            $tailPositions[] = [$currentTailPosition[0] -1 , $currentTailPosition[1] + $direction];
        } elseif ($currentHeadPosition[0] - $currentTailPosition[0] == -2) {
            $tailPositions[] = [$currentTailPosition[0] -1, $currentTailPosition[1]];
        }
    }

    public function moveDown(&$headPositions, &$tailPositions, $currentHeadPosition, $currentTailPosition)
    {
        $currentHeadPosition = [$currentHeadPosition[0]+1, $currentHeadPosition[1]];
        $headPositions[] = $currentHeadPosition;

        if ($currentHeadPosition[0] - $currentTailPosition[0] == 1) {
            return;
        } elseif ($currentHeadPosition[0] - $currentTailPosition[0] == 2 && $currentHeadPosition[1] !== $currentTailPosition[1]) {
            $direction = $currentHeadPosition[1] > $currentTailPosition[1] ? 1 : -1;
            $tailPositions[] = [$currentTailPosition[0]+1, $currentTailPosition[1] +$direction];
        } elseif ($currentHeadPosition[0] - $currentTailPosition[0] == 2) {
            $tailPositions[] = [$currentTailPosition[0]+1, $currentTailPosition[1]];
        }
    }

    public function moveRight(&$headPositions, &$tailPositions, $currentHeadPosition, $currentTailPosition): void
    {

        $currentHeadPosition = [$currentHeadPosition[0], $currentHeadPosition[1]+1];
        $headPositions[] = $currentHeadPosition;

        if ($currentHeadPosition[1] - $currentTailPosition[1] == 1) {
            return;
        } elseif ($currentHeadPosition[1] - $currentTailPosition[1] == 2 && $currentHeadPosition[0] !== $currentTailPosition[0]) {
            $direction = $currentHeadPosition[0] > $currentTailPosition[0] ? 1 : -1;
            $tailPositions[] = [$currentTailPosition[0]+$direction, $currentTailPosition[1] +1];
        } elseif ($currentHeadPosition[1] - $currentTailPosition[1] == 2) {
            $tailPositions[] = [$currentTailPosition[0], $currentTailPosition[1]+1];
        }
    }

    public function moveLeft(&$headPositions, &$tailPositions, $currentHeadPosition, $currentTailPosition)
    {
        $currentHeadPosition = [$currentHeadPosition[0], $currentHeadPosition[1]-1];
        $headPositions[] = $currentHeadPosition;

        if ($currentHeadPosition[1] - $currentTailPosition[1] == -1) {
            return;
        } elseif ($currentHeadPosition[1] - $currentTailPosition[1] == -2 && $currentHeadPosition[0] !== $currentTailPosition[0]) {
            $direction = $currentHeadPosition[0] > $currentTailPosition[0] ? 1 : -1;
            $tailPositions[] = [$currentTailPosition[0]+$direction, $currentTailPosition[1]-1];
        } elseif ($currentHeadPosition[1] - $currentTailPosition[1] == -2) {
            $tailPositions[] = [$currentTailPosition[0], $currentTailPosition[1]-1];
        }
    }
}
