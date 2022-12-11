<?php

namespace App\Controller;

use App\Services\InputReader;
use App\Services\Day11Services;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/day11', name: 'day11')]
class Day11Controller extends AbstractController
{
    public function __construct(
        private InputReader $inputReader,
        private Day11Services $day11services
    ){
    }

    #[Route('/1/{file}', name: 'day11_1', defaults: ["file"=>"day11"])]
    public function part1(string $file): JsonResponse
    {
        $lines = $this->inputReader->getInput($file.'.txt');

        $monkeysStats = $this->day11services->getMonkeysStats($lines);
        $inspectedItems = [];

        $numberOfRounds = 20;
        for($i = 0; $i < $numberOfRounds; $i++) {
            $this->day11services->executeRound($monkeysStats, $inspectedItems);
        }

        rsort($inspectedItems);

        return new JsonResponse($inspectedItems[0] * $inspectedItems[1], Response::HTTP_OK);
    }

    #[Route('/2/{file}', name: 'day11_2', defaults: ["file"=>"day11"])]
    public function part2(string $file): JsonResponse
    {
        $lines = $this->inputReader->getInput($file.'.txt');

        $monkeysStats = $this->day11services->getMonkeysStats($lines);
        $inspectedItems = [];

        $numberOfRounds = 20;
        for($i = 0; $i < $numberOfRounds; $i++) {
            $this->day11services->executeRound($monkeysStats, $inspectedItems, 1);
        }

        dd($inspectedItems);

        rsort($inspectedItems);

        return new JsonResponse($inspectedItems[0] * $inspectedItems[1], Response::HTTP_OK);

    }
}
