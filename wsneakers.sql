-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 28, 2024 at 09:47 PM
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
(6, 'Puma'),
(8, 'Cat');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `CartID` int(10) NOT NULL,
  `CustomerID` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`CartID`, `CustomerID`) VALUES
(86, 4);

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

CREATE TABLE `cart_items` (
  `CartID` int(10) NOT NULL,
  `ProductID` int(10) NOT NULL,
  `Quantity` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart_items`
--

INSERT INTO `cart_items` (`CartID`, `ProductID`, `Quantity`) VALUES
(86, 5, 10),
(86, 6, 1),
(86, 7, 10);

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
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `CouponID` int(10) NOT NULL,
  `Percentage_Discount` int(10) DEFAULT NULL,
  `Name` varchar(30) DEFAULT NULL,
  `SellerID` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `coupons`
--

INSERT INTO `coupons` (`CouponID`, `Percentage_Discount`, `Name`, `SellerID`) VALUES
(1, 10, 'wrudro', 1),
(2, 15, 'jim', 3),
(4, 25, 'summer25', 1),
(6, 10, 'CatOJ', 5);

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
(1, 'Jim', '$2y$10$f1jJHST5dugnpcHfgkCjuuFfTX9iltv9rLx3lRXnTlu/xD4ZlYQAS', '01735225285', '2001-06-22', 'H:18, R:7, B:E, Banasree, Rampura, Dhaka'),
(2, 'Mostakim52', '$2y$10$H49ZvUMGbLfndMgO2xOY6.F/bD8Xbt4EHnz1NrnEvvEx8n5fUIl3.', '01319674564', '2001-11-01', 'Dhaka, Uttara, Sector-5, Road-4A, House-32'),
(4, 'Rudra', '$2y$10$tJYS6i7rDEJRbGBq9EE9s.kYLOna/0sCQo7feM2LJ5qX8sOg784oq', '01956012107', '2001-01-15', 'Uttara'),
(5, 'Joy', '$2y$10$Dkuhz8YaZZ6WiBnNjypB2uadMojGsi4qQKqsGkfdykBdocd0VNH7e', '01816905001', '1993-12-01', 'House - 18, Road - 7, Block - E, Banasree, Rampura, Dhaka'),
(9, 'Tamim', '$2y$10$xOnccKlIfAgTZq1qWl/RGuGQnF88P3CFOO9D.KU4p8OSpgLPaUrKC', '01319674824', '2002-06-06', 'Gulshan'),
(10, 'Tushar', '$2y$10$8pFJSkhzLfhqiajvNECECui2WsvPkZ1Gd4KpFfKz1PLx8pwNgRUhO', '01951666788', '1990-06-21', 'Banani'),
(11, 'Ishan', '$2y$10$dNaKG0PkRH6GZNGy6Ta9CeWiesFP0OLAlnCSMQz4nKiN5PsorNxQS', '01735225265', '1985-08-15', 'Bashundhara'),
(12, 'Dipu', '$2y$10$91HVmOsmf8m9nxuHE6RGv.gGPSDtkQ843FZh4yidpaCVgjTrLu4/C', '01319674577', '2007-07-07', 'Aftabnagar'),
(13, 'Ryan Gosling', '$2y$10$dDSFcCgk0xy2UGT8HiK3K.IYfb3gLmXYAakjIvKS9m5ZxNXrYjS8K', '01319674553', '2000-01-15', 'Uttara'),
(14, 'Nabiha', '$2y$10$ZcU5rNRxUA6PER4KldLUjeau0iZPfiTIOnfN7RXDtmNQlKatxt8u6', '726138917612341', '2002-07-24', 'Bashundhara Rd'),
(15, 'Rubu', '$2y$10$YM9BzNgzWNPRCRE1j1Jz5ecA4f/NgRoq9Izp2t.gBvozLyfVcwfXu', '01319674565', '2024-05-13', 'Bashundhara Rd');

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
  `CustomerID` int(10) DEFAULT NULL,
  `CouponID` int(10) DEFAULT NULL,
  `Total_Price` double(10,2) DEFAULT NULL,
  `Date` date DEFAULT NULL,
  `Address` varchar(100) DEFAULT NULL,
  `Payment_Type` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`OrderID`, `Status`, `CustomerID`, `CouponID`, `Total_Price`, `Date`, `Address`, `Payment_Type`) VALUES
(6, 'shipped', 1, 4, 388.50, '2024-05-27', 'H:18, R:7, B:E, Banasree, Rampura, Dhaka', 'nagad'),
(7, 'shipped', 1, NULL, 900.38, '2024-05-27', 'H:18, R:7, B:E, Banasree, Rampura, Dhaka', 'Visa'),
(8, 'delivered', 1, 4, 1840.00, '2024-05-27', 'H:18, R:7, B:E, Banasree, Rampura, Dhaka', 'MasterCard'),
(9, 'delivered', 1, NULL, 350.00, '2024-05-28', 'H:18, R:7, B:E, Banasree, Rampura, Dhaka', 'Visa'),
(10, 'delivered', 1, NULL, 1000.00, '2024-05-28', 'H:18, R:7, B:E, Banasree, Rampura, Dhaka', 'MasterCard'),
(11, 'delivered', 1, NULL, 170.50, '2024-05-28', 'H:18, R:7, B:E, Banasree, Rampura, Dhaka', 'bkash'),
(12, 'pending', 1, NULL, 450.19, '2024-05-28', 'H:18, R:7, B:E, Banasree, Rampura, Dhaka', 'bkash'),
(13, 'pending', 1, NULL, 129.50, '2024-05-28', 'H:18, R:7, B:E, Banasree, Rampura, Dhaka', 'Visa'),
(14, 'pending', 1, NULL, 2840.00, '2024-05-28', 'H:18, R:7, B:E, Banasree, Rampura, Dhaka', 'bkash'),
(15, 'pending', 15, 6, 1577.19, '2024-05-28', 'Bashundhara Rd, North South University', 'MasterCard'),
(16, 'delivered', 15, NULL, 2999.99, '2024-05-28', 'Bashundhara Rd, Rudros Mansion', 'bkash');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `OrderID` int(10) DEFAULT NULL,
  `ProductName` varchar(100) DEFAULT NULL,
  `Quantity` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`OrderID`, `ProductName`, `Quantity`) VALUES
(6, 'Nike Converse', 3),
(7, 'Nike Air Force One', 2),
(8, 'New Balance FuelCell SuperComp Elite v4', 1),
(8, 'FUTURE 7 ULTIMATE Firm Ground/Arificial Ground Men&#38;#39;s Soccer Cleats', 1),
(9, 'New Balance FuelCell SuperComp Elite v4', 1),
(10, 'Nike HyperVenom', 1),
(11, 'Adidas Dragon', 1),
(12, 'Nike Air Force One', 1),
(13, 'Nike Converse', 1),
(14, 'New Balance FuelCell SuperComp Elite v4', 1),
(14, 'Nike HyperVenom', 1),
(14, 'FUTURE 7 ULTIMATE Firm Ground/Arificial Ground Men&#38;#39;s Soccer Cleats', 1),
(15, 'Nike Air Force One', 1),
(15, 'Nike Converse', 6),
(15, 'New Balance FuelCell SuperComp Elite v4', 1),
(16, 'Cat Intruder', 1);

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
(2, 'Adidas Dragon', 170.50, 9, '2.gif', 'Better than Nike!', 1, 1, 1),
(4, 'Nike Air Force One', 450.19, 1, '4.gif', 'Best of Nike! Better than Adidas!', 3, 1, 1),
(5, 'Nike Converse', 129.50, 0, '5.gif', 'The best for your feet!', 3, 1, 2),
(6, 'New Balance FuelCell SuperComp Elite v4', 350.00, 1, '6.jpg', 'The FuelCell SC Elite v4 is a race day shoe designed for the moments when seconds really do count. The propulsive feeling of FuelCell is combined with a thinner carbon fiber plate, offering superior energy return in a lightweight package.', 1, 5, 1),
(7, 'Nike HyperVenom', 1000.00, 23, '7.gif', 'Made for the attacking goalscorer, the Nike Hypervenom Football Boot features a large strike zone for unrivalled agility and better ball control on artificial pitches.', 3, 1, 1),
(10, 'FUTURE 7 ULTIMATE Firm Ground/Arificial Ground Mens Soccer Cleats', 1490.00, 2, '8.gif', 'The FuelCell SC Elite v4 is a race day shoe designed for the moments when seconds really do count. The propulsive feeling of FuelCell is combined with a thinner carbon fiber plate, offering superior energy return in a lightweight package.', 1, 6, 15),
(11, 'Cat Intruder', 2999.99, 9, '11.jpeg', 'The iconic Intruder and the original chunky sneaker. Born in the 90s, RePowered for modern day. With its one of a kind thick, rubber outsole the Intruder is unapologetically and authentically Cat.', 5, 8, 4);

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
(10, 'Orange'),
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
(10, 'Orange'),
(11, 'Black'),
(11, 'Cat Yellow');

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
(7, 43),
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
(7, 43),
(10, 42),
(11, 43),
(11, 20);

-- --------------------------------------------------------

--
-- Table structure for table `report`
--

CREATE TABLE `report` (
  `ReportID` int(11) NOT NULL,
  `Text` text DEFAULT NULL,
  `CustomerID` int(11) DEFAULT NULL,
  `ProductID` int(11) DEFAULT NULL,
  `SellerID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `report`
--

INSERT INTO `report` (`ReportID`, `Text`, `CustomerID`, `ProductID`, `SellerID`) VALUES
(36, 'Too White', 4, 5, 3),
(37, 'It looks like a shoe', 4, 5, 3),
(39, 'There should be more colour options.', 15, 4, 3),
(40, 'The shoes are for dogs!', 15, 11, 5);

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

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`ReviewID`, `Text`, `ProductID`, `CustomerID`) VALUES
(7, 'It looks better on my cats than me.', 11, 15);

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
(4, 'Mostakim Hossain', 'HelloWorld123'),
(5, 'Nayeem Porag Molla', 'Wrudru');

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
(4, '01319674564'),
(1, '01956012107'),
(3, '01711175098'),
(4, '01319674564'),
(5, '01303051107');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `WishlistID` int(10) NOT NULL,
  `CustomerID` int(10) DEFAULT NULL,
  `ProductID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `wishlist`
--

INSERT INTO `wishlist` (`WishlistID`, `CustomerID`, `ProductID`) VALUES
(39, 1, 7),
(63, 4, 2),
(64, 4, 4),
(65, 4, 5),
(66, 4, 2),
(67, 4, 2),
(69, 15, 5),
(70, 15, 6),
(71, 15, 11);

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
  ADD UNIQUE KEY `CustomerID_2` (`CustomerID`),
  ADD KEY `CustomerID` (`CustomerID`);

--
-- Indexes for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`CartID`,`ProductID`),
  ADD KEY `CartID` (`CartID`),
  ADD KEY `ProductID` (`ProductID`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`CategoryID`);

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
  ADD PRIMARY KEY (`CustomerID`),
  ADD UNIQUE KEY `Username` (`Username`);

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
  ADD KEY `CouponID` (`CouponID`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD KEY `order_items_ibfk_1` (`OrderID`);

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
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`WishlistID`),
  ADD KEY `CustomerID` (`CustomerID`),
  ADD KEY `fk_wishlist_product` (`ProductID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `brand`
