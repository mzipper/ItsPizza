-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 24, 2021 at 12:49 AM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 8.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbrestaurant`
--
CREATE DATABASE IF NOT EXISTS `dbrestaurant` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `dbrestaurant`;

-- --------------------------------------------------------

--
-- Table structure for table `authorizedusers`
--

CREATE TABLE `authorizedusers` (
  `AuthorizedUsersID` int(11) NOT NULL,
  `Name` varchar(100) DEFAULT NULL,
  `Username` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Role` enum('administrator','regularUser','guest','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `authorizedusers`
--

INSERT INTO `authorizedusers` (`AuthorizedUsersID`, `Name`, `Username`, `Password`, `Role`) VALUES
(1, NULL, 'user', '123', 'regularUser'),
(2, NULL, 'username', '1234', 'regularUser'),
(3, '', 'bob', '123', 'regularUser'),
(4, 'John Smith', 'jsmith', '1234', 'regularUser'),
(5, 'John Doe', 'jdoe', '123456', 'regularUser'),
(6, 'aname', 'auser', 'apass', 'regularUser');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `OrdersID` int(11) NOT NULL,
  `AuthorizedUserID` int(11) NOT NULL,
  `OrderDate` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`OrdersID`, `AuthorizedUserID`, `OrderDate`) VALUES
(1, 3, '2021-11-05 17:14:33'),
(2, 3, '2021-11-06 22:58:18'),
(3, 3, '2021-11-10 22:20:37'),
(4, 3, '2021-11-10 22:21:24'),
(5, 1, '2021-11-10 22:26:34'),
(6, 1, '2021-11-10 22:27:17'),
(7, 1, '2021-11-10 22:29:11');

-- --------------------------------------------------------

--
-- Table structure for table `pizzaorders`
--

CREATE TABLE `pizzaorders` (
  `PizzaOrderID` int(11) NOT NULL,
  `OrderID` int(11) NOT NULL,
  `PIzzaID` int(11) NOT NULL,
  `ToppingID` int(11) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `Price` decimal(6,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pizzaorders`
--

INSERT INTO `pizzaorders` (`PizzaOrderID`, `OrderID`, `PIzzaID`, `ToppingID`, `Quantity`, `Price`) VALUES
(1, 1, 1, 1, 3, '8.25'),
(2, 0, 1, 4, 2, '5.75'),
(3, 0, 2, 1, 3, '9.00'),
(4, 0, 1, 1, 1, '2.75'),
(5, 2, 2, 1, 1, '3.00'),
(6, 3, 1, 1, 8, '22.00'),
(7, 4, 1, 1, 8, '22.00'),
(8, 5, 1, 1, 4, '11.00'),
(9, 6, 2, 4, 2, '6.50'),
(10, 7, 2, 1, 9, '27.00');

-- --------------------------------------------------------

--
-- Table structure for table `pizzas`
--

CREATE TABLE `pizzas` (
  `PizzaID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Price` decimal(4,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pizzas`
--

INSERT INTO `pizzas` (`PizzaID`, `Name`, `Price`) VALUES
(1, 'Regular', '2.75'),
(2, 'Whole Wheat', '3.00');

-- --------------------------------------------------------

--
-- Table structure for table `toppings`
--

CREATE TABLE `toppings` (
  `ToppingsID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Price` decimal(4,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `toppings`
--

INSERT INTO `toppings` (`ToppingsID`, `Name`, `Price`) VALUES
(1, 'none', '0.00'),
(2, 'Tomatoes', '0.25'),
(3, 'Mushrooms', '0.25'),
(4, 'Ziti', '0.25');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `authorizedusers`
--
ALTER TABLE `authorizedusers`
  ADD PRIMARY KEY (`AuthorizedUsersID`),
  ADD UNIQUE KEY `Username` (`Username`),
  ADD KEY `AuthorizedUsersID` (`AuthorizedUsersID`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`OrdersID`),
  ADD KEY `AuthorizedUserID` (`AuthorizedUserID`),
  ADD KEY `OrdersID` (`OrdersID`);

--
-- Indexes for table `pizzaorders`
--
ALTER TABLE `pizzaorders`
  ADD PRIMARY KEY (`PizzaOrderID`),
  ADD KEY `PizzaOrderID` (`PizzaOrderID`),
  ADD KEY `OrderID` (`OrderID`) USING BTREE,
  ADD KEY `PIzzaID` (`PIzzaID`),
  ADD KEY `ToppingID` (`ToppingID`);

--
-- Indexes for table `pizzas`
--
ALTER TABLE `pizzas`
  ADD PRIMARY KEY (`PizzaID`),
  ADD UNIQUE KEY `Name` (`Name`),
  ADD KEY `PizzaID` (`PizzaID`);

--
-- Indexes for table `toppings`
--
ALTER TABLE `toppings`
  ADD PRIMARY KEY (`ToppingsID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `authorizedusers`
--
ALTER TABLE `authorizedusers`
  MODIFY `AuthorizedUsersID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `OrdersID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `pizzaorders`
--
ALTER TABLE `pizzaorders`
  MODIFY `PizzaOrderID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `pizzas`
--
ALTER TABLE `pizzas`
  MODIFY `PizzaID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `toppings`
--
ALTER TABLE `toppings`
  MODIFY `ToppingsID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
