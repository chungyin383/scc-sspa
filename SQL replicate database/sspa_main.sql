-- phpMyAdmin SQL Dump
-- version 4.7.6
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 27, 2018 at 05:41 AM
-- Server version: 10.1.29-MariaDB
-- PHP Version: 7.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `id1180552_pingu`
--

-- --------------------------------------------------------

--
-- Table structure for table `sspa_main`
--

CREATE TABLE `sspa_main` (
  `id` int(11) NOT NULL,
  `tel` text,
  `chi_5` text,
  `chi_6` text,
  `eng_5` text,
  `eng_6` text,
  `maths_5` text,
  `maths_6` text,
  `gs_5` text,
  `gs_6` text,
  `conduct_5` text,
  `conduct_6` text,
  `rank_class_5` text,
  `rank_class_6` text,
  `rank_form_5` text,
  `rank_form_6` text,
  `duties_5` text,
  `duties_6` text,
  `prizes_5` text,
  `prizes_6` text,
  `eca` text,
  `remarks` text
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `sspa_main`
--
ALTER TABLE `sspa_main`
  ADD PRIMARY KEY (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
