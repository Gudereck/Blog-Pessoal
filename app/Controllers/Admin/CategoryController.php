<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Csrf;
use App\Core\Session;
use App\Models\Category;

final class CategoryController extends Controller
{
    public function index(): void
    {
        Auth::requireLogin();

        $this->render('admin/categories/index', [
            'title'      => 'Categorias',
            'categories' => Category::all(),
        ], 'layouts/admin');
    }

    public function create(): void
    {
        Auth::requireLogin();

        $this->render('admin/categories/form', [
            'title'    => 'Nova categoria',
            'category' => null,
        ], 'layouts/admin');
    }

    public function store(): void
    {
        Auth::requireLogin();
        Csrf::verify();

        $data = $this->validated();

        if ($data === null) {
            $this->redirect('/admin/categories/create');
        }

        Category::create([
            'name'  => $data['name'],
            'slug'  => Category::uniqueSlug($data['name']),
            'color' => $data['color'],
        ]);

        Session::flash('success', 'Categoria criada com sucesso.');
        $this->redirect('/admin/categories');
    }

    public function edit(string $id): void
    {
        Auth::requireLogin();

        $category = Category::find((int) $id);

        if ($category === null) {
            $this->notFound('Categoria nao encontrada');
        }

        $this->render('admin/categories/form', [
            'title'    => 'Editar categoria',
            'category' => $category,
        ], 'layouts/admin');
    }

    public function update(string $id): void
    {
        Auth::requireLogin();
        Csrf::verify();

        $categoryId = (int) $id;

        if (Category::find($categoryId) === null) {
            $this->notFound('Categoria nao encontrada');
        }

        $data = $this->validated();

        if ($data === null) {
            $this->redirect('/admin/categories/' . $categoryId . '/edit');
        }

        Category::update($categoryId, [
            'name'  => $data['name'],
            'slug'  => Category::uniqueSlug($data['name'], $categoryId),
            'color' => $data['color'],
        ]);

        Session::flash('success', 'Categoria atualizada.');
        $this->redirect('/admin/categories');
    }

    public function destroy(string $id): void
    {
        Auth::requireLogin();
        Csrf::verify();

        Category::delete((int) $id);

        Session::flash('success', 'Categoria excluida. Os posts dela ficam sem categoria.');
        $this->redirect('/admin/categories');
    }

    /**
     * @return array{name: string, color: string}|null
     */
    private function validated(): ?array
    {
        $name  = $this->input('name');
        $color = $this->input('color');

        $errors = [];

        if ($name === '') {
            $errors[] = 'O nome e obrigatorio.';
        } elseif (mb_strlen($name) > 60) {
            $errors[] = 'O nome deve ter no maximo 60 caracteres.';
        }

        if (!in_array($color, Category::CORES, true)) {
            $errors[] = 'Escolha uma das cores disponiveis.';
        }

        if ($errors !== []) {
            Session::flash('error', implode(' ', $errors));

            return null;
        }

        return [
            'name'  => $name,
            'color' => $color,
        ];
    }
}
