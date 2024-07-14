<?php

namespace App\Util;

class Slugger
{
    public static function slugify(string $text): string
    {
        $text = preg_replace('/[^a-z0-9]+/i', '-', trim(strtolower($text)));

        return trim($text, '-');
    }
}
