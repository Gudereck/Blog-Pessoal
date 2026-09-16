<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use App\Core\Slugger;

final class Category
{
    /** Cores predefinidas (mantem a paleta consistente com o DESIGN.md). */
    public const CORES = ['rust', 'sage', 'blue', 'plum', 'gold'];

    public static function all(): array
    {
        return Database::instance()->all('SELECT * FROM categories ORDER BY name ASC');
    }

    public static function find(int $id): ?array
    {
        return Database::instance()->first('SELECT * FROM categories WHERE id = ?', [$id]);
    }

    public static function create(array $data): int
    {
        $db = Database::instance();
        $db->run(
            'INSERT INTO categories (name, slug, color) VALUES (?, ?, ?)',
            [$data['name'], $data['slug'], $data['color']]
        );

        return $db->lastInsertId();
    }

    public static function update(int $id, array $data): void
    {
        Database::instance()->run(
            'UPDATE categories SET name = ?, slug = ?, color = ? WHERE id = ?',
            [$data['name'], $data['slug'], $data['color'], $id]
        );
    }

    /** Posts nesta categoria ficam sem categoria (ON DELETE SET NULL). */
    public static function delete(int $id): void
    {
        Database::instance()->run('DELETE FROM categories WHERE id = ?', [$id]);
    }

    public static function uniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $base = Slugger::slugify($name, 'categoria');
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
            $sql = 'SELECT COUNT(*) FROM categories WHERE slug = ?';
            $params = [$slug];
        } else {
            $sql = 'SELECT COUNT(*) FROM categories WHERE slug = ? AND id <> ?';
            $params = [$slug, $ignoreId];
        }

        return (int) Database::instance()->scalar($sql, $params) > 0;
    }
}
