<?php

namespace App\Controller;

use App\Services\CalendarServices;
use App\Services\InputReader;
use App\Services\Day11Services;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
* + @Route("/day11")
 */
class Day11Controller extends AbstractController
{
    private InputReader $inputReader;

    private Day11Services $day11services;

    private CalendarServices $calendarServices;

    /**
     * @param InputReader $inputReader
     * @param Day11Services $day11services
     * @param CalendarServices $calendarServices
     */
    public function __construct(InputReader $inputReader, Day11Services $day11services, CalendarServices $calendarServices)
    {
        $this->inputReader = $inputReader;
        $this->day11services = $day11services;
        $this->calendarServices = $calendarServices;
    }

    /**
     * @Route("/1/{file}", defaults={"file"="day11"})
     * @param string $file
     * @return JsonResponse
     */
    public function part1(string $file): JsonResponse
    {
        $lines = $this->inputReader->getInput($file.'.txt');
        $octopuses = $this->calendarServices->parseInputFromStringsToIntArray($lines);
        $nbFlashes = 0;

        for ($i=0; $i<100; $i++) {
            $flashedOctopuses = [];

            for($x=0; $x < count($octopuses); $x++) {
                for($y=0; $y < count($octopuses[$x]); $y++) {
                    $octopuses[$x][$y]++;
                }
            }

            while($this->day11services->hasFlashingOctopuses($octopuses, $flashedOctopuses)) {
                for($x=0; $x<count($octopuses); $x++) {
                    for($y=0; $y<count($octopuses[$x]); $y++) {
                        if ($octopuses[$x][$y] > 9 && false === \array_key_exists("$x:$y", $flashedOctopuses)) {
                            $flashedOctopuses["$x:$y"] = true;
                            $nbFlashes++;
                            $this->day11services->updateAdjacentOctopuses($octopuses, $x, $y);
                        }
                    }
                }
            }

            foreach ($flashedOctopuses as $key => $flashedOctopus) {
                $xy = explode(':', $key);
                $octopuses[$xy[0]][$xy[1]] = 0;
                unset($flashedOctopuses[$key]);
            }

        }

        return new JsonResponse($nbFlashes, Response::HTTP_OK);
    }

    /**
     * @Route("/2/{file}", defaults={"file"="day11"})
     * @param string $file
     * @return JsonResponse
     */
    public function part2(string $file): JsonResponse
    {
        $lines = $this->inputReader->getInput($file.'.txt');

        $octopuses = $this->calendarServices->parseInputFromStringsToIntArray($lines);
        $nbFlashes = 0;

        $allFlashed = false;
        $i = 0;

        while (false === $allFlashed) {
            $flashedOctopuses = [];
            for($x=0; $x < count($octopuses); $x++) {
                for($y=0; $y < count($octopuses[$x]); $y++) {
                    $octopuses[$x][$y]++;
                }
            }

            while($this->day11services->hasFlashingOctopuses($octopuses, $flashedOctopuses)) {
                for($x=0; $x<count($octopuses); $x++) {
                    for($y=0; $y<count($octopuses[$x]); $y++) {
                        if ($octopuses[$x][$y] > 9 && false === \array_key_exists("$x:$y", $flashedOctopuses)) {
                            $flashedOctopuses["$x:$y"] = true;
                            $nbFlashes++;
                            $this->day11services->updateAdjacentOctopuses($octopuses, $x, $y);
                        }
                    }
                }
            }

            if (100 === count($flashedOctopuses)) {
                $allFlashed = true;
            }

            foreach ($flashedOctopuses as $key => $flashedOctopus) {
                $xy = explode(':', $key);
                $octopuses[$xy[0]][$xy[1]] = 0;
                unset($flashedOctopuses[$key]);
            }
            $i++;
        }

        return new JsonResponse($i, Response::HTTP_OK);
    }
}