<?php

namespace App\Services;

class Day6Services
{
    public function isStringStartOfPacket(string $string): bool
    {
        $maxCharCount = max(count_chars($string, 0));
        if(1 < $maxCharCount) {
            return false;
        }

        return true;
    }
}
