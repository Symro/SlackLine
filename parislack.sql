-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Dim 27 Octobre 2013 à 17:10
-- Version du serveur: 5.5.8-log
-- Version de PHP: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `hetic_slackline`
--

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `spots`
--

INSERT INTO `spots` (`id`, `id_utilisateur`, `latitude`, `longitude`, `titre`, `description`, `adresse`, `materiel`, `note`, `categorie`, `date_creation`) VALUES
(1, 6, '23.516500', '42.986099', 'Mon premier spot de Slackline', 'description du spot sur 255 caractères', 'Ourcq', 'j''emmène une 20m', 4, 'shortline', '2013-10-27 10:14:39'),
(2, 6, '21.416519', '42.486145', 'Mon deuxième spot de Slackline', 'description du 2ème spot', 'Canal de l''Ourcq', 'description du matériel', 5, 'longline', '2013-10-27 10:15:56'),
(3, 7, '11.594940', '13.184849', 'Mon troisième spot', 'description du 3ème spot', 'Chevaleret', 'description du matériel', 1, 'shortline', '2013-10-27 14:45:08'),
(4, 8, '42.516891', '46.594946', 'Mon quatrième spot', 'description du 4ème spot', '', '', 4, 'shortline', '2013-10-27 17:10:17');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `spots_favoris`
--

INSERT INTO `spots_favoris` (`id`, `id_utilisateur`, `id_spot`, `note`) VALUES
(1, 6, 1, 4),
(2, 6, 2, 2),
(3, 8, 3, 5);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Contenu de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `nom`, `prenom`, `email`, `date_naissance`, `mdp`, `niveau`, `technique`, `description`, `materiel`, `telephone`) VALUES
(5, 'Utilisateur 6', 'Prénom utilisateur 6', 'user6@lol.fr', '1991-05-24', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 'debutant', 'shortline, trickline', 'Ma petite description\r\n', 0, '0123456789'),
(6, 'Utilisateur 4', 'Prénom utilisateur 4', 'user4@lol.fr', '2013-10-09', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 'intermediaire', 'shortline, trickline', 'Ma description', 0, '0123456849'),
(7, 'Utilisateur 5', 'Prénom utilisateur 5', 'user5@lol.fr', '2013-10-16', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 'intermediaire', 'shortline, trickline, jumpline', 'Ma description', 0, '0123456849'),
(8, 'Utilisateur 1', 'Prénom Utilisateur 1', 'user1@lol.fr', '2013-10-02', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 'debutant', 'shortline', 'Ma description', 1, '0633972522'),
(9, 'Utilisateur 2', 'Prénom Utilisateur 2', 'user2@lol.fr', '2013-11-02', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 'intermediaire', 'longline', 'Ma description', 1, '0666666666'),
(10, 'Utilisateur 3', 'Prénom Utilisateur 3', 'user3@lol.fr', '2013-02-02', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 'intermediaire', 'highline', 'Ma description', 0, '0198765432');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs_favoris`
--

CREATE TABLE IF NOT EXISTS `utilisateurs_favoris` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `id_utilisateur` int(5) NOT NULL,
  `id_favoris` int(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- Contenu de la table `utilisateurs_favoris`
--

INSERT INTO `utilisateurs_favoris` (`id`, `id_utilisateur`, `id_favoris`) VALUES
(1, 6, 5),
(2, 6, 7),
(3, 7, 6),
(4, 5, 7),
(5, 5, 8),
(6, 5, 9),
(7, 5, 10),
(8, 6, 6),
(9, 6, 7),
(10, 6, 8),
(12, 6, 6),
(13, 6, 6);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
