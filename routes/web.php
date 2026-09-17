<?php

declare(strict_types=1);

use App\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Controllers\Admin\DashboardController;
use App\Controllers\Admin\PostController as AdminPostController;
use App\Controllers\AuthController;
use App\Controllers\HomeController;
use App\Controllers\PostController;
use App\Core\Router;

/** @var Router $router */

// --- Publicas ---
$router->get('/', [HomeController::class, 'index']);
$router->get('/posts/{slug}', [PostController::class, 'show']);

// --- Autenticacao ---
$router->get('/login', [AuthController::class, 'showLogin']);
$router->post('/login', [AuthController::class, 'login']);
$router->post('/logout', [AuthController::class, 'logout']);

// --- Painel admin (protegido em cada controller) ---
$router->get('/admin', [DashboardController::class, 'index']);
$router->get('/admin/posts', [AdminPostController::class, 'index']);
$router->get('/admin/posts/create', [AdminPostController::class, 'create']);
$router->post('/admin/posts', [AdminPostController::class, 'store']);
$router->get('/admin/posts/{id}/edit', [AdminPostController::class, 'edit']);
$router->post('/admin/posts/{id}', [AdminPostController::class, 'update']);
$router->post('/admin/posts/{id}/delete', [AdminPostController::class, 'destroy']);

$router->get('/admin/categories', [AdminCategoryController::class, 'index']);
$router->get('/admin/categories/create', [AdminCategoryController::class, 'create']);
$router->post('/admin/categories', [AdminCategoryController::class, 'store']);
$router->get('/admin/categories/{id}/edit', [AdminCategoryController::class, 'edit']);
$router->post('/admin/categories/{id}', [AdminCategoryController::class, 'update']);
$router->post('/admin/categories/{id}/delete', [AdminCategoryController::class, 'destroy']);
