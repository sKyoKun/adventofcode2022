<?php

namespace App\Controller;

use App\Services\CalendarServices;
use App\Services\InputReader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
* + @Route("/day7")
 */
class Day7Controller extends AbstractController
{
    const HP_FISH_DEFAULT = 6;
    const HP_FISH_NEW = 8;

    private InputReader $inputReader;

    private CalendarServices $calendarServices;

    /**
     * @param InputReader $inputReader
     * @param CalendarServices $calendarServices
     */
    public function __construct(InputReader $inputReader, CalendarServices $calendarServices)
    {
        $this->inputReader = $inputReader;
        $this->calendarServices = $calendarServices;
    }

    /**
     * @Route("/1/{file}", defaults={"file"="day7"})
     * @param string $file
     * @return JsonResponse
     */
    public function part1(string $file): JsonResponse
    {
        $lines =  $this->inputReader->getInput($file.'.txt');

        $listPositions = $this->calendarServices->parseInputWithIntegersAndComma($lines)[0];

        $leastFuel = 99999999999;

        // Get the minimal, maximal positions, and do a range of displacement
        $maxPos = max($listPositions);
        $minPos = min($listPositions);
        $range = range($minPos, $maxPos);

        foreach ($range as $value) {
            // get the sum of displacements from crab position to the range
            $fuel = array_sum(array_map(fn($position) => abs($position - $value), $listPositions));
            $leastFuel = min($fuel, $leastFuel);
        }

        return new JsonResponse($leastFuel, Response::HTTP_OK);
    }

    /**
     * @Route("/2/{file}", defaults={"file"="day7"})
     * @param string $file
     * @return JsonResponse
     */
    public function part2(string $file): JsonResponse
    {
        $lines =  $this->inputReader->getInput($file.'.txt');

        $listPositions = $this->calendarServices->parseInputWithIntegersAndComma($lines)[0];

        $leastFuel = 99999999999;

        // Get the minimal, maximal positions, and do a range of displacement
        $maxPos = max($listPositions);
        $minPos = min($listPositions);
        $range = range($minPos, $maxPos);

        foreach ($range as $value) {
            $fuel = array_sum(array_map(function($position) use ($value) {
                $displacement = abs($position - $value);
                // sum of displacement cost (increase by 1 each time you have to move)
                return $displacement * ($displacement + 1) / 2;
            }, $listPositions));
            $leastFuel = min($fuel, $leastFuel);
        }

        return new JsonResponse($leastFuel, Response::HTTP_OK);
    }
}