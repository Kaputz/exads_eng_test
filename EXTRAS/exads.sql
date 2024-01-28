-- Adminer 4.8.1 MySQL 8.3.0 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

CREATE DATABASE `exads` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `exads`;

DROP TABLE IF EXISTS `doctrine_migration_versions`;
CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20240125210812',	'2024-01-25 21:08:53',	97),
('DoctrineMigrations\\Version20240126211226',	'2024-01-26 21:12:48',	161);

DROP TABLE IF EXISTS `tv_series`;
CREATE TABLE `tv_series` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `channel` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `tv_series` (`id`, `title`, `channel`, `gender`) VALUES
(1,	'The Walking Dead',	'Netflix',	'Horror'),
(2,	'The Big Bang Theory',	'HBO Max',	'Comedy'),
(3,	'Game of Thrones',	'Prime Video',	'Fantasy'),
(4,	'Mandalorian',	'Disney+',	'Action');

DROP TABLE IF EXISTS `tv_series_intervals`;
CREATE TABLE `tv_series_intervals` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_tv_series_id` int NOT NULL,
  `week_day` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `show_time` time NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_6BD92DAA95A169D1` (`id_tv_series_id`),
  CONSTRAINT `FK_6BD92DAA95A169D1` FOREIGN KEY (`id_tv_series_id`) REFERENCES `tv_series` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `tv_series_intervals` (`id`, `id_tv_series_id`, `week_day`, `show_time`) VALUES
(1,	1,	'Friday',	'14:30:00'),
(2,	2,	'Friday',	'22:00:00'),
(3,	3,	'Monday',	'15:00:00'),
(4,	4,	'Wednesday',	'20:00:00'),
(5,	4,	'Saturday',	'20:00:00');

-- 2024-01-28 00:37:07
