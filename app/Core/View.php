<?php

declare(strict_types=1);

namespace App\Core;

use RuntimeException;

/**
 * Renderizador de templates PHP com layout.
 */
final class View
{
    private string $basePath;

    public function __construct(?string $basePath = null)
    {
        $this->basePath = $basePath ?? dirname(__DIR__, 2) . '/views';
    }

    /**
     * Renderiza uma view dentro de um layout.
     * O conteudo da view fica disponivel no layout como $content.
     */
    public function render(string $template, array $data = [], string $layout = 'layouts/main'): void
    {
        $content = $this->capture($template, $data);

        echo $this->capture($layout, $data + ['content' => $content]);
    }

    /** Renderiza sem layout (util para fragmentos). */
    public function partial(string $template, array $data = []): void
    {
        echo $this->capture($template, $data);
    }

    private function capture(string $template, array $data): string
    {
        $file = $this->basePath . '/' . str_replace('.', '/', $template) . '.php';

        if (!is_file($file)) {
            throw new RuntimeException("View nao encontrada: {$template} ({$file})");
        }

        extract($data, EXTR_SKIP);

        ob_start();
        require $file;

        return (string) ob_get_clean();
    }
}
