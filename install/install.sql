-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Lun 18 Janvier 2016 à 08:40
-- Version du serveur :  10.1.9-MariaDB
-- Version de PHP :  5.6.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de données :  `iut_zend`
--

-- --------------------------------------------------------

--
-- Structure de la table `gm_friends`
--

CREATE TABLE `gm_friends` (
  `user_one` int(11) UNSIGNED NOT NULL,
  `user_two` int(11) UNSIGNED NOT NULL,
  `state` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contenu de la table `gm_friends`
--

INSERT INTO `gm_friends` (`user_one`, `user_two`, `state`) VALUES
(1, 2, 1),
(1, 20, 0),
(2, 20, 1),
(2, 21, 0);

-- --------------------------------------------------------

--
-- Structure de la table `gm_restaurants`
--

CREATE TABLE `gm_restaurants` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(100) CHARACTER SET latin1 NOT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `mark` int(10) UNSIGNED NOT NULL,
  `address` varchar(100) CHARACTER SET latin1 NOT NULL,
  `owner` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contenu de la table `gm_restaurants`
--

INSERT INTO `gm_restaurants` (`id`, `name`, `comment`, `mark`, `address`, `owner`) VALUES
(1, 'In  My  Dreams', '', 0, 'The  Military  Wives', 1),
(2, '21', '', 0, 'Adele', 1),
(3, 'Wrecking Ball (Deluxe)', '', 0, 'Bruce  Springsteen', 1),
(7, 'Undertale', '', 0, 'Toby Fox', 2),
(8, 'Making Music', '', 0, 'Deluxe', 2),
(9, 'h', '', 0, 'h', 2),
(10, 'zzzzzzzz', '894', 2, 'zzzzzzz', 2),
(13, 'zzzzzzz', 'zzzzzzzzzzzzzzzzzzzzz', 2, 'zzzzzzzz', 21),
(14, 'yhtgrf', 'ujyhrtgerfze', 2, 'jyhrtrf', 21);

-- --------------------------------------------------------

--
-- Structure de la table `gm_users`
--

CREATE TABLE `gm_users` (
  `id` int(11) UNSIGNED NOT NULL,
  `email` varchar(50) CHARACTER SET latin1 NOT NULL,
  `password` varchar(32) CHARACTER SET latin1 NOT NULL,
  `real_name` varchar(150) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contenu de la table `gm_users`
--

INSERT INTO `gm_users` (`id`, `email`, `password`, `real_name`) VALUES
(1, 'alice', '6384e2b2184bcbf58eccf10ca7a6563c', 'Alice'),
(2, 'bob', '9f9d51bc70ef21ca5c14f307980a29d8', 'Bob'),
(20, 'bob2', 'e8557d12f6551b2ddd26bbdd0395465c', 'bob2'),
(21, 'bob.marley@mail.com', '2e5192166e0eb6820629ad22410d5dc5', 'Bob Marley');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `gm_friends`
--
ALTER TABLE `gm_friends`
  ADD UNIQUE KEY `user_one` (`user_one`,`user_two`);

--
-- Index pour la table `gm_restaurants`
--
ALTER TABLE `gm_restaurants`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `gm_users`
--
ALTER TABLE `gm_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`email`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `gm_restaurants`
--
ALTER TABLE `gm_restaurants`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT pour la table `gm_users`
--
ALTER TABLE `gm_users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;