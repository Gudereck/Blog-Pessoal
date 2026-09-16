<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Auth;
use App\Core\Controller;
use App\Models\Post;

final class DashboardController extends Controller
{
    public function index(): void
    {
        Auth::requireLogin();

        $posts = Post::all();

        $this->render('admin/dashboard', [
            'title'     => 'Painel',
            'posts'     => $posts,
            'published' => count(array_filter($posts, static fn (array $p): bool => (bool) $p['published'])),
        ], 'layouts/admin');
    }
}
