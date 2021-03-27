-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 27, 2021 at 11:00 PM
-- Server version: 10.1.28-MariaDB
-- PHP Version: 7.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `thephpguestbook`
--

-- --------------------------------------------------------

--
-- Table structure for table `forum`
--

CREATE TABLE `forum` (
  `dfilename` varchar(75) NOT NULL DEFAULT '',
  `ip` varchar(46) NOT NULL DEFAULT '',
  `name` varchar(50) NOT NULL DEFAULT '',
  `email` varchar(254) NOT NULL DEFAULT '',
  `location` varchar(50) NOT NULL DEFAULT '',
  `topic` varchar(75) NOT NULL DEFAULT '',
  `comments` text NOT NULL,
  `my_parent` int(11) NOT NULL DEFAULT '0',
  `timestamp` varchar(10) NOT NULL DEFAULT '',
  `url` varchar(254) NOT NULL,
  `viewable` int(11) NOT NULL DEFAULT '1',
  `rating` int(11) NOT NULL DEFAULT '100',
  `views` int(11) NOT NULL DEFAULT '1',
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `forum`
--

INSERT INTO `forum` (`dfilename`, `ip`, `name`, `email`, `location`, `topic`, `comments`, `my_parent`, `timestamp`, `url`, `viewable`, `rating`, `views`, `id`) VALUES
('guestbook', '::1', 'Samekhi', '1@1.com', 'USA', 'PHP Guestbook', 'PHP Guestbook<BR>\r\nWelcome to the MYSQL PDO PHP Guestbook, the Freedom of Speech Platform!<BR>This content could be either your HTML content or a selected postID?', 0, '1616813526', 'https://www.php-guestbook.com/', 1, 100, 2, 1),
('demo', '::1', 'Tom', '1@1.com', 'USA', 'Webpage about a Demo', 'Testing the Demo Webpage. the dfilename comes from the directory name aka demo, \r\nwhatever directory name you use becomes the new dfilename aka category . \r\nSo each directory functions as it&#039;s own webpage with comments \r\n&amp; comment threads relating to the topic.', 0, '1616882206', '', 1, 100, 2, 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `forum`
--
ALTER TABLE `forum`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dfilename` (`dfilename`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
