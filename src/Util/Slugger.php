<?php

namespace App\Util;

class Slugger
{
    public static function slugify(string $text): string
    {
        // Remplacer les espaces et autres caractères non désirés par des tirets
        $text = preg_replace('/[^a-z0-9]+/i', '-', trim(strtolower($text)));

        // Supprimer les tirets en début et fin de chaîne
        return trim($text, '-');
    }
}
