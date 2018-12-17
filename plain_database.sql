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



CREATE TABLE `bib_books` (
  `book_ID` varchar(64) CHARACTER SET latin1 COLLATE latin1_german1_ci NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `location` varchar(255) CHARACTER SET latin1 COLLATE latin1_german1_ci NOT NULL,
  `lend` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 = available; 1 = lend'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `bib_stuff` (
  `stuff_ID` varchar(64) CHARACTER SET latin1 COLLATE latin1_german1_ci NOT NULL,
  `name` varchar(255) NOT NULL,
  `location` varchar(255) CHARACTER SET latin1 COLLATE latin1_german1_ci NOT NULL,
  `lend` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 = available; 1 = lend'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `bib_lend` (
  `lend_ID` int(11) NOT NULL,
  `type` varchar NOT NULL,
  `ID` text COLLATE latin1_german1_ci NOT NULL,
  `user_ID` int(11) NOT NULL,
  `pickup_date` date NOT NULL,
  `return_date` date DEFAULT NULL,
  `returned` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 = not returned; 1 = returned',
  `last_mail_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;


CREATE TABLE `bib_open` (
  `day` varchar(255) COLLATE latin1_german1_ci NOT NULL,
  `start` varchar(255) COLLATE latin1_german1_ci NOT NULL,
  `end` varchar(255) COLLATE latin1_german1_ci NOT NULL,
  `notice` text COLLATE latin1_german1_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;



CREATE TABLE `bib_user` (
  `user_ID` int(11) NOT NULL,
  `password` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `forename` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `language` varchar(255) NOT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 = normal USER'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `bib_log` (
  `issue` varchar(255) NOT NULL
  `date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `bib_books`
  ADD PRIMARY KEY (`book_ID`),
  ADD UNIQUE KEY `book_ID` (`book_ID`),
  ADD KEY `book_ID_2` (`book_ID`);


ALTER TABLE `bib_lend`
  ADD PRIMARY KEY (`lend_ID`),
  ADD KEY `lending_ID` (`lend_ID`);


ALTER TABLE `bib_user`
  ADD PRIMARY KEY (`user_ID`),
  ADD UNIQUE KEY `ID` (`user_ID`),
  ADD KEY `ID_2` (`user_ID`);


ALTER TABLE `bib_lend`
  MODIFY `lend_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE `bib_user`
  MODIFY `user_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
