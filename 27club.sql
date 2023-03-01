-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 17, 2022 at 01:22 AM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `27club`
--

-- --------------------------------------------------------

--
-- Table structure for table `article`
--

CREATE TABLE `article` (
  `id` int(11) NOT NULL,
  `reference` varchar(255) NOT NULL,
  `artname` varchar(255) NOT NULL,
  `categoryid` int(11) NOT NULL,
  `couleur` varchar(255) NOT NULL,
  `quantite` int(11) NOT NULL,
  `prix` varchar(255) NOT NULL,
  `prixbase` varchar(255) NOT NULL,
  `barcode` varchar(255) NOT NULL,
  `ram` int(11) NOT NULL,
  `stockage` int(11) NOT NULL,
  `batterie` int(11) NOT NULL,
  `faceid` int(11) NOT NULL,
  `emprint` int(11) NOT NULL,
  `doublesim` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `article`
--

INSERT INTO `article` (`id`, `reference`, `artname`, `categoryid`, `couleur`, `quantite`, `prix`, `prixbase`, `barcode`, `ram`, `stockage`, `batterie`, `faceid`, `emprint`, `doublesim`) VALUES
(1, '1  iphone 11464', 'iphone 11', 7, 'noir', 4, '2400', '2000', '12', 4, 64, 6000, 0, 0, 1),
(2, '20a50416', 'a50', 2, 'blanc', 1, '600', '500', '', 4, 16, 3000, 0, 0, 0),
(5, '4Y9464', 'Y9', 4, 'noir', 8, '500', '450', '4260093465551', 4, 64, 4000, 0, 0, 0),
(6, '4nova632', 'nova', 4, 'noir', 74, '700', '650', '6192011803672', 6, 32, 4000, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `catname` varchar(255) NOT NULL,
  `parentID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `catname`, `parentID`) VALUES
(1, 'telephone', 0),
(2, 'Samsung', 1),
(4, 'Huawei', 1),
(5, 'phones', 0),
(6, 'nokia', 5),
(7, 'apple', 1);

-- --------------------------------------------------------

--
-- Table structure for table `phones`
--

CREATE TABLE `phones` (
  `id` int(11) NOT NULL,
  `reference` varchar(255) NOT NULL,
  `artname` varchar(255) NOT NULL,
  `categoryid` int(11) NOT NULL,
  `couleur` varchar(255) NOT NULL,
  `quantite` int(11) NOT NULL,
  `prix` varchar(255) NOT NULL,
  `prixbase` varchar(255) NOT NULL,
  `barcode` varchar(255) NOT NULL,
  `camera` int(11) NOT NULL,
  `doublesim` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `phones`
--

INSERT INTO `phones` (`id`, `reference`, `artname`, `categoryid`, `couleur`, `quantite`, `prix`, `prixbase`, `barcode`, `camera`, `doublesim`) VALUES
(1, '6105', '105', 6, 'blue', 3, '79', '70', '123', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `groupID` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `pass`, `groupID`) VALUES
(1, 'osm', '601f1889667efaebb33b8c12572835da3f027f78', 1),
(3, 'mahdy', '601f1889667efaebb33b8c12572835da3f027f78', 0);

-- --------------------------------------------------------

--
-- Table structure for table `vente`
--

CREATE TABLE `vente` (
  `id` int(11) NOT NULL,
  `artid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `quantite` int(11) NOT NULL,
  `prix` int(11) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `vente`
--

INSERT INTO `vente` (`id`, `artid`, `userid`, `quantite`, `prix`, `date`) VALUES
(1, 1, 1, 1, 2000, '2022-11-01 15:26:21'),
(3, 1, 1, 1, 200, '2022-11-15 00:46:48'),
(4, 1, 3, 1, 30, '2022-11-15 01:15:11'),
(5, 2, 3, 1, 100, '2022-11-15 18:47:54'),
(6, 2, 3, 1, 590, '2022-11-15 19:14:06'),
(7, 2, 3, 1, 590, '2022-11-16 16:18:53'),
(8, 2, 3, 2, 1190, '2022-11-16 17:04:20'),
(9, 1, 3, 1, 2400, '2022-11-16 17:10:30'),
(10, 2, 3, 1, 550, '2022-11-16 17:16:30'),
(11, 5, 3, 2, 990, '2022-11-16 17:20:34'),
(12, 6, 3, 3, 2100, '2022-11-16 17:27:11'),
(13, 1, 3, 1, 2300, '2022-11-16 22:25:43'),
(14, 1, 3, 1, 74, '2022-11-17 00:08:09'),
(16, 1, 3, 1, 79, '2022-11-17 00:16:29');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `article`
--
ALTER TABLE `article`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categoryid` (`categoryid`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `phones`
--
ALTER TABLE `phones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cat` (`categoryid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vente`
--
ALTER TABLE `vente`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userid` (`userid`),
  ADD KEY `vente_ibfk_1` (`artid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `article`
--
ALTER TABLE `article`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `phones`
--
ALTER TABLE `phones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `vente`
--
ALTER TABLE `vente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `article`
--
ALTER TABLE `article`
  ADD CONSTRAINT `article_ibfk_1` FOREIGN KEY (`categoryid`) REFERENCES `categories` (`id`);

--
-- Constraints for table `phones`
--
ALTER TABLE `phones`
  ADD CONSTRAINT `cat` FOREIGN KEY (`categoryid`) REFERENCES `categories` (`id`);

--
-- Constraints for table `vente`
--
ALTER TABLE `vente`
  ADD CONSTRAINT `vente_ibfk_1` FOREIGN KEY (`artid`) REFERENCES `article` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `vente_ibfk_2` FOREIGN KEY (`userid`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
