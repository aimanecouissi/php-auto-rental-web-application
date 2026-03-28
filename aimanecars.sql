-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 20, 2023 at 01:39 PM
-- Server version: 8.0.27
-- PHP Version: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `aimanecars`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `id` int NOT NULL AUTO_INCREMENT,
  `password` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `password`) VALUES
(1, '0000');

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

DROP TABLE IF EXISTS `booking`;
CREATE TABLE IF NOT EXISTS `booking` (
  `id` int NOT NULL AUTO_INCREMENT,
  `renter` int NOT NULL,
  `model` int NOT NULL,
  `payment_date` date NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `duration` int NOT NULL,
  `total_price` float NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_renter` (`renter`),
  KEY `fk_model` (`model`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `card`
--

DROP TABLE IF EXISTS `card`;
CREATE TABLE IF NOT EXISTS `card` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `number` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `mm` int NOT NULL,
  `yy` int NOT NULL,
  `cvv` int NOT NULL,
  `renter` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_renter2` (`renter`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `manufacturer`
--

DROP TABLE IF EXISTS `manufacturer`;
CREATE TABLE IF NOT EXISTS `manufacturer` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(25) NOT NULL,
  `logo` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `manufacturer`
--

INSERT INTO `manufacturer` (`id`, `name`, `logo`) VALUES
(1, 'Ferrari', 'files/cars/logos/ferrari.png'),
(2, 'McLaren', 'files/cars/logos/mclaren.png'),
(3, 'Porsche', 'files/cars/logos/porsche.png'),
(4, 'Lamborghini', 'files/cars/logos/lamborghini.png'),
(5, 'Maserati', 'files/cars/logos/maserati.png'),
(6, 'Audi', 'files/cars/logos/audi.png'),
(7, 'Ford', 'files/cars/logos/ford.png'),
(8, 'Aston Martin', 'files/cars/logos/aston martin.png'),
(9, 'Bugatti', 'files/cars/logos/bugatti.png'),
(10, 'Koenigsegg', 'files/cars/logos/koenigsegg.png ');

-- --------------------------------------------------------

--
-- Table structure for table `model`
--

DROP TABLE IF EXISTS `model`;
CREATE TABLE IF NOT EXISTS `model` (
  `id` int NOT NULL AUTO_INCREMENT,
  `image` text CHARACTER SET utf8 COLLATE utf8_general_ci,
  `name` varchar(25) NOT NULL,
  `price` float NOT NULL,
  `details` text NOT NULL,
  `manufacturer` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_manufaturer` (`manufacturer`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `model`
--

INSERT INTO `model` (`id`, `image`, `name`, `price`, `details`, `manufacturer`) VALUES
(1, 'files/cars/images/296 GTB 2022.jpg', '296 GTB 2022', 100, 'https://www.ferrari.com/en-EN/auto/296-gtb', 1),
(2, 'files/cars/images/765LT 2020.jpg', '765LT 2020', 150, 'https://cars.mclaren.com/en/super-series/765lt', 2),
(3, 'files/cars/images/911 Carrera.jpg', '911 Carrera', 200, 'https://www.porsche.com/international/models/911/911-models/carrera/', 3),
(4, 'files/cars/images/F8 Tributo 2019.jpg', 'F8 Tributo 2019', 250, 'https://www.ferrari.com/en-EN/auto/f8-tributo', 1),
(5, 'files/cars/images/Huracan.jpg', 'Huracan', 300, 'https://www.lamborghini.com/en-en/models/huracan', 4),
(6, 'files/cars/images/812 GTS 2021.jpg', '812 GTS 2021', 350, 'https://www.ferrari.com/en-EN/auto/812-gts', 1),
(7, 'files/cars/images/MC20 2021.jpg', 'MC20 2021', 400, 'https://www.maserati.com/global/en/models/mc20', 5),
(8, 'files/cars/images/R8.jpg', 'R8', 450, 'https://www.audiusa.com/us/web/en/models/r8/r8-coupe/2022/overview.html', 6),
(9, 'files/cars/images/GT 2017.jpg', 'GT 2017', 500, 'https://www.ford.com/performance/gt/', 7),
(10, 'files/cars/images/DBS (2007-2012).jpg', 'DBS (2007-2012)', 550, 'https://www.astonmartin.com/en/models/past-models/dbs-dbs-volante', 8),
(11, 'files/cars/images/Chiron Super Sport 300+.jpg', 'Chiron Super Sport 300+', 600, 'https://www.bugatti.com/models/chiron-models/chiron-super-sport-300/', 9),
(12, 'files/cars/images/Agera RS.jpg', 'Agera RS', 650, 'https://www.koenigsegg.com/', 10);

-- --------------------------------------------------------

--
-- Table structure for table `renter`
--

DROP TABLE IF EXISTS `renter`;
CREATE TABLE IF NOT EXISTS `renter` (
  `id` int NOT NULL AUTO_INCREMENT,
  `photo` varchar(255) NOT NULL DEFAULT 'assets/img/renter.png',
  `first_name` varchar(25) NOT NULL,
  `last_name` varchar(25) NOT NULL,
  `cin` varchar(8) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `phone` varchar(15) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `verification_code` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `fk_model` FOREIGN KEY (`model`) REFERENCES `model` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_renter` FOREIGN KEY (`renter`) REFERENCES `renter` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `card`
--
ALTER TABLE `card`
  ADD CONSTRAINT `fk_renter2` FOREIGN KEY (`renter`) REFERENCES `renter` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `model`
--
ALTER TABLE `model`
  ADD CONSTRAINT `fk_manufacturer` FOREIGN KEY (`manufacturer`) REFERENCES `manufacturer` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
