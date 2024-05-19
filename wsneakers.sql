-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 19, 2024 at 07:26 PM
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
(5, 'New Balance'),
(6, 'Puma');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `CartID` int(10) NOT NULL,
  `CustomerID` int(10) DEFAULT NULL,
  `Quantity` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(9, 'Specialty'),
(15, 'Cleats');

-- --------------------------------------------------------

--
-- Table structure for table `consists_of`
--

CREATE TABLE `consists_of` (
  `CartID` int(10) DEFAULT NULL,
  `ProductID` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `CouponID` int(10) NOT NULL,
  `Percentage_Discount` int(10) DEFAULT NULL,
  `Name` varchar(30) DEFAULT NULL,
  `SellerID` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(1, 'Jim', '$2y$10$f1jJHST5dugnpcHfgkCjuuFfTX9iltv9rLx3lRXnTlu/xD4ZlYQAS', '01735225285', '2001-06-21', 'H:18, R:7, B:E, Banasree, Rampura, Dhaka'),
(2, 'Mostakim52', '$2y$10$H49ZvUMGbLfndMgO2xOY6.F/bD8Xbt4EHnz1NrnEvvEx8n5fUIl3.', '01319674564', '2001-11-01', 'Dhaka, Uttara, Sector-5, Road-4A, House-32');

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
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `OrderID` int(10) NOT NULL,
  `Status` varchar(30) DEFAULT NULL,
  `CartID` int(10) DEFAULT NULL,
  `CustomerID` int(10) DEFAULT NULL,
  `CouponID` int(10) DEFAULT NULL,
  `Total_Price` double(10,2) DEFAULT NULL,
  `Date` date DEFAULT NULL,
  `Address` varchar(100) DEFAULT NULL
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
(2, 'Adidas Dragon', 170.50, 10, '2.gif', 'Better than Nike!', 1, 1, 1),
(4, 'Nike Air Force One', 450.19, 5, '4.gif', 'Best of Nike! Better than Adidas!', 3, 1, 1),
(5, 'Nike Converse', 129.50, 10, '5.gif', 'The best for your feet!', 3, 1, 2),
(6, 'New Balance FuelCell SuperComp Elite v4', 350.00, 5, '6.jpg', 'The FuelCell SC Elite v4 is a race day shoe designed for the moments when seconds really do count. The propulsive feeling of FuelCell is combined with a thinner carbon fiber plate, offering superior energy return in a lightweight package.', 1, 5, 1),
(7, 'Nike HyperVenom', 1000.00, 25, '7.gif', 'Made for the attacking goalscorer, the Nike Hypervenom Football Boot features a large strike zone for unrivalled agility and better ball control on artificial pitches.', 3, 1, 1),
(10, 'FUTURE 7 ULTIMATE Firm Ground/Arificial Ground Men&#38;#39;s Soccer Cleats', 1500.00, 10, '8.gif', 'The FuelCell SC Elite v4 is a race day shoe designed for the moments when seconds really do count. The propulsive feeling of FuelCell is combined with a thinner carbon fiber plate, offering superior energy return in a lightweight package.', 1, 6, 15);

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
(7, 'Purple'),
(10, 'White'),
(10, 'Black'),
(10, 'Orange');

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
-- Table structure for table `report`
--

CREATE TABLE `report` (
  `ReportID` int(10) NOT NULL,
  `Text` varchar(30) DEFAULT NULL,
  `CustomerID` int(10) DEFAULT NULL,
  `SellerID` int(10) DEFAULT NULL,
  `ProductID` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `ReviewID` int(10) NOT NULL,
  `Text` varchar(1000) DEFAULT NULL,
  `ProductID` int(10) DEFAULT NULL,
  `CustomerID` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `seller`
--

CREATE TABLE `seller` (
  `SellerID` int(128) NOT NULL,
  `Username` varchar(128) NOT NULL,
  `Pwd` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `seller`
--

INSERT INTO `seller` (`SellerID`, `Username`, `Pwd`) VALUES
(1, 'Rudra Tahsin', 'Double0Woof'),
(3, 'John Wick', 'ImACatLover'),
(4, 'Mostakim Hossain', 'HelloWorld123');

-- --------------------------------------------------------

--
-- Table structure for table `seller_phonenumbers`
--

CREATE TABLE `seller_phonenumbers` (
  `SellerID` int(10) DEFAULT NULL,
  `Phone_Number` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `seller_phonenumbers`
--

INSERT INTO `seller_phonenumbers` (`SellerID`, `Phone_Number`) VALUES
(1, '01956012107'),
(3, '01711175098'),
(4, '01319674564');

-- --------------------------------------------------------

--
-- Table structure for table `transaction_history`
--

CREATE TABLE `transaction_history` (
  `TrxID` int(10) NOT NULL,
  `CustomerID` int(10) DEFAULT NULL,
  `OrderID` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`CartID`),
  ADD KEY `CustomerID` (`CustomerID`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`CategoryID`);

--
-- Indexes for table `consists_of`
--
ALTER TABLE `consists_of`
  ADD KEY `CartID` (`CartID`),
  ADD KEY `ProductID` (`ProductID`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`CouponID`),
  ADD KEY `SellerID` (`SellerID`);

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
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`OrderID`),
  ADD KEY `CustomerID` (`CustomerID`),
  ADD KEY `CartID` (`CartID`),
  ADD KEY `CouponID` (`CouponID`);

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
-- Indexes for table `report`
--
ALTER TABLE `report`
  ADD PRIMARY KEY (`ReportID`),
  ADD KEY `CustomerID` (`CustomerID`),
  ADD KEY `ProductID` (`ProductID`),
  ADD KEY `SellerID` (`SellerID`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`ReviewID`),
  ADD KEY `ProductID` (`ProductID`),
  ADD KEY `CustomerID` (`CustomerID`);

--
-- Indexes for table `seller`
--
ALTER TABLE `seller`
  ADD PRIMARY KEY (`SellerID`),
  ADD UNIQUE KEY `Username` (`Username`);

--
-- Indexes for table `seller_phonenumbers`
--
ALTER TABLE `seller_phonenumbers`
  ADD KEY `SellerID` (`SellerID`);

--
-- Indexes for table `transaction_history`
--
ALTER TABLE `transaction_history`
  ADD PRIMARY KEY (`TrxID`),
  ADD KEY `CustomerID` (`CustomerID`),
  ADD KEY `OrderID` (`OrderID`);

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
  MODIFY `BrandID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `CartID` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `CategoryID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `CouponID` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `CustomerID` int(128) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `OrderID` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `ProductID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `report`
--
ALTER TABLE `report`
  MODIFY `ReportID` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `ReviewID` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `seller`
--
ALTER TABLE `seller`
  MODIFY `SellerID` int(128) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `transaction_history`
--
ALTER TABLE `transaction_history`
  MODIFY `TrxID` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `WishlistID` int(10) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`CustomerID`) REFERENCES `customer` (`CustomerID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `consists_of`
--
ALTER TABLE `consists_of`
  ADD CONSTRAINT `consists_of_ibfk_1` FOREIGN KEY (`CartID`) REFERENCES `cart` (`CartID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `consists_of_ibfk_2` FOREIGN KEY (`ProductID`) REFERENCES `product` (`ProductID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `coupons`
--
ALTER TABLE `coupons`
  ADD CONSTRAINT `coupons_ibfk_1` FOREIGN KEY (`SellerID`) REFERENCES `seller` (`SellerID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `is_part_of`
--
ALTER TABLE `is_part_of`
  ADD CONSTRAINT `is_part_of_ibfk_1` FOREIGN KEY (`WishlistID`) REFERENCES `wishlist` (`WishlistID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `is_part_of_ibfk_2` FOREIGN KEY (`CustomerID`) REFERENCES `customer` (`CustomerID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `order_ibfk_1` FOREIGN KEY (`CustomerID`) REFERENCES `customer` (`CustomerID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `order_ibfk_2` FOREIGN KEY (`CartID`) REFERENCES `cart` (`CartID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `order_ibfk_3` FOREIGN KEY (`CouponID`) REFERENCES `coupons` (`CouponID`) ON DELETE SET NULL ON UPDATE CASCADE;

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
-- Constraints for table `report`
--
ALTER TABLE `report`
  ADD CONSTRAINT `report_ibfk_1` FOREIGN KEY (`CustomerID`) REFERENCES `customer` (`CustomerID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `report_ibfk_2` FOREIGN KEY (`ProductID`) REFERENCES `product` (`ProductID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `report_ibfk_3` FOREIGN KEY (`SellerID`) REFERENCES `seller` (`SellerID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`ProductID`) REFERENCES `product` (`ProductID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`CustomerID`) REFERENCES `customer` (`CustomerID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `seller_phonenumbers`
--
ALTER TABLE `seller_phonenumbers`
  ADD CONSTRAINT `seller_phonenumbers_ibfk_1` FOREIGN KEY (`SellerID`) REFERENCES `seller` (`SellerID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `transaction_history`
--
ALTER TABLE `transaction_history`
  ADD CONSTRAINT `transaction_history_ibfk_1` FOREIGN KEY (`CustomerID`) REFERENCES `customer` (`CustomerID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `transaction_history_ibfk_2` FOREIGN KEY (`OrderID`) REFERENCES `order` (`OrderID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD CONSTRAINT `wishlist_ibfk_1` FOREIGN KEY (`CustomerID`) REFERENCES `customer` (`CustomerID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
