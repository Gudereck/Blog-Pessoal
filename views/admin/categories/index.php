<?php /** @var array $categories */ ?>
<div class="page-head">
    <h1 class="page-title">Categorias</h1>
    <a class="btn" href="/admin/categories/create">Nova categoria</a>
</div>

<?php if ($categories === []): ?>
    <p class="muted">Nenhuma categoria criada ainda.</p>
<?php else: ?>
    <table class="table">
        <thead>
        <tr>
            <th>Nome</th>
            <th>Cor</th>
            <th class="right">Acoes</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($categories as $category): ?>
            <tr>
                <td><?= e($category['name']) ?></td>
                <td><span class="tag tag-<?= e($category['color']) ?>"><?= e($category['name']) ?></span></td>
                <td class="right">
                    <a href="/admin/categories/<?= (int) $category['id'] ?>/edit">Editar</a>
                    <form action="/admin/categories/<?= (int) $category['id'] ?>/delete"
                          method="post"
                          class="inline-form"
                          onsubmit="return confirm('Excluir a categoria &quot;<?= e($category['name']) ?>&quot;? Os posts dela ficam sem categoria.');">
                        <?= csrf_field() ?>
                        <button type="submit" class="link-button danger">Excluir</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
