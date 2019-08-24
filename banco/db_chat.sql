-- phpMyAdmin SQL Dump
-- version 4.0.4.2
-- http://www.phpmyadmin.net
--
-- Máquina: localhost
-- Data de Criação: 21-Set-2018 às 01:13
-- Versão do servidor: 5.6.13
-- versão do PHP: 5.4.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de Dados: `db_chat`
--
CREATE DATABASE IF NOT EXISTS `db_chat` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `db_chat`;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_avatar`
--

CREATE TABLE IF NOT EXISTS `tb_avatar` (
  `cd_avatar` int(11) NOT NULL AUTO_INCREMENT,
  `ds_endereco` varchar(200) NOT NULL,
  PRIMARY KEY (`cd_avatar`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Extraindo dados da tabela `tb_avatar`
--

INSERT INTO `tb_avatar` (`cd_avatar`, `ds_endereco`) VALUES
(1, 'img/ciro.jpg'),
(2, 'img/bolsonaro.jpg'),
(3, 'img/marina.jpeg'),
(4, 'img/rey.jpg'),
(5, 'img/geraldo.jpg');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_emoji`
--

CREATE TABLE IF NOT EXISTS `tb_emoji` (
  `cd_emoji` int(11) NOT NULL AUTO_INCREMENT,
  `nm_emoji` varchar(20) NOT NULL,
  `ds_emoji` varchar(100) NOT NULL,
  PRIMARY KEY (`cd_emoji`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Extraindo dados da tabela `tb_emoji`
--

INSERT INTO `tb_emoji` (`cd_emoji`, `nm_emoji`, `ds_emoji`) VALUES
(1, 'Rindo', 'img/emoji1.png'),
(2, 'Impressionado', 'img/emoji2.png'),
(3, 'Feliz', 'img/emoji3.png'),
(4, 'Apaixonado', 'img/emoji4.png'),
(5, 'Zoeiro', 'img/emoji5.png'),
(6, 'Anjinho', 'img/emoji6.png'),
(7, 'Sonolento', 'img/emoji7.png'),
(8, 'Entediado', 'img/emoji8.png'),
(9, 'Exausto', 'img/emoji9.png'),
(10, 'Faminto', 'img/emoji10.png'),
(11, 'Fofo', 'img/emoji11.png'),
(12, 'Lindo', 'img/emoji12.png'),
(13, 'Indiferente', 'img/emoji13.png'),
(14, 'Assustado', 'img/emoji14.png'),
(15, 'Babando', 'img/emoji15.png'),
(16, 'Aliviado', 'img/emoji16.png'),
(17, 'Chorando', 'img/emoji17.png'),
(18, 'Doente', 'img/emoji18.png'),
(19, 'Beijinho', 'img/emoji19.png'),
(20, 'Rico', 'img/emoji20.png'),
(21, 'Louco', 'img/emoji21.png');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_mensagem`
--

CREATE TABLE IF NOT EXISTS `tb_mensagem` (
  `cd_mensagem` int(11) NOT NULL AUTO_INCREMENT,
  `ds_mensagem` varchar(100) NOT NULL,
  `id_remetente` int(11) DEFAULT NULL,
  `id_destinatario` int(11) DEFAULT NULL,
  `id_tipo` int(11) DEFAULT NULL,
  `id_emoji` int(11) DEFAULT NULL,
  PRIMARY KEY (`cd_mensagem`),
  KEY `id_remetente` (`id_remetente`),
  KEY `id_destinario` (`id_destinatario`),
  KEY `id_tipo` (`id_tipo`),
  KEY `id_emoji` (`id_emoji`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_tipo`
--

CREATE TABLE IF NOT EXISTS `tb_tipo` (
  `cd_tipo` int(11) NOT NULL AUTO_INCREMENT,
  `ds_tipo` varchar(20) NOT NULL,
  PRIMARY KEY (`cd_tipo`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Extraindo dados da tabela `tb_tipo`
--

INSERT INTO `tb_tipo` (`cd_tipo`, `ds_tipo`) VALUES
(1, 'PadrÃ£o'),
(2, 'Sussurro'),
(3, 'Grito');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_usuario`
--

CREATE TABLE IF NOT EXISTS `tb_usuario` (
  `cd_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `nm_usuario` varchar(50) NOT NULL,
  `ds_senha` varchar(50) NOT NULL,
  `id_avatar` int(11) DEFAULT NULL,
  PRIMARY KEY (`cd_usuario`),
  KEY `id_avatar` (`id_avatar`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Extraindo dados da tabela `tb_usuario`
--

INSERT INTO `tb_usuario` (`cd_usuario`, `nm_usuario`, `ds_senha`, `id_avatar`) VALUES
(1, 'iGod', 'igor123', 1),
(2, 'Thalya_Esquilete', 'thalya123', 3),
(3, 'Juan_Escobar', 'juan123', 2),
(4, 'Barry_Frati', 'frati123', 4),
(5, 'Nicolas_Catatau', 'nick123', 2);

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `tb_mensagem`
--
ALTER TABLE `tb_mensagem`
  ADD CONSTRAINT `tb_mensagem_ibfk_1` FOREIGN KEY (`id_remetente`) REFERENCES `tb_usuario` (`cd_usuario`),
  ADD CONSTRAINT `tb_mensagem_ibfk_2` FOREIGN KEY (`id_destinatario`) REFERENCES `tb_usuario` (`cd_usuario`),
  ADD CONSTRAINT `tb_mensagem_ibfk_3` FOREIGN KEY (`id_tipo`) REFERENCES `tb_tipo` (`cd_tipo`),
  ADD CONSTRAINT `tb_mensagem_ibfk_4` FOREIGN KEY (`id_emoji`) REFERENCES `tb_emoji` (`cd_emoji`);

--
-- Limitadores para a tabela `tb_usuario`
--
ALTER TABLE `tb_usuario`
  ADD CONSTRAINT `tb_usuario_ibfk_1` FOREIGN KEY (`id_avatar`) REFERENCES `tb_avatar` (`cd_avatar`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
