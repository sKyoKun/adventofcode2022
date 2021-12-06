<?php

namespace App\Services;

class Day6Services
{
    public function getFishesPerHP(array $fishes): array
    {
        $fishesWithHP = [];
        $fishes = explode(',', $fishes[0]);
        foreach ($fishes as $fish) {
            $fish = (int)$fish;
            if (false === \array_key_exists($fish, $fishesWithHP)) {
                $fishesWithHP[$fish] = 1;
            } else {
                $fishesWithHP[$fish]++;
            }
        }

        $possibleHP = range(0, 8);
        foreach ($possibleHP as $php) {
            if (false === array_key_exists($php, $fishesWithHP)) {
                $fishesWithHP[$php] = 0;
            }
        }

        krsort($fishesWithHP);

        return $fishesWithHP;
    }
}