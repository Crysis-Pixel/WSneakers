-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 02, 2024 at 12:40 AM
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
-- Table structure for table `brand`
--

CREATE TABLE `brand` (
  `BrandID` int(10) NOT NULL,
  `Name` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `brand`
--

INSERT INTO `brand` (`BrandID`, `Name`) VALUES
(1, 'Nike'),
(2, 'Adidas'),
(5, 'New Balance');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `CategoryID` int(10) NOT NULL,
  `Type` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`CategoryID`, `Type`) VALUES
(1, 'Athletic'),
(2, 'Casual'),
(3, 'Formal'),
(4, 'Boots'),
(5, 'Sandals'),
(6, 'Flats'),
(7, 'High heels'),
(8, 'Espadrilles'),
(9, 'Specialty');

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
-- Table structure for table `is_part_of`
--

CREATE TABLE `is_part_of` (
  `WishlistID` int(10) DEFAULT NULL,
  `CustomerID` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `ProductDesc` text DEFAULT NULL,
  `SellerID` int(10) DEFAULT NULL,
  `BrandID` int(11) DEFAULT NULL,
  `CategoryID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`ProductID`, `ProductName`, `Price`, `Quantity`, `Image`, `ProductDesc`, `SellerID`, `BrandID`, `CategoryID`) VALUES
(2, 'Adidas Dragon', 170.50, 10, '2.gif', 'Better than Nike!', 1, 2, 1),
(4, 'Nike Air Force One', 450.19, 5, '4.gif', 'Best of Nike! Better than Adidas!', 1, 1, 2),
(5, 'Nike Converse', 129.50, 10, '5.gif', 'The best for your feet!', 3, 1, 2),
(6, 'New Balance FuelCell SuperComp Elite v4', 350.00, 5, '6.jpg', 'The FuelCell SC Elite v4 is a race day shoe designed for the moments when seconds really do count. The propulsive feeling of FuelCell is combined with a thinner carbon fiber plate, offering superior energy return in a lightweight package.', 1, 5, 1),
(7, 'Nike HyperVenom', 1000.00, 25, '7.gif', 'Made for the attacking goalscorer, the Nike Hypervenom Football Boot features a large strike zone for unrivalled agility and better ball control on artificial pitches.', NULL, 1, 1);

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
(2, 'White'),
(2, 'Black'),
(4, 'Blue'),
(4, 'Gray'),
(4, 'Black'),
(5, 'White'),
(5, 'Red'),
(6, 'White'),
(7, 'Black'),
(7, 'Purple');

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
(2, 32),
(2, 42),
(4, 41),
(4, 42),
(4, 43),
(5, 42),
(5, 43),
(6, 46),
(6, 47),
(7, 41),
(7, 42),
(7, 43);

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

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `WishlistID` int(10) NOT NULL,
  `CustomerID` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `brand`
--
ALTER TABLE `brand`
  ADD PRIMARY KEY (`BrandID`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`CategoryID`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`CustomerID`);

--
-- Indexes for table `is_part_of`
--
ALTER TABLE `is_part_of`
  ADD KEY `WishlistID` (`WishlistID`),
  ADD KEY `CustomerID` (`CustomerID`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`ProductID`),
  ADD KEY `SellerID` (`SellerID`),
  ADD KEY `BrandID` (`BrandID`),
  ADD KEY `CategoryID` (`CategoryID`);

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
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`WishlistID`),
  ADD KEY `CustomerID` (`CustomerID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `brand`
--
ALTER TABLE `brand`
  MODIFY `BrandID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `CategoryID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `CustomerID` int(128) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `ProductID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `seller`
--
ALTER TABLE `seller`
  MODIFY `SellerID` int(128) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `WishlistID` int(10) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `is_part_of`
--
ALTER TABLE `is_part_of`
  ADD CONSTRAINT `is_part_of_ibfk_1` FOREIGN KEY (`WishlistID`) REFERENCES `wishlist` (`WishlistID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `is_part_of_ibfk_2` FOREIGN KEY (`CustomerID`) REFERENCES `customer` (`CustomerID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `BrandID` FOREIGN KEY (`BrandID`) REFERENCES `brand` (`BrandID`) ON DELETE SET NULL,
  ADD CONSTRAINT `CategoryID` FOREIGN KEY (`CategoryID`) REFERENCES `category` (`CategoryID`) ON DELETE SET NULL,
  ADD CONSTRAINT `SellerID` FOREIGN KEY (`SellerID`) REFERENCES `seller` (`SellerID`);

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

--
-- Constraints for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD CONSTRAINT `wishlist_ibfk_1` FOREIGN KEY (`CustomerID`) REFERENCES `customer` (`CustomerID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
