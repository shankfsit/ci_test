-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 29, 2020 at 01:59 PM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.1.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `host_test`
--

-- --------------------------------------------------------

--
-- Table structure for table `user_domain`
--

CREATE TABLE `user_domain` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` bigint(20) NOT NULL,
  `watsapp_no` bigint(20) NOT NULL,
  `domain_name` varchar(100) NOT NULL,
  `domain_date` date NOT NULL,
  `hosting_package` varchar(50) NOT NULL,
  `hosting_date` date NOT NULL,
  `uploads` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_domain`
--

INSERT INTO `user_domain` (`id`, `name`, `email`, `phone`, `watsapp_no`, `domain_name`, `domain_date`, `hosting_package`, `hosting_date`, `uploads`, `created_at`) VALUES
(1, 'virat kohli', 'virat@gmail.com', 1234567890, 1236547890, 'virat11.com', '2020-03-29', 'gold', '2020-03-22', 'user_domain1.csv', '2020-03-29 11:56:05'),
(2, 'Rohit Sharma', 'rohit@gmail.com', 9876543210, 789654136, 'rohit2020.com', '2020-03-29', 'bronze', '2020-03-23', 'linkswatch_task3.xlsx', '2020-03-29 11:57:15'),
(3, 'M S Dhoni', 'dhoni@gmail.com', 6547893214, 4545454545, 'dhonifan.com', '2020-03-22', 'bronze', '2020-03-29', 'linkswatch_task4.xlsx', '2020-03-29 11:58:18');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `user_domain`
--
ALTER TABLE `user_domain`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user_domain`
--
ALTER TABLE `user_domain`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
