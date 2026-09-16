<div class="card">
    <h1>Entrar no painel</h1>

    <form action="/login" method="post" class="form">
        <?= csrf_field() ?>

        <label for="email">E-mail</label>
        <input type="email" id="email" name="email" value="<?= e($email ?? '') ?>" required autofocus>

        <label for="password">Senha</label>
        <input type="password" id="password" name="password" required>

        <button type="submit" class="btn">Entrar</button>
    </form>

    <p class="muted"><a href="/">&larr; Voltar ao site</a></p>
</div>
