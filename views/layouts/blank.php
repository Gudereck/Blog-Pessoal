<?php /** @var string $content */ ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($title ?? 'Blog') ?> &middot; Meu Blog</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body class="centered">
<main class="narrow">
    <?php if (!empty($flash['error'])): ?>
        <div class="alert alert-error"><?= e($flash['error']) ?></div>
    <?php endif; ?>
    <?php if (!empty($flash['success'])): ?>
        <div class="alert alert-success"><?= e($flash['success']) ?></div>
    <?php endif; ?>

    <?= $content ?>
</main>
</body>
</html>
