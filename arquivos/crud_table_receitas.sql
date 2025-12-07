
-- --------------------------------------------------------

--
-- Estrutura para tabela `receitas`
--

CREATE TABLE `receitas` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `nome` varchar(150) NOT NULL,
  `descricao` text NOT NULL,
  `categoria` varchar(150) NOT NULL,
  `dificuldade` enum('Fácil','Médio','Difícil','Chef') NOT NULL,
  `ingredientes` text NOT NULL,
  `tempo_preparo_minutos` int(11) DEFAULT NULL,
  `data_postagem` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
