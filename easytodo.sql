-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 20, 2020 at 08:31 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `easytodo`
--

-- --------------------------------------------------------

--
-- Table structure for table `task`
--

CREATE TABLE `task` (
  `t_id` int(11) NOT NULL,
  `t_name` varchar(255) COLLATE utf8_bin NOT NULL,
  `t_date` varchar(255) COLLATE utf8_bin NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `task`
--

INSERT INTO `task` (`t_id`, `t_name`, `t_date`, `user_id`) VALUES
(16, 'hello world 2', 'Sunday 29th  March 2020 01:58:47 AM', 0),
(17, 'last todo for today', 'Monday 30th  March 2020 01:58:34 AM', 0),
(18, 'lets do party tonight', 'Monday 30th  March 2020 02:11:27 AM', 0),
(20, 'lets do party tomorrow', 'Monday 30th  March 2020 02:17:35 AM', 0),
(21, 'adfjaklj', 'Monday 30th  March 2020 02:48:22 AM', 0),
(22, 'learning php', 'Tuesday 31st  March 2020 06:14:41 PM', 0),
(23, 'bijoy goru', 'Monday 13th  April 2020 01:53:08 AM', 0),
(24, 'updating my todo bbbbbb', 'Monday 13th  April 2020 02:42:33 AM', 4),
(25, 'adding a new todo ', 'Monday 13th  April 2020 02:45:20 AM', 4),
(27, 'last todo for today', 'Monday 13th  April 2020 02:57:51 AM', 5),
(28, 'lets do party tonight', 'Monday 13th  April 2020 02:57:58 AM', 5);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `u_id` int(11) NOT NULL,
  `u_name` varchar(100) COLLATE utf8_bin NOT NULL,
  `u_email` varchar(200) COLLATE utf8_bin NOT NULL,
  `u_verified` tinyint(4) NOT NULL,
  `u_token` varchar(100) COLLATE utf8_bin NOT NULL,
  `u_password` varchar(255) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`u_id`, `u_name`, `u_email`, `u_verified`, `u_token`, `u_password`) VALUES
(1, 'abul', 'abul@gmail.com', 0, '8c9e73933b5230d5dfe4f82c9d9e869a1f8f0996594d65c43c4b431bc596b10788a7d6b0601ec4f4cb9df5162e73e781091d', '$2y$10$Hau02LUg0Y3lUat60IQQI.0/iblNqJtFoA4yKE2HPIGNY7xq0fGPi'),
(2, 'bijoy', 'bijoy@gmail.com', 0, 'a8a3e2390ad157a588df1f8236c0f315b667d0098b4bc06496574e68a9cd96e55a9187d0f271b321d58209e293385f0fde86', '$2y$10$Dltzqd/2VweiA8EUWaIiT.jgglvi4wJdMfXV2g6bKjkFincJuzcUW'),
(5, 'bithe', 'farzana.hossain5@gmail.com', 0, '17450bb8b9ef33cc98948c886a005a76757027220ad5199345e749c2717daeeb992bd045a9aff424e511759eef596e587f48', '$2y$10$0/6ynmWDkQsXRxWX0gGlheiEvpe9U3YtqIsMwN9drUCvjWcpBetpC'),
(14, 'bijoy', 'bijoycse2014@gmail.com', 1, 'df13398297e13d2589f8974962f98c6e43237bd9c4bd90cf4166d888ed30186a79405513b94e7989fd5d8c3f63a7d9ecdb25', '$2y$10$KhExAAWLgurSQDvNHy4HQu.ZFyP8JFvTwad8TFGQVSp6XPtojbYRy');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `task`
--
ALTER TABLE `task`
  ADD PRIMARY KEY (`t_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`u_id`),
  ADD UNIQUE KEY `u_email` (`u_email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `task`
--
ALTER TABLE `task`
  MODIFY `t_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `u_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
