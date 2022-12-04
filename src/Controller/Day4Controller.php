<?php

namespace App\Controller;

use App\Services\CalendarServices;
use App\Services\InputReader;
use App\Services\Day4Services;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/day4', name: 'day4')]
class Day4Controller extends AbstractController
{
    public function __construct(
        private InputReader $inputReader,
        private Day4Services $day4services,
        private CalendarServices $calendarServices
    ){
        $this->inputReader = $inputReader;
        $this->day4services = $day4services;
    }

    #[Route('/1/{file}', name: 'day4_1', defaults: ["file"=>"day4"])]
    public function part1(string $file): JsonResponse
    {
        $lines = $this->inputReader->getInput($file.'.txt');

        $pairs = $this->day4services->parseInputWithRangeAndComma($lines);

        $overlaps = 0;
        foreach ($pairs as $pair) {
            if ($this->day4services->isPairFullyOverlapping($pair))
            {
                $overlaps++;
            }
        }

        return new JsonResponse($overlaps, Response::HTTP_OK);
    }

    #[Route('/2/{file}', name: 'day4_2', defaults: ["file"=>"day4"])]
    public function part2(string $file): JsonResponse
    {
        $lines = $this->inputReader->getInput($file.'.txt');

        $pairs = $this->day4services->parseInputWithRangeAndComma($lines);

        $overlaps = 0;
        foreach ($pairs as $pair) {
            if ($this->day4services->isPairOverlapping($pair))
            {
                $overlaps++;
            }
        }

        return new JsonResponse($overlaps, Response::HTTP_OK);
    }
}
