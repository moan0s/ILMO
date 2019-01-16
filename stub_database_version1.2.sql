
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;



CREATE TABLE `lib_books` (
  `book_ID` varchar(64) CHARACTER SET latin1 COLLATE latin1_german1_ci NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `location` varchar(255) CHARACTER SET latin1 COLLATE latin1_german1_ci NOT NULL,
  `lent` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 = available; 1 = lend'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `lib_loan` (
  `loan_ID` int(11) NOT NULL,
  `type` varchar(255) COLLATE latin1_german1_ci NOT NULL,
  `ID` text COLLATE latin1_german1_ci NOT NULL,
  `user_ID` int(11) NOT NULL,
  `pickup_date` date NOT NULL,
  `return_date` date DEFAULT NULL,
  `returned` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 = not returned; 1 = returned',
  `last_reminder` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;


CREATE TABLE `lib_log` (
  `issue` varchar(255) COLLATE latin1_german1_ci NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;



INSERT INTO `lib_log` (`issue`, `date`) VALUES
('mail', '2019-01-16');


CREATE TABLE `lib_material` (
  `material_ID` varchar(64) CHARACTER SET latin1 COLLATE latin1_german1_ci NOT NULL,
  `name` varchar(255) NOT NULL,
  `location` varchar(255) CHARACTER SET latin1 COLLATE latin1_german1_ci NOT NULL,
  `lent` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 = available; 1 = lend'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `lib_open` (
  `day` varchar(255) COLLATE latin1_german1_ci NOT NULL,
  `start` varchar(255) COLLATE latin1_german1_ci NOT NULL,
  `end` varchar(255) COLLATE latin1_german1_ci NOT NULL,
  `notice` text COLLATE latin1_german1_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;


CREATE TABLE `lib_presence` (
  `presence_ID` int(11) NOT NULL,
  `UID` varchar(255) COLLATE latin1_german1_ci NOT NULL,
  `checkin_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `checkout_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;



CREATE TABLE `lib_user` (
  `user_ID` int(11) NOT NULL,
  `password` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `forename` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `language` varchar(255) NOT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 = normal USER',
  `UID` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `lib_books`
  ADD PRIMARY KEY (`book_ID`),
  ADD UNIQUE KEY `book_ID` (`book_ID`);

ALTER TABLE `lib_loan`
  ADD PRIMARY KEY (`loan_ID`);


ALTER TABLE `lib_log`
  ADD PRIMARY KEY (`issue`);


ALTER TABLE `lib_material`
  ADD PRIMARY KEY (`material_ID`);


ALTER TABLE `lib_presence`
  ADD PRIMARY KEY (`presence_ID`);


ALTER TABLE `lib_user`
  ADD PRIMARY KEY (`user_ID`),
  ADD UNIQUE KEY `ID` (`user_ID`),
  ADD UNIQUE KEY `UID` (`UID`);


ALTER TABLE `lib_loan`
  MODIFY `loan_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE `lib_presence`
  MODIFY `presence_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE `lib_user`
  MODIFY `user_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
