<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Csrf;
use App\Core\Session;
use App\Models\Post;

final class PostController extends Controller
{
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
            'title' => 'Novo post',
            'post'  => null,
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

        Post::create([
            'user_id'   => Auth::id(),
            'title'     => $data['title'],
            'slug'      => Post::uniqueSlug($data['title']),
            'excerpt'   => $data['excerpt'],
            'body'      => $data['body'],
            'published' => $data['published'],
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
            'title' => 'Editar post',
            'post'  => $post,
        ], 'layouts/admin');
    }

    public function update(string $id): void
    {
        Auth::requireLogin();
        Csrf::verify();

        $postId = (int) $id;

        if (Post::find($postId) === null) {
            $this->notFound('Post nao encontrado');
        }

        $data = $this->validated();

        if ($data === null) {
            $this->redirect('/admin/posts/' . $postId . '/edit');
        }

        Post::update($postId, [
            'title'     => $data['title'],
            'slug'      => Post::uniqueSlug($data['title'], $postId),
            'excerpt'   => $data['excerpt'],
            'body'      => $data['body'],
            'published' => $data['published'],
        ]);

        Session::flash('success', 'Post atualizado.');
        $this->redirect('/admin/posts');
    }

    public function destroy(string $id): void
    {
        Auth::requireLogin();
        Csrf::verify();

        Post::delete((int) $id);

        Session::flash('success', 'Post excluido.');
        $this->redirect('/admin/posts');
    }

    /**
     * Valida o formulario. Devolve os dados limpos ou null (com flash de erro).
     *
     * @return array{title: string, excerpt: string|null, body: string, published: bool}|null
     */
    private function validated(): ?array
    {
        $title   = $this->input('title');
        $body    = $this->input('body');
        $excerpt = $this->input('excerpt');

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

        if ($errors !== []) {
            Session::flash('error', implode(' ', $errors));

            return null;
        }

        return [
            'title'     => $title,
            'excerpt'   => $excerpt === '' ? null : $excerpt,
            'body'      => $body,
            'published' => $this->boolInput('published'),
        ];
    }
}
