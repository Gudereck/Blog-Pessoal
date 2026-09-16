<?php

declare(strict_types=1);

namespace App\Core;

/**
 * Roteador simples com suporte a parametros nomeados: /posts/{slug}
 */
final class Router
{
    /** @var array<string, array<int, array{pattern: string, params: string[], handler: callable|array}>> */
    private array $routes = ['GET' => [], 'POST' => []];

    public function get(string $path, array|callable $handler): void
    {
        $this->add('GET', $path, $handler);
    }

    public function post(string $path, array|callable $handler): void
    {
        $this->add('POST', $path, $handler);
    }

    private function add(string $method, string $path, array|callable $handler): void
    {
        $params = [];

        $pattern = preg_replace_callback(
            '/\{([a-zA-Z_][a-zA-Z0-9_]*)\}/',
            static function (array $m) use (&$params): string {
                $params[] = $m[1];

                return '([^/]+)';
            },
            rtrim($path, '/') ?: '/'
        );

        $this->routes[$method][] = [
            'pattern' => '#^' . $pattern . '$#',
            'params'  => $params,
            'handler' => $handler,
        ];
    }

    public function dispatch(string $method, string $uri): void
    {
        $path = rtrim(parse_url($uri, PHP_URL_PATH) ?? '/', '/') ?: '/';
        $method = strtoupper($method);

        // Suporte a method spoofing (_method=DELETE em formularios HTML).
        if ($method === 'POST' && isset($_POST['_method'])) {
            $spoofed = strtoupper((string) $_POST['_method']);
            if (in_array($spoofed, ['PUT', 'PATCH', 'DELETE'], true)) {
                $method = 'POST'; // rotas continuam registradas como POST
            }
        }

        foreach ($this->routes[$method] ?? [] as $route) {
            if (preg_match($route['pattern'], $path, $matches) !== 1) {
                continue;
            }

            array_shift($matches);
            $args = array_combine($route['params'], $matches) ?: [];

            $this->call($route['handler'], $args);

            return;
        }

        $this->notFound();
    }

    private function call(array|callable $handler, array $args): void
    {
        if (is_array($handler)) {
            [$class, $action] = $handler;
            $controller = new $class();
            $controller->{$action}(...array_values($args));

            return;
        }

        $handler(...array_values($args));
    }

    private function notFound(): void
    {
        http_response_code(404);
        (new View())->render('errors/404', ['title' => 'Pagina nao encontrada']);
    }
}
