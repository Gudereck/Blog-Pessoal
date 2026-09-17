<?php

declare(strict_types=1);

/**
 * Migracao unica para bancos criados antes das categorias e imagem de capa.
 * Uso: C:\xampp\php\php.exe database/migrate_categories_covers.php
 *
 * Seguro rodar mais de uma vez: cada passo verifica se ja foi aplicado.
 */

$config = require dirname(__DIR__) . '/config/config.php';
$db = $config['db'];

$pdo = new PDO(
    sprintf('mysql:host=%s;port=%s;dbname=%s;charset=%s', $db['host'], $db['port'], $db['database'], $db['charset']),
    $db['username'],
    $db['password'],
    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
);

function columnExists(PDO $pdo, string $table, string $column): bool
{
    $stmt = $pdo->prepare(
        'SELECT COUNT(*) FROM information_schema.columns
          WHERE table_schema = DATABASE() AND table_name = ? AND column_name = ?'
    );
    $stmt->execute([$table, $column]);

    return (int) $stmt->fetchColumn() > 0;
}

function tableExists(PDO $pdo, string $table): bool
{
    $stmt = $pdo->prepare(
        'SELECT COUNT(*) FROM information_schema.tables WHERE table_schema = DATABASE() AND table_name = ?'
    );
    $stmt->execute([$table]);

    return (int) $stmt->fetchColumn() > 0;
}

if (!tableExists($pdo, 'categories')) {
    $pdo->exec(
        "CREATE TABLE categories (
            id         INT UNSIGNED NOT NULL AUTO_INCREMENT,
            name       VARCHAR(60) NOT NULL,
            slug       VARCHAR(80) NOT NULL,
            color      VARCHAR(20) NOT NULL DEFAULT 'rust',
            created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            UNIQUE KEY categories_slug_unique (slug)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci"
    );
    echo "Tabela categories criada.\n";
} else {
    echo "Tabela categories ja existia.\n";
}

if (!columnExists($pdo, 'posts', 'category_id')) {
    $pdo->exec('ALTER TABLE posts ADD COLUMN category_id INT UNSIGNED NULL AFTER user_id');
    $pdo->exec(
        'ALTER TABLE posts ADD CONSTRAINT posts_category_id_foreign
            FOREIGN KEY (category_id) REFERENCES categories (id) ON DELETE SET NULL'
    );
    echo "Coluna posts.category_id criada.\n";
} else {
    echo "Coluna posts.category_id ja existia.\n";
}

if (!columnExists($pdo, 'posts', 'cover_image')) {
    $pdo->exec('ALTER TABLE posts ADD COLUMN cover_image VARCHAR(255) NULL AFTER excerpt');
    echo "Coluna posts.cover_image criada.\n";
} else {
    echo "Coluna posts.cover_image ja existia.\n";
}

echo "Migracao concluida.\n";
