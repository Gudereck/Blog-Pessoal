<?php
/** @var array|null $post */
$isEdit = $post !== null;
$action = $isEdit ? '/admin/posts/' . (int) $post['id'] : '/admin/posts';
?>
<h1 class="page-title"><?= $isEdit ? 'Editar post' : 'Novo post' ?></h1>

<form action="<?= $action ?>" method="post" class="form">
    <?= csrf_field() ?>

    <label for="title">Titulo</label>
    <input type="text" id="title" name="title" maxlength="200" required
           value="<?= e($post['title'] ?? '') ?>">

    <label for="excerpt">Resumo <span class="muted">(opcional, ate 300 caracteres)</span></label>
    <textarea id="excerpt" name="excerpt" rows="2" maxlength="300"><?= e($post['excerpt'] ?? '') ?></textarea>

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
