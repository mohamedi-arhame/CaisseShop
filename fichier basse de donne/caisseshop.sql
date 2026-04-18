-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 14 avr. 2026 à 12:16
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `caisseshop`
--

-- --------------------------------------------------------

--
-- Structure de la table `produits`
--

CREATE TABLE `produits` (
  `id_produit` int(11) NOT NULL,
  `reference` varchar(8) DEFAULT NULL,
  `nom_produit` varchar(30) NOT NULL,
  `prix` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `produits`
--

INSERT INTO `produits` (`id_produit`, `reference`, `nom_produit`, `prix`, `stock`) VALUES
(1, 'REF001', 'Coca-Cola 1L', 1.50, 99),
(2, 'REF002', 'Pepsi 1L', 1.40, 79),
(3, 'REF003', 'Eau Minérale 1.5L', 0.80, 149),
(4, 'REF004', 'Jus d\'orange 1L', 2.20, 59),
(5, 'REF005', 'Red Bull 25cl', 2.50, 49),
(6, 'REF006', 'Chips Paprika', 2.00, 68),
(7, 'REF007', 'Chips Nature', 1.80, 88),
(11, 'REF011', 'Pommes 1kg', 3.00, 44),
(12, 'REF012', 'Oranges 1kg', 2.80, 39),
(15, 'REF015', 'Beurre 250g', 2.30, 55),
(17, 'REF017', 'Fromage Emmental 200g', 3.20, 29),
(18, 'REF018', 'Pâtes 500g', 1.00, 199),
(19, 'REF019', 'Riz 1kg', 1.80, 149),
(20, 'REF020', 'Sucre 1kg', 1.50, 99),
(21, 'REF021', 'Farine 1kg', 1.20, 89),
(22, 'REF022', 'Savon', 1.00, 69),
(23, 'REF023', 'Shampoing', 3.50, 39),
(24, 'REF024', 'Dentifrice', 2.80, 49),
(25, 'REF025', 'Sac plastique', 0.10, 497),
(26, 'REF026', 'Briquet', 1.20, 59),
(29, 'rttgff', 'fbb', 20.00, 11);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `id_user` int(11) NOT NULL,
  `nom_utilisateur` varchar(50) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id_user`, `nom_utilisateur`, `mot_de_passe`, `email`) VALUES
(2, 'arhame', '$2y$10$wGqNQ/LaQ.YTJy2PDo.3lurLRo9rHb7blqgSWYqbkC8MCLgBcXBna', 'mohamediarhame@gmail.com');

-- --------------------------------------------------------

--
-- Structure de la table `ventes`
--

CREATE TABLE `ventes` (
  `id_vente` int(11) NOT NULL,
  `date_vente` datetime NOT NULL,
  `id_user` int(11) NOT NULL,
  `montant_total` decimal(10,2) NOT NULL,
  `nb_articles` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `ventes`
--

INSERT INTO `ventes` (`id_vente`, `date_vente`, `id_user`, `montant_total`, `nb_articles`) VALUES
(1, '2026-04-13 19:54:51', 2, 2.30, 1),
(2, '2026-04-14 10:57:34', 2, 0.10, 1),
(3, '2026-04-14 10:57:34', 2, 0.10, 1),
(4, '2026-04-14 10:58:10', 2, 54.10, 19),
(5, '2026-04-14 11:09:27', 2, 11.50, 5),
(6, '2026-04-14 11:15:47', 2, 2.30, 1),
(7, '2026-04-14 11:18:21', 2, 5.00, 3);

-- --------------------------------------------------------

--
-- Structure de la table `ventes_details`
--

CREATE TABLE `ventes_details` (
  `id_detail` int(11) NOT NULL,
  `id_vente` int(11) NOT NULL,
  `id_produit` int(11) NOT NULL,
  `quantite` int(11) NOT NULL,
  `prix_unitaire` decimal(10,2) NOT NULL,
  `total_ligne` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `ventes_details`
--

INSERT INTO `ventes_details` (`id_detail`, `id_vente`, `id_produit`, `quantite`, `prix_unitaire`, `total_ligne`) VALUES
(1, 1, 15, 1, 2.30, 2.30),
(2, 2, 25, 1, 0.10, 0.10),
(3, 3, 25, 1, 0.10, 0.10),
(4, 4, 23, 1, 3.50, 3.50),
(5, 4, 25, 1, 0.10, 0.10),
(6, 4, 19, 1, 1.80, 1.80),
(7, 4, 22, 1, 1.00, 1.00),
(8, 4, 20, 1, 1.50, 1.50),
(9, 4, 11, 1, 3.00, 3.00),
(10, 4, 5, 1, 2.50, 2.50),
(11, 4, 2, 1, 1.40, 1.40),
(12, 4, 18, 1, 1.00, 1.00),
(13, 4, 4, 1, 2.20, 2.20),
(14, 4, 12, 1, 2.80, 2.80),
(15, 4, 17, 1, 3.20, 3.20),
(16, 4, 29, 1, 20.00, 20.00),
(17, 4, 3, 1, 0.80, 0.80),
(18, 4, 21, 1, 1.20, 1.20),
(19, 4, 24, 1, 2.80, 2.80),
(20, 4, 1, 1, 1.50, 1.50),
(21, 4, 7, 1, 1.80, 1.80),
(22, 4, 6, 1, 2.00, 2.00),
(23, 5, 15, 5, 2.30, 11.50),
(24, 6, 15, 1, 2.30, 2.30),
(25, 7, 26, 1, 1.20, 1.20),
(26, 7, 6, 1, 2.00, 2.00),
(27, 7, 7, 1, 1.80, 1.80);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `produits`
--
ALTER TABLE `produits`
  ADD PRIMARY KEY (`id_produit`),
  ADD UNIQUE KEY `reference` (`reference`);

--
-- Index pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`id_user`);

--
-- Index pour la table `ventes`
--
ALTER TABLE `ventes`
  ADD PRIMARY KEY (`id_vente`),
  ADD KEY `id_user` (`id_user`);

--
-- Index pour la table `ventes_details`
--
ALTER TABLE `ventes_details`
  ADD PRIMARY KEY (`id_detail`),
  ADD KEY `id_vente` (`id_vente`),
  ADD KEY `id_produit` (`id_produit`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `produits`
--
ALTER TABLE `produits`
  MODIFY `id_produit` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `ventes`
--
ALTER TABLE `ventes`
  MODIFY `id_vente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `ventes_details`
--
ALTER TABLE `ventes_details`
  MODIFY `id_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `ventes`
--
ALTER TABLE `ventes`
  ADD CONSTRAINT `ventes_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `utilisateurs` (`id_user`);

--
-- Contraintes pour la table `ventes_details`
--
ALTER TABLE `ventes_details`
  ADD CONSTRAINT `ventes_details_ibfk_1` FOREIGN KEY (`id_vente`) REFERENCES `ventes` (`id_vente`),
  ADD CONSTRAINT `ventes_details_ibfk_2` FOREIGN KEY (`id_produit`) REFERENCES `produits` (`id_produit`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
