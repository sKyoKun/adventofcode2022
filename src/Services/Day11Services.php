<?php

namespace App\Services;

use Symfony\Component\ExpressionLanguage\ExpressionLanguage;

class Day11Services
{
    public function getMonkeysStats($lines)
    {
        $monkeys = [];
        $monkeyNumber = 0;
        $i = 0;

        while($i < count($lines)) {
            $monkeys[$monkeyNumber]['items'] = explode(',', explode(':', $lines[$i+1])[1]);
            $monkeys[$monkeyNumber]['operation'] = explode('old ', $lines[$i+2])[1];
            $monkeys[$monkeyNumber]['test'] = explode('by ', $lines[$i+3])[1];
            $monkeys[$monkeyNumber][1] = explode('monkey ', $lines[$i+4])[1];
            $monkeys[$monkeyNumber][0] = explode('monkey ', $lines[$i+5])[1];

            $monkeyNumber++;
            $i = $i+7;
        }

        return $monkeys;
    }

    public function executeRound(array &$monkeys, array &$inspectedItem, int $worryDivider = 3) {
        $expressionLanguage = new ExpressionLanguage();
        foreach ($monkeys as $monkeyNb => &$monkey) {
            foreach ($monkey['items'] as $item) {
                $operation = str_contains($monkey['operation'], 'old') ? str_replace('old',trim($item),$monkey['operation']) : $monkey['operation'];
                $worryLevel = $expressionLanguage->evaluate(trim($item) . $operation);
                $worryLevel = floor($worryLevel/$worryDivider);
                if (0 === $worryLevel % $monkey['test']) {
                    $monkeys[$monkey[1]]['items'][] = $worryLevel;
                } else {
                    $monkeys[$monkey[0]]['items'][] = $worryLevel;
                }
                $itemToRemove = array_search($item, $monkey['items']);
                $inspectedItem[$monkeyNb] = isset($inspectedItem[$monkeyNb]) ? $inspectedItem[$monkeyNb] + 1 : 1;
                unset($monkeys[$monkeyNb]['items'][$itemToRemove]);
            }
        }
    }
}
