-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 15, 2019 at 10:40 AM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.3.8

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
  `synced` int(1) NOT NULL DEFAULT 0,
  `removed` int(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
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
  `synced` int(1) NOT NULL DEFAULT 0,
  `removed` int(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
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
  `synced` int(1) NOT NULL DEFAULT 0,
  `removed` int(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` varchar(8) NOT NULL,
  `type` text NOT NULL,
  `start_date` text NOT NULL,
  `end_date` text NOT NULL,
  `price` text NOT NULL,
  `name` text NOT NULL,
  `course_var_id` text NOT NULL,
  `rewards` text NOT NULL,
  `lectures_no` text NOT NULL,
  `lecturer_id` varchar(8) NOT NULL,
  `details` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `synced`, `removed`, `created_at`, `user_id`, `type`, `start_date`, `end_date`, `price`, `name`, `course_var_id`, `rewards`, `lectures_no`, `lecturer_id`, `details`) VALUES
('3bnnHI3t', 0, 0, '2019-09-14 21:11:50', '2pvGEuk4', 'jrRw54t50Wb6KQe5KVXMnw==', 'E7kZ9jRQgwjmgyoVrahYUA==', 'ApCTjYro8Bl1tjyeu13vpQ==', 'CvbGmyRJP66r/sgV4BS2/A==', 'W/SSqnvCEnfG/CiZAEEQHw==', 'KvDr1yNUxTd2RNhBA0C6RA==', 'W/SsbMdG33Z0bAmJNOqbyg==', '5JB1l/ZFqIrTvc5+UQ/YMw==', 'NYRoFayM', 'W/SsbMdG33Z0bAmJNOqbyg=='),
('5TXwFJgG', 0, 0, '2019-09-14 16:03:21', 'KtSkLX0t', 'Ar1RFQeC57g9QWU1jrR01Q==', 'E7kZ9jRQgwjmgyoVrahYUA==', 'a6FDrRjT/AAoVLcqIPGmWg==', 'f8NV9YsJ4lfWYRoGsykM2Q==', 'V97VVCCEiQLnLuZ7MPlVhTjYK4WHRE9NEbC80ntvicXmSlDuHtSgyjg3ixGyVhqvI369kflKLWOPMvgbJhVqfw==', 'AMzphnh/JHY8SG0jW8Bkfg==', '2x1dpvAa/SmOE6Wwz7yK1w==', 'mWnn3buZX5u5fmQc/huvpg==', 'NYRoFayM', 'jD2J+9QowaLbb7XeH0Z2QA=='),
('666t8TFk', 0, 0, '2019-09-14 21:17:12', 'KtSkLX0t', 'odhSzyQTyN2tsKdch4Gwaw==', 'BQbRrcdwAqLhmgY/uVJCVA==', 'd/vrhAIrGadkR5cZHrE+Ww==', 'CvbGmyRJP66r/sgV4BS2/A==', 'KvDr1yNUxTd2RNhBA0C6RA==', 'QhJpEvGbpglI1ycPIqEJpg==', 'CvbGmyRJP66r/sgV4BS2/A==', 'Pf6DxgnTpjmVAkBDBrKPBQ==', 'NYRoFayM', 'CvbGmyRJP66r/sgV4BS2/A=='),
('VTCzaiwL', 0, 0, '2019-09-14 20:50:30', 'KtSkLX0t', 'jrRw54t50Wb6KQe5KVXMnw==', '+1HD08vB0WM8K6tHfchjLQ==', 'E7kZ9jRQgwjmgyoVrahYUA==', '9XDz0Zw10FsdrIWpQoPCRw==', 'JbHzW7V9l5b531WoiG96SpeyjbcV8gWDEHNbGovOiqG9PFbUjA4Rcrgc0jLFd5H8', 'rgKjjEseR+EWCHYotanUeg==', 'Pf6DxgnTpjmVAkBDBrKPBQ==', 'Pf6DxgnTpjmVAkBDBrKPBQ==', 'NYRoFayM', 'QJh0P3AKqLlKdswLDKeIcw==');

-- --------------------------------------------------------

--
-- Table structure for table `registrants`
--

CREATE TABLE `registrants` (
  `id` varchar(8) NOT NULL,
  `synced` int(1) NOT NULL DEFAULT 0,
  `removed` int(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` varchar(8) NOT NULL,
  `staff_id` varchar(8) NOT NULL,
  `course_id` varchar(8) NOT NULL,
  `payment` text NOT NULL,
  `acceptance` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `registrants`
--

INSERT INTO `registrants` (`id`, `synced`, `removed`, `created_at`, `user_id`, `staff_id`, `course_id`, `payment`, `acceptance`) VALUES
('LEpJotUB', 0, 0, '2019-09-14 19:20:17', 'KtSkLX0t', '6io8F7Td', '5TXwFJgG', 'iVouTze9JhaVXC/580533Q==', 'c7z76h8Awcl2ckRIArcdcw=='),
('S6HC5mUV', 0, 1, '2019-09-14 20:53:22', 'KtSkLX0t', '6io8F7Td', 'VTCzaiwL', 'LSqxAOKrPCdNlazBZ90s2w==', 'r5MQAJW8RZGx07xBMxaiqg=='),
('X2d8C563', 0, 0, '2019-09-14 20:55:09', 'KtSkLX0t', '6io8F7Td', 'VTCzaiwL', 'iVouTze9JhaVXC/580533Q==', 'r5MQAJW8RZGx07xBMxaiqg=='),
('xUet95Op', 0, 0, '2019-09-14 20:37:44', 'KtSkLX0t', 'NV17nHFw', '5TXwFJgG', 'iVouTze9JhaVXC/580533Q==', 'E8Km7XTrmD7SngiuqRU+xA=='),
('ZK5mtgdI', 0, 1, '2019-09-14 19:18:58', 'KtSkLX0t', '6io8F7Td', '5TXwFJgG', 'LSqxAOKrPCdNlazBZ90s2w==', 'r5MQAJW8RZGx07xBMxaiqg==');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` varchar(8) NOT NULL,
  `synced` int(1) NOT NULL DEFAULT 0,
  `removed` int(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` varchar(8) NOT NULL,
  `name` text NOT NULL,
  `roles` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `synced`, `removed`, `created_at`, `user_id`, `name`, `roles`) VALUES
('j4PG751f', 0, 0, '2019-08-14 10:32:20', 'KtSkLX0t', 'jERo6rVio283o7R8HJfB2w==', 'n2XPmfpAPxrU8E2bs5M3Ug=='),
('sQBcF8B0', 0, 0, '2019-09-14 21:10:29', 'KtSkLX0t', 'YOraKhBXGpVTph+WjYFlKw==', 'uQ0KLblCt/osRcBd8D+n19liQh/W/jUM6dOYiSGVpsxc/VL4Cf9sm0U6CKVX/BJ5');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `id` varchar(8) NOT NULL,
  `synced` int(1) NOT NULL DEFAULT 0,
  `removed` int(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
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

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`id`, `synced`, `removed`, `created_at`, `user_id`, `name`, `country`, `city`, `address`, `gender`, `mobile`, `organization`, `nationality`, `job_title`, `religion`, `details`, `type`, `birthdate`, `email`) VALUES
('6io8F7Td', 0, 0, '2019-09-12 20:09:46', 'KtSkLX0t', 'kVCggLa3ok3lbHhuARk7nt4CsYldQTk1++tlAByE8ac=', 'BL9L2g/7CHwa4Uupeis/KA==', 'BvbIJ3EddpqouXzG4OPsqw==', 'Tg+qvb8PLOuumYalG5vjZFUwZBrdYHWih4xBkO+sv6o=', 'EEF+EVQ+bCvKOEm0vp19yg==', 'IiNANnMv6UZ48dGIdXOSxQ==', '7PkI3pIQuIoB6DQmFMK+SgEXvNeZ1LdVCFyQwI3YAyp75cAPyM4SlxFi8IF7ftpd', 'zGruDoyLTGovxkMf3rVYuw==', 'AnIzGe7jlFnhUz2cGQDHUA==', 'eIOCERipyICMIdhZ5pp04w==', 'Gqm/7TM8fRypg4Nd8Rg5iQ==', 'YV6VI2PorXsr4Z3eLt/PIg==', 'Uo1/v4NQUdUBHCczsRbt0g==', '8yE2DdWQwunLywEnB2iDXxGj3WgghMogIUK3O34iZgU='),
('lvOGRo3I', 0, 1, '2019-09-12 20:12:03', 'KtSkLX0t', 'hul6FVLVFmWr7a/uNoz9Ng==', 'QJh0P3AKqLlKdswLDKeIcw==', 'QJh0P3AKqLlKdswLDKeIcw==', 'QJh0P3AKqLlKdswLDKeIcw==', 'QJh0P3AKqLlKdswLDKeIcw==', 'pvDyvEv9seceHHdVODC9Zw==', 'QJh0P3AKqLlKdswLDKeIcw==', 'QJh0P3AKqLlKdswLDKeIcw==', 'QJh0P3AKqLlKdswLDKeIcw==', 'QJh0P3AKqLlKdswLDKeIcw==', 'QJh0P3AKqLlKdswLDKeIcw==', 'YV6VI2PorXsr4Z3eLt/PIg==', 'QJh0P3AKqLlKdswLDKeIcw==', 'QJh0P3AKqLlKdswLDKeIcw=='),
('NV17nHFw', 0, 0, '2019-09-14 20:37:02', 'KtSkLX0t', 'zW+nU00WWRdcd48Db5HAlyGydvdXPKxXHqi/65x/Zz4=', 'QJh0P3AKqLlKdswLDKeIcw==', 'QJh0P3AKqLlKdswLDKeIcw==', 'QJh0P3AKqLlKdswLDKeIcw==', 'QJh0P3AKqLlKdswLDKeIcw==', 'Kauot8+PYNvpkZJIBIwf2A==', 'QJh0P3AKqLlKdswLDKeIcw==', 'QJh0P3AKqLlKdswLDKeIcw==', 'QJh0P3AKqLlKdswLDKeIcw==', 'QJh0P3AKqLlKdswLDKeIcw==', 'QJh0P3AKqLlKdswLDKeIcw==', 'YV6VI2PorXsr4Z3eLt/PIg==', 'QJh0P3AKqLlKdswLDKeIcw==', 'QJh0P3AKqLlKdswLDKeIcw=='),
('NYRoFayM', 0, 0, '2019-09-14 15:05:49', 'KtSkLX0t', 'MHhmGyzkpx0Gwd2u7o63BCaZet4pfWTEaIWp6KIiaPA=', 'BL9L2g/7CHwa4Uupeis/KA==', 'EEGYiEPV1W880JdUp1wfdw==', 'pGXs0Y/tXhjB/i0FFgtPyA==', 'EEF+EVQ+bCvKOEm0vp19yg==', 'IiNANnMv6UZ48dGIdXOSxQ==', '8k4jzp0DxJ+iYtWDliY8yCxVZTsCggmeftItFmT6/J8=', 'zGruDoyLTGovxkMf3rVYuw==', '8MXsxhJvm1+FSlQRLjHAeQ==', 'eIOCERipyICMIdhZ5pp04w==', 'Gqm/7TM8fRypg4Nd8Rg5iQ==', '3NtQKczR2M2BkhQr6+Tp9w==', 'YcTP1ZHRnQPRakSYW9wnVQ==', 'LA6off+4SAq5A1NTVkSfHCZLNgOyYQJrWOnICoJD0to=');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` varchar(8) NOT NULL,
  `synced` int(1) NOT NULL DEFAULT 0,
  `removed` int(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` varchar(8) NOT NULL,
  `name` text NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `activated` int(1) NOT NULL DEFAULT 0,
  `roles_id` varchar(8) NOT NULL,
  `job_title` text NOT NULL,
  `branch_id` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `synced`, `removed`, `created_at`, `user_id`, `name`, `email`, `password`, `activated`, `roles_id`, `job_title`, `branch_id`) VALUES
('2pvGEuk4', 0, 0, '2019-08-14 10:42:19', 'KtSkLX0t', '58zWZbhk4keTwPgjNoXpPxaQXGaV051jEZKwGOyYbMUZxVPfiG7tKZ4GjnTTvjmA', '/66qQmDMSxXxkwnYNIyTS6mbaeKzwv6wgXOByNiCHHI=', 'xXE1Zyzak5/bomHZmEl0Mw==', 1, 'sQBcF8B0', '', 'gPzF2zAN'),
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
-- Indexes for table `registrants`
--
ALTER TABLE `registrants`
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
