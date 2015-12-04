-- phpMyAdmin SQL Dump
-- version 3.1.2
-- http://www.phpmyadmin.net
--
-- Serveur: localhost
-- Généré le : Ven 04 Décembre 2015 à 16:32
-- Version du serveur: 5.1.31
-- Version de PHP: 5.6.14

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Base de données: `iut_zend`
--

-- --------------------------------------------------------

--
-- Structure de la table `album`
--

CREATE TABLE IF NOT EXISTS `album` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `artist` varchar(100) NOT NULL,
  `title` varchar(100) NOT NULL,
  `owner` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Contenu de la table `album`
--

INSERT INTO `album` (`id`, `artist`, `title`, `owner`) VALUES
(1, 'The  Military  Wives', 'In  My  Dreams', 1),
(2, 'Adele', '21', 1),
(3, 'Bruce  Springsteen', 'Wrecking Ball (Deluxe)', 1),
(7, 'Toby Fox', 'Undertale', 2),
(8, 'Deluxe', 'Making Music', 2);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(32) NOT NULL,
  `real_name` varchar(150) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `real_name`) VALUES
(1, 'alice', '6384e2b2184bcbf58eccf10ca7a6563c', 'Alice'),
(2, 'bob', '9f9d51bc70ef21ca5c14f307980a29d8', 'Bob');
