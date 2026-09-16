<?php /** @var array|null $category */ ?>
<?php
$isEdit = $category !== null;
$action = $isEdit ? '/admin/categories/' . (int) $category['id'] : '/admin/categories';
$corAtual = $category['color'] ?? 'rust';
?>
<h1 class="page-title"><?= $isEdit ? 'Editar categoria' : 'Nova categoria' ?></h1>

<form action="<?= $action ?>" method="post" class="form">
    <?= csrf_field() ?>

    <label for="name">Nome</label>
    <input type="text" id="name" name="name" maxlength="60" required
           value="<?= e($category['name'] ?? '') ?>">

    <label>Cor</label>
    <div class="color-picker">
        <?php foreach (\App\Models\Category::CORES as $cor): ?>
            <label class="color-option color-<?= e($cor) ?>">
                <input type="radio" name="color" value="<?= e($cor) ?>"
                    <?= $cor === $corAtual ? 'checked' : '' ?>>
            </label>
        <?php endforeach; ?>
    </div>

    <div class="form-actions">
        <button type="submit" class="btn"><?= $isEdit ? 'Salvar alteracoes' : 'Criar categoria' ?></button>
        <a class="btn btn-secondary" href="/admin/categories">Cancelar</a>
    </div>
</form>
