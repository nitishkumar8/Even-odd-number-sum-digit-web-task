-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 11, 2024 at 01:09 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `collection`
--

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

CREATE TABLE `project` (
  `Project_Id` int(11) NOT NULL,
  `Project_Code` varchar(20) DEFAULT NULL,
  `Project_Name` varchar(50) NOT NULL,
  `Create_Date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `project`
--

INSERT INTO `project` (`Project_Id`, `Project_Code`, `Project_Name`, `Create_Date`) VALUES
(1, '123456', 'Project 1', '2024-03-09 12:10:33'),
(2, '234567', 'Project 2', '2024-03-09 12:12:06'),
(3, '909999', 'Project3', '2024-03-10 12:16:31'),
(4, '1234ABN', 'Project 4', '2024-03-10 17:08:48'),
(5, '1234ABC', 'XYZ', '2024-03-10 17:16:49'),
(6, '567890', 'triii', '2024-03-10 17:21:04'),
(7, 'cvxyz', 'test3', '2024-03-10 17:25:26'),
(8, '123ert', 'nvk', '2024-03-10 17:32:55'),
(9, 'xyz123', 'test test', '2024-03-11 02:57:35');

-- --------------------------------------------------------

--
-- Table structure for table `task`
--

CREATE TABLE `task` (
  `Task_Id` int(11) NOT NULL,
  `Task_Name` varchar(100) NOT NULL,
  `Project_Id` int(11) NOT NULL,
  `Create_Date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `task`
--

INSERT INTO `task` (`Task_Id`, `Task_Name`, `Project_Id`, `Create_Date`) VALUES
(1, 'Task 1 – 8 hours', 1, '2024-03-10 18:06:04'),
(2, 'Task 1 – 2 hours', 2, '2024-03-10 18:10:24'),
(3, 'task 1-8 hours taskk task 2-3 99', 4, '2024-03-10 18:06:11'),
(4, 'TASK TEST 6-7 HOURS', 4, '2024-03-10 17:08:51'),
(5, 'TASK4-5 HOURS', 5, '2024-03-10 17:16:49'),
(8, 'test', 8, '2024-03-10 17:59:33'),
(12, 'qwdwq', 8, '2024-03-10 17:32:55'),
(13, 'task 2-3 hours', 9, '2024-03-11 02:57:35'),
(14, 'task4-5 hours', 9, '2024-03-11 02:57:35');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `project`
--
ALTER TABLE `project`
  ADD PRIMARY KEY (`Project_Id`);

--
-- Indexes for table `task`
--
ALTER TABLE `task`
  ADD PRIMARY KEY (`Task_Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `project`
--
ALTER TABLE `project`
  MODIFY `Project_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `task`
--
ALTER TABLE `task`
  MODIFY `Task_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
