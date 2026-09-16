<?php
/** @var array|null $post */
/** @var array $categories */
$isEdit = $post !== null;
$action = $isEdit ? '/admin/posts/' . (int) $post['id'] : '/admin/posts';
?>
<h1 class="page-title"><?= $isEdit ? 'Editar post' : 'Novo post' ?></h1>

<form action="<?= $action ?>" method="post" class="form" enctype="multipart/form-data">
    <?= csrf_field() ?>

    <label for="title">Titulo</label>
    <input type="text" id="title" name="title" maxlength="200" required
           value="<?= e($post['title'] ?? '') ?>">

    <label for="category_id">Categoria <span class="muted">(opcional)</span></label>
    <select id="category_id" name="category_id">
        <option value="">Sem categoria</option>
        <?php foreach ($categories as $category): ?>
            <option value="<?= (int) $category['id'] ?>"
                <?= (int) ($post['category_id'] ?? 0) === (int) $category['id'] ? 'selected' : '' ?>>
                <?= e($category['name']) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label for="excerpt">Resumo <span class="muted">(opcional, ate 300 caracteres)</span></label>
    <textarea id="excerpt" name="excerpt" rows="2" maxlength="300"><?= e($post['excerpt'] ?? '') ?></textarea>

    <label for="cover_image">Imagem de capa <span class="muted">(opcional, JPG/PNG/WEBP/GIF, ate 5MB)</span></label>
    <?php if (!empty($post['cover_image'])): ?>
        <div class="current-cover">
            <img src="/uploads/<?= e($post['cover_image']) ?>" alt="">
            <label class="checkbox">
                <input type="checkbox" name="remove_cover_image" value="1">
                Remover imagem atual
            </label>
        </div>
    <?php endif; ?>
    <input type="file" id="cover_image" name="cover_image" accept="image/jpeg,image/png,image/webp,image/gif">

    <label for="body">Conteudo</label>
    <textarea id="body" name="body" rows="16" required><?= e($post['body'] ?? '') ?></textarea>

    <label class="checkbox">
        <input type="checkbox" name="published" value="1"
            <?= !empty($post['published']) ? 'checked' : '' ?>>
        Publicar
    </label>

    <div class="form-actions">
        <button type="submit" class="btn"><?= $isEdit ? 'Salvar alteracoes' : 'Criar post' ?></button>
        <a class="btn btn-secondary" href="/admin/posts">Cancelar</a>
    </div>
</form>
