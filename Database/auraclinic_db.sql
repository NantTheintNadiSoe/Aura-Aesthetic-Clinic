-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 01, 2026 at 12:54 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `auraclinic_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointment`
--

CREATE TABLE `appointment` (
  `AppointmentCode` varchar(20) NOT NULL,
  `PatientID` int(11) NOT NULL,
  `AppointmentDate` date NOT NULL,
  `AppointmentTime` time NOT NULL,
  `Name` varchar(30) NOT NULL,
  `Email` varchar(30) NOT NULL,
  `PhoneNumber` varchar(30) NOT NULL,
  `Address` varchar(50) NOT NULL,
  `Status` varchar(30) NOT NULL,
  `IsNotified` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointment`
--

INSERT INTO `appointment` (`AppointmentCode`, `PatientID`, `AppointmentDate`, `AppointmentTime`, `Name`, `Email`, `PhoneNumber`, `Address`, `Status`, `IsNotified`) VALUES
('Ap_000007', 6, '0000-00-00', '00:00:00', 'Di Di', 'di@gmail.com', '09984758698', 'Yangon', 'Confirmed', 1),
('Ap_000012', 5, '2025-08-25', '00:00:10', 'Ntns', 'ntns@gmail.com', '09975647387', 'Yangon', 'Confirmed', 0),
('Ap_000013', 5, '2025-09-13', '10:00:00', 'Di Di', 'ntns@gmail.com', '09975647387', 'Yangon', 'Confirmed', 0),
('Ap_000014', 5, '2025-09-19', '11:00:00', 'Ntns', 'ntns@gmail.com', '09975647387', 'Yangon', 'Confirmed', 0),
('Ap_000015', 5, '2025-09-14', '11:00:00', 'Ntns', 'ntns@gmail.com', '09975647387', 'Hinthada', 'Confirmed', 0),
('Ap_000016', 6, '2025-09-14', '10:00:00', 'Di Di', 'di@gmail.com', '09975647387', 'Yangoon', 'Confirmed', 1),
('Ap_000017', 6, '2025-09-15', '02:00:00', 'Di Di', 'di@gmail.com', '09975647387', 'mm', 'Confirmed', 1),
('Ap_000019', 6, '2025-09-29', '01:00:00', 'Di Di', 'di@gmail.com', '09984758698', 'Yangon', 'Confirmed', 1),
('Ap_000020', 6, '2025-09-29', '10:00:00', 'Di Di', 'di@gmail.com', '09975647387', 'yy', 'Confirmed', 1),
('Ap_000024', 6, '2025-09-30', '09:00:00', 'Di Di', 'di@gmail.com', '09975647387', 'yy', 'Confirmed', 1),
('Ap_000026', 6, '2025-10-02', '02:00:00', 'Di Di', 'di@gmail.com', '09975647387', 'htd', 'Confirmed', 1),
('Ap_000030', 6, '2025-10-23', '09:00:00', 'Di Di', 'di@gmail.com', '09975647387', 'yg', 'Confirmed', 1),
('Ap_000033', 5, '2025-10-17', '02:00:00', 'Ntns', 'ntns@gmail.com', '09975647387', 'yg', 'Confirmed', 0),
('Ap_000034', 5, '2025-10-23', '02:00:00', 'Ntns', 'ntns@gmail.com', '09975647387', 'htd', 'Confirmed', 0),
('Ap_000036', 7, '2025-10-22', '09:00:00', 'Eve', 'eve@gmail.com', '099845895789', 'Yangon', 'Active', 1),
('Ap_000037', 7, '2025-10-22', '09:30:00', 'Thomas', 'thomas@gmail.com', '09985787347', 'Yangon', 'Active', 1),
('Ap_000038', 9, '2025-10-22', '10:00:00', 'Lydia', 'Lydia@gmail.com', '09989897898', 'Yangon', 'Active', 1),
('Ap_000039', 10, '2025-10-22', '10:30:00', 'Henry', 'Henry@gmail.com', '09975647387', '', 'Active', 1),
('Ap_000040', 10, '2025-10-22', '11:00:00', 'Henry', 'Henry@gmail.com', '09984758698', 'Yangon', 'Active', 1),
('Ap_000042', 15, '2025-10-30', '03:30:00', 'Iris', 'Iris123@gmail.com', '09975647387', 'Yangon', 'Confirmed', 1),
('Ap_000044', 5, '2025-11-26', '09:00:00', 'Nant Theint', 'ntns@gmail.com', '099768756789', 'Hinthada', 'Confirmed', 0),
('Ap_000045', 5, '2025-12-01', '09:00:00', 'Nant Theint', 'ntns@gmail.com', '09975647387', 'Hinthada', 'Active', 0),
('Ap_000046', 5, '2025-12-15', '11:00:00', 'Nant Theint', 'ntns@gmail.com', '09975647387', 'Hinthada', 'Confirmed', 0),
('Ap_000047', 5, '2025-12-24', '11:30:00', 'Nant Theint', 'ntns@gmail.com', '09975647387', 'Hinthada', 'Confirmed', 0),
('Ap_000048', 5, '2025-11-30', '02:00:00', 'Nant Theint', 'ntns@gmail.com', '09975647387', 'Hinthada', 'Confirmed', 0),
('Ap_000049', 5, '2025-11-27', '09:30:00', 'Nant Theint', 'ntns@gmail.com', '09975647387', 'Hinthada', 'Confirmed', 0),
('Ap_000050', 5, '2025-11-28', '03:30:00', 'Nant Theint', 'ntns@gmail.com', '09975647387', 'Yangon', 'Active', 0),
('Ap_000051', 5, '2025-11-29', '03:30:00', 'Nant Theint', 'ntns@gmail.com', '09975647387', 'Yangon', 'Confirmed', 0),
('Ap_000052', 5, '2025-12-04', '09:00:00', 'Nant Theint', 'ntns@gmail.com', '09975647387', 'Yangon', 'Active', 0),
('Ap_000053', 5, '2025-12-18', '11:00:00', 'Nant Theint', 'ntns@gmail.com', '09975647387', 'Ygn', 'Confirmed', 0),
('Ap_000054', 5, '2025-12-12', '03:30:00', 'Nant Theint', 'ntns@gmail.com', '09975647387', 'Ygn', 'Active', 0),
('Ap_000055', 5, '2025-12-19', '11:00:00', 'Nant Theint', 'ntns@gmail.com', '09975647387', 'Yangon', 'Confirmed', 0),
('Ap_000056', 5, '2025-12-19', '10:00:00', 'Nant Theint', 'ntns@gmail.com', '09975647387', 'Yangon', 'Confirmed', 0),
('Ap_000057', 5, '2025-12-20', '11:30:00', 'Nant Theint', 'ntns@gmail.com', '09975647387', 'Yangon', 'Confirmed', 0),
('Ap_000058', 5, '2025-12-20', '11:30:00', 'Nant Theint', 'ntns@gmail.com', '09975647387', 'Ygn', 'Confirmed', 1);

-- --------------------------------------------------------

--
-- Table structure for table `bill`
--

CREATE TABLE `bill` (
  `Bill_ID` int(11) NOT NULL,
  `InvoiceCode` varchar(30) NOT NULL,
  `PatientID` int(11) NOT NULL,
  `AppointmentCode` varchar(20) NOT NULL,
  `PaymentDate` date NOT NULL,
  `PaymentMethod` varchar(50) NOT NULL,
  `PaymentImage` varchar(255) NOT NULL,
  `Status` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bill`
--

INSERT INTO `bill` (`Bill_ID`, `InvoiceCode`, `PatientID`, `AppointmentCode`, `PaymentDate`, `PaymentMethod`, `PaymentImage`, `Status`) VALUES
(1, 'INV_000007', 5, 'Ap_000001', '2025-08-14', 'Card', 'pay_689dc77f163b1.jpg', 'Paid'),
(2, 'INV_000015', 5, 'Ap_000002', '2025-08-13', 'Kpay', 'pay_689dcadb55f44.jpg', 'Paid'),
(3, 'INV_000007', 5, 'Ap_000001', '2025-08-14', 'Kpay', 'pay_689dd158e15df.jpg', 'Paid'),
(4, 'INV_000015', 5, 'Ap_000002', '2025-08-14', 'Kpay', 'pay_689dd1cecfb58.jpg', 'Paid'),
(5, 'INV_000019', 5, 'Ap_000006', '2025-08-20', 'Kpay', 'pay_68a57ea12c84e.jpg', 'Paid'),
(6, 'INV_000020', 6, 'Ap_000007', '2025-08-20', 'Kpay', 'pay_68a580445c325.jpg', 'Paid'),
(7, 'INV_000021', 6, 'Ap_000008', '2025-08-20', 'Kpay', 'pay_68a5aeb7be6f4.jpg', 'Paid'),
(8, 'INV_000022', 5, 'Ap_000010', '2025-08-21', 'Kpay', 'pay_68a6772f7f867.jpg', 'Paid'),
(9, 'INV_000023', 5, 'Ap_000009', '2025-08-21', 'Kpay', 'pay_68a67d4a00fc2.jpg', 'Paid'),
(10, 'INV_000024', 5, 'Ap_000011', '2025-09-12', 'Cash', 'pay_68c2f9bd41838.png', 'Paid'),
(11, 'INV_000026', 6, 'Ap_000014', '2025-09-12', 'Kpay', 'pay_68c4223163852.jpg', 'Paid'),
(12, 'INV_000027', 5, 'Ap_000015', '2025-09-12', 'Cash', 'pay_68c42838783e1.jpg', 'Paid'),
(13, 'INV_000028', 6, 'Ap_000013', '2025-09-13', 'Cash', 'pay_68c4ca4093597.png', 'Paid'),
(14, 'INV_000029', 6, 'Ap_000017', '2025-09-28', 'Kpay', 'pay_68d9581e55f39.jpg', 'Paid'),
(15, 'INV_000034', 5, 'Ap_000026', '2025-10-22', 'Aya Pay', 'pay_68f876f3bd5f7.png', 'Paid'),
(16, 'INV_000037', 5, 'Ap_000030', '2025-11-27', 'Kpay', 'pay_6927f4437c9f5.png', 'Paid'),
(17, 'INV_000035', 5, 'Ap_000043', '2025-12-03', 'Kpay', 'pay_692fde67b32ed.png', 'Paid'),
(18, 'INV_000036', 5, 'Ap_000042', '2025-12-04', 'Kpay', 'pay_693003a2579d8.png', 'Paid'),
(19, 'INV_000038', 5, 'Ap_000031', '2025-12-10', 'Kpay', 'pay_6930df8bb7c68.png', 'Paid'),
(20, 'INV_000039', 5, 'Ap_000052', '2025-12-04', 'Kpay', 'pay_6930f63732904.png', 'Paid'),
(21, 'INV_000042', 5, 'Ap_000034', '2025-12-04', 'Kpay', 'pay_69312e0e73245.png', 'Paid');

-- --------------------------------------------------------

--
-- Table structure for table `consultation`
--

CREATE TABLE `consultation` (
  `ConsultationCode` varchar(20) NOT NULL,
  `PatientID` int(11) NOT NULL,
  `ConsultationType` enum('virtual','in-person') NOT NULL,
  `ConsultationDate` date NOT NULL,
  `ConsultationTime` time NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `PhoneNumber` varchar(30) NOT NULL,
  `Message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `Status` varchar(30) NOT NULL,
  `IsNotified` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `consultation`
--

INSERT INTO `consultation` (`ConsultationCode`, `PatientID`, `ConsultationType`, `ConsultationDate`, `ConsultationTime`, `Name`, `Email`, `PhoneNumber`, `Message`, `created_at`, `Status`, `IsNotified`) VALUES
('C_000003', 6, 'in-person', '2025-10-23', '03:00:00', 'Di Di', 'di@gmail.com', '099768756789', 'yg', '2025-10-02 13:07:57', 'Active', 1),
('C_000004', 7, 'virtual', '2025-10-15', '09:00:00', 'Thomas', 'thomas@gmail.com', '09984758698', 'mamam', '2025-10-15 02:56:04', 'Active', 1),
('C_000005', 13, 'virtual', '2025-10-15', '09:30:00', 'Thomas Aung', 'thomas@gmail.com', '09984758698', '', '2025-10-15 03:35:53', 'Active', 1),
('C_000006', 13, 'virtual', '2025-10-15', '10:00:00', 'Thomas Aung', 'thomas@gmail.com', '09984758698', '', '2025-10-15 03:37:38', 'Active', 1),
('C_000008', 15, 'in-person', '2025-10-30', '09:00:00', 'Iris', 'Iris123@gmail.com', '09984758698', 'Yangon', '2025-10-30 08:51:48', 'Active', 1),
('C_000009', 5, 'virtual', '2025-12-01', '10:00:00', 'Ntns', 'ntns@gmail.com', '09984758698', 'For treatment', '2025-10-31 14:03:29', 'Confirmed', 1),
('C_000010', 8, 'in-person', '2025-12-01', '11:00:00', 'Irene', 'Irene@gmail.com', '09984758698', 'To discuss treatment', '2025-10-31 14:11:32', 'Confirmed', 1),
('C_000011', 11, 'in-person', '2025-12-01', '11:30:00', 'Lucas', 'Lucas@gmail.com', '09975647387', 'To discuss laser treatment', '2025-10-31 14:21:27', 'Confirmed', 1),
('C_000012', 13, 'in-person', '2025-12-01', '02:00:00', 'Elara', 'Elara@gmail.com', '09978678878', 'To discuss skincare products', '2025-10-31 14:22:37', 'Active', 1),
('C_000013', 15, 'virtual', '2025-11-01', '09:00:00', 'Iris', 'Iris123@gmail.com', '0998376789', 'To discuss Treatments', '2025-10-31 14:31:36', 'Active', 1),
('C_000014', 5, 'in-person', '2025-11-01', '09:30:00', 'Nant Theint', 'ntns@gmail.com', '09975647387', 'To discuss about the treatments', '2025-11-01 00:01:28', 'Active', 1),
('C_000015', 5, 'virtual', '2025-11-25', '09:00:00', 'Ntns', 'ntns@gmail.com', '09975647387', '099898989', '2025-11-24 13:12:07', 'Confirmed', 1),
('C_000016', 5, 'in-person', '2025-11-27', '09:30:00', 'Nant Theint', 'ntns@gmail.com', '09975647387', 'Hinthada', '2025-11-26 07:06:34', 'Active', 1),
('C_000017', 5, 'virtual', '2025-11-27', '02:00:00', 'Nant Theint', 'ntns@gmail.com', '09975647387', 'To discuss facial treatment', '2025-11-27 03:46:15', 'Confirmed', 1),
('C_000018', 6, 'in-person', '2025-11-27', '01:30:00', 'Di Di', 'di@gmail.com', '099768756789', 'To discuss facial treatment', '2025-11-27 04:12:40', 'Active', 1),
('C_000019', 5, 'in-person', '2025-11-28', '11:30:00', 'Nant Theint', 'ntns@gmail.com', '09975647387', 'Yangon', '2025-11-27 17:15:26', 'Confirmed', 1),
('C_000020', 5, 'in-person', '2025-12-04', '03:30:00', 'Nant Theint', 'ntns@gmail.com', '09975647387', 'To discuss treatments', '2025-12-03 06:49:09', 'Confirmed', 1),
('C_000021', 5, 'in-person', '2025-12-04', '03:30:00', 'Nant Theint', 'ntns@gmail.com', '09975647387', 'to discuss treatment', '2025-12-04 06:42:18', 'Active', 0);

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `ContactID` int(11) NOT NULL,
  `Name` varchar(30) NOT NULL,
  `Email` varchar(30) NOT NULL,
  `PhoneNumber` varchar(30) NOT NULL,
  `Subject` varchar(50) NOT NULL,
  `Message` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`ContactID`, `Name`, `Email`, `PhoneNumber`, `Subject`, `Message`) VALUES
(1, 'Di Di', 'di@gmail.com', '09987896789', 'Appointment Booking', 'hhhhjjjj'),
(2, 'Di Di', 'di@gmail.com', '09987896789', 'Appointment Booking', 'hhhhjjjj'),
(3, 'Di Di', 'di@gmail.com', '09987896789', 'Appointment Booking', 'hhhhjjjj'),
(4, 'Aye Chan Moe', 'ayechanmoe@gmail.co', '09458762134', 'General Inquiry', 'Hello, I’d like to know more about your facial treatment services.'),
(5, 'Min Khant Htet', 'minkhanthtet23@yahoo.com', '09785342119', 'Appointment Booking', 'Can I book an appointment for next Tuesday afternoon?'),
(6, 'Su Mon Hlaing', 'suminhl@gmail.com', '09987456320', 'Feedback', 'I had a great experience with your staff. Keep up the good work!'),
(7, 'Nyein Ei Phyu', 'nyeineiphyu2024@gmail.com', '09762134587', 'Other', 'I’m facing issues submitting my order form. Can you assist?'),
(8, 'Hnin Ei Mon', 'hnineimon03@gmail.com', '09657823456', 'General Inquiry', 'I’m interested in your skincare products. Do you ship nationwide?'),
(9, 'Kyaw Zin Phyo', 'kyawzinphyo88@gmail.com', '09487653210', 'Other', 'I didn’t receive a confirmation email after my booking.');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `FeedbackID` int(11) NOT NULL,
  `Name` varchar(30) NOT NULL,
  `Email` varchar(30) NOT NULL,
  `Feedback` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`FeedbackID`, `Name`, `Email`, `Feedback`) VALUES
(1, 'Di Di', 'ntns@gmail.com', 'gghhjj');

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `InvoiceCode` varchar(30) NOT NULL,
  `AppointmentCode` varchar(20) NOT NULL,
  `PatientID` int(11) NOT NULL,
  `StaffID` int(11) NOT NULL,
  `InvoiceDate` date NOT NULL,
  `TotalAmount` int(11) NOT NULL,
  `Status` varchar(20) NOT NULL,
  `Payment` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `invoice`
--

INSERT INTO `invoice` (`InvoiceCode`, `AppointmentCode`, `PatientID`, `StaffID`, `InvoiceDate`, `TotalAmount`, `Status`, `Payment`) VALUES
('INV_000002', 'Ap_000001', 3, 6, '2025-08-06', 120000, 'Unpaid', ''),
('INV_000003', 'Ap_000001', 3, 6, '2025-08-06', 75500, 'Unpaid', ''),
('INV_000004', 'Ap_000001', 3, 6, '2025-08-06', 170300, 'Unpaid', ''),
('INV_000005', 'Ap_000001', 2, 1, '2025-08-06', 50000, 'Unpaid', ''),
('INV_000006', 'Ap_000001', 2, 6, '2025-08-06', 25000, 'Unpaid', ''),
('INV_000007', 'Ap_000001', 5, 1, '2025-08-06', 25000, 'Paid', ''),
('INV_000008', 'Ap_000001', 2, 1, '2025-08-06', 400000, 'Unpaid', ''),
('INV_000009', 'Ap_000002', 4, 1, '2025-08-07', 25000, 'Unpaid', ''),
('INV_000010', 'Ap_000001', 3, 1, '2025-08-08', 100000, 'Unpaid', ''),
('INV_000011', 'Ap_000002', 3, 6, '2025-08-12', 400000, 'Unpaid', ''),
('INV_000012', 'Ap_000001', 3, 6, '2025-08-12', 500000, 'Sent', ''),
('INV_000013', 'Ap_000002', 5, 1, '2025-08-12', 500000, 'Sent', ''),
('INV_000014', 'Ap_000002', 5, 1, '2025-08-12', 800000, 'Sent', ''),
('INV_000015', 'Ap_000002', 5, 8, '2025-08-14', 500000, 'Sent', ''),
('INV_000016', 'Ap_000003', 5, 6, '2025-08-14', 50150, 'Sent', ''),
('INV_000017', 'Ap_000004', 6, 9, '2025-08-17', 101000, 'Sent', ''),
('INV_000018', 'Ap_000005', 5, 1, '2025-08-19', 122500, 'Sent', ''),
('INV_000019', 'Ap_000006', 5, 8, '2025-08-20', 400000, 'Sent', 'Paid'),
('INV_000020', 'Ap_000007', 6, 1, '2025-08-20', 400000, 'Sent', 'Paid'),
('INV_000021', 'Ap_000008', 6, 8, '2025-08-20', 200000, 'Sent', 'Paid'),
('INV_000022', 'Ap_000010', 5, 8, '2025-08-21', 100000, 'Sent', 'Paid'),
('INV_000023', 'Ap_000009', 5, 8, '2025-08-21', 265000, 'Sent', 'Paid'),
('INV_000024', 'Ap_000011', 5, 8, '2025-08-22', 400000, 'Sent', 'Paid'),
('INV_000025', 'Ap_000012', 6, 8, '2025-09-11', 740000, 'Sent', 'Unpaid'),
('INV_000026', 'Ap_000014', 6, 6, '2025-09-12', 220000, 'Sent', 'Paid'),
('INV_000027', 'Ap_000015', 5, 8, '2025-09-12', 240000, 'Sent', 'Paid'),
('INV_000028', 'Ap_000013', 6, 8, '2025-09-13', 1000, 'Unpaid', 'Paid'),
('INV_000029', 'Ap_000017', 6, 8, '2025-09-13', 290000, 'Sent', 'Paid'),
('INV_000030', 'Ap_000019', 6, 6, '2025-10-01', 1000, 'Unpaid', 'Unpaid'),
('INV_000031', 'Ap_000016', 2, 1, '2025-10-22', 170000, 'Sent', 'Unpaid'),
('INV_000032', 'Ap_000020', 3, 1, '2025-10-22', 1000, 'Sent', 'Unpaid'),
('INV_000033', 'Ap_000024', 7, 1, '2025-10-22', 700000, 'Sent', 'Unpaid'),
('INV_000034', 'Ap_000026', 5, 1, '2025-10-22', 1000000, 'Sent', 'Paid'),
('INV_000035', 'Ap_000043', 5, 1, '2025-11-01', 150, 'Sent', 'Paid'),
('INV_000036', 'Ap_000042', 5, 1, '2025-11-01', 300000, 'Sent', 'Paid'),
('INV_000037', 'Ap_000030', 5, 1, '2025-11-27', 1000, 'Sent', 'Paid'),
('INV_000038', 'Ap_000031', 5, 1, '2025-11-27', 120000, 'Sent', 'Paid'),
('INV_000039', 'Ap_000052', 5, 1, '2025-12-03', 600000, 'Sent', 'Paid'),
('INV_000040', 'Ap_000053', 5, 1, '2025-12-03', 500000, 'Sent', 'Unpaid'),
('INV_000041', 'Ap_000033', 5, 1, '2025-12-04', 240000, 'Sent', 'Unpaid'),
('INV_000042', 'Ap_000034', 5, 1, '2025-12-04', 120000, 'Sent', 'Paid'),
('INV_000043', 'Ap_000058', 5, 1, '2025-12-04', 120000, 'Sent', 'Unpaid');

-- --------------------------------------------------------

--
-- Table structure for table `invoicedetail`
--

CREATE TABLE `invoicedetail` (
  `InvoiceDetailID` int(11) NOT NULL,
  `InvoiceCode` varchar(30) NOT NULL,
  `TreatmentCode` varchar(30) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `UnitPrice` int(11) NOT NULL,
  `Subtotal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `invoicedetail`
--

INSERT INTO `invoicedetail` (`InvoiceDetailID`, `InvoiceCode`, `TreatmentCode`, `Quantity`, `UnitPrice`, `Subtotal`) VALUES
(1, 'INV_000002', 'Tr_000002', 1, 120000, 120000),
(2, 'INV_000003', '', 1, 25000, 25000),
(3, 'INV_000003', 'Tr_000001', 1, 50000, 50000),
(4, 'INV_000003', 'Tr_000003', 1, 500, 500),
(5, '', 'Tr_000006', 1, 400000, 400000),
(6, 'INV_000004', 'Tr_000004', 2, 150, 300),
(7, 'INV_000004', 'Tr_000002', 1, 120000, 120000),
(8, 'INV_000004', 'Tr_000001', 1, 50000, 50000),
(9, 'INV_000005', 'Tr_000001', 1, 50000, 50000),
(10, 'INV_000006', '', 1, 25000, 25000),
(11, 'INV_000007', '', 1, 25000, 25000),
(12, 'INV_000008', 'Tr_000006', 1, 400000, 400000),
(13, 'INV_000009', '', 1, 25000, 25000),
(14, 'INV_000010', 'Tr_000001', 2, 50000, 100000),
(15, 'INV_000011', 'Tr_000006', 1, 400000, 400000),
(16, 'INV_000012', 'Tr_000005', 2, 250000, 500000),
(17, 'INV_000013', 'Tr_000005', 2, 250000, 500000),
(18, 'INV_000014', 'Tr_000006', 2, 400000, 800000),
(19, 'INV_000015', 'Tr_000005', 2, 250000, 500000),
(20, 'INV_000016', 'Tr_000004', 1, 150, 150),
(21, 'INV_000016', 'Tr_000001', 1, 50000, 50000),
(22, 'INV_000017', 'Tr_000003', 2, 500, 1000),
(23, 'INV_000017', 'Tr_000008', 1, 100000, 100000),
(24, 'INV_000018', 'Tr_000002', 1, 120000, 120000),
(25, 'INV_000018', 'Tr_000003', 5, 500, 2500),
(26, 'INV_000019', 'Tr_000011', 1, 400000, 400000),
(27, 'INV_000020', 'Tr_000009', 2, 200000, 400000),
(28, 'INV_000021', 'Tr_000008', 2, 100000, 200000),
(29, 'INV_000022', 'Tr_000008', 1, 100000, 100000),
(30, 'INV_000023', 'Tr_000002', 2, 120000, 240000),
(31, 'INV_000023', '', 1, 25000, 25000),
(32, 'INV_000024', 'Tr_000006', 1, 400000, 400000),
(33, 'INV_000025', 'Tr_000002', 2, 120000, 240000),
(34, 'INV_000025', 'Tr_000005', 2, 250000, 500000),
(35, 'INV_000026', 'Tr_000001', 2, 50000, 100000),
(36, 'INV_000026', 'Tr_000002', 1, 120000, 120000),
(37, 'INV_000027', 'Tr_000002', 2, 120000, 240000),
(38, 'INV_000028', 'Tr_000003', 2, 500, 1000),
(39, 'INV_000029', 'Tr_000002', 2, 120000, 240000),
(40, 'INV_000029', 'Tr_000001', 1, 50000, 50000),
(41, 'INV_000030', 'Tr_000003', 2, 500, 1000),
(42, 'INV_000031', 'Tr_000001', 1, 50000, 50000),
(43, 'INV_000031', 'Tr_000002', 1, 120000, 120000),
(44, 'INV_000032', 'Tr_000003', 2, 500, 1000),
(45, 'INV_000033', 'Tr_000007', 2, 350000, 700000),
(46, 'INV_000034', 'Tr_000006', 2, 400000, 800000),
(47, 'INV_000034', 'Tr_000009', 1, 200000, 200000),
(48, 'INV_000035', 'Tr_000004', 1, 150, 150),
(49, 'INV_000036', 'Tr_000008', 3, 100000, 300000),
(50, 'INV_000037', 'Tr_000003', 2, 500, 1000),
(51, 'INV_000038', 'Tr_000010', 1, 120000, 120000),
(52, 'INV_000039', 'Tr_000005', 2, 250000, 500000),
(53, 'INV_000039', 'Tr_000001', 2, 50000, 100000),
(54, 'INV_000040', 'Tr_000005', 2, 250000, 500000),
(55, 'INV_000041', 'Tr_000002', 2, 120000, 240000),
(56, 'INV_000042', 'Tr_000012', 2, 60000, 120000),
(57, 'INV_000043', 'Tr_000016', 2, 60000, 120000);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `NotificationID` int(11) NOT NULL,
  `TargetType` enum('Patient','Aesthetic Doctor','Nurse','Admin','Receptionist') NOT NULL,
  `PatientID` int(11) DEFAULT NULL,
  `StaffID` int(11) DEFAULT NULL,
  `Message` text NOT NULL,
  `IsRead` tinyint(1) NOT NULL,
  `IsNotifiedStaff` tinyint(1) NOT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `OrderCode` varchar(20) NOT NULL,
  `PatientID` int(11) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Phone` varchar(50) NOT NULL,
  `OrderDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `PaymentMethod` varchar(50) NOT NULL,
  `PaymentImage` varchar(255) NOT NULL,
  `DeliveryAddress` varchar(100) NOT NULL,
  `TotalAmount` int(11) NOT NULL,
  `TotalQuantity` int(11) NOT NULL,
  `Status` varchar(30) NOT NULL,
  `IsNotified` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`OrderCode`, `PatientID`, `Name`, `Email`, `Phone`, `OrderDate`, `PaymentMethod`, `PaymentImage`, `DeliveryAddress`, `TotalAmount`, `TotalQuantity`, `Status`, `IsNotified`) VALUES
('Ord_000006', 5, 'Nant Theint', 'ntns@gmail.com', '09975647387', '2025-11-27 17:05:40', 'Cash', '', 'Yangon', 135000, 3, 'Confirmed', 0),
('Ord_000007', 6, 'Di Di', 'di@gmail.com', '09975647387', '2025-10-04 14:12:37', 'Cash', '', 'Ua', 44000, 2, 'Confirmed', 1),
('Ord_000010', 0, 'Iris', 'Iris123@gmail.com', '09975647387', '2025-10-30 10:36:01', 'KPay', 'uploads/payments/pay_69033f37d430e.jpg', 'Yangon', 45000, 1, 'Pending', 1),
('Ord_000011', 0, 'Nant Theint', 'ntns@gmail.com', '0998989890', '2025-10-31 16:00:29', 'WavePay', 'uploads/payments/pay_6904d5b189fb0.jpg', 'Yangon', 44000, 2, 'Pending', 1),
('Ord_000012', 0, 'Nant Theint', 'ntns@gmail.com', '09984758698', '2025-10-31 16:00:29', 'WavePay', 'uploads/payments/pay_6904d61e7e794.jpg', 'Yangon', 30000, 3, 'Pending', 1),
('Ord_000013', 0, 'Irene', 'Irene@gmail.com', '09975647387', '2025-10-31 16:00:29', 'Aya Pay', 'uploads/payments/pay_6904d684bd4f0.jpg', 'Yangon', 90000, 2, 'Pending', 1),
('Ord_000014', 1, 'Admin', 'admin@gmail.com', '09984758698', '2025-10-31 16:00:29', 'WavePay', 'uploads/payments/pay_6904d8b4bf93f.jpg', 'Yangon', 38000, 2, 'Pending', 1),
('Ord_000015', 1, 'Admin', 'admin@gmail.com', '09984758698', '2025-10-31 16:00:29', 'Aya Pay', 'uploads/payments/pay_6904dbedae505.jpg', 'Yangon', 36000, 3, 'Pending', 1),
('Ord_000016', 0, 'Nant Theint', 'ntns@gmail.com', '09975647387', '2025-11-21 10:43:05', 'Aya Pay', 'uploads/payments/pay_6904f4afbbd1f.jpg', 'Yangon', 134000, 4, 'Pending', 1),
('Ord_000017', 0, 'Nant Theint', 'ntns@gmail.com', '09975647387', '2025-11-21 10:43:05', 'Aya Pay', 'uploads/payments/pay_69054e3986aed.jpg', 'Yangon', 60000, 2, 'Pending', 1),
('Ord_000018', 0, 'Nant Theint', 'ntns@gmail.com', '09975647387', '2025-11-26 12:24:38', 'KPay', 'uploads/payments/pay_6925b6528c50f.png', 'Hinthada', 110000, 4, 'Pending', 1),
('Ord_000019', 0, 'Nant Theint', 'ntns@gmail.com', '09975647387', '2025-11-26 12:24:38', 'KPay', 'uploads/payments/pay_6925b698df238.png', 'Hinthada', 90000, 2, 'Pending', 1),
('Ord_000020', 0, 'Nant Theint', 'ntns@gmail.com', '09975647387', '2025-11-26 12:24:38', 'KPay', 'uploads/payments/pay_6925d66e2e984.png', 'Hinthada', 24000, 2, 'Pending', 1),
('Ord_000021', 0, 'Nant Theint', 'ntns@gmail.com', '09975647387', '2025-11-26 12:24:38', 'KPay', 'uploads/payments/pay_6925dc9fd15a9.png', 'Hinthada', 45000, 1, 'Pending', 1),
('Ord_000022', 5, 'Nant Theint', 'ntns@gmail.com', '09975647387', '2025-11-27 17:05:27', 'KPay', 'uploads/payments/pay_6925dea60ffc8.png', 'Hinthada', 22000, 1, 'Confirmed', 0),
('Ord_000024', 5, 'Nant Theint', 'ntns@gmail.com', '09975647387', '2025-12-03 09:31:00', 'KPay', 'uploads/payments/pay_6927ce949cc2f.png', 'Yangon', 42000, 3, 'Pending', 0),
('Ord_000025', 6, 'Di Di', 'di@gmail.com', '099768756789', '2025-11-27 16:13:21', 'KPay', 'uploads/payments/pay_6927cf05cf456.png', 'Yangon', 44000, 2, 'Pending', 1),
('Ord_000026', 5, 'Nant Theint', 'ntns@gmail.com', '09975647387', '2025-12-03 09:31:00', 'KPay', 'uploads/payments/pay_6927e803cb931.png', 'Yangon', 60000, 2, 'Pending', 0),
('Ord_000027', 5, 'Nant Theint', 'ntns@gmail.com', '09975647387', '2025-12-03 09:31:00', 'KPay', 'uploads/payments/pay_6927f3c907bda.png', 'Yangon', 44000, 2, 'Pending', 0),
('Ord_000028', 5, 'Nant Theint', 'ntns@gmail.com', '09975647387', '2025-12-03 09:31:00', 'KPay', 'uploads/payments/pay_6928771e092e5.png', 'Yangon', 30000, 1, 'Pending', 0),
('Ord_000029', 5, 'Nant Theint', 'ntns@gmail.com', '09975647387', '2025-11-27 17:18:07', 'KPay', 'uploads/payments/pay_692887cf4406b.png', 'Yangon', 90000, 3, 'Pending', 0),
('Ord_000030', 5, 'Nant Theint', 'ntns@gmail.com', '09975647387', '2025-12-03 06:52:28', 'KPay', 'uploads/payments/pay_692fde2c513bd.png', 'Yanogn', 85000, 3, 'Pending', 0),
('Ord_000031', 5, 'Nant Theint', 'ntns@gmail.com', '09975647387', '2025-12-03 09:31:00', 'KPay', 'uploads/payments/pay_692ff8368f4ab.png', 'Ygn', 55000, 2, 'Confirmed', 0),
('Ord_000032', 5, 'Nant Theint', 'ntns@gmail.com', '09975647387', '2025-12-03 09:30:49', 'KPay', 'uploads/payments/pay_69300349620a8.png', 'Ygn', 55000, 2, 'Pending', 0),
('Ord_000033', 5, 'Nant Theint', 'ntns@gmail.com', '09975647387', '2025-12-04 01:09:14', 'KPay', 'uploads/payments/pay_6930df3a5314d.png', 'Yangon', 55000, 2, 'Pending', 0),
('Ord_000034', 5, 'Nant Theint', 'ntns@gmail.com', '09975647387', '2025-12-04 06:44:31', 'KPay', 'uploads/payments/pay_6930efeab0304.png', 'Yangon', 55000, 2, 'Confirmed', 0),
('Ord_000035', 5, 'Nant Theint', 'ntns@gmail.com', '09975647387', '2025-12-04 06:44:31', 'KPay', 'uploads/payments/pay_6930f60da5eba.png', 'Yangon', 55000, 2, 'Confirmed', 0),
('Ord_000036', 5, 'Nant Theint', 'ntns@gmail.com', '09975647387', '2025-12-04 06:44:20', 'KPay', 'uploads/payments/pay_69312dc487248.png', 'Ygn', 55000, 2, 'Pending', 0);

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `OrderCode` varchar(20) NOT NULL,
  `ProductCode` varchar(30) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `Price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`OrderCode`, `ProductCode`, `Quantity`, `Price`) VALUES
('0', 'Pr_000006', 2, 22000),
('0', 'Pr_000002', 2, 45000),
('0', 'Pr_000004', 3, 35000),
('0', 'Pr_000005', 2, 10000),
('0', 'Pr_000007', 2, 12000),
('0', 'Pr_000008', 2, 25000),
('0', 'Pr_000002', 3, 45000),
('0', 'Pr_000006', 2, 22000),
('0', 'Pr_000003', 2, 19000),
('0', 'Pr_000002', 2, 45000),
('Ord_000009', 'Pr_000006', 4, 22000),
('Ord_000010', 'Pr_000006', 3, 22000),
('Ord_000010', 'Pr_000002', 1, 45000),
('Ord_000011', 'Pr_000006', 2, 22000),
('Ord_000012', 'Pr_000005', 3, 10000),
('Ord_000013', 'Pr_000002', 2, 45000),
('Ord_000014', 'Pr_000003', 2, 19000),
('Ord_000015', 'Pr_000007', 3, 12000),
('Ord_000016', 'Pr_000006', 2, 22000),
('Ord_000016', 'Pr_000002', 2, 45000),
('Ord_000017', 'Pr_000009', 2, 30000),
('Ord_000018', 'Pr_000002', 2, 45000),
('Ord_000018', 'Pr_000005', 2, 10000),
('Ord_000019', 'Pr_000002', 2, 45000),
('Ord_000020', 'Pr_000007', 2, 12000),
('Ord_000021', 'Pr_000002', 1, 45000),
('Ord_000022', 'Pr_000006', 1, 22000),
('Ord_000023', 'Pr_000009', 2, 30000),
('Ord_000024', 'Pr_000006', 1, 22000),
('Ord_000024', 'Pr_000005', 2, 10000),
('Ord_000025', 'Pr_000006', 2, 22000),
('Ord_000026', 'Pr_000009', 2, 30000),
('Ord_000027', 'Pr_000006', 2, 22000),
('Ord_000028', 'Pr_000010', 1, 30000),
('Ord_000029', 'Pr_000010', 3, 30000),
('Ord_000030', 'Pr_000013', 1, 25000),
('Ord_000030', 'Pr_000010', 2, 30000),
('Ord_000031', 'Pr_000013', 1, 25000),
('Ord_000031', 'Pr_000010', 1, 30000),
('Ord_000032', 'Pr_000013', 1, 25000),
('Ord_000032', 'Pr_000010', 1, 30000),
('Ord_000033', 'Pr_000013', 1, 25000),
('Ord_000033', 'Pr_000010', 1, 30000),
('Ord_000034', 'Pr_000013', 1, 25000),
('Ord_000034', 'Pr_000010', 1, 30000),
('Ord_000035', 'Pr_000013', 1, 25000),
('Ord_000035', 'Pr_000010', 1, 30000),
('Ord_000036', 'Pr_000013', 1, 25000),
('Ord_000036', 'Pr_000010', 1, 30000);

-- --------------------------------------------------------

--
-- Table structure for table `patientregister`
--

CREATE TABLE `patientregister` (
  `PatientID` int(11) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `UserName` varchar(50) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `PhoneNumber` varchar(30) NOT NULL,
  `DateofBirth` date NOT NULL,
  `Gender` varchar(30) NOT NULL,
  `Address` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patientregister`
--

INSERT INTO `patientregister` (`PatientID`, `Name`, `UserName`, `Email`, `Password`, `PhoneNumber`, `DateofBirth`, `Gender`, `Address`) VALUES
(2, 'Kit', 'Kit', 'kit@gmail.com', '$2y$10$6qMezQadhhDzuUVdWJzGmen', '0985758478', '2025-06-11', 'Female', 'Yangon'),
(3, 'KK', 'KK', 'kk@gmail.com', '$2y$10$rYq./F.J4AuxkXRbVAYLkuI', '098876756789', '2025-06-23', 'Female', 'Yangon'),
(5, 'Nant Theint Nadi Soe', 'Theint Nadi', 'ntns@gmail.com', '$2y$10$jsvlDjl1gZqQ0hjakocv4eFO6EJN1XLO1sd94J2SWkhOE7vzaMYy6', '09975647387', '2003-02-24', 'Female', 'Hinthada'),
(6, 'Di Di', 'Di Di', 'di@gmail.com', '$2y$10$enpya0qtoQo4XJvbPnFYjO5NuUnA8SalK01cGuiY2wF26wKG0tNTm', '09978678878', '2003-02-12', 'Female', 'Hinthada'),
(7, 'Thomas', 'Thomas', 'thomas@gmail.com', '$2y$10$lSi9cDFE4twphRF7EIc84eNjivhmyEHZTQJkVOLtB2/lxUPOcJwXu', '099837388', '2002-12-25', 'Female', 'Yangon'),
(8, 'Irene', 'Irene', 'Irene@gmail.com', '$2y$10$lnHN0O7m713dC6kZwqVequQVzAHR9clcx05874MVQ.uMuu9Qvl0i.', '0998376789', '2002-12-25', 'Female', 'Yangon'),
(9, 'Lydia', 'Lydia', 'Lydia@gmail.com', '$2y$10$kMiksjZc0OgXHeg9lek90us1W/iBXwCBJ1/bHidTUuZHCUS3C7mmK', '09975647387', '2000-10-05', 'Female', 'Yangon'),
(10, 'Henry', 'Henry', 'Henry@gmail.com', '$2y$10$gu5lotqacMZHqZNotIo3Ve9xkIjstjsYru/E7NUOgFWgI.iUJkie.', '099484957899', '2000-04-15', 'Male', 'Yangon'),
(11, 'Lucas', 'Lucas', 'Lucas@gmail.com', '$2y$10$7JUdRCiCxGHmYuWlX6.0i.ql5GKEbXnBtWq0RKqD7np72GlkQVQBK', '0998767899', '1990-10-12', 'Male', 'Yangon'),
(12, 'Chloe', 'Chloe', 'Chloe@123', '$2y$10$VWQ60DQLBKlWMrifAaIIhOEnKI0L2KAHbf2eSyOOR0Ing4V6vDopK', '0998748578', '2001-07-15', 'Female', 'Hinthada'),
(13, 'Elara', 'Elara', 'Elara@gmail.com', '$2y$10$..WhycWfhWS4Np4ERxM18.oOEcSzmfplgjJ1pXDGogXt9Bg8ofXiK', '099897869', '2005-03-10', 'Female', 'Yangon'),
(15, 'Iris', 'Iris', 'Iris123@gmail.com', '$2y$10$K0d/WpKDd3bs/ZMQvj8KaOrzWJpELh74srXxG5j5WJSDN5qqf2e3O', '09986789584', '2025-10-30', 'Female', 'Yangon');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `ProductCode` varchar(30) NOT NULL,
  `ProductName` varchar(100) NOT NULL,
  `ProductType` varchar(50) NOT NULL,
  `ProductImage` varchar(255) NOT NULL,
  `Price` int(11) NOT NULL,
  `ManufactureDate` date NOT NULL,
  `ExpiryDate` date NOT NULL,
  `ProductSize` varchar(30) NOT NULL,
  `ProductQuantity` int(11) NOT NULL,
  `Discount` int(11) NOT NULL,
  `Description` varchar(255) NOT NULL,
  `Status` varchar(50) NOT NULL,
  `ModifiedDate` datetime DEFAULT NULL,
  `IsNotified` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`ProductCode`, `ProductName`, `ProductType`, `ProductImage`, `Price`, `ManufactureDate`, `ExpiryDate`, `ProductSize`, `ProductQuantity`, `Discount`, `Description`, `Status`, `ModifiedDate`, `IsNotified`) VALUES
