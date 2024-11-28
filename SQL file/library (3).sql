-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 26, 2024 at 07:14 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `library`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `FullName` varchar(100) DEFAULT NULL,
  `AdminEmail` varchar(120) DEFAULT NULL,
  `UserName` varchar(100) NOT NULL,
  `Password` varchar(100) NOT NULL,
  `updationDate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `FullName`, `AdminEmail`, `UserName`, `Password`, `updationDate`) VALUES
(1, 'Admin', 'admin@gmail.com', 'admin', '21232f297a57a5a743894a0e4a801fc3', '2024-11-21 00:33:35');

-- --------------------------------------------------------

--
-- Table structure for table `book_ratings`
--

CREATE TABLE `book_ratings` (
  `id` int(11) NOT NULL,
  `BookId` int(11) NOT NULL,
  `Rating` int(11) NOT NULL,
  `Review` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `book_ratings`
--

INSERT INTO `book_ratings` (`id`, `BookId`, `Rating`, `Review`) VALUES
(2, 11, 2, 'dsf'),
(4, 6, 2, 'hiii'),
(5, 1, 4, 'u76u'),
(6, 1, 4, 'u76u'),
(7, 7, 4, 'nice'),
(8, 10, 3, 'yahoo'),
(9, 11, 5, 'wopucetau'),
(10, 9, 4, 'good'),
(11, 12, 4, 'test'),
(12, 12, 5, 'I love this book so much'),
(13, 12, 5, 'good');

-- --------------------------------------------------------

--
-- Table structure for table `forum_replies`
--

CREATE TABLE `forum_replies` (
  `reply_id` int(11) NOT NULL,
  `thread_id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `reply_content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `forum_replies`
--

INSERT INTO `forum_replies` (`reply_id`, `thread_id`, `user_name`, `reply_content`, `created_at`) VALUES
(1, 2, 'sada', 'sfas', '2024-11-06 12:47:15'),
(2, 2, 'uji', 'tyu', '2024-11-06 18:37:16'),
(3, 5, 'aisyah', 'yow', '2024-11-07 07:25:25'),
(4, 6, 'sab', 'yow', '2024-11-09 13:48:36'),
(5, 6, 'dina', 'hiii', '2024-11-20 11:10:52'),
(6, 8, 'sab', 'hii', '2024-11-21 04:06:13');

-- --------------------------------------------------------

--
-- Table structure for table `forum_threads`
--

CREATE TABLE `forum_threads` (
  `thread_id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `thread_title` varchar(255) NOT NULL,
  `thread_content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `forum_threads`
--

INSERT INTO `forum_threads` (`thread_id`, `user_name`, `thread_title`, `thread_content`, `created_at`) VALUES
(2, 'sasd', 'asfa', 'fasa', '2024-11-06 12:46:11'),
(3, 'sasd', 'asfa', 'fasa', '2024-11-06 12:46:36'),
(4, 'afiqdaniel123', 'I love reading', 'My favorite book is Harry Potter. How about yours?', '2024-11-06 18:28:01'),
(5, 'sabrinaaaa', 'hello', 'newbies here', '2024-11-07 07:25:15'),
(6, 'haziq', 'ZEE', 'HAI', '2024-11-09 13:48:26'),
(7, 'sehuh', 'Nice to meet you', 'Hello', '2024-11-21 02:40:06'),
(8, 'anon', 'hi', 'yow', '2024-11-21 04:06:05');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` int(11) NOT NULL,
  `issued_id` varchar(50) NOT NULL,
  `user_id` int(11) NOT NULL,
  `bank_name` varchar(50) NOT NULL,
  `account_number` varchar(20) NOT NULL,
  `transaction_reference` varchar(100) NOT NULL,
  `amount` int(11) NOT NULL,
  `payment_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('Pending','Completed','Failed') DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tblauthors`
--

