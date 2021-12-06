<?php

namespace App\Controller;

use App\Services\Day6Services;
use App\Services\InputReader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
* + @Route("/day6")
 */
class Day6Controller extends AbstractController
{
    const HP_FISH_DEFAULT = 6;
    const HP_FISH_NEW = 8;

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

    /**
     * @Route("/1/{file}", defaults={"file"="day6"})
     * @param string $file
     * @return JsonResponse
     */
    public function part1(string $file): JsonResponse
    {
        $lines =  $this->inputReader->getInput($file.'.txt');

        $fishes = explode(',', $lines[0]);

        $nbDays = 80;
        $currentDay = 0;

        // THIS IS THE QUICK AND DIRTY METHOD : SEE PART 2 FOR MORE OPTIMIZED ONE AS THIS ONE WILL THROW AN ERROR ON BIG DAYS
        while ($currentDay < $nbDays) {
            $nbNewFishes = 0;
            foreach ($fishes as $key => $fish) {
                $fish = (int)$fish;
                $fish--;
                $fishes[$key] = $fish;
                if (0 > $fish) {
                    $fishes[$key] = self::HP_FISH_DEFAULT;
                    $nbNewFishes++;
                }
            }

            for($i = 0; $i < $nbNewFishes; $i++) {
                array_push($fishes, self::HP_FISH_NEW);
            }

            $currentDay++;
        }

        return new JsonResponse(count($fishes), Response::HTTP_OK);
    }

    /**
     * @Route("/2/{file}", defaults={"file"="day6"})
     * @param string $file
     * @return JsonResponse
     */
    public function part2(string $file): JsonResponse
    {
        $lines =  $this->inputReader->getInput($file.'.txt');

        $fishes = $this->day6services->getFishesPerHP($lines);

        $nbDays = 256;
        $currentDay = 0;

        while ($currentDay < $nbDays) {
            $previousDayFishes = $fishes;
            foreach ($fishes as $hp => $nbFish) {
                // i'm a baby and useless !
                if (self::HP_FISH_NEW === $hp) {
                    continue;
                }
                switch($hp) {
                    // There are two types of "6hp fishes" : baby fishes than comes from 7 days, and old fishes that comes from 0
                    case self::HP_FISH_DEFAULT:
                        $fishes[$hp] = $previousDayFishes[$hp+1] + $previousDayFishes[0];
                        break;
                    // When we reach 0 : A baby fish pops, and our new 0 population is the old 1
                    case 0:
                        $fishes[8] = $nbFish;
                        $fishes[$hp] = $previousDayFishes[$hp+1];
                        break;
                    // Our current population for this hp today, is the one for hp+1 yesterday
                    default:
                        $fishes[$hp] = $previousDayFishes[$hp+1];
                        break;
                }
            }
            $currentDay++;
        }

        $countFishes = array_sum($fishes);

        return new JsonResponse($countFishes, Response::HTTP_OK);
    }
}