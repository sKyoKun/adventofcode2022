<?php

namespace App\Controller;

use App\Services\Day2Services;
use App\Services\InputReader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
* + @Route("/day2")
 */
class Day2Controller extends AbstractController
{
    private InputReader $inputReader;

    private Day2Services $day2services;

    /**
     * @param InputReader $inputReader
     * @param Day2Services $day2Services
     */
    public function __construct(InputReader $inputReader, Day2Services $day2Services)
    {
        $this->inputReader = $inputReader;
        $this->day2services = $day2Services;
    }

    /**
     * @Route("/1/{file}", defaults={"file"="day2"})
     * @param string $file
     * @return JsonResponse
     */
    public function day2(string $file): JsonResponse
    {
        $lines =  $this->inputReader->getInput($file.'.txt');

        $instructions = $this->day2services->parseInput($lines);
        $depth = $this->day2services->calculateDepth($instructions);
        $horizontal = $this->day2services->calculateHorizontalPosition($instructions);
        
        return new JsonResponse($depth * $horizontal, Response::HTTP_OK);
    }

    /**
     * @Route("/2/{file}", defaults={"file"="day2"})
     * @param string $file
     * @return JsonResponse
     */
    public function day2bis(string $file): JsonResponse
    {
        $lines =  $this->inputReader->getInput($file.'.txt');

        $instructions = $this->day2services->parseInput($lines);
        $depth = $this->day2services->calculateDepthWithAim($lines); // we cant use combined instructions here
        $horizontal = $this->day2services->calculateHorizontalPosition($instructions);

        return new JsonResponse($depth * $horizontal, Response::HTTP_OK);
    }
}