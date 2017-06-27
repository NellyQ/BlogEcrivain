-- phpMyAdmin SQL Dump
-- version 4.5.5.1
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Mar 27 Juin 2017 à 10:00
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
(1, 'Premier billet', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed sodales tincidunt euismod. Nullam ligula risus, semper eget metus eget, tincidunt elementum libero. Aenean purus erat, tempus ut maximus ac, blandit sed nisl. Nam eget vehicula erat, in commodo nibh. Donec facilisis pharetra condimentum. Vivamus id sem a felis laoreet maximus. Nulla facilisi. Fusce tincidunt, ipsum quis hendrerit egestas, orci dolor vehicula enim, nec ultricies leo massa eleifend nibh. Nullam ante sapien, maximus vitae lectus vel, aliquam posuere justo. Nunc rhoncus sapien non tincidunt semper. Donec egestas accumsan purus nec ultrices. Proin quis pulvinar leo. Etiam mattis sed purus at commodo. Aenean volutpat consequat lorem, id consectetur metus faucibus ac. Proin non volutpat nulla. Curabitur non ultrices turpis. '),
(2, 'Deuxième billet', ' Integer at facilisis arcu. Morbi tristique sollicitudin elit, gravida viverra velit. Proin ultricies ultricies dictum. In gravida, diam a luctus elementum, massa neque placerat massa, eget pellentesque arcu odio a nisi. Maecenas a volutpat lectus, in tempus purus. Donec sed maximus nisl. Praesent lobortis mauris vitae scelerisque interdum. Maecenas ut malesuada augue. Sed aliquet augue nec sem pellentesque pretium. Etiam vel enim a arcu ullamcorper lobortis. Quisque vulputate tortor ut libero tincidunt semper. Praesent ut eleifend diam. Mauris id placerat quam.\r\n\r\nMaecenas neque ante, auctor sit amet accumsan hendrerit, suscipit faucibus nisi. Integer sagittis arcu et neque fermentum gravida. Aenean facilisis eu neque et consequat. Nam pellentesque massa a viverra placerat. Pellentesque elementum elit non dolor commodo venenatis. Proin euismod vestibulum cursus. Sed justo dolor, aliquam id rhoncus nec, maximus ac lectus. Maecenas commodo sagittis neque sed aliquam. Nullam orci dui, porttitor id aliquam ac, vestibulum et odio. Sed id purus sit amet lectus tincidunt ornare at in neque. Nam rutrum sagittis risus, in elementum sem euismod a. Aenean tincidunt ante massa, sed rhoncus erat dapibus ut. Donec enim felis, rhoncus vitae dignissim in, tincidunt nec nisi. Integer quis feugiat purus, id pellentesque augue. Nullam aliquet tristique lectus, quis dictum justo pellentesque et. Proin condimentum volutpat eros a ultricies. '),
(3, 'Troisième Billet', 'Suspendisse potenti. Duis interdum sapien non massa efficitur, vehicula imperdiet sem gravida. Vestibulum scelerisque aliquet neque non dapibus. Aliquam quis pulvinar massa. Vivamus in nulla tristique, auctor massa sit amet, scelerisque velit. Quisque volutpat congue elit. Donec auctor mauris vitae tortor cursus ornare. Sed eu suscipit metus. Phasellus porttitor ante nec justo porttitor, nec tempus urna ornare. Aliquam eget enim in nunc tristique sollicitudin vitae at velit. Praesent vel ultricies risus. Phasellus tempus iaculis tortor, ut viverra massa maximus sit amet. Nam congue diam vitae aliquet consectetur. Phasellus aliquet metus non turpis lobortis, vel ornare augue lacinia. Sed erat risus, venenatis at consequat sed, ornare et arcu. Vivamus in orci eu eros tristique ornare. ');

-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

CREATE TABLE `comments` (
  `com_id` int(11) NOT NULL,
  `com_content` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `billet_id` int(11) NOT NULL,
  `com_author` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `parent_id` int(11) DEFAULT '0',
  `com_level` int(11) DEFAULT NULL,
  `com_signal` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `comments`
--

INSERT INTO `comments` (`com_id`, `com_content`, `billet_id`, `com_author`, `parent_id`, `com_level`, `com_signal`) VALUES
(1, 'Voici un premier commentaire', 1, 'JaneDOE', 0, 0, 0),
(2, 'Réponse au premier commentaire', 1, 'Nelly', 1, 1, NULL),
(3, 'Voici un deuxième commentaire', 1, 'JohnDoe', 0, 0, NULL),
(4, 'Voici une deuxième réponse au premier commentaire', 1, 'JonhDOE', 1, 1, 1),
(5, 'Voici une réponse à la première réponse du premier commentaire', 1, 'JonhDOE', 2, 2, NULL),
(19, 'Test commentaire', 2, 'Nelly', 0, 0, 1),
(20, 'Commentaire test 2', 2, 'Forteroche', 0, 0, NULL);

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
(1, 'Forteroche', '$2y$13$eGn0sG/DN17hxSC44dSWYuTQApaoRGS7Yh55c.XPP8GeVi9LQhtT.', '%qUgq3NAYfC1MKwrW?yevbE', 'ROLE_ADMIN'),
(2, 'JaneDoe', '$2y$13$qOvvtnceX.TjmiFn4c4vFe.hYlIVXHSPHfInEG21D99QZ6/LM70xa', 'dhMTBkzwDKxnD;4KNs,4ENy', 'ROLE_USER'),
(3, 'JohnDoe', '$2y$13$F9v8pl5u5WMrCorP9MLyJeyIsOLj.0/xqKd/hqa5440kyeB7FQ8te', 'YcM=A$nsYzkyeDVjEUa7W9K', 'ROLE_USER');

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
  ADD KEY `fk_com_billet` (`billet_id`);

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
  MODIFY `billet_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `comments`
--
ALTER TABLE `comments`
  MODIFY `com_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `fk_com_billet` FOREIGN KEY (`billet_id`) REFERENCES `billets` (`billet_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
