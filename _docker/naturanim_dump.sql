-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : mer. 25 nov. 2026 à 16:01
-- Version du serveur : 10.6.23-MariaDB-0ubuntu0.22.04.1
-- Version de PHP : 8.4.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `lalu6135_lucaslapl`
--

-- --------------------------------------------------------

--
-- Structure de la table `lepido`
--

CREATE TABLE `lepido` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `nom_latin` varchar(255) NOT NULL,
  `famille` varchar(255) NOT NULL,
  `repartition` text NOT NULL,
  `description` text NOT NULL,
  `premiere_obs` date DEFAULT NULL,
  `lien_inpn` varchar(255) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `image_path_min` varchar(255) NOT NULL,
  `date_obs` date DEFAULT NULL,
  `lieu_obs` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `lepido`
--

INSERT INTO `lepido` (`id`, `nom`, `nom_latin`, `famille`, `repartition`, `description`, `premiere_obs`, `lien_inpn`, `image_path`, `image_path_min`, `date_obs`, `lieu_obs`) VALUES
(1, 'Le Citron', 'Gonepteryx rhamni', 'Papilionidé', 'Observable sur tout le territoire métropolitain.', '', '2022-07-02', 'https://inpn.mnhn.fr/espece/cd_nom/54417', '_photos/1732182314_IMG_7987.jpg', '_photos/1732182314_IMG_7987-Export thumbnail-1.jpg', '2022-07-02', 'Forêt de Gralas, Les Brouzils'),
(2, 'L&#039;Amaryllis', 'Pyronia tithonus', 'Nymphalidé', 'Observable sur tout le territoire métropolitain.', '', '2022-07-15', 'https://inpn.mnhn.fr/espece/cd_nom/608405', '_photos/1732203901_IMG_7996.jpg', '_photos/1732203901_IMG_7996-Export thumbnail-1.jpg', '2022-07-15', 'n/c'),
(3, 'L&#039;Aurore', 'Anthocharis cardamines', 'Piéridé', 'Observable surtout le territoire métropolitain.', '', '2023-04-09', 'https://inpn.mnhn.fr/espece/cd_nom/54451', '_photos/1732204861_IMG_1594.jpg', '_photos/1732204861_IMG_1594-Export thumbnail-1.jpg', '2023-04-09', 'Dompierre-sur-Yon'),
(4, 'Azuré de la Bugrane', 'Polyommatus icarus', 'Lycénidé', 'Observable sur tout le territoire métropolitain.', '', '2022-05-17', 'https://inpn.mnhn.fr/espece/cd_nom/54279', '_photos/1732205252_IMG_7859.jpg', '_photos/1732205252_IMG_7859-Export thumbnail-1.jpg', '2022-06-28', 'Dompierre-sur-Yon'),
(5, 'Azuré des Nerpruns', 'Celastrina argiolus', 'Lycénidé', 'Observable sur tout le territoire métropolitain.', '', '2022-06-07', 'https://inpn.mnhn.fr/espece/cd_nom/54052', '_photos/1732205564_IMG_7045.jpg', '_photos/1732205564_IMG_7045-Export thumbnail-1.jpg', '2022-06-07', 'Dompierre-sur-Yon'),
(6, 'Le Cardinal', 'Argynnis pandora', 'Nymphalidé', 'Observable sur la côté atlantique du Morbihan jusqu&#039;en Charente-Maritime. Aussi sur toute la côte méditerranéenne.', '', '2023-05-19', 'https://inpn.mnhn.fr/espece/cd_nom/219819', '_photos/1732206336_IMG_3526.jpg', '_photos/1732206336_IMG_3526-Export thumbnail-1.jpg', '2023-05-19', 'Pointe du Payré, Jard-sur-Mer'),
(7, 'La Carte Géographique', 'Araschnia levana', 'Nymphalidé', 'Observable sur tout le territoire métropolitain à l&#039;exception de la côte méditerranéenne.', '', '2022-04-28', 'https://inpn.mnhn.fr/espece/cd_nom/219819', '_photos/1732206592_IMG_6641.jpg', '_photos/1732206592_IMG_6641-Export thumbnail-1.jpg', '2022-04-28', 'Dompierre-sur-Yon'),
(8, 'Cuivré commun', 'Lycaena phlaeas', 'Lycénidé', 'Observable sur tout le territoire métropolitain.', '', '2022-04-27', 'https://inpn.mnhn.fr/espece/cd_nom/53973', '_photos/1732207423_IMG_6549.jpg', '_photos/1732207423_IMG_6549-Export thumbnail-1.jpg', '2022-04-27', 'Dompierre-sur-Yon'),
(9, 'Cuivré fuligineux', 'Lycaena tityrus', 'Lycénidé', 'Observable sur tout le territoire métropolitain à l&#039;exception de l&#039;extrême nord et l&#039;extrême sud du pays.', '', '2022-04-28', 'https://inpn.mnhn.fr/espece/cd_nom/219751', '_photos/1732207906_IMG_6619.jpg', '_photos/1732207906_IMG_6619-Export thumbnail-1.jpg', '2022-04-28', 'Dompierre-sur-Yon'),
(10, 'Le Demi-deuil', 'Melanargia galathea', 'Nymphalidé', 'Observable sur tout le territoire métropolitain. (sauf Corse)', '', '2022-06-07', 'https://inpn.mnhn.fr/espece/cd_nom/53700', '_photos/1732208133_IMG_6909.jpg', '_photos/1732208133_IMG_6909-Export thumbnail-1.jpg', '2022-06-07', 'Dompierre-sur-Yon'),
(11, 'Fadet commun', 'Coenonympha pamphilus', 'Nymphalidé', 'Observable sur tout le territoire métropolitain.', '', '2022-04-26', 'https://inpn.mnhn.fr/espece/cd_nom/53623', '_photos/1732208477_IMG_2300.jpg', '_photos/1732208477_IMG_2300-Export thumbnail-1.jpg', '2022-04-26', 'Dompierre-sur-Yon'),
(12, 'Le Gazé', 'Aporia crataegi', 'Piéridé', 'Observable sur tout le territoire métropolitain.', '', '2022-05-17', 'https://inpn.mnhn.fr/espece/cd_nom/54339', '_photos/1732208987_IMG_2380-2.jpg', '_photos/1732208987_IMG_2380-Export thumbnail-1.jpg', '2022-05-17', 'Réserva Naturelle Régionale du Marais de la Vacherie, Champagné-les-Marais'),
(13, 'Hespérie de la Houque', 'Thymelicus sylvestris', 'Hespéridé', 'Observable sur tout le territoire métropolitain (sauf Corse).', '', '2022-06-07', 'https://inpn.mnhn.fr/espece/cd_nom/219742', '_photos/1732209288_IMG_7215.jpg', '_photos/1732209288_IMG_7215-Export thumbnail-1.jpg', '2022-06-07', 'Dompierre-sur-Yon'),
(14, 'Hespérie des Potentilles', 'Pyrgus armoricanus', 'Hespéridé', '', '', '2022-09-16', 'https://inpn.mnhn.fr/espece/cd_nom/53236', '_photos/1732209871_IMG_8990.jpg', '_photos/1732209871_IMG_8990-Export thumbnail-1.jpg', '2022-09-16', 'Réserva Naturelle Régionale du Marais de la Vacherie, Champagné-les-Marais'),
(15, 'La Mégère', 'Lasiommata megera', 'Nymphalidé', 'Observable sur tout le territoire métropolitain (sauf Corse).', '', '2021-09-13', 'https://inpn.mnhn.fr/espece/cd_nom/53604', '_photos/1732210465_IMG_3135.jpg', '_photos/1732210465_IMG_3135-Export thumbnail-1.jpg', '2021-09-13', 'Lac de Grand-Lieu'),
(16, 'Mélitée des Centaurées', 'Melitaea phoebe', 'Nymphalidé', 'Semble être rare voire absent de la moitié nord de la métropole.', '', '2022-08-01', 'https://inpn.mnhn.fr/espece/cd_nom/53811', '_photos/1733215668_IMG_8125.jpg', '_photos/1733215668_IMG_8125-2.jpg', '2022-08-02', 'Dompierre-sur-Yon'),
(17, 'Mélitée du Plantain', 'Melitaea cinxia', 'Nymphalidé', 'Observable sur tout le territoire métropolitain à l&#039;exception du Nord du pays.', '', '2022-08-02', 'https://inpn.mnhn.fr/espece/cd_nom/53817', '_photos/1733216640_IMG_8189-2.jpg', '_photos/1733216640_IMG_8189.jpg', '2022-08-02', 'Dompierre-sur-Yon'),
(18, 'Le Myrtil', 'Maniola jurtina', 'Nymphalidé', 'Observable sur tout le territoire métropolitain.', '', '2022-05-24', 'https://inpn.mnhn.fr/espece/cd_nom/53668', '_photos/1733216863_IMG_2422-2.jpg', '_photos/1733216863_IMG_2422.jpg', '2022-05-24', 'Dompierre-sur-Yon'),
(19, 'Le Paon-du-jour', 'Aglais io', 'Nymphalidé', 'Observable sur tout le territoire métropolitain.', '', '2022-06-07', 'https://inpn.mnhn.fr/espece/cd_nom/608364', '_photos/1733217360_IMG_7523-2.jpg', '_photos/1733217360_IMG_7523.jpg', '2022-06-13', 'Dompierre-sur-Yon'),
(20, 'Le Petit Sylvain', 'Limenitis camilla', 'Nymphalidé', 'Observable sur tout le territoire métropolitain à l&#039;exception de la côte méditerranéenne.', '', '2022-07-02', 'https://inpn.mnhn.fr/espece/cd_nom/53770', '_photos/1733217671_IMG_7882-2.jpg', '_photos/1733217671_IMG_7882.jpg', '2022-07-02', 'Forêt de Gralas, Les Brouzils'),
(21, 'La Petite Violette', 'Boloria dia', 'Nymphalidé', 'Observable sur tout le territoire métropolitain à l&#039;exception du nord breton et normand.', '', '2023-04-19', 'https://inpn.mnhn.fr/espece/cd_nom/219818', '_photos/1733218847_IMG_1951-4.jpg', '_photos/1733218847_IMG_1951-3.jpg', '2023-04-19', 'Parc Naturel Régional de la Brenne'),
(22, 'Piéride de la Rave', 'Pieris rapae', 'Piéridé', 'Observable sur tout le territoire métropolitain.', '', '2022-04-27', 'https://inpn.mnhn.fr/espece/cd_nom/219831', '_photos/1733219095_IMG_6529-2.jpg', '_photos/1733219095_IMG_6529.jpg', '2022-04-27', 'Dompierre-sur-Yon'),
(23, 'Piéride du Chou', 'Pieris brassicae', 'Piéridé', 'Observable sur tout le territoire métropolitain.', '', '2021-09-13', 'https://inpn.mnhn.fr/espece/cd_nom/54342', '_photos/1733219378_IMG_7765-2.jpg', '_photos/1733219378_IMG_7765.jpg', '2022-06-23', 'Dompierre-sur-Yon'),
(24, 'Piéride du Navet', 'Pieris napi', 'Piéridé', 'Observable sur tout le territoire métropolitain.', '', '2022-04-28', 'https://inpn.mnhn.fr/espece/cd_nom/219833', '_photos/1733219639_IMG_6587-2.jpg', '_photos/1733219639_IMG_6587.jpg', '2022-04-28', 'Dompierre-sur-Yon'),
(25, 'Le Point-de-Hongrie', 'Erynnis tages', 'Hespéridé', 'Observable sur tout le territoire métropolitain.', '', '2022-04-25', 'https://inpn.mnhn.fr/espece/cd_nom/53307', '_photos/1733220014_IMG_2297-3.jpg', '_photos/1733220014_IMG_2297-2.jpg', '2022-04-26', 'Dompierre-sur-Yon'),
(26, 'Le Robert-le-Diable', 'Polygonia c-album', 'Nymphalidé', 'Observable sur tout le territoire métropolitain.', '', '2022-06-13', 'https://inpn.mnhn.fr/espece/cd_nom/53759', '_photos/1733220230_IMG_7403-2.jpg', '_photos/1733220230_IMG_7403.jpg', '2022-06-13', 'Dompierre-sur-Yon'),
(27, 'Le Souci', 'Colias crocea', 'Papilionidé', 'Observable sur tout le territoire métropolitain.', '', '2022-08-04', 'https://inpn.mnhn.fr/espece/cd_nom/641941', '_photos/1733220499_IMG_8219-2.jpg', '_photos/1733220499_IMG_8219.jpg', '2022-08-04', 'Dompierre-sur-Yon'),
(28, 'La Sylvaine', 'Ochlodes sylvanus', 'Hespéridé', 'Observable sur tout le territoire métropolitain.', '', '2022-06-20', 'https://inpn.mnhn.fr/espece/cd_nom/219740', '_photos/1733220763_IMG_7606-2.jpg', '_photos/1733220763_IMG_7606.jpg', '2022-06-20', 'Dompierre-sur-Yon'),
(29, 'Thécla de la Ronce', 'Callophrys rubi', 'Lycénidé', 'Observable sur tout le territoire métropolitain.', '', '2022-04-28', 'https://inpn.mnhn.fr/espece/cd_nom/54307', '_photos/1733221090_IMG_3269-3.jpg', '_photos/1733221090_IMG_3269-2.jpg', '2023-05-17', 'Les Sables-d&#039;Olonne'),
(30, 'Thécla du Bouleau', 'Thecla betulae', 'Lycénidé', 'Observable sur tout le territoire métropolitain.', '', '2022-08-08', 'https://inpn.mnhn.fr/espece/cd_nom/54319', '_photos/1733221349_IMG_8568-2.jpg', '_photos/1733221349_IMG_8568.jpg', '2022-08-08', 'Dompierre-sur-Yon'),
(31, 'Thécla du Chêne', 'Quercusia quercus', 'Lycénidé', 'Observable sur tout le territoire métropolitain.', '', '2022-06-28', 'https://inpn.mnhn.fr/espece/cd_nom/54322', '_photos/1733221505_IMG_7780-2.jpg', '_photos/1733221505_IMG_7780.jpg', '2022-06-28', 'Dompierre-sur-Yon'),
(32, 'Le Tircis', 'Pararge aegeria', 'Nymphalidé', 'Observable sur tout le territoire métropolitain.', '', '2021-09-14', 'https://inpn.mnhn.fr/espece/cd_nom/53595', '_photos/1733221717_IMG_7569-2.jpg', '_photos/1733221717_IMG_7569.jpg', '2022-06-20', 'Dompierre-sur-Yon'),
(33, 'Le Vulcain', 'Vanessa atalanta', 'Nymphalidé', 'Observable sur tout le territoire métropolitain.', '', '2022-04-27', 'https://inpn.mnhn.fr/espece/cd_nom/53741', '_photos/1733221845_IMG_6491-2.jpg', '_photos/1733221845_IMG_6491.jpg', '2022-04-27', 'Dompierre-sur-Yon'),
(34, 'Moiré lustré', 'Erebia cassioides', 'Nymphalidé', 'Alpes, Pyrénées, Massif central.', '', '2024-08-01', 'https://inpn.mnhn.fr/espece/cd_nom/219802', '_photos/1733223643_IMG_5120-2.jpg', '_photos/1733223643_IMG_5120.jpg', '2024-08-01', 'La Rosière, Montvalezan'),
(35, 'Le Machaon', 'Papilio machaon', 'Papilionidé', 'Observable sur tout le territoire métropolitain.', '', '2024-08-01', 'https://inpn.mnhn.fr/espece/cd_nom/54468', '_photos/1733223928_IMG_5165-2.jpg', '_photos/1733223928_IMG_5165.jpg', '2024-08-02', 'La Rosière, Montvalezan'),
(36, 'Sablé du Sainfoin', 'Polyommatus damon', 'Lycénidé', 'Espèce montagnarde. Alpes, Pyrénées, Massif central.', '', '2024-08-02', 'https://inpn.mnhn.fr/espece/cd_nom/219773', '_photos/1733224402_IMG_5222-2.jpg', '_photos/1733224402_IMG_5222.jpg', '2024-08-02', 'La Rosière, Montvalezan'),
(37, 'Hespérie du Dactyle', 'Thymelicus lineola', 'Hespéridé', 'Observable sur tout le territoire métropolitain.', '', '2024-08-02', 'https://inpn.mnhn.fr/espece/cd_nom/219741', '_photos/1733224619_IMG_5214-2.jpg', '_photos/1733224619_IMG_5214.jpg', '2024-08-02', 'La Rosière, Montvalezan'),
(38, 'Le Chiffre', 'Fabriciana niobe', 'Nymphalidé', 'Espèce montagnarde. Se retrouve sur presque toutes les altitudes supérieures à 300 mètres.', '', '2024-08-02', 'https://inpn.mnhn.fr/espece/cd_nom/53895', '_photos/1733225098_IMG_5203-2.jpg', '_photos/1733225098_IMG_5203.jpg', '2024-08-02', 'La Rosière, Montvalezan'),
(39, 'Le Grand Nacré', 'Speyeria aglaja', 'Nymphalidé', 'Observable sur tout le territoire métropolitain mais est une espèce plutôt collinéenne que l&#039;on ne retrouvera donc qu&#039;à partir d&#039;une certaine altitude.', '', '2024-08-02', 'https://inpn.mnhn.fr/espece/cd_nom/820680', '_photos/1733225949_IMG_5267-2.jpg', '_photos/1733225949_IMG_5267.jpg', '2024-08-02', 'La Rosière, Montvalezan'),
(40, 'Cuivré fuligineux (subalpinus)', 'Lycaena tityrus subalpina', 'Lycénidé', 'Sous-espèce seulement observable en altitude dans les Alpes.', '', '2024-08-02', 'https://inpn.mnhn.fr/espece/cd_nom/608291', '_photos/1733226939_IMG_5306-3.jpg', '_photos/1733226939_IMG_5306-2.jpg', '2024-08-02', 'La Rosière, Montvalezan'),
(41, 'Cuivré de la Verge d&#039;or', 'Lycaena virgaureae', 'Lycénidé', 'Espèce montagnarde. Alpes, Pyrénées, Massif central.', '', '2024-08-02', 'https://inpn.mnhn.fr/espece/cd_nom/219750', '_photos/1733227582_IMG_5330-2.jpg', '_photos/1733227582_IMG_5330.jpg', '2024-08-02', 'La Rosière, Montvalezan'),
(42, 'Mélitée noirâtre', 'Melitaea diamina', 'Nymphalidé', 'Espèce montagnarde, ne se retrouve qu&#039;en altitude.', '', '2024-08-03', 'https://inpn.mnhn.fr/espece/cd_nom/53821', '_photos/1733228707_IMG_5511-2.jpg', '_photos/1733228707_IMG_5511.jpg', '2024-08-03', 'La Rosière, Montvalezan'),
(43, 'Le Solitaire', 'Colias palaeno', 'Papilionidé', 'Alpes et Jura.', 'Espèce protégée sur tout le territoire métropolitain.', '2024-08-03', 'https://inpn.mnhn.fr/espece/cd_nom/54400', '_photos/1733245709_IMG_5530-2.jpg', '_photos/1733245709_IMG_5530.jpg', '2024-08-03', 'Autour du Lac Verney, La Thuile, Italie'),
(44, 'Hespérie de l&#039;Aigremoine (?)', 'Pyrgus malvoides', 'Hespéridé', 'Moitié nord de la France pour Pyrgus malvae moitié sud pour Pyrgus malvoides. Ces deux espèces sont sympatriques.', 'Du fait de la sympatrie des deux espèces, il est difficile de les identifier avec certitude sans étude des armatures génitales. La photo qui accompagne cet article a été prise dans la zone de sympatrie donc l&#039;identification de l&#039;espèce n&#039;est pas sûre.', '2024-08-03', 'https://inpn.mnhn.fr/espece/cd_nom/219744', '_photos/1733247629_IMG_5552-2.jpg', '_photos/1733247629_IMG_5552.jpg', '2024-08-03', 'Autour du Lac Verney, La Thuile, Italie'),
(45, 'Le Silène', 'Brintesia circe', 'Nymphalidé', 'Observable sur tout le territoire métropolitain à l&#039;exception de la Bretagne et de tout le nord de la France.', '', '2024-08-05', 'https://inpn.mnhn.fr/espece/cd_nom/53367', '_photos/1733248196_IMG_5596-2.jpg', '_photos/1733248196_IMG_5596.jpg', '2024-08-05', 'La Rosière, Montvalezan'),
(46, 'L&#039;Apollon', 'Parnassius apollo', 'Nymphalidé', 'Espèce montagnarde. Jura, Alpes, Massif Central, Pyrénées.', 'Espèce protégée et menacée à moyen terme par la déprise agropastorale et le réchauffement climatique.', '2024-08-05', 'https://inpn.mnhn.fr/espece/cd_nom/54496', '_photos/1733251729_IMG_5714-2.jpg', '_photos/1733251729_IMG_5714.jpg', '2024-08-05', 'La Rosière, Montvalezan'),
(47, 'Le Grand Collier argenté', 'Boloria euphrosyne', 'Nymphalidé', 'Espèce plutôt collinéenne que l&#039;on retrouve dans les hauteurs dès 300-400 mètres. ', '', '2024-08-06', 'https://inpn.mnhn.fr/espece/cd_nom/219815', '_photos/1733253583_IMG_5770-2.jpg', '_photos/1733253583_IMG_5770.jpg', '2024-08-06', 'La Rosière, Montvalezan'),
(48, 'Mélitée de Fruhstorfer', 'Melitaea nevadensis', 'Nymphalidé', 'Observable sur tout le sud-est de la France.', '', '2024-08-05', 'https://inpn.mnhn.fr/espece/cd_nom/608362', '_photos/1733325790_IMG_5665-2.jpg', '_photos/1733325790_IMG_5665.jpg', '2024-08-05', 'La Rosière, Montvalezan'),
(49, 'La Belle-Dame', 'Vanessa cardui', 'Nymphalidé', 'Observable sur tout le territoire métropolitain.', '', '2026-07-31', '', '_photos/1786107012_IMG_9367-naturefolio.jpg', '_photos/1786107012_IMG_9367-naturefoliothumb.jpg', '2026-07-31', 'Domaine Départemental de Trévarez, Finistère'),
(50, 'Tabac d&#039;Espagne', 'Argynnis paphia', 'Nymphalidé', 'Observable sur tout le territoire métropolitain.', '', '2026-07-31', '', '_photos/1786107109_IMG_9380-naturefolio.jpg', '_photos/1786107109_IMG_9380-naturefoliothumb.jpg', '2026-07-31', 'Domaine Départemental de Trévarez, Finistère');

