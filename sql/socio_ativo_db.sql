-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 22-Mar-2022 às 01:28
-- Versão do servidor: 10.4.22-MariaDB
-- versão do PHP: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `socio_ativo_db`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `clientes`
--

CREATE TABLE IF NOT EXISTS `clientes` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `site` varchar(255) NOT NULL,
  `ativo` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `forms`
--

CREATE TABLE IF NOT EXISTS `forms` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `cliente_id` bigint(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `foreign_clientes_id_form` (`cliente_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `inputs`
--

CREATE TABLE IF NOT EXISTS `inputs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `slug` varchar(100) NOT NULL,
  `type` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `labels`
--

CREATE TABLE IF NOT EXISTS `labels` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `input_id` int(11) NOT NULL,
  `form_id` bigint(255) NOT NULL,
  `readonly` tinyint(1) NOT NULL DEFAULT 0,
  `required` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `foreign_form_id_labels` (`form_id`),
  KEY `foreign_input_id_labels` (`input_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `secret_keys`
--

CREATE TABLE IF NOT EXISTS `secret_keys` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `cliente_id` bigint(255) NOT NULL,
  `user_id` bigint(255) NOT NULL,
  `secret_key` varchar(255) NOT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `foreign_clientes_id_secret_keys` (`cliente_id`),
  KEY `foreign_user_id_secret_keys` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `user_type` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `foreign_user_type_id_users` (`user_type`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `users_cliente`
--

CREATE TABLE IF NOT EXISTS `users_cliente` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `cliente_id` bigint(255) NOT NULL,
  `ativo` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `foreign_clientes_id_users_cliente` (`cliente_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `user_sessions`
--

CREATE TABLE IF NOT EXISTS `user_sessions` (
  `id` bigint(255) NOT NULL AUTO_INCREMENT,
  `session` varchar(255) NOT NULL,
  `user_id` bigint(255) NOT NULL,
  `expire` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `foreign_user_id_user_sessions` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `user_types`
--

CREATE TABLE IF NOT EXISTS `user_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `slug` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `user_types`
--

INSERT INTO `user_types` (`id`, `slug`) VALUES
(1, 'app'),
(2, 'cliente'),
(3, 'admin');

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `forms`
--
ALTER TABLE `forms`
  ADD CONSTRAINT `foreign_clientes_id_form` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`);

--
-- Limitadores para a tabela `labels`
--
ALTER TABLE `labels`
  ADD CONSTRAINT `foreign_form_id_labels` FOREIGN KEY (`form_id`) REFERENCES `forms` (`id`),
  ADD CONSTRAINT `foreign_input_id` FOREIGN KEY (`input_id`) REFERENCES `inputs` (`id`);

--
-- Limitadores para a tabela `secret_keys`
--
ALTER TABLE `secret_keys`
  ADD CONSTRAINT `foreign_clientes_id_secret_keys` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`),
  ADD CONSTRAINT `foreign_user_id_secret_keys` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Limitadores para a tabela `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `foreign_user_type_id_active_actions` FOREIGN KEY (`user_type`) REFERENCES `user_types` (`id`);

--
-- Limitadores para a tabela `users_cliente`
--
ALTER TABLE `users_cliente`
  ADD CONSTRAINT `foreign_clientes_id_users_cliente` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`);

--
-- Limitadores para a tabela `user_sessions`
--
ALTER TABLE `user_sessions`
  ADD CONSTRAINT `foreign_user_id_user_sessions` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
