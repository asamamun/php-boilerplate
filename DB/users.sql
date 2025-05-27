-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 27, 2025 at 12:08 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `r64_php`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `password` varchar(256) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `role` set('admin','user','superadmin','') NOT NULL DEFAULT 'user',
  `created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `password`, `active`, `role`, `created`) VALUES
(7, 'mamun', 'mamun@gmail.com', '324587654', '$2y$10$7Lf1B8207VRcN2/t/Te4Y.Gu58TUo.JCgr3WmxP.davfpBLjVkq6W', 1, 'user', '2025-05-06 06:12:43'),
(8, 'al imran emon', 'imranemon334@gmail.com', '01567954701', '$2y$10$LH4l0I20FN8pW6M3FEn9EuT5tZjR6ET9tANFSvfKHjt3E4yEau3/2', 1, 'user', '2025-05-06 06:12:45'),
(9, 'Md. Ishaq Hossain', 'ishaqhossain98@gmail.com', '01783629582', '$2y$10$9SUurMmJMlmm.hIp57hUO.tbSkZKpxOdMe5Tn8p9uWiSfLC5jhnPC', 1, 'user', '2025-05-06 06:12:47'),
(10, 'rasibul kabir', 'mdfarhadbhuiyan@yahoo.com', '01728510359', '$2y$10$bZMJZSa/IQEMKkT5vvaNBOnSgVutxqfIRPDpxb4Ojx8M3mHeU..TW', 1, 'user', '2025-05-06 06:12:48'),
(11, 'sume', 'bisew.tahminasumi@gmail.com', '01960474971', '$2y$10$hjyhaIvXbjxA6z1VMZ1bHeRHGIlNTJj/q06isfO1XNEXoE6snoiCy', 1, 'user', '2025-05-06 06:13:08'),
(12, 'abcd', 'abcd@gmail.com', '', '$2y$10$Cqy7XA6Qs9SEkfH.UlhALe.k16qCIlxkbVi6R.v7NgmmkiA7p9uhe', 1, 'user', '2025-05-06 06:13:22'),
(13, 'Muntasir', 'muntasirmahmudcn42@gmail.com', '01794000000', '$2y$10$MlQTB0.0/UZByFvxUGB6O.dVYQxUZWOlCVj6fgL.eji3EhE..8gAW', 1, 'user', '2025-05-06 06:14:08'),
(14, 'Shamima Naznin', 'rune182013@gmail.com', '01776056456', '$2y$10$a4N0j/4.Nety9Q./fXH7sucjmKWd0mX5PCMYZQYF1h5ZK6UewC/pa', 1, 'user', '2025-05-06 06:15:17'),
(15, 'Tony Stark', 'tony@ironman.com', '+852456789123', '$2y$10$7aJlp/91DVer316eOiudJuecIvkz/3eUza3RB7ZYF6pALv61Ged7a', 1, 'user', '2025-05-06 06:15:49'),
(17, 'Abdul Aziz Khan', 'abdulazizkhan.web@gmail.com', '01521557565', '$2y$10$6j3rmTnXV.fyTUptKsOtwO8I.FLpSjHa/PFTbXSz/PCwtzgVD1sc2', 1, 'user', '2025-05-06 06:18:24'),
(20, 'idb bisew', 'idb@gmail.com', '436858765', '$2y$10$2bVCWT3OXC1131/6B/mU8ugKzvGUDsqKq9Uh0cHDNKnpn4NccNoJy', 1, 'user', '2025-05-06 06:46:17'),
(21, 'muntasir_CR7', 'mmsoft@gmail.com', '01700000000', '$2y$10$qI9cQsMgKgPE/7MuaTTfmuJ0kilg8wnlySUt3mCFgs1rjw0eIAj6e', 1, 'user', '2025-05-06 06:48:31'),
(22, 'test5', 'test5@gmail.com', '3456897', '$2y$10$DRnMN5WKJVvju2LoTSaWRe6f34bOK7xeEd6EOb9ZWzVPz0VX98sL2', 1, 'admin', '2025-05-07 04:23:58'),
(23, 'test6', 'test6@gmail.com', '123123123', '$2y$10$qRvLKn3Hw8x3U4FYVeZ6GOy0A207kHAKiVCGMKlHYsdYqhpEWnrBS', 1, 'user', '2025-05-08 04:06:48'),
(24, 'Flash', 'flash@gmail.com', '123456789', '$2y$10$b6tRKQkMYzvVpA7gXzdhMe66T3xidyFEBWvrPcS9btkyWCxTDCuDm', 1, 'user', '2025-05-08 04:51:43'),
(25, 'Charu', 'jhuma@gmail.com', '0177772345', '$2y$10$5I9bXq4hAUH8HeaXQL0R5uMknnz12RM9xazvYhD3T7g/4dG8NJO.q', 1, 'user', '2025-05-08 05:34:55'),
(26, 'rakib', 'rakib@gmail.com', '012000000', '$2y$10$U1FXhpMtUZYmLL8aFmjoy.F9zNJCCS0vHXkqcKi.6/EQ8lG3FK9CW', 1, 'user', '2025-05-08 05:37:55'),
(27, 'Al Imran Emon', 'imran@hotmail.com', '124578', '$2y$10$aWdSoNszt.5ZyoyvZZHqu.Qfb84Wa7j5DpdTWl8fBmuxp00DadI3u', 1, 'user', '2025-05-08 05:43:48'),
(28, 'John Doe', 'Tb1bH@example.com', '1234567890', 'password', 1, 'user', '2025-05-10 04:04:29');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `phone` (`phone`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
