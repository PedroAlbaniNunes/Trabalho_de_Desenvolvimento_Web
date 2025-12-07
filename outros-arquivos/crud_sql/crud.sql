-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 07/12/2025 às 18:06
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `crud`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `favoritos`
--

CREATE TABLE `favoritos` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `receita_id` int(11) NOT NULL,
  `data_favorito` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `password_resets`
--

CREATE TABLE `password_resets` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `expira_em` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `password_resets`
--

INSERT INTO `password_resets` (`id`, `email`, `token`, `expira_em`) VALUES
(13, 'allicia30300@gmail.com', '021ebe80587ee8afab2296ad7fdc6354fd38f2d13ac26623f5e75ed3adbb020e', '2025-12-07 00:47:27');

-- --------------------------------------------------------

--
-- Estrutura para tabela `receitas`
--

CREATE TABLE `receitas` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `nome` varchar(150) NOT NULL,
  `descricao` text NOT NULL,
  `tempo_preparo_minutos` int(11) NOT NULL,
  `categoria` varchar(50) NOT NULL,
  `dificuldade` varchar(20) NOT NULL,
  `ingredientes` text NOT NULL,
  `modo_preparo` text NOT NULL,
  `data_postagem` datetime DEFAULT current_timestamp(),
  `imagem` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `receitas`
--

INSERT INTO `receitas` (`id`, `usuario_id`, `nome`, `descricao`, `tempo_preparo_minutos`, `categoria`, `dificuldade`, `ingredientes`, `modo_preparo`, `data_postagem`, `imagem`) VALUES
(1, 12, 'Pudim', '---', 60, 'Sobremesa', 'Difícil', '---', '---', '2025-12-07 13:15:55', NULL),
(2, 12, 'Brigadeiro', '---', 15, 'Sobremesa', 'Fácil', '---', '---', '2025-12-07 13:17:42', NULL),
(3, 12, 'Macarrão', '---', 35, 'Massa', 'Fácil', '-', '-', '2025-12-07 13:43:14', NULL),
(4, 12, 'sorvete', '---', 20, 'Massa', 'Médio', 'ada', 'adas', '2025-12-07 13:55:15', NULL),
(5, 12, 'asa', 'asa', 363, 'Sobremesa', 'Médio', 'few', 'eew', '2025-12-07 13:56:13', NULL),
(6, 12, 'Pudim', 'ada', 6, 'Sobremesa', 'Médio', 'fs', 'adsad', '2025-12-07 13:57:44', NULL),
(7, 12, 'Brigadeiro', 'aaa', 66, 'Sobremesa', 'Médio', 'sasa', 'sasa', '2025-12-07 13:59:36', NULL),
(8, 12, 'Brigadeiro', 'a', 6, 'Sobremesa', 'Difícil', 'asa', 'asa', '2025-12-07 14:05:07', 'uploads/6935b3c30f4b5.jpg');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `senha` varchar(200) NOT NULL,
  `token_reset` varchar(255) DEFAULT NULL,
  `tipo_usuario` varchar(20) NOT NULL DEFAULT 'comum',
  `data_cadastro` datetime DEFAULT current_timestamp(),
  `reset_token_hash` varchar(64) DEFAULT NULL,
  `reset_token_expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`, `token_reset`, `tipo_usuario`, `data_cadastro`, `reset_token_hash`, `reset_token_expires_at`) VALUES
(10, 'allicia30300@gmail.com', 'allicia30300@gmail.com', '$2y$10$JwpQn5r3txB1NktGg7tVGeZqoR5jQt/2jOkxajCHnrX3VIqGlohmi', NULL, 'comum', '2025-12-05 14:44:21', NULL, NULL),
(11, 'allicia5@gmail.com', 'allicia5@gmail.com', '$2y$10$KHDh79q8fvY2AbWYFR.pz.ZIbvX9Me/zoxU/T6E9gYY2Xjxvb7nuK', NULL, 'comum', '2025-12-06 19:40:53', '058c551108b96b124e05b8f8c4fe96def3f1ae275fa5784e4091b91e8a45bc5d', '2025-12-07 10:56:26'),
(12, 'teste', 'testando@gmail.com', '$2y$10$SC/5sdNGpAkXETCtofsy3uzMK2Vj5meAluz/V3ehD4s2GShWZYmLe', NULL, 'comum', '2025-12-07 07:33:33', NULL, NULL);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `favoritos`
--
ALTER TABLE `favoritos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuario_id` (`usuario_id`,`receita_id`),
  ADD KEY `receita_id` (`receita_id`);

--
-- Índices de tabela `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `token` (`token`);

--
-- Índices de tabela `receitas`
--
ALTER TABLE `receitas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `email_2` (`email`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `favoritos`
--
ALTER TABLE `favoritos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de tabela `receitas`
--
ALTER TABLE `receitas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `favoritos`
--
ALTER TABLE `favoritos`
  ADD CONSTRAINT `favoritos_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `favoritos_ibfk_2` FOREIGN KEY (`receita_id`) REFERENCES `receitas` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `receitas`
--
ALTER TABLE `receitas`
  ADD CONSTRAINT `receitas_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
