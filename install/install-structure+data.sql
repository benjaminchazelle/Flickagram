-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Ven 22 Janvier 2016 à 23:49
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

--
-- Vider la table avant d'insérer `fg_flicks`
--

TRUNCATE TABLE `fg_flicks`;
--
-- Contenu de la table `fg_flicks`
--

INSERT INTO `fg_flicks` (`id`, `name`, `fileupload`, `comment`, `mark`, `address`, `owner`) VALUES
(9, 'Koala', '06d3bc740e8ba0c8f64427649f537269-1453500095.jpg', 'Mon dernier voyage en Australie', 3, 'Australie Cl Gilmore ACT', 31),
(10, 'Phare', '4f6a306c94af679657ced7273b5ad4ea-1453500176.jpg', 'La Bretagne et ses phares', 3, 'Brest, France', 31),
(11, 'Le grenier de papy', 'f009420647f5355fc8f1e3db0a18901b-1453500233.jpg', 'Remplie de trésors !', 5, 'Normandie, France', 31),
(12, 'Eagle', '8acd4ea368291632746a77571a2be498-1453500320.jpg', 'Un symbole national !', 4, 'Comté de Mississippi AR US', 32),
(13, 'Golden Gate Bridge', '34b7dae6ee3860d92f0d1c894eb30ad1-1453500356.jpg', 'Une légende rouge', 2, 'Golden Gate Bridge CA US', 32),
(14, 'Aurores', 'c4ef280d46e48dd9542a323cd358330a-1453500463.jpg', 'La belle verte', 5, '18-A Kapelweg Best', 33),
(15, 'Viet children', 'd82183e7bc35a4c4213ce22b96823304-1453500528.jpg', 'Children in Vietnam', 3, 'Hanoi (Ha Noi) VN', 34),
(16, 'Sunrise', '16068c657b789e1fafca1921ca978c6d-1453502356.jpg', 'C''est beau.', 4, 'Pyrénées-Orientales Languedoc-Roussillon FR', 35);

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

--
-- Vider la table avant d'insérer `fg_friends`
--

TRUNCATE TABLE `fg_friends`;
--
-- Contenu de la table `fg_friends`
--

INSERT INTO `fg_friends` (`user_one`, `user_two`, `state`) VALUES
(31, 33, 0),
(31, 35, 1),
(31, 36, 1),
(32, 31, 0),
(32, 33, 1),
(32, 34, 0),
(32, 35, 1),
(32, 36, 0),
(34, 31, 1),
(34, 32, 0),
(34, 33, 0),
(34, 36, 1),
(35, 34, 0),
(35, 36, 0),
(36, 33, 0);

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
-- Vider la table avant d'insérer `fg_users`
--

TRUNCATE TABLE `fg_users`;
--
-- Contenu de la table `fg_users`
--

INSERT INTO `fg_users` (`id`, `email`, `password`, `nickname`) VALUES
(31, 'alice@mail.com', '139964b7dd8604912283b13017ec75b1', 'alice'),
(32, 'bob@mail.com', '139964b7dd8604912283b13017ec75b1', 'bob'),
(33, 'charles@mail.com', '139964b7dd8604912283b13017ec75b1', 'charles'),
(34, 'derik@mail.com', '139964b7dd8604912283b13017ec75b1', 'derik'),
(35, 'elise@mail.com', '139964b7dd8604912283b13017ec75b1', 'elise'),
(36, 'fabrice@mail.com', '139964b7dd8604912283b13017ec75b1', 'fabrice');

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
