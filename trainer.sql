-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 10, 2019 at 03:42 PM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `trainer`
--

-- --------------------------------------------------------

--
-- Table structure for table `branches`
--

CREATE TABLE `branches` (
  `id` varchar(8) NOT NULL,
  `synced` int(1) NOT NULL DEFAULT '0',
  `removed` int(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` varchar(8) NOT NULL,
  `name` text NOT NULL,
  `location` text NOT NULL,
  `admin_user_id` varchar(8) NOT NULL,
  `type` text NOT NULL,
  `mobile` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `branches`
--

INSERT INTO `branches` (`id`, `synced`, `removed`, `created_at`, `user_id`, `name`, `location`, `admin_user_id`, `type`, `mobile`) VALUES
('gPzF2zAN', 0, 0, '2019-07-03 06:16:52', 'KtSkLX0t', 'Zsb60/BS/xgJR7lkCNpgNh+RTfcMVwPKHwjTOCnDxMs=', 'UKOGphqKQqZ00jLogXD5E+0Y760FHGO8t+vmtZjTHvRA1Z+mmHlT4eUJZ1sTt+dtEKvSgKyiKMcRDHJY0OAnMQ==', 'KtSkLX0t', 'e6fIRX0R9nYxAYYiJSd9Dw==', 'sWSlaZA0QlIwjM05oj3fqApVfWI7PMRRNzjPDrUmCg4=');

-- --------------------------------------------------------

--
-- Table structure for table `certificates`
--

CREATE TABLE `certificates` (
  `id` varchar(8) NOT NULL,
  `synced` int(1) NOT NULL DEFAULT '0',
  `removed` int(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` varchar(8) NOT NULL,
  `course_id` varchar(8) NOT NULL,
  `staff_id` varchar(8) NOT NULL,
  `rewards` text NOT NULL,
  `paid` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` varchar(8) NOT NULL,
  `synced` int(1) NOT NULL DEFAULT '0',
  `removed` int(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` varchar(8) NOT NULL,
  `type` text NOT NULL,
  `start_date` text NOT NULL,
  `end_date` text NOT NULL,
  `price` text NOT NULL,
  `name` text NOT NULL,
  `course_var_id` text NOT NULL,
  `rewards` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` varchar(8) NOT NULL,
  `synced` int(1) NOT NULL DEFAULT '0',
  `removed` int(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` varchar(8) NOT NULL,
  `name` text NOT NULL,
  `roles` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `synced`, `removed`, `created_at`, `user_id`, `name`, `roles`) VALUES
('j4PG751f', 0, 0, '2019-08-14 10:32:20', 'KtSkLX0t', 'jERo6rVio283o7R8HJfB2w==', 'n2XPmfpAPxrU8E2bs5M3Ug==');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `id` varchar(8) NOT NULL,
  `synced` int(1) NOT NULL DEFAULT '0',
  `removed` int(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` varchar(8) NOT NULL,
  `name` text NOT NULL,
  `country` text NOT NULL,
  `city` text NOT NULL,
  `address` text NOT NULL,
  `gender` text NOT NULL,
  `mobile` text NOT NULL,
  `organization` text NOT NULL,
  `nationality` text NOT NULL,
  `job_title` text NOT NULL,
  `religion` text NOT NULL,
  `details` text NOT NULL,
  `type` text NOT NULL,
  `birthdate` text NOT NULL,
  `email` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` varchar(8) NOT NULL,
  `synced` int(1) NOT NULL DEFAULT '0',
  `removed` int(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` varchar(8) NOT NULL,
  `name` text NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `activated` int(1) NOT NULL DEFAULT '0',
  `roles_id` varchar(8) NOT NULL,
  `job_title` text NOT NULL,
  `branch_id` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `synced`, `removed`, `created_at`, `user_id`, `name`, `email`, `password`, `activated`, `roles_id`, `job_title`, `branch_id`) VALUES
('2pvGEuk4', 0, 0, '2019-08-14 10:42:19', 'KtSkLX0t', '58zWZbhk4keTwPgjNoXpPxaQXGaV051jEZKwGOyYbMUZxVPfiG7tKZ4GjnTTvjmA', 'iS/ZMX95QwBCVYpo2DB/0JMhGGU8WE8vICAmrsfUnrE=', 'xXE1Zyzak5/bomHZmEl0Mw==', 0, 'j4PG751f', '', 'gPzF2zAN'),
('KtSkLX0t', 0, 0, '2019-08-14 10:31:08', 'KtSkLX0t', 'MYstjCT4WS0KyKaio9Xdc+Lh57escvbzKSOXnLZHkxE=', '8yE2DdWQwunLywEnB2iDXxGj3WgghMogIUK3O34iZgU=', 'xXE1Zyzak5/bomHZmEl0Mw==', 1, 'j4PG751f', '', 'gPzF2zAN');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `branches`
--
ALTER TABLE `branches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `certificates`
--
ALTER TABLE `certificates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
