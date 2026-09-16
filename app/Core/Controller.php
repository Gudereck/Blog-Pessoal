<?php

declare(strict_types=1);

namespace App\Core;

/**
 * Base dos controllers: atalhos de view, redirect e input.
 */
abstract class Controller
{
    protected View $view;

    public function __construct()
    {
        Session::start();
        $this->view = new View();
    }

    protected function render(string $template, array $data = [], string $layout = 'layouts/main'): void
    {
        $data += [
            'authUser' => Auth::user(),
            'flash'    => [
                'success' => Session::pullFlash('success'),
                'error'   => Session::pullFlash('error'),
            ],
        ];

        $this->view->render($template, $data, $layout);
    }

    protected function redirect(string $path): never
    {
        header('Location: ' . $path);
        exit;
    }

    protected function back(string $fallback = '/'): never
    {
        $this->redirect($_SERVER['HTTP_REFERER'] ?? $fallback);
    }

    /** Valor de $_POST ja trimado. */
    protected function input(string $key, string $default = ''): string
    {
        $value = $_POST[$key] ?? $default;

        return is_string($value) ? trim($value) : $default;
    }

    protected function boolInput(string $key): bool
    {
        return filter_var($_POST[$key] ?? false, FILTER_VALIDATE_BOOL);
    }

    protected function notFound(string $message = 'Pagina nao encontrada'): never
    {
        http_response_code(404);
        $this->render('errors/404', ['title' => $message, 'message' => $message]);
        exit;
    }
}
