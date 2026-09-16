<?php /** @var array $posts */ ?>
<h1 class="page-title">Últimos posts</h1>

<?php if ($posts === []): ?>
    <p class="muted">Nenhum post publicado ainda.</p>
<?php else: ?>
    <div class="post-list">
        <?php foreach ($posts as $post): ?>
            <article class="post-card">
                <?php if (!empty($post['cover_image'])): ?>
                    <img class="post-cover" src="/uploads/<?= e($post['cover_image']) ?>" alt="">
                <?php else: ?>
                    <div class="cover-placeholder <?= category_tag_class($post['category_color'] ?? null) ?>">
                        <?= cover_icon() ?>
                    </div>
                <?php endif; ?>
                <div class="post-card-body">
                    <?php if (!empty($post['category_name'])): ?>
                        <span class="tag <?= category_tag_class($post['category_color']) ?>"><?= e($post['category_name']) ?></span>
                    <?php endif; ?>
                    <h2>
                        <a href="/posts/<?= e($post['slug']) ?>"><?= e($post['title']) ?></a>
                    </h2>
                    <p class="post-meta">
                        por <?= e($post['author']) ?> em <?= data_br($post['published_at']) ?>
                    </p>
                    <p><?= e(resumo($post)) ?></p>
                    <a class="read-more" href="/posts/<?= e($post['slug']) ?>">Ler mais &rarr;</a>
                </div>
            </article>
        <?php endforeach; ?>
    </div>

    <?php if ($totalPages > 1): ?>
        <nav class="pagination">
            <?php if ($page > 1): ?>
                <a href="/?page=<?= $page - 1 ?>">&larr; Anterior</a>
            <?php endif; ?>
            <span class="muted">Pagina <?= $page ?> de <?= $totalPages ?></span>
            <?php if ($page < $totalPages): ?>
                <a href="/?page=<?= $page + 1 ?>">Proxima &rarr;</a>
            <?php endif; ?>
        </nav>
    <?php endif; ?>
<?php endif; ?>
