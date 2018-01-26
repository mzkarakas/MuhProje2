-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.7.14 - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Version:             9.4.0.5154
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for sonsuz_form
CREATE DATABASE IF NOT EXISTS `sonsuz_form` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `sonsuz_form`;

-- Dumping structure for table sonsuz_form.ders
CREATE TABLE IF NOT EXISTS `ders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ders_adi` varchar(250) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- Dumping data for table sonsuz_form.ders: ~8 rows (approximately)
/*!40000 ALTER TABLE `ders` DISABLE KEYS */;
INSERT INTO `ders` (`id`, `ders_adi`) VALUES
	(1, 'Matematik'),
	(2, 'Fizik'),
	(3, 'Kimya'),
	(4, 'Beden'),
	(5, 'Müzik'),
	(6, 'Edebiyat'),
	(7, 'Matematik'),
	(8, 'Beden');
/*!40000 ALTER TABLE `ders` ENABLE KEYS */;

-- Dumping structure for table sonsuz_form.ogrenci
CREATE TABLE IF NOT EXISTS `ogrenci` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `adi` varchar(50) NOT NULL,
  `soyadi` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- Dumping data for table sonsuz_form.ogrenci: ~3 rows (approximately)
/*!40000 ALTER TABLE `ogrenci` DISABLE KEYS */;
INSERT INTO `ogrenci` (`id`, `adi`, `soyadi`) VALUES
	(1, 'Ali', 'Gezer'),
	(2, 'Murat', 'Doğan'),
	(3, 'Hasan', 'Gezer');
/*!40000 ALTER TABLE `ogrenci` ENABLE KEYS */;

-- Dumping structure for table sonsuz_form.ogrenci2ders
CREATE TABLE IF NOT EXISTS `ogrenci2ders` (
  `ogrenciID` int(11) NOT NULL,
  `dersID` int(11) NOT NULL,
  PRIMARY KEY (`ogrenciID`,`dersID`),
  KEY `ogrenciID` (`ogrenciID`),
  KEY `dersID` (`dersID`),
  CONSTRAINT `FK_ogrenci2ders_ders` FOREIGN KEY (`dersID`) REFERENCES `ders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_ogrenci2ders_ogrenci` FOREIGN KEY (`ogrenciID`) REFERENCES `ogrenci` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table sonsuz_form.ogrenci2ders: ~8 rows (approximately)
/*!40000 ALTER TABLE `ogrenci2ders` DISABLE KEYS */;
INSERT INTO `ogrenci2ders` (`ogrenciID`, `dersID`) VALUES
	(1, 1),
	(1, 2),
	(1, 3),
	(2, 4),
	(2, 5),
	(3, 6),
	(3, 7),
	(3, 8);
/*!40000 ALTER TABLE `ogrenci2ders` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
