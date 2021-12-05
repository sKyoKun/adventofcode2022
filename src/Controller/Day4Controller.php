<?php

namespace App\Controller;

use App\Services\Day4Services;
use App\Services\InputReader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
* + @Route("/day4")
 */
class Day4Controller extends AbstractController
{
    private InputReader $inputReader;

    private Day4Services $day4services;

    /**
     * @param InputReader $inputReader
     * @param Day4Services $day4services
     */
    public function __construct(InputReader $inputReader, Day4Services $day4services)
    {
        $this->inputReader = $inputReader;
        $this->day4services = $day4services;
    }

    /**
     * @Route("/1/{file}", defaults={"file"="day4"})
     * @param string $file
     * @return JsonResponse
     */
    public function day4(string $file): JsonResponse
    {
        $lines =  $this->inputReader->getInput($file.'.txt');

        $bingoNumbers = $this->day4services->getBingoNumbers($lines);
        $grids = $this->day4services->getBingoGrids($lines);
        $nbPlayers = count($grids);
        $playersGridNumbers = $this->day4services->getPlayerNumbers($grids);
        $playersLines = $this->day4services->initializePlayersLines($nbPlayers);
        $playersColumns = $this->day4services->initializePlayersLines($nbPlayers);

        while(count($bingoNumbers) > 0) {
            $number = (int) array_shift($bingoNumbers);
            for($i = 0; $i < $nbPlayers; $i++) {
                if (array_key_exists($number, $playersGridNumbers[$i])) {
                    $playersGridNumbers[$i][$number] = true;
                    $this->day4services->updateLineAndColumnCount(
                        $grids[$i],
                        $number,
                        $playersLines[$i],
                        $playersColumns[$i]
                    );
                    $canScream = $this->day4services->determineIfCanScreamBingo(
                        $playersLines[$i],
                        $playersColumns[$i]
                    );

                    if ($canScream) {
                        $totalUnusedNumbers = $this->day4services->getSumOfUncalledNumbers($playersGridNumbers[$i]);

                        return new JsonResponse($totalUnusedNumbers * $number, Response::HTTP_OK);
                    }
                }
            }

        }

        return new JsonResponse('', Response::HTTP_FORBIDDEN);
    }

    /**
     * @Route("/2/{file}", defaults={"file"="day4"})
     * @param string $file
     * @return JsonResponse
     */
    public function day4bis(string $file): JsonResponse
    {
        $lines =  $this->inputReader->getInput($file.'.txt');

        $bingoNumbers = $this->day4services->getBingoNumbers($lines);
        $grids = $this->day4services->getBingoGrids($lines);
        $nbPlayers = count($grids);
        $playersGridNumbers = $this->day4services->getPlayerNumbers($grids);
        $playersLines = $this->day4services->initializePlayersLines($nbPlayers);
        $playersColumns = $this->day4services->initializePlayersLines($nbPlayers);

        $playersWithBingo = [];
        $number = 0;

        while(count($playersWithBingo) < $nbPlayers) {
            $number = (int) array_shift($bingoNumbers);
            for($i = 0; $i < $nbPlayers; $i++) {
                if (array_key_exists($number, $playersGridNumbers[$i])) {
                    $playersGridNumbers[$i][$number] = true;
                    $this->day4services->updateLineAndColumnCount(
                        $grids[$i],
                        $number,
                        $playersLines[$i],
                        $playersColumns[$i]
                    );
                    $canScream = $this->day4services->determineIfCanScreamBingo(
                        $playersLines[$i],
                        $playersColumns[$i]
                    );

                    if ($canScream && false === in_array($i, $playersWithBingo)) {
                        $playersWithBingo[] = $i;
                    }
                }
            }

        }

        $lastPlayerThatSaidBingo = array_pop($playersWithBingo);

        $totalUnusedNumbers = $this->day4services->getSumOfUncalledNumbers($playersGridNumbers[$lastPlayerThatSaidBingo]);

        return new JsonResponse($totalUnusedNumbers * $number, Response::HTTP_OK);
    }
}