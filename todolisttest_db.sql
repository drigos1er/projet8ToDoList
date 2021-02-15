-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:8889
-- Généré le :  lun. 15 fév. 2021 à 16:46
-- Version du serveur :  5.7.26
-- Version de PHP :  7.3.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `todolisttest_db`
--
CREATE DATABASE IF NOT EXISTS `todolisttest_db` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `todolisttest_db`;

-- --------------------------------------------------------

--
-- Structure de la table `task`
--

CREATE TABLE `task` (
  `id` int(11) NOT NULL,
  `users_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_done` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `task`
--

INSERT INTO `task` (`id`, `users_id`, `created_at`, `title`, `content`, `is_done`) VALUES
(8, 2, '2021-02-03 17:11:33', 'tasksession3', 'task session3', 1),
(19, 1, '2021-02-12 09:01:58', 'tasksession3', 'task session3', 1);

-- --------------------------------------------------------

--
-- Structure de la table `to_do_role`
--

CREATE TABLE `to_do_role` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `to_do_role`
--

INSERT INTO `to_do_role` (`id`, `title`) VALUES
(1, 'ROLE_ADMIN'),
(2, 'ROLE_USER');

-- --------------------------------------------------------

--
-- Structure de la table `to_do_role_user`
--

CREATE TABLE `to_do_role_user` (
  `to_do_role_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `to_do_role_user`
--

INSERT INTO `to_do_role_user` (`to_do_role_id`, `user_id`) VALUES
(1, 1),
(2, 2),
(2, 18);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_role` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `email`, `user_role`) VALUES
(1, 'usert2', '$2y$10$eg0ufKNI6hoixxSDCiRr6.zZ1dFRCgEzKSQ7PCMzKmAnBjU8Rf6KG', 'usert2@test.ci', '1'),
(2, 'user7', '$2y$13$RLRvoxBN4Tp/rJEA3/X7KOvhOL35gPaKdyrVqAPA6mAN5v0uVOttu', 'user4@ci.ci', '2'),
(8, 'todoadm', '$2y$13$g2D326TAtfVUj5uEwzHyROF5bn63IxOn5c67CkiDFJznV7D4s5DcK', 'todoadm@todo.ci', '1'),
(18, 'user8', '$2y$13$l8Hf0vdkwHMnI90I35pgiOB0PSzGHZBMfNipZAR8mrAHlYnaBaDTe', 'user8@ci.ci', '2');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `task`
--
ALTER TABLE `task`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_527EDB2567B3B43D` (`users_id`);

--
-- Index pour la table `to_do_role`
--
ALTER TABLE `to_do_role`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `to_do_role_user`
--
ALTER TABLE `to_do_role_user`
  ADD PRIMARY KEY (`to_do_role_id`,`user_id`),
  ADD KEY `IDX_DA023D8C58067CCC` (`to_do_role_id`),
  ADD KEY `IDX_DA023D8CA76ED395` (`user_id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649F85E0677` (`username`),
  ADD UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `task`
--
ALTER TABLE `task`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT pour la table `to_do_role`
--
ALTER TABLE `to_do_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `task`
--
ALTER TABLE `task`
  ADD CONSTRAINT `FK_527EDB2567B3B43D` FOREIGN KEY (`users_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `to_do_role_user`
--
ALTER TABLE `to_do_role_user`
  ADD CONSTRAINT `FK_DA023D8C58067CCC` FOREIGN KEY (`to_do_role_id`) REFERENCES `to_do_role` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_DA023D8CA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
