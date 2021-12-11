<?php

namespace App\Services;

class Day10Services
{
    private const MISSING_CHAR_POINTS = [
        ')' => 1,
        ']' => 2,
        '}' => 3,
        '>' => 4
    ];

    private const ILLEGAL_CHAR_POINTS = [
        ')' => 3,
        ']' => 57,
        '}' => 1197,
        '>' => 25137
    ];

    private const CORRESPONDING_CHAR = [
        '(' => ')',
        '{' => '}',
        '[' => ']',
        '<' => '>',
    ];

    public function returnInvalidCharValue(string $line): int
    {
        $lineChars = str_split($line);
        $currentOpenedChars = [];
        foreach($lineChars as $char) {
            if (\array_key_exists($char, self::CORRESPONDING_CHAR)) { // it's an opening character
                $currentOpenedChars[] = $char;
                continue;
            }
            if (end($currentOpenedChars) !== array_search($char, self::CORRESPONDING_CHAR)) { // if the character does not match the previous opening one
                return self::ILLEGAL_CHAR_POINTS[$char];
            } else {
                array_pop($currentOpenedChars);
                continue;
            }
        }

        return 0;
    }

    public function incompleteStringCalculation(string $line): int
    {
        $totalValueOfLine = 0;
        $lineChars = str_split($line);
        $nonClosedChars = $this->getNonClosedChars($lineChars);
        $toClose = array_reverse($nonClosedChars);

        foreach ($toClose as $char) {
            $totalValueOfLine = $totalValueOfLine * 5 + self::MISSING_CHAR_POINTS[self::CORRESPONDING_CHAR[$char]];
        }

        return $totalValueOfLine;
    }

    private function getNonClosedChars(array $chars): array
    {
        $currentOpenedChars = [];
        foreach($chars as $char) {
            if (\array_key_exists($char, self::CORRESPONDING_CHAR)) { // it's an opening character
                $currentOpenedChars[] = $char;
                continue;
            }
            else {
                array_pop($currentOpenedChars);
                continue;
            }
        }

        return $currentOpenedChars;
    }
}