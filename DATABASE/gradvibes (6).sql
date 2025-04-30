-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 27, 2025 at 10:32 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gradvibes`
--

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

CREATE TABLE `addresses` (
  `address_ID` int(10) NOT NULL,
  `cust_ID` int(10) NOT NULL,
  `address1` varchar(255) NOT NULL,
  `address2` varchar(255) DEFAULT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `zip` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `addresses`
--

INSERT INTO `addresses` (`address_ID`, `cust_ID`, `address1`, `address2`, `city`, `state`, `zip`) VALUES
(1, 1, '1 Penang Road', NULL, 'George Town', 'Penang', 10100),
(2, 2, '45 Jalan Baru', 'Taman Ipoh', 'Ipoh', 'Perak', 31400),
(3, 3, '12 Jalan Damansara', NULL, 'Petaling Jaya', 'Selangor', 47200),
(4, 4, '34 Jalan Tebrau', 'Tebrau City', 'Johor Bahru', 'Johor', 80000),
(5, 5, '5 Gurney Drive', NULL, 'George Town', 'Penang', 10250),
(6, 6, '7 Taman Jaya', 'Section 14', 'Shah Alam', 'Selangor', 40000),
(7, 7, 'Jalan Kuching 100', NULL, 'Kuching', 'Sarawak', 93000),
(8, 8, '14 Jalan Lintas', 'Luyang', 'Kota Kinabalu', 'Sabah', 88000),
(9, 9, '10 Jalan Merdeka', NULL, 'Kota Kinabalu', 'Sabah', 88000),
(10, 10, '50 Jalan Oya', 'Oya Village', 'Sibu', 'Sarawak', 96000),
(11, 1, '123 Jalan Sungai Pinang', 'Taman Sri Mutiara', 'George Town', 'Penang', 10250),
(12, 3, '456 Jalan Damansara', 'Taman Seri Gombak', 'Kuala Lumpur', 'Selangor', 53000),
(13, 4, '789 Jalan Bandar', 'Taman Melawati', 'Johor Bahru', 'Johor', 80000),
(14, 7, '10 Jalan Gurney', 'Taman Gurney', 'Kuching', 'Sarawak', 93000),
(15, 9, '20 Jalan Lintas', NULL, 'Kota Kinabalu', 'Sabah', 88000),
(16, 7, '30 Jalan Oya', NULL, 'Sibu', 'Sarawak', 96000),
(17, 10, '50 Jalan Merdeka', 'Taman Tawau', 'Tawau', 'Sabah', 91000),
(19, 5, '5 Gurney Drive', '', 'George Town', 'Penang', 10250),
(20, 7, 'Jalan Dewan Undangan Negeri', 'Lot 17', 'Kuching', 'Sarawak', 93000),
(21, 4, '9 Jalan Iskandar', 'Taman Ulahu', 'Johor Bahru', 'Johor', 80000);

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `cart_ID` int(10) NOT NULL,
  `product_ID` int(10) NOT NULL,
  `cust_ID` int(10) DEFAULT NULL,
  `qty` int(10) NOT NULL,
  `IP_Address` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`cart_ID`, `product_ID`, `cust_ID`, `qty`, `IP_Address`) VALUES
(1, 20, 2, 5, '::1'),
(3, 25, 2, 2, '::1'),
(4, 23, 2, 2, '::1'),
(5, 22, 2, 3, '::1'),
(6, 24, 3, 5, '::1'),
(7, 19, 3, 3, '::1'),
(8, 23, 3, 2, '::1'),
(9, 10, 3, 2, '::1'),
(10, 2, 3, 2, '::1'),
(16, 21, 8, 2, '::1'),
(17, 28, 8, 2, '::1'),
(18, 21, 8, 4, '::1');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `cat_ID` int(100) NOT NULL,
  `cat_title` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`cat_ID`, `cat_title`) VALUES
(1, 'Collegiate Regalia'),
(2, 'Diplomas & Diploma Covers'),
(3, 'Accessories'),
(4, 'Choir Regalia');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `cust_ID` int(10) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `mobile` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`cust_ID`, `first_name`, `last_name`, `email`, `password`, `mobile`) VALUES
(1, 'Lee', 'Hong', 'lee.hong380@gmail.com', 'LeeHong1234.', '0139806148'),
(2, 'Tan', 'Wei', 'tan.wei543@gmail.com', 'TanWei1234.', '0191085192'),
(3, 'Chong', 'Jin', 'chong.jin785@gmail.com', 'ChongJin1234.', '0135215631'),
(4, 'Ming', 'Chong', 'ming.chong287@gmail.com', 'MingChong1234.', '0133725619'),
(5, 'Ng', 'Xiu', 'ng.xiu742@gmail.com', 'NgXiu1234.', '0116041008'),
(6, 'Ahmad', 'Faiz', 'ahmad.faiz789@gmail.com', 'AhmadFaiz1234.', '0138675963'),
(7, 'Siti', 'Nurhaliza', 'siti.nurhaliza220@gmail.com', 'SitiNurhaliza1234.', '0148969423'),
(8, 'Muhammad', 'Amin', 'muhammad.amin870@gmail.com', 'MuhammadAmin1234.', '0149331324'),
(9, 'Nur', 'Aisyah', 'nur.aisyah632@gmail.com', 'NurAisyah1234.', '0130193252'),
(10, 'Azman', 'Hakim', 'azman.hakim388@gmail.com', 'AzmanHakim1234.', '0148431705');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_ID` int(11) NOT NULL,
  `cust_ID` int(11) NOT NULL,
  `product_ID` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `totalPrice` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_ID`, `cust_ID`, `product_ID`, `qty`, `totalPrice`) VALUES
(3, 1, 11, 4, 23.96),
(4, 1, 23, 1, 192.22),
(5, 1, 25, 3, 1112.97),
(6, 1, 12, 5, 29.95),
(7, 1, 1, 1, 97.99),
(8, 5, 16, 5, 99.95),
(9, 5, 20, 5, 114.95),
(10, 7, 25, 3, 1112.97),
(11, 7, 21, 2, 45.76),
(12, 7, 13, 1, 7.99),
(13, 7, 19, 2, 13.98),
(14, 7, 12, 55, 329.45),
(15, 4, 17, 2, 39.98),
(16, 4, 16, 3, 59.97);

-- --------------------------------------------------------

--
-- Table structure for table `paymentmethod`
--

CREATE TABLE `paymentmethod` (
  `payment_mtd_id` int(10) NOT NULL,
  `cardname` varchar(255) NOT NULL,
  `cardnumber` varchar(20) NOT NULL,
  `expdate` varchar(10) NOT NULL,
  `cvv` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `paymentmethod`
--

INSERT INTO `paymentmethod` (`payment_mtd_id`, `cardname`, `cardnumber`, `expdate`, `cvv`) VALUES
(1, 'Lee Hong', '1155522109703432', '08/27', 643),
(2, 'Tan Wei', '5150448348649245', '06/29', 250),
(3, 'Chong Jin', '6102591864732242', '09/27', 150),
(4, 'Ming Chong', '4124846978617379', '06/26', 729),
(5, 'Ng Xiu', '4737848337147934', '03/31', 306),
(7, 'Siti Nurhaliza', '4109708705265008', '12/28', 657),
(8, 'Muhammad Amin', '4675439312271733', '12/25', 459),
(9, 'Nur Aisyah', '4418648436825806', '04/31', 615),
(10, 'Azman Hakim', '3847684947584789', '02/30', 979),
(16, 'Ahmad Faiz', '3041983271111556', '02/28', 794),
(20, 'Azman Hakim', '1995054626451191', '05/27', 257),
(21, 'Lee Hong', '2958739379698327', '05/29', 59),
(22, 'Ng Xiu', '4737 8483 3714 7934', '03/31', 306),
(23, 'Siti Nurhaliza', '8329834289389234', '01/29', 95);

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_ID` int(10) NOT NULL,
  `cust_ID` int(10) NOT NULL,
  `address_ID` int(10) DEFAULT NULL,
  `prod_count` int(15) DEFAULT NULL,
  `total_amt` decimal(10,2) DEFAULT NULL,
  `payment_mtd_ID` int(10) NOT NULL,
  `trx_ID` varchar(255) NOT NULL,
  `payment_date` date DEFAULT curdate(),
  `p_status` varchar(20) DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`payment_ID`, `cust_ID`, `address_ID`, `prod_count`, `total_amt`, `payment_mtd_ID`, `trx_ID`, `payment_date`, `p_status`) VALUES
