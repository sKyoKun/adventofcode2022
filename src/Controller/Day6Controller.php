<?php

namespace App\Controller;

use App\Services\InputReader;
use App\Services\Day6Services;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/day6', name: 'day6')]
class Day6Controller extends AbstractController
{
    private InputReader $inputReader;

    private Day6Services $day6services;

    /**
     * @param InputReader $inputReader
     * @param Day6Services $day6services
     */
    public function __construct(InputReader $inputReader, Day6Services $day6services)
    {
        $this->inputReader = $inputReader;
        $this->day6services = $day6services;
    }

    #[Route('/1/{file}', name: 'day6_1', defaults: ["file"=>"day6"])]
    public function part1(string $file): JsonResponse
    {
        $lines = $this->inputReader->getInput($file.'.txt');

        $start = 0;
        $endOfCursor = 3;
        $nbchars = strlen($lines[0]);

        while($endOfCursor < $nbchars) {
            $current4 = substr($lines[0], $start, 4);
            if ($this->day6services->isStringStartOfPacket($current4)) {
                return new JsonResponse($endOfCursor+1, Response::HTTP_OK);
            }
            $start++;
            $endOfCursor++;
        }

        return new JsonResponse('', Response::HTTP_NOT_ACCEPTABLE);
    }

    #[Route('/2/{file}', name: 'day6_2', defaults: ["file"=>"day6"])]
    public function part2(string $file): JsonResponse
    {
        $lines = $this->inputReader->getInput($file.'.txt');

        $start = 0;
        $endOfCursor = 13;
        $nbchars = strlen($lines[0]);

        while($endOfCursor < $nbchars) {
            $current14 = substr($lines[0], $start, 14);
            if ($this->day6services->isStringStartOfPacket($current14)) {
                return new JsonResponse($endOfCursor+1, Response::HTTP_OK);
            }
            $start++;
            $endOfCursor++;
        }

        return new JsonResponse('', Response::HTTP_NOT_ACCEPTABLE);
    }
}
