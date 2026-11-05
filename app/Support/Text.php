<?php

namespace App\Support;

use Illuminate\Support\HtmlString;

class Text
{
    /**
     * Kata yang diapit *bintang* diberi warna gradasi.
     * Contoh: "Solusi SIMRS yang *Terintegrasi*"
     */
    public static function highlight(?string $text, string $class = 'grad-text'): HtmlString
    {
        $safe = e((string) $text);

        return new HtmlString(preg_replace('/\*(.+?)\*/', '<span class="'.$class.'">$1</span>', $safe));
    }

    /** Teks tanpa tanda bintang, untuk meta tag dan atribut. */
    public static function plain(?string $text): string
    {
        return str_replace('*', '', (string) $text);
    }
}
