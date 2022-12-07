<?php

namespace App\Services;

class Day7Services
{
    public function calculateDirectorySize(array &$arborescence, string $directoryName) : int
    {
        $currentDirectorySize = 0;
        foreach ($arborescence[$directoryName] as $key => $name) {
            if (str_contains($key, 'dir')) {
                $currentDirectorySize += $this->calculateDirectorySize($arborescence, $name);
            } else {
                $currentDirectorySize += $key;
            }
        }

        return $currentDirectorySize;
    }

    public function computeArborescence(array $lines, array $arborescence = ['/' => []]) : array
    {
        $currentDirectory = '/';

        foreach ($lines as $line) {
            $matches = null;
            if (preg_match('#cd (.+)#', $line, $matches)) {
                $nextDirectory = $matches[1];
                if ('..' === $nextDirectory) {
                    $currentDirectory = $this->searchForDirectoryThatContains($arborescence, $currentDirectory);
                    continue;
                }

                $currentDirectory = $nextDirectory;
                continue;
            }
            if (str_starts_with($line, '$ ls')) {
                continue;
            }
            $ls = explode(' ', $line);

            if (str_contains($ls[0], 'dir')) {
                $arborescence[$ls[1]] = [];
                $arborescence[$currentDirectory][$ls[0].$ls[1]] = $ls[1];
            } else {
                $arborescence[$currentDirectory][$ls[0]] = $ls[1];
            }
        }

        return $arborescence;
    }

    public function searchForDirectoryThatContains(array $arborescence, string $dirName): string
    {
        foreach ($arborescence as $directory => $content) {
            foreach ($content as $type => $name) {
                if (str_contains('dir', $type) && $name === $dirName) {
                    return $directory;
                }
            }
        }
        return '/';
    }
}
