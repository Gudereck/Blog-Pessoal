<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;

final class User
{
    public static function find(int $id): ?array
    {
        return Database::instance()->first('SELECT * FROM users WHERE id = ?', [$id]);
    }

    public static function findByEmail(string $email): ?array
    {
        return Database::instance()->first('SELECT * FROM users WHERE email = ?', [$email]);
    }

    public static function create(string $name, string $email, string $password): int
    {
        $db = Database::instance();
        $db->run(
            'INSERT INTO users (name, email, password) VALUES (?, ?, ?)',
            [$name, $email, password_hash($password, PASSWORD_DEFAULT)]
        );

        return $db->lastInsertId();
    }

    public static function updatePassword(int $id, string $password): void
    {
        Database::instance()->run(
            'UPDATE users SET password = ? WHERE id = ?',
            [password_hash($password, PASSWORD_DEFAULT), $id]
        );
    }

    public static function count(): int
    {
        return (int) Database::instance()->scalar('SELECT COUNT(*) FROM users');
    }
}
