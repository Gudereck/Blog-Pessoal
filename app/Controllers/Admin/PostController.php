<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Csrf;
use App\Core\Session;
use App\Models\Category;
use App\Models\Post;

final class PostController extends Controller
{
    private const TAMANHO_MAX_IMAGEM = 5 * 1024 * 1024; // 5MB

    private const MIME_PARA_EXTENSAO = [
        'image/jpeg' => 'jpg',
        'image/png'  => 'png',
        'image/webp' => 'webp',
        'image/gif'  => 'gif',
    ];

    public function index(): void
    {
        Auth::requireLogin();

        $this->render('admin/posts/index', [
            'title' => 'Posts',
            'posts' => Post::all(),
        ], 'layouts/admin');
    }

    public function create(): void
    {
        Auth::requireLogin();

        $this->render('admin/posts/form', [
            'title'      => 'Novo post',
            'post'       => null,
            'categories' => Category::all(),
        ], 'layouts/admin');
    }

    public function store(): void
    {
        Auth::requireLogin();
        Csrf::verify();

        $data = $this->validated();

        if ($data === null) {
            $this->redirect('/admin/posts/create');
        }

        $cover = $this->processCoverImage(null);

        if ($cover['error'] !== null) {
            Session::flash('error', $cover['error']);
            $this->redirect('/admin/posts/create');
        }

        Post::create([
            'user_id'     => Auth::id(),
            'category_id' => $data['category_id'],
            'title'       => $data['title'],
            'slug'        => Post::uniqueSlug($data['title']),
            'excerpt'     => $data['excerpt'],
            'cover_image' => $cover['cover_image'],
            'body'        => $data['body'],
            'published'   => $data['published'],
        ]);

        Session::flash('success', 'Post criado com sucesso.');
        $this->redirect('/admin/posts');
    }

    public function edit(string $id): void
    {
        Auth::requireLogin();

        $post = Post::find((int) $id);

        if ($post === null) {
            $this->notFound('Post nao encontrado');
        }

        $this->render('admin/posts/form', [
            'title'      => 'Editar post',
            'post'       => $post,
            'categories' => Category::all(),
        ], 'layouts/admin');
    }

    public function update(string $id): void
    {
        Auth::requireLogin();
        Csrf::verify();

        $postId = (int) $id;
        $post = Post::find($postId);

        if ($post === null) {
            $this->notFound('Post nao encontrado');
        }

        $data = $this->validated();

        if ($data === null) {
            $this->redirect('/admin/posts/' . $postId . '/edit');
        }

        $cover = $this->processCoverImage($post['cover_image']);

        if ($cover['error'] !== null) {
            Session::flash('error', $cover['error']);
            $this->redirect('/admin/posts/' . $postId . '/edit');
        }

        Post::update($postId, [
            'category_id' => $data['category_id'],
            'title'       => $data['title'],
            'slug'        => Post::uniqueSlug($data['title'], $postId),
            'excerpt'     => $data['excerpt'],
            'cover_image' => $cover['cover_image'],
            'body'        => $data['body'],
            'published'   => $data['published'],
        ]);

        Session::flash('success', 'Post atualizado.');
        $this->redirect('/admin/posts');
    }

    public function destroy(string $id): void
    {
        Auth::requireLogin();
        Csrf::verify();

        $post = Post::find((int) $id);

        if ($post !== null && $post['cover_image'] !== null) {
            $this->deleteUpload($post['cover_image']);
        }

        Post::delete((int) $id);

        Session::flash('success', 'Post excluido.');
        $this->redirect('/admin/posts');
    }

    /**
     * Valida o formulario. Devolve os dados limpos ou null (com flash de erro).
     *
     * @return array{title: string, excerpt: string|null, category_id: int|null, body: string, published: bool}|null
     */
    private function validated(): ?array
    {
        $title      = $this->input('title');
        $body       = $this->input('body');
        $excerpt    = $this->input('excerpt');
        $categoryId = $this->input('category_id');

        $errors = [];

        if ($title === '') {
            $errors[] = 'O titulo e obrigatorio.';
        } elseif (mb_strlen($title) > 200) {
            $errors[] = 'O titulo deve ter no maximo 200 caracteres.';
        }

        if ($body === '') {
            $errors[] = 'O conteudo e obrigatorio.';
        }

        if (mb_strlen($excerpt) > 300) {
            $errors[] = 'O resumo deve ter no maximo 300 caracteres.';
        }

        $categoryIdValue = null;
        if ($categoryId !== '') {
            if (!ctype_digit($categoryId) || Category::find((int) $categoryId) === null) {
                $errors[] = 'Escolha uma categoria valida.';
            } else {
                $categoryIdValue = (int) $categoryId;
            }
        }

        if ($errors !== []) {
            Session::flash('error', implode(' ', $errors));

            return null;
        }

        return [
            'title'       => $title,
            'excerpt'     => $excerpt === '' ? null : $excerpt,
            'category_id' => $categoryIdValue,
            'body'        => $body,
            'published'   => $this->boolInput('published'),
        ];
    }

    /**
     * Processa o upload da imagem de capa (opcional). Devolve o nome de
     * arquivo a persistir (mantendo o atual quando nada muda) ou um erro.
     *
     * @return array{cover_image: string|null, error: string|null}
     */
    private function processCoverImage(?string $current): array
    {
        $file = $_FILES['cover_image'] ?? null;
        $removeRequested = $this->boolInput('remove_cover_image');

        if ($file === null || $file['error'] === UPLOAD_ERR_NO_FILE) {
            if ($removeRequested && $current !== null) {
                $this->deleteUpload($current);

                return ['cover_image' => null, 'error' => null];
            }

            return ['cover_image' => $current, 'error' => null];
        }

        if ($file['error'] !== UPLOAD_ERR_OK) {
            return ['cover_image' => $current, 'error' => 'Falha ao enviar a imagem. Tente novamente.'];
        }

        if ($file['size'] > self::TAMANHO_MAX_IMAGEM) {
            return ['cover_image' => $current, 'error' => 'A imagem deve ter no maximo 5MB.'];
        }

        // Nunca confiar no mime/nome enviado pelo cliente: le o tipo real do arquivo.
        $mime = mime_content_type($file['tmp_name']) ?: '';

        if (!isset(self::MIME_PARA_EXTENSAO[$mime])) {
            return ['cover_image' => $current, 'error' => 'Envie uma imagem JPG, PNG, WEBP ou GIF.'];
        }

        $filename = bin2hex(random_bytes(16)) . '.' . self::MIME_PARA_EXTENSAO[$mime];
        $destino = BASE_PATH . '/public/uploads/' . $filename;

        if (!move_uploaded_file($file['tmp_name'], $destino)) {
            return ['cover_image' => $current, 'error' => 'Nao foi possivel salvar a imagem.'];
        }

        if ($current !== null) {
            $this->deleteUpload($current);
        }

        return ['cover_image' => $filename, 'error' => null];
    }

    private function deleteUpload(string $filename): void
    {
        $path = BASE_PATH . '/public/uploads/' . $filename;

        if (is_file($path)) {
            @unlink($path);
        }
    }
}
