<?php

declare(strict_types=1);

/**
 * Configuracao da aplicacao.
 *
 * Valores sensiveis podem ser sobrescritos por variaveis de ambiente
 * (util para nao versionar credenciais de producao).
 */
return [
    'app' => [
        'name'  => getenv('APP_NAME') ?: 'Meu Blog',
        'url'   => getenv('APP_URL') ?: 'http://localhost:8000',
        'debug' => filter_var(getenv('APP_DEBUG') ?: 'true', FILTER_VALIDATE_BOOL),
    ],
    'db' => [
        'host'     => getenv('DB_HOST') ?: '127.0.0.1',
        'port'     => getenv('DB_PORT') ?: '3306',
        'database' => getenv('DB_DATABASE') ?: 'blog',
        'username' => getenv('DB_USERNAME') ?: 'root',
        'password' => getenv('DB_PASSWORD') ?: '',
        'charset'  => 'utf8mb4',
    ],
    'session' => [
        'name'     => 'blog_session',
        'lifetime' => 60 * 60 * 2,
    ],
];
