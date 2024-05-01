-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 19, 2024 at 11:21 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wsneakers`
--

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `CustomerID` int(128) NOT NULL,
  `Username` varchar(128) NOT NULL,
  `Password` varchar(256) NOT NULL,
  `Phone` varchar(15) NOT NULL,
  `Birthdate` date NOT NULL,
  `Address` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`CustomerID`, `Username`, `Password`, `Phone`, `Birthdate`, `Address`) VALUES
(1, 'Jim', '$2y$10$f1jJHST5dugnpcHfgkCjuuFfTX9iltv9rLx3lRXnTlu/xD4ZlYQAS', '01735225285', '2001-06-21', 'H:18, R:7, B:E, Banasree, Rampura, Dhaka');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `ProductID` int(10) NOT NULL,
  `ProductName` varchar(100) DEFAULT NULL,
  `Price` double(6,2) DEFAULT NULL,
  `Quantity` int(3) DEFAULT NULL,
  `Image` text DEFAULT NULL,
  `ProductDesc` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`ProductID`, `ProductName`, `Price`, `Quantity`, `Image`, `ProductDesc`) VALUES
(1, 'Nike converse', 129.50, 10, '1.gif', 'The best you can get for your feet!'),
(2, 'Adidas Dragon', 170.50, 10, '2.gif', 'Better than Nike!'),
(3, 'adidas Bleh', 200.09, 34, '3.jpg', 'Best of Adidas!'),
(4, 'Nike Air Force One', 450.19, 5, '4.gif', 'Best of Nike! Better than Adidas!');

-- --------------------------------------------------------

--
-- Table structure for table `product_colour`
--

CREATE TABLE `product_colour` (
  `ProductID` int(10) DEFAULT NULL,
  `Colour` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_colour`
--

INSERT INTO `product_colour` (`ProductID`, `Colour`) VALUES
(1, 'White'),
(1, 'Black'),
(2, 'White'),
(2, 'Black'),
(3, 'White'),
(3, 'Black'),
(3, 'Gray'),
(4, 'Blue'),
(4, 'Gray'),
(4, 'Black');

-- --------------------------------------------------------

--
-- Table structure for table `product_size`
--

CREATE TABLE `product_size` (
  `ProductID` int(10) DEFAULT NULL,
  `size` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_size`
--

INSERT INTO `product_size` (`ProductID`, `size`) VALUES
(1, 32),
(1, 42),
(2, 32),
(2, 42),
(3, 32),
(3, 42),
(4, 41),
(4, 42),
(4, 43);

-- --------------------------------------------------------

--
-- Table structure for table `seller`
--

CREATE TABLE `seller` (
  `SellerID` int(128) NOT NULL,
  `Phone` varchar(15) NOT NULL,
  `Username` varchar(128) NOT NULL,
  `Pwd` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `seller`
--

INSERT INTO `seller` (`SellerID`, `Phone`, `Username`, `Pwd`) VALUES
(1, '01956012107', 'Rudra Tahsin', 'Double0Woof'),
(3, '01711175098', 'John Wick', 'IamAcatLover');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`CustomerID`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`ProductID`);

--
-- Indexes for table `product_colour`
--
ALTER TABLE `product_colour`
  ADD KEY `ProductID` (`ProductID`);

--
-- Indexes for table `product_size`
--
ALTER TABLE `product_size`
  ADD KEY `ProductID` (`ProductID`);

--
-- Indexes for table `seller`
--
ALTER TABLE `seller`
  ADD PRIMARY KEY (`SellerID`),
  ADD UNIQUE KEY `Username` (`Username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `CustomerID` int(128) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `ProductID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `seller`
--
ALTER TABLE `seller`
  MODIFY `SellerID` int(128) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `product_colour`
--
ALTER TABLE `product_colour`
  ADD CONSTRAINT `product_colour_ibfk_1` FOREIGN KEY (`ProductID`) REFERENCES `product` (`ProductID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product_size`
--
ALTER TABLE `product_size`
  ADD CONSTRAINT `product_size_ibfk_1` FOREIGN KEY (`ProductID`) REFERENCES `product` (`ProductID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
