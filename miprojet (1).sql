-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 14 août 2024 à 13:55
-- Version du serveur : 8.3.0
-- Version de PHP : 8.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `miprojet`
--

-- --------------------------------------------------------

--
-- Structure de la table `cas_de_location`
--

DROP TABLE IF EXISTS `cas_de_location`;
CREATE TABLE IF NOT EXISTS `cas_de_location` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `nom_bailleur` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adresse_bailleur` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom_preneur` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adresse_de_preneur` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `duree_bailleur` int NOT NULL,
  `date_debut` date NOT NULL,
  `date_fin` date NOT NULL,
  `nom_du_signateur` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_du_signateur` date NOT NULL,
  `signataire` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_9D07659EA76ED395` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `categorie_classement`
--

DROP TABLE IF EXISTS `categorie_classement`;
CREATE TABLE IF NOT EXISTS `categorie_classement` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `ravinala_selection` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `etoile_selection` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_CB2757C1A76ED395` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `categorie_classement`
--

INSERT INTO `categorie_classement` (`id`, `user_id`, `ravinala_selection`, `etoile_selection`) VALUES
(1, 2, 'Ravinala 2', 'Étoile 2');

-- --------------------------------------------------------

--
-- Structure de la table `designation_construction`
--

DROP TABLE IF EXISTS `designation_construction`;
CREATE TABLE IF NOT EXISTS `designation_construction` (
  `id` int NOT NULL AUTO_INCREMENT,
  `designation` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `designation_construction`
--

INSERT INTO `designation_construction` (`id`, `designation`) VALUES
(1, 'En bloc R'),
(2, 'Pavillonnaire'),
(3, 'Appartement'),
(4, 'Bingalow');

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20240814132351', '2024-08-14 13:23:59', 998);

-- --------------------------------------------------------

--
-- Structure de la table `environnement`
--

DROP TABLE IF EXISTS `environnement`;
CREATE TABLE IF NOT EXISTS `environnement` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `nom_site` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `distance` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `est` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `observation` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_A2D30A21A76ED395` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `environnement`
--

INSERT INTO `environnement` (`id`, `user_id`, `nom_site`, `distance`, `est`, `observation`) VALUES
(1, 2, 'site', '100', 'rien', 'rien');

-- --------------------------------------------------------

--
-- Structure de la table `lieu_implantation`
--

DROP TABLE IF EXISTS `lieu_implantation`;
CREATE TABLE IF NOT EXISTS `lieu_implantation` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `adresse` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `commune` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fivondronana` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `region` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `faritany` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_801F89D5A76ED395` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `lieu_implantation`
--

INSERT INTO `lieu_implantation` (`id`, `user_id`, `adresse`, `commune`, `fivondronana`, `region`, `faritany`) VALUES
(1, 2, 'adresse', 'commune', 'fivondronana', 'region', 'faritany');

-- --------------------------------------------------------

--
-- Structure de la table `messenger_messages`
--

DROP TABLE IF EXISTS `messenger_messages`;
CREATE TABLE IF NOT EXISTS `messenger_messages` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `available_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `delivered_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  KEY `IDX_75EA56E016BA31DB` (`delivered_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `nature_ouvrage`
--

DROP TABLE IF EXISTS `nature_ouvrage`;
CREATE TABLE IF NOT EXISTS `nature_ouvrage` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nature_ouvrage` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `nature_projet`
--

DROP TABLE IF EXISTS `nature_projet`;
CREATE TABLE IF NOT EXISTS `nature_projet` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `nature` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_64193E7EA76ED395` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `nature_projet`
--

INSERT INTO `nature_projet` (`id`, `user_id`, `nature`) VALUES
(1, 2, 'Nouvelle construction');

-- --------------------------------------------------------

--
-- Structure de la table `plan_masse`
--

DROP TABLE IF EXISTS `plan_masse`;
CREATE TABLE IF NOT EXISTS `plan_masse` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `plan_masse` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `plan_esquisse` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `plan_immatriculation` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `plan_assainissement` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `certificat_situation_juridique_terrain` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_18C1F890A76ED395` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `plan_masse`
--

INSERT INTO `plan_masse` (`id`, `user_id`, `plan_masse`, `plan_esquisse`, `plan_immatriculation`, `plan_assainissement`, `certificat_situation_juridique_terrain`) VALUES
(1, 2, '66bcb6fb77bc8.jpg', '66bcb6fb78bbd.jpg', '66bcb6fb7a10c.jpg', '66bcb6fb7b29a.jpg', '66bcb6fb7c13f.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `type_activite`
--

DROP TABLE IF EXISTS `type_activite`;
CREATE TABLE IF NOT EXISTS `type_activite` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `nature_activite` json NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_758A72E9A76ED395` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `type_activite`
--

INSERT INTO `type_activite` (`id`, `user_id`, `nature_activite`) VALUES
(1, 2, '[\"Location\", \"Autre\"]');

-- --------------------------------------------------------

--
-- Structure de la table `type_construction`
--

DROP TABLE IF EXISTS `type_construction`;
CREATE TABLE IF NOT EXISTS `type_construction` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_5BD2586BA76ED395` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `type_construction`
--

INSERT INTO `type_construction` (`id`, `user_id`) VALUES
(1, 2);

-- --------------------------------------------------------

--
-- Structure de la table `type_construction_detail`
--

DROP TABLE IF EXISTS `type_construction_detail`;
CREATE TABLE IF NOT EXISTS `type_construction_detail` (
  `id` int NOT NULL AUTO_INCREMENT,
  `type_construction_id` int NOT NULL,
  `designation` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `unite` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nombre` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_5160AE0F387C850E` (`type_construction_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `type_construction_detail`
--

INSERT INTO `type_construction_detail` (`id`, `type_construction_id`, `designation`, `unite`, `nombre`) VALUES
(1, 1, 'En bloc R', '2', 3),
(2, 1, 'Pavillonnaire', '4', 5),
(3, 1, 'Appartement', '6', 7),
(4, 1, 'Bingalow', '8', 9);

-- --------------------------------------------------------

--
-- Structure de la table `type_etablissement`
--

DROP TABLE IF EXISTS `type_etablissement`;
CREATE TABLE IF NOT EXISTS `type_etablissement` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `nature` json NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_5010EE19A76ED395` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `type_etablissement`
--

INSERT INTO `type_etablissement` (`id`, `user_id`, `nature`) VALUES
(1, 2, '[\"Hotel_Restaurant\", \"Terrain Camping\"]');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenoms` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `entreprise` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `responsable` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ville` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adresse` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telephone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_verified` tinyint(1) NOT NULL,
  `verification_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `email`, `password`, `nom`, `prenoms`, `entreprise`, `responsable`, `ville`, `adresse`, `telephone`, `image`, `is_verified`, `verification_token`) VALUES
