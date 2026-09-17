<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use App\Core\Slugger;

final class Post
{
    /** Posts publicados, mais recentes primeiro (com paginacao). */
    public static function published(int $limit = 10, int $offset = 0): array
    {
        // LIMIT/OFFSET nao aceitam placeholders em prepares nativos do MySQL;
        // os valores sao convertidos para int, entao a interpolacao e segura.
        $sql = sprintf(
            'SELECT p.*, u.name AS author, c.name AS category_name, c.slug AS category_slug, c.color AS category_color
               FROM posts p
               JOIN users u ON u.id = p.user_id
               LEFT JOIN categories c ON c.id = p.category_id
              WHERE p.published = 1
              ORDER BY p.published_at DESC, p.id DESC
              LIMIT %d OFFSET %d',
            max(1, $limit),
            max(0, $offset)
        );

        return Database::instance()->all($sql);
    }

    public static function countPublished(): int
    {
        return (int) Database::instance()->scalar('SELECT COUNT(*) FROM posts WHERE published = 1');
    }

    /** Todos os posts, para o painel admin. */
    public static function all(): array
    {
        return Database::instance()->all(
            'SELECT p.*, u.name AS author, c.name AS category_name, c.color AS category_color
               FROM posts p
               JOIN users u ON u.id = p.user_id
               LEFT JOIN categories c ON c.id = p.category_id
              ORDER BY p.created_at DESC, p.id DESC'
        );
    }

    public static function find(int $id): ?array
    {
        return Database::instance()->first('SELECT * FROM posts WHERE id = ?', [$id]);
    }

    /** Busca um post publicado pelo slug (usado na pagina publica). */
    public static function findPublishedBySlug(string $slug): ?array
    {
        return Database::instance()->first(
            'SELECT p.*, u.name AS author, c.name AS category_name, c.slug AS category_slug, c.color AS category_color
               FROM posts p
               JOIN users u ON u.id = p.user_id
               LEFT JOIN categories c ON c.id = p.category_id
              WHERE p.slug = ? AND p.published = 1',
            [$slug]
        );
    }

    public static function create(array $data): int
    {
        $db = Database::instance();
        $db->run(
            'INSERT INTO posts (user_id, category_id, title, slug, excerpt, cover_image, body, published, published_at)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)',
            [
                $data['user_id'],
                $data['category_id'],
                $data['title'],
                $data['slug'],
                $data['excerpt'],
                $data['cover_image'],
                $data['body'],
                $data['published'] ? 1 : 0,
                $data['published'] ? date('Y-m-d H:i:s') : null,
            ]
        );

        return $db->lastInsertId();
    }

    public static function update(int $id, array $data): void
    {
        $current = self::find($id);

        // Define published_at na primeira vez que o post e publicado.
        $publishedAt = $current['published_at'] ?? null;
        if ($data['published'] && $publishedAt === null) {
            $publishedAt = date('Y-m-d H:i:s');
        }

        Database::instance()->run(
            'UPDATE posts
                SET category_id = ?, title = ?, slug = ?, excerpt = ?, cover_image = ?, body = ?, published = ?, published_at = ?
              WHERE id = ?',
            [
                $data['category_id'],
                $data['title'],
                $data['slug'],
                $data['excerpt'],
                $data['cover_image'],
                $data['body'],
                $data['published'] ? 1 : 0,
                $publishedAt,
                $id,
            ]
        );
    }

    public static function delete(int $id): void
    {
        Database::instance()->run('DELETE FROM posts WHERE id = ?', [$id]);
    }

    /** Gera um slug unico a partir do titulo, ignorando o proprio post na edicao. */
    public static function uniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Slugger::slugify($title, 'post');
        $slug = $base;
        $i = 2;

        while (self::slugTaken($slug, $ignoreId)) {
            $slug = $base . '-' . $i;
            $i++;
        }

        return $slug;
    }

    private static function slugTaken(string $slug, ?int $ignoreId): bool
    {
        if ($ignoreId === null) {
            $sql = 'SELECT COUNT(*) FROM posts WHERE slug = ?';
            $params = [$slug];
        } else {
            $sql = 'SELECT COUNT(*) FROM posts WHERE slug = ? AND id <> ?';
            $params = [$slug, $ignoreId];
        }

        return (int) Database::instance()->scalar($sql, $params) > 0;
    }
}
