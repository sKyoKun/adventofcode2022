<?php

namespace App\Services;

class Day8Services
{
    private const ZERO = 'abcefg';
    private const ONE = 'cf';
    private const TWO = 'acdfeg';
    private const THREE = 'acdfg';
    private const FOUR = 'bcdf';
    private const FIVE = 'abdfg';
    private const SIX = 'abdefg';
    private const SEVEN = 'acf';
    private const EIGHT = 'abcdefg';
    private const NINE = 'abcdfg';

    public function parseLines(array $lines): array
    {
        $parsedLines = [];
        foreach ($lines as $key => $line) {
            $segmentsAndOutputs = explode(' | ', $line);
            $segments = explode(' ', $segmentsAndOutputs[0]);
            $outputs = explode(' ', $segmentsAndOutputs[1]);
            $parsedLines[$key]['segments'] = $segments;
            $parsedLines[$key]['outputs'] = $outputs;
            $parsedLines[$key]['unified'] = array_merge($outputs, $segments);
        }

        return $parsedLines;
    }

    public function countEasyDigits(array $lines): int
    {
        $digitCounter = 0;

        $easyDigits = $this->getEasyDigits($lines);

        foreach ($easyDigits as $line) {
            $digitCounter += count($line);
        }

        return $digitCounter;
    }

    public function getEasyDigits(array $lines): array
    {
        $easyDigitsPerLine = [];
        foreach ($lines as $line) {
            $easyDigitsPerLine[] = array_values(array_filter($line, function($value){
                return \in_array(strlen($value),
                    [
                        strlen(self::ONE),
                        strlen(self::FOUR),
                        strlen(self::SEVEN),
                        strlen(self::EIGHT)
                    ]);
            }));
        }

        return $easyDigitsPerLine;
    }

    public function determineLineValue(array $line): int
    {
        $arrayValues = [];
        $inputs = $line['segments'];
        // sorts inputs by length
        usort($inputs, function($a, $b) {
            return strlen($a) <=> strlen($b);
        });
        foreach ($inputs as $number) {
            $count = strlen($number);
            $splitString = str_split($number);
            sort($splitString);
            switch($count) {
                case 2:
                    $arrayValues[1] = $splitString;
                    break;
                case 3:
                    $arrayValues[7] = $splitString;
                    break;
                case 4:
                    $arrayValues[4] = $splitString;
                    break;
                case 5:
                    // 3 is the only number with length of 5 that fully uses all the segments of 1
                    if (2 === count(array_intersect($arrayValues[1], $splitString))) {
                        $arrayValues[3] = $splitString;
                        break;
                    // To do a 5 you need 3 segments of 4 and 1 of 1
                    } else if (3 === count(array_intersect($arrayValues[4], $splitString)) && 1 === count(array_intersect($arrayValues[1], $splitString))) {
                        $arrayValues[5] = $splitString;
                        break;
                    // The last 5 char segment is the 2
                    } else {
                        $arrayValues[2] = $splitString;
                        break;
                    }
                case 6:
                    // 9 is the only 6 char digit that fully uses all the segments of 4
                    if (4 === count(array_intersect($arrayValues[4], $splitString))) {
                        $arrayValues[9] = $splitString;
                        break;
                    // 6 is the only 6 char digit that fully uses all the segments of 5
                    } else if (5 === count(array_intersect($arrayValues[5], $splitString))) {
                        $arrayValues[6] = $splitString;
                        break;
                    // 0 is the remaining 6char digit
                    } else {
                        $arrayValues[0] = $splitString;
                        break;
                    }
                case 7:
                    $arrayValues[8] = $splitString;
                    break;
            }
        }

        $outputNumber = '';
        $outputs = $line['outputs'];
        foreach ($outputs as $number) {
            $splitString = str_split($number);
            sort($splitString);

            $outputNumber .= array_search($splitString,$arrayValues);
        }

        return (int) $outputNumber;
    }
}