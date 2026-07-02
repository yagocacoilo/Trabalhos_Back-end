-- =========================================================
-- Banco de dados do sistema VinylBox (Coleção de Álbuns)
-- =========================================================
-- Este script é uma ALTERNATIVA a rodar "php spark migrate --all".
-- Use um dos dois métodos, não os dois (se já rodou as migrations,
-- não precisa importar este arquivo).
--
-- Como usar no phpMyAdmin:
--   1) Crie um banco chamado albuns_ci (ou o nome que você
--      configurou no .env)
--   2) Selecione o banco -> aba "Importar" -> escolha este arquivo
-- =========================================================

CREATE DATABASE IF NOT EXISTS albuns_ci
    DEFAULT CHARACTER SET utf8mb4
    DEFAULT COLLATE utf8mb4_general_ci;

USE albuns_ci;

-- ---------------------------------------------------------
-- Tabela: users
-- ---------------------------------------------------------
CREATE TABLE IF NOT EXISTS users (
    id         INT UNSIGNED NOT NULL AUTO_INCREMENT,
    nome       VARCHAR(100) NOT NULL,
    username   VARCHAR(50)  NOT NULL,
    senha      VARCHAR(255) NOT NULL,
    created_at DATETIME NULL,
    updated_at DATETIME NULL,
    PRIMARY KEY (id),
    UNIQUE KEY username (username)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------------------------------------------------------
-- Tabela: albuns
-- ---------------------------------------------------------
CREATE TABLE IF NOT EXISTS albuns (
    id         INT UNSIGNED NOT NULL AUTO_INCREMENT,
    user_id    INT UNSIGNED NOT NULL,
    nome_album VARCHAR(150) NOT NULL,
    ano        INT NOT NULL,
    capa       VARCHAR(255) NULL,
    created_at DATETIME NULL,
    updated_at DATETIME NULL,
    PRIMARY KEY (id),
    KEY user_id (user_id),
    CONSTRAINT albuns_user_id_foreign
        FOREIGN KEY (user_id) REFERENCES users (id)
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------------------------------------------------------
-- Tabela: musicas
-- ---------------------------------------------------------
CREATE TABLE IF NOT EXISTS musicas (
    id          INT UNSIGNED NOT NULL AUTO_INCREMENT,
    album_id    INT UNSIGNED NOT NULL,
    nome_musica VARCHAR(150) NOT NULL,
    ordem       INT NOT NULL DEFAULT 0,
    PRIMARY KEY (id),
    KEY album_id (album_id),
    CONSTRAINT musicas_album_id_foreign
        FOREIGN KEY (album_id) REFERENCES albuns (id)
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
