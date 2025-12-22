-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:8889
-- Généré le : lun. 22 déc. 2025 à 22:43
-- Version du serveur : 8.0.40
-- Version de PHP : 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `projet_symfony`
--

-- --------------------------------------------------------

--
-- Structure de la table `adresse`
--

CREATE TABLE `adresse` (
  `id` int NOT NULL,
  `rue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code_postal` int NOT NULL,
  `ville` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pays` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `adresse`
--

INSERT INTO `adresse` (`id`, `rue`, `code_postal`, `ville`, `pays`) VALUES
(1, '1B rue du bourg', 57510, 'Ernestviller', 'France'),
(2, '1B rue du bourgs', 57510, 'Ernestviller', 'France');

-- --------------------------------------------------------

--
-- Structure de la table `carte_credit`
--

CREATE TABLE `carte_credit` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `numero` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_expiration` date NOT NULL,
  `cvv` varchar(4) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `carte_credit`
--

INSERT INTO `carte_credit` (`id`, `user_id`, `numero`, `date_expiration`, `cvv`) VALUES
(1, 1, '1234123412341234', '2026-01-03', '123');

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

CREATE TABLE `commande` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `status_commande` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `reference` int NOT NULL,
  `adresse_livraison_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `commande`
--

INSERT INTO `commande` (`id`, `user_id`, `status_commande`, `date`, `reference`, `adresse_livraison_id`) VALUES
(1, 1, 'En préparation', '2025-12-22', 329195, 1),
(2, 1, 'En préparation', '2025-12-22', 603513, 2),
(3, 1, 'En préparation', '2025-12-22', 888875, 2),
(4, 1, 'En préparation', '2025-12-22', 412115, 1);

-- --------------------------------------------------------

--
-- Structure de la table `commande_produit`
--

CREATE TABLE `commande_produit` (
  `commande_id` int NOT NULL,
  `produit_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `commande_produit`
--

INSERT INTO `commande_produit` (`commande_id`, `produit_id`) VALUES
(2, 18),
(3, 18),
(4, 18),
(4, 26);

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20251024122841', '2025-10-24 12:29:26', 18),
('DoctrineMigrations\\Version20251107134904', '2025-11-07 14:23:56', 25),
('DoctrineMigrations\\Version20251107142426', '2025-11-07 14:24:41', 14),
('DoctrineMigrations\\Version20251107153110', '2025-11-07 15:31:51', 60),
('DoctrineMigrations\\Version20251107161124', '2025-11-07 16:11:28', 20),
('DoctrineMigrations\\Version20251115080048', '2025-11-15 08:03:19', 24),
('DoctrineMigrations\\Version20251115081653', '2025-11-15 08:16:58', 17),
('DoctrineMigrations\\Version20251115132335', '2025-11-15 13:23:41', 13),
('DoctrineMigrations\\Version20251115133845', '2025-11-15 13:38:47', 57),
('DoctrineMigrations\\Version20251222095705', '2025-12-22 09:57:28', 29),
('DoctrineMigrations\\Version20251222101212', '2025-12-22 10:12:15', 45),
('DoctrineMigrations\\Version20251222192843', '2025-12-22 19:30:18', 38);

-- --------------------------------------------------------

--
-- Structure de la table `image`
--

CREATE TABLE `image` (
  `id` int NOT NULL,
  `produit_id` int NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `image`
--

INSERT INTO `image` (`id`, `produit_id`, `url`) VALUES
(9, 18, '6949ad04452a7.webp'),
(10, 18, '6949ad0447c41.webp'),
(11, 18, '6949ad0447e88.jpg'),
(12, 18, '6949ad0447fac.webp'),
(13, 18, '6949ad0448129.webp'),
(14, 19, '6949ad5c6f158.webp'),
(15, 19, '6949ad5c6f718.webp'),
(16, 19, '6949ad5c6f8ce.webp'),
(17, 19, '6949ad5c6fab1.jpg'),
(18, 19, '6949ad5c6fbdd.webp'),
(44, 24, '6949af1f63b63.jpg'),
(45, 24, '6949af1f63eb5.jpg'),
(46, 24, '6949af1f640c7.webp'),
(47, 24, '6949af1f642fb.webp'),
(48, 24, '6949af1f64498.webp'),
(53, 26, '6949b04c431bd.webp'),
(54, 26, '6949b04c43568.webp'),
(55, 27, '6949c10e7f02a.webp'),
(56, 27, '6949c10e7f503.webp'),
(57, 27, '6949c10e7f67c.webp'),
(58, 27, '6949c10e7f7cb.jpg'),
(59, 28, '6949c151158ea.webp'),
(64, 30, '6949c36778107.webp'),
(65, 30, '6949c36778496.webp'),
(66, 30, '6949c36778616.webp'),
(67, 30, '6949c3677882d.webp'),
(68, 31, '6949c3aee1708.webp'),
(69, 31, '6949c3aee19f6.webp'),
(70, 31, '6949c3aee1b23.webp'),
(71, 32, '6949c40270266.webp'),
(72, 32, '6949c4027063b.webp'),
(73, 32, '6949c402707f9.webp'),
(74, 33, '6949c46a4814a.webp'),
(75, 33, '6949c46a48b72.webp'),
(76, 33, '6949c46a48d1d.webp'),
(77, 33, '6949c46a49649.webp'),
(78, 34, '6949c4b6434a6.webp'),
(79, 34, '6949c4b64385c.webp'),
(80, 34, '6949c4b643a0e.webp');

-- --------------------------------------------------------

--
-- Structure de la table `messenger_messages`
--

CREATE TABLE `messenger_messages` (
  `id` bigint NOT NULL,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `available_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `delivered_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `pantalon`
--

CREATE TABLE `pantalon` (
  `id` int NOT NULL,
  `taille` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `pantalon`
--

INSERT INTO `pantalon` (`id`, `taille`) VALUES
(18, 40),
(19, 40),
(24, 40);

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

CREATE TABLE `produit` (
  `id` int NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prix` double NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `marque` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stock` int NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `produit`
--

INSERT INTO `produit` (`id`, `nom`, `prix`, `type`, `marque`, `description`, `stock`, `status`) VALUES
(18, 'BLACK STARS DENIM', 89.95, 'pantalon', 'DIVIN BY DIVIN', 'Loose-fit 100% Cotton Denim material Logos embroidery Embroidery patch Color :  BLACK', 48, 'Disponible'),
(19, 'SIX STARS DENIM', 89.95, 'pantalon', 'DIVIN BY DIVIN', 'Loose-fit 100% Cotton Denim material Logos embroidery Embroidery', 50, 'Disponible'),
(24, 'BLUEBELL BLASON DENIM', 89.95, 'pantalon', 'DIVIN BY DIVIN', 'Loose-fit 100% Cotton Denim material Back stitching logo Front embroidery Ready to ship Worldwide shipping', 50, 'Disponible'),
(26, 'BLACK PUFF STARS HOODIES', 79.95, 'pull', 'DIVIN BY DIVIN', 'TRUE TO SIZE Heavy hoodie 80% Organic Cotton, 20% polyester 350 g/m²', 49, 'Disponible'),
(27, 'BLACK HILL HOODIE', 79.95, 'pull', 'DIVIN BY DIVIN', 'Heavy hoodie', 50, 'Disponible'),
(28, 'LILAC SHARP HOODIE', 84.95, 'pull', 'DIVIN BY DIVIN', 'Heavy hoodie 80% Organic Cotton, 20% polyester Color : LILAC / LIGHT BLUE BLACK CHENILLE EMBROIDERY', 50, 'Disponible'),
(30, 'GREY BEAST T-SHIRT', 44.95, 'tshirt', 'DIVIN BY DIVIN', 'MADE IN PORTUGAL PRINT : FRONT / BACK 280GMS SUPER HEAVY T-SHIRT COLOR : GREY TRUE TO SIZE ; SIZE-UP FOR OVERSIZED EFFECT Ready to ship Worldwide shipping', 50, 'Disponible'),
(31, '6STARS CHROMED T-SHIRT', 44.95, 'tshirt', 'DIVIN BY DIVIN', '100% Cotton 280 GSM Front and back print  Ready to ship Worldwide shipping', 50, 'Disponible'),
(32, 'WHITE BEAST T-SHIRT', 44.95, 'tshirt', 'DIVIN BY DIVIN', 'MADE IN PORTUGAL SCREEN PRINT  COLOR : WHITE TRUE TO SIZE ; SIZE-UP FOR OVERSIZED EFFECT Ready to ship Worldwide shipping', 50, 'Disponible'),
(33, 'BLACK DENIM JORT', 69.95, 'short', 'DIVIN BY DIVIN', 'Loose-fit 100% Cotton Denim material Logos embroidery Embroidery patch Color :  BLACK', 50, 'Disponible'),
(34, 'BLACK SIX DENIM JORTS', 69.95, 'short', 'DIVIN BY DIVIN', 'Loose-fit 100% Cotton Denim material Logos embroidery Embroidery patch Color :  Black jean', 50, 'Disponible');

-- --------------------------------------------------------

--
-- Structure de la table `pull`
--

CREATE TABLE `pull` (
  `id` int NOT NULL,
  `taille` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `pull`
--

INSERT INTO `pull` (`id`, `taille`) VALUES
(26, 'M'),
(27, 'M'),
(28, 'M');

-- --------------------------------------------------------

--
-- Structure de la table `short`
--

CREATE TABLE `short` (
  `id` int NOT NULL,
  `taille` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `short`
--

INSERT INTO `short` (`id`, `taille`) VALUES
(33, 40),
(34, 40);

-- --------------------------------------------------------

--
-- Structure de la table `tshirt`
--

CREATE TABLE `tshirt` (
  `id` int NOT NULL,
  `taille` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tshirt`
--

INSERT INTO `tshirt` (`id`, `taille`) VALUES
(30, 'M'),
(31, 'M'),
(32, 'M');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int NOT NULL,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `email`, `roles`, `password`, `nom`, `prenom`) VALUES
(1, 'thibjant@gmail.com', '[\"ROLE_USER\", \"ROLE_ADMIN\"]', '$2y$13$K7E9Yg4HIKwAGBNqDx4GIO02qaxn04.06aSqLXCmH9uuLxFy0a6pa', 'JANTZEN', 'Thibaut'),
(2, 'mattheo55.b@gmail.com', '[]', '$2y$13$xk6HlVuRGjudLNrTXpgziOIjtIwOxwPc0hAH0sea0lnAU7skXsP76', 'Bigorgne', 'Matthéo'),
(5, 'admin@gmail.com', '[\"ROLE_USER\", \"ROLE_ADMIN\"]', '$2y$13$DK.S5fuIrbOB4YjpkQAXtuf5nh0o2jVt.XY4YnoNGO3Mg1c/S.x6K', 'admin', 'admin'),
(6, 'test@gmail.com', '[]', '$2y$13$/OyEz/8QcChul1RleT3ZeuwzGK8AfB.rvZYBuNalvYaLgVrcOqkS2', 'test', 'test');

-- --------------------------------------------------------

--
-- Structure de la table `user_adresse`
--

CREATE TABLE `user_adresse` (
  `user_id` int NOT NULL,
  `adresse_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user_adresse`
--

INSERT INTO `user_adresse` (`user_id`, `adresse_id`) VALUES
(1, 1);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `adresse`
--
ALTER TABLE `adresse`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `carte_credit`
--
ALTER TABLE `carte_credit`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_A250ECFA76ED395` (`user_id`);

--
-- Index pour la table `commande`
--
ALTER TABLE `commande`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_6EEAA67DA76ED395` (`user_id`),
  ADD KEY `IDX_6EEAA67DBE2F0A35` (`adresse_livraison_id`);

--
-- Index pour la table `commande_produit`
--
ALTER TABLE `commande_produit`
  ADD PRIMARY KEY (`commande_id`,`produit_id`),
  ADD KEY `IDX_DF1E9E8782EA2E54` (`commande_id`),
  ADD KEY `IDX_DF1E9E87F347EFB` (`produit_id`);

--
-- Index pour la table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Index pour la table `image`
--
ALTER TABLE `image`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_C53D045FF347EFB` (`produit_id`);

--
-- Index pour la table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  ADD KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  ADD KEY `IDX_75EA56E016BA31DB` (`delivered_at`);

--
-- Index pour la table `pantalon`
--
ALTER TABLE `pantalon`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `produit`
--
ALTER TABLE `produit`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `pull`
--
ALTER TABLE `pull`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `short`
--
ALTER TABLE `short`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `tshirt`
--
ALTER TABLE `tshirt`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_IDENTIFIER_EMAIL` (`email`);

--
-- Index pour la table `user_adresse`
--
ALTER TABLE `user_adresse`
  ADD PRIMARY KEY (`user_id`,`adresse_id`),
  ADD KEY `IDX_9B52161CA76ED395` (`user_id`),
  ADD KEY `IDX_9B52161C4DE7DC5C` (`adresse_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `adresse`
--
ALTER TABLE `adresse`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `carte_credit`
--
ALTER TABLE `carte_credit`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `commande`
--
ALTER TABLE `commande`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `image`
--
ALTER TABLE `image`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT pour la table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `produit`
--
ALTER TABLE `produit`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `carte_credit`
--
ALTER TABLE `carte_credit`
  ADD CONSTRAINT `FK_A250ECFA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `commande`
--
ALTER TABLE `commande`
  ADD CONSTRAINT `FK_6EEAA67DA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_6EEAA67DBE2F0A35` FOREIGN KEY (`adresse_livraison_id`) REFERENCES `adresse` (`id`);

--
-- Contraintes pour la table `commande_produit`
--
ALTER TABLE `commande_produit`
  ADD CONSTRAINT `FK_DF1E9E8782EA2E54` FOREIGN KEY (`commande_id`) REFERENCES `commande` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_DF1E9E87F347EFB` FOREIGN KEY (`produit_id`) REFERENCES `produit` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `image`
--
ALTER TABLE `image`
  ADD CONSTRAINT `FK_C53D045FF347EFB` FOREIGN KEY (`produit_id`) REFERENCES `produit` (`id`);

--
-- Contraintes pour la table `pantalon`
--
ALTER TABLE `pantalon`
  ADD CONSTRAINT `FK_5027B898BF396750` FOREIGN KEY (`id`) REFERENCES `produit` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `pull`
--
ALTER TABLE `pull`
  ADD CONSTRAINT `FK_950DDCE3BF396750` FOREIGN KEY (`id`) REFERENCES `produit` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `short`
--
ALTER TABLE `short`
  ADD CONSTRAINT `FK_8F2890A2BF396750` FOREIGN KEY (`id`) REFERENCES `produit` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `tshirt`
--
ALTER TABLE `tshirt`
  ADD CONSTRAINT `FK_6CF6F579BF396750` FOREIGN KEY (`id`) REFERENCES `produit` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `user_adresse`
--
ALTER TABLE `user_adresse`
  ADD CONSTRAINT `FK_9B52161C4DE7DC5C` FOREIGN KEY (`adresse_id`) REFERENCES `adresse` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_9B52161CA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
