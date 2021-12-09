<?php

namespace App\Services;

class Day9Services
{
    /**
     * Gets the minimum value of adjacent cells
     * @param $currentX
     * @param $currentY
     * @param $grid
     * @return int
     */
    public function getMinimumOfAdjacentCells($currentX, $currentY, $grid): int
    {
        $lowest = 10;

        $adjacentPoints = [
            [$currentX-1, $currentY],
            [$currentX+1, $currentY],
            [$currentX, $currentY+1],
            [$currentX, $currentY-1],
        ];

        foreach ($adjacentPoints as [$posX, $posY]) {
            if (isset($grid[$posX][$posY])) {
                $lowest = min($lowest, (int) $grid[$posX][$posY]);
            }
        }

        return $lowest;
    }

    public function countLocationsForBasin($currentX, $currentY, &$grid): int
    {
       $adjacentPoints = [
         [$currentX-1, $currentY],
         [$currentX+1, $currentY],
         [$currentX, $currentY+1],
         [$currentX, $currentY-1],
       ];

       $currentCount = 0;
       foreach ($adjacentPoints as [$px, $py]) {
           // the place does not exist
           if (false === isset($grid[$px][$py])) {
               continue;
           }
           // dead end
           if (9 === (int) $grid[$px][$py]) {
               continue;
           }
           // we mark this place as passed by so we dont count it multiple times
           $grid[$px][$py] = 9;
           // we follow the path from this point
           $currentCount += $this->countLocationsForBasin($px, $py, $grid) +1; // total number of points + current one
       }

       return $currentCount;
    }
}