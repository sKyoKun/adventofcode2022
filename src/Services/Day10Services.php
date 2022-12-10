<?php

namespace App\Services;

class Day10Services
{
    // current value = X
    // if noop, next cycle happens and next value = X
    // if addx, add one cycle and next value = X+Y
    public function readInstruction(array $instruction, bool &$readInstruction, int $valueX, int &$currentInstruction): int
    {
        $command = $instruction[0];
        if ('noop' === $command) {
            $readInstruction = true;
            $currentInstruction++;

            return $valueX;
        }

        $readInstruction = false;

        return $valueX + intval($instruction[1]);
    }
}
