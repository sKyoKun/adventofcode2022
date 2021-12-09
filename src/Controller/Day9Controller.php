<?php

namespace App\Controller;

use App\Services\CalendarServices;
use App\Services\InputReader;
use App\Services\Day9Services;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
* + @Route("/day9")
 */
class Day9Controller extends AbstractController
{
    private InputReader $inputReader;

    private Day9Services $day9services;

    private CalendarServices $calendarServices;

    /**
     * @param InputReader $inputReader
     * @param Day9Services $day9services
     * @param CalendarServices $calendarServices
     */
    public function __construct(InputReader $inputReader, Day9Services $day9services, CalendarServices $calendarServices)
    {
        $this->inputReader = $inputReader;
        $this->day9services = $day9services;
        $this->calendarServices = $calendarServices;
    }

    /**
     * @Route("/1/{file}", defaults={"file"="day9"})
     * @param string $file
     * @return JsonResponse
     */
    public function part1(string $file): JsonResponse
    {
        $lines = $this->inputReader->getInput($file.'.txt');

        $grid = $this->calendarServices->parseInputFromStringsToArray($lines);

        $lowPoints = [];
        for ($x = 0; $x < count($grid); $x++) {
            for ($y = 0; $y < count($grid[$x]); $y++) {
                $lowestAdjacent = $this->day9services->getMinimumOfAdjacentCells($x, $y, $lines);
                if ($grid[$x][$y] < $lowestAdjacent) {
                    $lowPoints[] = $grid[$x][$y];
                }
            }
        }

        $risk = array_sum($lowPoints) + count($lowPoints);

        return new JsonResponse($risk, Response::HTTP_OK);
    }

    /**
     * @Route("/2/{file}", defaults={"file"="day9"})
     * @param string $file
     * @return JsonResponse
     */
    public function part2(string $file): JsonResponse
    {
        $lines = $this->inputReader->getInput($file.'.txt');

        $grid = $this->calendarServices->parseInputFromStringsToArray($lines);

        $lowPoints = [];
        for ($x = 0; $x < count($grid); $x++) {
            for ($y = 0; $y < count($grid[$x]); $y++) {
                $lowestAdjacent = $this->day9services->getMinimumOfAdjacentCells($x, $y, $lines);
                if ($grid[$x][$y] < $lowestAdjacent) {
                    $lowPoints[] = ['x' => $x, 'y' => $y];
                }
            }
        }

        $locationPerBasin = [];
        foreach ($lowPoints as $key => $lowPoint) {
            $locationPerBasin[] = $this->day9services->countLocationsForBasin($lowPoint['x'], $lowPoint['y'], $grid);
        }

        sort($locationPerBasin);
        $biggestBasins = array_splice($locationPerBasin, -3);

        return new JsonResponse(array_product($biggestBasins), Response::HTTP_OK);
    }
}