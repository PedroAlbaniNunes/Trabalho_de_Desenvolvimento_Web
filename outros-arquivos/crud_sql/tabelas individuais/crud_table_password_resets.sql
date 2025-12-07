
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
