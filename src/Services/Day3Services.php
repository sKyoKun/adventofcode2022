<?php


namespace App\Services;


class Day3Services
{
    public function calculatePowerConsumption($lines)
    {
        $gamma = '';
        $epsilon = '';

        $resultTab = $this->getBitsRepartition($lines);

        for ($j = 0; $j < count($resultTab); $j++)
        {
            $gamma .= $this->getMostCommonValue($resultTab[$j]);
            $epsilon .= $this->getLeastCommonValue($resultTab[$j]);
        }

        $decGamma = bindec($gamma);
        $decEpsilon = bindec($epsilon);

        return $decGamma * $decEpsilon;
    }

    public function calculateLifeSupportRating($lines)
    {
        $oxygenValue = $this->determineRightNumberOxygen($lines,0);
        $co2Value = $this->determineRightNumberCo2($lines, 0);

        $decOxygen = bindec($oxygenValue);
        $decCo2 = bindec($co2Value);

        return $decOxygen * $decCo2;
    }

    private function getBitsRepartition(array $lines): array
    {
        $repartition = [];

        foreach ($lines as $lineNumber => $line) {
            $line = (string)trim($line);

            $numberChar = strlen($line);

            for ($i = 0; $i < $numberChar; $i++) {
                $repartition[$i][] = $line[$i];
            }
        }
        return $repartition;
    }

    public function determineRightNumberOxygen(array $lines, int $bitPosition)
    {
        while(count($lines) > 1 ) {
            $resultTab = $this->getBitsRepartition($lines);
            $oxygenStart = $this->getMostCommonValue($resultTab[$bitPosition]);

            $lines = array_filter($lines, function($value) use ($oxygenStart, $bitPosition){
                return $oxygenStart === (int) $value[$bitPosition];
            });

            $bitPosition++;
        }
        return array_shift($lines);
    }

    public function determineRightNumberCo2(array $lines, int $bitPosition)
    {
        while(count($lines) > 1 ) {
            $resultTab = $this->getBitsRepartition($lines);
            $co2Start = $this->getLeastCommonValue($resultTab[$bitPosition]);

            $lines = array_filter($lines, function($value) use ($co2Start, $bitPosition){
                return $co2Start === (int) $value[$bitPosition];
            });

            $bitPosition++;
        }
        return array_shift($lines);
    }

    public function getMostCommonValue($array): int
    {
        $aggregatedValues = array_count_values($array);
        $searchedValue = array_search(max($aggregatedValues), $aggregatedValues);
        if ($aggregatedValues[0] === $aggregatedValues[1]) {
            $searchedValue = 1;
        }

        return $searchedValue;
    }

    public function getLeastCommonValue($array): int
    {
        $aggregatedValues = array_count_values($array);
        $searchedValue = array_search(min($aggregatedValues), $aggregatedValues);;
        if ($aggregatedValues[0] === $aggregatedValues[1]) {
            $searchedValue = 0;
        }

        return $searchedValue;
    }
}