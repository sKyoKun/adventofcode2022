<?php

namespace App\Controller;

use App\Services\InputReader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
* + @Route("/day1")
 */
class Day1Controller extends AbstractController
{
    private $inputReader;

    /**
     * @param InputReader $inputReader
     */
    public function __construct(InputReader $inputReader)
    {
        $this->inputReader = $inputReader;
    }

    /**
     * @Route("/1/{file}", defaults={"file"="day1"})
     * @param string $file
     * @return JsonResponse
     */
    public function day1(string $file): JsonResponse
    {
        $numbers = $this->inputReader->getInput($file.'.txt');

        $increased = 0;

        foreach ($numbers as $key => $number) {
            if ($key !== 0 && ($number > $numbers[$key-1])) {
                $increased++;
            }
        }
        
        return new JsonResponse($increased, Response::HTTP_OK);
    }

    /**
     * @Route("/2/{file}", defaults={"file"="day1"})
     * @param string $file
     * @return JsonResponse
     */
    public function day1bis(string $file): JsonResponse
    {
        $numbers =  $this->inputReader->getInput($file.'.txt');
        $increased = 0;

        for ($i = 2 ; $i < count($numbers); $i++) {

            // if we can't do another three-measurement sum, then we return our current increased value
            if (false === isset($numbers[$i+1])) {
                return new JsonResponse($increased, Response::HTTP_OK);
            }

            $firstSum = $numbers[$i-2] + $numbers[$i-1] + $numbers[$i];
            $secondSum = $numbers[$i-1] + $numbers[$i+1] + $numbers[$i];

            if ($secondSum > $firstSum) {
                $increased++;
            }
        }

        return new JsonResponse(null, Response::HTTP_NOT_ACCEPTABLE);
    }
}