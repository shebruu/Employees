-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 20 fév. 2024 à 20:36
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `employees`
--

-- --------------------------------------------------------

--
-- Structure de la table `collaborators`
--

CREATE TABLE `collaborators` (
  `id` int(11) NOT NULL,
  `birth_date` date NOT NULL,
  `firstname` varchar(14) NOT NULL,
  `lastname` varchar(16) NOT NULL,
  `gender` varchar(1) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `hire_date` date NOT NULL,
  `password` varchar(255) NOT NULL,
  `roles` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL COMMENT '(DC2Type:json)' CHECK (json_valid(`roles`)),
  `is_verified` tinyint(1) NOT NULL,
  `group_code` varchar(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `collaborators`
--

INSERT INTO `collaborators` (`id`, `birth_date`, `firstname`, `lastname`, `gender`, `photo`, `email`, `hire_date`, `password`, `roles`, `is_verified`, `group_code`) VALUES
(10001, '1953-09-02', 'Georgi', 'Facello', 'M', 'employees\\images\\me.jpg', 'georgi@sull.com', '1986-06-26', '$2y$13$/V/thb4qWDwMzz0Sizm5..Zwfu04B2Ena4xqYZKcD/ud0SFqBs6Ru', '[\"ROLE_ADMIN\"]', 0, NULL),
(10002, '1964-06-02', 'Bezalel', 'Simmel', 'F', NULL, NULL, '1985-11-21', '', '[\"ROLE_USER\"]', 0, NULL),
(10003, '1959-12-03', 'Parto', 'Bamford', 'M', NULL, NULL, '1986-08-28', '', '[\"ROLE_USER\"]', 0, NULL),
(10004, '1954-05-01', 'Chirstian', 'Koblick', 'M', NULL, NULL, '1986-12-01', '', '[\"ROLE_USER\"]', 0, NULL),
(10005, '1955-01-21', 'Kyoichi', 'Maliniak', 'M', NULL, NULL, '1989-09-12', '', '[\"ROLE_USER\"]', 0, NULL),
(10006, '1953-04-20', 'Anneke', 'Preusig', 'F', NULL, 'anneke@gmail.com', '1989-06-02', '$2y$13$FApNSaKfDNhtR/ryHnY85uJGNptUXz3JdJxEjFpoY0Kt1QyJGDTqW', '[\"ROLE_comptable\"]', 0, NULL),
(10007, '1957-05-23', 'Tzvetan', 'Zielinski', 'F', NULL, NULL, '1989-02-10', '', '[\"ROLE_USER\"]', 0, NULL),
(10008, '1958-02-19', 'Saniya', 'Kalloufi', 'M', NULL, NULL, '1994-09-15', '', '[\"ROLE_USER\"]', 0, NULL),
(10009, '1952-04-19', 'Sumant', 'Peac', 'F', NULL, 'sumo12@gmail.com', '1985-02-18', '$2y$13$/qqI4PVfcdzPhfe8BJUsE.0aahP47HvF1daLfrlGOfHaIGjunA3x.', '[\"ROLE_USER\"]', 0, NULL),
(10010, '1963-06-01', 'Duangkaew', 'Piveteau', 'F', NULL, NULL, '1989-08-24', '', '[\"ROLE_USER\"]', 0, NULL);

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `current_dept_emp`
-- (Voir ci-dessous la vue réelle)
--
CREATE TABLE `current_dept_emp` (
);

-- --------------------------------------------------------

--
-- Structure de la table `demand`
--

CREATE TABLE `demand` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `type` varchar(60) NOT NULL,
  `about` varchar(30) NOT NULL,
  `status` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `demand`
--

INSERT INTO `demand` (`id`, `employee_id`, `type`, `about`, `status`) VALUES
(1, 10008, 'Augmentation salaire', '300', NULL),
(2, 10003, 'Achat de voiture', '10000', NULL),
(3, 10007, 'Augmentation salaire', '400', NULL),
(4, 10001, 'Achat matriel informatique', '1000', NULL),
(5, 10010, 'Remboursement transport', '500', NULL),
(6, 10005, 'Achat de voiture', '4000', NULL),
(7, 10004, 'Achat de voiture ', '5000', NULL),
(8, 10007, 'Cheque repas', '500', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `departments`
--

CREATE TABLE `departments` (
  `id` int(11) NOT NULL,
  `dept_no` char(4) NOT NULL,
  `dept_name` varchar(40) NOT NULL,
  `description` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `roi_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `departments`
--

INSERT INTO `departments` (`id`, `dept_no`, `dept_name`, `description`, `address`, `roi_url`) VALUES
(1, 'd009', 'Customer Service', ' Le département dédié à la satisfaction et au soutien de nos clients, offrant une assistance de qualité supérieure.', '100 Avenue du Service, Bruxelles, Belgique', ' https://www.entreprise.com/customer-service'),
(2, 'd005', 'Development', 'Ce département se concentre sur l\'innovation et le développement de nouveaux produits et services.', '200 Boulevard de l\'Innovation, Bruxelles, Belgique', 'https://www.entreprise.com/development'),
(3, 'd002', 'Finance', 'Responsable de la gestion financière, de la planification budgétaire et de l\'analyse économique.', '300 Rue de la Finance, Gant, Belgique', 'https://www.entreprise.com/finance'),
(4, 'd003', 'Human Resources', 'Dédié à la gestion du personnel, au recrutement et au développement des compétences.', '400 Avenue des Talents, Charleroi, Belgique', ' https://www.entreprise.com/human-resources'),
(5, 'd001', 'Marketing', 'Concentré sur la promotion, la publicité et la recherche de marché pour stimuler les ventes.', ' 500 Route de la Communication, Liege, Belgique', 'https://www.entreprise.com/production'),
(6, 'd004', 'Production', 'Supervise la fabrication des produits, assurant qualité et efficacité dans la production.', '600 Chemin de l\'Usine, Wavre, Belgique', ' https://www.entreprise.com/production'),
(7, 'd006', 'Quality Management', 'Assure la qualité des produits et services et gère les normes de contrôle qualité.', '700 Rue de la Qualité, LosAngeles, USA', ' https://www.entreprise.com/quality-management'),
(8, 'd008', 'Research', 'Se consacre à la recherche et au développement, explorant de nouvelles idées et technologies.', '800 Allée de la Science, Teheran, Iran', 'https://www.entreprise.com/research'),
(9, 'd007', 'Sales', 'Pilier de la croissance commerciale, gère les relations avec la clientèle et les ventes.', '900 Voie du Commerce, Istanbul, Turquie', 'https://www.entreprise.com/sales');

-- --------------------------------------------------------

--
-- Structure de la table `dept_emp`
--

CREATE TABLE `dept_emp` (
  `employee_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `dept_no` char(4) NOT NULL,
  `from_date` date NOT NULL,
  `to_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `dept_emp`
--

INSERT INTO `dept_emp` (`employee_id`, `department_id`, `dept_no`, `from_date`, `to_date`) VALUES
(10001, 2, 'd005', '1986-06-26', '9999-01-01'),
(10001, 8, 'd008', '2024-01-16', '9999-01-01'),
(10002, 9, 'd007', '1996-08-03', '9999-01-01'),
(10003, 6, 'd004', '1995-12-03', '9999-01-01'),
(10004, 6, 'd004', '1986-12-01', '9999-01-01'),
(10005, 4, 'd003', '1989-09-12', '9999-01-01'),
(10006, 2, 'd005', '1990-08-05', '9999-01-01'),
(10007, 8, 'd008', '1989-02-10', '9999-01-01'),
(10008, 2, 'd005', '1998-03-11', '2000-07-31'),
(10009, 7, 'd006', '1985-02-18', '9999-01-01'),
(10010, 6, 'd004', '1996-11-24', '2000-06-26'),
(10010, 7, 'd006', '2000-06-26', '9999-01-01');

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `dept_emp_latest_date`
-- (Voir ci-dessous la vue réelle)
--
CREATE TABLE `dept_emp_latest_date` (
);

-- --------------------------------------------------------

--
-- Structure de la table `dept_manager`
--

CREATE TABLE `dept_manager` (
  `department_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `dept_name` varchar(255) DEFAULT NULL,
  `from_date` date DEFAULT NULL,
  `to_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `dept_manager`
--

INSERT INTO `dept_manager` (`department_id`, `employee_id`, `dept_name`, `from_date`, `to_date`) VALUES
(3, 10006, 'Finance', '2024-01-19', '2024-06-14'),
(3, 10008, 'Marketing', '2024-01-01', '2024-07-19'),
(7, 10005, 'Quality Management', '2024-01-08', '2024-07-19');

-- --------------------------------------------------------

--
-- Structure de la table `dept_title`
--

CREATE TABLE `dept_title` (
  `dept_no` char(4) NOT NULL,
  `title_no` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `dept_title`
--

INSERT INTO `dept_title` (`dept_no`, `title_no`) VALUES
('d001', 3),
('d001', 2),
('d004', 5),
('d003', 5);

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `employee_mission`
--

CREATE TABLE `employee_mission` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `mission_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `employee_mission`
--

INSERT INTO `employee_mission` (`id`, `employee_id`, `mission_id`) VALUES
(1, 10001, 1),
(2, 10001, 2),
(3, 10003, 6),
(4, 10004, 4),
(5, 10008, 7),
(6, 10009, 5),
(7, 10006, 2);

-- --------------------------------------------------------

--
-- Structure de la table `emp_title`
--

CREATE TABLE `emp_title` (
  `emp_no` int(11) NOT NULL,
  `title_no` int(11) NOT NULL,
  `from_date` date NOT NULL,
  `to_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `emp_title`
--

INSERT INTO `emp_title` (`emp_no`, `title_no`, `from_date`, `to_date`) VALUES
(10001, 1, '1986-06-26', '9999-01-01'),
(10002, 2, '1996-08-03', '9999-01-01'),
(10003, 1, '1995-12-03', '9999-01-01'),
(10004, 1, '1995-12-01', '9999-01-01'),
(10004, 3, '1986-12-01', '1995-12-01'),
(10005, 2, '1989-09-12', '1996-09-12'),
(10005, 4, '1996-09-12', '9999-01-01'),
(10006, 1, '1990-08-05', '9999-01-01'),
(10007, 2, '1989-02-10', '1996-02-11'),
(10007, 4, '1996-02-11', '9999-01-01'),
(10008, 5, '1998-03-11', '2000-07-31'),
(10009, 1, '1995-02-18', '9999-01-01'),
(10009, 3, '1990-02-18', '1995-02-18'),
(10009, 5, '1985-02-18', '1990-02-18'),
(10010, 3, '1996-11-24', '9999-01-01');

-- --------------------------------------------------------

--
-- Structure de la table `groups`
--

CREATE TABLE `groups` (
  `code` char(4) NOT NULL,
  `name` varchar(60) NOT NULL,
  `max_size` smallint(5) UNSIGNED NOT NULL,
  `created_at` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `groups`
--

INSERT INTO `groups` (`code`, `name`, `max_size`, `created_at`) VALUES
('A1', 'Alpha', 4, '2023-01-01'),
('B2', 'Beta', 2, '2024-02-03'),
('G3', 'Gamma', 3, '2023-01-15');

-- --------------------------------------------------------

--
-- Structure de la table `interns`
--

CREATE TABLE `interns` (
  `id` int(11) NOT NULL,
  `emp_no` int(11) DEFAULT NULL,
  `fullname` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `dept_no` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `interns`
--

INSERT INTO `interns` (`id`, `emp_no`, `fullname`, `start_date`, `end_date`, `dept_no`) VALUES
(1, 10001, 'Clara Lara', '2023-01-01', '2023-04-01', 5),
(2, 10001, 'Eddy Dontoy', '2023-01-07', '2023-07-07', 3),
(3, 10001, 'Fatoumata Diallo', '2023-01-15', '2023-02-15', 3),
(4, 10006, 'Lee Chan', '2023-02-15', '2023-08-15', 4),
(5, 10001, 'serap yener', '2024-01-08', '2024-01-23', 7),
(10, 10001, 'Tatiana Deboucher', '2024-01-15', '2024-01-17', 4),
(11, 10001, 'Amelie decerise', '2024-01-09', '2024-01-12', 2);

-- --------------------------------------------------------

--
-- Structure de la table `messenger_messages`
--

CREATE TABLE `messenger_messages` (
  `id` bigint(20) NOT NULL,
  `body` longtext NOT NULL,
  `headers` longtext NOT NULL,
  `queue_name` varchar(190) NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `available_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `delivered_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `missions`
--

CREATE TABLE `missions` (
  `id` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `due_date` datetime NOT NULL,
  `status` enum('en cours','en attente','terminé') NOT NULL DEFAULT 'en attente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `missions`
--

INSERT INTO `missions` (`id`, `description`, `due_date`, `status`) VALUES
(1, 'vendre 500 unités de produit ', '2024-01-18 13:42:48', 'en attente'),
(2, 'Faire une suggestion pour ameliorer la communication', '2024-01-18 13:42:48', 'en attente'),
(3, 'Mise a jour des données', '2024-01-18 14:53:43', 'en cours'),
(4, 'Proposer de nouvelles idées pour renforcer l\' esprit équipe', '2024-01-18 19:56:41', 'en attente'),
(5, 'Proposer des idées pour améliorer la Sécurité ', '2024-01-18 19:56:41', 'en attente'),
(6, 'Améliorer l\' espace de travail ', '2024-01-18 20:01:25', 'en cours'),
(7, 'Préparer 5 question pour une enquete de satisfaction', '2024-01-18 20:01:25', 'terminé');

-- --------------------------------------------------------

--
-- Structure de la table `partners`
--

CREATE TABLE `partners` (
  `id` int(11) NOT NULL,
  `nom_entreprise` varchar(30) NOT NULL,
  `websiteurl` varchar(255) NOT NULL,
  `adresse` varchar(50) DEFAULT NULL,
  `tel` int(12) DEFAULT NULL,
  `logo` varchar(60) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `partners`
--

INSERT INTO `partners` (`id`, `nom_entreprise`, `websiteurl`, `adresse`, `tel`, `logo`) VALUES
(1, 'Microsoft', 'https://www.microsoft.com/fr-be/', NULL, NULL, 'microsoft.png'),
(2, 'Apple', 'https://www.apple.com/be-fr/store', NULL, NULL, 'apple.png'),
(4, 'Amazon', 'https://www.amazon.com.be/', NULL, NULL, 'amazone.png'),
(5, 'Cisco', 'https://www.cisco.com/c/fr_be/index.html', NULL, NULL, 'cisco2.png'),
(6, 'Ottobock', 'https://www.ottobock.com/fr-fr/Accueil', NULL, NULL, 'ottoboock.jpg'),
(7, 'Materialise', 'https://www.materialise.com/fr', NULL, NULL, 'materialise.png');

-- --------------------------------------------------------

--
-- Structure de la table `project_employee`
--

CREATE TABLE `project_employee` (
  `project_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `project_employee`
--

INSERT INTO `project_employee` (`project_id`, `employee_id`) VALUES
(1, 10005),
(1, 10010);

-- --------------------------------------------------------

--
-- Structure de la table `projets`
--

CREATE TABLE `projets` (
  `id` int(11) NOT NULL,
  `chef_projet` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `date_creation` datetime NOT NULL,
  `modified` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `projets`
--

INSERT INTO `projets` (`id`, `chef_projet`, `description`, `date_creation`, `modified`) VALUES
(1, 10001, 'Projet1 ', '2020-10-15 12:00:00', NULL),
(2, 10003, 'projet2 ', '2021-01-27 16:45:00', NULL),
(3, 10004, 'projet 3', '2021-01-30 18:00:00', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `salaries`
--

CREATE TABLE `salaries` (
  `id` int(11) NOT NULL,
  `emp_no` int(11) NOT NULL,
  `salary` int(11) NOT NULL,
  `from_date` date NOT NULL,
  `to_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `salaries`
--

INSERT INTO `salaries` (`id`, `emp_no`, `salary`, `from_date`, `to_date`) VALUES
(1, 10001, 60117, '1986-06-26', '1987-06-26'),
(2, 10001, 62102, '1987-06-26', '1988-06-25'),
(3, 10001, 66074, '1988-06-25', '1989-06-25'),
(4, 10001, 66596, '1989-06-25', '1990-06-25'),
(5, 10001, 66961, '1990-06-25', '1991-06-25'),
(6, 10001, 71046, '1991-06-25', '1992-06-24'),
(7, 10001, 74333, '1992-06-24', '1993-06-24'),
(8, 10001, 75286, '1993-06-24', '1994-06-24'),
(9, 10001, 75994, '1994-06-24', '1995-06-24'),
(10, 10001, 76884, '1995-06-24', '1996-06-23'),
(11, 10001, 80013, '1996-06-23', '1997-06-23'),
(12, 10001, 81025, '1997-06-23', '1998-06-23'),
(13, 10001, 81097, '1998-06-23', '1999-06-23'),
(14, 10001, 84917, '1999-06-23', '2000-06-22'),
(15, 10001, 85112, '2000-06-22', '2001-06-22'),
(16, 10001, 85097, '2001-06-22', '2002-06-22'),
(17, 10001, 88958, '2002-06-22', '9999-01-01'),
(18, 10002, 65828, '1996-08-03', '1997-08-03'),
(19, 10002, 65909, '1997-08-03', '1998-08-03'),
(20, 10002, 67534, '1998-08-03', '1999-08-03'),
(21, 10002, 69366, '1999-08-03', '2000-08-02'),
(22, 10002, 71963, '2000-08-02', '2001-08-02'),
(23, 10002, 72527, '2001-08-02', '9999-01-01'),
(24, 10003, 40006, '1995-12-03', '1996-12-02'),
(25, 10003, 43616, '1996-12-02', '1997-12-02'),
(26, 10003, 43466, '1997-12-02', '1998-12-02'),
(27, 10003, 43636, '1998-12-02', '1999-12-02'),
(28, 10003, 43478, '1999-12-02', '2000-12-01'),
(29, 10003, 43699, '2000-12-01', '2001-12-01'),
(30, 10003, 43311, '2001-12-01', '9999-01-01'),
(31, 10004, 40054, '1986-12-01', '1987-12-01'),
(32, 10004, 42283, '1987-12-01', '1988-11-30'),
(33, 10004, 42542, '1988-11-30', '1989-11-30'),
(34, 10004, 46065, '1989-11-30', '1990-11-30'),
(35, 10004, 48271, '1990-11-30', '1991-11-30'),
(36, 10004, 50594, '1991-11-30', '1992-11-29'),
(37, 10004, 52119, '1992-11-29', '1993-11-29'),
(38, 10004, 54693, '1993-11-29', '1994-11-29'),
(39, 10004, 58326, '1994-11-29', '1995-11-29'),
(40, 10004, 60770, '1995-11-29', '1996-11-28'),
(41, 10004, 62566, '1996-11-28', '1997-11-28'),
(42, 10004, 64340, '1997-11-28', '1998-11-28'),
(43, 10004, 67096, '1998-11-28', '1999-11-28'),
(44, 10004, 69722, '1999-11-28', '2000-11-27'),
(45, 10004, 70698, '2000-11-27', '2001-11-27'),
(46, 10004, 74057, '2001-11-27', '9999-01-01'),
(47, 10005, 78228, '1989-09-12', '1990-09-12'),
(48, 10005, 82621, '1990-09-12', '1991-09-12'),
(49, 10005, 83735, '1991-09-12', '1992-09-11'),
(50, 10005, 85572, '1992-09-11', '1993-09-11'),
(51, 10005, 85076, '1993-09-11', '1994-09-11'),
(52, 10005, 86050, '1994-09-11', '1995-09-11'),
(53, 10005, 88448, '1995-09-11', '1996-09-10'),
(54, 10005, 88063, '1996-09-10', '1997-09-10'),
(55, 10005, 89724, '1997-09-10', '1998-09-10'),
(56, 10005, 90392, '1998-09-10', '1999-09-10'),
(57, 10005, 90531, '1999-09-10', '2000-09-09'),
(58, 10005, 91453, '2000-09-09', '2001-09-09'),
(59, 10005, 94692, '2001-09-09', '9999-01-01'),
(60, 10006, 40000, '1990-08-05', '1991-08-05'),
(61, 10006, 42085, '1991-08-05', '1992-08-04'),
(62, 10006, 42629, '1992-08-04', '1993-08-04'),
(63, 10006, 45844, '1993-08-04', '1994-08-04'),
(64, 10006, 47518, '1994-08-04', '1995-08-04'),
(65, 10006, 47917, '1995-08-04', '1996-08-03'),
(66, 10006, 52255, '1996-08-03', '1997-08-03'),
(67, 10006, 53747, '1997-08-03', '1998-08-03'),
(68, 10006, 56032, '1998-08-03', '1999-08-03'),
(69, 10006, 58299, '1999-08-03', '2000-08-02'),
(70, 10006, 60098, '2000-08-02', '2001-08-02'),
(71, 10006, 59755, '2001-08-02', '9999-01-01'),
(72, 10007, 56724, '1989-02-10', '1990-02-10'),
(73, 10007, 60740, '1990-02-10', '1991-02-10'),
(74, 10007, 62745, '1991-02-10', '1992-02-10'),
(75, 10007, 63475, '1992-02-10', '1993-02-09'),
(76, 10007, 63208, '1993-02-09', '1994-02-09'),
(77, 10007, 64563, '1994-02-09', '1995-02-09'),
(78, 10007, 68833, '1995-02-09', '1996-02-09'),
(79, 10007, 70220, '1996-02-09', '1997-02-08'),
(80, 10007, 73362, '1997-02-08', '1998-02-08'),
(81, 10007, 75582, '1998-02-08', '1999-02-08'),
(82, 10007, 79513, '1999-02-08', '2000-02-08'),
(83, 10007, 80083, '2000-02-08', '2001-02-07'),
(84, 10007, 84456, '2001-02-07', '2002-02-07'),
(85, 10007, 88070, '2002-02-07', '9999-01-01'),
(86, 10008, 46671, '1998-03-11', '1999-03-11'),
(87, 10008, 48584, '1999-03-11', '2000-03-10'),
(88, 10008, 52668, '2000-03-10', '2000-07-31'),
(89, 10009, 60929, '1985-02-18', '1986-02-18'),
(90, 10009, 64604, '1986-02-18', '1987-02-18'),
(91, 10009, 64780, '1987-02-18', '1988-02-18'),
(92, 10009, 66302, '1988-02-18', '1989-02-17'),
(93, 10009, 69042, '1989-02-17', '1990-02-17'),
(94, 10009, 70889, '1990-02-17', '1991-02-17'),
(95, 10009, 71434, '1991-02-17', '1992-02-17'),
(96, 10009, 74612, '1992-02-17', '1993-02-16'),
(97, 10009, 76518, '1993-02-16', '1994-02-16'),
(98, 10009, 78335, '1994-02-16', '1995-02-16'),
(99, 10009, 80944, '1995-02-16', '1996-02-16'),
(100, 10009, 82507, '1996-02-16', '1997-02-15'),
(101, 10009, 85875, '1997-02-15', '1998-02-15'),
(102, 10009, 89324, '1998-02-15', '1999-02-15'),
(103, 10009, 90668, '1999-02-15', '2000-02-15'),
(104, 10009, 93507, '2000-02-15', '2001-02-14'),
(105, 10009, 94443, '2001-02-14', '2002-02-14'),
(106, 10009, 94409, '2002-02-14', '9999-01-01'),
(107, 10010, 72488, '1996-11-24', '1997-11-24'),
(108, 10010, 74347, '1997-11-24', '1998-11-24'),
(109, 10010, 75405, '1998-11-24', '1999-11-24'),
(110, 10010, 78194, '1999-11-24', '2000-11-23'),
(111, 10010, 79580, '2000-11-23', '2001-11-23'),
(112, 10010, 80324, '2001-11-23', '9999-01-01');

-- --------------------------------------------------------

--
-- Structure de la table `titles`
--

CREATE TABLE `titles` (
  `title_no` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `titles`
--

INSERT INTO `titles` (`title_no`, `title`, `description`) VALUES
(1, 'Senior Engineer', 'description'),
(2, 'Staff', 'description'),
(3, 'Engineer', 'description'),
(4, 'Senior Staff', 'description'),
(5, 'Assistant Engineer', 'description'),
(6, 'Technique Leader', 'description'),
(7, 'Manager', 'description');

-- --------------------------------------------------------

--
-- Structure de la vue `current_dept_emp`
--
DROP TABLE IF EXISTS `current_dept_emp`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `current_dept_emp`  AS SELECT `l`.`emp_no` AS `emp_no`, `d`.`dept_no` AS `dept_no`, `l`.`from_date` AS `from_date`, `l`.`to_date` AS `to_date` FROM (`dept_emp` `d` join `dept_emp_latest_date` `l` on(`d`.`emp_no` = `l`.`emp_no` and `d`.`from_date` = `l`.`from_date` and `l`.`to_date` = `d`.`to_date`)) ;

-- --------------------------------------------------------

--
-- Structure de la vue `dept_emp_latest_date`
--
DROP TABLE IF EXISTS `dept_emp_latest_date`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `dept_emp_latest_date`  AS SELECT `dept_emp`.`emp_no` AS `emp_no`, max(`dept_emp`.`from_date`) AS `from_date`, max(`dept_emp`.`to_date`) AS `to_date` FROM `dept_emp` GROUP BY `dept_emp`.`emp_no` ;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `collaborators`
--
ALTER TABLE `collaborators`
  ADD PRIMARY KEY (`id`),
  ADD KEY `group_code` (`group_code`);

--
-- Index pour la table `demand`
--
ALTER TABLE `demand`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_428D79731B65292` (`employee_id`);

--
-- Index pour la table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `dept_name` (`dept_name`);

--
-- Index pour la table `dept_emp`
--
ALTER TABLE `dept_emp`
  ADD PRIMARY KEY (`employee_id`,`department_id`),
  ADD KEY `department_id` (`department_id`);

--
-- Index pour la table `dept_manager`
--
ALTER TABLE `dept_manager`
  ADD PRIMARY KEY (`department_id`,`employee_id`),
  ADD KEY `employee_id` (`employee_id`),
  ADD KEY `dept_name` (`dept_name`);

--
-- Index pour la table `dept_title`
--
ALTER TABLE `dept_title`
  ADD KEY `dept_no` (`dept_no`),
  ADD KEY `title_no` (`title_no`);

--
-- Index pour la table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Index pour la table `employee_mission`
--
ALTER TABLE `employee_mission`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_id` (`employee_id`),
  ADD KEY `mission_id` (`mission_id`);

--
-- Index pour la table `emp_title`
--
ALTER TABLE `emp_title`
  ADD PRIMARY KEY (`emp_no`,`title_no`,`from_date`),
  ADD KEY `title_no` (`title_no`);

--
-- Index pour la table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`code`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Index pour la table `interns`
--
ALTER TABLE `interns`
  ADD PRIMARY KEY (`id`),
  ADD KEY `interns_ibfk_1` (`dept_no`),
  ADD KEY `interns_ibfk_2` (`emp_no`);

--
-- Index pour la table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  ADD KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  ADD KEY `IDX_75EA56E016BA31DB` (`delivered_at`);

--
-- Index pour la table `missions`
--
ALTER TABLE `missions`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `partners`
--
ALTER TABLE `partners`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `project_employee`
--
ALTER TABLE `project_employee`
  ADD PRIMARY KEY (`project_id`,`employee_id`),
  ADD KEY `employee_id` (`employee_id`);

--
-- Index pour la table `projets`
--
ALTER TABLE `projets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `emp_no` (`chef_projet`);

--
-- Index pour la table `salaries`
--
ALTER TABLE `salaries`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `emp_no` (`emp_no`,`from_date`);

--
-- Index pour la table `titles`
--
ALTER TABLE `titles`
  ADD PRIMARY KEY (`title_no`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `demand`
--
ALTER TABLE `demand`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `employee_mission`
--
ALTER TABLE `employee_mission`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `interns`
--
ALTER TABLE `interns`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `missions`
--
ALTER TABLE `missions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `partners`
--
ALTER TABLE `partners`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `projets`
--
ALTER TABLE `projets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `salaries`
--
ALTER TABLE `salaries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=113;

--
-- AUTO_INCREMENT pour la table `titles`
--
ALTER TABLE `titles`
  MODIFY `title_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `collaborators`
--
ALTER TABLE `collaborators`
  ADD CONSTRAINT `collaborators_ibfk_1` FOREIGN KEY (`group_code`) REFERENCES `groups` (`code`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Contraintes pour la table `demand`
--
ALTER TABLE `demand`
  ADD CONSTRAINT `demand_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `collaborators` (`id`);

--
-- Contraintes pour la table `dept_emp`
--
ALTER TABLE `dept_emp`
  ADD CONSTRAINT `dept_emp_ibfk_2` FOREIGN KEY (`employee_id`) REFERENCES `collaborators` (`id`),
  ADD CONSTRAINT `dept_emp_ibfk_3` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`);

--
-- Contraintes pour la table `dept_manager`
--
ALTER TABLE `dept_manager`
  ADD CONSTRAINT `dept_manager_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`),
  ADD CONSTRAINT `dept_manager_ibfk_2` FOREIGN KEY (`employee_id`) REFERENCES `collaborators` (`id`),
  ADD CONSTRAINT `dept_manager_ibfk_3` FOREIGN KEY (`dept_name`) REFERENCES `departments` (`dept_name`);

--
-- Contraintes pour la table `dept_title`
--
ALTER TABLE `dept_title`
  ADD CONSTRAINT `dept_title_ibfk_1` FOREIGN KEY (`dept_no`) REFERENCES `departments` (`dept_no`) ON UPDATE CASCADE,
  ADD CONSTRAINT `dept_title_ibfk_2` FOREIGN KEY (`title_no`) REFERENCES `titles` (`title_no`) ON UPDATE CASCADE,
  ADD CONSTRAINT `dept_title_ibfk_3` FOREIGN KEY (`title_no`) REFERENCES `titles` (`title_no`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `employee_mission`
--
ALTER TABLE `employee_mission`
  ADD CONSTRAINT `employee_mission_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `collaborators` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `employee_mission_ibfk_2` FOREIGN KEY (`mission_id`) REFERENCES `missions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `emp_title`
--
ALTER TABLE `emp_title`
  ADD CONSTRAINT `emp_title_ibfk_1` FOREIGN KEY (`emp_no`) REFERENCES `collaborators` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `emp_title_ibfk_2` FOREIGN KEY (`title_no`) REFERENCES `titles` (`title_no`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `interns`
--
ALTER TABLE `interns`
  ADD CONSTRAINT `interns_ibfk_1` FOREIGN KEY (`dept_no`) REFERENCES `departments` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `interns_ibfk_2` FOREIGN KEY (`emp_no`) REFERENCES `collaborators` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Contraintes pour la table `project_employee`
--
ALTER TABLE `project_employee`
  ADD CONSTRAINT `project_employee_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projets` (`id`),
  ADD CONSTRAINT `project_employee_ibfk_2` FOREIGN KEY (`employee_id`) REFERENCES `collaborators` (`id`);

--
-- Contraintes pour la table `projets`
--
ALTER TABLE `projets`
  ADD CONSTRAINT `projets_ibfk_1` FOREIGN KEY (`chef_projet`) REFERENCES `collaborators` (`id`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `salaries`
--
ALTER TABLE `salaries`
  ADD CONSTRAINT `salaries_ibfk_1` FOREIGN KEY (`emp_no`) REFERENCES `collaborators` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
