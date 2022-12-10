<?php

namespace App\Controller;

use App\Services\CalendarServices;
use App\Services\InputReader;
use App\Services\Day10Services;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/day10', name: 'day10')]
class Day10Controller extends AbstractController
{
    public function __construct(
        private InputReader $inputReader,
        private Day10Services $day10services,
        private CalendarServices $calendarServices
    ){
    }

    #[Route('/1/{file}', name: 'day10_1', defaults: ["file"=>"day10"])]
    public function part1(string $file): JsonResponse
    {
        $lines = $this->inputReader->getInput($file.'.txt');

        $instructions = $this->calendarServices->parseInputFromStringsWithSpaceToArray($lines);

        $cycleNumber = 1;
        $valueX = 1;
        $nextXValue = $valueX;
        $sumOfSignals = 0;
        $readInstruction = true;
        $currentInstruction = 0;

        while($currentInstruction < count($instructions)) {
            if (\in_array($cycleNumber,[20,60, 100,140,180,220])) {
                $sumOfSignals += $cycleNumber * $valueX;
            }

            if ($readInstruction) {
                $nextXValue = $this->day10services->readInstruction(
                    $instructions[$currentInstruction],
                    $readInstruction,
                    $valueX,
                    $currentInstruction
                );
            } else { // if I didnt read anything this cycle, then I should increase X and read next instruction
                $valueX = $nextXValue;
                $readInstruction = true;
                ++$currentInstruction;
            }

            ++$cycleNumber;
        }

        return new JsonResponse($sumOfSignals, Response::HTTP_OK);
    }

    #[Route('/2/{file}', name: 'day10_2', defaults: ["file"=>"day10"])]
    public function part2(string $file): JsonResponse
    {
        $lines = $this->inputReader->getInput($file.'.txt');

        $instructions = $this->calendarServices->parseInputFromStringsWithSpaceToArray($lines);

        $crt = [];

        $cycleNumber = 0;
        $valueX = 1;
        $nextXValue = $valueX;
        $drawIf = [0,1,2];
        $readInstruction = true;
        $currentInstruction = 0;
        $currentCrtLine = 0;


        while($currentInstruction < count($instructions)) {
            // We change line every 40 pixels
            if (0 === $cycleNumber % 40 && 0 !== $cycleNumber ) {
                ++$currentCrtLine;
                $cycleNumber = 0;
            }

            // We draw if the current pixel is in the drawIf array
            if (\in_array($cycleNumber, $drawIf)) {
                $crt[$currentCrtLine][$cycleNumber] = '#';
            } else {
                $crt[$currentCrtLine][$cycleNumber] = '.';
            }

            if ($readInstruction) {
                $nextXValue = $this->day10services->readInstruction(
                    $instructions[$currentInstruction],
                    $readInstruction,
                    $valueX,
                    $currentInstruction
                );
            } else { // if I didnt read anything this cycle, change the pixel to draw, then I should increase X and read next instruction
                $valueX = $nextXValue;
                $drawIf = [$valueX-1, $valueX, $valueX+1];
                $readInstruction = true;
                ++$currentInstruction;
            }

            ++$cycleNumber;
        }

        // DRAW CRT
        foreach ($crt as $x => $line) {
            foreach ($line as $y => $value) {
                if ('.' === $value) {
                    echo "~";
                } else {
                    echo "#";
                }
            }
            echo "<br/>";
        }

        die();


        return new JsonResponse('', Response::HTTP_NOT_ACCEPTABLE);
    }
}
