<?php

namespace App\Services;

class Day2Services
{
    // First player : A for Rock, B for Paper, and C for Scissors
    // Us : X for Rock, Y for Paper, and Z for Scissors.
    public const WIN_HANDS_FOR_P1 = [
        'ROCK' => 'SCISSOR',
        'PAPER' => 'ROCK',
        'SCISSOR' => 'PAPER',
    ];

    public const DRAW_HANDS_FOR_P1 = [
        'ROCK' => 'ROCK',
        'PAPER' => 'PAPER',
        'SCISSOR' => 'SCISSOR',
    ];

    public const LOSS_HANDS_FOR_P1 = [
        'ROCK' => 'PAPER',
        'PAPER' => 'SCISSOR',
        'SCISSOR' => 'ROCK',
    ];

    public const LETTERS_VALUES = [
       'A' => 'ROCK',
       'B' => 'PAPER',
       'C' => 'SCISSOR',
       'X' => 'ROCK',
       'Y' => 'PAPER',
       'Z' => 'SCISSOR',
    ];

    public const SHAPE_VALUES = [
        'ROCK' => 1,
        'PAPER' => 2,
        'SCISSOR' => 3,
    ];

    public const ROUND_VALUE = [
        'loss' => 0,
        'draw' => 3,
        'win' => 6,
    ];

    // points = Shape value + round value
    public function calculatePointsForPlayers(array $games): array
    {
        $player1 = 0;
        $player2 = 0;
        foreach ($games as $game) {
            $letterValueP1 = self::LETTERS_VALUES[$game[0]];
            $letterValueP2 = self::LETTERS_VALUES[$game[1]];
            if (self::WIN_HANDS_FOR_P1[$letterValueP1] === $letterValueP2) {
                $player1 += self::SHAPE_VALUES[$letterValueP1] + self::ROUND_VALUE['win'];
                $player2 += self::SHAPE_VALUES[$letterValueP2] + self::ROUND_VALUE['loss'];
            } elseif (self::DRAW_HANDS_FOR_P1[$letterValueP1] === $letterValueP2) {
                $player1 += self::SHAPE_VALUES[$letterValueP1] + self::ROUND_VALUE['draw'];
                $player2 += self::SHAPE_VALUES[$letterValueP2] + self::ROUND_VALUE['draw'];
            } else {
                $player1 += self::SHAPE_VALUES[$letterValueP1] + self::ROUND_VALUE['loss'];
                $player2 += self::SHAPE_VALUES[$letterValueP2] + self::ROUND_VALUE['win'];
            }
        }

        return ['player1' => $player1, 'player2' => $player2];
    }

    public function calculatePointsWithStrategy(array $games): array
    {
        $player1 = 0;
        $player2 = 0;
        foreach ($games as $game) {
            $letterValueP1 = self::LETTERS_VALUES[$game[0]];
            $strategy = $game[1];

            switch($strategy) {
                case 'X': // lose
                    $player1 += self::SHAPE_VALUES[$letterValueP1] + self::ROUND_VALUE['win'];
                    $player2 += self::SHAPE_VALUES[self::WIN_HANDS_FOR_P1[$letterValueP1]] + self::ROUND_VALUE['loss'];
                    break;
                case 'Y': // draw
                    $player1 += self::SHAPE_VALUES[$letterValueP1] + self::ROUND_VALUE['draw'];
                    $player2 += self::SHAPE_VALUES[self::DRAW_HANDS_FOR_P1[$letterValueP1]] + self::ROUND_VALUE['draw'];
                    break;
                case 'Z': // win
                    $player1 += self::SHAPE_VALUES[$letterValueP1] + self::ROUND_VALUE['loss'];
                    $player2 += self::SHAPE_VALUES[self::LOSS_HANDS_FOR_P1[$letterValueP1]] + self::ROUND_VALUE['win'];
                    break;
            }
        }

        return ['player1' => $player1, 'player2' => $player2];
    }
}
