-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Tempo de geração: 16/03/2024 às 11:00
-- Versão do servidor: 5.7.44
-- Versão do PHP: 8.1.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `bdwebgestora_protesto_mecanico`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `notificacoes_arquivos`
--

CREATE TABLE `notificacoes_arquivos` (
  `id` int(11) NOT NULL,
  `id_notificacao` int(11) NOT NULL,
  `arquivo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Despejando dados para a tabela `notificacoes_arquivos`
--

INSERT INTO `notificacoes_arquivos` (`id`, `id_notificacao`, `arquivo`) VALUES
(2, 10, '10-0.pdf'),
(3, 11, '11-0.pdf'),
(4, 12, '12-0.pdf'),
(5, 13, '13-0.pdf'),
(6, 14, '14-0.pdf'),
(7, 15, '15-0.pdf'),
(8, 16, '16-0.pdf'),
(9, 17, '17-0.pdf'),
(12, 18, '18-11.pdf'),
(13, 18, '18-1.pdf'),
(14, 19, '19-0.pdf'),
(15, 20, '20-0.pdf'),
(16, 21, '21-0.pdf');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `notificacoes_arquivos`
--
ALTER TABLE `notificacoes_arquivos`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `notificacoes_arquivos`
--
ALTER TABLE `notificacoes_arquivos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
