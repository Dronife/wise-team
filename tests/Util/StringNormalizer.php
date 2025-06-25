<?php

declare(strict_types=1);

namespace App\Tests\Util;

class StringNormalizer
{
    public static function normalize(string $string): string
    {
        $string = preg_replace('/\s+/', ' ', $string);
        $string = preg_replace('/\n/', ' ', $string);

        return trim($string);
    }
}