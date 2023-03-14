-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 17-Out-2020 às 07:16
-- Versão do servidor: 10.4.14-MariaDB
-- versão do PHP: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `enduro`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `categoria`
--

CREATE TABLE `categoria` (
  `idCategoria` int(11) NOT NULL,
  `NomeCategoria` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `categoria`
--

INSERT INTO `categoria` (`idCategoria`, `NomeCategoria`) VALUES
(1, 'E4B'),
(2, 'E4A');

-- --------------------------------------------------------

--
-- Estrutura da tabela `competicao`
--

CREATE TABLE `competicao` (
  `idCompeticao` int(11) NOT NULL,
  `NomeCompeticao` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `competicao`
--

INSERT INTO `competicao` (`idCompeticao`, `NomeCompeticao`) VALUES
(1, 'Enduro Sul do Brasil'),
(2, 'Enduro dos Pampas\r\n');

-- --------------------------------------------------------

--
-- Estrutura da tabela `cronometragem`
--

CREATE TABLE `cronometragem` (
  `idcronometragem` int(11) NOT NULL,
  `longitude` double NOT NULL,
  `latitude` double NOT NULL,
  `CodPiloto` int(11) NOT NULL,
  `CTinicial` int(11) NOT NULL DEFAULT 0,
  `CTfinal` int(11) DEFAULT 0,
  `ET1inicial` int(11) DEFAULT 0,
  `ET1final` int(11) DEFAULT 0,
  `Volta` int(11) NOT NULL DEFAULT 99,
  `Tempo` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `cronometragem`
--

INSERT INTO `cronometragem` (`idcronometragem`, `longitude`, `latitude`, `CodPiloto`, `CTinicial`, `CTfinal`, `ET1inicial`, `ET1final`, `Volta`, `Tempo`) VALUES
(1638, -25.7775, -53.314, 1, 1, 0, 0, 0, 1, '00:02:32'),
(1639, -25.7775, -53.314, 1, 0, 1, 0, 0, 1, '00:05:00'),
(1640, -25.7775, -53.314, 1, 0, 0, 1, 0, 1, '00:10:00'),
(1641, -25.7775, -53.314, 1, 0, 0, 0, 1, 1, '00:15:12'),
(1642, -25.7775, -53.314, 1, 1, 0, 0, 0, 2, '00:20:00'),
(1643, -25.7775, -53.314, 1, 0, 1, 0, 0, 2, '00:25:00'),
(1644, -25.7775, -53.314, 1, 0, 0, 1, 0, 2, '00:30:00'),
(1645, -25.7775, -53.314, 1, 0, 0, 0, 1, 2, '00:35:00'),
(1646, -25.7775, -53.314, 2, 1, 0, 0, 0, 1, '00:05:20'),
(1647, -25.7775, -53.314, 2, 0, 1, 0, 0, 1, '00:10:00'),
(1648, -25.7775, -53.314, 2, 0, 0, 1, 0, 1, '00:15:00'),
(1649, -25.7775, -53.314, 2, 0, 0, 0, 1, 1, '00:20:00'),
(1650, -25.7775, -53.314, 2, 1, 0, 0, 0, 2, '00:25:26'),
(1651, -25.7775, -53.314, 2, 0, 1, 0, 0, 2, '00:30:00'),
(1652, -25.7775, -53.314, 2, 0, 0, 1, 0, 2, '00:35:00');

-- --------------------------------------------------------

--
-- Estrutura da tabela `ct1`
--

CREATE TABLE `ct1` (
  `idct` int(11) NOT NULL,
  `tempoct` time NOT NULL DEFAULT '00:00:00',
  `CodPiloto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `et1`
--

CREATE TABLE `et1` (
  `idet1` int(11) NOT NULL,
  `tempoet1` time NOT NULL DEFAULT '00:00:00',
  `CodPiloto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `localizacao`
--

CREATE TABLE `localizacao` (
  `idlocalizacao` int(11) NOT NULL,
  `CodPiloto` int(11) NOT NULL,
  `Latitude` double NOT NULL,
  `Longitude` double NOT NULL,
  `Velocidade` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `localizacao`
--

INSERT INTO `localizacao` (`idlocalizacao`, `CodPiloto`, `Latitude`, `Longitude`, `Velocidade`) VALUES
(4, 1, -25.7775, -53.314, 0.31),
(5, 2, -25.7763, -53.3126, 0.31),
(6, 1, -25.7798, -53.3189, 50),
(8, 2, -25.7773, -53.3132, 36),
(10, 2, -25.7777, -53.3136, 38),
(11, 1, -25.778, -53.314, 49);

-- --------------------------------------------------------

--
-- Estrutura da tabela `login`
--

CREATE TABLE `login` (
  `idLogin` int(11) NOT NULL,
  `Usuario` varchar(255) NOT NULL,
  `Senha` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `login`
--

INSERT INTO `login` (`idLogin`, `Usuario`, `Senha`) VALUES
(1, 'admin', 'admin');

-- --------------------------------------------------------

--
-- Estrutura da tabela `piloto`
--

CREATE TABLE `piloto` (
  `idPiloto` int(11) NOT NULL,
  `NomePiloto` varchar(255) NOT NULL,
  `NumeroPiloto` int(11) NOT NULL,
  `NomeMotocicleta` varchar(255) NOT NULL,
  `CodCompeticao` int(11) NOT NULL,
  `CodCategoria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `piloto`
--

INSERT INTO `piloto` (`idPiloto`, `NomePiloto`, `NumeroPiloto`, `NomeMotocicleta`, `CodCompeticao`, `CodCategoria`) VALUES
(1, 'Leonardo Coelho', 40, 'CRF 230', 1, 1),
(2, 'Pedro', 24, 'CRF', 1, 1),
(7, 'Sidnei', 8, 'CRF 230', 1, 1);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`idCategoria`);

--
-- Índices para tabela `competicao`
--
ALTER TABLE `competicao`
  ADD PRIMARY KEY (`idCompeticao`);

--
-- Índices para tabela `cronometragem`
--
ALTER TABLE `cronometragem`
  ADD PRIMARY KEY (`idcronometragem`),
  ADD KEY `fk_codpiloto` (`CodPiloto`);

--
-- Índices para tabela `ct1`
--
ALTER TABLE `ct1`
  ADD PRIMARY KEY (`idct`),
  ADD KEY `CodPiloto` (`CodPiloto`);

--
-- Índices para tabela `et1`
--
ALTER TABLE `et1`
  ADD PRIMARY KEY (`idet1`),
  ADD KEY `Cod_piloto` (`CodPiloto`);

--
-- Índices para tabela `localizacao`
--
ALTER TABLE `localizacao`
  ADD PRIMARY KEY (`idlocalizacao`),
  ADD KEY `Cod_pilotonew` (`CodPiloto`);

--
-- Índices para tabela `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`idLogin`);

--
-- Índices para tabela `piloto`
--
ALTER TABLE `piloto`
  ADD PRIMARY KEY (`idPiloto`),
  ADD KEY `Fk_competicao` (`CodCompeticao`),
  ADD KEY `Fk_Categoria` (`CodCategoria`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `categoria`
--
ALTER TABLE `categoria`
  MODIFY `idCategoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `competicao`
--
ALTER TABLE `competicao`
  MODIFY `idCompeticao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `cronometragem`
--
ALTER TABLE `cronometragem`
  MODIFY `idcronometragem` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1654;

--
-- AUTO_INCREMENT de tabela `ct1`
--
ALTER TABLE `ct1`
  MODIFY `idct` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `et1`
--
ALTER TABLE `et1`
  MODIFY `idet1` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `localizacao`
--
ALTER TABLE `localizacao`
  MODIFY `idlocalizacao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de tabela `login`
--
ALTER TABLE `login`
  MODIFY `idLogin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `piloto`
--
ALTER TABLE `piloto`
  MODIFY `idPiloto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `cronometragem`
--
ALTER TABLE `cronometragem`
  ADD CONSTRAINT `fk_codpiloto` FOREIGN KEY (`CodPiloto`) REFERENCES `piloto` (`idPiloto`);

--
-- Limitadores para a tabela `ct1`
--
ALTER TABLE `ct1`
  ADD CONSTRAINT `CodPiloto` FOREIGN KEY (`CodPiloto`) REFERENCES `piloto` (`idPiloto`);

--
-- Limitadores para a tabela `et1`
--
ALTER TABLE `et1`
  ADD CONSTRAINT `Cod_piloto` FOREIGN KEY (`CodPiloto`) REFERENCES `piloto` (`idPiloto`);

--
-- Limitadores para a tabela `localizacao`
--
ALTER TABLE `localizacao`
  ADD CONSTRAINT `Cod_pilotonew` FOREIGN KEY (`CodPiloto`) REFERENCES `piloto` (`idPiloto`);

--
-- Limitadores para a tabela `piloto`
--
ALTER TABLE `piloto`
  ADD CONSTRAINT `Fk_Categoria` FOREIGN KEY (`CodCategoria`) REFERENCES `categoria` (`idCategoria`),
  ADD CONSTRAINT `Fk_competicao` FOREIGN KEY (`CodCompeticao`) REFERENCES `competicao` (`idCompeticao`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
