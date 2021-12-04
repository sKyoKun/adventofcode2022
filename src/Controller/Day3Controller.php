<?php

namespace App\Controller;

use App\Services\Day3Services;
use App\Services\InputReader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
* + @Route("/day3")
 */
class Day3Controller extends AbstractController
{
    private InputReader $inputReader;

    private Day3Services $day3services;

    /**
     * @param InputReader $inputReader
     * @param Day3Services $day3Services
     */
    public function __construct(InputReader $inputReader, Day3Services $day3Services)
    {
        $this->inputReader = $inputReader;
        $this->day3services = $day3Services;
    }

    /**
     * @Route("/1/{file}", defaults={"file"="day3"})
     * @param string $file
     * @return JsonResponse
     */
    public function day3(string $file): JsonResponse
    {
        $lines =  $this->inputReader->getInput($file.'.txt');

        $powerConsuption = $this->day3services->calculatePowerConsumption($lines);
        
        return new JsonResponse($powerConsuption, Response::HTTP_OK);
    }

    /**
     * @Route("/2/{file}", defaults={"file"="day3"})
     * @param string $file
     * @return JsonResponse
     */
    public function day3bis(string $file): JsonResponse
    {
        $lines =  $this->inputReader->getInput($file.'.txt');

        $lifeSupport = $this->day3services->calculateLifeSupportRating($lines);

        return new JsonResponse($lifeSupport, Response::HTTP_OK);
    }
}