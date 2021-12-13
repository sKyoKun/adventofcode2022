<?php

namespace App\Services;

class Day12Services
{
    public function getAllCaveName(array $lines)
    {
        $caveList = [];
        foreach ($lines as $line) {
            $caves = explode('-', $line);
            $caveList[$caves[0]][] = $caves[1];
            $caveList[$caves[1]][] = $caves[0];
        }

        return $caveList;
    }

    /**
     * Removes lower cased characters that have no followable path from cave list
     *
     * @param array $cavesList
     */
    public function removeUnfollowablePaths(array &$cavesList): void
    {
        foreach ($cavesList as $cave => $possiblePaths) {
            if (ctype_lower($cave) && false === $this->caveHasFollowablePath($possiblePaths)) {
                unset($cavesList[$cave]);
            }
        }
    }

    public function exploreCaves(array $caves, array &$paths, string $currentCave, int $currentPathNumber): int
    {
        // if we previously removed this cave as a non accessible one, dont process
        if (false === array_key_exists($currentCave, $caves)) {
            return $currentPathNumber;
        }

        // we stay on the same path until we reach an end,
        // if we previously found an end and there is no current path, create a new one
        $currentPath = $paths[$currentPathNumber] ?? [];
        $currentPath[] = $currentCave;

        // if we find the end, we increase our path count
        if ("end" === $currentCave) {
            return $currentPathNumber+1;
        }

        // explore the next caves
        foreach ($caves[$currentCave] as $cave) {
            // if it's a lower cased char and we already passed it => dead end.
            if (ctype_lower($cave) && in_array($cave, $currentPath)) {
                continue;
            }

            // save our current path, and explore further
            $paths[$currentPathNumber] = $currentPath;
            $currentPathNumber = $this->exploreCaves($caves, $paths, $cave, $currentPathNumber);
        }

        return $currentPathNumber;
    }

    public function exploreCavesWithAllowedOneDoubleCave(array $caves, array &$paths, string $currentCave, int $currentPathNumber): int
    {
        if (false === array_key_exists($currentCave, $caves)) {
            return $currentPathNumber;
        }

        $currentPath = $paths[$currentPathNumber] ?? [];
        $currentPath[] = $currentCave;

        if ("end" === $currentCave) {
            return $currentPathNumber+1;
        }

        foreach ($caves[$currentCave] as $cave) {
            // calculate the number of times a lower cave appears in the path
            $lowerCavesCount = array_count_values(array_filter($currentPath, 'ctype_lower'));

            // we cant pass the start again, and if we're in a cave we already passed, we cant pass again if a cave is already there 2 times
            if ("start" === $cave || (ctype_lower($cave) && in_array($cave, $currentPath) && max($lowerCavesCount) == 2)) {
                continue;
            }

            $paths[$currentPathNumber] = $currentPath;
            $currentPathNumber = $this->exploreCavesWithAllowedOneDoubleCave($caves, $paths, $cave, $currentPathNumber);
        }

        return $currentPathNumber;
    }

    /**
     * Returns if a current lower cased cave has any followable path (i.e : an end or an upper cased cave)
     *
     * @param array $paths
     *
     * @return bool
     */
    public function caveHasFollowablePath(array $paths): bool
    {
        foreach ($paths as $path) {
            if ("end" === $path) {
                return true;
            } elseif (ctype_upper($path)) {
                return true;
            }
        }

        return false;
    }
}