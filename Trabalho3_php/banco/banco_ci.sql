-- ============================================================
--  BancoCI - Script de criação do banco de dados
--  Execute este arquivo no seu MySQL/MariaDB
-- ============================================================

CREATE DATABASE IF NOT EXISTS banco_ci CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE banco_ci;

-- Tabela de usuários
CREATE TABLE IF NOT EXISTS `users` (
    `id`           INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `nome`         VARCHAR(100)     NOT NULL,
    `username`     VARCHAR(50)      NOT NULL UNIQUE,
    `senha`        VARCHAR(255)     NOT NULL,
    `numero_conta` VARCHAR(20)      NOT NULL UNIQUE,
    `saldo`        DECIMAL(15,2)    NOT NULL DEFAULT 0.00,
    `created_at`   DATETIME         NULL,
    `updated_at`   DATETIME         NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabela de transações
CREATE TABLE IF NOT EXISTS `transacoes` (
    `id`         INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_id`    INT(11) UNSIGNED NOT NULL,
    `tipo`       ENUM('debito','credito') NOT NULL,
    `descricao`  VARCHAR(255) NOT NULL,
    `valor`      DECIMAL(15,2) NOT NULL,
    `saldo_apos` DECIMAL(15,2) NOT NULL,
    `created_at` DATETIME NULL,
    `updated_at` DATETIME NULL,
    PRIMARY KEY (`id`),
    CONSTRAINT `fk_transacoes_user` FOREIGN KEY (`user_id`)
        REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
