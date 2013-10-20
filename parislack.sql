-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Dim 20 Octobre 2013 à 18:07
-- Version du serveur: 5.5.8-log
-- Version de PHP: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `slackline`
--

-- --------------------------------------------------------

--
-- Structure de la table `spots`
--

CREATE TABLE IF NOT EXISTS `spots` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `id_utilisateur` int(5) NOT NULL,
  `latitude` decimal(10,0) NOT NULL,
  `longitude` decimal(10,0) NOT NULL,
  `titre` varchar(70) NOT NULL,
  `description` varchar(255) NOT NULL,
  `adresse` varchar(150) NOT NULL,
  `materiel` varchar(255) NOT NULL,
  `note` tinyint(1) NOT NULL,
  `categorie` varchar(70) NOT NULL,
  `date_creation` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `spots_favoris`
--

CREATE TABLE IF NOT EXISTS `spots_favoris` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `id_utilisateur` int(5) NOT NULL,
  `id_spot` int(5) NOT NULL,
  `note` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `spots_ouvert`
--

CREATE TABLE IF NOT EXISTS `spots_ouvert` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `id_spot` int(5) NOT NULL,
  `date_ouverture` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_fermeture` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `etat` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `date_naissance` date NOT NULL,
  `mdp` varchar(100) NOT NULL,
  `niveau` varchar(15) NOT NULL,
  `technique` varchar(30) NOT NULL,
  `description` varchar(255) NOT NULL,
  `materiel` tinyint(1) NOT NULL,
  `telephone` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
