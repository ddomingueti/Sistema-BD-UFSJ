-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: 25-Set-2019 às 20:44
-- Versão do servidor: 5.7.23
-- versão do PHP: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


IF NOT EXISTS CREATE SCHEMA 'sistema_enade';

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sistema_enade`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `area`
--

DROP TABLE IF EXISTS `area`;
CREATE TABLE IF NOT EXISTS `area` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  CONSTRAINT pk_area PRIMARY KEY (`id`),
  UNIQUE(`nome`)
) ENGINE=innoDB AUTO_INCREMENT=1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE IF NOT EXISTS `usuario` (
  `nome` varchar(50) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `cpf` varchar(11) NOT NULL,
  `idade` int(11) NOT NULL,
  `senha` varchar(20) NOT NULL,
  `sexo` char(1) NOT NULL,
  `data_nasc` date NOT NULL,
  `id_area` int(11) NULL,
  `tipo_ingresso` varchar(2) NULL,
  `tipo_usuario` int(11) NOT NULL,
  CONSTRAINT pk_usuario PRIMARY KEY (`cpf`),
  CONSTRAINT fk_usu_area FOREIGN KEY (id_area) REFERENCES area(id) ON DELETE SET NULL
) ENGINE=innoDB;

-- --------------------------------------------------------

--
-- Estrutura da tabela `avaliacao`
--

DROP TABLE IF EXISTS `avaliacao`;
CREATE TABLE IF NOT EXISTS `avaliacao` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `comentario` varchar(200) NOT NULL,
  `nota` float NOT NULL,
  `data` date NOT NULL,
  `id_usuario` varchar(11) NOT NULL,
  CONSTRAINT pk_usu PRIMARY KEY (`id`),
  CONSTRAINT fk_usu_prova 
    FOREIGN KEY (id_usuario) REFERENCES usuario(cpf)
    ON DELETE CASCADE
) ENGINE=innoDB;

-- --------------------------------------------------------

--
-- Estrutura da tabela `prova`
--

DROP TABLE IF EXISTS `prova`;
CREATE TABLE IF NOT EXISTS `prova` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `data` date NOT NULL,
  `finalizada` tinyint(1) NOT NULL,
  `num_acertos` int(11) NOT NULL,
  `id_usuario` varchar(11) NOT NULL,
  CONSTRAINT pk_prova PRIMARY KEY (`id`),
  CONSTRAINT fk_prova_usu 
    FOREIGN KEY (id_usuario) 
    REFERENCES usuario(cpf) 
    ON DELETE CASCADE
) ENGINE=innoDB;

-- --------------------------------------------------------

--
-- Estrutura da tabela `questoes`
--

DROP TABLE IF EXISTS `questoes`;
CREATE TABLE IF NOT EXISTS `questoes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_area` int(11) NOT NULL,
  `tipo` char(1) NOT NULL,
  `enunciado` varchar(3000) NOT NULL,
  `resposta` varchar(1000) NOT NULL,
  `num_acertos` int(11) NOT NULL,
  `a` varchar(500) NULL,
  `b` varchar(500) NULL,
  `c` varchar(500) NULL,
  `d` varchar(500) NULL,
  `e` varchar(500) NULL,
  `caminho_imagens` varchar(20000) NULL,
  CONSTRAINT fk_questao_area 
    FOREIGN KEY (id_area) REFERENCES area(id)
    ON DELETE CASCADE,
  CONSTRAINT pk_questao 
    PRIMARY KEY(id)
) ENGINE=innoDB;

-- --------------------------------------------------------

--
-- Estrutura da tabela `formada_por`
--

DROP TABLE IF EXISTS `formada_por`;
CREATE TABLE IF NOT EXISTS `formada_por` (
  `id_prova` int(11) NOT NULL,
  `id_questao` int(11) NOT NULL,
  `resposta_usuario` varchar(1000) NULL,
  CONSTRAINT fk_formada_prova 
    FOREIGN KEY (id_prova)  
    REFERENCES prova(id) 
    ON DELETE CASCADE,
  CONSTRAINT fk_formada_questao FOREIGN KEY (id_questao) REFERENCES questoes(id) ON DELETE CASCADE
) ENGINE=innoDB;



COMMIT;


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
