<?php

declare(strict_types=1);

use App\Core\Csrf;

/** Escapa texto para saida em HTML. */
function e(?string $value): string
{
    return htmlspecialchars($value ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/** Campo hidden com o token CSRF. */
function csrf_field(): string
{
    return Csrf::field();
}

/** Formata uma data do banco no padrao brasileiro. */
function data_br(?string $datetime, bool $comHora = false): string
{
    if ($datetime === null || $datetime === '') {
        return '-';
    }

    $ts = strtotime($datetime);

    if ($ts === false) {
        return '-';
    }

    return date($comHora ? 'd/m/Y H:i' : 'd/m/Y', $ts);
}

/**
 * Converte texto simples em HTML: paragrafos por linha em branco,
 * quebras simples viram <br>. Tudo escapado antes.
 */
function texto_para_html(string $texto): string
{
    $blocos = preg_split('/\R{2,}/', trim($texto)) ?: [];

    $html = array_map(
        static fn (string $bloco): string => '<p>' . nl2br(e(trim($bloco))) . '</p>',
        $blocos
    );

    return implode("\n", $html);
}

/** Resumo do post: usa o excerpt ou corta o corpo. */
function resumo(array $post, int $limite = 180): string
{
    if (!empty($post['excerpt'])) {
        return $post['excerpt'];
    }

    $texto = trim(preg_replace('/\s+/', ' ', $post['body']) ?? '');

    return mb_strlen($texto) <= $limite
        ? $texto
        : mb_substr($texto, 0, $limite) . '...';
}
