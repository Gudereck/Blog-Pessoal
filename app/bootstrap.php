<?php

declare(strict_types=1);

/**
 * Bootstrap da aplicacao: autoload PSR-4 manual, erros e helpers.
 */

define('BASE_PATH', dirname(__DIR__));

$config = require BASE_PATH . '/config/config.php';

if ($config['app']['debug']) {
    ini_set('display_errors', '1');
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', '0');
    error_reporting(E_ALL & ~E_DEPRECATED);
}

// Autoload PSR-4: App\ -> app/
spl_autoload_register(static function (string $class): void {
    $prefix = 'App\\';

    if (!str_starts_with($class, $prefix)) {
        return;
    }

    $relative = substr($class, strlen($prefix));
    $file = BASE_PATH . '/app/' . str_replace('\\', '/', $relative) . '.php';

    if (is_file($file)) {
        require $file;
    }
});

require BASE_PATH . '/app/helpers.php';

return $config;