(4, 5, 19, 2, 227.79, 22, 'TRX20250401035682', '2025-04-01', 'Completed'),
(5, 7, 14, 4, 1251.54, 7, 'TRX20250403334878', '2025-04-03', 'Completed'),
(6, 7, 20, 1, 349.22, 23, 'TRX20250406861282', '2025-04-06', 'Completed'),
(7, 4, 21, 2, 105.95, 4, 'TRX20250427594413', '2025-04-27', 'Completed');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_ID` int(100) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `product_price` decimal(10,2) NOT NULL,
  `product_desc` text NOT NULL,
  `product_image` text NOT NULL,
  `product_keywords` text DEFAULT NULL,
  `cat_ID` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_ID`, `product_name`, `product_price`, `product_desc`, `product_image`, `product_keywords`, `cat_ID`) VALUES
(1, 'Matte Cap, Gown, Tassel & Stole Package', 97.99, 'Matte Cap, Gown, Tassel & Stole Package', 'gc-1.jpg', 'Matte Cap, Gown, Tassel & Stole Package', 1),
(2, 'Shiny Cap, Gown & Tassel Package', 97.99, 'Shiny Cap, Gown & Tassel Package', 'gc-2.jpg', 'Shiny Cap, Gown & Tassel Package', 1),
(3, 'Repreve Environmental Cap, Gown & Tassel Package', 114.59, 'Repreve Environmental Cap, Gown & Tassel Package', 'gc-3.jpg', 'Repreve Environmental Cap, Gown & Tassel Package', 1),
(4, 'Shiny Cap, Gown, Tassel & Stole Package', 158.88, 'Shiny Cap, Gown, Tassel & Stole Package', 'gc-4.jpg', 'Shiny Cap, Gown, Tassel & Stole Package', 1),
(5, '2 Color Graduation Gown', 119.28, '2 Color Graduation Gown', 'gc-5.jpg', '2 Color Graduation Gown', 1),
(6, 'Elite Doctorate Gown - Custom Colors & Embroidery Available', 158.19, 'Elite Doctorate Gown - Custom Colors & Embroidery Available', 'gc-6.jpg', 'Elite Doctorate Gown - Custom Colors & Embroidery Available', 1),
(10, 'Custom Diploma - Thermo or Flat Print (non foil)', 19.99, 'Custom Diploma - Thermo or Flat Print (non foil)', 'dc-1.jpg', 'Custom Diploma - Thermo or Flat Print (non foil)', 2),
(11, 'Thermographed White Stock Diploma', 5.99, 'Thermographed White Stock Diploma', 'dc-2.jpg', 'Thermographed White Stock Diploma', 2),
(12, 'Thermographed Ivory Stock Diploma', 5.99, 'Thermographed Ivory Stock Diploma', 'dc-3.jpg', 'Thermographed Ivory Stock Diploma', 2),
(13, 'Gold Foiled Ivory Stock Diplomas', 7.99, 'Gold Foiled Ivory Stock Diplomas', 'dc-4.jpg', 'Gold Foiled Ivory Stock Diplomas', 2),
(14, 'Gold Foiled White Stock Diplomas', 399.99, 'Gold Foiled White Stock Diplomas', 'dc-5.jpg', 'Gold Foiled White Stock Diplomas', 2),
(16, 'Single Color Graduation Tassel', 19.99, 'Single Color Graduation Tassel', 'ts-1.jpg', 'Single Color Graduation Tassel ', 3),
(17, 'Child Single Color Tassel', 19.99, 'Child Single Color Tassel ', 'ts-2.jpg', 'Child Single Color Tassel ', 3),
(19, 'Adult Gold Signet Year Charm', 6.99, 'Adult Gold Signet Year Charm', 'ts-3.jpg', 'Adult Gold Signet Year Charm', 3),
(20, 'College Degree Jumbo Graduation Tassel', 22.99, 'College Degree Jumbo Graduation Tassel', 'ts-4.jpg', 'College Degree Jumbo Graduation Tassel', 3),
(21, 'Jumbo Graduation Tassel', 22.88, 'Jumbo Graduation Tassel', 'ts-5.jpg', 'Jumbo Graduation Tassel', 3),
(22, 'Adagio Youth Choir Gown', 315.55, 'Adagio Youth Choir Gown', 'cg-1.jpg', 'Adagio Youth Choir Gown', 4),
(23, 'Symphony Youth Choir Gown', 192.22, 'Symphony Youth Choir Gown', 'cg-2.jpg', 'Symphony Youth Choir Gown', 4),
(24, 'Adagio Choir Gown Only', 324.99, 'Adagio Choir Gown Only', 'cg-3.jpg', 'Adagio Choir Gown Only', 4),
(25, 'Celebration Choir Gown', 370.99, 'Celebration Choir Gown', 'cg-4.jpg', 'Celebration Choir Gown', 4),
(27, 'Symphony Choir Gown', 201.99, 'Symphony Choir Gown', 'cg-5.jpg', 'Symphony Choir Gown', 4),
(28, 'Custom Diploma Cover', 74.99, 'Custom Diploma Cover', 'dcdc-1.jpg', 'Custom Diploma Cover', 2),
(29, 'Imprinted Diploma Cover', 40.99, 'Imprinted Diploma Cover', 'dcdc-2.jpg', 'Imprinted Diploma Cover', 2),
(30, 'Plain Diploma Cover', 40.99, 'Plain Diploma Cover', 'dcdc-3.jpg', 'Plain Diploma Cover', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`address_ID`),
  ADD KEY `cust_ID` (`cust_ID`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`cart_ID`),
  ADD KEY `product_ID` (`product_ID`),
  ADD KEY `cust_ID` (`cust_ID`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`cat_ID`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`cust_ID`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_ID`,`product_ID`),
  ADD KEY `cust_ID` (`cust_ID`),
  ADD KEY `product_ID` (`product_ID`);

--
-- Indexes for table `paymentmethod`
--
ALTER TABLE `paymentmethod`
  ADD PRIMARY KEY (`payment_mtd_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_ID`),
  ADD KEY `cust_ID` (`cust_ID`),
  ADD KEY `payment_mtd_id` (`payment_mtd_ID`),
  ADD KEY `payments_ibfk_4` (`address_ID`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_ID`),
  ADD KEY `cat_ID` (`cat_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addresses`
--
ALTER TABLE `addresses`
  MODIFY `address_ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `cart_ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `cat_ID` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `cust_ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `paymentmethod`
--
ALTER TABLE `paymentmethod`
  MODIFY `payment_mtd_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_ID` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `addresses`
--
ALTER TABLE `addresses`
  ADD CONSTRAINT `addresses_ibfk_1` FOREIGN KEY (`cust_ID`) REFERENCES `customers` (`cust_ID`) ON DELETE CASCADE;

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_ibfk_1` FOREIGN KEY (`product_ID`) REFERENCES `products` (`product_ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `carts_ibfk_2` FOREIGN KEY (`cust_ID`) REFERENCES `customers` (`cust_ID`) ON DELETE SET NULL;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`cust_ID`) REFERENCES `customers` (`cust_ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`product_ID`) REFERENCES `products` (`product_ID`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_2` FOREIGN KEY (`cust_ID`) REFERENCES `customers` (`cust_ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `payments_ibfk_3` FOREIGN KEY (`payment_mtd_ID`) REFERENCES `paymentmethod` (`payment_mtd_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `payments_ibfk_4` FOREIGN KEY (`address_ID`) REFERENCES `addresses` (`address_ID`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`cat_ID`) REFERENCES `categories` (`cat_ID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
