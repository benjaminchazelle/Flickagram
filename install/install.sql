-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Ven 22 Janvier 2016 à 00:53
-- Version du serveur :  10.1.9-MariaDB
-- Version de PHP :  5.6.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de données :  `iut_zend`
--

-- --------------------------------------------------------

--
-- Structure de la table `gm_flicks`
--

DROP TABLE IF EXISTS `gm_flicks`;
CREATE TABLE IF NOT EXISTS `gm_flicks` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET latin1 NOT NULL,
  `fileupload` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci,
  `mark` int(10) UNSIGNED NOT NULL,
  `address` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `owner` int(11) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_owner` (`owner`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contenu de la table `gm_flicks`
--

INSERT INTO `gm_flicks` (`id`, `name`, `fileupload`, `comment`, `mark`, `address`, `owner`) VALUES
(1, 'Grenier', 'f009420647f5355fc8f1e3db0a18901b-1453388563.jpg', 'Grrrr !', 4, 'Fondettes Indre-et-Loire Centre', 2),
(2, 'Golden Gate Bridge', '34b7dae6ee3860d92f0d1c894eb30ad1-1453388630.jpg', 'The red.', 2, 'Golden Gate Bridge CA US', 2),
(3, 'Eagle', '8acd4ea368291632746a77571a2be498-1453388670.jpg', 'Flyyy !', 2, 'Mississippi Mills Lanark County ON', 20),
(4, 'Children', 'd82183e7bc35a4c4213ce22b96823304-1453388711.jpg', 'My first trip in Vietnam', 3, '26 Hàng M?m Hà N?i', 1),
(5, 'Aurore', 'c4ef280d46e48dd9542a323cd358330a-1453388780.jpg', 'Sky in fire', 5, 'Adams Bjerg Qaasuitsup GL', 2),
(6, 'Koala', '06d3bc740e8ba0c8f64427649f537269-1453412643.jpg', 'Trop meuhgnon !!', 4, '38 York St Sydney', 2);

-- --------------------------------------------------------

--
-- Structure de la table `gm_friends`
--

DROP TABLE IF EXISTS `gm_friends`;
CREATE TABLE IF NOT EXISTS `gm_friends` (
  `user_one` int(11) UNSIGNED NOT NULL,
  `user_two` int(11) UNSIGNED NOT NULL,
  `state` int(11) UNSIGNED NOT NULL,
  UNIQUE KEY `user_one` (`user_one`,`user_two`),
  KEY `gm_friends_ibfk_2` (`user_two`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contenu de la table `gm_friends`
--

INSERT INTO `gm_friends` (`user_one`, `user_two`, `state`) VALUES
(1, 2, 1),
(1, 20, 0),
(2, 20, 1),
(2, 26, 1),
(21, 2, 1);

-- --------------------------------------------------------

--
-- Structure de la table `gm_users`
--

DROP TABLE IF EXISTS `gm_users`;
CREATE TABLE IF NOT EXISTS `gm_users` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `email` varchar(50) CHARACTER SET latin1 NOT NULL,
  `password` varchar(32) CHARACTER SET latin1 NOT NULL,
  `nickname` varchar(150) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`email`),
  UNIQUE KEY `real_name` (`nickname`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contenu de la table `gm_users`
--

INSERT INTO `gm_users` (`id`, `email`, `password`, `nickname`) VALUES
(1, 'alice@yopmail.com', '6384e2b2184bcbf58eccf10ca7a6563c', 'Alice'),
(2, 'bob@yopmail.com', '9f9d51bc70ef21ca5c14f307980a29d8', 'Bob'),
(20, 'bob2', 'e8557d12f6551b2ddd26bbdd0395465c', 'bob2'),
(21, 'bob.marley@mail.com', '9f9d51bc70ef21ca5c14f307980a29d8', 'Bob Marley'),
(22, 'aqw@zsx.fr', 'e6c0a934324b41e41253589b848280ec', 'aqw'),
(23, 'aqw@sfndfgdf.com', '52e89091c4110a2c4caba28f9f284643', 'Bobd'),
(24, 'dsovsd@fr.fr', '4e17a94fb4b569896fca50c069f1c058', 'dsgdfg'),
(25, 'aqw.zsx@edc.com', '6cf82ee1020caef069e753c67a97a70d', 'sdnskld'),
(26, 'sthdfdsf@art.fr', '1ec165bd8b93cc8acba002f2b42efd93', 'Bobgd'),
(27, 'zsdfs@sdsdf.fr', 'e8557d12f6551b2ddd26bbdd0395465c', 'aqwzsx'),
(28, 'boris@boris.fr', '76af0c5973b7a41ec910046c74aa4c92', 'boris');

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `gm_flicks`
--
ALTER TABLE `gm_flicks`
  ADD CONSTRAINT `gm_flicks_ibfk_1` FOREIGN KEY (`owner`) REFERENCES `gm_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `gm_friends`
--
ALTER TABLE `gm_friends`
  ADD CONSTRAINT `gm_friends_ibfk_1` FOREIGN KEY (`user_one`) REFERENCES `gm_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `gm_friends_ibfk_2` FOREIGN KEY (`user_two`) REFERENCES `gm_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
