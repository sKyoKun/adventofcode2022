<?php

namespace App\Controller;

use App\Services\CalendarServices;
use App\Services\InputReader;
use App\Services\Day8Services;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/day8', name: 'day8')]
class Day8Controller extends AbstractController
{
    public function __construct(
        private InputReader $inputReader,
        private Day8Services $day8services,
        private CalendarServices $calendarServices
    ){
    }

    #[Route('/1/{file}', name: 'day8_1', defaults: ["file"=>"day8"])]
    public function part1(string $file): JsonResponse
    {
        $lines = $this->inputReader->getInput($file.'.txt');

        $trees = $this->calendarServices->parseInputFromStringsToIntArray($lines);
        $numberVisible = 0;

        for ($x = 0; $x < count($trees); $x++) {
            for ($y = 0; $y < count($trees[$x]); $y++) {
                $maxLeft = $this->day8services->calculateMaxValuebeforePosX($x,$y, $trees);
                $maxRight = $this->day8services->calculateMaxValueAfterPosX($x,$y, $trees);
                $maxUp = $this->day8services->calculateMaxValuebeforePosY($x,$y, $trees);
                $maxDown = $this->day8services->calculateMaxValueAfterPosY($x,$y, $trees);
                if (0 === $x || 0 === $y || count($trees)-1 === $x || count($trees[$x])-1 === $y) {
                    $numberVisible++;
                }
                elseif ($this->day8services->isVisible($trees[$x][$y], $maxLeft, $maxRight, $maxUp, $maxDown)) {
                    $numberVisible++;
                }
            }
        }

        return new JsonResponse($numberVisible, Response::HTTP_OK);
    }

    #[Route('/2/{file}', name: 'day8_2', defaults: ["file"=>"day8"])]
    public function part2(string $file): JsonResponse
    {
        $lines = $this->inputReader->getInput($file.'.txt');

        $trees = $this->calendarServices->parseInputFromStringsToIntArray($lines);

        $maxTrees = 0;

        for ($x = 0; $x < count($trees); $x++) {
            for ($y = 0; $y < count($trees[$x]); $y++) {
                $up = $this->day8services->howManyTreesCanSeeUp($x, $y, $trees);
                $left = $this->day8services->howManyTreesCanSeeLeft($x, $y, $trees);
                $right = $this->day8services->howManyTreesCanSeeRight($x, $y, $trees);
                $down = $this->day8services->howManyTreesCanSeeDown($x, $y, $trees);

                $scenicScore = $left * $right * $up * $down;
                $maxTrees = max($maxTrees, $scenicScore);
            }
        }

        return new JsonResponse($maxTrees, Response::HTTP_OK);
    }
}
