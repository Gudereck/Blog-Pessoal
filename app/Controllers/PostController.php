<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Post;

final class PostController extends Controller
{
    public function show(string $slug): void
    {
        $post = Post::findPublishedBySlug($slug);

        if ($post === null) {
            $this->notFound('Post nao encontrado');
        }

        $this->render('post/show', [
            'title' => $post['title'],
            'post'  => $post,
        ]);
    }
}
