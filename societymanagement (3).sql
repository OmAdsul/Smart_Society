-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 26, 2025 at 02:02 PM
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
-- Database: `societymanagement`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `admin_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`admin_id`, `username`, `password`) VALUES
(1, 'admin', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `complaints`
--

CREATE TABLE `complaints` (
  `complaint_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `complaint_type` enum('plumbing','electrical','security') NOT NULL,
  `description` text NOT NULL,
  `status` enum('open','resolved') DEFAULT 'open',
  `date_raised` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_completed` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `complaints`
--

INSERT INTO `complaints` (`complaint_id`, `user_id`, `complaint_type`, `description`, `status`, `date_raised`, `date_completed`) VALUES
(6, 20, 'plumbing', 'Having leakage in the bathroom', 'resolved', '2025-04-14 11:11:36', '2025-04-13 18:30:00'),
(7, 20, 'electrical', 'Having some issues in the circuit\r\n', 'resolved', '2025-04-15 08:57:06', '2025-04-14 18:30:00'),
(8, 20, 'electrical', 'Having some issues in the circuit\r\n', 'open', '2025-04-15 08:57:43', NULL),
(9, 22, 'plumbing', 'Leakage in the balcony ', 'open', '2025-04-26 11:13:33', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `flat_allotment`
--

CREATE TABLE `flat_allotment` (
  `allotment_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `contact_number` varchar(15) NOT NULL,
  `block` varchar(10) NOT NULL,
  `flat_number` varchar(10) NOT NULL,
  `total_members` int(11) NOT NULL,
  `ownership_status` enum('rented','owned') NOT NULL DEFAULT 'owned',
  `members_names` text NOT NULL,
  `floor` int(11) NOT NULL,
  `maintenance_charge` decimal(10,2) NOT NULL,
  `flat_type` enum('1BHK','2BHK','3BHK') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `flat_allotment`
--

INSERT INTO `flat_allotment` (`allotment_id`, `name`, `contact_number`, `block`, `flat_number`, `total_members`, `ownership_status`, `members_names`, `floor`, `maintenance_charge`, `flat_type`) VALUES
(14, 'Om Adsul', '9769625639', 'A', 'A-1005', 1, 'owned', 'Om Adsul', 10, 9000.00, '3BHK'),
(15, 'Yash Adsul', '9869333222', 'A', 'A-105', 1, 'owned', 'Yash Adsul', 1, 9000.00, '3BHK'),
(16, 'Shubham Dorkar', '7788778877', 'A', 'A-505', 1, 'rented', 'Shubham Dorkar', 5, 9000.00, '3BHK'),
(17, 'Karun Nair', '7788665544', 'B', 'B-603', 1, 'owned', 'Karun Nair', 6, 5000.00, '1BHK'),
(18, 'Axar Patel', '3322116655', 'B', 'B-404', 1, 'owned', 'Axar Patel ', 4, 7000.00, '2BHK'),
(19, 'Ajinkya Rahane', '1717171717', 'B', 'B-805', 1, 'owned', 'Ajinkya Rahane', 8, 9000.00, '3BHK'),
(21, 'Rinku Singh', '1112223334', 'A', 'A-801', 1, 'rented', 'Rinku Singh', 8, 5000.00, '1BHK');

-- --------------------------------------------------------

--
-- Table structure for table `flat_details`
--

