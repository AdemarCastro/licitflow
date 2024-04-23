-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Tempo de geração: 23/04/2024 às 12:49
-- Versão do servidor: 8.0.36-0ubuntu0.20.04.1
-- Versão do PHP: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `licitflow`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `licitacoes`
--

CREATE TABLE `licitacoes` (
  `id` int NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `servico` varchar(255) NOT NULL,
  `descricao` text NOT NULL,
  `documento` varchar(255) DEFAULT NULL,
  `data_criacao` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `licitacoes`
--

INSERT INTO `licitacoes` (`id`, `titulo`, `servico`, `descricao`, `documento`, `data_criacao`) VALUES
(3, 'Titulo 04', 'Servico 04', 'JODIA JDAA JDOI AODJ JA IOD JAIOD OAID', '20_at2_versionamentoDeCod.png', '2024-04-23 14:47:12'),
(4, 'Titulo 03', 'Servico 03', 'adju ad jaod oai  JIOAJDIOAJDIOAJIODAIO DJDOJAIOSD', '10_at2_versionamentoDeCodigo.png', '2024-04-23 14:48:24'),
(5, 'Titulo 05', 'Servico 05', ' DJOAI DA Djioa jdioa djioajsd AOID JOAIJDADAJDIO AJOIDJ AODJOAI D', '11_at2_versionamentoDeCodigo.png', '2024-04-23 14:52:57');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `licitacoes`
--
ALTER TABLE `licitacoes`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `licitacoes`
--
ALTER TABLE `licitacoes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