('Pr_000002', 'Anti-Aging Serum', 'Serum', 'UploadedImage/_anti_aging_serum.jpg', 45000, '2024-12-24', '2026-12-24', '30 ml', 50, 0, 'Advanced serum to reduce wrinkles and fine lines.', 'Available', NULL, 0),
('Pr_000003', 'Sunscreen SPF 50', 'Sun Cream', 'UploadedImage/_sunscreen_spf50.webp', 20000, '2024-10-15', '2026-10-15', '75 ml', 50, 5, 'High protection sunscreen for all skin types.', 'Available', NULL, 0),
('Pr_000004', 'Collagen Drink', 'Collagen Drink', 'UploadedImage/_collagen_drink.webp', 35000, '2025-07-15', '2026-07-15', '10 bottles (50 ml each)', 50, 0, 'Collagen-rich drink for healthy skin and hair.', 'Available', NULL, 0),
('Pr_000005', 'Lip Balm', 'Lip Balm', 'UploadedImage/_lip-balm.webp', 10000, '2025-02-10', '2026-02-10', '10 g', 100, 0, 'Hydrating lip balm with natural oils.', 'Available', NULL, 0),
('Pr_000006', 'Body Lotion', 'Body Lotion', 'UploadedImage/_body_lotion.webp', 22000, '2025-06-20', '2025-06-20', '250 ml', 80, 0, 'Moisturizing body lotion with long-lasting hydration.', 'Available', NULL, 0),
('Pr_000007', 'Face Mask Sheet', 'Face Mask', 'UploadedImage/_sheet-mask.webp', 12000, '2024-08-10', '2026-08-10', '25 ml per sheet', 60, 0, 'Hydrating and refreshing face masks.', 'Available', NULL, 0),
('Pr_000008', 'Aloe Vera Gel', 'Soothing Gel', 'UploadedImage/_Aloe_Vera_Gel.jpg', 25000, '2025-08-02', '2026-08-02', '100 ml', 100, 0, 'Multi-purpose soothing gel made with pure aloe vera.', 'Available', NULL, 0),
('Pr_000009', 'Hair Oil Treatment', 'Hair Oil', 'UploadedImage/_hair_oil_treaatment.jpg', 30000, '2025-09-03', '2027-09-03', '150 ml', 70, 0, 'Nourishing oil for strong and silky hair.', 'Active', '2025-11-01 01:06:18', 0),
('Pr_000010', 'Hair Repair Serum', 'Hair Serum', 'UploadedImage/_hairserum.webp', 30000, '2027-01-10', '2025-01-10', '50 ml', 45, 0, 'Silky serum that repairs split ends and reduces frizz.', 'Available', '2025-11-27 12:39:41', 0),
('Pr_000011', 'Volume & Strength Shampoo', 'Shampoo', 'UploadedImage/_shampoo.jpeg', 9000, '2025-02-10', '2027-02-10', '250 ml', 80, 0, 'Strengthening shampoo that promotes healthy, voluminous hair.', 'Available', '2025-11-27 12:41:57', 0),
('Pr_000012', 'AURA Brightening Facial Foam', 'Facial Foam', 'UploadedImage/_FacialForm.jpg', 15000, '2025-01-10', '2027-01-10', '100 ml', 50, 0, 'Gentle cleansing foam that brightens skin and removes impurities.', 'Available', '2025-11-27 12:44:10', 0),
('Pr_000013', 'Toner  Updated', 'Toner', 'UploadedImage/_toner.jpg', 25000, '2025-11-27', '2027-11-27', '250 ml', 45, 0, 'Alcohol-free toner', 'Active', '2025-12-04 07:47:46', 0);

