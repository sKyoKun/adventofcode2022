<?php

namespace App\Services;

class Day7Services
{
    public function calculateDirectorySize(array &$arborescence, string $directoryName) : int
    {
        $currentDirectorySize = 0;
        foreach ($arborescence[$directoryName] as $key => $name) {
            if (is_string($key)) {
                $currentDirectorySize += $this->calculateDirectorySize($arborescence, $name);
            } else {
                $currentDirectorySize += $key;
            }
        }

        return $currentDirectorySize;
    }

    public function computeArborescence(array $lines, array &$arborescence) : array
    {
        $currentDirectory = ''; // will contain the path with all directory aggregated
        $directories = []; // will contain the directories we passed

        foreach ($lines as $line) {
            $matches = null;
            if (preg_match('#cd (.+)#', $line, $matches)) {
                $nextDirectory = $matches[1];
                if ('..' === $nextDirectory) {
                    $lastDirectory = array_pop($directories);
                    $currentDirectory = substr($currentDirectory,0,-strlen($lastDirectory)); // we remove the name of the last directory
                    continue;
                }

                $currentDirectory .= $nextDirectory;
                $directories[] = $nextDirectory;
                continue;
            }
            if (str_starts_with($line, '$ ls')) {
                continue;
            }
            $ls = explode(' ', $line);

            if (str_contains($ls[0], 'dir')) {
                $arborescence[$currentDirectory.$ls[1]] = []; // create a new path at the root of our arborescence
                $arborescence[$currentDirectory][$ls[1]] = $currentDirectory.$ls[1]; // reference the path in our current directory
            } else {
                $arborescence[$currentDirectory][$ls[0]] = $ls[1]; // add the file in our directory
            }
        }

        return $arborescence;
    }
}
