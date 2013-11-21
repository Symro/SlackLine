-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Jeu 21 Novembre 2013 à 15:51
-- Version du serveur: 5.6.12-log
-- Version de PHP: 5.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `hetic_slackline`
--
CREATE DATABASE IF NOT EXISTS `hetic_slackline` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `hetic_slackline`;

-- --------------------------------------------------------

--
-- Structure de la table `spots`
--

CREATE TABLE IF NOT EXISTS `spots` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `id_utilisateur` int(5) NOT NULL,
  `latitude` decimal(10,6) NOT NULL,
  `longitude` decimal(10,6) NOT NULL,
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
  `id_utilisateur` int(5) NOT NULL,
  `date_ouverture` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_fermeture` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `etat` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `spots_ouvert`
--

INSERT INTO `spots_ouvert` (`id`, `id_spot`, `id_utilisateur`, `date_ouverture`, `date_fermeture`, `etat`) VALUES
(1, 1, 6, '2013-11-14 07:00:00', '2013-11-14 08:00:00', 1),
(2, 1, 7, '2013-11-14 01:00:00', '2013-11-14 03:00:00', 0),
(3, 2, 14, '2013-11-16 17:00:00', '2013-11-17 01:00:00', 0);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=28 ;

--
-- Contenu de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `nom`, `prenom`, `email`, `date_naissance`, `mdp`, `niveau`, `technique`, `description`, `materiel`, `telephone`) VALUES
(5, 'Perti', 'Baptiste', 'user6@parislack.fr', '1991-05-24', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 'debutant', 'shortline, trickline', 'Ma description', 0, '0123456789'),
(6, 'Verdet', 'Cédric', 'user4@parislack.fr', '2013-10-09', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 'intermediaire', 'shortline, trickline', 'Ma description', 0, '0123456849'),
(7, 'Bastian', 'Pierre', 'user5@parislack.fr', '2013-10-16', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 'intermediaire', 'shortline, trickline, jumpline', 'Ma description', 0, '0123456849'),
(9, 'Legros', 'Etienne', 'user2@parislack.fr', '2007-11-02', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 'confirme', 'trickline', 'Ma description', 1, '0666666666'),
(10, 'Renée', 'Nathalie', 'user3@parislack.fr', '2013-02-02', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 'intermediaire', 'highline', 'Ma description', 0, '0198765432'),
(13, 'Guerard', 'Alex Le Lion', 'alexg10@hotmail.fr', '1992-01-10', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 'confirme', 'highline, waterline', 'Ma description', 0, '0123456849'),
(14, 'Durant', 'Florent', 'user1@parislack.fr', '2009-02-14', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 'confirme', 'shortline, jumpline', 'Ma description', 1, '0231633333');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs_favoris`
--

CREATE TABLE IF NOT EXISTS `utilisateurs_favoris` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `id_utilisateur` int(5) NOT NULL,
  `id_favoris` int(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
