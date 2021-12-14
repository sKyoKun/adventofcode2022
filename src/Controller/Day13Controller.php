<?php

namespace App\Controller;

use App\Services\CalendarServices;
use App\Services\InputReader;
use App\Services\Day13Services;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
* + @Route("/day13")
 */
class Day13Controller extends AbstractController
{
    private InputReader $inputReader;

    private Day13Services $day13services;

    private CalendarServices $calendarServices;

    /**
     * @param InputReader $inputReader
     * @param Day13Services $day13services
     * @param CalendarServices $calendarServices
     */
    public function __construct(InputReader $inputReader, Day13Services $day13services, CalendarServices $calendarServices)
    {
        $this->inputReader = $inputReader;
        $this->day13services = $day13services;
        $this->calendarServices = $calendarServices;
    }

    /**
     * @Route("/1/{file}", defaults={"file"="day13"})
     * @param string $file
     * @return JsonResponse
     */
    public function part1(string $file): JsonResponse
    {
        $lines = $this->inputReader->getInput($file.'.txt');

        $grid = $this->day13services->createGrid($lines);
        $instructions = $this->day13services->getInstructions($lines);

        $firstInstruction = array_shift($instructions);
        $direction = explode('=', $firstInstruction)[0];
        $number = explode('=', $firstInstruction)[1];

        if('y' === $direction) {
            $this->day13services->foldAlongY($grid, $number);
        } else {
            $this->day13services->foldAlongX($grid, $number);
        }

        $hashtags = $this->day13services->countHashtags($grid);

        return new JsonResponse($hashtags, Response::HTTP_OK);
    }

    /**
     * @Route("/2/{file}", defaults={"file"="day13"})
     * @param string $file
     * @return JsonResponse
     */
    public function part2(string $file): JsonResponse
    {
        $lines = $this->inputReader->getInput($file.'.txt');

        $grid = $this->day13services->createGrid($lines);
        $instructions = $this->day13services->getInstructions($lines);

        foreach($instructions as $instruction) {
            $direction = explode('=', $instruction)[0];
            $number = explode('=', $instruction)[1];

            if ('y' === $direction) {
                $this->day13services->foldAlongY($grid, $number);
            } else {
                $this->day13services->foldAlongX($grid, $number);
            }
        }


        foreach ($grid as $x => $line) {
            foreach ($line as $y => $value) {
                if (null === $value) {
                    echo "~";
                } else {
                    echo "#";
                }
            }
            echo "<br/>";
        }

        die();

        return new JsonResponse('', Response::HTTP_NOT_ACCEPTABLE);
    }
}