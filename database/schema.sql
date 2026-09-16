-- Schema do blog. Executar com:
--   C:\xampp\mysql\bin\mysql.exe -u root < database/schema.sql

CREATE DATABASE IF NOT EXISTS blog
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE blog;

CREATE TABLE IF NOT EXISTS users (
    id         INT UNSIGNED NOT NULL AUTO_INCREMENT,
    name       VARCHAR(100) NOT NULL,
    email      VARCHAR(191) NOT NULL,
    password   VARCHAR(255) NOT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY users_email_unique (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS categories (
    id         INT UNSIGNED NOT NULL AUTO_INCREMENT,
    name       VARCHAR(60) NOT NULL,
    slug       VARCHAR(80) NOT NULL,
    color      VARCHAR(20) NOT NULL DEFAULT 'rust',
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY categories_slug_unique (slug)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS posts (
    id           INT UNSIGNED NOT NULL AUTO_INCREMENT,
    user_id      INT UNSIGNED NOT NULL,
    category_id  INT UNSIGNED NULL,
    title        VARCHAR(200) NOT NULL,
    slug         VARCHAR(220) NOT NULL,
    excerpt      VARCHAR(300) NULL,
    cover_image  VARCHAR(255) NULL,
    body         MEDIUMTEXT NOT NULL,
    published    TINYINT(1) NOT NULL DEFAULT 0,
    published_at DATETIME NULL,
    created_at   DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at   DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY posts_slug_unique (slug),
    KEY posts_published_index (published, published_at),
    CONSTRAINT posts_user_id_foreign FOREIGN KEY (user_id)
        REFERENCES users (id) ON DELETE CASCADE,
    CONSTRAINT posts_category_id_foreign FOREIGN KEY (category_id)
        REFERENCES categories (id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
