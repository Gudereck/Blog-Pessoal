<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Post;

final class HomeController extends Controller
{
    private const PER_PAGE = 5;

    public function index(): void
    {
        $page   = max(1, (int) ($_GET['page'] ?? 1));
        $total  = Post::countPublished();
        $pages  = max(1, (int) ceil($total / self::PER_PAGE));
        $page   = min($page, $pages);
        $offset = ($page - 1) * self::PER_PAGE;

        $this->render('home', [
            'title'      => 'Inicio',
            'posts'      => Post::published(self::PER_PAGE, $offset),
            'page'       => $page,
            'totalPages' => $pages,
        ]);
    }
}
