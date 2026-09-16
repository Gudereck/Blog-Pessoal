<?php

declare(strict_types=1);

/**
 * Insere um post de exemplo (util para ver o layout funcionando).
 *
 * Uso: C:\xampp\php\php.exe database/seed.php
 */

require dirname(__DIR__) . '/app/bootstrap.php';

use App\Core\Database;
use App\Models\Post;
use App\Models\User;

$user = Database::instance()->first('SELECT * FROM users ORDER BY id LIMIT 1');

if ($user === null) {
    fwrite(STDERR, "Nenhum usuario cadastrado. Rode database/create_user.php antes.\n");
    exit(1);
}

$titulo = 'Bem-vindo ao blog';

if (Database::instance()->first('SELECT id FROM posts WHERE title = ?', [$titulo]) !== null) {
    echo "O post de exemplo ja existe.\n";
    exit(0);
}

$id = Post::create([
    'user_id'   => (int) $user['id'],
    'title'     => $titulo,
    'slug'      => Post::uniqueSlug($titulo),
    'excerpt'   => 'Primeiro post do blog, criado automaticamente para voce ver o layout funcionando.',
    'body'      => "Este blog foi feito em PHP puro, sem framework.\n\n"
                 . "A estrutura segue o padrao MVC: as rotas ficam em routes/web.php, "
                 . "os controllers em app/Controllers, os models em app/Models e os templates em views.\n\n"
                 . "Entre no painel com /login para escrever, editar e publicar seus proprios posts. "
                 . "Voce pode apagar este post quando quiser.",
    'published' => true,
]);

echo "Post de exemplo criado (id {$id}).\n";
