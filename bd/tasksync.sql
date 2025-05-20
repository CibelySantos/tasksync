-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 20-Maio-2025 às 17:32
-- Versão do servidor: 10.4.27-MariaDB
-- versão do PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `tasksync`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `tarefas`
--

CREATE TABLE `tarefas` (
  `id_tarefas` int(11) NOT NULL,
  `setor_tarefas` varchar(200) NOT NULL,
  `datacriacao_tarefas` date NOT NULL,
  `descricao_tarefas` varchar(200) NOT NULL,
  `status_tarefas` varchar(200) NOT NULL,
  `id_usuarios` int(11) NOT NULL,
  `titulo_tarefas` varchar(200) NOT NULL,
  `prioridade_tarefas` enum('baixa','media','alta') DEFAULT 'media'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `tarefas`
--

INSERT INTO `tarefas` (`id_tarefas`, `setor_tarefas`, `datacriacao_tarefas`, `descricao_tarefas`, `status_tarefas`, `id_usuarios`, `titulo_tarefas`, `prioridade_tarefas`) VALUES
(2, 'vendas', '2025-05-23', 'teste', 'alta', 5, 'teste2', 'media'),
(3, 'vendas', '2025-05-06', 'testeeeee', 'media', 5, 'teste3', 'media'),
(5, 'RH', '2025-05-17', 'teste', 'baixa', 2, 'teste4', 'media'),
(7, 'vendas', '2025-05-08', 'teste', 'a_fazer', 3, 'testeeeexxxxx', 'media');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuarios` int(11) NOT NULL,
  `senha_usuarios` varchar(64) NOT NULL,
  `nome_usuarios` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id_usuarios`, `senha_usuarios`, `nome_usuarios`) VALUES
(2, '$2y$10$g8njn', '0'),
(3, '$2y$10$hOojc', '0'),
(4, '$2y$10$HnzRP', 'Cibely'),
(5, '$2y$10$wTarG', 'Julia'),
(6, '$2y$10$19saf', 'Fabio'),
(7, '$2y$10$fHEpb', 'Carlos'),
(8, '$2y$10$OqdwIdDRMyosaMBYgmZjTO6fLaCnz88MShyGREMEhLra67wYEpBxW', 'Julio'),
(9, '$2y$10$I23Vzj/kxCOB15Ce2WfwnONfXmf3zLAZdV3V.hNCZKR3FHXV0z/2C', 'Julio'),
(10, '$2y$10$MMnv19qadS0nwnROiV18P.Mn7btdcNHbh2aSBh6cZ9ZKLRXCPnmNG', 'Marcos'),
(11, '$2y$10$SS/iC5DBnOD47clUkgViROUi.uZy4uejjou2hmFoXk/HcHXQG.mmq', 'Raquel');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `tarefas`
--
ALTER TABLE `tarefas`
  ADD PRIMARY KEY (`id_tarefas`),
  ADD KEY `id_usuarios` (`id_usuarios`);

--
-- Índices para tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuarios`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `tarefas`
--
ALTER TABLE `tarefas`
  MODIFY `id_tarefas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuarios` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `tarefas`
--
ALTER TABLE `tarefas`
  ADD CONSTRAINT `tarefas_ibfk_1` FOREIGN KEY (`id_usuarios`) REFERENCES `usuarios` (`id_usuarios`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
