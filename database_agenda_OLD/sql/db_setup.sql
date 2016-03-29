-- phpMyAdmin SQL Dump
-- version 4.2.12deb2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 21, 2015 at 10:58 PM
-- Server version: 10.0.20-MariaDB-0+deb8u1
-- PHP Version: 5.6.12-0+deb8u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `cucine_popolari`
--
CREATE DATABASE IF NOT EXISTS `cucine_popolari` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `cucine_popolari`;

-- --------------------------------------------------------

--
-- Table structure for table `medico`
--

CREATE TABLE IF NOT EXISTS `medico` (
  `medico_id` int(11) NOT NULL,
  `specialita` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `medico`
--

INSERT INTO `medico` (`medico_id`, `specialita`) VALUES
(0, 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `paziente`
--

CREATE TABLE IF NOT EXISTS `paziente` (
  `paziente_id` int(11) NOT NULL,
  `nascita_stato` varchar(50) NOT NULL,
  `nascita_regione` varchar(50) DEFAULT NULL,
  `nascita_citta` varchar(50) DEFAULT NULL,
  `nascita_via` varchar(50) DEFAULT NULL,
  `nascita_numero` varchar(20) DEFAULT NULL,
  `nascita_telefono` varchar(20) DEFAULT NULL,
  `tessera_sanitaria` varchar(100) DEFAULT NULL,
  `ENI` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `utente`
--

CREATE TABLE IF NOT EXISTS `utente` (
`utente_id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `cognome` varchar(50) DEFAULT NULL,
  `sesso` enum('M','F') NOT NULL,
  `domicilio_stato` varchar(50) NOT NULL,
  `domicilio_regione` varchar(50) DEFAULT NULL,
  `domicilio_citta` varchar(50) DEFAULT NULL,
  `domicilio_via` varchar(50) DEFAULT NULL,
  `domicilio_numero` varchar(10) DEFAULT NULL,
  `data_nascita` date NOT NULL,
  `telefono` varchar(30) DEFAULT NULL,
  `email` varchar(40) DEFAULT NULL,
  `attivo` tinyint(1) NOT NULL DEFAULT '1',
  `note` longtext
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `utente`
--

INSERT INTO `utente` (`utente_id`, `nome`, `cognome`, `sesso`, `domicilio_stato`, `domicilio_regione`, `domicilio_citta`, `domicilio_via`, `domicilio_numero`, `data_nascita`, `telefono`, `email`, `attivo`, `note`) VALUES
(0, 'Amministratore', 'Iniziale', '', '', '', '', '', '', '0000-00-00', '', '', 1, 'Utente temporaneo di amministrazione.');

-- --------------------------------------------------------

--
-- Table structure for table `visita_medica`
--

CREATE TABLE IF NOT EXISTS `visita_medica` (
`visita_medica_id` int(100) NOT NULL,
  `medico_id` int(11) NOT NULL,
  `paziente_id` int(11) NOT NULL,
  `data` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tipo` text,
  `motivazione` longtext,
  `esame_clinico` longtext,
  `diagnosi` longtext,
  `richiesta_esami` longtext,
  `farmaci_attuali_assunzione` longtext,
  `terapia_prescritta` longtext,
  `farmaci_consegnati` longtext,
  `farmaci_prescritti_ricetta` longtext,
  `data_ventura` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `medico`
--
ALTER TABLE `medico`
 ADD PRIMARY KEY (`medico_id`);

--
-- Indexes for table `paziente`
--
ALTER TABLE `paziente`
 ADD PRIMARY KEY (`paziente_id`);

--
-- Indexes for table `utente`
--
ALTER TABLE `utente`
 ADD PRIMARY KEY (`utente_id`);

--
-- Indexes for table `visita_medica`
--
ALTER TABLE `visita_medica`
 ADD PRIMARY KEY (`visita_medica_id`), ADD KEY `visita_medica_id` (`visita_medica_id`), ADD KEY `medico_id` (`medico_id`), ADD KEY `paziente_id` (`paziente_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `utente`
--
ALTER TABLE `utente`
MODIFY `utente_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=49;
--
-- AUTO_INCREMENT for table `visita_medica`
--
ALTER TABLE `visita_medica`
MODIFY `visita_medica_id` int(100) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `paziente`
--
ALTER TABLE `paziente`
ADD CONSTRAINT `paziente_ibfk_1` FOREIGN KEY (`paziente_id`) REFERENCES `utente` (`utente_id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
