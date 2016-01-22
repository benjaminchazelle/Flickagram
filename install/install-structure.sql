-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Ven 22 Janvier 2016 à 23:48
-- Version du serveur :  10.1.9-MariaDB
-- Version de PHP :  5.6.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de données :  `iut_zend`
--

-- --------------------------------------------------------

--
-- Structure de la table `fg_flicks`
--

DROP TABLE IF EXISTS `fg_flicks`;
CREATE TABLE `fg_flicks` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(100) CHARACTER SET latin1 NOT NULL,
  `fileupload` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci,
  `mark` int(10) UNSIGNED NOT NULL,
  `address` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `owner` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `fg_friends`
--

DROP TABLE IF EXISTS `fg_friends`;
CREATE TABLE `fg_friends` (
  `user_one` int(11) UNSIGNED NOT NULL,
  `user_two` int(11) UNSIGNED NOT NULL,
  `state` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `fg_users`
--

DROP TABLE IF EXISTS `fg_users`;
CREATE TABLE `fg_users` (
  `id` int(11) UNSIGNED NOT NULL,
  `email` varchar(50) CHARACTER SET latin1 NOT NULL,
  `password` varchar(32) CHARACTER SET latin1 NOT NULL,
  `nickname` varchar(150) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Index pour les tables exportées
--

--
-- Index pour la table `fg_flicks`
--
ALTER TABLE `fg_flicks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_owner` (`owner`);

--
-- Index pour la table `fg_friends`
--
ALTER TABLE `fg_friends`
  ADD UNIQUE KEY `user_one` (`user_one`,`user_two`),
  ADD KEY `gm_friends_ibfk_2` (`user_two`);

--
-- Index pour la table `fg_users`
--
ALTER TABLE `fg_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`email`),
  ADD UNIQUE KEY `real_name` (`nickname`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `fg_flicks`
--
ALTER TABLE `fg_flicks`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT pour la table `fg_users`
--
ALTER TABLE `fg_users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `fg_flicks`
--
ALTER TABLE `fg_flicks`
  ADD CONSTRAINT `fg_flicks_ibfk_1` FOREIGN KEY (`owner`) REFERENCES `fg_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `fg_friends`
--
ALTER TABLE `fg_friends`
  ADD CONSTRAINT `fg_friends_ibfk_1` FOREIGN KEY (`user_one`) REFERENCES `fg_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fg_friends_ibfk_2` FOREIGN KEY (`user_two`) REFERENCES `fg_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