CREATE TABLE `flat_details` (
  `id` int(11) NOT NULL,
  `block` char(1) NOT NULL,
  `floor` int(11) NOT NULL CHECK (`floor` between 1 and 10),
  `flat_number` varchar(10) NOT NULL,
  `flat_type` enum('1BHK','2BHK','3BHK') NOT NULL,
  `maintenance_charge` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `flat_details`
--

INSERT INTO `flat_details` (`id`, `block`, `floor`, `flat_number`, `flat_type`, `maintenance_charge`) VALUES
(1, 'A', 1, 'A-101', '1BHK', 5000),
(2, 'A', 1, 'A-102', '1BHK', 5000),
(3, 'A', 1, 'A-103', '1BHK', 5000),
(4, 'A', 1, 'A-104', '2BHK', 7000),
(5, 'A', 1, 'A-105', '3BHK', 9000),
(6, 'A', 2, 'A-201', '1BHK', 5000),
(7, 'A', 2, 'A-202', '1BHK', 5000),
(8, 'A', 2, 'A-203', '1BHK', 5000),
(9, 'A', 2, 'A-204', '2BHK', 7000),
(10, 'A', 2, 'A-205', '3BHK', 9000),
(11, 'A', 3, 'A-301', '1BHK', 5000),
(12, 'A', 3, 'A-302', '1BHK', 5000),
(13, 'A', 3, 'A-303', '1BHK', 5000),
(14, 'A', 3, 'A-304', '2BHK', 7000),
(15, 'A', 3, 'A-305', '3BHK', 9000),
(16, 'A', 4, 'A-401', '1BHK', 5000),
(17, 'A', 4, 'A-402', '1BHK', 5000),
(18, 'A', 4, 'A-403', '1BHK', 5000),
(19, 'A', 4, 'A-404', '2BHK', 7000),
(20, 'A', 4, 'A-405', '3BHK', 9000),
(21, 'A', 5, 'A-501', '1BHK', 5000),
(22, 'A', 5, 'A-502', '1BHK', 5000),
(23, 'A', 5, 'A-503', '1BHK', 5000),
(24, 'A', 5, 'A-504', '2BHK', 7000),
(25, 'A', 5, 'A-505', '3BHK', 9000),
(26, 'A', 6, 'A-601', '1BHK', 5000),
(27, 'A', 6, 'A-602', '1BHK', 5000),
(28, 'A', 6, 'A-603', '1BHK', 5000),
(29, 'A', 6, 'A-604', '2BHK', 7000),
(30, 'A', 6, 'A-605', '3BHK', 9000),
(31, 'A', 7, 'A-701', '1BHK', 5000),
(32, 'A', 7, 'A-702', '1BHK', 5000),
(33, 'A', 7, 'A-703', '1BHK', 5000),
(34, 'A', 7, 'A-704', '2BHK', 7000),
(35, 'A', 7, 'A-705', '3BHK', 9000),
(36, 'A', 8, 'A-801', '1BHK', 5000),
(37, 'A', 8, 'A-802', '1BHK', 5000),
(38, 'A', 8, 'A-803', '1BHK', 5000),
(39, 'A', 8, 'A-804', '2BHK', 7000),
(40, 'A', 8, 'A-805', '3BHK', 9000),
(41, 'A', 9, 'A-901', '1BHK', 5000),
(42, 'A', 9, 'A-902', '1BHK', 5000),
(43, 'A', 9, 'A-903', '1BHK', 5000),
(44, 'A', 9, 'A-904', '2BHK', 7000),
(45, 'A', 9, 'A-905', '3BHK', 9000),
(46, 'A', 10, 'A-1001', '1BHK', 5000),
(47, 'A', 10, 'A-1002', '1BHK', 5000),
(48, 'A', 10, 'A-1003', '1BHK', 5000),
(49, 'A', 10, 'A-1004', '2BHK', 7000),
(50, 'A', 10, 'A-1005', '3BHK', 9000),
(51, 'B', 1, 'B-101', '1BHK', 5000),
(52, 'B', 1, 'B-102', '1BHK', 5000),
(53, 'B', 1, 'B-103', '1BHK', 5000),
(54, 'B', 1, 'B-104', '2BHK', 7000),
(55, 'B', 1, 'B-105', '3BHK', 9000),
(56, 'B', 2, 'B-201', '1BHK', 5000),
(57, 'B', 2, 'B-202', '1BHK', 5000),
(58, 'B', 2, 'B-203', '1BHK', 5000),
(59, 'B', 2, 'B-204', '2BHK', 7000),
(60, 'B', 2, 'B-205', '3BHK', 9000),
(61, 'B', 3, 'B-301', '1BHK', 5000),
(62, 'B', 3, 'B-302', '1BHK', 5000),
(63, 'B', 3, 'B-303', '1BHK', 5000),
(64, 'B', 3, 'B-304', '2BHK', 7000),
(65, 'B', 3, 'B-305', '3BHK', 9000),
(66, 'B', 4, 'B-401', '1BHK', 5000),
(67, 'B', 4, 'B-402', '1BHK', 5000),
(68, 'B', 4, 'B-403', '1BHK', 5000),
(69, 'B', 4, 'B-404', '2BHK', 7000),
(70, 'B', 4, 'B-405', '3BHK', 9000),
(71, 'B', 5, 'B-501', '1BHK', 5000),
(72, 'B', 5, 'B-502', '1BHK', 5000),
(73, 'B', 5, 'B-503', '1BHK', 5000),
(74, 'B', 5, 'B-504', '2BHK', 7000),
(75, 'B', 5, 'B-505', '3BHK', 9000),
(76, 'B', 6, 'B-601', '1BHK', 5000),
(77, 'B', 6, 'B-602', '1BHK', 5000),
(78, 'B', 6, 'B-603', '1BHK', 5000),
(79, 'B', 6, 'B-604', '2BHK', 7000),
(80, 'B', 6, 'B-605', '3BHK', 9000),
(81, 'B', 7, 'B-701', '1BHK', 5000),
(82, 'B', 7, 'B-702', '1BHK', 5000),
(83, 'B', 7, 'B-703', '1BHK', 5000),
(84, 'B', 7, 'B-704', '2BHK', 7000),
(85, 'B', 7, 'B-705', '3BHK', 9000),
(86, 'B', 8, 'B-801', '1BHK', 5000),
(87, 'B', 8, 'B-802', '1BHK', 5000),
(88, 'B', 8, 'B-803', '1BHK', 5000),
(89, 'B', 8, 'B-804', '2BHK', 7000),
(90, 'B', 8, 'B-805', '3BHK', 9000),
(91, 'B', 9, 'B-901', '1BHK', 5000),
(92, 'B', 9, 'B-902', '1BHK', 5000),
(93, 'B', 9, 'B-903', '1BHK', 5000),
(94, 'B', 9, 'B-904', '2BHK', 7000),
(95, 'B', 9, 'B-905', '3BHK', 9000),
(96, 'B', 10, 'B-1001', '1BHK', 5000),
(97, 'B', 10, 'B-1002', '1BHK', 5000),
(98, 'B', 10, 'B-1003', '1BHK', 5000),
(99, 'B', 10, 'B-1004', '2BHK', 7000),
(100, 'B', 10, 'B-1005', '3BHK', 9000);

-- --------------------------------------------------------

--
-- Table structure for table `maids`
--

CREATE TABLE `maids` (
  `maid_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `contact_number` varchar(15) NOT NULL,
  `block` varchar(10) NOT NULL,
  `flat_number` varchar(10) NOT NULL,
  `maid_number` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `maids`
--

INSERT INTO `maids` (`maid_id`, `name`, `contact_number`, `block`, `flat_number`, `maid_number`) VALUES
(9, 'Jui Chawla', '1231231231', 'A', 'A-1005', '241001'),
(10, 'Deepika Kaif', '3332221114', 'A', 'A-801', '241002');

-- --------------------------------------------------------

--
-- Table structure for table `maid_visits`
--

CREATE TABLE `maid_visits` (
  `visit_id` int(11) NOT NULL,
  `maid_id` int(11) DEFAULT NULL,
  `maid_number` varchar(50) DEFAULT NULL,
  `maid_name` varchar(255) DEFAULT NULL,
  `flat_number` varchar(50) DEFAULT NULL,
  `remark_type` enum('in','out') DEFAULT NULL,
  `remark_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `maid_visits`
--

INSERT INTO `maid_visits` (`visit_id`, `maid_id`, `maid_number`, `maid_name`, `flat_number`, `remark_type`, `remark_time`) VALUES
(14, 9, '241001', 'Jui Chawla', 'A-1005', 'in', '2025-04-14 17:36:55'),
(15, 9, '241001', 'Jui Chawla', 'A-1005', 'out', '2025-04-14 19:03:50');

-- --------------------------------------------------------

--
-- Table structure for table `maintenance`
--

CREATE TABLE `maintenance` (
  `maintenance_id` int(11) NOT NULL,
  `month_year` varchar(7) NOT NULL,
  `block` varchar(10) NOT NULL,
  `flat_number` varchar(10) NOT NULL,
  `flat_type` enum('1BHK','2BHK','3BHK') NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `status` enum('Unpaid','Paid') DEFAULT 'Unpaid',
  `date_added` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_paid` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `maintenance`
--

INSERT INTO `maintenance` (`maintenance_id`, `month_year`, `block`, `flat_number`, `flat_type`, `amount`, `status`, `date_added`, `date_paid`) VALUES
(19, '2025-04', 'A', 'A-1005', '3BHK', 9000.00, 'Paid', '2025-04-14 13:34:26', NULL),
(20, '2025-04', 'A', 'A-105', '3BHK', 9000.00, 'Unpaid', '2025-04-14 13:34:26', NULL),
(21, '2025-04', 'A', 'A-505', '3BHK', 9000.00, 'Paid', '2025-04-14 13:34:26', NULL),
(22, '2025-04', 'B', 'B-603', '1BHK', 5000.00, 'Unpaid', '2025-04-14 13:34:26', NULL),
(23, '2025-04', 'B', 'B-404', '2BHK', 7000.00, 'Unpaid', '2025-04-14 13:34:26', NULL),
(24, '2025-04', 'B', 'B-805', '3BHK', 9000.00, 'Unpaid', '2025-04-14 13:34:26', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `notices`
--

CREATE TABLE `notices` (
  `notice_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notices`
--

INSERT INTO `notices` (`notice_id`, `title`, `description`, `date_created`) VALUES
(5, 'Monthly Residents Meeting', 'Reminder: Our Monthly Residents\' Meeting will be held on 15 April at 7:00 pm in the Community Hall. Your participation is important as we discuss community issues and upcoming events.', '2025-04-14 13:20:19');

-- --------------------------------------------------------

--
-- Table structure for table `payment_new`
--

CREATE TABLE `payment_new` (
  `payment_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `flat_number` varchar(10) DEFAULT NULL,
  `block` varchar(10) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `payment_status` enum('Completed','Pending') DEFAULT NULL,
  `payment_type` enum('penalty','maintenance') DEFAULT NULL,
  `reference_id` int(11) DEFAULT NULL,
  `payment_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment_new`
--

INSERT INTO `payment_new` (`payment_id`, `user_id`, `flat_number`, `block`, `amount`, `payment_status`, `payment_type`, `reference_id`, `payment_date`) VALUES
(16, 22, 'A-505', 'A', 9000.00, 'Completed', 'maintenance', 21, '2025-04-14 13:37:06'),
(17, 23, 'B-603', 'B', 1000.00, 'Completed', 'penalty', 14, '2025-04-14 13:38:48'),
(18, 20, 'A-1005', 'A', 9000.00, 'Completed', 'maintenance', 19, '2025-04-15 08:55:25'),
(19, 22, 'A-505', 'A', 1000.00, 'Completed', 'penalty', 15, '2025-04-25 05:53:03');

-- --------------------------------------------------------

--
-- Table structure for table `penalties`
--

CREATE TABLE `penalties` (
  `penalty_id` int(11) NOT NULL,
  `flat_number` varchar(10) NOT NULL,
  `block` varchar(10) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `reason` text NOT NULL,
  `date_imposed` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('Unpaid','Paid') DEFAULT 'Unpaid',
  `date_solved` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `penalties`
--

INSERT INTO `penalties` (`penalty_id`, `flat_number`, `block`, `amount`, `reason`, `date_imposed`, `status`, `date_solved`) VALUES
(14, 'B-603', 'B', 1000.00, 'Not following the pet policies', '2025-04-13 18:30:00', 'Paid', '2025-04-14'),
(15, 'A-505', 'A', 1000.00, 'Spitting in the residential area\r\n', '2025-04-24 18:30:00', 'Paid', '2025-04-25'),
(16, 'A-505', 'A', 1000.00, 'Spitting in the residential area', '2025-04-25 18:30:00', 'Unpaid', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `rented_flats`
--

CREATE TABLE `rented_flats` (
  `rent_id` int(11) NOT NULL,
  `flat_number` varchar(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `contact_number` varchar(15) NOT NULL,
  `block` varchar(10) NOT NULL,
  `total_members` int(11) NOT NULL,
  `members_names` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rented_flats`
--

INSERT INTO `rented_flats` (`rent_id`, `flat_number`, `name`, `email`, `contact_number`, `block`, `total_members`, `members_names`) VALUES
(12, 'A-505', 'Rachin Kumar', 'rachin@gmail.com', '2211221122', 'A', 1, ''),
(13, 'A-801', 'Vaibhav Kadam', 'vaibhav@gmail.com', '4443332221', 'A', 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `flat_number` varchar(10) NOT NULL,
  `block` varchar(10) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_type` enum('Owner','Renter') NOT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `token_expiry` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `email`, `phone`, `flat_number`, `block`, `password`, `user_type`, `reset_token`, `token_expiry`) VALUES
(20, 'Om Adsul', '21omadsul@gmail.com', '9819938928', 'A-1005', 'A', '$2y$10$yDWssS3431wNc7g0ZdXdjOSluR2nUML4nXV0GGup0Vze3ltlmfNX.', 'Owner', 'f4917ae3683110b0cf85e75cd87544ec397b0c5ad4b6b8b41139d4776e90895406b57b53456d821967fd0a6c9e60a8e986c3', '2025-04-25 12:25:22'),
(21, 'Yash Adsul', 'yash1999@gmail.com', '9869333222', 'A-105', 'A', '$2y$10$AvaThuijtLr0P8Kvid3iZua721WKzOVb8kWs/NCssAhrvoe8wjiTm', 'Owner', NULL, NULL),
(22, 'Shubham Dorkar', 'chomyaa21@gmail.com', '7788778877', 'A-505', 'A', '$2y$10$RBCJ4aWEv2Hu2qGSriH6SutnBnrvQveaeLxKVu.Q/Mn3aXDza6hHe', 'Owner', NULL, NULL),
(23, 'Karun Nair', 'cs2212221001@mdcollege.in', '7788665544', 'B-603', 'B', '$2y$10$Xu0aE0tn645RE3a5gE6pTegnImsHe6QZ7sse.zg66/EODgo7r6r76', 'Owner', NULL, NULL),
(24, 'Axar Patel', 'axar@gmail.com', '3322116655', 'B-404', 'B', '$2y$10$fOr8QItZL6hsQhoyuWFAXejCmBev74pH/PjY2wWay85fZ7I9mNWQi', 'Owner', NULL, NULL),
(25, 'Ajinkya Rahane', 'ajinkya@gmail.com', '1717171717', 'B-805', 'B', '$2y$10$tSwOVXSUbRaTxIucY2zUCeUO4qZgJ3Z5.NPr6T9wK239CsMicxuxy', 'Owner', NULL, NULL),
(26, 'Rachin Kumar', 'rachin@gmail.com', '2211221122', 'A-505', 'A', '$2y$10$Q.KHSiHDoMTxWRv8Ob7njesDVI6gIOFvpbv8QPOaMzIyBSyGhJUri', 'Renter', NULL, NULL),
(28, 'Rinku Singh', 'rinku@gmail.com', '1112223334', 'A-801', 'A', '$2y$10$w1N786/IGnseuCRnFEdUleZZeidQilJcEgwOmDOzYFTDh4iaQoXZi', 'Owner', NULL, NULL),
(29, 'Vaibhav Kadam', 'vaibhav@gmail.com', '4443332221', 'A-801', 'A', '$2y$10$645hqJhsuTtifLJEj7QeFebRCciQq5LHMlUJx8A4Fh4InHQ7um5pG', 'Renter', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `visitors`
--

CREATE TABLE `visitors` (
  `visitor_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `visitor_type` enum('delivery boy','courier') NOT NULL,
  `flat_number` varchar(10) NOT NULL,
  `block` varchar(10) NOT NULL,
  `remark_in` datetime DEFAULT NULL,
  `remark_out` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `visitors`
--

INSERT INTO `visitors` (`visitor_id`, `name`, `phone`, `visitor_type`, `flat_number`, `block`, `remark_in`, `remark_out`) VALUES
(12, 'Rahul Kumar', '8877665544', 'delivery boy', 'A-1005', 'A', '2025-04-14 16:46:23', '2025-04-14 17:37:03');

-- --------------------------------------------------------

--
-- Table structure for table `watchmen`
--

CREATE TABLE `watchmen` (
  `watchman_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `joining_date` date NOT NULL,
  `salary` decimal(10,2) NOT NULL,
  `working_shift` enum('morning','evening','night') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `watchmen`
--

INSERT INTO `watchmen` (`watchman_id`, `name`, `phone`, `password`, `joining_date`, `salary`, `working_shift`) VALUES
(8, 'Krunal Patil', '9769625639', '$2y$10$Vn69kxcEoZHtcXT/JOhRiOTzFPDULB/Hsu1A/PQoaD4qTBOVQX4eu', '2025-04-14', 10000.00, 'morning'),
(9, 'Mangesh Sawant', '9876543211', '$2y$10$XIEATqytfEXpDUKT8uAvv.DB66PT5pz2.u1hyOUmfO37gedxbCdba', '2025-04-14', 10000.00, 'evening'),
(10, 'Roshan Singh', '1234567899', '$2y$10$yKJfdPZHUdldUf64vajQmeCpLGyfBciW4PqNFxYpisoWwzlmOWczG', '2025-04-14', 10000.00, 'night');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `complaints`
--
ALTER TABLE `complaints`
  ADD PRIMARY KEY (`complaint_id`),
  ADD KEY `complaints_ibfk_1` (`user_id`);

--
-- Indexes for table `flat_allotment`
--
ALTER TABLE `flat_allotment`
  ADD PRIMARY KEY (`allotment_id`),
  ADD UNIQUE KEY `unique_flat` (`flat_number`,`block`);

--
-- Indexes for table `flat_details`
--
ALTER TABLE `flat_details`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `flat_number` (`flat_number`),
  ADD UNIQUE KEY `unique_flat` (`block`,`flat_number`);

--
-- Indexes for table `maids`
--
ALTER TABLE `maids`
  ADD PRIMARY KEY (`maid_id`),
  ADD UNIQUE KEY `maid_number` (`maid_number`);

--
-- Indexes for table `maid_visits`
--
ALTER TABLE `maid_visits`
  ADD PRIMARY KEY (`visit_id`),
  ADD KEY `fk_maid_id` (`maid_id`);

--
-- Indexes for table `maintenance`
--
ALTER TABLE `maintenance`
  ADD PRIMARY KEY (`maintenance_id`);

--
-- Indexes for table `notices`
--
ALTER TABLE `notices`
  ADD PRIMARY KEY (`notice_id`);

--
-- Indexes for table `payment_new`
--
ALTER TABLE `payment_new`
  ADD PRIMARY KEY (`payment_id`);

--
-- Indexes for table `penalties`
--
ALTER TABLE `penalties`
  ADD PRIMARY KEY (`penalty_id`),
  ADD KEY `flat_number` (`flat_number`,`block`);

--
-- Indexes for table `rented_flats`
--
ALTER TABLE `rented_flats`
  ADD PRIMARY KEY (`rent_id`),
  ADD UNIQUE KEY `flat_number` (`flat_number`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `flat_number` (`flat_number`,`block`);

--
-- Indexes for table `visitors`
--
ALTER TABLE `visitors`
  ADD PRIMARY KEY (`visitor_id`);

--
-- Indexes for table `watchmen`
--
ALTER TABLE `watchmen`
  ADD PRIMARY KEY (`watchman_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `complaints`
--
ALTER TABLE `complaints`
  MODIFY `complaint_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `flat_allotment`
--
ALTER TABLE `flat_allotment`
  MODIFY `allotment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `flat_details`
--
ALTER TABLE `flat_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT for table `maids`
--
ALTER TABLE `maids`
  MODIFY `maid_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `maid_visits`
--
ALTER TABLE `maid_visits`
  MODIFY `visit_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `maintenance`
--
ALTER TABLE `maintenance`
  MODIFY `maintenance_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `notices`
--
ALTER TABLE `notices`
  MODIFY `notice_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `payment_new`
--
ALTER TABLE `payment_new`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `penalties`
--
ALTER TABLE `penalties`
  MODIFY `penalty_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `rented_flats`
--
ALTER TABLE `rented_flats`
  MODIFY `rent_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `visitors`
--
ALTER TABLE `visitors`
  MODIFY `visitor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `watchmen`
--
ALTER TABLE `watchmen`
  MODIFY `watchman_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `complaints`
--
ALTER TABLE `complaints`
  ADD CONSTRAINT `complaints_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `maid_visits`
--
ALTER TABLE `maid_visits`
  ADD CONSTRAINT `fk_maid_id` FOREIGN KEY (`maid_id`) REFERENCES `maids` (`maid_id`) ON DELETE SET NULL;

--
-- Constraints for table `penalties`
--
ALTER TABLE `penalties`
  ADD CONSTRAINT `penalties_ibfk_1` FOREIGN KEY (`flat_number`,`block`) REFERENCES `flat_allotment` (`flat_number`, `block`) ON DELETE CASCADE;

--
-- Constraints for table `rented_flats`
--
ALTER TABLE `rented_flats`
  ADD CONSTRAINT `fk_rented_flats` FOREIGN KEY (`flat_number`) REFERENCES `flat_allotment` (`flat_number`) ON DELETE CASCADE,
  ADD CONSTRAINT `rented_flats_ibfk_1` FOREIGN KEY (`flat_number`) REFERENCES `flat_allotment` (`flat_number`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`flat_number`,`block`) REFERENCES `flat_allotment` (`flat_number`, `block`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
