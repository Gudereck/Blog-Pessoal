<?php /** @var string $content */ ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($title ?? 'Blog') ?> &middot; Meu Blog</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Newsreader:opsz,wght@6..72,400;6..72,500;6..72,600&display=swap">
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
<header class="site-header">
    <div class="container header-inner">
        <a class="brand" href="/">Meu Blog</a>
        <nav>
            <?php if (!empty($authUser)): ?>
                <a href="/admin">Painel</a>
                <form action="/logout" method="post" class="inline-form">
                    <?= csrf_field() ?>
                    <button type="submit" class="link-button">Sair</button>
                </form>
            <?php else: ?>
                <a href="/login">Entrar</a>
            <?php endif; ?>
        </nav>
    </div>
</header>

<main class="container">
    <?php if (!empty($flash['success'])): ?>
        <div class="alert alert-success"><?= e($flash['success']) ?></div>
    <?php endif; ?>
    <?php if (!empty($flash['error'])): ?>
        <div class="alert alert-error"><?= e($flash['error']) ?></div>
    <?php endif; ?>

    <?= $content ?>
</main>

<footer class="site-footer">
    <div class="container">
        <p>&copy; <?= date('Y') ?> Meu Blog &middot; feito em PHP puro</p>
    </div>
</footer>
</body>
</html>
