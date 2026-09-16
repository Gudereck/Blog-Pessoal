<?php

declare(strict_types=1);

namespace App\Core;

/**
 * Protecao CSRF por token de sessao.
 */
final class Csrf
{
    private const KEY = '_csrf_token';

    public static function token(): string
    {
        Session::start();

        $token = Session::get(self::KEY);

        if (!is_string($token) || $token === '') {
            $token = bin2hex(random_bytes(32));
            Session::set(self::KEY, $token);
        }

        return $token;
    }

    /** Campo hidden pronto para colar no formulario. */
    public static function field(): string
    {
        return '<input type="hidden" name="_token" value="' . htmlspecialchars(self::token(), ENT_QUOTES, 'UTF-8') . '">';
    }

    public static function check(?string $token): bool
    {
        Session::start();

        $expected = Session::get(self::KEY);

        return is_string($expected) && is_string($token) && hash_equals($expected, $token);
    }

    /** Aborta a requisicao com 419 se o token for invalido. */
    public static function verify(): void
    {
        if (!self::check($_POST['_token'] ?? null)) {
            http_response_code(419);
            exit('Token CSRF invalido ou expirado. Recarregue a pagina e tente novamente.');
        }
    }
}
