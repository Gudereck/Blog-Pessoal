# Blog em PHP puro

Blog com painel administrativo, feito em PHP 8.2 sem framework e sem Composer.
Banco de dados MySQL/MariaDB via PDO.

## Estrutura

```
blog/
├── public/              <- unica pasta exposta na web (document root)
│   ├── index.php        <- front controller: toda requisicao passa por aqui
│   ├── .htaccess        <- reescreve URLs para o index.php
│   └── assets/css/
├── app/
│   ├── bootstrap.php    <- autoload PSR-4, erros, helpers
│   ├── helpers.php      <- e(), csrf_field(), data_br(), texto_para_html()
│   ├── Core/            <- Database, Router, View, Controller, Auth, Session, Csrf
│   ├── Controllers/
│   │   ├── HomeController.php
│   │   ├── PostController.php
│   │   ├── AuthController.php
│   │   └── Admin/       <- DashboardController, PostController
│   └── Models/          <- Post, User
├── views/               <- templates (layouts, home, post, auth, admin, errors)
├── routes/web.php       <- todas as rotas
├── config/config.php    <- configuracao (aceita variaveis de ambiente)
└── database/
    ├── schema.sql       <- criacao das tabelas
    ├── create_user.php  <- cria usuario do painel
    └── seed.php         <- post de exemplo
```

## Rotas

| Metodo | Caminho                   | Descricao                  |
|--------|---------------------------|----------------------------|
| GET    | `/`                       | lista de posts publicados  |
| GET    | `/posts/{slug}`           | post individual            |
| GET    | `/login`                  | formulario de login        |
| POST   | `/login`                  | autenticacao               |
| POST   | `/logout`                 | encerra a sessao           |
| GET    | `/admin`                  | painel (protegido)         |
| GET    | `/admin/posts`            | lista de posts             |
| GET    | `/admin/posts/create`     | formulario de novo post    |
| POST   | `/admin/posts`            | grava novo post            |
| GET    | `/admin/posts/{id}/edit`  | formulario de edicao       |
| POST   | `/admin/posts/{id}`       | grava a edicao             |
| POST   | `/admin/posts/{id}/delete`| exclui o post              |

## Instalacao

1. Suba o MySQL (painel do XAMPP ou `C:\xampp\mysql_start.bat`).

2. Crie o banco e as tabelas:

   ```
   C:\xampp\mysql\bin\mysql.exe -u root < database/schema.sql
   ```

3. Crie o usuario do painel:

   ```
   C:\xampp\php\php.exe database/create_user.php "Seu Nome" voce@exemplo.com "suasenha"
   ```

   Omitindo a senha, uma aleatoria e gerada e exibida no terminal.

4. (Opcional) Post de exemplo:

   ```
   C:\xampp\php\php.exe database/seed.php
   ```

## Rodando

### Servidor embutido do PHP (mais simples)

```
C:\xampp\php\php.exe -S 127.0.0.1:8000 -t public
```

Acesse http://127.0.0.1:8000

### Apache do XAMPP

Aponte um VirtualHost para a pasta `public/`, ou coloque o projeto em
`C:\xampp\htdocs\blog` e acesse http://localhost/blog/public/.

O `.htaccess` da raiz redireciona para `public/` caso o projeto seja servido
de um nivel acima, mas o correto em producao e o DocumentRoot apontar
diretamente para `public/`.

## Configuracao

`config/config.php` le variaveis de ambiente quando existem:

| Variavel      | Padrao      |
|---------------|-------------|
| `APP_NAME`    | Meu Blog    |
| `APP_URL`     | http://localhost:8000 |
| `APP_DEBUG`   | true        |
| `DB_HOST`     | 127.0.0.1   |
| `DB_PORT`     | 3306        |
| `DB_DATABASE` | blog        |
| `DB_USERNAME` | root        |
| `DB_PASSWORD` | (vazio)     |

Em producao, defina `APP_DEBUG=false` e uma senha real para o MySQL.

## Seguranca implementada

- Senhas com `password_hash()`/`password_verify()` e re-hash automatico.
- Token CSRF em todos os formularios POST (resposta 419 quando invalido).
- Todas as consultas usam prepared statements.
- Toda saida em HTML passa por `e()` (`htmlspecialchars`).
- Sessao com cookie `HttpOnly` + `SameSite=Lax` e `session_regenerate_id()` no login.
- Mensagem de login generica, que nao revela se o e-mail existe.
