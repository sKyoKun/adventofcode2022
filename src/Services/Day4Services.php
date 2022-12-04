<?php

namespace App\Services;

class Day4Services
{
    public function parseInputWithRangeAndComma(array $lines)
    {
        $finalArray = [];
        foreach ($lines as $key => $line) {
            $arrLine = explode(',', $line);
            foreach ($arrLine as $keyLine => $range) {
                $arrLine[$keyLine] = explode('-', $range);
            }
            $finalArray[$key] = $arrLine;
        }

        return $finalArray;
    }

    public function isPairFullyOverlapping(array $pair): bool
    {
        $overlap = false;
        $elvesRanges = $this->computeElvesRanges($pair);
        $elfIntersection = array_values(array_intersect(...$this->computeElvesRanges($pair)));

        if (false === empty($elfIntersection) &&
            (
                $elfIntersection === $elvesRanges[0] ||
                $elfIntersection === $elvesRanges[1]
            )
        ) {
            $overlap = true;
        }

        return $overlap;
    }

    public function isPairOverlapping(array $pair): bool
    {
        $overlap = false;
        if (false === empty(array_intersect(...$this->computeElvesRanges($pair))))
        {
            $overlap = true;
        }

        return $overlap;
    }

    private function computeElvesRanges(array $pair): array
    {
        $elvesRanges = [];
        $elvesRanges[] = range((int)$pair[0][0], (int)$pair[0][1], 1);
        $elvesRanges[] = range((int)$pair[1][0], (int)$pair[1][1], 1);

        return $elvesRanges;
    }
}
