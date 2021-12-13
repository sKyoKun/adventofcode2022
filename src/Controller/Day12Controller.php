<?php

namespace App\Controller;

use App\Services\InputReader;
use App\Services\Day12Services;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
* + @Route("/day12")
 */
class Day12Controller extends AbstractController
{
    private InputReader $inputReader;

    private Day12Services $day12services;

    /**
     * @param InputReader $inputReader
     * @param Day12Services $day12services
     */
    public function __construct(InputReader $inputReader, Day12Services $day12services)
    {
        $this->inputReader = $inputReader;
        $this->day12services = $day12services;
    }

    /**
     * @Route("/1/{file}", defaults={"file"="day12"})
     * @param string $file
     * @return JsonResponse
     */
    public function part1(string $file): JsonResponse
    {
        $lines = $this->inputReader->getInput($file.'.txt');

        $caveList = $this->day12services->getAllCaveName($lines);
        $this->day12services->removeUnfollowablePaths($caveList);

        $pathsFound = [];
        $currentPathNumber = $this->day12services->exploreCaves($caveList, $pathsFound, 'start', 0);

        return new JsonResponse($currentPathNumber, Response::HTTP_OK);
    }

    /**
     * @Route("/2/{file}", defaults={"file"="day12"})
     * @param string $file
     * @return JsonResponse
     */
    public function part2(string $file): JsonResponse
    {
        $lines = $this->inputReader->getInput($file.'.txt');

        $caveList = $this->day12services->getAllCaveName($lines);

        $pathsFound = [];
        $currentPathNumber = $this->day12services->exploreCavesWithAllowedOneDoubleCave($caveList, $pathsFound, 'start', 0);

        return new JsonResponse($currentPathNumber, Response::HTTP_OK);
    }
}