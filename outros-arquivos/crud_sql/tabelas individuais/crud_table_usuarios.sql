
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