(2, 'mioratianalinah17@gmail.com', '$2y$13$wrVPJkelkpVi5BAJVWBECOYqkn4MEo1CeTEIvvRaPDQKzQu19gXOG', 'miora', 'mi', 'entreprise_b', 'responsable_a', 'ambato', 'ambato', '0333', NULL, 1, NULL);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `cas_de_location`
--
ALTER TABLE `cas_de_location`
  ADD CONSTRAINT `FK_9D07659EA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `categorie_classement`
--
ALTER TABLE `categorie_classement`
  ADD CONSTRAINT `FK_CB2757C1A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `environnement`
--
ALTER TABLE `environnement`
  ADD CONSTRAINT `FK_A2D30A21A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `lieu_implantation`
--
ALTER TABLE `lieu_implantation`
  ADD CONSTRAINT `FK_801F89D5A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `nature_projet`
--
ALTER TABLE `nature_projet`
  ADD CONSTRAINT `FK_64193E7EA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `plan_masse`
--
ALTER TABLE `plan_masse`
  ADD CONSTRAINT `FK_18C1F890A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `type_activite`
--
ALTER TABLE `type_activite`
  ADD CONSTRAINT `FK_758A72E9A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `type_construction`
--
ALTER TABLE `type_construction`
  ADD CONSTRAINT `FK_5BD2586BA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `type_construction_detail`
--
ALTER TABLE `type_construction_detail`
  ADD CONSTRAINT `FK_5160AE0F387C850E` FOREIGN KEY (`type_construction_id`) REFERENCES `type_construction` (`id`);

--
-- Contraintes pour la table `type_etablissement`
--
ALTER TABLE `type_etablissement`
  ADD CONSTRAINT `FK_5010EE19A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