--
ALTER TABLE `brand`
  MODIFY `BrandID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `CartID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=144;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `CategoryID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `CouponID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `CustomerID` int(128) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `OrderID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `ProductID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `report`
--
ALTER TABLE `report`
  MODIFY `ReportID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `ReviewID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `seller`
--
ALTER TABLE `seller`
  MODIFY `SellerID` int(128) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `WishlistID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`CustomerID`) REFERENCES `customer` (`CustomerID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_ibfk_1` FOREIGN KEY (`CartID`) REFERENCES `cart` (`CartID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cart_items_ibfk_2` FOREIGN KEY (`ProductID`) REFERENCES `product` (`ProductID`) ON DELETE CASCADE ON UPDATE CASCADE;

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
  ADD CONSTRAINT `order_ibfk_3` FOREIGN KEY (`CouponID`) REFERENCES `coupons` (`CouponID`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`OrderID`) REFERENCES `order` (`OrderID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `BrandID` FOREIGN KEY (`BrandID`) REFERENCES `brand` (`BrandID`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `CategoryID` FOREIGN KEY (`CategoryID`) REFERENCES `category` (`CategoryID`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `SellerID` FOREIGN KEY (`SellerID`) REFERENCES `seller` (`SellerID`) ON DELETE CASCADE ON UPDATE CASCADE;

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
  ADD CONSTRAINT `report_ibfk_1` FOREIGN KEY (`CustomerID`) REFERENCES `customer` (`CustomerID`),
  ADD CONSTRAINT `report_ibfk_2` FOREIGN KEY (`ProductID`) REFERENCES `product` (`ProductID`),
  ADD CONSTRAINT `report_ibfk_3` FOREIGN KEY (`SellerID`) REFERENCES `seller` (`SellerID`);

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
-- Constraints for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD CONSTRAINT `fk_wishlist_product` FOREIGN KEY (`ProductID`) REFERENCES `product` (`ProductID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `wishlist_ibfk_1` FOREIGN KEY (`CustomerID`) REFERENCES `customer` (`CustomerID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
