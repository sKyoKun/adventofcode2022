<?php

namespace App\Services;

class Day4Services
{
    /**
     * Numbers that will be called
     * @param array $lines
     * @return array
     */
    public function getBingoNumbers(array $lines): array
    {
        $line = array_shift($lines);

        return explode(',', $line);
    }

    /**
     * Get grids for players
     * @param array $lines
     * @return array
     */
    public function getBingoGrids(array $lines): array
    {
        // remove first line
        array_shift($lines);

        $withoutEmptyLines = array_filter($lines, function($value){
            return '' !== $value;
        });

        $bingoGrids = [];
        $gridNumber = 0;

        while(count($withoutEmptyLines) > 0) {
            $bingoGrids[$gridNumber] = array_splice($withoutEmptyLines, 0, 5);
            $gridNumber++;
        }

        return $bingoGrids;
    }

    /**
     * Returns all the numbers of a player, with a false "called" value
     * @param array $grids
     * @return array
     */
    public function getPlayerNumbers(array $grids) : array
    {
        $playersNumbers = [];
        foreach ($grids as $player => $grid) {
            $playersNumbers[$player] = [];
            foreach($grid as $line) {
                $lineNumbers = explode(' ', $line);
                $lineNumbers = array_filter($lineNumbers, function($value){
                    return '' !== $value;
                });
                $lineNumbers = array_combine($lineNumbers,[false, false, false, false, false]);
                $playersNumbers[$player] = $lineNumbers + $playersNumbers[$player];
            }
        }

        return $playersNumbers;
    }

    /**
     * Search on which line/column is the called number, update them with the amount of number called
     * @param array $playerGrid
     * @param int $calledNumber
     * @param array $playerLines
     * @param array $playerColumns
     */
    public function updateLineAndColumnCount(array $playerGrid, int $calledNumber, array &$playerLines, array &$playerColumns): void
    {
        foreach ($playerGrid as $lineNumber => $lineContent) {
            $line = $this->getLineNumbers($lineContent);

            foreach ($line as $columnNumber => $value) {
                if ($calledNumber === (int) $value) {
                    $playerLines[$lineNumber]++;
                    $playerColumns[$columnNumber]++;
                }
            }
        }
    }

    /**
     * Initialize the array that will store how many called numbers per line / column for each player
     * @param int $nbPlayers
     * @return array
     */
    public function initializePlayersLines(int $nbPlayers): array
    {
        $playersLines = [];

        for($i = 0; $i < $nbPlayers; $i++) {
            $playersLines[$i][0] = 0;
            $playersLines[$i][1] = 0;
            $playersLines[$i][2] = 0;
            $playersLines[$i][3] = 0;
            $playersLines[$i][4] = 0;
        }

        return $playersLines;
    }

    /**
     * Gets an array of all the numbers of a line
     * @param string $lineContent
     * @return string[]
     */
    public function getLineNumbers(string $lineContent)
    {
        $lineNumbers = explode(' ', $lineContent);
        $lineNumbers = array_filter($lineNumbers, function($value){
            return '' !== trim($value);
        });

        return array_values($lineNumbers);
    }

    /**
     * Look if a line or a column is completed
     * @param array $playerLines
     * @param array $playerColumns
     * @return bool
     */
    public function determineIfCanScreamBingo(array &$playerLines, array &$playerColumns): bool
    {
        $maxNumbersOnLine = max($playerLines);
        $maxNumbersOnColumn = max($playerColumns);

        return (5 === $maxNumbersOnLine || 5 === $maxNumbersOnColumn);
    }

    /**
     * Calculates the sum of all uncalled numbers from a players grid
     * @param array $playersGridNumbers
     * @return int
     */
    public function getSumOfUncalledNumbers(array $playersGridNumbers): int
    {
        $sumUncalled = 0;
        foreach ($playersGridNumbers as $number => $called) {
            if (false === $called) {
                $sumUncalled += $number;
            }
        }

        return $sumUncalled;
    }
}