-- phpMyAdmin SQL Dump
-- version 4.5.5.1
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Mar 06 Juin 2017 à 16:59
-- Version du serveur :  5.7.11
-- Version de PHP :  5.6.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `blog_ecrivain`
--

-- --------------------------------------------------------

--
-- Structure de la table `billets`
--

CREATE TABLE `billets` (
  `billet_id` int(11) NOT NULL,
  `billet_title` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `billet_content` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `billets`
--

INSERT INTO `billets` (`billet_id`, `billet_title`, `billet_content`) VALUES
(1, 'Premier billet', 'Voici le tout premier billet.'),
(2, 'Deuxième billet', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut hendrerit mauris ac porttitor accumsan. Nunc vitae pulvinar odio, auctor interdum dolor'),
(7, 'tests', 'eeee'),
(8, 'tests', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque consequat hendrerit ante. Nunc iaculis id dolor in accumsan. Sed pellentesque quam nunc, non ullamcorper purus euismod nec. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Phasellus ac mi sed libero porttitor vulputate. Aenean sed molestie mi, ac vestibulum tortor. Mauris tincidunt ornare quam, sit amet pharetra tortor finibus at. Donec hendrerit ligula justo, sed scelerisque massa laoreet eu. Vestibulum euismod rutrum velit at interdum. Nulla facilisis dolor eros, in consectetur libero ultricies nec. Pellentesque pretium tempor cursus.\r\n\r\nDonec laoreet, lectus id finibus cursus, velit quam euismod enim, sed lobortis tortor tortor non quam. Sed eu augue venenatis sem laoreet vulputate. Cras neque magna, rhoncus et est vel, vehicula blandit felis. Fusce et egestas felis. Integer molestie pellentesque nisl. Etiam efficitur justo quis diam convallis rutrum. Ut elementum blandit tellus, sit amet auctor erat dictum vel. Morbi sit amet urna urna. Fusce auctor, quam a facilisis eleifend, magna metus vulputate justo, in congue leo eros ac ex. Mauris ornare dictum justo quis euismod.\r\n\r\nNullam sem dui, aliquam non libero nec, mollis vehicula lorem. Quisque id bibendum purus. Donec sed mi at augue euismod semper ut a massa. Fusce eget viverra est. Aenean sed magna ac odio lobortis ullamcorper a a lorem. Maecenas pellentesque, magna eu consequat varius, odio nulla pulvinar mauris, ac convallis justo sapien sit amet dui. Proin lacinia turpis ac feugiat tincidunt. Vivamus ac ex nunc. Nulla facilisi. Nulla bibendum libero justo, a consequat mi sagittis sit amet. Praesent vitae urna sapien. Aliquam volutpat lacus nec metus pulvinar efficitur.\r\n\r\nSed vehicula ligula ex, a sollicitudin nisl ultricies ut. In a condimentum sem, in euismod sem. Vivamus sit amet pretium lectus. Nam a imperdiet ipsum, at posuere tellus. Quisque molestie odio elit, a ultricies ligula hendrerit eu. Morbi tincidunt, elit id dictum ornare, ante nisl scelerisque odio, ac hendrerit nibh magna quis tortor. Etiam et mauris odio.\r\n\r\nNulla id efficitur nulla. Proin auctor dui at tristique euismod. Nulla vulputate ipsum nec pharetra varius. Sed pretium ullamcorper arcu ut suscipit. Duis pharetra neque quis tincidunt ullamcorper. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Etiam blandit lorem id libero mollis finibus. Phasellus non bibendum nulla, eu fermentum leo. Nulla facilisi.');

-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

CREATE TABLE `comments` (
  `com_id` int(11) NOT NULL,
  `com_content` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `billet_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `comments`
--

INSERT INTO `comments` (`com_id`, `com_content`, `billet_id`, `user_id`) VALUES
(1, 'Great! Keep up the good work.', 1, 1),
(2, 'Thank you, I\'ll try my best.', 1, 2);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `user_password` varchar(88) COLLATE utf8_unicode_ci NOT NULL,
  `user_salt` varchar(23) COLLATE utf8_unicode_ci NOT NULL,
  `user_role` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_password`, `user_salt`, `user_role`) VALUES
(1, 'JohnDoe', '$2y$13$HdY8l8TiJTFpYz1CutgYP.s2gJpycOPOkP5Qkz3xmnc1HgVfF4GLW', 'YcM=A$nsYzkyeDVjEUa7W9K', 'ROLE_USER'),
(2, 'JaneDoe', '$2y$13$qOvvtnceX.TjmiFn4c4vFe.hYlIVXHSPHfInEG21D99QZ6/LM70xa', 'dhMTBkzwDKxnD;4KNs,4ENy', 'ROLE_USER'),
(3, 'Forteroche', '$2y$13$eGn0sG/DN17hxSC44dSWYuTQApaoRGS7Yh55c.XPP8GeVi9LQhtT.', '%qUgq3NAYfC1MKwrW?yevbE', 'ROLE_ADMIN'),
(11, 'TEST', '$2y$13$UfUei9yZPs4byMnolm79ROfbHlKblzk/HxlFVkQWJP61AigIT9XYa', '3a907972c041191b8b6e17d', 'ROLE_USER');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `billets`
--
ALTER TABLE `billets`
  ADD PRIMARY KEY (`billet_id`);

--
-- Index pour la table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`com_id`),
  ADD KEY `fk_com_billet` (`billet_id`),
  ADD KEY `fk_com_user` (`user_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `billets`
--
ALTER TABLE `billets`
  MODIFY `billet_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT pour la table `comments`
--
ALTER TABLE `comments`
  MODIFY `com_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `fk_com_billet` FOREIGN KEY (`billet_id`) REFERENCES `billets` (`billet_id`),
  ADD CONSTRAINT `fk_com_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
