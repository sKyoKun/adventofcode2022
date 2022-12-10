<?php

namespace App\Controller;

use App\Services\CalendarServices;
use App\Services\InputReader;
use App\Services\Day9Services;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/day9', name: 'day9')]
class Day9Controller extends AbstractController
{
    public function __construct(
        private InputReader $inputReader,
        private Day9Services $day9services,
        private CalendarServices $calendarServices
    ){
    }

    #[Route('/1/{file}', name: 'day9_1', defaults: ["file"=>"day9"])]
    public function part1(string $file): JsonResponse
    {
        $lines = $this->inputReader->getInput($file.'.txt');

        $commands = $this->calendarServices->parseInputFromStringsWithSpaceToArray($lines);

        $startX = 5;
        $startY = 5;

        $headPositions = [[$startX,$startY]];
        $tailPositions = [[$startX,$startY]];

        foreach ($commands as $command) {
            $this->day9services->executeFullmove($headPositions, $tailPositions, $command[0], $command[1]);
        }

        $grid = array_fill(0,10, '~');
        for($i=0; $i<count($grid); $i++) {
            $grid[$i] = array_fill(0,10, '~');
        }
        foreach ($tailPositions as $position) {
            $grid[$position[0]][$position[1]] = '#';
        }

        // DRAW CRT
        foreach ($grid as $x => $line) {
            foreach ($line as $y => $value) {
                echo $value;
            }
            echo "<br/>";
        }

        return new JsonResponse(count(array_unique($tailPositions, SORT_REGULAR)), Response::HTTP_OK);
    }

    #[Route('/2/{file}', name: 'day9_2', defaults: ["file"=>"day9"])]
    public function part2(string $file): JsonResponse
    {
        $lines = $this->inputReader->getInput($file.'.txt');

        return new JsonResponse('', Response::HTTP_NOT_ACCEPTABLE);
    }
}
