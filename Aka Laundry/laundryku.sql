-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 02, 2026 at 03:17 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laundryku`
--

-- --------------------------------------------------------

--
-- Table structure for table `laundryku`
--

CREATE TABLE `laundryku` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `username` text DEFAULT NULL,
  `password` varchar(200) NOT NULL,
  `level` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `laundryku`
--

INSERT INTO `laundryku` (`id`, `name`, `username`, `password`, `level`) VALUES
(16, 'Fadlii', 'fadli889', '$2y$10$1jJlSLRSl53WMO.uMfg.sOfQLur1u4.TnsElg1cn/oyoucnHNZCTm', 'superadmin'),
(19, 'Aqshal', 'aqshal889', '$2y$10$t7pAp9S/k/EtZPu3Phpxzu9o0HDs2Mica0uV3iJBOtN7zWFp4W4kC', 'admin'),
(20, 'Renata', 'renata889', '$2y$10$zxBPnlO9oTrjYawdEwfC3.KCkMUIHZYi/Po9eWo4F9.2haJCLBts2', 'admin'),
(21, 'dimas lontong', 'dimas889', '$2y$10$d3tOlihx3oRji6x7jH.tiOQEWm8YlWNSDUqDboIlA4mXt5mywDcpC', 'washer'),
(22, 'Raras', 'raras889', '$2y$10$wEZNPX8WyOgAHDq0AFGhY.yINIa4EIxkJdcp/kOKraTxEpUVm5YyS', 'washer');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `laundryku`
--
ALTER TABLE `laundryku`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `laundryku`
--
ALTER TABLE `laundryku`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
