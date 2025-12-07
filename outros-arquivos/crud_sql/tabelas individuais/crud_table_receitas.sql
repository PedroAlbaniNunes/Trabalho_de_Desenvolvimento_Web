
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
