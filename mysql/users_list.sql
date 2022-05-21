-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 21, 2022 at 01:09 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test`
--

-- --------------------------------------------------------

--
-- Table structure for table `users_list`
--

CREATE TABLE `users_list` (
  `id` int(11) NOT NULL,
  `firstName` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastName` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dateOfBirth` date DEFAULT NULL,
  `question1` int(11) NOT NULL,
  `answer1` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `question2` int(11) NOT NULL,
  `answer2` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `twofa` int(11) NOT NULL DEFAULT 0,
  `hash` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `numLogin` int(11) NOT NULL DEFAULT 0,
  `twofatoken` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users_list`
--

INSERT INTO `users_list` (`id`, `firstName`, `lastName`, `email`, `username`, `password`, `dateOfBirth`, `question1`, `answer1`, `question2`, `answer2`, `status`, `twofa`, `hash`, `numLogin`, `twofatoken`) VALUES
(1, 'Neve', 'Crawford', 'vogohac@mailinator.com', 'bipoxadidy', '$2y$10$mqjQOGN3BzxPCUyX0aCTreyeIQ4bODZBCRhShAkM2PqvydmUUNXrG', '1980-11-02', 2, 'c4d8550ca6060d0dce9ba654c399bfda25ad53fb', 4, '5725fb97a08955aebdf4458d3051851226402c1d', 0, 0, 'eccbc87e4b5ce2fe28308fd9f2a7baf3', 0, ''),
(2, 'Bo', 'Hicks', 'zovytywywu@mailinator.com', 'dozyw', '$2y$10$H3MXF236wrJEogg.I3c8t.sB/9Wbs1T7/HgqFABPOPaee8hDJ93si', '2021-12-03', 1, '816485ff8c2cefc0183bab5e2a488f267aea1c5d', 1, '126f4663d56dc210c3ba0dc4a824aa8c45b730ef', 0, 0, '8065d07da4a77621450aa84fee5656d9', 0, '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users_list`
--
ALTER TABLE `users_list`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users_list`
--
ALTER TABLE `users_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
