<?php

namespace App\Services;

class Day14Services
{
    public function getPolymerTemplate(array &$lines): string
    {
        return array_shift($lines);
    }

    public function getPairsInsertion(array &$lines): array
    {
        $pairs = [];
        array_shift($lines); // remove empty line

        foreach ($lines as $line) {
            $pairsAndValue = explode(' -> ', $line);
            $pairs[$pairsAndValue[0]] = $pairsAndValue[1];
        }

        return $pairs;
    }

    public function updateTemplate(string &$template, array $pairs): void
    {
        $newTemplate = substr($template, 0, 1);
        for ($i=0; $i < strlen($template)-1; $i++) {
            $currentPair = substr($template, $i, 2);
            if (array_key_exists($currentPair, $pairs)) {
                $newTemplate .= $pairs[$currentPair] . substr($template, $i+1, 1) ;
            }
        }

        $template = $newTemplate;
    }

    public function getInitialPairs(string &$template, array &$calculatedPairs): void
    {
        for ($i=0; $i < strlen($template)-1; $i++) {
            $currentPair = substr($template, $i, 2);
            if (array_key_exists($currentPair, $calculatedPairs)) {
                $calculatedPairs[$currentPair]++ ;
            } else {
                $calculatedPairs[$currentPair] = 1;
            }
        }
    }

    public function updatePairs(array $pairs, array &$calculatedPairs)
    {
        $newCalculatedPairs = [];
        foreach($calculatedPairs as $pair => $number) {
            $currentPair = $pair;
            if (array_key_exists($currentPair, $pairs)) {
                $newChar = $pairs[$currentPair];
                $newPair1 = substr($currentPair, 0, 1).$newChar;
                $newPair2 = $newChar.substr($currentPair, 1, 1);

                $newCalculatedPairs[$newPair1] = isset($newCalculatedPairs[$newPair1]) ? $newCalculatedPairs[$newPair1] + $number : $number;
                $newCalculatedPairs[$newPair2] = isset($newCalculatedPairs[$newPair2]) ? $newCalculatedPairs[$newPair2] + $number : $number;
            }
        }
        $calculatedPairs = $newCalculatedPairs;
    }

    public function countMinMaxChar(string $template) : array
    {
        $arrayChar = [];
        for ($i=0; $i < strlen($template); $i++) {
            if (false === \array_key_exists($template[$i], $arrayChar)) {
                $arrayChar[$template[$i]] = 1;
            } else {
                $arrayChar[$template[$i]]++;
            }
        }

        return ['min' => min($arrayChar), 'max' => max($arrayChar)];
    }

    public function countMinMaxCharInArrayKeys(array $calculatedPairs, string $template) : array
    {
        $arrayChar = [];
        foreach ($calculatedPairs as $pair => $count)
        {
            $chars = str_split($pair);
            // we only take the first one because the second one will be first on another pair
            $arrayChar[$chars[0]] = isset($arrayChar[$chars[0]]) ? $arrayChar[$chars[0]] + $count : $count;
        }

        // we add the last character of the input
        $initialLastChar = substr($template, -1);
        $arrayChar[$initialLastChar]++;

        return ['min' => min($arrayChar), 'max' => max($arrayChar)];
    }
}