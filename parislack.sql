-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Ven 29 Novembre 2013 à 00:05
-- Version du serveur: 5.5.25
-- Version de PHP: 5.4.4

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

CREATE TABLE `spots` (
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

CREATE TABLE `spots_favoris` (
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

CREATE TABLE `spots_ouvert` (
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

CREATE TABLE `utilisateurs` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=39 ;

--
-- Contenu de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `nom`, `prenom`, `email`, `date_naissance`, `mdp`, `niveau`, `technique`, `description`, `materiel`, `telephone`) VALUES
(28, 'Perti', 'Baptiste', 'perti.baptiste@gmail.com', '1971-11-10', '226a193ae269296d44f3efd3d66fead575a9ed15e14320b088c7c3d3cb2b9d8d', 'expert', 'shortline, trickline, jumpline', 'Passionné par la slackline depuis mes 12 ans, je pratique 3 fois par semaine. Si vous voulez des conseils, n’hésitez-pas à me rejoindre sur le spot !', 0, '0776658753'),
(29, 'Verdet', 'Cédric', 'verdetcedric@gmail.com', '1982-07-16', '29cdee48e28d8104186513c96be32955f6203cffa61833e36a88a37ecbff7989', 'debutant', 'shortline', 'Je suis un petit nouveau dans le monde de slackline mais je dois dire que j’adore ça et que j’ai hâte de progresser.', 0, ''),
(30, 'Legros', 'Etienne', 'etienne.legros@hotmail.fr', '1991-04-17', 'd65c3e892354b17a4c032593974d46bc8732c6c0b1ce56edf0c95511d1749cf5', 'intermediaire', 'shortline, trickline', 'Je pratique essentiellement la trickline, je n’hésites pas à aider les débutants et j’aime également apprendre des autres. A bientôt sur les spots parisiens !', 0, '0676548756'),
(31, 'Durand', 'Florent', 'durand.florent@gmail.com', '1992-12-25', '8bd574fdb05c2dc5017188a2f4c32d5b81963e0a33eccba92404e968c665006d', 'debutant', 'shortline', 'Je suis débutant mais j’ai envie d’apprendre, à bientôt sur les spots !', 0, '0776430854'),
(32, 'Bastian', 'Pierre', 'pierredu46@hotmail.fr', '1988-11-21', '3315f44da4a7aaaf8d84382c7583233f697787f5871294ed49cd41207f7375a0', 'expert', 'jumpline, highline', 'Je pratique depuis 5 ans maintenant avec toujours la même passion ! Je préfère la highline, j’aime le danger ! N’hésitez pas à me demander des conseils.', 0, '0687549809'),
(33, 'Petit', 'Julien', 'petit.julien@gmail.com', '1989-09-18', '9732c83e3e03fffde2ee65a9d826df8c4dd623c27fb92b952fe62a02f0726f87', 'debutant', 'shortline, trickline', 'Je pratique la shortline mais j’ai envie de progresser en trickline donc je suis à la recherche de pros qui souhaiteraient m’apprendre de nouvelles figures', 1, '0687659876'),
(34, 'Dupont', 'Mickael', 'dupont.micka@hotmail.fr', '1984-02-17', '21262a3cb5337627b0fad9d891c16adb40706bd3e57534416dd02bbe5917d184', 'confirme', 'shortline, trickline, longline', 'La slackline est mon sport favoris, je pourrait en faire à longueur de journée ! Content de voir qu’il y a d’autres passionés.', 1, '0676985487'),
(35, 'Villa', 'Nathalie', 'villa.nathalie@gmail.com', '1988-04-18', 'b3c51f8a64fa28ac50ec1233d1178413cc04536d4ae21bb290ffc8d053074456', 'confirme', 'shortline, trickline, highline', 'Shortline, highline, trickline et waterline, j’adore essayer des nouvelles catégories, j’ai hâte de rencontrer d’autres slackers avec qui partager ma passion.', 1, '0776549865'),
(36, 'Laduc', 'Sophie', 'laduc.soso@hotmail.fr', '1990-01-08', 'a27154809adae3840a76308e216d779b3da70b344b86ffe54b9108442b57ae0a', 'intermediaire', 'jumpline, blindline', 'Je pratique la blindline et trickline, ce n’est pas facile de trouver ce genre de spot dans les villes, je compte sur ce site pour m’aider. Je serais ravie de rencontrer d’autres slackers !', 0, '0686985497'),
(37, 'Protu', 'Julie', 'protu.julie@hotmail.fr', '1989-02-18', '9732c83e3e03fffde2ee65a9d826df8c4dd623c27fb92b952fe62a02f0726f87', 'debutant', 'shortline', 'J’ai commencé à pratiquer la slackline il y a quelques mois seulement, mais je suis avide de conseils !', 0, '0687659865'),
(38, 'Judon', 'Laure', 'judon.laure@gmail.com', '1988-05-22', '70a30eae40a4ccbcaf6b81bc4f2b7d817c901f689461990e36348560fa061794', 'intermediaire', 'shortline, trickline, jumpline', 'Je suis nouvelle sur Paris, je souhaite rencontrer des personnes qui ont la même passion que moi. Je pratique la shortline, trickline et un peu de jump, n’hésitez pas si vous voulez qu’on se rencontre.', 1, '0765986598');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs_favoris`
--

CREATE TABLE `utilisateurs_favoris` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `id_utilisateur` int(5) NOT NULL,
  `id_favoris` int(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Contenu de la table `utilisateurs_favoris`
--

INSERT INTO `utilisateurs_favoris` (`id`, `id_utilisateur`, `id_favoris`) VALUES
(1, 29, 29),
(2, 29, 30),
(3, 28, 31),
(4, 35, 29),
(5, 35, 30),
(6, 38, 37),
(7, 38, 33);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
