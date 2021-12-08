<?php

namespace App\Controller;

use App\Services\InputReader;
use App\Services\Day8Services;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
* + @Route("/day8")
 */
class Day8Controller extends AbstractController
{
    private InputReader $inputReader;

    private Day8Services $day8services;

    /**
     * @param InputReader $inputReader
     * @param Day8Services $day8services
     */
    public function __construct(InputReader $inputReader, Day8Services $day8services)
    {
        $this->inputReader = $inputReader;
        $this->day8services = $day8services;
    }

    /**
     * @Route("/1/{file}", defaults={"file"="day8"})
     * @param string $file
     * @return JsonResponse
     */
    public function part1(string $file): JsonResponse
    {
        $lines = $this->inputReader->getInput($file.'.txt');

        $parsedLines = $this->day8services->parseLines($lines);
        $outputOnlyArray = array_column($parsedLines, 'outputs');

        $countEasyDigits = $this->day8services->countEasyDigits($outputOnlyArray);

        return new JsonResponse($countEasyDigits, Response::HTTP_OK);
    }

    /**
     * @Route("/2/{file}", defaults={"file"="day8"})
     * @param string $file
     * @return JsonResponse
     */
    public function part2(string $file): JsonResponse
    {
        $lines = $this->inputReader->getInput($file.'.txt');

        $total = 0;
        $parsedLines = $this->day8services->parseLines($lines);
        foreach ($parsedLines as $key => $line) {
            $lineValue =  $this->day8services->determineLineValue($line);
            $total += $lineValue;
        }

        return new JsonResponse($total, Response::HTTP_OK);
    }
}