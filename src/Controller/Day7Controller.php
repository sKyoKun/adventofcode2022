<?php

namespace App\Controller;

use App\Services\InputReader;
use App\Services\Day7Services;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/day7', name: 'day7')]
class Day7Controller extends AbstractController
{
    public function __construct(
        private InputReader $inputReader,
        private Day7Services $day7services
    ){
        $this->inputReader = $inputReader;
        $this->day7services = $day7services;
    }

    #[Route('/1/{file}', name: 'day7_1', defaults: ["file"=>"day7"])]
    public function part1(string $file): JsonResponse
    {
        $lines = $this->inputReader->getInput($file.'.txt');

        $arborescence = $this->day7services->computeArborescence($lines);

        $directoriesSize = [];
        foreach ($arborescence as $key => $content) {
            $directoriesSize[$key] = $this->day7services->calculateDirectorySize($arborescence, $key);
        }

        $totalSize = 0;
        $maxSize = 100000;

        foreach($directoriesSize as $size) {
            if ($size <= $maxSize) {
                $totalSize += $size;
            }
        }

        return new JsonResponse($totalSize, Response::HTTP_OK);
    }

    #[Route('/2/{file}', name: 'day7_2', defaults: ["file"=>"day7"])]
    public function part2(string $file): JsonResponse
    {
        $lines = $this->inputReader->getInput($file.'.txt');

        return new JsonResponse('', Response::HTTP_NOT_ACCEPTABLE);
    }
}
