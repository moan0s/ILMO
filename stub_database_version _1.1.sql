-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: xxx
-- Generation Time: Dec 19, 2018 at 09:04 AM
-- Server version: 5.6.42-log
-- PHP Version: 5.6.38

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `xxx`
--

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `lib_books` (
  `book_ID` varchar(64) CHARACTER SET latin1 COLLATE latin1_german1_ci NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `location` varchar(255) CHARACTER SET latin1 COLLATE latin1_german1_ci NOT NULL,
  `lend` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 = available; 1 = lend'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


--
-- Table structure for table `lend`
--

CREATE TABLE `lib_lend` (
  `lend_ID` int(11) NOT NULL,
  `type` varchar(255) COLLATE latin1_german1_ci NOT NULL,
  `ID` text COLLATE latin1_german1_ci NOT NULL,
  `user_ID` int(11) NOT NULL,
  `pickup_date` date NOT NULL,
  `return_date` date DEFAULT NULL,
  `returned` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 = not returned; 1 = returned',
  `last_reminder` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;

--
-- Table structure for table `log`
--

CREATE TABLE `lib_log` (
  `issue` varchar(255) COLLATE latin1_german1_ci NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;

--
-- Dumping data for table `log`
--

INSERT INTO `lib_log` (`issue`, `date`) VALUES
('mail', '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `open`
--

CREATE TABLE `lib_open` (
  `day` varchar(255) COLLATE latin1_german1_ci NOT NULL,
  `start` varchar(255) COLLATE latin1_german1_ci NOT NULL,
  `end` varchar(255) COLLATE latin1_german1_ci NOT NULL,
  `notice` text COLLATE latin1_german1_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;

--
-- Dumping data for table `open`
--

INSERT INTO `lib_open` (`day`, `start`, `end`, `notice`) VALUES
('monday', '12', '15', ''),
('tuesday', '13', '14', ''),
('wednesday', '15', '15', ''),
('thursday', '', '', 'closed'),
('friday', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `material`
--

CREATE TABLE `lib_material` (
  `material_ID` varchar(64) CHARACTER SET latin1 COLLATE latin1_german1_ci NOT NULL,
  `name` varchar(255) NOT NULL,
  `location` varchar(255) CHARACTER SET latin1 COLLATE latin1_german1_ci NOT NULL,
  `lend` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 = available; 1 = lend'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


--
-- Table structure for table `user`
--

CREATE TABLE `lib_user` (
  `user_ID` int(11) NOT NULL,
  `password` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `forename` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `language` varchar(255) NOT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 = normal USER'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `lib_user` (`user_ID`, `password`, `surname`, `forename`, `email`, `language`, `admin`) VALUES
(1, '44d9dbb60b6c2c24922cd62d249412f9', 'Li', 'Mohamed', 'admin@test.com', 'english', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `books`
--
ALTER TABLE `lib_books`
  ADD PRIMARY KEY (`book_ID`),
  ADD UNIQUE KEY `book_ID` (`book_ID`),;

--
-- Indexes for table `lend`
--
ALTER TABLE `lib_lend`
  ADD PRIMARY KEY (`lend_ID`);

--
-- Indexes for table `log`
--
ALTER TABLE `lib_log`
  ADD PRIMARY KEY (`issue`);

--
-- Indexes for table `user`
--
ALTER TABLE `lib_user`
  ADD PRIMARY KEY (`user_ID`),
  ADD UNIQUE KEY `ID` (`user_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--

-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `lib_user`
  MODIFY `user_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
