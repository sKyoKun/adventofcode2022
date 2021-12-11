<?php

namespace App\Controller;

use App\Services\InputReader;
use App\Services\Day10Services;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
* + @Route("/day10")
 */
class Day10Controller extends AbstractController
{
    private InputReader $inputReader;

    private Day10Services $day10services;

    /**
     * @param InputReader $inputReader
     * @param Day10Services $day10services
     */
    public function __construct(InputReader $inputReader, Day10Services $day10services)
    {
        $this->inputReader = $inputReader;
        $this->day10services = $day10services;
    }

    /**
     * @Route("/1/{file}", defaults={"file"="day10"})
     * @param string $file
     * @return JsonResponse
     */
    public function part1(string $file): JsonResponse
    {
        $lines = $this->inputReader->getInput($file.'.txt');

        $totalPoints = 0;
        foreach ($lines as $line) {
            $totalPoints += $this->day10services->returnInvalidCharValue($line);
        }

        return new JsonResponse($totalPoints, Response::HTTP_OK);
    }

    /**
     * @Route("/2/{file}", defaults={"file"="day10"})
     * @param string $file
     * @return JsonResponse
     */
    public function part2(string $file): JsonResponse
    {
        $lines = $this->inputReader->getInput($file.'.txt');

        $lineValues = [];

        foreach ($lines as $line) {
            if (0 !== $this->day10services->returnInvalidCharValue($line)) {
                continue;
            }
            $lineValues[] = $this->day10services->incompleteStringCalculation($line);
        }

        sort($lineValues);
        $middle = count($lineValues) / 2;

        return new JsonResponse($lineValues[$middle], Response::HTTP_OK);
    }
}