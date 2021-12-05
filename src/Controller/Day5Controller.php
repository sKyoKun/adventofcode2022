<?php

namespace App\Controller;

use App\Services\Day5Services;
use App\Services\InputReader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
* + @Route("/day5")
 */
class Day5Controller extends AbstractController
{
    private InputReader $inputReader;

    private Day5Services $day5services;

    /**
     * @param InputReader $inputReader
     * @param Day5Services $day5services
     */
    public function __construct(InputReader $inputReader, Day5Services $day5services)
    {
        $this->inputReader = $inputReader;
        $this->day5services = $day5services;
    }

    /**
     * @Route("/1/{file}", defaults={"file"="day5"})
     * @param string $file
     * @return JsonResponse
     */
    public function part1(string $file): JsonResponse
    {
        $lines =  $this->inputReader->getInput($file.'.txt');

        $segments = $this->day5services->parseInputs($lines);
        $gridMaxX = $this->day5services->getMaxXPosition($segments);
        $gridMaxY = $this->day5services->getMaxYPosition($segments);

        $grid = [];

        foreach ($segments as $segment) {
            if ($this->day5services->isValidSegment($segment)) {
                $this->day5services->updateGridWithSegment($segment, $grid);
            }
        }

        $count = $this->day5services->countSuperior2($grid, $gridMaxX, $gridMaxY);

        return new JsonResponse($count, Response::HTTP_OK);
    }

    /**
     * @Route("/2/{file}", defaults={"file"="day5"})
     * @param string $file
     * @return JsonResponse
     */
    public function part2(string $file): JsonResponse
    {
        $lines =  $this->inputReader->getInput($file.'.txt');

        $segments = $this->day5services->parseInputs($lines);
        $gridMaxX = $this->day5services->getMaxXPosition($segments);
        $gridMaxY = $this->day5services->getMaxYPosition($segments);

        $grid = [];

        foreach ($segments as $segment) {
            if ($this->day5services->isValidSegment($segment)) {
                $this->day5services->updateGridWithSegment($segment, $grid);
            } else {
                $this->day5services->updateGridWithDiagonalSegment($segment, $grid);
            }
        }

        $count = $this->day5services->countSuperior2($grid, $gridMaxX, $gridMaxY);

        return new JsonResponse($count, Response::HTTP_OK);
    }
}