<?php

namespace App\Services;

class Day5Services
{
    public function getStacksLines(array $lines): array
    {
        $lineCounter = 0;
        foreach ($lines as $line) {
            if (empty($line)) {
                return array_slice($lines, 0, $lineCounter-1); //we dont care about the numbers
            }
            $lineCounter++;
        }
    }

    public function getStacksNumber(array $lines): int
    {
        // here we use the last line before blank line to know how many stacks we have
        $lineCounter = 0;
        foreach ($lines as $line) {
            if (empty($line)) {
                $stackValuesForLine = explode('||', chunk_split($lines[$lineCounter-1],4,'||'));
                array_pop($stackValuesForLine); // useless blank value from split
                $stackValuesForLine = array_map("trim", $stackValuesForLine);

                return count($stackValuesForLine);
            }
            $lineCounter++;
        }
    }

    public function getDirections(array $lines): array
    {
        $lineCounter = 0;
        foreach ($lines as $line) {
            if (empty($line)) {
                return array_slice($lines, $lineCounter+1);
            }
            $lineCounter++;
        }
    }

    public function getStacks(array $stacksLines, int $nbStacks): array
    {
        $stacks = [];

        foreach ($stacksLines as $line) {
            $stackValuesForLine = explode('||', chunk_split($line,4,'||'));
            array_pop($stackValuesForLine); // useless blank value from split
            $stackValuesForLine = array_map("trim", $stackValuesForLine);
            for($i = 0; $i < $nbStacks; $i++) {
                if (empty($stacks[$i+1])) { // initialize stack
                    $stacks[$i+1] = '';
                }
                if (empty($stackValuesForLine[$i])) {
                    $stacks[$i+1] .= '';
                    continue;
                }

                $matches = null;
                preg_match('#\[(.)\]#', $stackValuesForLine[$i], $matches);
                $stacks[$i+1] .= $matches[1];
            }
        }

        return $stacks;
    }

    public function moveCrane(array $instructions, array $stacks): array
    {

        foreach ($instructions as $instruction)
        {
            $matches = null;
            preg_match("#move (\d+) from (\d+) to (\d+)#", $instruction, $matches);
            $howMany = $matches[1];
            $from = $matches[2];
            $to = $matches[3];

            $cranes = substr($stacks[$from], 0, $howMany); // get the first chars
            $stacks[$from] = substr($stacks[$from], $howMany); // removes the char from the "from" stack
            $stacks[$to] = strrev($cranes).$stacks[$to]; // appends the char in reverse order to the start of "to" stack
        }

        return $stacks;
    }

    public function moveCrane9001(array $instructions, array $stacks): array
    {

        foreach ($instructions as $instruction)
        {
            $matches = null;
            preg_match("#move (\d+) from (\d+) to (\d+)#", $instruction, $matches);
            $howMany = $matches[1];
            $from = $matches[2];
            $to = $matches[3];

            $cranes = substr($stacks[$from], 0, $howMany); // get the first chars
            $stacks[$from] = substr($stacks[$from], $howMany); // removes the char from the "from" stack
            $stacks[$to] = $cranes.$stacks[$to]; // appends the char to the start of the "to" stack
        }

        return $stacks;
    }

    public function getFirstCharsOfStacks(array $stacks) {
        $finalString = '';
        foreach($stacks as $stack) {
            $finalString .= $stack[0];
        }

        return $finalString;
    }
}
