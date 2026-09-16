<?php

declare(strict_types=1);

/**
 * Cria um usuario do painel.
 *
 * Uso:
 *   C:\xampp\php\php.exe database/create_user.php "Nome" email@exemplo.com "senha"
 *
 * Sem o terceiro argumento, uma senha aleatoria e gerada e exibida.
 */

require dirname(__DIR__) . '/app/bootstrap.php';

use App\Models\User;

$name  = $argv[1] ?? null;
$email = $argv[2] ?? null;
$pass  = $argv[3] ?? null;

if ($name === null || $email === null) {
    fwrite(STDERR, "Uso: php database/create_user.php \"Nome\" email@exemplo.com [senha]\n");
    exit(1);
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    fwrite(STDERR, "E-mail invalido: {$email}\n");
    exit(1);
}

if (User::findByEmail($email) !== null) {
    fwrite(STDERR, "Ja existe um usuario com o e-mail {$email}\n");
    exit(1);
}

$gerada = false;

if ($pass === null || $pass === '') {
    $pass = bin2hex(random_bytes(6));
    $gerada = true;
} elseif (strlen($pass) < 8) {
    fwrite(STDERR, "A senha deve ter pelo menos 8 caracteres.\n");
    exit(1);
}

$id = User::create($name, $email, $pass);

echo "Usuario criado (id {$id}).\n";
echo "  E-mail: {$email}\n";

if ($gerada) {
    echo "  Senha:  {$pass}   <-- gerada automaticamente, anote e troque depois\n";
}
