-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 16, 2023 at 09:29 AM
-- Server version: 8.0.30
-- PHP Version: 7.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `example`
--

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `cst_id` int NOT NULL,
  `nationality_id` int NOT NULL,
  `cst_name` varchar(50) NOT NULL,
  `cst_dob` date DEFAULT NULL,
  `cst_phone_num` varchar(20) NOT NULL,
  `cst_email` varchar(50) NOT NULL,
  `updated_at` timestamp NOT NULL,
  `created_at` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`cst_id`, `nationality_id`, `cst_name`, `cst_dob`, `cst_phone_num`, `cst_email`, `updated_at`, `created_at`) VALUES
(1, 1, 'Fai', '2023-07-15', '085709471660', 'rifai.aregds@gmail.com', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 1, 'Yanto', '2023-07-16', '1234567', 'yanto@gmail.com', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `family_list`
--

CREATE TABLE `family_list` (
  `fi_id` int NOT NULL,
  `cst_id` int NOT NULL,
  `fi_relation` varchar(50) NOT NULL,
  `fi_name` varchar(50) NOT NULL,
  `fi_dob` date NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `family_list`
--

INSERT INTO `family_list` (`fi_id`, `cst_id`, `fi_relation`, `fi_name`, `fi_dob`, `created_at`, `updated_at`) VALUES
(6, 4, 'Sister', 'Suci', '2023-07-07', '2023-07-16 02:09:22', '2023-07-16 02:09:22'),
(8, 4, 'Brother', 'Fai', '2023-07-01', '2023-07-16 02:12:40', '2023-07-16 02:12:40');

-- --------------------------------------------------------

--
-- Table structure for table `nationality`
--

CREATE TABLE `nationality` (
  `nationality_id` int NOT NULL,
  `nationality_name` varchar(50) NOT NULL,
  `nationality_code` char(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `nationality`
--

INSERT INTO `nationality` (`nationality_id`, `nationality_name`, `nationality_code`) VALUES
(1, 'Indonesia', '01');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`cst_id`);

--
-- Indexes for table `family_list`
--
ALTER TABLE `family_list`
  ADD PRIMARY KEY (`fi_id`);

--
-- Indexes for table `nationality`
--
ALTER TABLE `nationality`
  ADD PRIMARY KEY (`nationality_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `cst_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `family_list`
--
ALTER TABLE `family_list`
  MODIFY `fi_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `nationality`
--
ALTER TABLE `nationality`
  MODIFY `nationality_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
