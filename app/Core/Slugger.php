<?php

declare(strict_types=1);

namespace App\Core;

/**
 * Geracao de slugs a partir de texto livre.
 */
final class Slugger
{
    /**
     * Mapa de transliteracao. iconv//TRANSLIT depende da libc do sistema e no
     * Windows produz resultados ruins ("acao" vira "ac~ao"), entao a conversao
     * de acentos e feita explicitamente.
     */
    private const ACENTOS = [
        'á' => 'a', 'à' => 'a', 'ã' => 'a', 'â' => 'a', 'ä' => 'a', 'å' => 'a',
        'é' => 'e', 'è' => 'e', 'ẽ' => 'e', 'ê' => 'e', 'ë' => 'e',
        'í' => 'i', 'ì' => 'i', 'ĩ' => 'i', 'î' => 'i', 'ï' => 'i',
        'ó' => 'o', 'ò' => 'o', 'õ' => 'o', 'ô' => 'o', 'ö' => 'o',
        'ú' => 'u', 'ù' => 'u', 'ũ' => 'u', 'û' => 'u', 'ü' => 'u',
        'ç' => 'c', 'ñ' => 'n', 'ý' => 'y', 'ÿ' => 'y',
        'æ' => 'ae', 'œ' => 'oe', 'ß' => 'ss',
    ];

    public static function slugify(string $text, string $fallbackPrefix = 'item'): string
    {
        $text = mb_strtolower($text, 'UTF-8');
        $text = strtr($text, self::ACENTOS);
        $text = (string) preg_replace('/[^a-z0-9]+/', '-', $text);
        $text = trim($text, '-');

        return $text !== '' ? $text : $fallbackPrefix . '-' . date('YmdHis');
    }
}
