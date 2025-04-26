-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 12, 2025 at 04:43 PM
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
(1, 1, 'plumbing', 'leaking from terrace', 'resolved', '2025-02-03 15:15:00', '2025-02-19 18:30:00'),
(2, 1, 'plumbing', 'kya karu mai iska\r\n', 'resolved', '2025-02-17 15:15:40', '2025-02-20 11:08:12'),
(3, 1, 'plumbing', 'nal thik nahi hain', 'resolved', '2025-02-26 10:44:34', '2025-03-07 18:30:00'),
(4, 12, 'plumbing', 'leakage', 'resolved', '2025-03-10 15:41:40', '2025-03-10 18:30:00');

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
(1, 'om', '1234567899', 'A', 'A-101', 1, 'rented', 'om', 1, 5000.00, '1BHK'),
(2, 'yash', '5555544444', 'A', 'A-105', 1, 'owned', 'yash', 1, 9000.00, '3BHK'),
(3, 'shreyas', '8888877777', 'B', 'B-105', 1, 'rented', 'shreyas', 1, 9000.00, '3BHK'),
(5, 'kshtija', '3333322222', 'A', 'A-305', 1, 'owned', 'kshju', 3, 9000.00, '3BHK'),
(6, 'shubham', '4444455555', 'A', 'A-405', 1, 'owned', 'shubham', 4, 9000.00, '3BHK'),
(8, 'ramesh gurav', '9819938928', 'A', 'A-201', 1, 'owned', 'Ramesh', 2, 5000.00, '1BHK'),
(9, 'Suresh Raina', '9869199934', 'B', 'B-305', 1, 'rented', 'Suresh', 3, 9000.00, '3BHK'),
(10, 'shikhar dhawan', '7474747474', 'B', 'B-1005', 1, 'rented', 'shikhar dhawan', 10, 9000.00, '3BHK');

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
(3, 'chandya', '7777755555', 'B', 'B-105', '241002'),
(6, 'rani', '3322332233', 'B', 'B-305', '241003'),
(7, 'sweety', '4422442244', 'A', 'A-101', '241004');

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
(4, 3, '241002', 'chandya', 'A-101', 'in', '2025-02-26 16:02:02'),
(5, 3, '241002', 'chandya', 'A-101', 'out', '2025-03-04 19:20:20'),
(6, 3, '241002', 'chandya', 'A-101', 'out', '2025-03-04 19:23:45'),
(7, 3, '241002', 'chandya', 'A-101', 'out', '2025-03-04 19:29:21'),
(8, NULL, '241002', NULL, 'A-101', 'out', '2025-03-04 19:42:10'),
(9, 3, '241002', 'chandya', 'A-101', 'out', '2025-03-04 19:43:30'),
(10, 6, '241003', 'rani', '', 'in', '2025-03-08 10:06:00'),
(11, 6, '241003', 'rani', '', 'in', '2025-03-08 10:13:56');

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
(1, '2025-02', 'A', 'A-101', '1BHK', 5000.00, 'Paid', '2025-02-21 14:44:14', '2025-02-21 14:52:17'),
(2, '2025-02', 'A', 'A-105', '3BHK', 9000.00, 'Paid', '2025-02-21 14:44:14', NULL),
(3, '2025-03', 'A', 'A-101', '1BHK', 5000.00, 'Paid', '2025-03-08 04:10:55', NULL),
(4, '2025-03', 'A', 'A-105', '3BHK', 9000.00, 'Unpaid', '2025-03-08 04:10:56', NULL),
(5, '2025-03', 'B', 'B-105', '3BHK', 9000.00, 'Unpaid', '2025-03-08 04:10:56', NULL),
(6, '2025-03', 'A', 'A-305', '3BHK', 9000.00, 'Unpaid', '2025-03-08 04:10:56', NULL),
(7, '2025-03', 'A', 'A-405', '3BHK', 9000.00, 'Unpaid', '2025-03-08 04:10:56', NULL),
(8, '2025-03', 'A', 'A-201', '1BHK', 5000.00, 'Unpaid', '2025-03-08 04:10:56', NULL),
(9, '2025-03', 'B', 'B-305', '3BHK', 9000.00, 'Unpaid', '2025-03-08 04:10:56', NULL);

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
(1, 'nothing', '1234\r\n', '2025-02-03 15:15:59'),
(2, 'Helpp', 'Nahi ho rahi padhaii', '2025-02-17 15:13:22'),
(3, 'Exam aa rahi hain', 'Kal se pakka padhunga', '2025-03-11 12:54:24');

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
(1, 3, 'A-105', 'A', 9000.00, 'Completed', 'maintenance', 2, '2025-02-21 15:03:22'),
(2, 3, 'A-105', 'A', 2000.00, 'Completed', 'penalty', 3, '2025-02-21 15:11:01'),
(3, 3, 'A-105', 'A', 2000.00, 'Completed', 'penalty', 4, '2025-02-21 15:20:00'),
(4, 3, 'A-105', 'A', 2000.00, 'Completed', 'penalty', 5, '2025-02-21 15:20:36'),
(5, 1, 'A-101', 'A', 101.00, 'Completed', 'penalty', 6, '2025-03-03 14:23:47'),
(6, 1, 'A-101', 'A', 0.00, 'Completed', '', 0, '2025-03-05 16:04:02'),
(7, 1, 'A-101', 'A', 100.00, 'Completed', '', 0, '2025-03-05 16:10:04'),
(8, 1, 'A-101', 'A', 0.00, 'Completed', '', 0, '2025-03-06 14:16:37'),
(9, 1, 'A-101', 'A', 0.00, 'Completed', '', 0, '2025-03-06 14:17:05'),
(10, 1, 'A-101', 'A', 0.00, 'Completed', '', 0, '2025-03-06 14:17:42'),
(11, 1, 'A-101', 'A', 100.00, 'Completed', 'penalty', 7, '2025-03-06 14:22:45'),
(12, 1, 'A-101', 'A', 5000.00, 'Completed', 'maintenance', 3, '2025-03-08 04:22:08');

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
(1, 'A-101', 'A', 1000.00, 'gunha kiya hai isne ', '2025-02-17 15:24:32', 'Paid', NULL),
(2, 'A-101', 'A', 1000.00, 'kuch toh galat kiya\r\n', '2025-02-18 14:12:19', 'Paid', NULL),
(3, 'A-105', 'A', 2000.00, 'samajta hi nahin isko', '2025-02-20 18:30:00', 'Paid', NULL),
(4, 'A-105', 'A', 2000.00, 'samajta hi nahin isko', '2025-02-20 18:30:00', 'Paid', '2025-02-21'),
(5, 'A-105', 'A', 2000.00, 'samajta hi nahin isko', '2025-02-20 18:30:00', 'Paid', '2025-02-21'),
(6, 'A-101', 'A', 101.00, 'don\'t know', '2025-03-02 18:30:00', 'Paid', '2025-03-03'),
(7, 'A-101', 'A', 100.00, 'pagal hai', '2025-03-03 18:30:00', 'Paid', '2025-03-06'),
(8, 'B-105', 'B', 100.00, 'Spittiting in the lift', '2025-03-07 18:30:00', 'Unpaid', NULL),
(9, 'B-1005', 'B', 100.00, 'mand hain\r\n', '2025-03-10 18:30:00', 'Unpaid', NULL),
(10, 'B-1005', 'B', 100.00, 'mand hain\r\n', '2025-03-10 18:30:00', 'Unpaid', NULL),
(11, 'A-101', 'A', 100.00, 'har baar kuch karta hain\r\n', '2025-03-10 18:30:00', 'Unpaid', NULL);

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
(6, 'A-101', 'rohit', 'rohit@gmail.com', '9876543211', 'A', 1, 'rohit'),
(7, 'B-105', 'raja', 'raja@gmail.com', '1111122222', 'B', 1, 'raja'),
(8, 'B-305', 'thala', 'thala@gmail.com', '9867025921', 'B', 1, 'thala'),
(9, 'B-1005', 'varun dhawan', 'v@gmail.com', '6565656565', 'B', 1, 'varun dhawan');

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
  `user_type` enum('Owner','Renter') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `email`, `phone`, `flat_number`, `block`, `password`, `user_type`) VALUES
