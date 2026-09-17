<?php /** @var array $post */ ?>
<article class="post-full">
    <?php if (!empty($post['category_name'])): ?>
        <span class="tag <?= category_tag_class($post['category_color']) ?>"><?= e($post['category_name']) ?></span>
    <?php endif; ?>

    <h1 class="page-title"><?= e($post['title']) ?></h1>
    <p class="post-meta">
        por <?= e($post['author']) ?> em <?= data_br($post['published_at'], true) ?>
    </p>

    <?php if (!empty($post['cover_image'])): ?>
        <img class="post-cover-hero" src="/uploads/<?= e($post['cover_image']) ?>" alt="">
    <?php else: ?>
        <div class="cover-placeholder cover-placeholder-hero <?= category_tag_class($post['category_color'] ?? null) ?>">
            <?= cover_icon() ?>
        </div>
    <?php endif; ?>

    <div class="post-body">
        <?= texto_para_html($post['body']) ?>
    </div>

    <p><a class="read-more" href="/">&larr; Voltar</a></p>
</article>
