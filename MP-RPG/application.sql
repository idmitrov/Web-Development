-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.6.24 - MySQL Community Server (GPL)
-- Server OS:                    Win32
-- HeidiSQL Version:             9.3.0.4984
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping database structure for application
DROP DATABASE IF EXISTS `application`;
CREATE DATABASE IF NOT EXISTS `application` /*!40100 DEFAULT CHARACTER SET latin1 COLLATE latin1_general_ci */;
USE `application`;


-- Dumping structure for table application.buildings
DROP TABLE IF EXISTS `buildings`;
CREATE TABLE IF NOT EXISTS `buildings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE latin1_general_ci NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- Dumping data for table application.buildings: ~2 rows (approximately)
DELETE FROM `buildings`;
/*!40000 ALTER TABLE `buildings` DISABLE KEYS */;
INSERT INTO `buildings` (`id`, `name`) VALUES
	(1, 'Dark Tower'),
	(2, 'Base Camp');
/*!40000 ALTER TABLE `buildings` ENABLE KEYS */;


-- Dumping structure for table application.building_levels
DROP TABLE IF EXISTS `building_levels`;
CREATE TABLE IF NOT EXISTS `building_levels` (
  `id` int(11) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `building_id` int(11) NOT NULL DEFAULT '0',
  `level` int(11) NOT NULL DEFAULT '0',
  `gold` int(11) NOT NULL DEFAULT '0',
  `food` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `FK_building_levels_buildings` (`building_id`),
  KEY `level` (`level`),
  CONSTRAINT `FK_building_levels_buildings` FOREIGN KEY (`building_id`) REFERENCES `buildings` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- Dumping data for table application.building_levels: ~8 rows (approximately)
DELETE FROM `building_levels`;
/*!40000 ALTER TABLE `building_levels` DISABLE KEYS */;
INSERT INTO `building_levels` (`id`, `building_id`, `level`, `gold`, `food`) VALUES
	(00000000001, 1, 1, 200, 400),
	(00000000002, 1, 2, 400, 800),
	(00000000003, 1, 3, 800, 1000),
	(00000000004, 2, 1, 100, 200),
	(00000000005, 2, 2, 200, 400),
	(00000000006, 2, 3, 400, 500),
	(00000000007, 1, 0, 0, 0),
	(00000000008, 2, 0, 0, 0);
/*!40000 ALTER TABLE `building_levels` ENABLE KEYS */;


-- Dumping structure for table application.users
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE latin1_general_ci NOT NULL DEFAULT '0',
  `password` varchar(255) COLLATE latin1_general_ci NOT NULL DEFAULT '0',
  `gold` int(11) NOT NULL DEFAULT '0',
  `food` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- Dumping data for table application.users: ~1 rows (approximately)
DELETE FROM `users`;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `username`, `password`, `gold`, `food`) VALUES
	(1, 'mitko', '$2y$10$eyn2Vr4BCY7CmwX3p/1OQu9xneGR5fKKiQS9TlTqQgpd79tzSOiDK', 1500, 1500);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;


-- Dumping structure for table application.user_buildings
DROP TABLE IF EXISTS `user_buildings`;
CREATE TABLE IF NOT EXISTS `user_buildings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `building_id` int(11) NOT NULL DEFAULT '0',
  `level_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `FK_user_buildings_users` (`user_id`),
  KEY `FK_user_buildings_buildings` (`building_id`),
  KEY `FK_user_buildings_building_levels` (`level_id`),
  CONSTRAINT `FK_user_buildings_building_level` FOREIGN KEY (`level_id`) REFERENCES `building_levels` (`level`),
  CONSTRAINT `FK_user_buildings_buildings` FOREIGN KEY (`building_id`) REFERENCES `buildings` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_user_buildings_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- Dumping data for table application.user_buildings: ~0 rows (approximately)
DELETE FROM `user_buildings`;
/*!40000 ALTER TABLE `user_buildings` DISABLE KEYS */;
INSERT INTO `user_buildings` (`id`, `user_id`, `building_id`, `level_id`) VALUES
	(2, 1, 1, 0),
	(3, 1, 2, 2);
/*!40000 ALTER TABLE `user_buildings` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