-- --------------------------------------------------------

--
-- Table structure for table `recommendation`
--

CREATE TABLE `recommendation` (
  `RecommendationCode` varchar(30) NOT NULL,
  `AssessmentCode` varchar(30) NOT NULL,
  `StaffID` int(11) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `UserName` varchar(50) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `RecommendationDate` date NOT NULL,
  `SkinType` varchar(50) NOT NULL,
  `Observations` text NOT NULL,
  `RecommendedTreatments` text DEFAULT NULL,
  `RecommendedProducts` text DEFAULT NULL,
  `LifestyleAdvice` text NOT NULL,
  `FollowUpDate` date DEFAULT NULL,
  `IsNotified` tinyint(1) NOT NULL DEFAULT 0,
  `Status` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `recommendation`
--

INSERT INTO `recommendation` (`RecommendationCode`, `AssessmentCode`, `StaffID`, `Name`, `UserName`, `Email`, `RecommendationDate`, `SkinType`, `Observations`, `RecommendedTreatments`, `RecommendedProducts`, `LifestyleAdvice`, `FollowUpDate`, `IsNotified`, `Status`) VALUES
('R_000003', 'SA_000002', 8, 'Zuri', 'Zuri', 'zuri@gmail.com', '2025-07-06', 'Combination', 'dddhdjf', 'Glow Boost Facial, Kybella, LED Light Therapy, Microneedling', 'cncn', 'djdj', NULL, 0, ''),
('R_000005', 'SA_000004', 8, 'Zuri', 'Zuri', 'zuri@gmail.com', '2025-07-07', 'Oily', 'hjj', 'Anti-Aging Glow Booster, Glow Boost Facial, Kybella, LED Light Therapy', 'njjkk', 'Absolutely! Below is the full view_recommendation.php file with:\r\n\r\nAccess control for both staff and patients\r\n\r\nProper query to fetch data securely\r\nLayout remains the same (Tailwind-based)\r\nAccess restriction: patients can only see their own recommendations', NULL, 0, ''),
('R_000006', 'Select Assessment Code', 8, 'Zuri', 'Zuri', 'zuri@gmail.com', '2025-07-08', 'Combination', 'hhh', 'Botox Wrinkle Treatment, Glow Boost Facial, Kybella, LED Light Therapy', 'jj', 'hhh', '2025-07-09', 1, ''),
('R_000007', 'SA_000006', 8, 'Zuri', 'Zuri', 'zuri@gmail.com', '2025-07-10', 'Oily', 'hhhh', 'Glow Boost Facial', 'hhh', 'hhh', NULL, 0, ''),
('R_000008', 'SA_000005', 8, 'Zuri', 'Zuri', 'zuri@gmail.com', '2025-07-08', 'Combination', 'jjjj', 'Anti-Aging Glow Booster, Glow Boost Facial, Kybella', 'nmm', 'mmm,', NULL, 0, ''),
('R_000009', 'SA_000007', 8, 'Zuri', 'Zuri', 'zuri@gmail.com', '2025-07-10', 'Oily', 'hhjj', ' Chemical Peel, Botox Wrinkle Treatment, Hyaluronic Acid Filler', 'hjk', 'jkll', NULL, 0, ''),
('R_000010', 'SA_000008', 8, 'Zuri', 'Zuri', 'zuri@gmail.com', '2025-07-10', 'Dry', 'zz', 'Glow Boost Facial, Kybella, LED Light Therapy', 'zz', 'zz', NULL, 0, ''),
('R_000011', 'SA_000010', 8, 'Zuri', 'Zuri', 'zuri@gmail.com', '2025-07-10', 'Oily', 'j', ' Chemical Peel, Botox Wrinkle Treatment, Glow Boost Facial', 'jj', 'jj', NULL, 0, ''),
('R_000012', 'SA_000011', 8, 'Zuri', 'Zuri', 'zuri@gmail.com', '2025-07-10', 'Oily', 'j', ' Chemical Peel, Botox Wrinkle Treatment, Glow Boost Facial', 'jj', 'jj', NULL, 0, ''),
('R_000013', 'Select Assessment Code', 8, 'Zuri', 'Zuri', 'zuri@gmail.com', '2025-07-10', 'Oily', 'hhgh', ' Chemical Peel, Botox Wrinkle Treatment, Hyaluronic Acid Filler', 'j', 'j', NULL, 1, ''),
('R_000014', 'SA_000012', 8, 'Zuri', 'Zuri', 'zuri@gmail.com', '2025-07-11', 'Oily', 's', 'Glow Boost Facial, Kybella, LED Light Therapy', 'j', 'j', NULL, 0, ''),
('R_000015', 'SA_000013', 8, 'Zuri', 'Zuri', 'zuri@gmail.com', '2025-07-10', 'Combination', 'jjj', ' Chemical Peel, Botox Wrinkle Treatment, Hyaluronic Acid Filler', 'jjjj', 'nnnn', NULL, 0, ''),
('R_000016', 'SA_000014', 1, 'Admin', 'Admin', 'admin@gmail.com', '2025-08-07', 'Dry', 'jjkk', 'Glow Boost Facial', 'jjj', 'kkk', NULL, 0, ''),
('R_000017', 'SA_000009', 1, 'Admin', 'Admin', 'admin@gmail.com', '2025-08-16', 'Combination', 'jjj', 'Anti-Aging Glow Booster', 'j', 'k', NULL, 0, ''),
('R_000018', 'SA_000015', 1, 'Admin', 'Admin', 'admin@gmail.com', '2025-08-08', 'Oily', 'jjj', 'Glow Boost Facial', 'jjj', 'jj', NULL, 0, ''),
('R_000019', 'SA_000016', 1, 'Admin', 'Admin', 'admin@gmail.com', '2025-08-02', 'Dry', 'jjj', 'Glow Boost Facial', 'kkk', 'kk', NULL, 0, ''),
('R_000020', 'SA_000017', 1, 'Admin', 'Admin', 'admin@gmail.com', '2025-08-02', 'Oily', 'hh', 'Anti-Aging Glow Booster', 'n', 'n', NULL, 0, 'Pending'),
('R_000021', 'SA_000018', 1, 'Admin', 'Admin', 'admin@gmail.com', '2025-08-02', 'Combination', 'zzz', 'LED Light Therapy', 'h', 'u', NULL, 0, 'Sent'),
('R_000022', 'SA_000019', 1, 'Admin', 'Admin', 'admin@gmail.com', '2025-08-02', 'Dry', 'jjj', 'LED Light Therapy, Microneedling', 'jj', 'jj', NULL, 0, 'Pending'),
('R_000023', 'SA_000020', 1, 'Admin', 'Admin', 'admin@gmail.com', '2025-08-02', 'Dry', 'j', 'Kybella', 'n', 'n', NULL, 0, 'Sent'),
('R_000024', 'SA_000021', 1, 'Admin', 'Admin', 'admin@gmail.com', '2025-08-03', 'Oily', 'jj', 'Glow Boost Facial', 'kkk', 'kk', NULL, 0, 'Sent'),
('R_000025', 'Select Assessment Code', 1, 'Admin', 'Admin', 'admin@gmail.com', '2025-08-08', 'Dry', 'jj', 'Anti-Aging Glow Booster, Botox Wrinkle Treatment', 'jj', 'jj', NULL, 1, 'Sent'),
('R_000026', 'SA_000022', 8, 'Zuri', 'Zuri', 'zuri@gmail.com', '2025-09-12', 'Dry', 'this is observation.', 'Botox Wrinkle Treatment, Hyaluronic Acid Filler, Laser Hair Removal', 'this is about your recommended skincare products.', 'Lifestyle Advice', '2025-09-25', 0, 'Sent'),
('R_000027', 'SA_000024', 8, 'Zuri', 'Zuri', 'zuri@gmail.com', '2025-09-12', 'Combination', 'www', ' Chemical Peel, Botox Wrinkle Treatment', 'wwwweee', 'eeee', '2025-09-26', 0, 'Sent'),
('R_000028', 'SA_000025', 8, 'Zuri', 'Zuri', 'zuri@gmail.com', '2025-09-12', 'Oily', 'hhh', 'Botox Wrinkle Treatment, Hyaluronic Acid Filler', 'jjjj', 'jjj', '2025-09-12', 0, 'Sent'),
('R_000029', 'SA_000023', 8, 'Zuri', 'Zuri', 'zuri@gmail.com', '2025-09-13', 'Dry', 'iiiii', ' Chemical Peel, Botox Wrinkle Treatment', 'aaa', 'aa', '0000-00-00', 0, 'Pending'),
('R_000030', 'SA_000026', 8, 'Zuri', 'Zuri', 'zuri@gmail.com', '2025-09-13', 'Dry', 'hhh', 'Anti-Aging Glow Booster, Glow Boost Facial', 'hhj', 'jj', NULL, 0, 'Sent'),
('R_000031', 'SA_000027', 8, 'Zuri', 'Zuri', 'zuri@gmail.com', '2025-09-13', 'Combination', 'sss', ' Chemical Peel, Anti-Aging Glow Booster', 'sss', 'sss', NULL, 0, 'Sent'),
('R_000032', 'SA_000028', 8, 'Zuri', 'Zuri', 'zuri@gmail.com', '2025-10-21', 'Dry', 'Visible acne scars and enlarged pores.', 'LED Light Therapy, Microneedling', 'Niacinamide serum, Salicylic acid cleanser', 'Avoid oily food and drink more water daily.', '2025-10-07', 0, 'Pending'),
('R_000034', 'SA_000030', 8, 'Zuri', 'Zuri', 'zuri@gmail.com', '2025-10-21', 'Oily', 'Uneven skin tone and mild pigmentation.', ' Chemical Peel, LED Light Therapy', 'Vitamin C, Kojic acid', 'Use sunscreen daily and limit sun exposure.', NULL, 1, 'Sent'),
('R_000035', 'SA_000031', 8, 'Zuri', 'Zuri', 'zuri@gmail.com', '2025-10-21', 'Sensitive', 'Redness and dryness after cleansing.', 'Glow Boost Facial, Microdermabrasion', 'Aloe vera gel, Ceramide moisturizer', 'Avoid harsh scrubs and alcohol-based products.', NULL, 1, 'Sent'),
('R_000036', 'SA_000032', 8, 'Zuri', 'Zuri', 'zuri@gmail.com', '2025-10-21', 'Oily', 'Acne breakouts on cheeks and forehead.', '', '', '', NULL, 1, 'Sent'),
('R_000037', 'SA_000033', 8, 'Zuri', 'Zuri', 'zuri@gmail.com', '2025-10-21', 'Dry', 'Acne breakouts on cheeks and forehead.', '', '', '', NULL, 1, 'Sent'),
('R_000038', 'SA_000034', 8, 'Zuri', 'Zuri', 'zuri@gmail.com', '2025-10-21', 'Normal', 'Slight dullness due to sun exposure.', 'Glow Boost Facial', 'Vitamin E, SPF 50', 'Wear sunscreen daily and eat fruits rich in antioxidants.', NULL, 1, 'Sent'),
('R_000039', 'SA_000035', 8, 'Zuri', 'Zuri', 'zuri@gmail.com', '2025-10-21', 'Combination', 'Blackheads and rough texture on nose area.', ' Chemical Peel, Microdermabrasion', 'BHA exfoliant, Niacinamide', 'Exfoliate twice weekly and avoid junk food.', '2025-10-31', 1, 'Sent'),
('R_000040', 'SA_000036', 8, 'Zuri', 'Zuri', 'zuri@gmail.com', '2025-10-21', 'Oily', 'Acne marks and occasional cystic pimples.', ' Chemical Peel, PRP Therapy', 'Azelaic acid, Tea tree oil', 'Avoid dairy and stress.', NULL, 0, 'Sent'),
('R_000041', 'SA_000037', 8, 'Zuri', 'Zuri', 'zuri@gmail.com', '2025-10-21', 'Dry', 'Tightness and rough skin surface.', 'Anti-Aging Glow Booster', 'Hyaluronic acid, Squalane oil', 'Apply moisturizer twice daily.', NULL, 1, 'Sent'),
('R_000042', 'SA_000029', 8, 'Zuri', 'Zuri', 'zuri@gmail.com', '2025-11-25', 'Oily', 'Skin also shows early signs of dehydration despite excess oil production.', ' Chemical Peel, Anti-Aging Glow Booster, Cryolipolysis (Fat Freezing)', 'Salicylic Acid cleanser\r\n\r\nNiacinamide serum\r\n\r\nLightweight gel moisturizer\r\n\r\nSunscreen SPF 50 (oil-free)', 'Reduce consumption of oily and sugary foods, increase daily water intake, and maintain a consistent skincare routine morning and night. Change pillowcases regularly and avoid touching the face throughout the day.', NULL, 1, 'Sent'),
('R_000043', 'SA_000040', 8, 'Zuri', 'Zuri', 'zuri@gmail.com', '2025-11-26', 'Combination', 'jjjjck', ' Chemical Peel, Cryolipolysis (Fat Freezing)', 'jajj', 'ajj', NULL, 0, 'Pending'),
('R_000044', 'SA_000041', 8, 'Zuri', 'Zuri', 'zuri@gmail.com', '2025-11-26', 'Oily', 'bbn', ' Chemical Peel, Botox Wrinkle Treatment', 'jjj', 'jj', NULL, 0, 'Pending'),
('R_000045', 'SA_000050', 8, 'Zuri', 'Zuri', 'zuri@gmail.com', '2025-12-03', 'Oily', 'this is onservs', 'Acne Clearing Treatment', 'toner', 'to avoid oily foods', NULL, 0, 'Sent'),
('R_000046', 'SA_000052', 8, 'Zuri', 'Zuri', 'zuri@gmail.com', '2025-12-04', 'Oily', 'to reduce fat', 'Acne Clearing Treatment, Cryolipolysis (Fat Freezing)', 'toner', 'to avoid oily foods', NULL, 0, 'Sent'),
('R_000047', 'SA_000053', 8, 'Zuri', 'Zuri', 'zuri@gmail.com', '2025-12-04', 'Oily', 'to reduce fat', 'Glow Boost Facial, Hydrating Facial', 'Toner', 'to avoid oily foods', NULL, 0, 'Sent'),
('R_000048', 'SA_000054', 8, 'Zuri', 'Zuri', 'zuri@gmail.com', '2025-12-11', 'Oily', 'yy', 'Botox Wrinkle Treatment', 'toner', 'to reduce fat', NULL, 1, 'Sent');

-- --------------------------------------------------------

--
-- Table structure for table `skinassessment`
--

CREATE TABLE `skinassessment` (
  `AssessmentCode` varchar(30) NOT NULL,
  `PatientID` int(11) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `PhoneNumber` varchar(30) NOT NULL,
  `DateOfBirth` date NOT NULL,
  `Gender` varchar(30) NOT NULL,
  `AssessmentDate` date NOT NULL,
  `Allergies` varchar(255) NOT NULL,
  `SkincareRoutine` text NOT NULL,
  `SkincareCost` varchar(50) NOT NULL,
  `SkinPhoto` varchar(255) NOT NULL,
  `SkinConcern` varchar(50) NOT NULL,
  `SkinCondition` text NOT NULL,
  `Status` varchar(30) NOT NULL,
  `IsNotified` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `skinassessment`
--

INSERT INTO `skinassessment` (`AssessmentCode`, `PatientID`, `Name`, `Email`, `PhoneNumber`, `DateOfBirth`, `Gender`, `AssessmentDate`, `Allergies`, `SkincareRoutine`, `SkincareCost`, `SkinPhoto`, `SkinConcern`, `SkinCondition`, `Status`, `IsNotified`) VALUES
('', 4, 'admin', 'admin@gmail.com', '09984758698', '2025-06-03', 'Female', '2025-06-25', 'nothing', 'three times in a day', '30000 Kyats', ' UploadedImage/_image.jpg', 'Oiliness', 'Just normal', 'Active', 1),
('SA_000001', 4, 'admin', 'admin@gmail.com', '09984758698', '2025-06-09', 'Male', '2025-06-25', 'nothing', 'three times in a day', '30000 Kyats', ' UploadedImage/_Hydrating-Facial-1.jpg', 'Oiliness', 'Just normal', 'Active', 1),
('SA_000002', 5, 'Ntns', 'ntns@gmail.com', '09975647387', '2003-02-24', 'Female', '2025-06-25', 'nothing', 'three times in a day', '30000 Kyats', ' UploadedImage/_image.png', 'Oiliness', 'aystey', 'Active', 0),
('SA_000003', 5, 'Ntns', 'ntns@gmail.com', '09975647387', '2025-07-08', 'Female', '2025-07-06', 'jj', 'jjj', 'jjj', ' UploadedImage/_Receptionist.jpg', 'Oiliness', 'hhhjhk', 'Active', 0),
('SA_000004', 5, 'Ntns', 'ntns@gmail.com', '09975647387', '2025-07-01', 'Female', '2025-07-06', 'nothing', 'three times in a day', '30000 Kyats', ' UploadedImage/_calendar-date-date-notes-business-office-event-icon-template-black-color-editable-calendar-date-symbol-flat-illustration-for-graphic-and-web-design-free-vector.jpg', 'Dark eye circles', 'jjj', 'Active', 0),
('SA_000005', 5, 'Ntns', 'ntns@gmail.com', '09975647387', '2025-07-07', 'Female', '2025-07-06', 'hhh', 'jjj', '30000 Kyats', ' UploadedImage/_portrait-beauty-smiling-asian-woman-600nw-1997741045.webp', 'Oiliness, Dark eye circles, Wrinkles', 'nn', 'Active', 0),
('SA_000007', 5, 'Ntns', 'ntns@gmail.com', '09975647387', '2025-07-10', 'Female', '2025-07-09', 'jj', 'three times in a day', '30000 Kyats', ' UploadedImage/_np3.jpg', 'Rough Skin', 'gghh', 'Active', 0),
('SA_000008', 5, 'Ntns', 'ntns@gmail.com', '09975647387', '2025-07-10', 'Female', '2025-07-09', 'nothing', 'three times in a day', 'aa', ' UploadedImage/_profile3.png', 'Oiliness', 'sss', 'Active', 0),
('SA_000009', 5, 'Ntns', 'ntns@gmail.com', '09975647387', '2025-07-10', 'Female', '2025-07-09', 'sss', 'ss', '30000 Kyats', ' UploadedImage/_Mohinga.webp', 'Oiliness, Dark eye circles', 'www', 'Active', 0),
('SA_000010', 4, 'admin', 'admin@gmail.com', '09984758698', '2025-07-11', 'Female', '2025-07-09', 'nothing', 'as', 'aj', ' UploadedImage/_viber_image_2024-10-02_20-55-12-983.jpg', 'Oiliness, Dark eye circles', 'ajjs', 'Active', 1),
('SA_000011', 4, 'admin', 'admin@gmail.com', '09984758698', '2025-07-10', 'Female', '2025-07-09', 'n', 'j', 'jj', ' UploadedImage/_chocolatecakes.jpg', 'Rough Skin', 'h', 'Active', 1),
('SA_000012', 4, 'admin', 'admin@gmail.com', '09984758698', '2025-07-10', 'Female', '2025-07-10', 's', 's', 's', ' UploadedImage/_Maintaining-Your-Restaurants-Exterior.webp', 'Dryness, Redness, Dehydration', 's', 'Active', 1),
('SA_000013', 5, 'Ntns', 'ntns@gmail.com', '09975647387', '2025-07-11', 'Female', '2025-07-09', 'j', 'jjj', 'hhh', ' UploadedImage/_bagan1.jpg', 'Oiliness, Dark eye circles', 'hhh', 'Active', 0),
('SA_000014', 5, 'Ntns', 'ntns@gmail.com', '09975647387', '2025-08-01', 'Female', '2025-08-01', 'jj', 'three times in a day', '30000 Kyats', ' UploadedImage/_model10.jpg', 'Oiliness', 'hhh', 'Active', 0),
('SA_000015', 5, 'Ntns', 'ntns@gmail.com', '09975647387', '2025-08-02', 'Female', '2025-08-01', 'hhh', 'jj', '30000 Kyats', ' UploadedImage/_Ella.webp', 'Sun damage', 'jjj', 'Active', 0),
('SA_000016', 5, 'Ntns', 'ntns@gmail.com', '09975647387', '2025-08-09', 'Female', '2025-08-01', 'nothing', 'j', 'jj', ' UploadedImage/_Aurora.avif', 'Dryness', 'hhh', 'Active', 0),
('SA_000017', 5, 'Ntns', 'ntns@gmail.com', '09975647387', '2025-08-02', 'Female', '2025-08-02', 'nothing', 'three times in a day', '30000 Kyats', ' UploadedImage/_23b179e1142628214ae828b1bd2fed8b.jpg', 'Sun damage', 'hhh', 'Active', 0),
('SA_000018', 5, 'Ntns', 'ntns@gmail.com', '09975647387', '2025-08-09', 'Female', '2025-08-02', 'qq', 'qq', 'qq', ' UploadedImage/_23b179e1142628214ae828b1bd2fed8b.jpg', 'Oiliness', 'ww', 'Active', 0),
('SA_000019', 5, 'Ntns', 'ntns@gmail.com', '09975647387', '2025-08-12', 'Female', '2025-08-02', 'hhh', 'jjj', '30000 Kyats', ' UploadedImage/_bg2.jpg', 'Sun damage', 'zzzz', 'Active', 0),
('SA_000020', 5, 'Ntns', 'ntns@gmail.com', '09975647387', '2025-08-02', 'Female', '2025-08-02', 'nothing', 'three times in a day', 'jj', ' UploadedImage/_bg1.jpg', 'Oiliness', 'jj', 'Active', 0),
('SA_000021', 5, 'Ntns', 'ntns@gmail.com', '09975647387', '2025-08-03', 'Female', '2025-08-03', 'nothing', 'three times in a day', 'jj', ' UploadedImage/_360_F_301725410_B1xr99nz7O3qyO3OYpUUz8FdJ72WTw8V (1).jpg', 'Dryness', 'wwwk', 'Active', 0),
('SA_000022', 5, 'Ntns', 'ntns@gmail.com', '09975647387', '2025-08-07', 'Female', '2025-08-08', 'nothing', 'three times in a day', 'jj', ' UploadedImage/_23b179e1142628214ae828b1bd2fed8b.jpg', 'Dark eye circles', 'jjj', 'Active', 0),
('SA_000023', 5, 'Ntns', 'ntns@gmail.com', '09975647387', '2025-09-12', 'Female', '2025-09-12', 'nothing', 'three times in a day', '30000 Kyats', ' UploadedImage/_Charlie-Puth-Singer-Download-Free-PNG.png', 'Rough Skin, Oiliness', 'skin condition', 'Active', 0),
('SA_000024', 5, 'Ntns', 'ntns@gmail.com', '09975647387', '2025-09-12', 'Female', '2025-09-12', 'wwww', 'www', '1222', ' UploadedImage/_5bbe514dd733c24cf53b26dcc5b61d30.jpg', 'Rough Skin, Oiliness', '222', 'Active', 0),
('SA_000025', 5, 'Ntns', 'ntns@gmail.com', '09975647387', '2025-09-12', 'Male', '2025-09-12', 'nothing', 'three times in a day', '30000 Kyats', ' UploadedImage/_360_F_301725410_B1xr99nz7O3qyO3OYpUUz8FdJ72WTw8V (1).jpg', 'Rough Skin, Oiliness, Dryness', 'hhhh', 'Active', 0),
('SA_000027', 6, 'Di Di', 'di@gmail.com', '09978678878', '2025-09-14', 'Female', '2025-09-13', 'nothing', 'wwj', 'www', ' UploadedImage/_Screenshot 2024-12-17 154150.png', 'Rough Skin, Oiliness', 'ww', 'Active', 1),
('SA_000028', 9, 'Lydia', 'Lydia@gmail.com', '09975647387', '2000-02-11', 'Female', '2025-10-13', 'None', 'Cleanser, toner, moisturizer, sunscreen', '60000', ' UploadedImage/_badskingril1.jpg', 'Dryness, Dehydration', 'Normal to dry', 'Active', 1),
('SA_000029', 7, 'Thomas', 'thomas@gmail.com', '099837388', '2000-05-15', 'Male', '2025-10-13', 'Fragrance in products', 'Face wash and moisturizer', '350000', ' UploadedImage/_badskinboy1.jpg', 'Oiliness', 'Oily', 'Active', 1),
('SA_000030', 8, 'Irene', 'Irene@gmail.com', '0998376789', '1999-04-24', 'Female', '2025-10-13', 'None', 'Cleanser, serum, moisturizer', '150000', ' UploadedImage/_badskingirl2.jpg', 'Redness, Acne', 'Combination', 'Active', 1),
('SA_000031', 8, 'Irene', 'Irene@gmail.com', '0998376789', '2000-09-30', 'Female', '2025-10-13', 'None', 'Cleanser, serum, moisturizer', '300000 Kyats', 'UploadedImage/_badskingirl2.jpg', 'Redness, Acne', 'Combination', 'Active', 1),
('SA_000032', 8, 'Irene', 'Irene@gmail.com', '0998376789', '2000-09-30', 'Female', '2025-10-13', 'None', 'Cleanser, serum, moisturizer', '150000', ' UploadedImage/_badskingirl2.jpg', 'Redness, Acne', 'Combination', 'Active', 1),
('SA_000033', 8, 'Irene', 'Irene@gmail.com', '0998376789', '1999-10-08', 'Female', '2025-10-13', 'None', 'Cleanser, serum, moisturizer', '30000 ', ' UploadedImage/_badskingirl2.jpg', 'Redness, Acne', 'Combination', 'Active', 1),
('SA_000034', 8, 'Irene', 'Irene@gmail.com', '0998376789', '2000-10-21', 'Female', '2025-10-13', 'nothing', 'three times in a day', 'jj', ' UploadedImage/_23b179e1142628214ae828b1bd2fed8b.jpg', 'Rough Skin', 'hhh', 'Active', 1),
('SA_000035', 12, 'Chloe', 'Chloe@123', '0998748578', '2000-08-06', 'Female', '2025-10-13', 'None', 'Cleanser, exfoliator, moisturizer', '200000', ' UploadedImage/_badskingirl3.jpg', 'Dryness, Wrinkles', 'Dry', 'Active', 1),
('SA_000036', 10, 'Henry', 'Henry@gmail.com', '09975647387', '2001-09-04', 'Male', '2025-10-13', '', 'Cleanser and toner', '200000', ' UploadedImage/_badskinboy2.jpg', 'Rough Skin, Wrinkles', 'Oily', 'Active', 1),
('SA_000037', 13, 'Elara', 'Elara@gmail.com', '099897869', '2000-05-15', 'Female', '2025-10-14', 'None', 'Cleanser, serum, moisturizer', '200000', ' UploadedImage/_badskingirl4.jpg', 'Rough Skin, Oiliness', 'Oily', 'Active', 1),
('SA_000038', 7, 'Thomas', 'thomas@gmail.com', '099837388', '2000-10-21', 'Male', '2025-10-21', 'nothing', 'Cleanser, serum, moisturizer', '30000 Kyats', ' UploadedImage/_badskinboy3.jpg', 'Sun damage, Dark eye circles', 'Nothing', 'Active', 1),
('SA_000039', 15, 'Iris', 'Iris123@gmail.com', '09986789584', '2001-10-08', 'Female', '2025-10-30', 'nothing', 'three times in a day', '200000', ' UploadedImage/_image4-2-800x576.jpg', 'Sun damage, Dark eye circles', 'Nothing', 'Active', 1),
('SA_000040', 5, 'Nant Theint', 'ntns@gmail.com', '09975647387', '2025-11-01', 'Female', '2025-11-01', 'None', 'three times in a day', '30000 Kyats', ' UploadedImage/_badskinboy3.jpg', 'Sun damage, Dark eye circles', 'Rough Skin', 'Active', 0),
('SA_000041', 5, 'Nant Theint', 'ntns@gmail.com', '09975647387', '2025-11-27', 'Female', '2025-11-25', 'nothing', 'three times in a day', '30000 Kyats', ' UploadedImage/_hair_oil_treaatment.jpg', 'Sun damage', 'Oliy', 'Active', 0),
('SA_000042', 5, 'Nant Theint', 'ntns@gmail.com', '09975647387', '2025-11-12', 'Female', '2025-11-26', 'nothing', 'three times in a day', '200000', ' UploadedImage/_trail.jpg', 'Redness', 'kkkdk', 'Confirmed', 0),
('SA_000043', 5, 'Nant Theint', 'ntns@gmail.com', '09975647387', '1999-06-09', 'Female', '2025-11-27', 'None', 'Cleanser, toner, moisturizer', '200000', ' UploadedImage/_gbadskin1.jpg', 'Oiliness, Acne', 'Oily T-zone with occasional acne breakouts', 'Active', 0),
('SA_000044', 6, 'Di Di', 'di@gmail.com', '09978678878', '2000-06-14', 'Female', '2025-11-27', 'Fragrance products', 'Minimal skincare', '200000', ' UploadedImage/_gbadskin1.jpg', 'Rough Skin, Redness', 'Sensitive skin with redness', 'Confirmed', 1),
('SA_000045', 5, 'Nant Theint', 'ntns@gmail.com', '09975647387', '2025-10-29', 'Female', '2025-11-27', 'None', 'Cleanser, serum, moisturizer', '200000', ' UploadedImage/_gbadskin2.jpg', 'Dark eye circles, Redness', 'skin redness', 'Active', 0),
('SA_000046', 5, 'Nant Theint', 'ntns@gmail.com', '09975647387', '2025-11-12', 'Female', '2025-11-27', 'None', 'Cleanser, serum, moisturizer', '200000', ' UploadedImage/_gbadskin3.webp', 'Oiliness, Redness', 'Skin Redness', 'Active', 0),
('SA_000047', 5, 'Nant Theint ', 'ntns@gmail.com', '09975647387', '2025-11-14', 'Female', '2025-11-27', 'nothing', 'three times in a day', '200000', ' UploadedImage/_gbadskin3.webp', 'Redness, Acne', 'Skin Redness', 'Active', 0),
('SA_000048', 5, 'Nant Theint ', 'ntns@gmail.com', '09975647387', '2025-12-04', 'Female', '2025-12-03', 'None', 'Cleanser, serum, moisturizer', '200000', ' UploadedImage/_Acne_1.webp', 'Oiliness', 'Normal situation ', 'Active', 0),
('SA_000049', 5, 'Nant Theint ', 'ntns@gmail.com', '09975647387', '2025-12-10', 'Female', '2025-12-03', 'None', 'Cleanser, serum, moisturizer', '200000', ' UploadedImage/_Acne_1.webp', 'Oiliness', 'It is just a normal', 'Active', 0),
('SA_000050', 5, 'Nant Theint Nadi Soe', 'ntns@gmail.com', '09975647387', '2025-12-17', 'Female', '2025-12-03', 'nothing', 'three times in a day', '200000', ' UploadedImage/_Acne_1.webp', 'Oiliness', 'noramla', 'Active', 0),
('SA_000051', 5, 'Nant Theint ', 'ntns@gmail.com', '09975647387', '2025-12-03', 'Female', '2025-12-04', 'None', 'Cleanser, serum, moisturizer', '200000', ' UploadedImage/_Acne_1.webp', 'Oiliness', 'Oiliness', 'Active', 0),
('SA_000052', 5, 'Nant Theint ', 'ntns@gmail.com', '09975647387', '2025-12-04', 'Female', '2025-12-04', 'None', 'Cleanser, serum, moisturizer', '200000', ' UploadedImage/_Acne_1.webp', 'Oiliness', 'Oiliness', 'Active', 0),
('SA_000053', 5, 'Nant Theint Nadi Soe', 'ntns@gmail.com', '09975647387', '2025-12-16', 'Female', '2025-12-04', 'None', 'Cleanser, serum, moisturizer', '200000', ' UploadedImage/_gbadskin3.webp', 'Oiliness', 'Oiliness', 'Active', 0),
('SA_000054', 5, 'Nant Theint ', 'ntns@gmail.com', '09975647387', '2025-12-16', 'Female', '2025-12-04', 'None', 'Cleanser, serum, moisturizer', '200000', ' UploadedImage/_gbadskin3.webp', 'Oiliness', 'Oiliness', 'Active', 0);

-- --------------------------------------------------------

--
-- Table structure for table `staffregister`
--

CREATE TABLE `staffregister` (
  `StaffID` int(11) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `ProfileImage` varchar(255) NOT NULL,
  `UserName` varchar(50) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `PhoneNumber` varchar(50) NOT NULL,
  `DateOfBirth` date NOT NULL,
  `Position` varchar(50) NOT NULL,
  `Experience` varchar(100) NOT NULL,
  `Qualification` varchar(100) NOT NULL,
  `Address` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staffregister`
--

INSERT INTO `staffregister` (`StaffID`, `Name`, `ProfileImage`, `UserName`, `Email`, `Password`, `PhoneNumber`, `DateOfBirth`, `Position`, `Experience`, `Qualification`, `Address`) VALUES
(1, 'Admin', '', 'Admin', 'admin@gmail.com', '$2y$10$GERv9B1RDGTSLBPZ89JQMuFVvjvaemd17p9tZp5pCJm4JEaS9ElVe', '09937483767', '2000-01-05', 'Admin', '5 years', 'Bachelor of Health Science', 'Yangon'),
(8, 'Zuri', 'UploadedImage/_Zuri.avif', 'Zuri', 'zuri@gmail.com', '$2y$10$eIeJKrlTaRj5XIPzkrPHgeLtk0TW789R.SmufgBNGurBU49IQDjRW', '099768756789', '2003-02-25', 'Aesthetic Doctor', '12 years', 'MBBS, Diploma in Aesthetic Medicine', 'No. 15, Baho Road, Sanchaung, Yangon'),
(9, 'Eve', 'UploadedImage/_Eve.avif', 'Eve', 'eve@gmail.com', '$2y$10$hX9hOb/0heObPCJEOiAqfebr3UPmpg1jrJEhDnqD0nZgPuZDjUds6', '09984758698', '2000-01-20', 'Nurse', '5 years', 'Certified Aesthetician, Diploma in Skincare Therapy', 'Yangon'),
(10, 'Ella', 'UploadedImage/_Ella.webp', 'Ella', 'ella@gmail.com', '$2y$10$N15vyX44uAAr/EC04GamqOcVuAXaRS8VJMww1z1igxpG./hJuh4JW', '097896789', '2000-10-12', 'Receptionist', '18 years', 'MBBS, MMED (Dermatology)', 'Kabar Aye Pagoda Road, Yangon'),
(11, 'Aurora', 'UploadedImage/_Aurora.avif', 'Aurora', 'aurora@gmail.com', '$2y$10$BdjCDwWcjsD2qQsgO3gNnOoTfUCyobCe/gOkqCpALKptPvZ2RSNiu', '0989878989', '1999-03-12', 'Aesthetic Doctor', '12 years', 'MBBS, Diploma in Aesthetic Medicine', 'Sanchaung, Yangon'),
(12, 'Felix', 'UploadedImage/_doctor5.jpg', 'Felix', 'felix@gmail.com', '$2y$10$vxKXyPj9ChRgs8OsarLT.O7m5PciWnBqI3FDOv5zSDZj7YhaQSxNa', '09975647387', '1999-05-23', 'Aesthetic Doctor', 'M.B., B.S., Diploma in Dermatology (Singapore)', '5 years in laser and skin rejuvenation', 'No. 45, Kamayut Township, Yangon'),
(14, 'Daniel Smith', 'UploadedImage/_maledoctor1.jpg', 'daniel_smith', 'danielsmith@gmail.com', '$2y$10$Wr7IPzUTMTSGs1wiR23k2OnugnNiMuuGjxxzuAoZNBuksaHU0NH16', '09756231478', '1987-06-20', 'Aesthetic Doctor', '10 years', 'MD in Dermatology', '12 Lake View Road, Mandalay'),
(15, 'Ethan Williams', 'UploadedImage/_doctor4.jpg', 'Ethan', 'ethan@gmail.com', '$2y$10$ovObNsOCkiGRP883VY7PS.Emxa3kJMpJT60nfO6m1hSDK0UoD6UIC', '09587451236', '2000-02-20', 'Aesthetic Doctor', '4 years', 'MBBS, Diploma in Aesthetic Medicine', '23 River Street, Naypyitaw'),
(16, 'Noe Noe', 'UploadedImage/_doctor2.jpg', 'Noe Noe', 'noe123@gmail.com', '$2y$10$ti0IjEllcHRsvL14HG0gVe/o9jGadqSgoKAuGvZYdNHuuZg3cpNYu', '09984758698', '1999-10-16', 'Aesthetic Doctor', '5 years in facial rejuvenation', 'M.B., B.S., Certificate in Cosmetic Skin Care (Singapore)', 'No. 4, Kyimyindaing Township, Yangon'),
(17, 'Yuri', 'UploadedImage/_doctor8.webp', 'Yuri', 'Yuri@gmail.com', '$2y$10$OndD0GLs3gQypVGoVtAeUuYfTsvFRRe.1VMqbXNoKOm39H.rY0gdO', '09975647387', '1999-06-10', 'Aesthetic Doctor', '4 years in laser and whitening', 'M.B., B.S., Diploma in Skin Aesthetic (Korea)', 'No. 2, Ahlone Township, Yangon'),
(18, 'Emily Jason ', 'UploadedImage/_emily.jpeg', 'Emily ', 'Emily@gmail.com', '$2y$10$XEuy57ftpYst6gb18pixC.5BNJj3Fi.mGfEoBQm/ac3ppZuESZXSu', '0998989890', '1998-06-17', 'Aesthetic Doctor', '6 years in skincare assistance and treatment support', 'B.N.Sc (University of Nursing, Yangon)', 'No. 5, Kyimyindaing Township, Yangon');

-- --------------------------------------------------------

--
-- Table structure for table `treatment`
--

CREATE TABLE `treatment` (
  `TreatmentCode` varchar(30) NOT NULL,
  `TreatmentName` varchar(100) NOT NULL,
  `Category` varchar(50) NOT NULL,
  `CreatedDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `ModifiedDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `TreatmentImage` varchar(255) NOT NULL,
  `Price` int(11) NOT NULL,
  `Duration` varchar(50) NOT NULL,
  `Descriptions` text NOT NULL,
  `Sessions` int(11) NOT NULL,
  `RecoveryTime` varchar(50) NOT NULL,
  `DurationOfEffect` varchar(50) NOT NULL,
  `Discount` int(11) NOT NULL,
  `Prerequisites` text NOT NULL,
  `Contraindications` text NOT NULL,
  `AftercareInstructions` text NOT NULL,
  `ExpectedResults` text NOT NULL,
  `SideEffects` text NOT NULL,
  `Status` varchar(30) NOT NULL,
  `IsNotified` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `treatment`
--

INSERT INTO `treatment` (`TreatmentCode`, `TreatmentName`, `Category`, `CreatedDate`, `ModifiedDate`, `TreatmentImage`, `Price`, `Duration`, `Descriptions`, `Sessions`, `RecoveryTime`, `DurationOfEffect`, `Discount`, `Prerequisites`, `Contraindications`, `AftercareInstructions`, `ExpectedResults`, `SideEffects`, `Status`, `IsNotified`) VALUES
('', 'Glow Boost Facial', '', '2025-06-26 15:46:49', '2025-06-26 15:46:49', 'UploadedImage/_GlowBoostFacial.webp', 25000, '45 minutes', 'This hydrating facial deeply nourishes and revitalizes the skin, giving you an instant radiant glow. Ideal for dry and tired skin.', 0, '', '', 0, '', '', '', '', '', 'Active', 1),
('Tr_000001', 'Anti-Aging Glow Booster', 'Anti-Aging', '2025-06-26 10:15:05', '2025-06-26 10:15:05', 'UploadedImage/_Anti-AgingGlowBooste.webp', 50000, '45 minutes', 'This treatment reduces wrinkles and fine lines using advanced techniques.', 3, '2 days', '4 months', 15, 'Skin must be clean before treatment.\r\n\r\n', 'Not suitable for pregnant women or those with allergies.', 'Avoid sunlight for 48 hours after treatment.', 'Skin appears brighter, firmer, and more youthful.', 'Temporary redness or swelling may occur.', 'Active', 1),
('Tr_000002', 'Botox Wrinkle Treatment', 'Injectables', '2025-06-26 22:23:13', '2025-06-26 22:23:13', 'UploadedImage/_BotoxWrinkleTreatment.jpg', 120000, '30 minutes', 'A non-surgical cosmetic procedure to reduce facial wrinkles.', 1, '1 day', '3-4 months', 0, 'No recent infections', 'Pregnancy, Neurological conditions', 'Avoid touching or massaging the area for 24 hours', 'Smoother skin, reduced wrinkles', 'Minor swelling or redness', 'Active', 1),
('Tr_000003', 'Laser Hair Removal', 'Laser Treatments', '2025-06-26 22:33:35', '2025-06-26 22:33:35', 'UploadedImage/_LaserHairRemoval.webp', 500, '1 hour', 'Laser hair removal uses concentrated light to target and destroy hair follicles.', 6, 'None', 'Permanent hair reduction', 15, 'Shave the area before treatment.', 'Sunburn, active infections', 'Avoid sun exposure for 2 weeks.', 'Smooth, hair-free skin.', 'Redness, slight discomfort.', 'Active', 1),
('Tr_000004', ' Chemical Peel', 'Peels & Exfoliation', '2025-06-26 22:42:28', '2025-06-26 22:42:28', 'UploadedImage/_ChemicalPeel.webp', 150, ' 45 minutes', 'A chemical peel removes dead skin cells to reveal smoother, brighter skin underneath.', 3, '3 days', '6 months', 5, 'Avoid retinoids for 1 week prior.', 'Active acne, eczema', 'Use gentle cleansers and moisturizers.', 'Improved skin texture and tone.', 'Peeling, redness.', 'Active', 1),
('Tr_000005', 'Microneedling', 'Skin Rejuvenation', '2025-06-27 02:31:54', '2025-06-27 02:31:54', 'UploadedImage/_microneedling1.jpg', 250000, '1 hour', 'Microneedling stimulates collagen production by creating tiny micro-injuries in the skin.', 4, '2 days', '6 months', 0, 'Avoid blood thinners for 48 hours.', 'Active infections, keloid scarring', 'Keep the area moisturized and avoid sun exposure.', 'Firmer, smoother skin with reduced scars.', 'Redness, swelling.', 'Active', 1),
('Tr_000006', 'PRP Therapy', 'Hair Restoration', '2025-06-27 02:50:44', '2025-06-27 02:50:44', 'UploadedImage/_prp-injections.jpg', 400000, '1 hour', 'PRP therapy uses the patient own blood to promote hair growth by injecting platelets into the scalp.', 3, 'None', '12 months', 0, 'No blood thinners for 48 hours.', 'Blood disorders, active infections', 'Avoid washing hair for 24 hours.', 'Thicker, healthier hair growth.\r\n', 'Mild swelling, tenderness.', 'Active', 1),
('Tr_000007', 'Hyaluronic Acid Filler', 'Anti-Aging', '2025-06-27 03:01:49', '2025-06-27 03:01:49', 'UploadedImage/_Hyaluronic-Acid-Fillers.jpg', 350000, '30 minutes', 'Hyaluronic acid fillers add volume to the skin, enhancing facial contours and reducing signs of aging.', 1, '1 day', '6-12 months', 10, 'None', 'Allergies to hyaluronic acid', 'Avoid alcohol and strenuous exercise for 24 hours.', 'Plumper lips and reduced wrinkles.', 'Swelling, bruising.', 'Active', 1),
('Tr_000008', 'LED Light Therapy', 'Facial Treatments', '2025-06-27 03:07:16', '2025-06-27 03:07:16', 'UploadedImage/_LEDLightTherapy.jpg', 100000, '30 minutes', 'LED light therapy uses different wavelengths of light to treat various skin concerns, including acne and aging.', 5, 'None', 'Varies', 15, 'None', 'Light sensitivity', 'Use sunscreen after treatment.', 'Improved skin tone and texture.', 'Mild redness.', 'Active', 1),
('Tr_000009', 'Sclerotherapy', 'Body Contouring', '2025-06-29 22:20:28', '2025-06-29 22:20:28', 'UploadedImage/_SclerotherapyTreatment.webp', 200000, '45 minutes', 'Sclerotherapy involves injecting a solution into varicose veins to collapse and fade them.', 2, '1 week', 'Permanent', 10, 'None', 'Pregnancy, blood clotting disorders', 'Wear compression stockings for a week.', 'Reduced appearance of spider veins.', 'Bruising, swelling.', 'Active', 1),
('Tr_000010', 'Microdermabrasion', 'Skin Rejuvenation', '2025-06-29 22:34:23', '2025-06-29 22:34:23', 'UploadedImage/_Microdermabrasion.jpg', 120000, '30 minutes', 'Microdermabrasion exfoliates the skin to remove dead skin cells and promote new cell growth.', 4, 'None', '1-2 months', 5, 'None', 'Active acne, rosacea', 'Use gentle skincare products post-treatment.', 'Smoother skin texture and reduced fine lines.', 'Mild redness, sensitivity.', 'Active', 1),
('Tr_000011', 'Kybella', 'Body Contouring', '2025-06-29 22:43:04', '2025-09-19 10:43:26', 'UploadedImage/_Kybella.webp', 400000, '30 minutes', 'Kybella is an injectable treatment that destroys fat cells under the chin to improve the profile.', 2, '1 week', 'Permanent', 0, 'None', 'Infection at the injection site', 'Avoid strenuous activity for 24 hours.', 'Reduced double chin appearance.', 'Swelling, bruising.', 'Active', 1),
('Tr_000012', 'Ultrasonic Cavitation', 'Body Contouring', '2025-10-19 07:56:49', '2025-10-30 07:33:32', 'UploadedImage/_laser-lipolysis.png', 60000, '40 minutes', 'Breaks down fat cells using ultrasound waves for a slimmer look.', 5, 'None', '2–4 months', 0, 'Drink at least 1L of water before the session.', 'Kidney or liver disease, pregnancy.\r\n', 'Drink water and do light exercise.', 'Reduced fat and cellulite appearance.', 'Mild warmth or ringing sensation in ears.', 'Active', 1),
('Tr_000013', 'Cryolipolysis (Fat Freezing)', 'Body Contouring', '2025-10-19 08:43:23', '2025-10-30 07:32:46', 'UploadedImage/_Fat-Freezing-Applicator.jpg', 50000, '3–6 months', 'A non-invasive fat reduction procedure that freezes and eliminates stubborn fat cells.', 3, '1–2 days', '3–6 months', 10, 'Avoid heavy meals and alcohol before treatment.', 'Pregnancy, cold allergies, severe obesity.', 'Massage treated area; stay hydrated.', 'Reduction in fat layer thickness; improved body shape.', 'Temporary redness, numbness, or mild soreness.', 'Active', 1),
('Tr_000014', 'Hydrating Facial', 'Facial Treatments', '2025-10-30 23:05:46', '2025-10-31 03:09:14', 'UploadedImage/_hydrationfacials.jpeg', 70000, '40 minutes', 'Deep hydration facial for dry and dull skin.', 1, 'None', '1 week', 0, 'Cleanse face before appointment', 'Open wounds', 'Avoid makeup for 12 hours', 'Moisturized, glowing skin', 'None', 'Active', 1),
('Tr_000015', 'Lip Filler Enhancement', 'Injectables', '2025-10-30 23:13:21', '2025-10-30 23:13:21', 'UploadedImage/_lip-filler.webp', 200000, '30 mins', 'Enhances lip volume with hyaluronic acid fillers.', 0, '2 days', '6–9 months', 0, 'Avoid aspirin', 'Pregnancy', 'Avoid touching lips', 'Fuller, plumper lips', 'Swelling', 'Active', 1),
('Tr_000016', 'Acne Clearing Treatment updated', 'Acne Treatments', '2025-11-27 23:52:45', '2025-12-03 19:52:25', 'UploadedImage/_Acne_1.webp', 60000, '45 minutes', 'A therapeutic treatment targeting acne bacteria and inflammation.', 4, 'None', '1 month', 0, 'Stop acne creams 24 hrs before', 'Cystic acne flare-ups', 'Use oil-free products', 'Reduced inflammation and breakouts', 'Mild stinging', 'Active', 0);

-- --------------------------------------------------------

--
-- Table structure for table `treatmenttype`
--

CREATE TABLE `treatmenttype` (
  `TreatmentTypeID` int(11) NOT NULL,
  `TreatmentTypeName` varchar(100) NOT NULL,
  `TreatmentTypeImage` varchar(255) NOT NULL,
  `Descriptions` text NOT NULL,
  `Status` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `treatmenttype`
--

INSERT INTO `treatmenttype` (`TreatmentTypeID`, `TreatmentTypeName`, `TreatmentTypeImage`, `Descriptions`, `Status`) VALUES
(1, 'Hydrating Facial', 'UploadedImage/_HydratingFacial.jpg', ' A deep moisturizing treatment designed to restore skin hydration, improve elasticity, and leave the skin soft and glowing. ', 'Active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bill`
--
ALTER TABLE `bill`
  ADD PRIMARY KEY (`Bill_ID`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`ContactID`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`FeedbackID`);

--
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`InvoiceCode`);

--
-- Indexes for table `invoicedetail`
--
ALTER TABLE `invoicedetail`
  ADD PRIMARY KEY (`InvoiceDetailID`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`NotificationID`);

--
-- Indexes for table `patientregister`
--
ALTER TABLE `patientregister`
  ADD PRIMARY KEY (`PatientID`);

--
-- Indexes for table `staffregister`
--
ALTER TABLE `staffregister`
  ADD PRIMARY KEY (`StaffID`);

--
-- Indexes for table `treatmenttype`
--
ALTER TABLE `treatmenttype`
  ADD PRIMARY KEY (`TreatmentTypeID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bill`
--
ALTER TABLE `bill`
  MODIFY `Bill_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `ContactID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `FeedbackID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `invoicedetail`
--
ALTER TABLE `invoicedetail`
  MODIFY `InvoiceDetailID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `NotificationID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `patientregister`
--
ALTER TABLE `patientregister`
  MODIFY `PatientID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `staffregister`
--
ALTER TABLE `staffregister`
  MODIFY `StaffID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `treatmenttype`
--
ALTER TABLE `treatmenttype`
  MODIFY `TreatmentTypeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
