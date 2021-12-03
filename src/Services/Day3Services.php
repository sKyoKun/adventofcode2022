<?php


namespace App\Services;


class Day3Services
{
    public function calculatePowerConsuption($lines)
    {
        $gamma = '';
        $epsilon = '';

        $resultTab = [];
        $numberChar = 0;

        foreach ($lines as $lineNumber => $line) {
            $line = (string) trim($line);

            $numberChar = strlen($line);

            for ($i = 0; $i < $numberChar; $i++)
            {
                $resultTab[$lineNumber][] = $line[$i];
            }
        }

        $result = array_map($callback, array_keys($arr), array_values($arr));

        for ($j = 0; $j < count($resultTab); $j++)
        {
            $aggregatedValues = array_count_values($resultTab[$j]);

            dump($aggregatedValues);
            $gamma .= array_search(max($aggregatedValues), $aggregatedValues);
            $epsilon .= array_search(min($aggregatedValues), $aggregatedValues);
            dump ($gamma);
            dump ($epsilon);;
        }

        $decGamma = bindec($gamma);
        dump($decGamma);
        $decEpsilon = bindec($epsilon);
        dump($decEpsilon);

        return $decGamma * $decEpsilon;
    }
}