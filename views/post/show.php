<?php /** @var array $post */ ?>
<article class="post-full">
    <h1 class="page-title"><?= e($post['title']) ?></h1>
    <p class="post-meta">
        por <?= e($post['author']) ?> em <?= data_br($post['published_at'], true) ?>
    </p>

    <div class="post-body">
        <?= texto_para_html($post['body']) ?>
    </div>

    <p><a class="read-more" href="/">&larr; Voltar</a></p>
</article>
