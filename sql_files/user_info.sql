-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 20, 2021 at 07:36 AM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.2.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vipra_raipur`
--

-- --------------------------------------------------------

--
-- Table structure for table `user_info`
--

CREATE TABLE `user_info` (
  `id` int(255) NOT NULL,
  `browser_ip` varchar(255) NOT NULL,
  `system_ip` varchar(255) NOT NULL,
  `server_ip` varchar(255) NOT NULL,
  `isp` varchar(255) NOT NULL,
  `os_name` varchar(100) NOT NULL,
  `system_username` varchar(100) NOT NULL,
  `country_code` varchar(10) NOT NULL,
  `country_name` varchar(255) NOT NULL,
  `continent` varchar(50) NOT NULL,
  `time_zone` varchar(100) NOT NULL,
  `state` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `location_name` varchar(255) NOT NULL,
  `postal_code` varchar(50) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_info`
--

INSERT INTO `user_info` (`id`, `browser_ip`, `system_ip`, `server_ip`, `isp`, `os_name`, `system_username`, `country_code`, `country_name`, `continent`, `time_zone`, `state`, `city`, `location_name`, `postal_code`, `date`) VALUES
(1, '127.0.0.1', '127.0.0.1', '127.0.0.1', 'Reliance Jio Infocomm Limited', 'Ubuntu', 'vaibhav-NS14A6', 'IND', 'India', 'Asia', 'localhost', 'Chhattisgarh', 'Raipur', 'Avanti Hospital ', '492001', '2021-01-20');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `user_info`
--
ALTER TABLE `user_info`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user_info`
--
ALTER TABLE `user_info`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
