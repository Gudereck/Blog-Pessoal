<?php

declare(strict_types=1);

/**
 * Front controller: toda requisicao passa por aqui.
 */

use App\Core\Router;

require dirname(__DIR__) . '/app/bootstrap.php';

$router = new Router();

require BASE_PATH . '/routes/web.php';

$router->dispatch(
    $_SERVER['REQUEST_METHOD'] ?? 'GET',
    $_SERVER['REQUEST_URI'] ?? '/'
);