CREATE TABLE `tblauthors` (
  `id` int(11) NOT NULL,
  `AuthorName` varchar(159) DEFAULT NULL,
  `creationDate` timestamp NULL DEFAULT current_timestamp(),
  `UpdationDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblauthors`
--

INSERT INTO `tblauthors` (`id`, `AuthorName`, `creationDate`, `UpdationDate`) VALUES
(1, 'Anuj kumari', '2024-01-25 07:23:03', '2024-11-02 06:44:32'),
(2, 'Amir', '2024-01-25 07:23:03', '2024-11-02 07:24:33'),
(3, 'Anita Desai', '2024-01-25 07:23:03', '2024-02-04 06:34:26'),
(4, 'HC Verma', '2024-01-25 07:23:03', '2024-02-04 06:34:26'),
(5, 'R.D. Sharma ', '2024-01-25 07:23:03', '2024-02-04 06:34:26'),
(9, 'fwdfrwer', '2024-01-25 07:23:03', '2024-02-04 06:34:26'),
(10, 'Dr. Andy Williams', '2024-01-25 07:23:03', '2024-02-04 06:34:26'),
(11, 'Kyle Hill', '2024-01-25 07:23:03', '2024-02-04 06:34:26'),
(12, 'Robert T. Kiyosak', '2024-01-25 07:23:03', '2024-02-04 06:34:26'),
(13, 'Kelly Barnhill', '2024-01-25 07:23:03', '2024-02-04 06:34:26'),
(14, 'Herbert Schildt', '2024-01-25 07:23:03', '2024-02-04 06:34:26'),
(16, 'Daniel', '2024-11-02 10:40:21', NULL),
(17, 'Madammm', '2024-11-07 07:29:15', NULL),
(18, 'J.K. Rowling', '2024-11-20 11:23:40', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tblbooks`
--

CREATE TABLE `tblbooks` (
  `id` int(11) NOT NULL,
  `BookName` varchar(255) DEFAULT NULL,
  `CatId` int(11) DEFAULT NULL,
  `AuthorId` int(11) DEFAULT NULL,
  `ISBNNumber` varchar(25) DEFAULT NULL,
  `bookImage` varchar(250) NOT NULL,
  `RegDate` timestamp NULL DEFAULT current_timestamp(),
  `UpdationDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `quantity` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblbooks`
--

INSERT INTO `tblbooks` (`id`, `BookName`, `CatId`, `AuthorId`, `ISBNNumber`, `bookImage`, `RegDate`, `UpdationDate`, `quantity`) VALUES
(1, 'PHP And MySql programming', 5, 16, '222333', '1efecc0ca822e40b7b673c0d79ae943f.jpg', '2024-01-30 07:23:03', '2024-11-21 04:04:49', 50),
(3, 'physics', 6, 4, '1111', 'dd8267b57e0e4feee5911cb1e1a03a79.jpg', '2024-01-30 07:23:03', '2024-11-20 11:11:33', 16),
(5, 'Murach\'s MySQL', 5, 1, '9350237695', '5939d64655b4d2ae443830d73abc35b6.jpg', '2024-01-30 07:23:03', '2024-11-09 08:54:30', 10),
(6, 'WordPress for Beginners 2022: A Visual Step-by-Step Guide to Mastering WordPress', 5, 10, 'B019MO3WCM', '144ab706ba1cb9f6c23fd6ae9c0502b3.jpg', '2024-01-30 07:23:03', '2024-11-20 11:28:48', 0),
(7, 'WordPress Mastery Guide:', 5, 11, 'B09NKWH7NP', '90083a56014186e88ffca10286172e64.jpg', '2024-01-30 07:23:03', '2024-02-04 06:34:11', 0),
(8, 'Rich Dad Poor Dad', 8, 12, 'B07C7M8SX9', '52411b2bd2a6b2e0df3eb10943a5b640.jpg', '2024-01-30 07:23:03', '2024-11-09 07:06:48', 0),
(9, 'The Girl Who Drank the Moon', 8, 13, '1848126476', 'f05cd198ac9335245e1fdffa793207a7.jpg', '2024-01-30 07:23:03', '2024-02-04 06:34:11', 0),
(10, 'C++: The Complete Reference, 4th Edition', 5, 14, '007053246X', '36af5de9012bf8c804e499dc3c3b33a5.jpg', '2024-01-30 07:23:03', '2024-11-20 11:29:26', 11),
(11, 'ASP.NET Core 5 for Beginners', 9, 11, 'GBSJ36344563', 'b1b6788016bbfab12cfd2722604badc9.jpg', '2024-01-30 07:23:03', '2024-11-08 10:24:38', 10),
(12, 'Harry Potter and The Prisoner of Azkaban', 10, 18, '12345', 'ee3197480fff7a100fc1c3471952b5aejpeg', '2024-11-02 10:42:06', '2024-11-21 02:39:22', 6),
(14, 'Harry Potter', 10, 18, '141241522141', '9e3c7247e7fd8dbed990968800684aab.jpeg', '2024-11-21 00:25:09', NULL, 10);

-- --------------------------------------------------------

--
-- Table structure for table `tblcategory`
--

CREATE TABLE `tblcategory` (
  `id` int(11) NOT NULL,
  `CategoryName` varchar(150) DEFAULT NULL,
  `Status` int(1) DEFAULT NULL,
  `CreationDate` timestamp NULL DEFAULT current_timestamp(),
  `UpdationDate` timestamp NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblcategory`
--

INSERT INTO `tblcategory` (`id`, `CategoryName`, `Status`, `CreationDate`, `UpdationDate`) VALUES
(4, 'Romantic', 1, '2024-01-31 07:23:03', '2024-11-02 07:24:18'),
(5, 'Technology', 1, '2024-01-31 07:23:03', '2024-02-04 06:33:51'),
(6, 'Science', 1, '2024-01-31 07:23:03', '2024-11-06 19:13:58'),
(7, 'Management', 1, '2024-01-31 07:23:03', '2024-02-04 06:33:51'),
(8, 'General', 1, '2024-01-31 07:23:03', '2024-02-04 06:33:51'),
(9, 'Programming', 1, '2024-01-31 07:23:03', '2024-02-04 06:33:51'),
(10, 'Fiction', 1, '2024-11-20 11:23:27', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tblissuedbookdetails`
--

CREATE TABLE `tblissuedbookdetails` (
  `id` int(11) NOT NULL,
  `BookId` int(11) DEFAULT NULL,
  `StudentID` varchar(150) DEFAULT NULL,
  `IssuesDate` timestamp NULL DEFAULT current_timestamp(),
  `ReturnDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `DeliveryOption` varchar(50) DEFAULT NULL,
  `status` enum('Issued','Returned','Waiting to be Shipped','Waiting to be Pickup') DEFAULT 'Issued',
  `ExpectedReturnDate` date DEFAULT NULL,
  `pay_status` enum('Paid','Pending','Not Paid') DEFAULT 'Pending',
  `amount` decimal(10,2) DEFAULT 0.00,
  `fine` int(11) NOT NULL,
  `payment_status` enum('Paid','Pending','Not Paid') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblissuedbookdetails`
--

INSERT INTO `tblissuedbookdetails` (`id`, `BookId`, `StudentID`, `IssuesDate`, `ReturnDate`, `DeliveryOption`, `status`, `ExpectedReturnDate`, `pay_status`, `amount`, `fine`, `payment_status`) VALUES
(7, 5, 'SID011', '2024-02-01 05:45:57', NULL, NULL, 'Issued', NULL, NULL, 0.00, 0, 'Paid'),
(8, 1, 'SID002', '2024-02-01 05:45:57', '2024-02-04 06:33:08', NULL, 'Issued', NULL, NULL, 0.00, 0, 'Paid'),
(9, 10, 'SID009', '2024-02-01 05:45:57', '2024-11-02 07:23:42', NULL, 'Returned', NULL, NULL, 0.00, 0, 'Paid'),
(10, 11, 'SID009', '2024-02-01 05:45:57', '2024-02-04 06:33:08', NULL, 'Issued', NULL, NULL, 0.00, 0, 'Paid'),
(11, 1, 'SID012', '2024-02-01 05:45:57', NULL, NULL, 'Issued', NULL, NULL, 0.00, 0, 'Paid'),
(12, 10, 'SID012', '2024-02-01 05:45:57', '2024-02-04 06:33:08', NULL, 'Issued', NULL, NULL, 0.00, 0, 'Paid'),
(28, 1, 'SID014', '2024-11-01 16:00:00', '2024-11-26 03:18:55', 'delivery', 'Issued', '2024-11-09', 'Paid', 5.00, 17, 'Paid'),
(29, 1, 'SID014', '2024-11-01 16:00:00', '2024-11-26 03:18:55', 'pickup', 'Issued', '2024-11-09', 'Paid', 0.00, 17, 'Paid'),
(30, 1, 'SID014', '2024-11-01 16:00:00', '2024-11-26 03:18:55', 'pickup', 'Issued', '2024-11-09', 'Paid', 0.00, 17, 'Paid'),
(31, 3, 'SID014', '2024-11-01 16:00:00', '2024-11-26 03:18:55', 'pickup', 'Issued', '2024-11-09', 'Paid', 0.00, 17, 'Paid'),
(32, 6, 'SID014', '2024-11-01 16:00:00', '2024-11-26 03:18:55', 'pickup', 'Issued', '2024-11-09', 'Paid', 0.00, 17, 'Paid'),
(33, 11, 'SID014', '2024-11-01 16:00:00', '2024-11-26 03:18:55', 'pickup', 'Issued', '2024-11-09', 'Paid', 0.00, 17, 'Paid'),
(34, 1, 'SID014', '2024-11-01 16:00:00', '2024-11-26 03:18:55', 'pickup', 'Issued', '2024-11-09', 'Paid', 0.00, 17, 'Paid'),
(35, 3, 'SID014', '2024-11-01 16:00:00', '2024-11-26 03:18:55', 'pickup', 'Issued', '2024-11-09', 'Paid', 0.00, 17, 'Paid'),
(36, 6, 'SID014', '2024-11-01 16:00:00', '2024-11-26 03:18:55', 'pickup', 'Issued', '2024-11-09', 'Paid', 0.00, 17, 'Paid'),
(37, 11, 'SID014', '2024-11-01 16:00:00', '2024-11-26 03:18:55', 'pickup', 'Issued', '2024-11-09', 'Paid', 0.00, 17, 'Paid'),
(39, 11, 'SID014', '2024-11-01 16:00:00', '2024-11-26 03:18:55', 'delivery', 'Issued', '2024-11-09', 'Paid', 5.00, 17, 'Paid'),
(40, 3, 'SID014', '2024-11-01 16:00:00', '2024-11-26 03:18:55', 'delivery', 'Issued', '2024-11-09', 'Paid', 5.00, 17, 'Paid'),
(41, 11, 'SID014', '2024-11-01 16:00:00', '2024-11-26 03:18:55', 'delivery', 'Issued', '2024-11-09', 'Paid', 5.00, 17, 'Paid'),
(42, 3, 'SID014', '2024-11-01 16:00:00', '2024-11-26 03:18:55', 'delivery', 'Issued', '2024-11-09', 'Paid', 5.00, 17, 'Paid'),
(43, 11, 'SID014', '2024-11-01 16:00:00', '2024-11-26 03:18:55', 'delivery', 'Issued', '2024-11-09', 'Paid', 5.00, 17, 'Paid'),
(45, 3, 'SID013', '2024-11-13 16:00:00', '2024-11-05 09:38:02', 'delivery', 'Issued', '2024-11-21', NULL, 5.00, 0, 'Paid'),
(46, 6, 'SID013', '2024-11-13 16:00:00', '2024-11-05 09:38:02', 'delivery', 'Issued', '2024-11-21', NULL, 5.00, 0, 'Paid'),
(47, 11, 'SID013', '2024-11-03 16:00:00', '2024-11-05 09:41:04', 'pickup', 'Waiting to be Pickup', '2024-11-11', 'Paid', 0.00, 0, 'Paid'),
(48, 3, 'SID014', '2024-11-03 16:00:00', '2024-11-26 03:18:55', 'pickup', 'Issued', '2024-11-11', 'Paid', 0.00, 15, 'Paid'),
(49, 1, 'SID014', '2024-11-03 16:00:00', '2024-11-26 03:18:55', 'delivery', 'Issued', '2024-11-11', 'Paid', 5.00, 15, 'Paid'),
(50, 1, 'SID014', '2024-11-03 16:00:00', '2024-11-26 03:18:55', 'pickup', 'Issued', '2024-11-11', 'Paid', 0.00, 15, 'Paid'),
(51, 1, 'SID014', '2024-11-03 16:00:00', '2024-11-26 03:18:55', 'pickup', 'Issued', '2024-11-11', 'Paid', 0.00, 15, 'Paid'),
(52, 6, 'SID013', '2024-11-03 16:00:00', '2024-11-05 09:38:02', 'delivery', 'Issued', '2024-11-11', NULL, 5.00, 0, 'Paid'),
(53, 1, 'SID013', '2024-11-03 16:00:00', '2024-11-05 09:41:04', 'pickup', 'Waiting to be Pickup', '2024-11-11', 'Paid', 0.00, 0, 'Paid'),
(54, 3, 'SID013', '2024-11-03 16:00:00', '2024-11-05 09:41:04', 'pickup', 'Waiting to be Pickup', '2024-11-11', 'Paid', 0.00, 0, 'Paid'),
(55, 6, 'SID013', '2024-11-03 16:00:00', '2024-11-05 09:41:04', 'pickup', 'Waiting to be Pickup', '2024-11-11', 'Paid', 0.00, 0, 'Paid'),
(56, 10, 'SID013', '2024-11-03 16:00:00', '2024-11-05 09:41:04', 'pickup', 'Waiting to be Pickup', '2024-11-11', 'Paid', 0.00, 0, 'Paid'),
(57, 11, 'SID013', '2024-11-03 16:00:00', '2024-11-05 09:41:04', 'pickup', 'Waiting to be Pickup', '2024-11-11', 'Paid', 0.00, 0, 'Paid'),
(58, 6, 'SID013', '2024-11-03 16:00:00', '2024-11-05 09:41:04', 'pickup', 'Waiting to be Pickup', '2024-11-11', 'Paid', 0.00, 0, 'Paid'),
(59, 11, 'SID013', '2024-11-04 16:00:00', '2024-11-05 09:41:04', 'pickup', 'Waiting to be Pickup', '2024-11-12', 'Paid', 0.00, 0, 'Paid'),
(60, 10, 'SID013', '2024-11-04 16:00:00', '2024-11-05 09:41:04', 'pickup', 'Waiting to be Pickup', '2024-11-12', 'Paid', 0.00, 0, 'Paid'),
(61, 3, 'SID013', '2024-11-04 16:00:00', '2024-11-05 09:41:04', 'pickup', 'Waiting to be Pickup', '2024-11-12', 'Paid', 0.00, 0, 'Paid'),
(62, 6, 'SID013', '2024-11-04 16:00:00', '2024-11-05 09:41:04', 'pickup', 'Waiting to be Pickup', '2024-11-12', 'Paid', 0.00, 0, 'Paid'),
(63, 6, 'SID014', '2024-11-04 16:00:00', '2024-11-26 03:18:55', 'pickup', 'Issued', '2024-11-12', 'Paid', 0.00, 14, 'Paid'),
(64, 1, 'SID014', '2024-11-04 16:00:00', '2024-11-26 03:18:55', 'delivery', 'Issued', '2024-11-12', 'Paid', 5.00, 14, 'Paid'),
(65, 1, 'SID014', '2024-11-04 16:00:00', '2024-11-26 03:18:55', 'pickup', 'Issued', '2024-11-12', 'Paid', 0.00, 14, 'Paid'),
(66, 6, 'SID014', '2024-11-04 16:00:00', '2024-11-26 03:18:55', 'pickup', 'Issued', '2024-11-12', 'Paid', 0.00, 14, 'Paid'),
(67, 6, 'SID013', '2024-11-04 16:00:00', '2024-11-05 09:38:02', 'delivery', 'Issued', '2024-11-12', NULL, 5.00, 0, 'Paid'),
(68, 11, 'SID013', '2024-11-04 16:00:00', '2024-11-05 09:41:04', 'pickup', 'Waiting to be Pickup', '2024-11-12', 'Paid', 0.00, 0, 'Paid'),
(69, 6, 'SID013', '2024-11-04 16:00:00', '2024-11-05 09:38:02', 'delivery', 'Issued', '2024-11-12', NULL, 5.00, 0, 'Paid'),
(70, 10, 'SID013', '2024-11-04 16:00:00', '2024-11-05 09:38:02', 'delivery', 'Issued', '2024-11-12', NULL, 5.00, 0, 'Paid'),
(71, 3, 'SID013', '2024-11-04 16:00:00', '2024-11-05 09:41:04', 'pickup', 'Waiting to be Pickup', '2024-11-12', 'Paid', 0.00, 0, 'Paid'),
(72, 11, 'SID013', '2024-11-04 16:00:00', '2024-11-05 09:38:02', 'delivery', 'Issued', '2024-11-12', NULL, 5.00, 0, 'Paid'),
(73, 3, 'SID013', '2024-11-04 16:00:00', '2024-11-05 09:38:02', 'delivery', 'Issued', '2024-11-12', NULL, 5.00, 0, 'Paid'),
(74, 11, 'SID013', '2024-11-04 16:00:00', '2024-11-05 09:38:02', 'delivery', 'Issued', '2024-11-12', NULL, 5.00, 0, 'Paid'),
(75, 6, 'SID013', '2024-11-04 16:00:00', '2024-11-05 09:41:04', 'pickup', 'Waiting to be Pickup', '2024-11-12', 'Paid', 0.00, 0, 'Paid'),
(76, 6, 'SID013', '2024-11-04 16:00:00', '2024-11-05 09:38:02', 'delivery', 'Issued', '2024-11-12', NULL, 5.00, 0, 'Paid'),
(77, 11, 'SID013', '2024-11-04 16:00:00', '2024-11-05 09:41:04', 'pickup', 'Waiting to be Pickup', '2024-11-12', 'Paid', 0.00, 0, 'Paid'),
(78, 3, 'SID013', '2024-11-04 16:00:00', '2024-11-05 09:38:02', 'delivery', 'Issued', '2024-11-12', NULL, 5.00, 0, 'Paid'),
(79, 6, 'SID013', '2024-11-04 16:00:00', '2024-11-05 09:41:04', 'pickup', 'Waiting to be Pickup', '2024-11-12', 'Paid', 0.00, 0, 'Paid'),
(80, 10, 'SID013', '2024-11-04 16:00:00', '2024-11-05 09:38:02', 'delivery', 'Issued', '2024-11-12', NULL, 5.00, 0, 'Paid'),
(81, 11, 'SID013', '2024-11-04 16:00:00', '2024-11-05 09:41:04', 'pickup', 'Waiting to be Pickup', '2024-11-12', 'Paid', 0.00, 0, 'Paid'),
(82, 11, 'SID013', '2024-11-04 16:00:00', '2024-11-05 09:41:04', 'pickup', 'Issued', '2024-11-12', 'Paid', 0.00, 0, 'Paid'),
(83, 10, 'SID013', '2024-11-04 16:00:00', '2024-11-05 09:38:02', 'delivery', 'Issued', '2024-11-12', NULL, 5.00, 0, 'Paid'),
(84, 11, 'SID013', '2024-11-04 16:00:00', '2024-11-05 09:41:04', 'pickup', 'Issued', '2024-11-12', 'Paid', 0.00, 0, 'Paid'),
(85, 3, 'SID013', '2024-11-04 16:00:00', '2024-11-05 09:38:02', 'delivery', 'Issued', '2024-11-12', NULL, 5.00, 0, 'Paid'),
(86, 11, 'SID013', '2024-11-04 16:00:00', '2024-11-05 09:41:04', 'pickup', 'Issued', '2024-11-12', 'Paid', 0.00, 0, 'Paid'),
(87, 6, 'SID013', '2024-11-04 16:00:00', '2024-11-05 09:38:02', 'delivery', 'Issued', '2024-11-12', NULL, 5.00, 0, 'Paid'),
(88, 3, 'SID013', '2024-11-04 16:00:00', '2024-11-05 09:38:02', 'delivery', 'Issued', '2024-11-12', NULL, 5.00, 0, 'Paid'),
(89, 6, 'SID013', '2024-11-04 16:00:00', '2024-11-05 09:38:02', 'delivery', 'Issued', '2024-11-12', NULL, 5.00, 0, 'Paid'),
(90, 11, 'SID013', '2024-11-04 16:00:00', '2024-11-05 09:41:04', 'pickup', 'Issued', '2024-11-12', 'Paid', 0.00, 0, 'Paid'),
(91, 6, 'SID013', '2024-11-04 16:00:00', '2024-11-05 09:38:02', 'delivery', 'Issued', '2024-11-12', NULL, 5.00, 0, 'Paid'),
(92, 11, 'SID013', '2024-11-04 16:00:00', '2024-11-05 09:41:04', 'pickup', 'Issued', '2024-11-12', 'Paid', 0.00, 0, 'Paid'),
(93, 3, 'SID013', '2024-11-04 16:00:00', '2024-11-05 09:41:04', 'pickup', 'Issued', '2024-11-12', 'Paid', 0.00, 0, 'Paid'),
(94, 10, 'SID013', '2024-11-04 16:00:00', '2024-11-05 09:38:02', 'delivery', 'Issued', '2024-11-12', NULL, 5.00, 0, 'Paid'),
(95, 1, 'SID013', '2024-11-04 16:00:00', '2024-11-05 09:41:04', 'pickup', 'Issued', '2024-11-12', 'Paid', 0.00, 0, 'Paid'),
(96, 11, 'SID013', '2024-11-04 16:00:00', '2024-11-05 09:38:02', 'delivery', 'Issued', '2024-11-12', NULL, 5.00, 0, 'Paid'),
(97, 1, 'SID013', '2024-11-04 16:00:00', '2024-11-05 09:38:02', 'delivery', 'Issued', '2024-11-12', NULL, 5.00, 0, 'Paid'),
(98, 11, 'SID013', '2024-11-04 16:00:00', '2024-11-05 09:41:04', 'pickup', 'Issued', '2024-11-12', 'Paid', 0.00, 0, 'Paid'),
(99, 6, 'SID013', '2024-11-04 16:00:00', '2024-11-05 09:41:04', 'pickup', 'Issued', '2024-11-12', 'Paid', 0.00, 0, 'Paid'),
(100, 1, 'SID013', '2024-11-04 16:00:00', '2024-11-05 09:41:04', 'pickup', 'Issued', '2024-11-12', 'Paid', 0.00, 0, 'Paid'),
(101, 3, 'SID013', '2024-11-04 16:00:00', '2024-11-05 09:43:41', 'delivery', 'Issued', '2024-11-12', 'Pending', 5.00, 0, 'Paid'),
(102, 1, 'SID013', '2024-11-04 16:00:00', '2024-11-05 09:41:14', 'pickup', 'Issued', '2024-11-12', 'Paid', 0.00, 0, 'Paid'),
(103, 10, 'SID013', '2024-11-04 16:00:00', '2024-11-05 09:43:41', 'delivery', 'Issued', '2024-11-12', 'Pending', 5.00, 0, 'Paid'),
(104, 1, 'SID013', '2024-11-04 16:00:00', '2024-11-05 09:43:57', 'pickup', 'Issued', '2024-11-12', 'Paid', 0.00, 0, 'Paid'),
(105, 11, 'SID013', '2024-11-04 16:00:00', '2024-11-05 09:44:03', 'delivery', 'Issued', '2024-11-12', 'Pending', 5.00, 0, 'Paid'),
(106, 6, 'SID013', '2024-11-04 16:00:00', '2024-11-05 09:45:06', 'pickup', 'Issued', '2024-11-12', 'Paid', 0.00, 0, 'Paid'),
(107, 3, 'SID013', '2024-11-04 16:00:00', '2024-11-05 09:45:12', 'delivery', 'Issued', '2024-11-12', 'Pending', 5.00, 0, 'Paid'),
(108, 11, 'SID013', '2024-11-04 16:00:00', '2024-11-09 09:38:46', 'pickup', 'Issued', '2024-11-12', 'Paid', 0.00, 0, 'Paid'),
(109, 11, 'SID013', '2024-11-04 16:00:00', '2024-11-05 09:50:37', 'delivery', 'Issued', '2024-11-12', 'Pending', 5.00, 0, 'Paid'),
(110, 1, 'SID013', '2024-11-04 16:00:00', '2024-11-05 09:53:49', 'delivery', 'Issued', '2024-11-12', 'Pending', 5.00, 0, 'Paid'),
(111, 1, 'SID013', '2024-11-04 16:00:00', '2024-11-05 09:55:24', 'delivery', 'Issued', '2024-11-12', 'Pending', 5.00, 0, 'Paid'),
(112, 1, 'SID013', '2024-11-04 16:00:00', '2024-11-09 09:38:46', 'pickup', 'Issued', '2024-11-12', 'Paid', 0.00, 0, 'Paid'),
(113, 1, 'SID013', '2024-11-04 16:00:00', '2024-11-05 09:56:55', 'delivery', 'Issued', '2024-11-12', 'Pending', 5.00, 0, 'Paid'),
(114, 1, 'SID013', '2024-11-04 16:00:00', '2024-11-05 10:05:07', 'delivery', 'Issued', '2024-11-12', 'Pending', 5.00, 0, 'Paid'),
(115, 3, 'SID013', '2024-11-04 16:00:00', '2024-11-09 09:38:46', 'pickup', 'Issued', '2024-11-12', 'Paid', 0.00, 0, 'Paid'),
(116, 3, 'SID013', '2024-11-04 16:00:00', '2024-11-05 10:05:07', 'delivery', 'Issued', '2024-11-12', 'Pending', 5.00, 0, 'Paid'),
(117, 1, 'SID013', '2024-11-04 16:00:00', '2024-11-05 10:05:07', 'delivery', 'Issued', '2024-11-12', 'Pending', 5.00, 0, 'Paid'),
(118, 1, 'SID013', '2024-11-04 16:00:00', '2024-11-05 10:05:07', 'delivery', 'Issued', '2024-11-12', 'Pending', 5.00, 0, 'Paid'),
(119, 3, 'SID013', '2024-11-04 16:00:00', '2024-11-05 10:06:48', 'delivery', 'Issued', '2024-11-12', 'Pending', 5.00, 0, 'Paid'),
(120, 3, 'SID013', '2024-11-04 16:00:00', '2024-11-05 10:14:14', 'delivery', 'Issued', '2024-11-12', 'Pending', 5.00, 0, 'Paid'),
(121, 6, 'SID013', '2024-11-04 16:00:00', '2024-11-09 09:38:46', 'pickup', 'Issued', '2024-11-12', 'Paid', 0.00, 0, 'Paid'),
(122, 3, 'SID013', '2024-11-04 16:00:00', '2024-11-05 10:19:02', 'delivery', 'Issued', '2024-11-12', 'Pending', 5.00, 0, 'Paid'),
(123, 3, 'SID013', '2024-11-04 16:00:00', '2024-11-05 11:03:29', 'delivery', 'Issued', '2024-11-12', 'Pending', 5.00, 0, 'Paid'),
(124, 3, 'SID013', '2024-11-04 16:00:00', '2024-11-09 09:38:46', 'pickup', 'Issued', '2024-11-12', 'Paid', 0.00, 0, 'Paid'),
(125, 1, 'SID013', '2024-11-04 16:00:00', '2024-11-05 11:07:37', 'delivery', 'Issued', '2024-11-12', 'Pending', 5.00, 0, 'Paid'),
(126, 3, 'SID013', '2024-11-04 16:00:00', '2024-11-09 09:38:46', 'pickup', 'Issued', '2024-11-12', 'Paid', 0.00, 0, 'Paid'),
(127, 1, 'SID013', '2024-11-04 16:00:00', '2024-11-05 11:12:07', 'delivery', 'Issued', '2024-11-12', 'Pending', 5.00, 0, 'Paid'),
(128, 1, 'SID013', '2024-11-04 16:00:00', '2024-11-09 09:38:46', 'pickup', 'Issued', '2024-11-12', 'Paid', 0.00, 0, 'Paid'),
(129, 1, 'SID013', '2024-11-04 16:00:00', '2024-11-05 11:14:17', 'delivery', 'Issued', '2024-11-12', 'Pending', 5.00, 0, 'Paid'),
(130, 1, 'SID013', '2024-11-04 16:00:00', '2024-11-05 11:16:34', 'delivery', 'Returned', '2024-11-12', 'Pending', 5.00, 0, 'Paid'),
(131, 1, 'SID013', '2024-11-04 16:00:00', '2024-11-05 11:17:30', 'delivery', 'Issued', '2024-11-12', 'Pending', 5.00, 0, 'Paid'),
(132, 6, 'SID013', '2024-11-04 16:00:00', '2024-11-09 09:38:46', 'pickup', 'Issued', '2024-11-12', 'Paid', 0.00, 0, 'Paid'),
(133, 1, 'SID013', '2024-11-04 16:00:00', '2024-11-05 11:17:51', 'delivery', 'Issued', '2024-11-12', 'Pending', 5.00, 0, 'Paid'),
(134, 6, 'SID013', '2024-11-04 16:00:00', '2024-11-09 09:59:37', 'delivery', 'Issued', '2024-11-12', 'Paid', 5.00, 0, 'Paid'),
(135, 1, 'SID013', '2024-11-04 16:00:00', '2024-11-09 09:57:51', 'delivery', 'Issued', '2024-11-12', 'Paid', 5.00, 0, 'Paid'),
(136, 1, 'SID013', '2024-11-04 16:00:00', '2024-11-05 12:16:42', 'delivery', 'Issued', '2024-11-12', 'Paid', 5.00, 0, 'Paid'),
(137, 11, 'SID013', '2024-11-04 16:00:00', '2024-11-05 12:13:03', 'pickup', 'Waiting to be Pickup', '2024-11-12', 'Paid', 0.00, 0, 'Paid'),
(138, 11, 'SID014', '2024-11-04 16:00:00', '2024-11-26 03:18:55', 'delivery', 'Waiting to be Shipped', '2024-11-12', 'Paid', 5.00, 14, 'Paid'),
(139, 11, 'SID014', '2024-11-04 16:00:00', '2024-11-26 03:19:09', 'delivery', 'Returned', '2024-11-12', 'Paid', 5.00, 14, 'Paid'),
(140, 1, 'SID014', '2024-11-04 16:00:00', '2024-11-26 03:18:55', 'delivery', 'Issued', '2024-11-12', 'Paid', 5.00, 14, 'Paid'),
(141, 3, 'SID014', '2024-11-04 16:00:00', '2024-11-26 03:18:55', 'delivery', 'Issued', '2024-11-12', 'Paid', 5.00, 14, 'Paid'),
(142, 6, 'SID014', '2024-11-04 16:00:00', '2024-11-26 03:18:55', 'delivery', 'Issued', '2024-11-12', 'Paid', 5.00, 14, 'Paid'),
(145, 6, 'SID015', '2024-11-04 16:00:00', '2024-11-05 16:23:37', 'delivery', 'Returned', '2024-11-12', 'Paid', 5.00, 0, 'Paid'),
(146, 5, 'SID014', '2024-11-05 16:00:00', '2024-11-26 03:18:55', 'delivery', 'Issued', '2024-11-13', 'Paid', 5.00, 13, 'Paid'),
(147, 6, 'SID014', '2024-11-05 16:00:00', '2024-11-26 03:18:55', 'pickup', 'Issued', '2024-11-13', 'Paid', 0.00, 13, 'Paid'),
(148, 3, 'SID014', '2024-11-05 16:00:00', NULL, 'delivery', 'Issued', '2024-11-13', 'Pending', 5.00, 13, 'Paid'),
(149, 3, 'SID014', '2024-11-05 16:00:00', '2024-11-26 03:18:55', 'pickup', 'Issued', '2024-11-13', 'Paid', 0.00, 13, 'Paid'),
(150, 10, 'SID014', '2024-11-05 16:00:00', NULL, 'delivery', 'Issued', '2024-11-13', 'Pending', 5.00, 13, 'Paid'),
(151, 3, 'SID014', '2024-11-05 16:00:00', '2024-11-26 03:18:55', 'pickup', 'Issued', '2024-11-13', 'Paid', 0.00, 13, 'Paid'),
(152, 6, 'SID016', '2024-11-05 16:00:00', '2024-11-20 11:17:57', 'pickup', 'Waiting to be Pickup', '2024-11-13', 'Paid', 0.00, 7, 'Paid'),
(153, 10, 'SID016', '2024-11-06 16:00:00', '2024-11-20 11:17:57', 'delivery', 'Issued', '2024-11-14', 'Paid', 5.00, 6, 'Paid'),
(154, 5, 'SID017', '2024-11-06 16:00:00', '2024-11-07 07:20:57', 'pickup', 'Issued', '2024-11-14', 'Paid', 0.00, 0, 'Paid'),
(155, 6, 'SID017', '2024-11-06 16:00:00', '2024-11-07 07:20:57', 'pickup', 'Issued', '2024-11-14', 'Paid', 0.00, 0, 'Paid'),
(156, 11, 'SID017', '2024-11-06 16:00:00', '2024-11-07 07:32:22', 'delivery', 'Returned', '2024-11-14', 'Paid', 5.00, 0, 'Paid'),
(157, 1, 'SID021', '2024-11-07 16:00:00', '2024-11-08 10:01:21', 'pickup', 'Issued', '2024-11-15', 'Paid', 0.00, 0, 'Paid'),
(158, 6, 'SID021', '2024-11-07 16:00:00', '2024-11-08 10:04:46', 'delivery', 'Issued', '2024-11-15', 'Paid', 5.00, 0, 'Paid'),
(159, 3, 'SID021', '2024-11-07 16:00:00', '2024-11-08 10:15:05', 'delivery', 'Issued', '2024-11-15', 'Paid', 5.00, 0, 'Paid'),
(160, 5, 'SID021', '2024-11-07 16:00:00', '2024-11-08 10:17:52', 'delivery', 'Issued', '2024-11-15', 'Paid', 5.00, 0, 'Paid'),
(161, 6, 'SID021', '2024-11-07 16:00:00', '2024-11-08 10:18:39', 'delivery', 'Issued', '2024-11-15', 'Paid', 5.00, 0, 'Paid'),
(162, 11, 'SID021', '2024-11-07 16:00:00', '2024-11-08 10:24:45', 'delivery', 'Issued', '2024-11-15', 'Paid', 5.00, 0, 'Paid'),
(163, 5, 'SID021', '2024-11-07 16:00:00', '2024-11-08 10:35:55', 'delivery', 'Issued', '2024-11-15', 'Paid', 5.00, 0, 'Paid'),
(165, 3, 'SID021', '2024-11-09 08:33:37', NULL, NULL, 'Issued', NULL, 'Pending', 0.00, 0, 'Paid'),
(166, 1111, 'SID012', '2024-11-09 08:41:06', NULL, NULL, 'Issued', NULL, 'Pending', 0.00, 0, 'Paid'),
(168, 3, 'SID021', '2024-11-09 08:53:21', NULL, NULL, 'Issued', NULL, 'Pending', 0.00, 0, 'Paid'),
(169, 3, 'SID021', '2024-11-09 08:53:32', NULL, NULL, 'Issued', NULL, 'Pending', 0.00, 0, 'Paid'),
(170, 5, 'SID016', '2024-11-08 16:00:00', '2024-11-20 11:17:57', 'delivery', 'Issued', '2024-11-16', 'Paid', 5.00, 4, 'Paid'),
(171, 1, 'SID021', '2024-11-09 09:00:37', NULL, NULL, 'Issued', NULL, 'Pending', 0.00, 0, 'Paid'),
(172, 1, 'SID011', '2024-11-09 09:02:11', NULL, 'Home Delivery', 'Issued', '2024-11-13', 'Pending', 0.00, 0, 'Paid'),
(173, 1, 'SID011', '2024-11-09 09:06:28', '2024-11-09 09:10:31', 'Pickup', 'Waiting to be Shipped', '2024-11-12', 'Paid', 5.00, 0, 'Paid'),
(174, 1, 'SID022', '2024-11-08 16:00:00', '2024-11-09 09:27:03', 'delivery', 'Issued', '2024-11-16', 'Paid', 5.00, 0, 'Paid'),
(175, 3, 'SID022', '2024-11-08 16:00:00', '2024-11-09 09:27:20', 'pickup', 'Issued', '2024-11-16', 'Paid', 0.00, 0, 'Paid'),
(176, 5, 'SID022', '2024-11-09 09:32:06', '2024-11-09 13:50:16', 'Pickup', 'Returned', '2024-11-13', 'Pending', 0.00, 0, 'Paid'),
(177, 1, 'SID013', '2024-11-08 16:00:00', '2024-11-09 13:50:21', 'delivery', 'Returned', '2024-11-16', 'Paid', 5.00, 0, 'Paid'),
(178, 3, 'SID016', '2024-11-19 16:00:00', '2024-11-20 11:18:36', 'delivery', 'Issued', '2024-11-27', 'Paid', 5.00, 0, 'Paid'),
(179, 3, 'SID016', '2024-11-19 16:00:00', '2024-11-20 11:17:57', 'pickup', 'Issued', '2024-11-27', 'Paid', 0.00, 0, 'Paid'),
(180, 6, 'SID014', '2024-11-19 16:00:00', '2024-11-20 11:28:52', 'pickup', 'Issued', '2024-11-27', 'Paid', 0.00, 0, 'Paid'),
(181, 10, 'SID014', '2024-11-19 16:00:00', NULL, 'delivery', 'Issued', '2024-11-27', 'Pending', 5.00, 0, 'Paid'),
(182, 5, 'SID014', '2024-11-21 00:19:57', '2024-11-26 03:18:55', 'delivery', 'Issued', '2024-11-22', 'Paid', 5.00, 4, 'Paid'),
(183, 10, 'SID014', '2024-11-21 00:22:28', '2024-11-26 03:18:55', 'Pickup', 'Waiting to be Pickup', '2024-11-25', 'Paid', 0.00, 1, 'Paid'),
(184, 12, 'SID025', '2024-11-20 16:00:00', '2024-11-21 02:39:25', 'pickup', 'Issued', '2024-11-28', 'Paid', 0.00, 0, 'Paid'),
(185, 1, 'SID014', '2024-11-20 16:00:00', '2024-11-26 03:18:55', 'Pickup', 'Waiting to be Shipped', '2024-11-28', 'Paid', 0.00, 0, 'Paid');

-- --------------------------------------------------------

--
-- Table structure for table `tblstudents`
--

CREATE TABLE `tblstudents` (
  `id` int(11) NOT NULL,
  `StudentId` varchar(100) DEFAULT NULL,
  `EmailId` varchar(120) DEFAULT NULL,
  `MobileNumber` char(11) DEFAULT NULL,
  `Password` varchar(120) DEFAULT NULL,
  `Status` int(1) DEFAULT NULL,
  `RegDate` timestamp NULL DEFAULT current_timestamp(),
  `UpdationDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `Address` varchar(255) NOT NULL,
  `IdCardNumber` varchar(12) NOT NULL,
  `FirstName` varchar(255) DEFAULT NULL,
  `LastName` varchar(255) DEFAULT NULL,
  `Poscode` varchar(5) DEFAULT NULL,
  `State` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblstudents`
--

INSERT INTO `tblstudents` (`id`, `StudentId`, `EmailId`, `MobileNumber`, `Password`, `Status`, `RegDate`, `UpdationDate`, `Address`, `IdCardNumber`, `FirstName`, `LastName`, `Poscode`, `State`) VALUES
(1, 'SID002', 'anujk@gmail.com', '9865472555', 'f925916e2754e5e03f75dd58a5733251', 1, '2024-01-31 07:23:03', '2024-02-04 06:32:36', '', '', NULL, NULL, NULL, NULL),
(4, 'SID005', 'csfsd@dfsfks.com', '8569710025', '92228410fc8b872914e023160cf4ae8f', 0, '2024-01-31 07:23:03', '2024-11-02 05:58:30', '', '', NULL, NULL, NULL, NULL),
(8, 'SID009', 'test@gmail.com', '2359874527', 'f925916e2754e5e03f75dd58a5733251', 1, '2024-01-31 07:23:03', '2024-02-04 06:32:42', '', '', NULL, NULL, NULL, NULL),
(9, 'SID010', 'amit@gmail.com', '8585856224', 'f925916e2754e5e03f75dd58a5733251', 0, '2024-01-31 07:23:03', '2024-11-04 06:31:59', '', '', NULL, NULL, NULL, NULL),
(10, 'SID011', 'sarita@gmail.com', '4672423754', 'fb4e529ea6b9320c8bd32577f78a7fdf', 1, '2024-01-31 07:23:03', '2024-11-09 09:04:26', '', '', NULL, NULL, NULL, NULL),
(11, 'SID012', 'john@test.com', '1234569870', 'f925916e2754e5e03f75dd58a5733251', 1, '2024-01-31 07:23:03', '2024-02-04 06:32:42', '', '', NULL, NULL, NULL, NULL),
(12, 'SID013', 'sabrina@gmail.com', '0193481721', '00e45749508fe15ca1af3397eab8db78', 1, '2024-11-02 04:40:33', '2024-11-02 10:44:31', '23, Jalan Kesuma 5/11C, Bandar Tasik Kesuma 43700 Beranang, Selangor', '12345', NULL, NULL, NULL, NULL),
(13, 'SID014', 'daniel@gmail.com', '0123456789', 'aa47f8215c6f30a0dcdb2a36a9f4168e', 1, '2024-11-02 06:00:00', '2024-11-21 00:21:20', 'Raub', '012512', 'Muhammad Afiq Daniel', 'Bin Hairul Amir', '55454', 'Pahang'),
(14, 'SID015', 'sayang@gmail.com', '5446256251', 'dcb76da384ae3028d6aa9b2ebcea01c9', 1, '2024-11-05 16:21:25', NULL, 'Raubbbbbbbbbbbb', '112345678', NULL, NULL, NULL, NULL),
(15, 'SID016', 'jeonjungkook@gmail.com', '013249953', 'bd0a5c90acb8f603fc2fdaa0a557cde1', 1, '2024-11-06 19:37:27', NULL, 'Korea', '4556784', 'Jeon', 'Jungkook', '12544', 'Korea'),
(16, 'SID017', 'parkjimin@gmail.com', '0123456788', 'ebb797eaea754183967fd5de80fe63ec', 1, '2024-11-07 07:15:02', '2024-11-07 07:27:46', 'Kuala Lumpur', '123546', NULL, NULL, NULL, NULL),
(17, 'SID018', 'test123@gmail.com', 'sdgsdg', 'cc03e747a6afbbcbf8be7668acfebee5', 1, '2024-11-08 07:24:16', NULL, 'dsfsdf', '651654684626', NULL, NULL, NULL, NULL),
(19, 'SID020', 'test123@gmail.com', 'sdgsdg', 'cc03e747a6afbbcbf8be7668acfebee5', 1, '2024-11-08 07:27:25', NULL, 'dsfsdf', '651654684626', NULL, 'sdfsdf', 'dsfsf', 'dsfs'),
(20, 'SID021', 'test2@gmail.com', '6545465456', '098f6bcd4621d373cade4e832627b4f6', 0, '2024-11-08 07:30:09', '2024-11-26 03:26:01', 'bandar tasik kesuma', '123456864626', 'ayuiuuuuu', 'raudah', '54668', 'Selangor'),
(21, 'SID022', 'nurin@gmail.com', '0104421142', '2e667d81df0b4dc4b89312e740feced8', 1, '2024-11-09 09:24:25', NULL, 'Georgetown', '020708060614', 'Nurin', 'Addina', '10450', 'Penang'),
(22, 'SID025', 'nurinaddina@gmail.com', '0104420042', '81dc9bdb52d04dc20036dbd8313ed055', 1, '2024-11-21 02:37:05', NULL, '121Q, Jalan Scotland', '020708060614', 'Nurin Addina', 'Jaida', '10450', 'Penang');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `book_ratings`
--
ALTER TABLE `book_ratings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `BookId` (`BookId`);

--
-- Indexes for table `forum_replies`
--
ALTER TABLE `forum_replies`
  ADD PRIMARY KEY (`reply_id`),
  ADD KEY `thread_id` (`thread_id`);

--
-- Indexes for table `forum_threads`
--
ALTER TABLE `forum_threads`
  ADD PRIMARY KEY (`thread_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`);

--
-- Indexes for table `tblauthors`
--
ALTER TABLE `tblauthors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblbooks`
--
ALTER TABLE `tblbooks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblcategory`
--
ALTER TABLE `tblcategory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblissuedbookdetails`
--
ALTER TABLE `tblissuedbookdetails`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblstudents`
--
ALTER TABLE `tblstudents`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `StudentId` (`StudentId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `book_ratings`
--
ALTER TABLE `book_ratings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `forum_replies`
--
ALTER TABLE `forum_replies`
  MODIFY `reply_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `forum_threads`
--
ALTER TABLE `forum_threads`
  MODIFY `thread_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tblauthors`
--
ALTER TABLE `tblauthors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `tblbooks`
--
ALTER TABLE `tblbooks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tblcategory`
--
ALTER TABLE `tblcategory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tblissuedbookdetails`
--
ALTER TABLE `tblissuedbookdetails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=186;

--
-- AUTO_INCREMENT for table `tblstudents`
--
ALTER TABLE `tblstudents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `book_ratings`
--
ALTER TABLE `book_ratings`
  ADD CONSTRAINT `book_ratings_ibfk_1` FOREIGN KEY (`BookId`) REFERENCES `tblbooks` (`id`);

--
-- Constraints for table `forum_replies`
--
ALTER TABLE `forum_replies`
  ADD CONSTRAINT `forum_replies_ibfk_1` FOREIGN KEY (`thread_id`) REFERENCES `forum_threads` (`thread_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
