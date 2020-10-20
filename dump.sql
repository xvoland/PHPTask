-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 20, 2020 at 12:23 AM
-- Server version: 5.7.31
-- PHP Version: 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gear4music`
--

-- --------------------------------------------------------

--
-- Table structure for table `batches`
--

CREATE TABLE `batches` (
  `id_batch` int(10) UNSIGNED NOT NULL,
  `batch_name` varchar(64) NOT NULL,
  `batch_status` int(1) UNSIGNED NOT NULL DEFAULT '0',
  `batch_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `batches`
--

INSERT INTO `batches` (`id_batch`, `batch_name`, `batch_status`, `batch_time`) VALUES
(1, 'First', 0, '2020-10-18 13:19:26');

-- --------------------------------------------------------

--
-- Table structure for table `consignment`
--

CREATE TABLE `consignment` (
  `id` int(10) UNSIGNED NOT NULL,
  `status` int(1) UNSIGNED NOT NULL DEFAULT '0',
  `id_batch` int(10) UNSIGNED NOT NULL,
  `sku` varchar(16) NOT NULL,
  `mailservice` varchar(32) NOT NULL,
  `firstname` varchar(64) NOT NULL,
  `lastname` varchar(64) NOT NULL,
  `email` varchar(64) NOT NULL,
  `phone` varchar(32) NOT NULL,
  `address` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `consignment`
--

INSERT INTO `consignment` (`id`, `status`, `id_batch`, `sku`, `mailservice`, `firstname`, `lastname`, `email`, `phone`, `address`) VALUES
(1, 0, 1, 'SKU-10', 'myhermes', 'First', 'Last', 'xxx@xxx.com', '123-123-123', 'Address1, street'),
(2, 0, 1, 'SKU-02', 'royalmail', 'RoyalFirst', 'RoyalLast', 'royal@xxx.com', '321-321-321', 'Royal park 1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `batches`
--
ALTER TABLE `batches`
  ADD PRIMARY KEY (`id_batch`),
  ADD KEY `batchstatus` (`batch_status`),
  ADD KEY `batchtime` (`batch_time`);

--
-- Indexes for table `consignment`
--
ALTER TABLE `consignment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `batches` (`id_batch`),
  ADD KEY `status` (`status`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `batches`
--
ALTER TABLE `batches`
  MODIFY `id_batch` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `consignment`
--
ALTER TABLE `consignment`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
