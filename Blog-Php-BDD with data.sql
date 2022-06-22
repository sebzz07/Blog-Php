-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : mer. 22 juin 2022 à 09:06
-- Version du serveur : 10.3.34-MariaDB-0+deb10u1
-- Version de PHP : 8.1.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `Blog-Php-BDD`
--

-- --------------------------------------------------------

--
-- Structure de la table `article`
--

CREATE TABLE `article` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `chapo` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `creation_date` datetime NOT NULL,
  `modification_date` datetime NOT NULL,
  `author_id` int(11) NOT NULL,
  `visibility` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `article`
--

INSERT INTO `article` (`id`, `title`, `chapo`, `content`, `creation_date`, `modification_date`, `author_id`, `visibility`) VALUES
(1, 'article 1 new', 'sum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '2022-04-27 11:18:06', '2022-06-12 17:37:21', 13, 'published'),
(2, 'article 2', 'm dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea ', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '2022-04-27 11:18:06', '2022-04-27 11:18:06', 13, 'published'),
(3, 'article 3', ' been the industry\'s standard dummy text ever since the 1500s, when an unknown prin', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '2022-05-14 11:18:06', '2022-05-14 11:18:06', 13, 'published'),
(4, 'article 4', 'he leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '2022-05-14 11:18:06', '2022-05-14 11:18:06', 13, 'published'),
(14, 'Nouvelle article', 'A lire Absolument', 'c est une longue histoire', '2022-06-08 15:50:07', '2022-06-08 15:50:07', 13, 'waitingForValidation'),
(15, 'Nouvelle article test', 'A lire Absolument', 'c est une longue histoire', '2022-06-10 12:19:12', '2022-06-10 12:19:12', 13, 'waitingForValidation'),
(16, 'J\'ai passé un petit test PHP sur LinkedIn', 'Aujourd\'hui j\'ai passé le badge PHP sur LinkedIn et devinez mon score', 'Aujourd\'hui j\'ai passé le badge PHP sur LinkedIn et vous savez quoi ?\r\nJe suis classé dans le Top 5% des 662.700 personnes qui l\'ont passé ! \r\nQui l\'eu cru ??!! :D\r\n\r\nLa question maintenant est de savoir quelle valeur à ce test !! :D', '2022-06-10 12:37:44', '2022-06-21 17:47:29', 13, 'published'),
(17, 'Nouvelle article test 4', 'A lire Absolument', 'c est une longue histoire', '2022-06-10 12:44:20', '2022-06-10 12:44:20', 13, 'waitingForValidation'),
(18, 'Nouvelle article test 4', 'A lire Absolument', 'c est une longue histoire', '2022-06-10 12:48:56', '2022-06-10 12:48:56', 13, 'waitingForValidation'),
(19, 'Nouvelle article test 4', 'A lire Absolument', 'c est une longue histoire', '2022-06-10 12:50:47', '2022-06-10 12:50:47', 13, 'waitingForValidation'),
(20, 'Mon super article', 'A lire Absolument oui oui !', 'c est une longue histoire ', '2022-06-10 13:31:05', '2022-06-12 06:24:03', 13, 'published'),
(21, 'test', 'test', 'test', '2022-06-21 16:24:01', '2022-06-21 16:24:01', 13, 'unpublished');

-- --------------------------------------------------------

--
-- Structure de la table `comment`
--

CREATE TABLE `comment` (
  `id` int(11) NOT NULL,
  `content` text NOT NULL,
  `creation_date` datetime NOT NULL DEFAULT current_timestamp(),
  `modification_date` datetime NOT NULL DEFAULT current_timestamp(),
  `article_id` int(11) NOT NULL,
  `author_id` int(11) NOT NULL,
  `visibility` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `comment`
--

INSERT INTO `comment` (`id`, `content`, `creation_date`, `modification_date`, `article_id`, `author_id`, `visibility`) VALUES
(2, 'Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. ', '2022-04-27 11:20:59', '2022-04-27 11:20:59', 1, 13, 'published'),
(4, 'cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '2022-04-27 11:21:39', '2022-04-27 11:21:39', 2, 30, 'published'),
(5, 'test', '2022-05-09 16:06:44', '2022-05-09 16:06:44', 2, 24, 'waitingForValidation'),
(6, 'test article 1 est vraiment bien', '2022-05-09 16:07:52', '2022-06-14 13:25:15', 1, 13, 'waitingForValidation'),
(7, 'test article 1 bis', '2022-05-09 16:07:52', '2022-06-14 13:13:37', 1, 13, 'published'),
(10, 'je suis d\'accord', '2022-06-03 16:44:22', '2022-06-20 18:03:31', 3, 13, 'published'),
(11, 'je suis d\'accord', '2022-06-03 16:52:24', '2022-06-20 18:03:20', 3, 13, 'published'),
(12, 'Vraiment excellent !', '2022-06-12 17:55:06', '2022-06-12 17:55:06', 20, 13, 'published'),
(13, 'je suis john ', '2022-06-14 12:51:17', '2022-06-14 12:51:17', 20, 36, 'published'),
(14, 'On veut lire la suite !', '2022-06-14 14:14:49', '2022-06-20 23:08:45', 20, 36, 'published'),
(15, 'Ça le site est en prod', '2022-06-15 22:36:17', '2022-06-15 22:36:17', 20, 37, 'published'),
(16, 'Super article ', '2022-06-17 15:57:48', '2022-06-17 15:57:48', 20, 38, 'waitingForValidation'),
(17, 'j\'adore cet article', '2022-06-20 12:56:21', '2022-06-20 12:56:21', 2, 30, 'published'),
(18, 'Est-ce vraiment la fin ?', '2022-06-20 18:05:51', '2022-06-20 18:05:51', 20, 30, 'published'),
(19, 'test', '2022-06-20 19:41:31', '2022-06-20 19:41:31', 20, 30, 'published'),
(20, 'Y aura t\'il une mise à jour ?', '2022-06-21 18:21:30', '2022-06-21 18:21:30', 20, 40, 'published');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `password`, `status`) VALUES
(1, 'root', 'root', '$2y$10$p53LDmOszube4TAfrEMFWOrs1i1.bFpHXUGtq8JCd84w5GtIeyaVm', 'admin'),
(13, 'Sebzz', 'sebdru.fr@gmail.com', '$2y$10$AwyS9uPH98HyOAHys6hKV.Q407ZshBOPbau1Rgy/NnznHwOysJfXW', 'user'),
(24, 'Jojo', 'john.doe@email.com', '$2y$10$5EK96y8W2uuyhWYNYp1KwOfL/Iisw55KKrb0uWkiqEHR48iH2Tlie', 'user'),
(27, 'Sebzz543554354', 'sebdru43523435424.fr@gmail.com', '$2y$10$F23eR79/lbG/0PzyzShKG.D3RLAU6ZdDpogvQKhSpcZWAffJxO9T6', 'banned'),
(30, 'dodo', 'dodo@dodo.fr', '$2y$10$7KReXEnaO2Vbdj97rMPbjeM6UfLY.Y2S8qIwqaluDsc8AxCE96vO.', 'user'),
(34, 'dodo22', 'dodo22@dodo.fr', '$2y$10$XOn3T6qaVaSiiC0Lm3abbOkOkt/QbDynJHuPcbzC8upXX5M94ySlW', 'user'),
(35, 'John Doe', 'john.doe@john.doe', '$2y$10$TY5Sg8ARHTuNqk46LveWkOkKMq0dSEVf1MNnn44TPII.M8ehC0m5y', 'user'),
(36, 'John', 'j.doe@unknow.fr', '$2y$10$FT.NgVggpHXtMjHlr.yUlua1sUFdCF2r28RdCfFgO04ido2lwofOG', 'user'),
(37, 'Sebzzagain', 'Seb@test.fr', '$2y$10$kU8rnrK5Fm0gkBOUPt3qo.bEeC0hFOosa7ld1ajKzV3Yly95Tq1/i', 'banned'),
(38, 'Thomas', 'Thomas@thomas.com', '$2y$10$3tkrEbNX7qAB1sbiy4fg6eUDiTkl3TiFWsOml6HdMhciikBtMMfky', 'user'),
(39, 'Jean Michel', 'jean.michel@email.com', '$2y$10$dPz6OyV4ACdTlDecPxp.veThadCkGrRsqOmDBmQnN2EpBCxD4MIHq', 'user'),
(40, 'lulu', 'lulu@email.com', '$2y$10$RXqPsmt6FS13uTBDAS09..RZKpadGmSe6k.JUc9quP8Qlr0B2/lTu', 'user'),
(41, 'lululu', 'lululu@email.com', '$2y$10$DJIhLgLrW1IVOff/R4IRHOfkL4qPXgYnshPMF6Ksv5ARRvYGLf.ZC', 'banned');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `article`
--
ALTER TABLE `article`
  ADD PRIMARY KEY (`id`),
  ADD KEY `author_id` (`author_id`);

--
-- Index pour la table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `article_id` (`article_id`),
  ADD KEY `author_id` (`author_id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `article`
--
ALTER TABLE `article`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT pour la table `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `article`
--
ALTER TABLE `article`
  ADD CONSTRAINT `article_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`article_id`) REFERENCES `article` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`author_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