-- --------------------------------------------------------

--
-- Structure de la table `oiseaux`
--

CREATE TABLE `oiseaux` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `nom_latin` varchar(255) NOT NULL,
  `famille` varchar(255) NOT NULL,
  `repartition` text NOT NULL,
  `description` text NOT NULL,
  `premiere_obs` date DEFAULT NULL,
  `lien_inpn` varchar(255) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `image_path_min` varchar(255) NOT NULL,
  `date_obs` date DEFAULT NULL,
  `lieu_obs` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `oiseaux`
--

INSERT INTO `oiseaux` (`id`, `nom`, `nom_latin`, `famille`, `repartition`, `description`, `premiere_obs`, `lien_inpn`, `image_path`, `image_path_min`, `date_obs`, `lieu_obs`) VALUES
(1, 'Pinson des arbres', 'Fringilla coelebs', 'Fringillidé', 'Présent sur tout le territoire métropolitain.', '', '2018-10-01', 'https://inpn.mnhn.fr/espece/cd_nom/4564', '_photos/1726772824_1644326324IMG_8174.jpg', '_photos/1726772824_1644326324IMG_8174-2.jpg', '2021-01-06', 'Fontenay-Trésigny'),
(2, 'Pigeon biset', 'Columba livia', 'Columbidé', 'Présente sur tout le territoire métropolitain.', '', '2019-01-10', 'https://inpn.mnhn.fr/espece/cd_nom/3420', '_photos/1726776063_1644274503IMG_3182.jpg', '_photos/1726776063_1644274503IMG_3182-2.jpg', '2019-01-10', 'Paris'),
(3, 'Corneille noire', 'Corvus corone', 'Corvidé', 'Présente sur tout le territoire métropolitain.', '', '2018-10-01', 'https://inpn.mnhn.fr/espece/cd_nom/4503', '_photos/1727343435_1644275283IMG_0287.jpg', '_photos/1727343435_1644275283IMG_0287-2.jpg', '2019-06-15', 'Parcs Zoologiques de Lumigny, Lumigny-Nesles-Ormeaux'),
(4, 'Corneille mantelée', 'Corvus corone cornix', 'Corvidé', 'Grande présence dans le nord de l&#039;Europe. En France, on peut la retrouver surtout sur la côte méditerranéenne et la Corse.', 'Elle a tendance à s&#039;hybrider avec la Corneille noire (Corvus corone).', '2019-08-07', 'https://inpn.mnhn.fr/espece/cd_nom/4505', '_photos/1727344203_1644315863IMG_8955.jpg', '_photos/1727344203_1644315863IMG_8955-2.jpg', '2019-08-07', 'Narvik, Norvège'),
(5, 'Huîtrier pie', 'Haematopus ostralegus', 'Hématopodidé', 'Présente sur toutes les côtes de France métropolitaine. De manière très occasionnelle près des grands fleuves et grands lacs.', '', '2019-08-07', 'https://inpn.mnhn.fr/espece/cd_nom/3106', '_photos/1727349093_1644316042IMG_8974.jpg', '_photos/1727349093_1644316042IMG_8974-2.jpg', '2019-08-07', 'Narvik, Norvège'),
(122, 'Petit Gravelot', 'Charadrius dubius', '', '', '', '2022-03-22', 'https://inpn.mnhn.fr/espece/cd_nom/3136', '_photos/1648237057IMG_5342.jpg', '_photos/1648237057IMG_5342-2.jpg', '2022-03-22', 'Réserve Naturelle Régionale du Marais de la Vacherie, Champagné-les-Marais'),
(121, 'Chevalier gambette', 'Tringa totanus', '', '', '', '2022-03-22', 'https://inpn.mnhn.fr/espece/cd_nom/2586', '_photos/1648236837IMG_5331.jpg', '_photos/1648236837IMG_5331-2.jpg', '2022-03-22', 'Réserve Naturelle Régionale du Marais de la Vacherie, Champagné-les-Marais'),
(120, 'Bruant zizi', 'Emberiza cirlus', '', '', '', NULL, 'https://inpn.mnhn.fr/espece/cd_nom/4659', '', '', NULL, 'Lycée Nature, La Roche-sur-Yon'),
(119, 'Alouette des champs', 'Alauda arvensis', '', '', '', '2022-03-09', 'https://inpn.mnhn.fr/espece/cd_nom/3676', '_photos/1647075420IMG_5293.jpg', '_photos/1647075420IMG_5293-2.jpg', '2022-03-09', 'Réserve Naturelle Régionale du Marais de la Vacherie, Champagné-les-Marais'),
(118, 'Barge à queue noire', 'Limosa limosa', '', '', '', '2022-03-09', 'https://inpn.mnhn.fr/espece/cd_nom/2563', '_photos/IMG_1243-Avec accentuation-Bruit-2.jpg', '_photos/IMG_1243-Avec accentuation-Bruit.jpg', '2023-02-09', 'Réserve naturelle du Mullembourg, Noirmoutier-en-l\'Île'),
(117, 'Fuligule morillon', 'Aythya fuligula', '', '', '', '2022-02-16', 'https://inpn.mnhn.fr/espece/cd_nom/1998', '_photos/1645351033IMG_4899.jpg', '_photos/1645351033IMG_4899-2.jpg', '2022-02-16', 'Parc Naturelle Régional de la Brenne'),
(116, 'Grue cendrée', 'Grus grus', '', '', '', '2022-02-16', 'https://inpn.mnhn.fr/espece/cd_nom/3076', '_photos/IMG_9690-Avec accentuation-Bruit-2.jpg', '_photos/IMG_9690-Avec accentuation-Bruit.jpg', '2022-10-25', 'Lac du Der'),
(115, 'Nette rousse', 'Netta rufina', '', '', '', '2022-02-16', 'https://inpn.mnhn.fr/espece/cd_nom/1984', '_photos/IMG_2001-2.jpg', '_photos/IMG_2001.jpg', '2023-04-19', 'Parc Naturelle Régional de la Brenne'),
(114, 'Chevalier arlequin', 'Tringa erythropus', '', '', '', '2022-02-16', 'https://inpn.mnhn.fr/espece/cd_nom/2584', '_photos/1645265830IMG_4904.jpg', '_photos/1645265830IMG_4904-2.jpg', '2022-02-16', 'Parc Naturelle Régional de la Brenne'),
(113, 'Canard souchet', 'Spatula clypeata', '', '', '', '2022-02-16', 'https://inpn.mnhn.fr/espece/cd_nom/1972', '_photos/1645265063IMG_4853.jpg', '_photos/1645265063IMG_4853-2.jpg', '2022-02-16', 'Parc Naturelle Régional de la Brenne'),
(112, 'Canard pilet', 'Anas acuta', '', '', '', '2022-02-16', 'https://inpn.mnhn.fr/espece/cd_nom/1973', '_photos/1645264780IMG_4665.jpg', '_photos/1645264780IMG_4665-2.jpg', '2022-02-16', 'Parc Naturelle Régional de la Brenne'),
(111, 'Fuligule milouin', 'Aythya ferina', '', '', '', '2022-02-16', 'https://inpn.mnhn.fr/espece/cd_nom/1991', '_photos/1645264566IMG_4636.jpg', '_photos/1645264566IMG_4636-2.jpg', '2022-02-16', 'Parc Naturelle Régional de la Brenne'),
(110, 'Canard chipeau', 'Mareca strepera', '', '', '', '2022-02-16', 'https://inpn.mnhn.fr/espece/cd_nom/836203', '_photos/1645264278IMG_4523.jpg', '_photos/1645264278IMG_4523-2.jpg', '2022-02-16', 'Parc Naturelle Régional de la Brenne'),
(109, 'Tarier pâtre', 'Saxicola rubicola', '', '', '', '2022-02-16', 'https://inpn.mnhn.fr/espece/cd_nom/199425', '_photos/IMG_6414-Avec accentuation-Bruit-2.jpg', '_photos/IMG_6414-Avec accentuation-Bruit.jpg', '2022-04-20', 'Réserve Naturelle Régionale du Marais de la Vacherie, Champagné-les-Marais'),
(108, 'Chevêche d\'Athéna', 'Athena noctua', '', '', '', '2022-02-09', 'https://inpn.mnhn.fr/espece/cd_nom/3511', '_photos/1644589561IMG_4348.jpg', '_photos/1644589561IMG_4348-2.jpg', '2022-02-09', 'La Brelaizière'),
(107, 'Sarcelle d\'hiver', 'Anas crecca', '', '', '', '2019-10-22', 'https://inpn.mnhn.fr/espece/cd_nom/1958', '_photos/1644333054IMG_1886.jpg', '_photos/1644333054IMG_1886-2.jpg', '2019-10-22', 'Réserve Naturelle Régionale du Grand-Voyeux, Congis-sur-Thérouanne'),
(106, 'Grand Cormoran', 'Phalacrocorax carbo', '', '', '', '2021-06-06', 'https://inpn.mnhn.fr/espece/cd_nom/2440', '_photos/1644332892IMG_1472-3-3.jpg', '_photos/1644332892IMG_1472-3-2.jpg', '2021-06-06', 'Noisiel'),
(105, 'Perruche à collier', 'Psittacula krameri', '', '', '', '2019-09-09', 'https://inpn.mnhn.fr/espece/cd_nom/3448', '_photos/IMG_0267-3.jpg', '_photos/1644332711IMG_0267-2.jpg', '2019-09-09', 'Parc zoologique de Paris'),
(104, 'Pouillot véloce', 'Phylloscopus collybita', '', '', '', '2018-10-01', 'https://inpn.mnhn.fr/espece/cd_nom/4280', '_photos/1644332590IMG_0425.jpg', '_photos/1644332590IMG_0425-2.jpg', '2020-03-14', 'Fontenay-Trésigny'),
(103, 'Tourterelle turque', 'Streptopelia decaocto', '', '', '', '2018-10-01', 'https://inpn.mnhn.fr/espece/cd_nom/3429', '_photos/1644332383IMG_4841.jpg', '_photos/1644332383IMG_4841-2.jpg', '2019-12-21', 'Fontenay-Trésigny'),
(102, 'Martin-pêcheur d\'Europe', 'Alcedo atthis', '', '', '', '2019-10-22', 'https://inpn.mnhn.fr/espece/cd_nom/3571', '_photos/1644332166IMG_1838.jpg', '_photos/1644332166IMG_1838-2.jpg', '2019-10-22', 'Réserve Naturelle Régionale du Grand-Voyeux, Congis-sur-Thérouanne'),
(101, 'Chevalier guignette', 'Actitis hypoleucos', '', '', '', '2019-10-22', 'https://inpn.mnhn.fr/espece/cd_nom/2616', '_photos/1644332064IMG_1960-2.jpg', '_photos/1644332064IMG_1960.jpg', '2019-10-22', 'Réserve Naturelle Régionale du Grand-Voyeux, Congis-sur-Thérouanne'),
(100, 'Bernache du Canada', 'Branta canadensis', '', '', '', '2019-10-22', 'https://inpn.mnhn.fr/espece/cd_nom/2747', '_photos/1644331721IMG_1728.jpg', '_photos/1644331721IMG_1728-2.jpg', '2019-10-22', 'Réserve Naturelle Régionale du Grand-Voyeux, Congis-sur-Thérouanne'),
(99, 'Chocard à bec jaune', 'Pyrrhocorax graculus', '', '', '', '2018-10-01', 'https://inpn.mnhn.fr/espece/cd_nom/4485', '_photos/1644331425IMG_6757.jpg', '_photos/1644331425IMG_6757-2.jpg', '2020-02-11', 'La Rosière 1850, Montvalezan'),
(98, 'Roitelet huppé', 'Regulus regulus', '', '', '', '2020-02-12', 'https://inpn.mnhn.fr/espece/cd_nom/4308', '_photos/1644331286IMG_7022.jpg', '_photos/1644331286IMG_7022-2.jpg', '2020-02-12', 'La Rosière 1850, Montvalezan'),
(96, 'Aigle royal', 'Aquila chrysaetos', '', '', '', NULL, 'https://inpn.mnhn.fr/espece/cd_nom/2645', '', '', NULL, 'La Rosière 1850, Montvalezan'),
(97, 'Pie bavarde', 'Pica pica', '', '', '', '2018-10-01', 'https://inpn.mnhn.fr/espece/cd_nom/4474', '_photos/1644331215IMG_6981.jpg', '_photos/1644331215IMG_6981-2.jpg', '2020-02-12', 'La Rosière 1850, Montvalezan'),
(95, 'Martinet noir', 'Apus apus', '', '', '', '2018-10-01', 'https://inpn.mnhn.fr/espece/cd_nom/3551', '', '', NULL, 'Fontenay-Trésigny'),
(93, 'Loriot d\'Europe', 'Oriolus oriolus', '', '', '', '2020-07-17', 'https://inpn.mnhn.fr/espece/cd_nom/3803', '', '', NULL, 'Lac du Der'),
(94, 'Pipit des arbres', 'Anthus trivialis', '', '', '', '2018-10-01', 'https://inpn.mnhn.fr/espece/cd_nom/3723', '', '', NULL, 'Fontenay-Trésigny'),
(88, 'Serin cini', 'Serinus serinus', '', '', '', NULL, 'https://inpn.mnhn.fr/espece/cd_nom/4571', '', '', NULL, 'Reims'),
(89, 'Bergeronnette des ruisseaux', 'Motacilla cinerea', '', '', '', '2021-11-20', 'https://inpn.mnhn.fr/espece/cd_nom/3755', '_photos/1644330591IMG_3684.jpg', '_photos/1644330591IMG_3684-2.jpg', '2021-11-20', 'Chaos de Piquet, Le Tablier'),
(87, 'Hypolaïs polyglotte', 'Hippolais polyglotta', '', '', '', '2023-05-17', 'https://inpn.mnhn.fr/espece/cd_nom/4215', '_photos/IMG_3376-2.jpg', '_photos/IMG_3376-3.jpg', '2023-05-17', 'Les Sables d’Olonne'),
(86, 'Rossignol philomèle', 'Luscinia megarhynchos', '', '', '', '2023-04-20', 'https://inpn.mnhn.fr/espece/cd_nom/4013', '', '', NULL, ''),
(83, 'Pigeon colombin', 'Columba oenas', '', '', '', '2018-10-01', 'https://inpn.mnhn.fr/espece/cd_nom/3422', '', '', NULL, ''),
(85, 'Coucou gris', 'Cuculus canorus', '', '', '', '2018-10-01', 'https://inpn.mnhn.fr/espece/cd_nom/3465', '', '', NULL, ''),
(82, 'Chevalier culblanc', 'Tringa ochropus', '', '', '', '2022-01-25', 'https://inpn.mnhn.fr/espece/cd_nom/2603', '', '', NULL, 'Réserve Naturelle Régionale du Marais de la Vacherie, Champagné-les-Marais'),
(81, 'Pipit spioncelle', 'Anthus spinoletta', '', '', '', '2022-01-25', 'https://inpn.mnhn.fr/espece/cd_nom/3733', '', '', NULL, 'Réserve Naturelle Régionale du Marais de la Vacherie, Champagné-les-Marais'),
(80, 'Cigogne blanche', 'Ciconia ciconia', '', '', '', '2022-01-25', 'https://inpn.mnhn.fr/espece/cd_nom/2517', '_photos/1644328260IMG_4309.jpg', '_photos/1644328260IMG_4309-2.jpg', '2022-01-25', 'Réserve Naturelle Régionale du Marais de la Vacherie, Champagné-les-Marais'),
(79, 'Faucon pèlerin', 'Falco peregrinus', '', '', '', '2022-01-25', 'https://inpn.mnhn.fr/espece/cd_nom/2938', '_photos/1644328214IMG_4185.jpg', '_photos/1644328214IMG_4185-2.jpg', '2022-01-25', 'Réserve Naturelle Régionale du Marais de la Vacherie, Champagné-les-Marais'),
(78, 'Busard des roseaux', 'Circus aeruginosus', '', '', '', '2022-01-25', 'https://inpn.mnhn.fr/espece/cd_nom/2878', '_photos/1644328161IMG_4118.jpg', '_photos/1644328161IMG_4118-2.jpg', '2022-01-25', 'Réserve Naturelle Régionale du Marais de la Vacherie, Champagné-les-Marais'),
(77, 'Buse variable', 'Buteo buteo', '', '', '', '2018-10-01', 'https://inpn.mnhn.fr/espece/cd_nom/2623', '_photos/1644328109IMG_4086.jpg', '_photos/1644328109IMG_4086-2.jpg', '2022-01-25', 'Réserve Naturelle Régionale du Marais de la Vacherie, Champagné-les-Marais'),
(76, 'Tadorne de Belon', 'Tadorna tadorna', '', '', '', '2022-01-25', 'https://inpn.mnhn.fr/espece/cd_nom/2767', '_photos/IMG_1451-Avec accentuation-Bruit-2.jpg', '_photos/IMG_1451-Avec accentuation-Bruit.jpg', '2023-02-09', 'Réserve naturelle du Mullembourg, Noirmoutier-en-l\'Île'),
(75, 'Grande Aigrette', 'Ardea alba', '', '', '', '2021-09-15', 'https://inpn.mnhn.fr/espece/cd_nom/2504', '_photos/1644328031IMG_9955.jpg', '_photos/1644328031IMG_9955-2.jpg', '2021-09-15', 'Lac de Grand-Lieu'),
(74, 'Bécassine des marais', 'Gallinago gallinago', '', '', '', '2021-09-15', 'https://inpn.mnhn.fr/espece/cd_nom/2543', '_photos/1644327985IMG_3333.jpg', '_photos/1644327985IMG_3333-2.jpg', '2021-09-15', 'Lac de Grand-Lieu'),
(73, 'Vanneau huppé', 'Vanellus vanellus', '', '', '', '2021-09-15', 'https://inpn.mnhn.fr/espece/cd_nom/3187', '_photos/16443278631613475634IMG_0089.jpg', '_photos/16443278631613475634IMG_0089-2.jpg', '2021-09-15', 'Lac de Grand-Lieu'),
(72, 'Bouscarle de Cetti', 'Cettia cetti', '', '', '', '2021-09-14', 'https://inpn.mnhn.fr/espece/cd_nom/4151', '_photos/1644327804IMG_3251.jpg', '_photos/1644327804IMG_3251-2.jpg', '2021-09-14', 'Lac de Grand-Lieu'),
(71, 'Traquet motteux', 'Oenanthe oenanthe', '', '', '', '2021-09-13', 'https://inpn.mnhn.fr/espece/cd_nom/4064', '_photos/1644327743IMG_3162.jpg', '_photos/1644327743IMG_3162-2.jpg', '2021-09-13', 'Lac de Grand-Lieu'),
(70, 'Spatule blanche', 'Platalea leucorodia', '', '', '', '2021-09-12', 'https://inpn.mnhn.fr/espece/cd_nom/2530', '_photos/1644327689IMG_3039.jpg', '_photos/1644327689IMG_3039-2.jpg', '2021-09-12', 'Pointe de l’Aiguillon, l’Aiguillon-la-Presqu’île'),
(69, 'Gravelot à collier interrompu', 'Charadrius alexandrinus', '', '', '', '2021-09-11', 'https://inpn.mnhn.fr/espece/cd_nom/3142', '_photos/1644327613IMG_2992.jpg', '_photos/1644327613IMG_2992-2.jpg', '2021-09-11', 'Pointe de l’Aiguillon, l’Aiguillon-la-Presqu’île'),
(68, 'Bécasseau variable', 'Calidris alpina', '', '', '', '2021-09-11', 'https://inpn.mnhn.fr/espece/cd_nom/2911', '_photos/1644327547IMG_2985.jpg', '_photos/1644327547IMG_2985-2.jpg', '2021-09-11', 'Pointe de l’Aiguillon, l’Aiguillon-la-Presqu’île'),
(67, 'Bécasseau sanderling', 'Calidris alba', '', '', '', '2021-09-11', 'https://inpn.mnhn.fr/espece/cd_nom/3195', '_photos/1644327494IMG_2940.jpg', '_photos/1644327494IMG_2940-2.jpg', '2021-09-11', 'Pointe de l’Aiguillon, l’Aiguillon-la-Presqu’île'),
(66, 'Balbuzard pêcheur', 'Pandion haliaetus', '', '', '', '2021-09-11', 'https://inpn.mnhn.fr/espece/cd_nom/2660', '_photos/IMG_2314-2.jpg', '_photos/IMG_2314.jpg', '2023-04-21', 'Parc Naturelle Régional de la Brenne'),
(65, 'Grand Gravelot', 'Charadrius hiaticula', '', '', '', '2021-09-11', 'https://inpn.mnhn.fr/espece/cd_nom/3140', '_photos/1644327388IMG_2801.jpg', '_photos/1644327388IMG_2801-2.jpg', '2021-09-11', 'Pointe de l’Aiguillon, l’Aiguillon-la-Presqu’île'),
(64, 'Barge rousse', 'Limosa lapponica', '', '', '', '2021-09-11', 'https://inpn.mnhn.fr/espece/cd_nom/2568', '_photos/1644327320IMG_2733.jpg', '_photos/1644327320IMG_2733-2.jpg', '2021-09-11', 'Pointe de l’Aiguillon, l’Aiguillon-la-Presqu’île'),
(63, 'Cigogne noire', 'Ciconia nigra', '', '', '', '2021-07-20', 'https://inpn.mnhn.fr/espece/cd_nom/2514', '_photos/1644327198IMG_1800.jpg', '_photos/1644327198IMG_1800-2.jpg', '2021-07-20', 'Fontenay-Trésigny'),
(62, 'Verdier d\'Europe', 'Chloris chloris', '', 'Normalement observable sur tout le territoire métropolitain.', 'Espèce en très fort déclin.', '2018-10-01', 'https://inpn.mnhn.fr/espece/cd_nom/4582', '_photos/1644327088IMG_0448.jpg', '_photos/1644327088IMG_0448-2.jpg', '2021-05-27', 'Parcs Zoologiques de Lumigny, Lumigny-Nesles-Ormeaux '),
(61, 'Accenteur mouchet', 'Prunella modularis', '', '', '', '2018-10-01', 'https://inpn.mnhn.fr/espece/cd_nom/3978', '_photos/1644327038IMG_9349.jpg', '_photos/1644327038IMG_9349-2.jpg', '2021-05-27', 'Parcs Zoologiques de Lumigny, Lumigny-Nesles-Ormeaux '),
(60, 'Pigeon ramier', 'Columba palumbus', '', '', '', '2018-10-01', 'https://inpn.mnhn.fr/espece/cd_nom/3424', '_photos/1644326984IMG_5234.jpg', '_photos/1644326984IMG_5234-2.jpg', '2021-05-27', 'Parcs Zoologiques de Lumigny, Lumigny-Nesles-Ormeaux '),
(59, 'Pic vert', 'Picus viridis', '', '', '', '2021-05-20', 'https://inpn.mnhn.fr/espece/cd_nom/3603', '_photos/1644326936IMG_1179.jpg', '_photos/1644326936IMG_1179-2.jpg', '2021-05-20', 'Parcs Zoologiques de Lumigny, Lumigny-Nesles-Ormeaux '),
(58, 'Faucon crécerelle', 'Falco tinnunculus', '', '', '', '2020-07-17', 'https://inpn.mnhn.fr/espece/cd_nom/2669', '_photos/1644326877IMG_1172.jpg', '_photos/1644326877IMG_1172-2.jpg', '2021-05-20', 'Parcs Zoologiques de Lumigny, Lumigny-Nesles-Ormeaux '),
(57, 'Troglodyte mignon', 'Troglodytes troglodytes', '', '', '', '2018-10-01', 'https://inpn.mnhn.fr/espece/cd_nom/3967', '_photos/1644326803IMG_9403.jpg', '_photos/1644326803IMG_9403-2.jpg', '2021-05-19', 'Parcs Zoologiques de Lumigny, Lumigny-Nesles-Ormeaux '),
(56, 'Fauvette des jardins', 'Sylvia borin', '', '', '', '2021-05-19', 'https://inpn.mnhn.fr/espece/cd_nom/4254', '_photos/1644326728IMG_1083.jpg', '_photos/1644326728IMG_1083-2.jpg', '2021-05-19', 'Parcs Zoologiques de Lumigny, Lumigny-Nesles-Ormeaux '),
(55, 'Rougequeue à front blanc', 'Phoenicurus phoenicurus', '', '', '', '2021-05-19', 'https://inpn.mnhn.fr/espece/cd_nom/4040', '_photos/1644326678IMG_1060.jpg', '_photos/1644326678IMG_1060-2.jpg', '2021-05-19', 'Parcs Zoologiques de Lumigny, Lumigny-Nesles-Ormeaux '),
(54, 'Choucas des tours', 'Coloeus monedula', '', '', '', '2021-02-24', 'https://inpn.mnhn.fr/espece/cd_nom/4494', '_photos/1644326609IMG_0610.jpg', '_photos/1644326609IMG_0610-2.jpg', '2021-02-24', 'Moret-sur-Loing'),
(53, 'Roitelet à triple-bandeau', 'Regulus ignicapilla', '', '', '', '2021-02-24', 'https://inpn.mnhn.fr/espece/cd_nom/459638', '_photos/1644326554IMG_0367.jpg', '_photos/1644326554IMG_0367-2.jpg', '2021-02-24', 'ENS Plaine de Sorques, Montigny-sur-Loing'),
(52, 'Corbeau freux', 'Corvus frugilegus', '', '', '', '2021-02-14', 'https://inpn.mnhn.fr/espece/cd_nom/4501', '_photos/1644326484IMG_0059.jpg', '_photos/1644326484IMG_0059-2.jpg', '2021-02-14', 'Fontenay-Trésigny'),
(51, 'Pic épeichette', 'Dryobates minor', '', '', '', '2021-01-11', 'https://inpn.mnhn.fr/espece/cd_nom/3630', '_photos/IMG_2235-Avec accentuation-Bruit-2.jpg', '_photos/IMG_2235-Avec accentuation-Bruit.jpg', '2023-04-21', 'Parc Naturelle Régionale de la Brenne'),
(49, 'Pinson des arbres', 'Fringilla coelebs', '', '', '', '2018-10-01', 'https://inpn.mnhn.fr/espece/cd_nom/4564', '_photos/1644326324IMG_8174.jpg', '_photos/1644326324IMG_8174-2.jpg', '2021-01-06', 'Fontenay-Trésigny'),
(50, 'Pic épeiche', 'Dendrocopos major', '', '', '', '2021-01-11', 'https://inpn.mnhn.fr/espece/cd_nom/3611', '_photos/1644326380IMG_9363.jpg', '_photos/1644326380IMG_9363-2.jpg', '2021-01-11', 'Étangs de Liverdy-en-Brie'),
(48, 'Grive musicienne', 'Turdus philomelos', '', '', '', '2020-09-29', 'https://inpn.mnhn.fr/espece/cd_nom/4129', '_photos/1644326259IMG_6640.jpg', '_photos/1644326259IMG_6640-2.jpg', '2020-09-29', 'Parcs Zoologiques de Lumigny, Lumigny-Nesles-Ormeaux '),
(47, 'Sittelle torchepot', 'Sitta europaea', '', '', '', '2020-09-22', 'https://inpn.mnhn.fr/espece/cd_nom/3774', '_photos/1644326195IMG_8556.jpg', '_photos/1644326195IMG_8556-2.jpg', '2020-09-22', 'Parcs Zoologiques de Lumigny, Lumigny-Nesles-Ormeaux '),
(46, 'Merle noir', 'Turdus merula', '', '', '', '2018-10-01', 'https://inpn.mnhn.fr/espece/cd_nom/4117', '_photos/1644326118IMG_6134.jpg', '_photos/1644326118IMG_6134-2.jpg', '2020-09-22', 'Fontenay-Trésigny'),
(45, 'Héron pourpré', 'Ardea purpurea', '', '', '', '2020-07-18', 'https://inpn.mnhn.fr/espece/cd_nom/2508', '_photos/1644326054IMG_4909.jpg', '_photos/1644326054IMG_4909-2.jpg', '2020-07-18', 'Lac du Der'),
(44, 'Oie cendrée', 'Anser anser', '', '', '', '2020-07-18', 'https://inpn.mnhn.fr/espece/cd_nom/2741', '_photos/1644325984IMG_4902.jpg', '_photos/1644325984IMG_4902-2.jpg', '2020-07-18', 'Lac du Der'),
(43, 'Hirondelle rustique', 'Hirundo rustica', '', '', '', '2020-07-18', 'https://inpn.mnhn.fr/espece/cd_nom/3696', '_photos/1644325912IMG_4879.jpg', '_photos/1644325912IMG_4879-2.jpg', '2020-07-18', 'Giffaumont-Champaubert, Lac du Der'),
(42, 'Hirondelle de rivage', 'Riparia riparia', '', '', '', '2020-07-18', 'https://inpn.mnhn.fr/espece/cd_nom/3688', '_photos/1644325835IMG_4826.jpg', '_photos/1644325835IMG_4826-2.jpg', '2020-07-18', 'Giffaumont-Champaubert, Lac du Der'),
(41, 'Linotte mélodieuse', 'Linaria cannabina', '', '', '', '2020-07-17', 'https://inpn.mnhn.fr/espece/cd_nom/889047', '_photos/1644325763IMG_4812.jpg', '_photos/1644325763IMG_4812-2.jpg', '2020-07-17', 'Lac du Der'),
(40, 'Héron garde-boeufs', 'Bubulcus ibis', '', '', '', '2020-07-17', 'https://inpn.mnhn.fr/espece/cd_nom/2489', '_photos/1644325681IMG_4724.jpg', '_photos/1644325681IMG_4724-2.jpg', '2020-07-17', 'Lac du Der'),
(39, 'Bihoreau gris', 'Nycticorax nycticorax', '', '', '', '2020-07-17', 'https://inpn.mnhn.fr/espece/cd_nom/2481', '_photos/IMG_3609-Avec accentuation-Bruit-2.jpg', '_photos/IMG_3609-Avec accentuation-Bruit.jpg', '2023-05-20', 'Près de la Réserve Naturelle du Lac de Grand Lieu'),
(38, 'Rougequeue noir', 'Phoenicurus ochruros', '', '', '', '2020-07-15', 'https://inpn.mnhn.fr/espece/cd_nom/4035', '_photos/1644321305IMG_4467-3.jpg', '_photos/1644321305IMG_4467-2.jpg', '2020-07-15', 'Giffaumont-Champaubert, Lac du Der'),
(37, 'Hirondelle de fenêtre', 'Delichon urbicum', '', '', '', '2020-07-15', 'https://inpn.mnhn.fr/espece/cd_nom/459478', '_photos/1644321001IMG_4404.jpg', '_photos/1644321001IMG_4404-2.jpg', '2020-07-15', 'Giffaumont-Champaubert, Lac du Der'),
(36, 'Fauvette à tête noire', 'Sylvia atricapilla', '', '', '', '2020-06-11', 'https://inpn.mnhn.fr/espece/cd_nom/4257', '_photos/1644320890IMG_3929.jpg', '_photos/1644320890IMG_3929-2.jpg', '2020-06-11', 'Fontenay-Trésigny'),
(35, 'Pic mar', 'Dendrocopos medius', '', '', '', '2020-05-30', 'https://inpn.mnhn.fr/espece/cd_nom/3619', '_photos/1644320818IMG_2634.jpg', '_photos/1644320818IMG_2634-2.jpg', '2020-05-30', 'Parcs Zoologiques de Lumigny, Lumigny-Nesles-Ormeaux '),
(34, 'Rousserolle turdoïde', 'Acrocephalus arundinaceus', '', '', '', '2020-05-28', 'https://inpn.mnhn.fr/espece/cd_nom/4198', '_photos/1644320723IMG_2213.jpg', '_photos/1644320723IMG_2213-2.jpg', '2020-05-28', 'Réserve Naturelle Régionale du Grand-Voyeux, Congis-sur-Thérouanne'),
(33, 'Rousserolle effarvatte', 'Acrocephalus scirpaceus', '', '', '', '2020-05-28', 'https://inpn.mnhn.fr/espece/cd_nom/4195', '_photos/1644320647IMG_2168.jpg', '_photos/1644320647IMG_2168-2.jpg', '2020-05-28', 'Réserve Naturelle Régionale du Grand-Voyeux, Congis-sur-Thérouanne'),
(32, 'Grèbe huppée', 'Podiceps cristatus', '', '', '', '2020-05-28', 'https://inpn.mnhn.fr/espece/cd_nom/965', '_photos/1644320542IMG_2128.jpg', '_photos/1644320542IMG_2128-2.jpg', '2020-05-28', 'Réserve Naturelle Régionale du Grand-Voyeux, Congis-sur-Thérouanne'),
(31, 'Mouette rieuse', 'Chroicocephalus ridibundus', '', '', '', '2018-10-01', 'https://inpn.mnhn.fr/espece/cd_nom/530157', '_photos/1644320469IMG_2117.jpg', '_photos/1644320469IMG_2117-2.jpg', '2020-05-28', 'Réserve Naturelle Régionale du Grand-Voyeux, Congis-sur-Thérouanne'),
(30, 'Héron cendré', 'Ardea cinerea', '', '', '', '2020-05-28', 'https://inpn.mnhn.fr/espece/cd_nom/2506', '_photos/1644320380IMG_2090.jpg', '_photos/1644320380IMG_2090-2.jpg', '2020-05-28', 'Réserve Naturelle Régionale du Grand-Voyeux, Congis-sur-Thérouanne'),
(29, 'Cygne tuberculé', 'Cygnus olor', '', '', '', '2018-10-01', 'https://inpn.mnhn.fr/espece/cd_nom/2706', '_photos/1644320282IMG_2034.jpg', '_photos/1644320282IMG_2034-2.jpg', '2020-05-28', 'Réserve Naturelle Régionale du Grand-Voyeux, Congis-sur-Thérouanne'),
(28, 'Fauvette grisette', 'Curruca communis', '', '', '', '2020-05-28', 'https://inpn.mnhn.fr/espece/cd_nom/4252', '_photos/1644320166IMG_1966.jpg', '_photos/1644320166IMG_1966-2.jpg', '2020-05-28', 'Réserve Naturelle Régionale du Grand-Voyeux, Congis-sur-Thérouanne'),
(27, 'Milan noir', 'Milvus migrans', '', '', '', '2020-05-28', 'https://inpn.mnhn.fr/espece/cd_nom/2840', '_photos/IMG_6336-2.jpg', '_photos/IMG_6336.jpg', '2022-04-20', 'Réserve Naturelle Régionale du Marais de la Vacherie, Champagné-les-Marais'),
(26, 'Chardonneret élégant', 'Carduelis carduelis', '', '', '', '2020-05-20', 'https://inpn.mnhn.fr/espece/cd_nom/4583', '_photos/1644319676IMG_1646.jpg', '_photos/1644319676IMG_1646-2.jpg', '2020-05-20', 'Fontenay-Trésigny'),
(25, 'Moineau domestique', 'Passer domesticus', '', '', '', '2018-10-01', 'https://inpn.mnhn.fr/espece/cd_nom/4525', '_photos/1644319575IMG_0603.jpg', '_photos/1644319575IMG_0603-2.jpg', '2020-04-08', 'Fontenay-Trésigny'),
(24, 'Gallinule poule-d\'eau', 'Gallinula chloropus', '', '', '', '2020-03-13', 'https://inpn.mnhn.fr/espece/cd_nom/3059', '_photos/1644318899IMG_0386.jpg', '_photos/1644318899IMG_0386-2.jpg', '2020-03-13', 'Parcs Zoologiques de Lumigny, Lumigny-Nesles-Ormeaux '),
(23, 'Foulque macroule', 'Fulica atra', '', '', '', '2020-03-07', 'https://inpn.mnhn.fr/espece/cd_nom/3070', '_photos/1644318772IMG_9767.jpg', '_photos/1644318772IMG_9767-2.jpg', '2020-03-07', 'Parcs Zoologiques de Lumigny, Lumigny-Nesles-Ormeaux '),
(22, 'Tarin des aulnes', 'Spinus spinus', '', '', '', '2020-03-07', 'https://inpn.mnhn.fr/espece/cd_nom/889056', '_photos/1644318678IMG_9601.jpg', '_photos/1644318678IMG_9601-2.jpg', '2020-03-07', 'Parcs Zoologiques de Lumigny, Lumigny-Nesles-Ormeaux '),
(21, 'Orite à longue queue', 'Aegithalos caudatus', '', '', '', '2020-03-07', 'https://inpn.mnhn.fr/espece/cd_nom/4342', '_photos/1644318598IMG_9440.jpg', '_photos/1644318598IMG_9440-2.jpg', '2020-03-07', 'Parcs Zoologiques de Lumigny, Lumigny-Nesles-Ormeaux '),
(20, 'Mésange charbonnière', 'Parus major', '', '', '', '2018-10-01', 'https://inpn.mnhn.fr/espece/cd_nom/3764', '_photos/1644318447IMG_9132.jpg', '_photos/1644318447IMG_9132-2.jpg', '2020-02-22', 'Zoo du Bois d’Attilly, Férolles-Attilly'),
(19, 'Etourneau sansonnet', 'Sturnus vulgaris', '', '', '', '2018-10-01', 'https://inpn.mnhn.fr/espece/cd_nom/4516', '_photos/1644318228IMG_8997.jpg', '_photos/1644318228IMG_8997-2.jpg', '2020-02-22', 'Zoo du Bois d’Attilly, Férolles-Attilly'),
(18, 'Mésange bleue', 'Cyanistes caeruleus', '', '', '', '2018-10-01', 'https://inpn.mnhn.fr/espece/cd_nom/534742', '_photos/1644318079IMG_7604.jpg', '_photos/1644318079IMG_7604-2.jpg', '2020-02-18', 'Parcs Zoologiques de Lumigny, Lumigny-Nesles-Ormeaux '),
(17, 'Grimpereau des jardins', 'Certhia brachydactyla', '', '', '', '2020-02-18', 'https://inpn.mnhn.fr/espece/cd_nom/3791', '_photos/1644317979IMG_7412.jpg', '_photos/1644317979IMG_7412-2.jpg', '2020-02-18', 'Parcs Zoologiques de Lumigny, Lumigny-Nesles-Ormeaux '),
(16, 'Mésange nonnette', 'Poecile palustris', '', '', '', '2020-01-25', 'https://inpn.mnhn.fr/espece/cd_nom/534753', '_photos/1644317857pdf25012020-6094.jpg', '_photos/1644317857pdf25012020-6094-2.jpg', '2020-01-25', 'Parcs Zoologiques de Lumigny, Lumigny-Nesles-Ormeaux '),
(15, 'Geai des chênes', 'Garralus glandarius', '', '', '', '2020-01-25', 'https://inpn.mnhn.fr/espece/cd_nom/4466', '_photos/1644317693pdf25012020-5514.jpg', '_photos/1644317693pdf25012020-5514-2.jpg', '2020-01-25', 'Parcs Zoologiques de Lumigny, Lumigny-Nesles-Ormeaux '),
(14, 'Rougegorge familier', 'Erithacus rubecula', '', '', '', '2018-10-01', 'https://inpn.mnhn.fr/espece/cd_nom/4001', '_photos/1644317554IMG_2674.jpg', '_photos/1644317554IMG_2674-2.jpg', '2019-10-23', 'Parcs Zoologiques de Lumigny, Lumigny-Nesles-Ormeaux '),
(13, 'Bruant des roseaux', 'Emberiza schoeniclus', '', '', '', '2019-10-22', 'https://inpn.mnhn.fr/espece/cd_nom/4669', '_photos/1644317475IMG_2011.jpg', '_photos/1644317475IMG_2011-2.jpg', '2019-10-22', 'Réserve Naturelle Régionale du Grand-Voyeux, Congis-sur-Thérouanne'),
(12, 'Canard colvert', 'Anas platyrhynchos', '', '', '', '2018-10-01', 'https://inpn.mnhn.fr/espece/cd_nom/1966', '_photos/1644317305IMG_1193.jpg', '_photos/1644317305IMG_1193-2.jpg', '2019-10-03', 'Jardin d’acclimatation, Paris'),
(11, 'Goéland marin', 'Larus marinus', '', '', '', '2019-08-10', 'https://inpn.mnhn.fr/espece/cd_nom/3311', '_photos/1644317058IMG_9835.jpg', '_photos/1644317058IMG_9835-2.jpg', '2019-08-10', 'Narvik, Norvège'),
(10, 'Goéland cendré', 'Larus canus', '', '', '', '2019-08-10', 'https://inpn.mnhn.fr/espece/cd_nom/3293', '_photos/1644316935IMG_9746.jpg', '_photos/1644316935IMG_9746-2.jpg', '2019-08-10', 'Narvik, Norvège'),
(9, 'Goéland argenté', 'Larus argentatus ', '', '', '', '2019-08-10', 'https://inpn.mnhn.fr/espece/cd_nom/3302', '_photos/1644316604IMG_9678.jpg', '_photos/1644316604IMG_9678-2.jpg', '2019-08-10', 'Narvik, Norvège'),
(8, 'Pipit farlouse', 'Anthus pratensis ', '', '', '', '2019-08-09', 'https://inpn.mnhn.fr/espece/cd_nom/3726', '_photos/1644316445IMG_9445.jpg', '_photos/1644316445IMG_9445-2.jpg', '2019-08-09', 'Norvège'),
(7, 'Sterne pierregarin', 'Sterna hirundo ', '', '', '', '2019-08-07', 'https://inpn.mnhn.fr/espece/cd_nom/3343', '_photos/1644316228IMG_9186.jpg', '_photos/1644316228IMG_9186-2.jpg', '2019-08-07', 'Narvik, Norvège'),
(138, 'Pic noir', 'Dryocopus martius', '', '', '', '2022-05-10', 'https://inpn.mnhn.fr/espece/cd_nom/3608/', '', '', '2022-05-10', 'Parc National des Pyrénées'),
(6, 'Bergeronnette grise', 'Motacilla alba ', '', '', '', '2019-08-07', 'https://inpn.mnhn.fr/espece/cd_nom/3941', '_photos/1644316127IMG_9177.jpg', '_photos/1644316127IMG_9177-2.jpg', '2019-08-07', 'Narvik, Norvège'),
(123, 'Echasse blanche', 'Himantopus himantopus', '', '', '', '2022-03-29', 'https://inpn.mnhn.fr/espece/cd_nom/3112', '_photos/1648645482IMG_5588.jpg', '_photos/1648645482IMG_5588-2.jpg', '2022-03-29', 'Réserve Naturelle Régionale du Marais de la Vacherie, Champagné-les-Marais'),
(124, 'Pouillot fitis', 'Phylloscopus trochilus', '', '', '', '2022-04-13', 'https://inpn.mnhn.fr/espece/cd_nom/4289', '_photos/1650130416IMG_6130.jpg', '_photos/1650130416IMG_6130-2.jpg', '2022-04-13', 'Réserve Naturelle Régionale du Grand-Voyeux, Congis-sur-Thérouanne'),
(125, 'Gorgebleue à miroir', 'Luscinia svecica', '', '', '', '2022-04-13', 'https://inpn.mnhn.fr/espece/cd_nom/4023', '_photos/1650130846IMG_6222.jpg', '_photos/1650130846IMG_6222-2.jpg', '2022-04-13', 'Réserve Naturelle Régionale du Grand-Voyeux, Congis-sur-Thérouanne'),
(126, 'Phragmite des joncs', 'Acrocephalus schoenobaenus', '', '', '', NULL, 'https://inpn.mnhn.fr/espece/cd_nom/4187', '', '', NULL, 'Réserve Naturelle Régionale du Marais de la Vacherie, Champagné-les-Marais'),
(128, 'Bergeronnette printanière', 'Motacilla flava', '', '', '', '2022-04-20', 'https://inpn.mnhn.fr/espece/cd_nom/3741', '_photos/IMG_2269-2.jpg', '_photos/IMG_2269.jpg', '2023-04-21', 'Parc Naturelle Régionale de la Brenne'),
(129, 'Goéland leucophée', 'Larus michahellis', '', '', '', '2022-04-20', 'https://inpn.mnhn.fr/espece/cd_nom/199374', '_photos/1650475056IMG_6307.jpg', '_photos/1650475056IMG_6307-2.jpg', '2022-04-20', 'Réserve Naturelle Régionale du Marais de la Vacherie, Champagné-les-Marais'),
(130, 'Faisan de Colchide', 'Phasianus colchicus', '', '', '', NULL, 'https://inpn.mnhn.fr/espece/cd_nom/3003/', '', '', NULL, ''),
(131, 'Huppe fasciée', 'Upupa epops', '', '', '', NULL, 'https://inpn.mnhn.fr/espece/cd_nom/3590/', '', '', NULL, 'Dompierre-sur-Yon'),
(132, 'Circaète Jean-le-Blanc', 'Circaetus gallicus', '', '', '', '2022-05-10', 'https://inpn.mnhn.fr/espece/cd_nom/2873', '', '', '2022-05-10', 'Parc National des Pyrénées'),
(133, 'Milan royal', 'Milvus milvus', '', '', '', '2022-05-10', 'https://inpn.mnhn.fr/espece/cd_nom/2844/', '', '', '2022-05-10', 'Parc National des Pyrénées'),
(134, 'Vautour fauve', 'Gyps fulvus', '', '', '', '2022-05-10', 'https://inpn.mnhn.fr/espece/cd_nom/2860/', '', '', '2022-05-10', 'Parc National des Pyrénées'),
(135, 'Gypaète barbu', 'Gypaetus barbatus', '', '', '', '2022-05-10', 'https://inpn.mnhn.fr/espece/cd_nom/2852/', '', '', '2022-05-10', 'Parc National des Pyrénées'),
(136, 'Aigle botté', 'Hieraaetus pennatus', '', '', '', '2022-05-10', 'https://inpn.mnhn.fr/espece/cd_nom/2651/', '', '', '2022-05-10', 'Parc National des Pyrénées'),
(137, 'Grand corbeau', 'Corvus corax', '', '', '', '2022-05-10', 'https://inpn.mnhn.fr/espece/cd_nom/4510/', '', '', '2022-05-10', 'Parc National des Pyrénées'),
(139, 'Pie-grièche écorcheur', 'Lanius collurio', '', '', '', '2022-05-10', 'https://inpn.mnhn.fr/espece/cd_nom/3807/', '', '', '2022-05-10', 'Parc National des Pyrénées'),
(140, 'Gobemouche gris', 'Muscicapa striata', '', '', '', '2022-09-03', 'https://inpn.mnhn.fr/espece/cd_nom/4319/', '_photos/IMG_8829.jpg', '_photos/IMG_8829_2.jpg', '2022-09-03', 'Réserve des Huttes, Nalliers'),
(141, 'Bruant jaune', 'Emberiza citrinella', '', '', '', NULL, 'https://inpn.mnhn.fr/espece/cd_nom/4657/', '', '', NULL, ''),
(143, 'Gobemouche noir', 'Ficedula hypoleuca', '', '', '', '2022-08-29', 'https://inpn.mnhn.fr/espece/cd_nom/4330', '_photos/1662658950IMG_8707-2.jpg', '_photos/1662658950IMG_8707.jpg', '2022-08-29', 'Lac du Jaunay'),
(144, 'Guifette noire', 'Chlidonias niger', '', '', '', '2022-08-29', 'https://inpn.mnhn.fr/espece/cd_nom/3371', '_photos/1662659539IMG_8714.jpg', '_photos/1662659539IMG_8714-2.jpg', '2022-08-29', 'Lac du Jaunay'),
(145, 'Ibis sacré', 'Threskiornis aethiopicus', '', '', '', '2022-09-16', 'https://inpn.mnhn.fr/espece/cd_nom/2687/', '_photos/1663945541IMG_8967.jpg', '_photos/1663945541IMG_8967-2.jpg', '2022-09-16', 'Réserve Naturelle Régionale du Marais de la Vacherie, Champagné-les-Marais'),
(146, 'Tarier des prés', 'Saxicola rubetra', '', '', '', '2022-09-16', 'https://inpn.mnhn.fr/espece/cd_nom/4049/', '_photos/1663945710IMG_8919.jpg', '_photos/1663945710IMG_8919-2.jpg', '2022-09-16', 'Réserve Naturelle Régionale du Marais de la Vacherie, Champagné-les-Marais'),
(147, 'Chevalier aboyeur', 'Tringa nebularia', '', '', '', NULL, 'https://inpn.mnhn.fr/espece/cd_nom/2594/', '', '', NULL, 'Réserve Naturelle Régionale du Marais de la Vacherie, Champagné-les-Marais'),
(148, 'Avocette élégante', 'Recurvirostra avosetta', '', '', '', '2022-09-24', 'https://inpn.mnhn.fr/espece/cd_nom/3116/', '_photos/IMG_1388-2.jpg', '_photos/IMG_1388.jpg', '2023-02-09', 'Réserve naturelle du Mullembourg, Noirmoutier-en-l\'Île'),
(149, 'Cisticole des joncs', 'Cisticola juncidis', '', '', '', '2022-09-24', 'https://inpn.mnhn.fr/espece/cd_nom/4155/', '_photos/1664104245IMG_9138.jpg', '_photos/1664104245IMG_9138-2.jpg', '2022-09-24', 'Les Sables d’Olonne'),
(150, 'Tournepierre à collier', 'Arenaria interpres', '', '', '', '2022-09-24', 'https://inpn.mnhn.fr/espece/cd_nom/3239/', '_photos/1664104545IMG_9161.jpg', '_photos/1664104545IMG_9161-2.jpg', '2022-09-24', 'Les Sables d’Olonne'),
(151, 'Sterne caugek', 'Thalasseus sandvicensis', '', '', '', '2022-09-24', 'https://inpn.mnhn.fr/espece/cd_nom/3362/', '_photos/1664104733IMG_9175.jpg', '_photos/1664104733IMG_9175-2.jpg', '2022-09-24', 'Les Sables d’Olonne'),
(152, 'Chouette effraie', 'Tyto alba', '', '', '', NULL, 'https://inpn.mnhn.fr/espece/cd_nom/3482/', '', '', NULL, ''),
(153, 'Moineau friquet', 'Passer montanus', '', '', '', '2022-10-27', 'https://inpn.mnhn.fr/espece/cd_nom/4532/', '_photos/1672421292IMG_0027.jpg', '_photos/1672421292IMG_0027-2.jpg', '2022-10-27', 'Lac du Der'),
(154, 'Grèbe castagneux', 'Tachybaptus ruficollis', '', '', '', '2022-10-25', 'https://inpn.mnhn.fr/espece/cd_nom/977/', '_photos/1672421674IMG_9581-2.jpg', '_photos/1672421674IMG_9581.jpg', '2022-10-25', 'Lac du Der'),
(155, 'Grive mauvis', 'Turdus iliacus', '', '', '', '2023-02-08', 'https://inpn.mnhn.fr/espece/cd_nom/4137', '_photos/1675883817IMG_0787-2.jpg', '_photos/1675883817IMG_0787.jpg', '2023-02-08', 'Bord de l’Yon, la Roche-sur-Yon'),
(156, 'Pluvier doré', 'Pluvialis apricaria', '', '', '', '2023-02-07', 'https://inpn.mnhn.fr/espece/cd_nom/3161', '_photos/1675884062IMG_0722-2.jpg', '_photos/1675884062IMG_0722.jpg', '2023-02-07', 'Réserve Naturelle Régionale du Marais de la Vacherie, Champagné-les-Marais'),
(157, 'Mouette mélanocéphale', 'Ichthyaetus melanocephalus', '', '', '', '2023-04-20', 'https://inpn.mnhn.fr/espece/cd_nom/627745', '_photos/IMG_2073-Avec accentuation-Bruit.jpg', '_photos/IMG_2073-Avec accentuation-Bruit-2.jpg', '2023-04-20', 'Parc Naturelle Régional de la Brenne'),
(159, 'Sarcelle d’été', 'Spatula querquedula', '', '', '', NULL, 'https://inpn.mnhn.fr/espece/cd_nom/836222/', '', '', NULL, 'Réserve Naturelle Régionale du Marais de la Vacherie, Champagné-les-Marais'),
(160, 'Pluvier argenté', 'Pluvialis squatarola', '', '', '', '2023-02-09', 'https://inpn.mnhn.fr/espece/cd_nom/3165/', '_photos/1681136379IMG_1085.jpg', '_photos/1681136379IMG_1085-2.jpg', '2023-02-09', 'Noirmoutier'),
(161, 'Bernache cravant', 'Branta bernicla', '', '', '', '2023-02-09', 'https://inpn.mnhn.fr/espece/cd_nom/2757/', '_photos/1681136614IMG_1415-2.jpg', '_photos/1681136614IMG_1415.jpg', '2023-02-09', 'Noirmoutier'),
(162, 'Pygargue à queue blanche', 'Haliaeetus albicilla', '', '', '', NULL, 'https://inpn.mnhn.fr/espece/cd_nom/2848/', '', '', NULL, 'Lac du Der'),
(163, 'Grèbe à cou noir', 'Podiceps nigricollis', '', '', '', '2023-04-20', 'https://inpn.mnhn.fr/espece/cd_nom/974/', '_photos/1683459181IMG_2112-Avec accentuation-Bruit.jpg', '_photos/1683459181IMG_2112-Avec accentuation-Bruit-2.jpg', '2023-04-20', 'Parc Naturelle Régional de la Brenne'),
(164, 'Guifette moustac', 'Chlidonias hybrida', '', '', '', '2023-04-20', 'https://inpn.mnhn.fr/espece/cd_nom/459627/', '_photos/1683459342IMG_2131-Avec accentuation-Bruit.jpg', '_photos/1683459342IMG_2131-Avec accentuation-Bruit-2.jpg', '2023-04-20', 'Parc Naturelle Régional de la Brenne'),
(165, 'Butor étoilé', 'Botaurus stellaris', '', '', '', NULL, 'https://inpn.mnhn.fr/espece/cd_nom/2473/', '', '', NULL, 'Parc Naturelle Régional de la Brenne'),
(166, 'Tourterelle des bois', 'Streptopelia turtur', '', '', '', NULL, 'https://inpn.mnhn.fr/espece/cd_nom/3439/', '', '', NULL, 'La Brelaizière'),
(167, 'Pouillot de Bonelli', 'Phylloscopus bonelli', '', '', '', NULL, 'https://inpn.mnhn.fr/espece/cd_nom/4269/', '', '', NULL, ''),
(168, 'Faucon hobereau', 'Falco subbuteo', '', '', '', '2023-05-17', 'https://inpn.mnhn.fr/espece/cd_nom/2679/', '_photos/1684354165IMG_3298-2.jpg', '_photos/1684354165IMG_3298-3.jpg', '2023-05-17', 'Les Sables d’Olonne'),
(169, 'Bruant proyer', 'Emberiza calandra', '', '', '', '2023-05-27', 'https://inpn.mnhn.fr/espece/cd_nom/4686/', '_photos/1685480015IMG_3731-Avec accentuation-Bruit-2.jpg', '_photos/1685480015IMG_3731-Avec accentuation-Bruit.jpg', '2023-05-27', 'Réserve Naturelle Régionale du Marais de la Vacherie, Champagné-les-Marais'),
(170, 'Busard cendré', 'Circus pygargus', '', '', '', '2023-05-27', 'https://inpn.mnhn.fr/espece/cd_nom/2887/', '_photos/1685480205IMG_3803-2.jpg', '_photos/1685480205IMG_3803.jpg', '2023-05-27', 'Réserve Naturelle Régionale du Marais de la Vacherie, Champagné-les-Marais'),
(171, 'Engoulevent d’Europe', 'Caprimulgus europaeus', '', '', '', NULL, 'https://inpn.mnhn.fr/espece/cd_nom/3540/', '', '', NULL, 'Forêt d’Aizenay'),
(172, 'Courlis cendré', 'Numenius arquata', '', '', '', '2023-07-12', 'https://inpn.mnhn.fr/espece/cd_nom/2576', '_photos/1689179492IMG_3965.jpg', '_photos/1689179492IMG_3965-2.jpg', '2023-07-12', 'Pointe de l’Aiguillon, l’Aiguillon-la-Presqu’île'),
(173, 'Accenteur alpin', 'Prunella collaris', 'Prunellidé', 'Espèce présente en altitude. Alpes, Massif Central, Pyrénées.', '', '2024-08-01', 'https://inpn.mnhn.fr/espece/cd_nom/3984', '_photos/1733302515_IMG_5035-2.jpg', '_photos/1733302515_IMG_5035.jpg', '2024-08-01', 'La Rosière, Montvalezan');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `lepido`
--
ALTER TABLE `lepido`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `oiseaux`
--
ALTER TABLE `oiseaux`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `lepido`
--
ALTER TABLE `lepido`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT pour la table `oiseaux`
--
ALTER TABLE `oiseaux`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=174;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
