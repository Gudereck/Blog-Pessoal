<?php /** @var array $posts */ ?>
<h1 class="page-title">Visao geral</h1>

<div class="stats">
    <div class="stat">
        <span class="stat-value"><?= count($posts) ?></span>
        <span class="stat-label">posts no total</span>
    </div>
    <div class="stat">
        <span class="stat-value"><?= $published ?></span>
        <span class="stat-label">publicados</span>
    </div>
    <div class="stat">
        <span class="stat-value"><?= count($posts) - $published ?></span>
        <span class="stat-label">rascunhos</span>
    </div>
</div>

<p>
    <a class="btn" href="/admin/posts/create">Escrever novo post</a>
    <a class="btn btn-secondary" href="/admin/posts">Gerenciar posts</a>
</p>
