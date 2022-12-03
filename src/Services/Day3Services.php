<?php

namespace App\Services;

class Day3Services
{
    private const CAPITALIZED_LETTER_START = 38; // ord for capitalized A is 65 and we want 27
    private const LOWER_CASED_LETTER_START = 96; // ord for lower A is 97 and we want 1

    public function getSumOfRucksack(array $array): int
    {
        $sum = 0;
        foreach ($array as $rucksack) {
            $nbItemsInRuckSack = count($rucksack);
            $compartments = array_chunk($rucksack, $nbItemsInRuckSack/2);
            $sameLetter = array_values(array_intersect($compartments[0], $compartments[1]))[0];
            $sum += ctype_lower($sameLetter)
                ? ord($sameLetter) - self::LOWER_CASED_LETTER_START
                : ord($sameLetter) - self::CAPITALIZED_LETTER_START;
        }

        return $sum;
    }

    public function getSumOfRucksackPerGroup(array $array): int
    {
        $sum = 0;
        $groups = array_chunk($array, 3);
        foreach ($groups as $group) {
            $sameLetter = array_values(array_intersect($group[0], $group[1], $group[2]))[0];
            $sum += ctype_lower($sameLetter)
                ? ord($sameLetter) - self::LOWER_CASED_LETTER_START
                : ord($sameLetter) - self::CAPITALIZED_LETTER_START;
        }

        return $sum;
    }

}
