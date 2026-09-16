<?php

declare(strict_types=1);

namespace App\Core;

use App\Models\User;

/**
 * Autenticacao por sessao.
 */
final class Auth
{
    private const KEY = '_user_id';

    /** Tenta autenticar; devolve true em caso de sucesso. */
    public static function attempt(string $email, string $password): bool
    {
        $user = User::findByEmail($email);

        if ($user === null || !password_verify($password, $user['password'])) {
            return false;
        }

        // Re-hash transparente caso o custo padrao do PHP tenha mudado.
        if (password_needs_rehash($user['password'], PASSWORD_DEFAULT)) {
            User::updatePassword((int) $user['id'], $password);
        }

        Session::start();
        Session::regenerate();
        Session::set(self::KEY, (int) $user['id']);

        return true;
    }

    public static function logout(): void
    {
        Session::start();
        Session::destroy();
    }

    public static function check(): bool
    {
        Session::start();

        return Session::get(self::KEY) !== null;
    }

    /** Usuario logado, ou null. */
    public static function user(): ?array
    {
        if (!self::check()) {
            return null;
        }

        static $cached = null;

        if ($cached === null) {
            $cached = User::find((int) Session::get(self::KEY));
        }

        return $cached;
    }

    public static function id(): ?int
    {
        $user = self::user();

        return $user === null ? null : (int) $user['id'];
    }

    /** Redireciona para o login se nao estiver autenticado. */
    public static function requireLogin(): void
    {
        if (self::check() && self::user() !== null) {
            return;
        }

        Session::start();
        Session::set('_intended', $_SERVER['REQUEST_URI'] ?? '/admin');

        header('Location: /login');
        exit;
    }
}
