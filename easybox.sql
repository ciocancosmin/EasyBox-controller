-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 09, 2020 at 09:32 PM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 7.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `easybox`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `csrf_token` varchar(255) NOT NULL,
  `level` int(11) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `last_login` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `csrf_token`, `level`, `active`, `last_login`) VALUES
(4, 'gicu', '568e4b33bc99549bdf559d27e4354577', 'DRSOGmhSehaFB7CpEPePJS68FeP2Pn', 0, 1, ''),
(5, 'danut', '321eaa3255a65c9137f5293537d4135d', '5CqtIUlOyZcZrOAHJRBbg5Q9mXpOUt', 0, 1, ''),
(6, 'admin', '21396d72f44f88ae325378e743d579f7', 'XZpcoEVcWj5OwABnExHKgN5hRqZMn1', 1, 1, '2020-07-09;18:09;127.0.0.1'),
(7, 'pelemeu', '784273dd98c35e797f2f6471455e1d1b', 'oOCkwdDlCQYMNWvACcxddQXF9A4pxF', 0, 1, ''),
(8, 'qqq', 'f3cd957fa4a46e865c750d076a4f0c82', 'lNlNrKykL2aWxu9dutZfOPCCgSxr1u', 0, 1, ''),
(9, 'qqqq', '8a317aa62b2e6709dcf99b1d94436492', 'L3A8rvVNkTpR8ytr4j56SyKYK4oDqf', 0, 1, ''),
(10, 'tech', 'c1f2cb7182912e587e00cdbf279b2e32', '8DjHIEB2tcK7C6HySJWrsTqm4YCpXM', 2, 1, '2020-07-09;20:13;127.0.0.1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
