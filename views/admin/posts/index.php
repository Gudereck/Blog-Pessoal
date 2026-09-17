<?php /** @var array $posts */ ?>
<div class="page-head">
    <h1 class="page-title">Posts</h1>
    <a class="btn" href="/admin/posts/create">Novo post</a>
</div>

<?php if ($posts === []): ?>
    <p class="muted">Nenhum post criado ainda.</p>
<?php else: ?>
    <div class="table-scroll">
    <table class="table">
        <thead>
        <tr>
            <th>Titulo</th>
            <th>Categoria</th>
            <th>Status</th>
            <th>Criado em</th>
            <th class="right">Acoes</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($posts as $post): ?>
            <tr>
                <td>
                    <?php if ($post['published']): ?>
                        <a href="/posts/<?= e($post['slug']) ?>"><?= e($post['title']) ?></a>
                    <?php else: ?>
                        <?= e($post['title']) ?>
                    <?php endif; ?>
                </td>
                <td>
                    <?php if (!empty($post['category_name'])): ?>
                        <span class="tag tag-<?= e($post['category_color']) ?>"><?= e($post['category_name']) ?></span>
                    <?php else: ?>
                        <span class="muted">&mdash;</span>
                    <?php endif; ?>
                </td>
                <td>
                    <?php if ($post['published']): ?>
                        <span class="badge badge-ok">Publicado</span>
                    <?php else: ?>
                        <span class="badge">Rascunho</span>
                    <?php endif; ?>
                </td>
                <td><?= data_br($post['created_at'], true) ?></td>
                <td class="right">
                    <a href="/admin/posts/<?= (int) $post['id'] ?>/edit">Editar</a>
                    <form action="/admin/posts/<?= (int) $post['id'] ?>/delete"
                          method="post"
                          class="inline-form"
                          onsubmit="return confirm('Excluir o post &quot;<?= e($post['title']) ?>&quot;? Essa acao nao pode ser desfeita.');">
                        <?= csrf_field() ?>
                        <button type="submit" class="link-button danger">Excluir</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    </div>
<?php endif; ?>
