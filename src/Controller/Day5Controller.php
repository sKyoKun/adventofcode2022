<?php

namespace App\Controller;

use App\Services\InputReader;
use App\Services\Day5Services;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/day5', name: 'day5')]
class Day5Controller extends AbstractController
{
    public function __construct(
        private InputReader $inputReader,
        private Day5Services $day5services
    ){
        $this->inputReader = $inputReader;
        $this->day5services = $day5services;
    }

    #[Route('/1/{file}', name: 'day5_1', defaults: ["file"=>"day5"])]
    public function part1(string $file): JsonResponse
    {
        $lines = $this->inputReader->getInputRTrimmed($file.'.txt');

        $nbOfStacks = $this->day5services->getStacksNumber($lines);
        $stacksLines = $this->day5services->getStacksLines($lines);
        $directions = $this->day5services->getDirections($lines);

        $stacks = $this->day5services->getStacks($stacksLines, $nbOfStacks);
        $finalStacks = $this->day5services->moveCrane($directions, $stacks);

        $finalString = $this->day5services->getFirstCharsOfStacks($finalStacks);

        return new JsonResponse($finalString, Response::HTTP_OK);
    }

    #[Route('/2/{file}', name: 'day5_2', defaults: ["file"=>"day5"])]
    public function part2(string $file): JsonResponse
    {
        $lines = $this->inputReader->getInputRTrimmed($file.'.txt');

        $nbOfStacks = $this->day5services->getStacksNumber($lines);
        $stacksLines = $this->day5services->getStacksLines($lines);
        $directions = $this->day5services->getDirections($lines);

        $stacks = $this->day5services->getStacks($stacksLines, $nbOfStacks);
        $finalStacks = $this->day5services->moveCrane9001($directions, $stacks);

        $finalString = $this->day5services->getFirstCharsOfStacks($finalStacks);

        return new JsonResponse($finalString, Response::HTTP_OK);
    }
}
