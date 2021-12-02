<?php


namespace App\Services;


class Day2Services
{
    public function calculateDepth(array $directions)
    {
        $depth = 0;
        foreach ($directions as $key => $length)
        {
            switch($key) {
                case 'down':
                    $depth = $depth + $length;
                    break;
                case 'up':
                    $depth = $depth - $length;
                    break;
                default:
                    break;
            }
        }

        return $depth;
    }

    public function calculateDepthWithAim(array $arrayLines)
    {
        $aim = 0;
        $depth = 0;
        foreach ($arrayLines as $line)
        {
            $directionNumberArray = explode(' ', $line);
            switch($directionNumberArray[0]) {
                case 'down':
                    $aim = $aim + $directionNumberArray[1];
                    break;
                case 'up':
                    $aim = $aim - $directionNumberArray[1];
                    break;
                case 'forward':
                    $depth = $depth + ($aim * $directionNumberArray[1]);
                    break;
                default:
                    break;
            }
        }

        return $depth;
    }

    public function calculateHorizontalPosition(array $directions)
    {
        $position = 0;
        foreach ($directions as $key => $length)
        {
            if ('forward' === $key) {
                $position = $position + $length;
            }
        }

        return $position;
    }

    public function parseInput(array $input)
    {
        $parsedArray = [];

        foreach($input as $line) {
            $directionNumberArray = explode(' ', $line);
            if (array_key_exists($directionNumberArray[0], $parsedArray)) {
                $parsedArray[$directionNumberArray[0]] += $directionNumberArray[1];
            } else {
                $parsedArray[$directionNumberArray[0]] = $directionNumberArray[1];
            }
        }

        return $parsedArray;
    }
}