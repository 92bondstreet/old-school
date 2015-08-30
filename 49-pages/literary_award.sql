-- phpMyAdmin SQL Dump
-- version 3.4.10.1
-- http://www.phpmyadmin.net
--
-- Client: sql-2.e-clicking.in
-- Généré le : Sam 25 Août 2012 à 15:08
-- Version du serveur: 5.0.95
-- Version de PHP: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `bondstre_pmba92`
--

-- --------------------------------------------------------

--
-- Structure de la table `literary_award`
--

CREATE TABLE IF NOT EXISTS `literary_award` (
  `id` varchar(155) NOT NULL,
  `title` varchar(155) NOT NULL,
  `author` varchar(155) NOT NULL,
  `year` varchar(4) NOT NULL,
  `award` varchar(155) NOT NULL,
  `amazon_best_url` varchar(155) NOT NULL,
  `amazon_price` varchar(155) NOT NULL,
  `cheapest_price` varchar(155) NOT NULL,
  `ship_price` varchar(155) NOT NULL,
  `ISBN` varchar(155) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
