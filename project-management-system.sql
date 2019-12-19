-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 19, 2019 at 06:06 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project-management-system`
--

-- --------------------------------------------------------

--
-- Table structure for table `deliverables`
--

CREATE TABLE `deliverables` (
  `id` int(11) NOT NULL,
  `project-id` int(11) NOT NULL,
  `title` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `deliverables`
--

INSERT INTO `deliverables` (`id`, `project-id`, `title`) VALUES
(1, 1, 'Software application'),
(2, 1, 'Training plan');

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE `member` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`id`, `name`) VALUES
(1, 'Sara Samer'),
(2, 'Ahmed Wessam');

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

CREATE TABLE `project` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_bin NOT NULL,
  `hours-per-day` int(11) NOT NULL,
  `cost` double NOT NULL,
  `start-date` date NOT NULL,
  `end-date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `project`
--

INSERT INTO `project` (`id`, `name`, `hours-per-day`, `cost`, `start-date`, `end-date`) VALUES
(1, 'Project 1', 8, 500000000, '2019-12-24', '2019-12-30');

-- --------------------------------------------------------

--
-- Table structure for table `project-managers`
--

CREATE TABLE `project-managers` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_bin NOT NULL,
  `username` varchar(50) COLLATE utf8_bin NOT NULL,
  `password` varchar(50) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `project-member-titles`
--

CREATE TABLE `project-member-titles` (
  `project-id` int(11) NOT NULL,
  `member-id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `task`
--

CREATE TABLE `task` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_bin NOT NULL,
  `start-date` date NOT NULL,
  `end-date` date NOT NULL,
  `working-hours` int(11) NOT NULL DEFAULT 0,
  `parent-task-id` int(11) DEFAULT NULL,
  `is-complete` tinyint(1) NOT NULL DEFAULT 0,
  `actual-working-hours` int(11) NOT NULL DEFAULT 0,
  `is-milestone` tinyint(1) NOT NULL DEFAULT 0,
  `project-id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `task`
--

INSERT INTO `task` (`id`, `name`, `start-date`, `end-date`, `working-hours`, `parent-task-id`, `is-complete`, `actual-working-hours`, `is-milestone`, `project-id`) VALUES
(1, 'Task A', '2019-12-19', '2019-12-19', 20, 1, 1, 50, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `task-dependency`
--

CREATE TABLE `task-dependency` (
  `main-task` int(11) NOT NULL,
  `dependent-task` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `task-members`
--

CREATE TABLE `task-members` (
  `task-id` int(11) NOT NULL,
  `member-id` int(11) NOT NULL,
  `working-hours` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `task-members`
--

INSERT INTO `task-members` (`task-id`, `member-id`, `working-hours`) VALUES
(1, 1, 10),
(1, 2, 20);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `deliverables`
--
ALTER TABLE `deliverables`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pid-delivery` (`project-id`);

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `project`
--
ALTER TABLE `project`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `project-managers`
--
ALTER TABLE `project-managers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `project-member-titles`
--
ALTER TABLE `project-member-titles`
  ADD KEY `member-id-title` (`member-id`),
  ADD KEY `project-id-title` (`project-id`);

--
-- Indexes for table `task`
--
ALTER TABLE `task`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pid` (`project-id`);

--
-- Indexes for table `task-dependency`
--
ALTER TABLE `task-dependency`
  ADD PRIMARY KEY (`main-task`,`dependent-task`),
  ADD KEY `dependent-task-id` (`dependent-task`);

--
-- Indexes for table `task-members`
--
ALTER TABLE `task-members`
  ADD KEY `task-id` (`task-id`),
  ADD KEY `member-id` (`member-id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `deliverables`
--
ALTER TABLE `deliverables`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `project`
--
ALTER TABLE `project`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `project-managers`
--
ALTER TABLE `project-managers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `task`
--
ALTER TABLE `task`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `deliverables`
--
ALTER TABLE `deliverables`
  ADD CONSTRAINT `pid-delivery` FOREIGN KEY (`project-id`) REFERENCES `project` (`id`);

--
-- Constraints for table `project-member-titles`
--
ALTER TABLE `project-member-titles`
  ADD CONSTRAINT `member-id-title` FOREIGN KEY (`member-id`) REFERENCES `member` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `project-id-title` FOREIGN KEY (`project-id`) REFERENCES `project` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `task`
--
ALTER TABLE `task`
  ADD CONSTRAINT `pid` FOREIGN KEY (`project-id`) REFERENCES `project` (`id`);

--
-- Constraints for table `task-dependency`
--
ALTER TABLE `task-dependency`
  ADD CONSTRAINT `dependent-task-id` FOREIGN KEY (`dependent-task`) REFERENCES `task` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `main-task-id` FOREIGN KEY (`main-task`) REFERENCES `task` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `task-members`
--
ALTER TABLE `task-members`
  ADD CONSTRAINT `member-id` FOREIGN KEY (`member-id`) REFERENCES `member` (`id`),
  ADD CONSTRAINT `task-id` FOREIGN KEY (`task-id`) REFERENCES `task` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
