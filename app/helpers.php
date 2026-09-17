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

/** Icone generico usado no lugar de uma imagem de capa ainda nao enviada. */
function cover_icon(): string
{
    // Puramente decorativo (o post ja tem titulo/texto ao lado), entao fica
    // escondido da arvore de acessibilidade.
    return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">'
        . '<rect x="3" y="3" width="18" height="18" rx="3"/><circle cx="8.5" cy="8.5" r="1.5"/>'
        . '<path d="M21 15l-5-5-4 4-3-3-6 6"/></svg>';
}

/** Classe CSS de tag/placeholder para a cor de categoria (com fallback). */
function category_tag_class(?string $color): string
{
    return 'tag-' . ($color ?: 'rust');
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