(1, 'om', '21omadsul@gmail.com', '1234567899', 'A-101', 'A', '$2y$10$rHXddTwsvmhVCusLIh4kfO960ekTvY9J9wtkWVydFeh6LgBqOoFYC', 'Owner'),
(2, 'rohit', 'rohit@gmail.com', '98765432111', 'A-101', 'A', '$2y$10$sFuH9ykgZF7VHCwF7MK/EeQoH4nwdN3KCbpqA0Jk2xEWmV0df3nni', 'Renter'),
(3, 'yash', 'yash@gmail.com', '5555544444', 'A-105', 'A', '$2y$10$BKYHiV6qViW/SiMj6FKryeENaINXVyjWCldTB2EwSTabAwSGpnc1C', 'Owner'),
(4, 'kshtija', 'k@gmail.com', '3333322222', 'A-305', 'A', '$2y$10$1fMSEcA4uGGK3inlEbQA5eVxky8JiWIfKedkIZuSuJY1Lax4nhZ.W', 'Owner'),
(5, 'shreyas', 'shreyas@gmail.com', '8888877777', 'B-105', 'B', '$2y$10$b3CCmoTrfKp02ojgsPrFIuKnvpP/h3lSRnFMVOBqNGjuyE3npnF7q', 'Owner'),
(7, 'shubham', 'shubham@gmail.com', '4444455555', 'A-405', 'A', '$2y$10$V43RqBOC7WCjp7sMm4bVcunHe.dvCcb7hP4QewJGD2spk0FFvt726', 'Owner'),
(8, 'raja', 'raja@gmail.com', '1111122222', 'B-105', 'B', '$2y$10$umsNqg.lWxN.SQ6q1ApxQubJEwQWJA4mBnohsE2kCdnAKBhX/Qoo.', 'Renter'),
(9, 'ramesh gurav', 'ramesh@gmail.com', '9819938928', 'A-201', 'A', '$2y$10$LT60mjTTTp/SNUQXFZh1/OzuIkA5KiwsiPw5vZ33y9QJCz/6PFAlW', 'Owner'),
(10, 'Suresh Raina', 'suresh@gmail.com', '9869199934', 'B-305', 'B', '$2y$10$4tiuebUB.8q34yA804Ip1uwksR/ZEo9vewsXA0GSDOC194/CX0FAi', 'Owner'),
(11, 'thala', 'thala@gmail.com', '9867025921', 'B-305', 'B', '$2y$10$CB8tROJ7K/4VyZtIadYANes0Zf7vBwp86btsDIXGssQbMnXRT/jc.', 'Renter'),
(12, 'shikhar dhawan', 'shikhar@gmail.com', '7474747474', 'B-1005', 'B', '$2y$10$UFTFt7bKMaRRm.X23VBvTut8vA5.rzKhJ2NrLFJXVeRsGzv1y2H7a', 'Owner'),
(13, 'varun dhawan', 'v@gmail.com', '6565656565', 'B-1005', 'B', '$2y$10$8vxE8lkb4N5HVesAdX6KiuZuiTByHFEbt.yew5MFQZOQPR.TKOSPW', 'Renter');

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
(1, 'bandya', '2323232323', 'courier', '101', 'a', '2025-02-03 16:35:22', '2025-02-03 16:35:30'),
(2, 'simba', '4343434343', 'delivery boy', '101', 'a', '2025-02-05 14:11:57', '2025-02-05 14:12:35'),
(3, 'omkar', '7534128960', 'courier', '101', 'a', '2025-02-06 16:21:05', '2025-02-06 16:21:24'),
(4, 'pk', '8888888888', 'delivery boy', '101', 'a', '2025-02-11 20:19:07', '2025-02-11 20:19:52'),
(5, 'ghanshyam', '4444444444', 'delivery boy', '101', 'a', '2025-02-11 20:37:51', '2025-02-11 20:52:15'),
(6, 'chor', '6665554444', 'delivery boy', 'A-101', 'A', '2025-02-25 19:57:04', '2025-02-25 20:03:47'),
(7, 'yashraj', '3333322222', 'courier', 'A-101', 'A', '2025-02-26 16:06:41', '2025-02-26 16:06:58'),
(8, '', '', '', '', '', '2025-03-04 17:32:50', '2025-03-04 18:56:28'),
(9, 'samay', '8877887788', 'delivery boy', 'A-105', 'A', '2025-03-08 10:02:49', '2025-03-08 10:03:12'),
(10, 'santner', '9696969696', 'courier', 'A-101', 'A', '2025-03-09 20:25:34', '2025-03-09 20:25:58');

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
(1, 'shyama', '2323232323', '', '2025-02-05', 10000.00, 'morning'),
(2, 'raja', '1234567899', '$2y$10$yZhDiWptFtesgO1y.aCg3eFKiIMc9pEVESBSFk1M/MuDtbj/w.Yre', '2025-02-05', 10000.00, 'evening'),
(3, 'ambati rayudu', '6655665566', '$2y$10$dVVy9zHkyzkgzU07a9DUqu.HFtcjfLdBm2rrGgrXbfjfVpEwXB9BW', '2025-08-03', 10000.00, 'night'),
(4, 'kapil sharma ', '2233223322', '$2y$10$wfhOWL4nxYfzI.4zUOXFw.Qebpg52DuFGPvpU9lr9tlVQDbvEhIJ.', '2025-03-11', 10000.00, 'morning');

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
  ADD KEY `user_id` (`user_id`);

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
  ADD KEY `maid_id` (`maid_id`);

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
  MODIFY `complaint_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `flat_allotment`
--
ALTER TABLE `flat_allotment`
  MODIFY `allotment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `flat_details`
--
ALTER TABLE `flat_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT for table `maids`
--
ALTER TABLE `maids`
  MODIFY `maid_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `maid_visits`
--
ALTER TABLE `maid_visits`
  MODIFY `visit_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `maintenance`
--
ALTER TABLE `maintenance`
  MODIFY `maintenance_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `notices`
--
ALTER TABLE `notices`
  MODIFY `notice_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `payment_new`
--
ALTER TABLE `payment_new`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `penalties`
--
ALTER TABLE `penalties`
  MODIFY `penalty_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `rented_flats`
--
ALTER TABLE `rented_flats`
  MODIFY `rent_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `visitors`
--
ALTER TABLE `visitors`
  MODIFY `visitor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `watchmen`
--
ALTER TABLE `watchmen`
  MODIFY `watchman_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `complaints`
--
ALTER TABLE `complaints`
  ADD CONSTRAINT `complaints_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `maid_visits`
--
ALTER TABLE `maid_visits`
  ADD CONSTRAINT `maid_visits_ibfk_1` FOREIGN KEY (`maid_id`) REFERENCES `maids` (`maid_id`);

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
