<?php

namespace App\Services;

class Day11Services
{
    public function hasFlashingOctopuses(array &$octopuses, array &$flashedOctopuses)
    {
        $hasFlashing = false;
        for($x=0; $x<count($octopuses); $x++) {
            for($y=0; $y<count($octopuses[$x]); $y++) {
                if($octopuses[$x][$y] > 9 && false === \array_key_exists("$x:$y", $flashedOctopuses)) {
                    $hasFlashing = true;
                }
            }
        }

        return $hasFlashing;
    }

    public function updateAdjacentOctopuses(array &$octopuses, int $currentX, int $currentY)
    {
        $adjacentPoints = [
            [$currentX-1, $currentY],
            [$currentX-1, $currentY-1],
            [$currentX-1, $currentY+1],
            [$currentX+1, $currentY],
            [$currentX+1, $currentY-1],
            [$currentX+1, $currentY+1],
            [$currentX, $currentY+1],
            [$currentX, $currentY-1],
        ];

        foreach ($adjacentPoints as [$px, $py]) {
            if (isset($octopuses[$px][$py])) {
                $octopuses[$px][$py]++;
            }
        }
    }
}