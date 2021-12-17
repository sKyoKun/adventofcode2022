<?php

namespace App\Controller;

use App\Services\InputReader;
use App\Services\Day14Services;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
* + @Route("/day14")
 */
class Day14Controller extends AbstractController
{
    private InputReader $inputReader;

    private Day14Services $day14services;

    /**
     * @param InputReader $inputReader
     * @param Day14Services $day14services
     */
    public function __construct(InputReader $inputReader, Day14Services $day14services)
    {
        $this->inputReader = $inputReader;
        $this->day14services = $day14services;
    }

    /**
     * @Route("/1/{file}", defaults={"file"="day14"})
     * @param string $file
     * @return JsonResponse
     */
    public function part1(string $file): JsonResponse
    {
        $lines = $this->inputReader->getInput($file.'.txt');

        $polymerTemplate = $this->day14services->getPolymerTemplate($lines);
        $pairs = $this->day14services->getPairsInsertion($lines);

        for ($step = 0; $step < 10; $step++) {
            $this->day14services->updateTemplate($polymerTemplate, $pairs);

        }

        $minMax = $this->day14services->countMinMaxChar($polymerTemplate);
        $total = $minMax['max'] - $minMax['min'];

        return new JsonResponse($total, Response::HTTP_OK);
    }

    /**
     * @Route("/2/{file}", defaults={"file"="day14"})
     * @param string $file
     * @return JsonResponse
     */
    public function part2(string $file): JsonResponse
    {
        $lines = $this->inputReader->getInput($file.'.txt');

        $polymerTemplate = $this->day14services->getPolymerTemplate($lines);
        $pairs = $this->day14services->getPairsInsertion($lines);

        $calculatedPairs = [];
        $this->day14services->getInitialPairs($polymerTemplate, $calculatedPairs);

        for ($step = 0; $step < 40; $step++) {
            $this->day14services->updatePairs($pairs, $calculatedPairs);
        }

        $minMax = $this->day14services->countMinMaxCharInArrayKeys($calculatedPairs, $polymerTemplate);
        $total = $minMax['max'] - $minMax['min'];

        return new JsonResponse($total, Response::HTTP_OK);
    }
}