-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3307
-- Generation Time: Nov 18, 2018 at 12:02 AM
-- Server version: 5.7.24
-- PHP Version: 7.1.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00"; 


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `loginsystem`
--

-- --------------------------------------------------------

create schema loginsystem;
use loginsystem;

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `cat_id` int(8) NOT NULL,
  `cat_name` varchar(255) NOT NULL,
  `cat_description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`cat_id`, `cat_name`, `cat_description`) VALUES
(1, 'category 1', 'this is a test category'),
(2, 'category 2', 'this is another test category'),
(3, 'computer', 'this is a category related to computer sciences fields and related questions as well as a discussion forum'),
(4, 'finance sciences', 'all topics related to finance and economy like making double decker chocolate cake and how to end the world in 3 days'),
(5, 'gardening', 'different gardening techniques used to torture helpless victims and make them dream of attending horrible opera performances'),
(6, 'a', 'aa'),
(7, 'hooooola', 'yea hoooooooooooooooo');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `post_id` int(8) NOT NULL,
  `post_content` text NOT NULL,
  `post_date` datetime NOT NULL,
  `post_topic` int(8) NOT NULL,
  `post_by` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`post_id`, `post_content`, `post_date`, `post_topic`, `post_by`) VALUES
(16, 'aaaaaaaaa', '2018-11-18 10:48:26', 30, 24),
(17, 'how can i destroy the world in 3 days?', '2018-11-18 11:13:00', 31, 24),
(18, 'aa', '2018-11-18 11:22:59', 32, 24),
(19, 'xxxxxxxxxx', '2018-11-18 11:29:41', 33, 24),
(20, 'aaaa ', '2018-11-18 12:35:39', 31, 24),
(21, 'idk how to do this', '2018-11-18 12:36:21', 31, 24),
(22, 'idk how to do this', '2018-11-18 12:39:51', 31, 24),
(23, 'idk how to do this', '2018-11-18 12:40:03', 31, 24),
(24, 'hello', '2018-11-18 12:40:37', 31, 24),
(25, 'can i help u', '2018-11-18 12:41:10', 31, 24),
(26, 'go to hrll', '2018-11-18 12:44:55', 31, 24),
(27, 'um are u guys for real?', '2018-11-18 12:46:31', 31, 24),
(28, 'please just go away', '2018-11-18 12:48:12', 31, 24),
(29, 'please just go away', '2018-11-18 12:49:56', 31, 24),
(30, 'please just go away', '2018-11-18 12:51:18', 31, 24),
(31, 'please just go away', '2018-11-18 12:51:57', 31, 24),
(32, 'please just go away', '2018-11-18 12:52:13', 31, 24),
(33, 'go away\r\n', '2018-11-18 12:59:25', 31, 25);

-- --------------------------------------------------------

--
-- Table structure for table `topics`
--

CREATE TABLE `topics` (
  `topic_id` int(8) NOT NULL,
  `topic_subject` varchar(255) NOT NULL,
  `topic_date` datetime NOT NULL,
  `topic_cat` int(8) NOT NULL,
  `topic_by` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `topics`
--

INSERT INTO `topics` (`topic_id`, `topic_subject`, `topic_date`, `topic_cat`, `topic_by`) VALUES
(29, 'testint testing123', '2018-11-18 10:46:58', 6, 24),
(30, 'aaaaaaa', '2018-11-18 10:48:26', 6, 24),
(31, 'how to plant a nuclear bomb', '2018-11-18 11:13:00', 5, 24),
(32, 'a', '2018-11-18 11:22:59', 5, 24),
(33, 'aaaa', '2018-11-18 11:29:41', 1, 24);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `idUsers` int(11) NOT NULL,
  `userLevel` int(11) NOT NULL DEFAULT '0',
  `f_name` varchar(50) NOT NULL,
  `l_name` varchar(50) NOT NULL,
  `uidUsers` tinytext NOT NULL,
  `emailUsers` tinytext NOT NULL,
  `pwdUsers` longtext NOT NULL,
  `gender` char(1) NOT NULL,
  `headline` varchar(40) DEFAULT NULL,
  `bio` varchar(1000) DEFAULT NULL,
  `userImg` varchar(500) DEFAULT 'default.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`idUsers`, `userLevel`, `f_name`, `l_name`, `uidUsers`, `emailUsers`, `pwdUsers`, `gender`, `headline`, `bio`, `userImg`) VALUES
(24, 1, 'Muhammad', 'Saad', 'saad', 'saad@test.com', '$2y$10$vvdlB7AP99fc2kJx.zxnm.neZuNfadqoNwI.RveluFB1TFtsGlasG', 'm', '', '', '5be88033bdc294.35939237.jpg'),
(25, 0, '', '', 'a', 'a@a.a', '$2y$10$RiiU91TqjjVhPdVpypQBtuq0etClplrZ3HNTLPFrUheJ.sy7ZifwK', 'f', '', '', '5bf11a9c7367a8.71588688.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`cat_id`),
  ADD UNIQUE KEY `cat_name_unique` (`cat_name`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `post_topic` (`post_topic`),
  ADD KEY `post_by` (`post_by`);

--
-- Indexes for table `topics`
--
ALTER TABLE `topics`
  ADD PRIMARY KEY (`topic_id`),
  ADD KEY `topic_cat` (`topic_cat`),
  ADD KEY `topic_by` (`topic_by`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`idUsers`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `cat_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `topics`
--
ALTER TABLE `topics`
  MODIFY `topic_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `idUsers` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`post_topic`) REFERENCES `topics` (`topic_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `posts_ibfk_2` FOREIGN KEY (`post_by`) REFERENCES `users` (`idUsers`) ON UPDATE CASCADE;

--
-- Constraints for table `topics`
--
ALTER TABLE `topics`
  ADD CONSTRAINT `topics_ibfk_1` FOREIGN KEY (`topic_cat`) REFERENCES `categories` (`cat_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `topics_ibfk_2` FOREIGN KEY (`topic_by`) REFERENCES `users` (`idUsers`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
