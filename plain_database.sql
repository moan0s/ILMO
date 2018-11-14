da-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: xxx
-- Generation Time: Nov 14, 2018 at 11:39 AM
-- Server version: 5.6.41-log
-- PHP Version: 5.6.38

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


--
-- Database: `xxx`
--

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `book_ID` varchar(64) CHARACTER SET latin1 COLLATE latin1_german1_ci NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `location` varchar(255) CHARACTER SET latin1 COLLATE latin1_german1_ci NOT NULL,
  `lend` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 = available; 1 = lend'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


--
-- Table structure for table `lend`
--

CREATE TABLE `lend` (
  `lend_ID` int(11) NOT NULL,
  `book_ID` text COLLATE latin1_german1_ci NOT NULL,
  `user_ID` int(11) NOT NULL,
  `pickup_date` date NOT NULL,
  `return_date` date DEFAULT NULL,
  `returned` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 = not returned; 1 = returned'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;

--
-- Dumping data for table `lend`
--

INSERT INTO `lend` (`lend_ID`, `book_ID`, `user_ID`, `pickup_date`, `return_date`, `returned`) VALUES
(66, 'B1 b', 1, '2018-10-28', '2018-10-28', 1),
(67, 'B1 b', 32, '2018-10-28', '2018-10-28', 1),
(68, 'B1 b', 32, '2018-10-28', '2018-10-28', 1),
(69, 'B1 b', 19, '2018-10-28', '0000-00-00', 0),
(70, 'B1 b', 19, '2018-10-28', '0000-00-00', 0),
(71, 'B1 b', 19, '2018-10-28', '0000-00-00', 0),
(72, 'B1 b', 19, '2018-10-28', '0000-00-00', 0),
(73, 'B1 b', 19, '2018-10-28', '0000-00-00', 0),
(74, 'B1 b', 1, '2018-10-28', '0000-00-00', 0),
(75, 'B1 b', 1, '2018-10-28', '0000-00-00', 0),
(76, 'B1 b', 1, '2018-10-28', '0000-00-00', 0),
(78, 'B1 b', 32, '2018-10-29', '2018-10-29', 1),
(79, 'a', 1, '2018-10-30', '0000-00-00', 0),
(80, 'B1 b', 1, '2018-10-30', '0000-00-00', 0),
(81, 'H60 a', 1, '2018-10-30', '0000-00-00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `open`
--

CREATE TABLE `open` (
  `day` varchar(255) COLLATE latin1_german1_ci NOT NULL,
  `start` varchar(255) COLLATE latin1_german1_ci NOT NULL,
  `end` varchar(255) COLLATE latin1_german1_ci NOT NULL,
  `notice` text COLLATE latin1_german1_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;


--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_ID` int(11) NOT NULL,
  `password` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `forename` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 = normal USER'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`book_ID`),
  ADD UNIQUE KEY `book_ID` (`book_ID`),
  ADD KEY `book_ID_2` (`book_ID`);

--
-- Indexes for table `lend`
--
ALTER TABLE `lend`
  ADD PRIMARY KEY (`lend_ID`),
  ADD KEY `lending_ID` (`lend_ID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_ID`),
  ADD UNIQUE KEY `ID` (`user_ID`),
  ADD KEY `ID_2` (`user_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `lend`
--
ALTER TABLE `lend`
  MODIFY `lend_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
