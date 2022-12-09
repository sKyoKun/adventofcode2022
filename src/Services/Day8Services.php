<?php

namespace App\Services;

class Day8Services
{
    public function calculateMaxValuebeforePosX($currentX, $currentY, $trees)
    {
        $maxXBeforeCurrent = 0;
        for ($y = 0; $y < $currentY; $y++) {
            $maxXBeforeCurrent = max($trees[$currentX][$y], $maxXBeforeCurrent);
        }

        return $maxXBeforeCurrent;
    }

    public function calculateMaxValueAfterPosX($currentX, $currentY, $trees)
    {
        $maxXAfterCurrent = 0;
        for ($y = $currentY+1; $y < count($trees[$currentX]); $y++) {
            $maxXAfterCurrent = max($trees[$currentX][$y], $maxXAfterCurrent);
        }

        return $maxXAfterCurrent;
    }

    public function calculateMaxValuebeforePosY($currentX, $currentY, $trees)
    {
        $maxYBeforeCurrent = 0;
        for ($x = 0; $x < $currentX; $x++) {
            $maxYBeforeCurrent = max($trees[$x][$currentY], $maxYBeforeCurrent);
        }

        return $maxYBeforeCurrent;
    }

    public function calculateMaxValueAfterPosY($currentX, $currentY, $trees)
    {
        $maxYAfterCurrent = 0;
        for ($x = $currentX+1; $x < count($trees); $x++) {
            $maxYAfterCurrent = max($trees[$x][$currentY], $maxYAfterCurrent);
        }

        return $maxYAfterCurrent;
    }

    public function howManyTreesCanSeeLeft($currentX, $currentY, $trees) : int
    {
        $numberOfTrees = 0;
        for ($y = $currentY-1; $y >= 0; $y--) {
            if ($trees[$currentX][$currentY] > $trees[$currentX][$y]) {
                $numberOfTrees++;
            } elseif ($trees[$currentX][$currentY] === 0) {
                return $numberOfTrees;
            } else {
                $numberOfTrees++;

                return $numberOfTrees;
            }
        }
        return $numberOfTrees;
    }

    public function howManyTreesCanSeeRight($currentX, $currentY, $trees) : int
    {
        $numberOfTrees = 0;
        for ($y = $currentY+1; $y < count($trees[$currentX]); $y++) {
            if ($trees[$currentX][$currentY] > $trees[$currentX][$y]) {
                $numberOfTrees++;
            } elseif ($trees[$currentX][$currentY] === 0) {
                return $numberOfTrees;
            } else {
                $numberOfTrees++;

                return $numberOfTrees;
            }
        }
        return $numberOfTrees;
    }

    public function howManyTreesCanSeeUp($currentX, $currentY, $trees) : int
    {
        $numberOfTrees = 0;
        for ($x = $currentX-1; $x >= 0; $x--) {
            if ($trees[$currentX][$currentY] > $trees[$x][$currentY]) {
                $numberOfTrees++;
            } elseif ($trees[$currentX][$currentY] === 0) {
                return $numberOfTrees;
            } else {
                $numberOfTrees++;

                return $numberOfTrees;
            }
        }
        return $numberOfTrees;
    }

    public function howManyTreesCanSeeDown($currentX, $currentY, $trees) : int
    {
        $numberOfTrees = 0;
        for ($x = $currentX+1; $x < count($trees); $x++) {
            if ($trees[$currentX][$currentY] > $trees[$x][$currentY]) {
                $numberOfTrees++;
            } elseif ($trees[$currentX][$currentY] === 0) {
                return $numberOfTrees;
            } else {
                $numberOfTrees++;

                return $numberOfTrees;
            }
        }
        return $numberOfTrees;
    }

    public function isVisible($value, $maxXBefore, $maxXAfter, $maxYBefore, $maxYAfter): int
    {
        return $value > $maxXBefore || $value > $maxXAfter || $value > $maxYBefore || $value > $maxYAfter;
    }
}
