-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Tempo de geração: 30/12/2019 às 00:33
-- Versão do servidor: 10.3.17-MariaDB-0+deb10u1
-- Versão do PHP: 7.3.11-1~deb10u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `comercio`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `nome` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Fazendo dump de dados para tabela `categorias`
--

INSERT INTO `categorias` (`id`, `nome`) VALUES
(1, 'Alimentos'),
(2, 'Bebidas'),
(3, 'Higiene'),
(4, 'Limpeza');

-- --------------------------------------------------------

--
-- Estrutura para tabela `produtos`
--

CREATE TABLE `produtos` (
  `codigo` int(11) NOT NULL,
  `nome` varchar(30) DEFAULT NULL,
  `categoria_id` int(11) DEFAULT NULL,
  `preco` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Fazendo dump de dados para tabela `produtos`
--

INSERT INTO `produtos` (`codigo`, `nome`, `categoria_id`, `preco`) VALUES
(1, 'Margarina', 1, 4.5),
(2, 'Óleo', 1, 2),
(3, 'Creme de Leite', 1, 2.75),
(4, 'Maionese', 1, 4),
(5, 'Extrato de Tomate', 1, 1.75),
(6, 'Refrigerante', 2, 3.75),
(7, 'Água Mineral', 2, 2),
(8, 'Cerveja', 2, 5),
(9, 'Suco Pronto', 2, 4.5),
(10, 'Chá Pronto', 2, 3),
(11, 'Shampoo', 3, 4.75),
(12, 'Creme Dental', 3, 2),
(13, 'Desodorante', 3, 4.5),
(14, 'Sabonete', 3, 1.25),
(15, 'Papel Higiênico', 3, 1.5),
(16, 'Sabão em Pedra', 4, 1.55),
(17, 'Detergente Líquido', 4, 1.85),
(18, 'Amaciante', 4, 3.25),
(19, 'Água Sanitária', 4, 2.35),
(20, 'Esponja Sintética', 4, 1.25);

-- --------------------------------------------------------

--
-- Estrutura stand-in para view `vw_produtos`
-- (Veja abaixo para a visão atual)
--
CREATE TABLE `vw_produtos` (
`codigo` int(11)
,`produto` varchar(30)
,`categoria_id` int(11)
,`categoria` varchar(30)
,`preco` double
);

-- --------------------------------------------------------

--
-- Estrutura para view `vw_produtos`
--
DROP TABLE IF EXISTS `vw_produtos`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_produtos`  AS  select `produtos`.`codigo` AS `codigo`,`produtos`.`nome` AS `produto`,`produtos`.`categoria_id` AS `categoria_id`,`categorias`.`nome` AS `categoria`,`produtos`.`preco` AS `preco` from (`produtos` join `categorias` on(`produtos`.`categoria_id` = `categorias`.`id`)) ;

--
-- Índices de tabelas apagadas
--

--
-- Índices de tabela `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `categoria_id` (`categoria_id`);

--
-- AUTO_INCREMENT de tabelas apagadas
--

--
-- AUTO_INCREMENT de tabela `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de tabela `produtos`
--
ALTER TABLE `produtos`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- Restrições para dumps de tabelas
--

--
-- Restrições para tabelas `produtos`
--
ALTER TABLE `produtos`
  ADD CONSTRAINT `produtos_ibfk_1` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
