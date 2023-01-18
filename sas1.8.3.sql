-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 20, 2021 at 12:34 PM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 8.0.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `demo`
--

-- --------------------------------------------------------

--
-- Table structure for table `billdetails`
--

CREATE TABLE `billdetails` (
  `billdetailsID` int(11) NOT NULL,
  `billID` int(11) NOT NULL,
  `productID` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` float NOT NULL,
  `tax` float DEFAULT NULL,
  `subtotal` float DEFAULT 0,
  `discount` float DEFAULT NULL,
  `amount` float DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `billdetails`
--

INSERT INTO `billdetails` (`billdetailsID`, `billID`, `productID`, `quantity`, `price`, `tax`, `subtotal`, `discount`, `amount`) VALUES
(1, 1, 12, 31, 920, 10, 31372, 0, 31372),
(2, 1, 6, 16, 1035, 10, 18216, 10, 16394.4),
(3, 1, 2, 28, 728, 10, 22422.4, 0, 22422.4),
(4, 1, 20, 10, 153, 0, 1530, 10, 1377),
(5, 2, 3, 49, 644, 10, 34711.6, 0, 34711.6),
(6, 2, 6, 40, 352, 10, 15488, 10, 13939.2),
(7, 2, 10, 31, 422, 0, 13082, 0, 13082),
(8, 2, 9, 20, 649, 10, 14278, 10, 12850.2),
(9, 2, 15, 42, 457, 0, 19194, 0, 19194),
(10, 3, 12, 28, 872, 0, 24416, 0, 24416),
(11, 3, 14, 24, 241, 10, 6362.4, 0, 6362.4),
(12, 3, 18, 48, 174, 0, 8352, 10, 7516.8),
(13, 3, 19, 35, 499, 10, 19211.5, 10, 17290.3),
(14, 3, 8, 49, 276, 10, 14876.4, 0, 14876.4),
(15, 3, 11, 11, 415, 0, 4565, 10, 4108.5),
(16, 4, 5, 10, 571, 0, 5710, 0, 5710),
(17, 4, 15, 10, 570, 0, 5700, 10, 5130),
(18, 4, 5, 17, 336, 0, 5712, 10, 5140.8),
(19, 5, 5, 10, 571, 0, 5710, 0, 5710),
(20, 5, 15, 10, 570, 0, 5700, 10, 5130),
(21, 5, 5, 17, 336, 0, 5712, 10, 5140.8);

-- --------------------------------------------------------

--
-- Table structure for table `bills`
--

CREATE TABLE `bills` (
  `billID` int(11) NOT NULL,
  `purchaseorderID` int(11) NOT NULL,
  `vendorID` int(11) NOT NULL,
  `billDate` datetime NOT NULL,
  `dueDate` datetime NOT NULL,
  `total` float NOT NULL,
  `description` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `userID` int(11) NOT NULL,
  `createdDate` datetime NOT NULL DEFAULT current_timestamp(),
  `updatedDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `bills`
--

INSERT INTO `bills` (`billID`, `purchaseorderID`, `vendorID`, `billDate`, `dueDate`, `total`, `description`, `userID`, `createdDate`, `updatedDate`) VALUES
(1, 1, 4, '2021-07-19 00:00:00', '2021-07-19 00:00:00', 71565.8, NULL, 9, '2021-07-19 18:51:54', '2021-07-19 18:51:54'),
(2, 2, 3, '2021-07-19 00:00:00', '2021-07-19 00:00:00', 93777, NULL, 9, '2021-07-19 18:52:11', '2021-07-19 18:52:11'),
(3, 3, 1, '2021-07-19 00:00:00', '2021-07-19 00:00:00', 74570.5, NULL, 9, '2021-07-19 18:53:11', '2021-07-19 18:53:11'),
(4, 5, 2, '2021-07-19 00:00:00', '2021-07-19 00:00:00', 15980.8, NULL, 9, '2021-07-19 18:53:19', '2021-07-19 18:53:19'),
(5, 5, 2, '2021-07-19 00:00:00', '2021-07-19 00:00:00', 15980.8, NULL, 9, '2021-07-19 18:53:29', '2021-07-19 18:53:29');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customerID` int(11) NOT NULL,
  `customerName` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `taxNumber` bigint(13) DEFAULT NULL,
  `address` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `unpaid` float DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT 1,
  `description` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customerID`, `customerName`, `taxNumber`, `address`, `phone`, `email`, `unpaid`, `status`, `description`) VALUES
(1, 'TIKI CORPORATION', 309532909, '29/1 Đường số 4, Khu phố 3 - Phường An Khánh - Thành phố Thủ Đức - TP Hồ Chí Minh.', '1900-6035', 'tiki@tiki.com', 50000, 1, NULL),
(2, 'NGUYEN KIM TRADING JSC.', 302286281, '63-65-67 Trần Hưng Đạo, Phường Cầu Ông Lãnh, Quận 1, Thành phố Hồ Chí Minh', '0838211211', 'nguyenkim@gmail.com', 2000, 1, NULL),
(3, 'Amazon.com, Inc', 123456789, '2111 7th Ave, Seattle, WA 98121, United States', '12062664064', 'amazon@gmail.com', 80000, 1, NULL),
(4, 'Lazada Việt Nam', 308808576, 'Saigon Centre, 67 Lê Lợi, P.Bến Nghé, Q1, TPHồ Chí Minh.', '1900636857', 'lazadavn@gmail.com', 0, 0, NULL),
(5, 'Công Ty TNHH Thương Mại nShop', 316713247, '66 Thành Thái P12 Q.10', '0909848921', 'game@nshop.com.vn', 20000, 0, NULL),
(6, 'AN PHAT COMPUTER TRADING JOINT STOCK COMPANY', 101468933, '158 - 160 Lý Thường Kiệt - Quận 10 - TPHCM', '0918.858.797', 'thaohtt@anphatpc.com.vn', 10000, 1, NULL),
(7, 'GamingWithEvets Inc.', 6664201337, '324 Tennis Tiger Str., GWE Ward, Tennis Tiger District, T.T.W., F.I.S.H.', '01226104247', 'gwe@gweinc.ttw', 0, 1, NULL),
(8, 'Công ty TNHH Shopee', 106773786, 'Tầng 4-5-6, Tòa nhà Capital Place, số 29 đường Liễu Giai, Phường Ngọc Khánh, Quận Ba Đình, Thành phố', '024 73081221', 'cskh@hotro.shopee.vn', NULL, 1, NULL),
(9, 'Công ty Cổ phần Công nghệ Sen Đỏ', 312776486, 'Tầng 3, Toà nhà B, Vườn Ươm Doanh Nghiệp, Lô D.01, Đường Tân Thuận, KCX Tân Thuận, Phường Tân ', '08 73001188', 'lienhe@sendo.vn', NULL, 1, NULL),
(10, 'CÔNG TY TNHH THE NEW XGEAR', 316898252, 'Số 26 Đường số 33, Phường An Phú, Thành phố Thủ Đức, Thành phố Hồ Chí Minh, Việt Nam', '02871081881', 'hotro@xgear.vn', NULL, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `exportdetails`
--

CREATE TABLE `exportdetails` (
  `exportdetailsID` int(11) NOT NULL,
  `exportID` int(11) NOT NULL,
  `productID` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `exportdetails`
--

INSERT INTO `exportdetails` (`exportdetailsID`, `exportID`, `productID`, `quantity`) VALUES
(1, 1, 6, 47),
(2, 2, 1, 40),
(3, 3, 19, 33);

-- --------------------------------------------------------

--
-- Table structure for table `exports`
--

CREATE TABLE `exports` (
  `exportID` int(11) NOT NULL,
  `invoiceID` int(11) NOT NULL,
  `exportDate` datetime NOT NULL,
  `customerID` int(11) NOT NULL,
  `description` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `userID` int(11) NOT NULL,
  `createdDate` datetime NOT NULL DEFAULT current_timestamp(),
  `updatedDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `exports`
--

INSERT INTO `exports` (`exportID`, `invoiceID`, `exportDate`, `customerID`, `description`, `userID`, `createdDate`, `updatedDate`) VALUES
(1, 5, '2021-07-19 00:00:00', 6, NULL, 9, '2021-07-19 19:14:36', '2021-07-19 19:14:36'),
(2, 3, '2021-07-19 00:00:00', 5, NULL, 9, '2021-07-19 19:14:54', '2021-07-19 19:14:54'),
(3, 1, '2021-07-20 00:00:00', 8, NULL, 9, '2021-07-20 17:20:59', '2021-07-20 17:20:59');

-- --------------------------------------------------------

--
-- Table structure for table `importdetails`
--

CREATE TABLE `importdetails` (
  `importdetailsID` int(11) NOT NULL,
  `importID` int(11) NOT NULL,
  `productID` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `importdetails`
--

INSERT INTO `importdetails` (`importdetailsID`, `importID`, `productID`, `quantity`) VALUES
(1, 1, 12, 31),
(2, 1, 6, 16),
(3, 1, 2, 28),
(4, 1, 20, 10),
(5, 2, 3, 49),
(6, 2, 6, 40),
(7, 2, 10, 31),
(8, 2, 9, 20),
(9, 2, 15, 42),
(10, 3, 12, 28),
(11, 3, 14, 24),
(12, 3, 18, 48),
(13, 3, 19, 35),
(14, 3, 8, 49),
(15, 3, 11, 11);

-- --------------------------------------------------------

--
-- Table structure for table `imports`
--

CREATE TABLE `imports` (
  `importID` int(11) NOT NULL,
  `billID` int(11) NOT NULL,
  `vendorID` int(11) NOT NULL,
  `importDate` datetime NOT NULL,
  `description` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `userID` int(11) NOT NULL,
  `createdDate` datetime NOT NULL DEFAULT current_timestamp(),
  `updatedDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `imports`
--

INSERT INTO `imports` (`importID`, `billID`, `vendorID`, `importDate`, `description`, `userID`, `createdDate`, `updatedDate`) VALUES
(1, 1, 4, '2021-07-19 00:00:00', NULL, 9, '2021-07-19 22:13:08', '2021-07-19 22:13:08'),
(2, 2, 3, '2021-07-19 00:00:00', NULL, 9, '2021-07-19 22:13:15', '2021-07-19 22:13:15'),
(3, 3, 1, '2021-07-19 00:00:00', NULL, 9, '2021-07-19 22:13:20', '2021-07-19 22:13:20');

-- --------------------------------------------------------

--
-- Table structure for table `invoicedetails`
--

CREATE TABLE `invoicedetails` (
  `invoicedetailsID` int(11) NOT NULL,
  `invoiceID` int(11) NOT NULL,
  `productID` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` float NOT NULL,
  `tax` float NOT NULL,
  `subtotal` float DEFAULT 0,
  `discount` float DEFAULT NULL,
  `amount` float DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `invoicedetails`
--

INSERT INTO `invoicedetails` (`invoicedetailsID`, `invoiceID`, `productID`, `quantity`, `price`, `tax`, `subtotal`, `discount`, `amount`) VALUES
(1, 1, 13, 33, 373, 10, 13539.9, 10, 12185.9),
(2, 2, 4, 49, 721, 0, 35329, 10, 31796.1),
(3, 3, 1, 40, 532, 10, 23408, 10, 21067.2),
(4, 4, 2, 46, 291, 10, 14724.6, 10, 13252.1),
(5, 5, 6, 47, 65, 0, 3055, 10, 2749.5),
(6, 6, 13, 14, 285, 10, 4389, 10, 3950.1),
(7, 7, 13, 23, 298, 0, 6854, 0, 6854),
(8, 7, 5, 38, 350, 0, 13300, 10, 11970),
(9, 7, 17, 38, 497, 0, 18886, 10, 16997.4),
(10, 7, 19, 47, 517, 0, 24299, 0, 24299);

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `invoiceID` int(11) NOT NULL,
  `orderID` int(11) NOT NULL,
  `customerID` int(11) NOT NULL,
  `invoiceDate` datetime NOT NULL,
  `dueDate` datetime NOT NULL,
  `total` float NOT NULL,
  `description` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `userID` int(11) NOT NULL,
  `createdDate` datetime NOT NULL DEFAULT current_timestamp(),
  `updatedDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`invoiceID`, `orderID`, `customerID`, `invoiceDate`, `dueDate`, `total`, `description`, `userID`, `createdDate`, `updatedDate`) VALUES
(1, 1, 8, '2021-07-19 00:00:00', '2021-07-19 00:00:00', 30628.9, NULL, 9, '2021-07-19 15:25:02', '2021-07-19 19:11:22'),
(2, 2, 1, '2021-07-19 00:00:00', '2021-07-19 00:00:00', 31796.1, NULL, 9, '2021-07-19 18:59:20', '2021-07-20 17:00:18'),
(3, 3, 5, '2021-07-19 00:00:00', '2021-07-19 00:00:00', 45713.2, NULL, 9, '2021-07-19 18:59:27', '2021-07-19 18:59:27'),
(4, 4, 1, '2021-07-19 00:00:00', '2021-07-19 00:00:00', 33094.1, NULL, 9, '2021-07-19 18:59:37', '2021-07-19 18:59:37'),
(5, 5, 6, '2021-07-19 00:00:00', '2021-07-19 00:00:00', 2749.5, NULL, 9, '2021-07-19 19:04:44', '2021-07-19 19:04:44'),
(6, 7, 5, '2021-07-19 00:00:00', '2021-07-19 00:00:00', 84345.8, NULL, 9, '2021-07-19 22:04:26', '2021-07-19 22:04:26'),
(7, 1, 8, '2021-07-19 00:00:00', '2021-07-19 00:00:00', 60120.4, NULL, 9, '2021-07-19 22:20:19', '2021-07-20 17:12:30');

-- --------------------------------------------------------

--
-- Table structure for table `payabledetails`
--

CREATE TABLE `payabledetails` (
  `payabledetailsID` int(11) NOT NULL,
  `payableID` int(11) NOT NULL,
  `billID` int(11) NOT NULL,
  `notes` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `amount` float DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `payabledetails`
--

INSERT INTO `payabledetails` (`payabledetailsID`, `payableID`, `billID`, `notes`, `amount`) VALUES
(1, 1, 1, NULL, 71565.8),
(2, 2, 3, NULL, 74570.5),
(3, 3, 4, NULL, 15980.8),
(4, 3, 5, NULL, 15980.8),
(7, 4, 1, NULL, 71565.8);

-- --------------------------------------------------------

--
-- Table structure for table `payables`
--

CREATE TABLE `payables` (
  `payableID` int(11) NOT NULL,
  `vendorID` int(11) NOT NULL,
  `payableDate` datetime NOT NULL,
  `total` float NOT NULL,
  `paymentMethod` int(11) NOT NULL,
  `description` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `userID` int(11) NOT NULL,
  `createdDate` datetime NOT NULL DEFAULT current_timestamp(),
  `updatedDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `payables`
--

INSERT INTO `payables` (`payableID`, `vendorID`, `payableDate`, `total`, `paymentMethod`, `description`, `userID`, `createdDate`, `updatedDate`) VALUES
(1, 4, '2021-07-19 00:00:00', 71565, 1, NULL, 9, '2021-07-19 19:53:49', '2021-07-19 19:53:49'),
(2, 1, '2021-07-19 00:00:00', 74570, 1, NULL, 9, '2021-07-19 19:53:54', '2021-07-19 19:53:54'),
(3, 2, '2021-07-19 00:00:00', 31961, 1, NULL, 9, '2021-07-19 19:58:42', '2021-07-19 19:58:42'),
(4, 4, '2021-07-19 00:00:00', 71565, 1, NULL, 9, '2021-07-19 22:12:21', '2021-07-19 22:12:55');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `productID` int(11) NOT NULL,
  `productName` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `manufacture` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `salesprice` float DEFAULT NULL,
  `purchaseprice` float DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `category` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `status` int(1) NOT NULL DEFAULT 1,
  `picture` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`productID`, `productName`, `manufacture`, `salesprice`, `purchaseprice`, `quantity`, `category`, `status`, `picture`, `description`) VALUES
(1, 'Nintendo Switch V2', 'Nintendo Company', 400, 300, 38, 'Console', 1, 'product1.jpg', NULL),
(2, 'PS5 Digital Edition', 'Sony Company', 1100, 700, 33, 'Console', 1, 'product2.jpg', NULL),
(3, 'Nintendo Switch Fortnite Special Edition', 'Nintendo Company', 400, 100, 99, 'Console', 1, 'product3.jpg', NULL),
(4, 'Animal Crossing', 'Nintendo Company', 400, 100, 70, 'Nintendo Games', 1, 'product4.jpg', NULL),
(5, 'Nintendo Switch Lite Coral', 'Nintendo Company', 350, 120, 80, 'Console', 1, 'product5.jpg', NULL),
(6, 'Nintendo Switch Lite Turquoise', 'Nintendo Company', 350, 120, 99, 'Console', 1, 'product6.jpg', NULL),
(7, 'Mario Kart Live Home Circuit', 'Nintendo Company', 300, 90, 100, 'Nintendo Games', 1, 'product7.jpg', NULL),
(8, 'PS4 - Grand Theft Auto V - GTAV', 'Sony Company', 600, 300, 69, 'PlayStation Games', 1, 'product8.jpg', NULL),
(9, 'PS4 - Cyberpunk 2077', 'Sony Company', 820, 620, 60, 'PlayStation Games', 1, 'product9.jpg', NULL),
(10, 'PS4 - FIFA 21', 'Sony Company', 650, 450, 91, 'PlayStation Games', 1, 'product10.jpg', NULL),
(11, 'PS4 - DRAGON BALL Z', 'Sony Company', 600, 400, 66, 'PlayStation Games', 1, 'product11.jpg', NULL),
(12, 'PS5 -  Assassins Creed Valhalla', 'Sony Company', 820, 620, 84, 'PlayStation Games', 1, 'product12.jpg', NULL),
(13, 'PS4 - Final Fantasy VII Remake', 'Square Enix', 910, 700, 10, 'PlayStation Games', 1, 'product13.jpg', NULL),
(14, 'PS5 Standard Edition', 'NDS', 1200, 800, 24, 'Console', 2, 'product14.jpg', NULL),
(15, 'PS5 DualSense', 'NDS', 300, 150, 57, 'Accessory', 1, 'product15.jpg', NULL),
(16, 'PS6 - Concept Art', 'Sony Company', 100, 50, 15, 'Accessory', 1, 'product16.jpg', NULL),
(17, 'WEEGEE Kart Live: Home Circuit', 'Dintonen Co., Ltd.', 80, 70, 100, 'Nintendo Games', 1, 'product17.jpg', NULL),
(18, 'Razer Hammerhead True Wireless Earbuds Pikachu Limited Edition', 'Razer', 55, 40, 98, 'Accessory', 1, 'product18.jpg', NULL),
(19, 'Game & Watch: Super WEEGEE Bros.', 'Dintonen Co., Ltd.', 200, 190, 102, 'Console', 1, 'product21.jpg', NULL),
(20, 'Mario', 'Nintendo Company', 200, 50, 210, 'Nintendo Games', 1, 'product22.jpg', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `purchaseorderdetails`
--

CREATE TABLE `purchaseorderdetails` (
  `purchaseorderdetailsID` int(11) NOT NULL,
  `purchaseorderID` int(11) NOT NULL,
  `productID` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` float NOT NULL,
  `tax` float DEFAULT NULL,
  `subtotal` float DEFAULT 0,
  `discount` float DEFAULT NULL,
  `amount` float DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `purchaseorderdetails`
--

INSERT INTO `purchaseorderdetails` (`purchaseorderdetailsID`, `purchaseorderID`, `productID`, `quantity`, `price`, `tax`, `subtotal`, `discount`, `amount`) VALUES
(1, 26, 15, 10, 300, 10, 3300, 10, 2970),
(2, 6, 16, 30, 100, 10, 3300, 0, 3300),
(3, 19, 12, 20, 820, 0, 16400, 10, 14760),
(4, 30, 15, 40, 300, 0, 12000, 10, 10800),
(5, 41, 12, 40, 820, 10, 36080, 10, 32472),
(6, 32, 1, 20, 400, 0, 8000, 10, 7200),
(7, 4, 4, 40, 400, 10, 17600, 10, 15840),
(8, 1, 12, 30, 820, 10, 27060, 0, 27060),
(9, 9, 8, 40, 600, 0, 24000, 0, 24000),
(10, 15, 12, 10, 820, 10, 9020, 0, 9020),
(11, 6, 13, 40, 910, 10, 40040, 10, 36036),
(12, 16, 6, 20, 350, 0, 7000, 10, 6300),
(13, 24, 7, 20, 300, 10, 6600, 0, 6600),
(14, 24, 4, 30, 400, 10, 13200, 0, 13200),
(15, 40, 18, 40, 55, 10, 2420, 10, 2178),
(16, 17, 10, 20, 650, 10, 14300, 0, 14300),
(17, 39, 6, 10, 350, 0, 3500, 0, 3500),
(18, 48, 16, 40, 100, 0, 4000, 0, 4000),
(19, 23, 10, 10, 650, 10, 7150, 10, 6435),
(20, 47, 4, 30, 400, 10, 13200, 10, 11880),
(21, 32, 14, 10, 1200, 0, 12000, 0, 12000),
(22, 47, 16, 20, 100, 0, 2000, 0, 2000),
(23, 29, 1, 40, 400, 10, 17600, 0, 17600),
(24, 46, 10, 20, 650, 0, 13000, 10, 11700),
(25, 31, 2, 10, 1100, 0, 11000, 0, 11000),
(26, 21, 20, 10, 200, 10, 2200, 10, 1980),
(27, 9, 10, 30, 650, 0, 19500, 10, 17550),
(28, 1, 6, 10, 350, 10, 3850, 10, 3465),
(29, 32, 8, 20, 600, 10, 13200, 0, 13200),
(30, 6, 17, 30, 80, 0, 2400, 0, 2400),
(31, 42, 12, 30, 820, 10, 27060, 10, 24354),
(32, 33, 10, 30, 650, 10, 21450, 10, 19305),
(33, 42, 19, 20, 200, 0, 4000, 0, 4000),
(34, 34, 18, 40, 55, 0, 2200, 0, 2200),
(35, 45, 1, 30, 400, 0, 12000, 0, 12000),
(36, 50, 12, 40, 820, 0, 32800, 0, 32800),
(37, 6, 1, 20, 400, 0, 8000, 10, 7200),
(38, 37, 3, 20, 400, 0, 8000, 10, 7200),
(39, 36, 11, 10, 600, 10, 6600, 10, 5940),
(40, 22, 20, 30, 200, 10, 6600, 10, 5940),
(41, 46, 20, 30, 200, 10, 6600, 0, 6600),
(42, 42, 20, 40, 200, 10, 8800, 10, 7920),
(43, 25, 7, 40, 300, 0, 12000, 0, 12000),
(44, 8, 19, 40, 200, 0, 8000, 10, 7200),
(45, 14, 19, 40, 200, 10, 8800, 10, 7920),
(46, 5, 5, 10, 350, 0, 3500, 0, 3500),
(47, 22, 2, 20, 1100, 10, 24200, 10, 21780),
(48, 50, 16, 10, 100, 10, 1100, 0, 1100),
(49, 18, 6, 40, 350, 0, 14000, 0, 14000),
(50, 9, 16, 40, 100, 10, 4400, 0, 4400),
(51, 7, 1, 30, 400, 0, 12000, 10, 10800),
(52, 14, 11, 20, 600, 0, 12000, 0, 12000),
(53, 10, 13, 40, 910, 10, 40040, 10, 36036),
(54, 47, 18, 20, 55, 0, 1100, 0, 1100),
(55, 49, 10, 40, 650, 10, 28600, 10, 25740),
(56, 17, 10, 20, 650, 10, 14300, 0, 14300),
(57, 13, 5, 50, 350, 0, 17500, 0, 17500),
(58, 48, 20, 40, 200, 10, 8800, 10, 7920),
(59, 1, 2, 20, 1100, 10, 24200, 0, 24200),
(60, 5, 15, 10, 300, 0, 3000, 10, 2700),
(61, 30, 12, 20, 820, 10, 18040, 0, 18040),
(62, 5, 5, 10, 350, 0, 3500, 10, 3150),
(63, 7, 9, 10, 820, 0, 8200, 10, 7380),
(64, 39, 4, 30, 400, 0, 12000, 0, 12000),
(65, 43, 8, 10, 600, 0, 6000, 0, 6000),
(66, 19, 11, 40, 600, 0, 24000, 0, 24000),
(67, 21, 2, 30, 1100, 0, 33000, 0, 33000),
(68, 34, 6, 10, 350, 10, 3850, 10, 3465),
(69, 4, 6, 20, 350, 0, 7000, 0, 7000),
(70, 43, 17, 10, 80, 10, 880, 10, 792),
(71, 50, 10, 30, 650, 0, 19500, 10, 17550),
(72, 16, 19, 20, 200, 10, 4400, 10, 3960),
(73, 23, 13, 20, 910, 0, 18200, 10, 16380),
(74, 23, 5, 40, 350, 0, 14000, 0, 14000),
(75, 46, 14, 40, 1200, 0, 48000, 10, 43200),
(76, 42, 19, 40, 200, 10, 8800, 10, 7920),
(77, 46, 20, 10, 200, 0, 2000, 0, 2000),
(78, 45, 20, 30, 200, 0, 6000, 0, 6000),
(79, 23, 18, 20, 55, 0, 1100, 10, 990),
(80, 30, 10, 30, 650, 0, 19500, 0, 19500),
(81, 34, 4, 10, 400, 0, 4000, 0, 4000),
(82, 29, 12, 20, 820, 10, 18040, 0, 18040),
(83, 49, 9, 10, 820, 10, 9020, 0, 9020),
(84, 20, 2, 10, 1100, 0, 11000, 10, 9900),
(85, 48, 20, 40, 200, 0, 8000, 10, 7200),
(86, 27, 3, 30, 400, 10, 13200, 10, 11880),
(87, 34, 13, 20, 910, 10, 20020, 10, 18018),
(88, 7, 5, 30, 350, 10, 11550, 0, 11550),
(89, 26, 19, 10, 200, 10, 2200, 10, 1980),
(90, 9, 3, 10, 400, 0, 4000, 0, 4000),
(91, 38, 9, 40, 820, 10, 36080, 10, 32472),
(92, 24, 18, 10, 55, 0, 550, 0, 550),
(93, 6, 7, 20, 300, 0, 6000, 10, 5400),
(94, 46, 7, 30, 300, 0, 9000, 10, 8100),
(95, 3, 12, 20, 820, 0, 16400, 0, 16400),
(96, 36, 4, 10, 400, 0, 4000, 0, 4000),
(97, 4, 8, 20, 600, 10, 13200, 0, 13200),
(98, 31, 16, 30, 100, 10, 3300, 10, 2970),
(99, 46, 14, 40, 1200, 10, 52800, 10, 47520),
(100, 21, 3, 40, 400, 0, 16000, 10, 14400),
(101, 24, 17, 50, 80, 0, 4000, 0, 4000),
(102, 3, 14, 20, 1200, 10, 26400, 0, 26400),
(103, 43, 10, 20, 650, 10, 14300, 10, 12870),
(104, 24, 8, 10, 600, 0, 6000, 10, 5400),
(105, 41, 3, 40, 400, 10, 17600, 10, 15840),
(106, 39, 14, 40, 1200, 10, 52800, 0, 52800),
(107, 11, 2, 30, 1100, 10, 36300, 10, 32670),
(108, 29, 12, 40, 820, 0, 32800, 0, 32800),
(109, 20, 15, 20, 300, 10, 6600, 10, 5940),
(110, 25, 7, 10, 300, 0, 3000, 0, 3000),
(111, 28, 13, 20, 910, 10, 20020, 10, 18018),
(112, 39, 18, 30, 55, 10, 1815, 0, 1815),
(113, 37, 20, 30, 200, 10, 6600, 0, 6600),
(114, 3, 18, 40, 55, 0, 2200, 10, 1980),
(115, 28, 12, 20, 820, 10, 18040, 10, 16236),
(116, 16, 13, 10, 910, 10, 10010, 10, 9009),
(117, 18, 7, 30, 300, 10, 9900, 0, 9900),
(118, 47, 8, 40, 600, 10, 26400, 0, 26400),
(119, 44, 7, 40, 300, 0, 12000, 0, 12000),
(120, 14, 20, 20, 200, 10, 4400, 0, 4400),
(121, 1, 20, 10, 200, 0, 2000, 10, 1800),
(122, 6, 17, 40, 80, 0, 3200, 10, 2880),
(123, 15, 11, 40, 600, 0, 24000, 10, 21600),
(124, 35, 18, 30, 55, 10, 1815, 0, 1815),
(125, 48, 18, 40, 55, 10, 2420, 10, 2178),
(126, 27, 14, 40, 1200, 10, 52800, 10, 47520),
(127, 41, 11, 10, 600, 0, 6000, 10, 5400),
(128, 13, 4, 40, 400, 0, 16000, 10, 14400),
(129, 4, 7, 30, 300, 10, 9900, 10, 8910),
(130, 3, 19, 30, 200, 10, 6600, 10, 5940),
(131, 47, 7, 20, 300, 0, 6000, 0, 6000),
(132, 6, 20, 50, 200, 10, 11000, 0, 11000),
(133, 2, 3, 40, 400, 10, 17600, 0, 17600),
(134, 26, 5, 20, 350, 10, 7700, 0, 7700),
(135, 22, 16, 10, 100, 0, 1000, 0, 1000),
(136, 50, 2, 30, 1100, 0, 33000, 0, 33000),
(137, 21, 15, 10, 300, 10, 3300, 0, 3300),
(138, 2, 6, 40, 350, 10, 15400, 10, 13860),
(139, 6, 15, 10, 300, 10, 3300, 0, 3300),
(140, 36, 7, 40, 300, 10, 13200, 0, 13200),
(141, 15, 15, 30, 300, 10, 9900, 10, 8910),
(142, 40, 5, 20, 350, 0, 7000, 0, 7000),
(143, 29, 18, 30, 55, 0, 1650, 10, 1485),
(144, 19, 5, 40, 350, 10, 15400, 0, 15400),
(145, 29, 11, 10, 600, 0, 6000, 0, 6000),
(146, 42, 20, 20, 200, 0, 4000, 0, 4000),
(147, 20, 13, 30, 910, 0, 27300, 0, 27300),
(148, 44, 19, 30, 200, 0, 6000, 10, 5400),
(149, 21, 11, 20, 600, 0, 12000, 0, 12000),
(150, 49, 16, 30, 100, 0, 3000, 10, 2700),
(151, 48, 3, 30, 400, 0, 12000, 10, 10800),
(152, 38, 15, 30, 300, 0, 9000, 10, 8100),
(153, 48, 14, 30, 1200, 10, 39600, 10, 35640),
(154, 4, 15, 30, 300, 0, 9000, 10, 8100),
(155, 41, 10, 20, 650, 10, 14300, 0, 14300),
(156, 6, 8, 20, 600, 0, 12000, 0, 12000),
(157, 29, 6, 20, 350, 0, 7000, 10, 6300),
(158, 2, 10, 30, 650, 0, 19500, 0, 19500),
(159, 7, 19, 40, 200, 10, 8800, 10, 7920),
(160, 45, 13, 30, 910, 0, 27300, 0, 27300),
(161, 25, 19, 20, 200, 0, 4000, 10, 3600),
(162, 14, 5, 10, 350, 0, 3500, 10, 3150),
(163, 42, 6, 10, 350, 10, 3850, 0, 3850),
(164, 22, 5, 40, 350, 10, 15400, 10, 13860),
(165, 14, 8, 20, 600, 10, 13200, 0, 13200),
(166, 36, 12, 10, 820, 0, 8200, 0, 8200),
(167, 38, 4, 30, 400, 10, 13200, 10, 11880),
(168, 23, 3, 10, 400, 0, 4000, 0, 4000),
(169, 13, 7, 20, 300, 10, 6600, 10, 5940),
(170, 37, 18, 40, 55, 0, 2200, 0, 2200),
(171, 31, 5, 40, 350, 10, 15400, 10, 13860),
(172, 9, 2, 10, 1100, 0, 11000, 10, 9900),
(173, 22, 5, 30, 350, 10, 11550, 0, 11550),
(174, 12, 9, 50, 820, 0, 41000, 10, 36900),
(175, 3, 8, 40, 600, 10, 26400, 0, 26400),
(176, 26, 3, 40, 400, 10, 17600, 0, 17600),
(177, 12, 17, 10, 80, 10, 880, 10, 792),
(178, 49, 8, 10, 600, 10, 6600, 0, 6600),
(179, 11, 10, 30, 650, 10, 21450, 10, 19305),
(180, 44, 19, 30, 200, 10, 6600, 0, 6600),
(181, 33, 15, 10, 300, 10, 3300, 0, 3300),
(182, 26, 2, 30, 1100, 0, 33000, 10, 29700),
(183, 48, 9, 10, 820, 0, 8200, 10, 7380),
(184, 23, 16, 20, 100, 0, 2000, 0, 2000),
(185, 44, 6, 20, 350, 0, 7000, 0, 7000),
(186, 35, 11, 20, 600, 0, 12000, 10, 10800),
(187, 2, 9, 20, 820, 10, 18040, 10, 16236),
(188, 9, 7, 30, 300, 10, 9900, 0, 9900),
(189, 37, 15, 30, 300, 0, 9000, 10, 8100),
(190, 50, 20, 40, 200, 10, 8800, 0, 8800),
(191, 40, 2, 20, 1100, 0, 22000, 0, 22000),
(192, 2, 15, 40, 300, 0, 12000, 0, 12000),
(193, 48, 11, 50, 600, 10, 33000, 10, 29700),
(194, 28, 18, 50, 55, 10, 3025, 0, 3025),
(195, 33, 17, 20, 80, 10, 1760, 10, 1584),
(196, 48, 13, 30, 910, 0, 27300, 10, 24570),
(197, 33, 10, 40, 650, 10, 28600, 0, 28600),
(198, 39, 11, 10, 600, 0, 6000, 10, 5400),
(199, 34, 10, 40, 650, 0, 26000, 10, 23400),
(200, 3, 11, 10, 600, 0, 6000, 10, 5400),
(201, 51, 19, 10, 190, 0, 1900, 0, 1900),
(202, 51, 7, 30, 90, 0, 2700, 0, 2700),
(203, 52, 19, 50, 190, 0, 9500, 0, 9500),
(204, 52, 4, 20, 100, 0, 2000, 0, 2000);

-- --------------------------------------------------------

--
-- Table structure for table `purchaseorders`
--

CREATE TABLE `purchaseorders` (
  `purchaseorderID` int(11) NOT NULL,
  `vendorID` int(11) NOT NULL,
  `purchaseorderDate` datetime NOT NULL,
  `total` float NOT NULL,
  `description` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `userID` int(11) NOT NULL,
  `createdDate` datetime NOT NULL DEFAULT current_timestamp(),
  `updatedDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `purchaseorders`
--

INSERT INTO `purchaseorders` (`purchaseorderID`, `vendorID`, `purchaseorderDate`, `total`, `description`, `userID`, `createdDate`, `updatedDate`) VALUES
(1, 4, '2021-02-15 00:00:00', 56525, NULL, 10, '2021-07-19 11:46:53', NULL),
(2, 3, '2021-06-21 00:00:00', 79196, NULL, 5, '2021-07-19 11:46:53', NULL),
(3, 1, '2021-06-17 00:00:00', 82520, NULL, 10, '2021-07-19 11:46:53', NULL),
(4, 3, '2021-03-26 00:00:00', 53050, NULL, 4, '2021-07-19 11:46:53', '2021-07-19 14:29:58'),
(5, 2, '2021-03-23 00:00:00', 9350, NULL, 11, '2021-07-19 11:46:53', NULL),
(6, 3, '2021-03-05 00:00:00', 83516, NULL, 2, '2021-07-19 11:46:53', NULL),
(7, 2, '2021-05-03 00:00:00', 37650, NULL, 10, '2021-07-19 11:46:53', NULL),
(8, 7, '2021-03-09 00:00:00', 7200, NULL, 10, '2021-07-19 11:46:53', NULL),
(9, 7, '2021-01-02 00:00:00', 69750, NULL, 3, '2021-07-19 11:46:53', NULL),
(10, 1, '2021-02-17 00:00:00', 36036, NULL, 4, '2021-07-19 11:46:53', NULL),
(11, 7, '2021-05-28 00:00:00', 51975, NULL, 4, '2021-07-19 11:46:53', NULL),
(12, 1, '2021-02-16 00:00:00', 37692, NULL, 8, '2021-07-19 11:46:53', NULL),
(13, 7, '2021-05-26 00:00:00', 37840, NULL, 4, '2021-07-19 11:46:53', NULL),
(14, 7, '2021-04-24 00:00:00', 40670, NULL, 1, '2021-07-19 11:46:53', NULL),
(15, 5, '2021-01-04 00:00:00', 39530, NULL, 2, '2021-07-19 11:46:53', NULL),
(16, 7, '2021-06-27 00:00:00', 19269, NULL, 6, '2021-07-19 11:46:53', NULL),
(17, 2, '2021-04-23 00:00:00', 28600, NULL, 2, '2021-07-19 11:46:53', NULL),
(18, 6, '2021-06-05 00:00:00', 23900, NULL, 8, '2021-07-19 11:46:53', NULL),
(19, 7, '2021-02-08 00:00:00', 54160, NULL, 3, '2021-07-19 11:46:53', NULL),
(20, 8, '2021-05-08 00:00:00', 43140, NULL, 10, '2021-07-19 11:46:53', NULL),
(21, 6, '2021-03-03 00:00:00', 64680, NULL, 2, '2021-07-19 11:46:53', NULL),
(22, 6, '2021-04-25 00:00:00', 54130, NULL, 7, '2021-07-19 11:46:53', NULL),
(23, 7, '2021-03-02 00:00:00', 43805, NULL, 7, '2021-07-19 11:46:53', NULL),
(24, 3, '2021-05-12 00:00:00', 29750, NULL, 10, '2021-07-19 11:46:53', NULL),
(25, 6, '2021-01-02 00:00:00', 18600, NULL, 3, '2021-07-19 11:46:53', NULL),
(26, 8, '2021-01-16 00:00:00', 59950, NULL, 4, '2021-07-19 11:46:53', NULL),
(27, 7, '2021-01-12 00:00:00', 59400, NULL, 9, '2021-07-19 11:46:53', NULL),
(28, 8, '2021-06-18 00:00:00', 37279, NULL, 7, '2021-07-19 11:46:53', NULL),
(29, 2, '2021-06-01 00:00:00', 82225, NULL, 3, '2021-07-19 11:46:53', NULL),
(30, 5, '2021-04-29 00:00:00', 48340, NULL, 3, '2021-07-19 11:46:53', NULL),
(31, 3, '2021-04-05 00:00:00', 27830, NULL, 1, '2021-07-19 11:46:53', NULL),
(32, 4, '2021-02-16 00:00:00', 32400, NULL, 9, '2021-07-19 11:46:53', NULL),
(33, 4, '2021-05-14 00:00:00', 52789, NULL, 7, '2021-07-19 11:46:53', NULL),
(34, 1, '2021-03-30 00:00:00', 51083, NULL, 1, '2021-07-19 11:46:53', NULL),
(35, 6, '2021-03-25 00:00:00', 12615, NULL, 6, '2021-07-19 11:46:53', NULL),
(36, 8, '2021-05-19 00:00:00', 31340, NULL, 4, '2021-07-19 11:46:53', NULL),
(37, 1, '2021-04-10 00:00:00', 24100, NULL, 11, '2021-07-19 11:46:53', NULL),
(38, 1, '2021-03-29 00:00:00', 52452, NULL, 8, '2021-07-19 11:46:53', NULL),
(39, 4, '2021-06-13 00:00:00', 75515, NULL, 9, '2021-07-19 11:46:53', NULL),
(40, 4, '2021-03-12 00:00:00', 31178, NULL, 4, '2021-07-19 11:46:53', NULL),
(41, 4, '2021-05-02 00:00:00', 68012, NULL, 6, '2021-07-19 11:46:53', NULL),
(42, 1, '2021-06-10 00:00:00', 52044, NULL, 8, '2021-07-19 11:46:53', NULL),
(43, 6, '2021-04-17 00:00:00', 19662, NULL, 8, '2021-07-19 11:46:53', NULL),
(44, 8, '2021-03-03 00:00:00', 31000, NULL, 10, '2021-07-19 11:46:53', NULL),
(45, 1, '2021-01-29 00:00:00', 45300, NULL, 6, '2021-07-19 11:46:53', NULL),
(46, 6, '2021-01-31 00:00:00', 119120, NULL, 6, '2021-07-19 11:46:53', NULL),
(47, 5, '2021-02-04 00:00:00', 47380, NULL, 10, '2021-07-19 11:46:53', NULL),
(48, 7, '2021-06-13 00:00:00', 129388, NULL, 6, '2021-07-19 11:46:53', NULL),
(49, 7, '2021-01-21 00:00:00', 44060, NULL, 7, '2021-07-19 11:46:53', NULL),
(50, 3, '2021-01-03 00:00:00', 93250, NULL, 7, '2021-07-19 11:46:53', NULL),
(51, 7, '2021-07-20 00:00:00', 4600, NULL, 9, '2021-07-20 17:05:31', '2021-07-20 17:05:31'),
(52, 7, '2021-07-20 00:00:00', 11500, NULL, 9, '2021-07-20 17:06:49', '2021-07-20 17:06:49');

-- --------------------------------------------------------

--
-- Table structure for table `receivabledetails`
--

CREATE TABLE `receivabledetails` (
  `receivabledetailsID` int(11) NOT NULL,
  `receivableID` int(11) NOT NULL,
  `invoiceID` int(11) NOT NULL,
  `notes` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `amount` float DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `receivabledetails`
--

INSERT INTO `receivabledetails` (`receivabledetailsID`, `receivableID`, `invoiceID`, `notes`, `amount`) VALUES
(1, 1, 2, NULL, 59719.9),
(2, 2, 5, NULL, 2749.5),
(3, 3, 1, NULL, 30628.9),
(4, 4, 6, NULL, 84345.8),
(5, 4, 3, NULL, 45713.2),
(6, 5, 7, NULL, 60120.4);

-- --------------------------------------------------------

--
-- Table structure for table `receivables`
--

CREATE TABLE `receivables` (
  `receivableID` int(11) NOT NULL,
  `customerID` int(11) NOT NULL,
  `receivableDate` datetime NOT NULL,
  `total` float NOT NULL,
  `paymentMethod` int(11) NOT NULL,
  `description` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `userID` int(11) NOT NULL,
  `createdDate` datetime NOT NULL DEFAULT current_timestamp(),
  `updatedDate` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `receivables`
--

INSERT INTO `receivables` (`receivableID`, `customerID`, `receivableDate`, `total`, `paymentMethod`, `description`, `userID`, `createdDate`, `updatedDate`) VALUES
(1, 1, '2021-07-19 00:00:00', 59719, 1, NULL, 9, '2021-07-19 19:07:14', '2021-07-19 19:07:14'),
(2, 6, '2021-07-19 00:00:00', 2749, 1, NULL, 9, '2021-07-19 19:07:20', '2021-07-19 19:07:20'),
(3, 8, '2021-07-19 00:00:00', 30628, 1, NULL, 9, '2021-07-19 19:12:41', '2021-07-19 19:13:23'),
(4, 5, '2021-07-19 00:00:00', 130059, 1, NULL, 9, '2021-07-19 22:11:37', '2021-07-19 22:11:37'),
(5, 8, '2021-07-19 00:00:00', 60120.4, 1, NULL, 9, '2021-07-19 22:20:37', '2021-07-20 17:19:32');

-- --------------------------------------------------------

--
-- Table structure for table `saleorderdetails`
--

CREATE TABLE `saleorderdetails` (
  `saleorderdetailsID` int(11) NOT NULL,
  `orderID` int(11) NOT NULL,
  `productID` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` float NOT NULL,
  `tax` float DEFAULT NULL,
  `subtotal` float DEFAULT 0,
  `discount` float DEFAULT NULL,
  `amount` float DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `saleorderdetails`
--

INSERT INTO `saleorderdetails` (`saleorderdetailsID`, `orderID`, `productID`, `quantity`, `price`, `tax`, `subtotal`, `discount`, `amount`) VALUES
(1, 31, 11, 20, 600, 10, 13200, 10, 11880),
(2, 39, 10, 10, 650, 0, 6500, 0, 6500),
(3, 39, 19, 10, 200, 0, 2000, 10, 1800),
(4, 30, 14, 30, 1200, 10, 39600, 10, 35640),
(5, 38, 6, 20, 350, 0, 7000, 0, 7000),
(6, 45, 1, 50, 400, 10, 22000, 10, 19800),
(7, 14, 9, 40, 820, 0, 32800, 10, 29520),
(8, 11, 6, 50, 350, 0, 17500, 10, 15750),
(9, 35, 18, 20, 55, 0, 1100, 10, 990),
(10, 18, 20, 10, 200, 0, 2000, 10, 1800),
(11, 18, 13, 30, 910, 10, 30030, 10, 27027),
(12, 2, 4, 40, 400, 0, 16000, 10, 14400),
(13, 4, 2, 40, 1100, 10, 48400, 10, 43560),
(14, 28, 11, 10, 600, 0, 6000, 10, 5400),
(15, 1, 13, 20, 910, 0, 18200, 0, 18200),
(16, 28, 3, 10, 400, 0, 4000, 0, 4000),
(17, 18, 19, 50, 200, 10, 11000, 0, 11000),
(18, 33, 4, 10, 400, 0, 4000, 10, 3600),
(19, 32, 7, 20, 300, 10, 6600, 0, 6600),
(20, 23, 18, 20, 55, 10, 1210, 10, 1089),
(21, 7, 13, 10, 910, 10, 10010, 10, 9009),
(22, 10, 20, 40, 200, 10, 8800, 0, 8800),
(23, 46, 12, 10, 820, 10, 9020, 0, 9020),
(24, 42, 16, 20, 100, 10, 2200, 0, 2200),
(25, 1, 5, 30, 350, 0, 10500, 10, 9450),
(26, 20, 2, 10, 1100, 10, 12100, 10, 10890),
(27, 42, 10, 40, 650, 0, 26000, 10, 23400),
(28, 27, 10, 40, 650, 0, 26000, 0, 26000),
(29, 37, 12, 10, 820, 0, 8200, 0, 8200),
(30, 28, 14, 10, 1200, 0, 12000, 0, 12000),
(31, 30, 1, 20, 400, 10, 8800, 10, 7920),
(32, 20, 5, 40, 350, 0, 14000, 0, 14000),
(33, 40, 10, 40, 650, 10, 28600, 10, 25740),
(34, 23, 1, 40, 400, 0, 16000, 10, 14400),
(35, 34, 5, 20, 350, 0, 7000, 0, 7000),
(36, 11, 1, 40, 400, 0, 16000, 0, 16000),
(37, 31, 16, 10, 100, 10, 1100, 10, 990),
(38, 18, 8, 10, 600, 10, 6600, 10, 5940),
(39, 30, 11, 40, 600, 10, 26400, 10, 23760),
(40, 15, 15, 30, 300, 0, 9000, 0, 9000),
(41, 12, 16, 30, 100, 0, 3000, 0, 3000),
(42, 8, 9, 40, 820, 0, 32800, 0, 32800),
(43, 50, 5, 40, 350, 10, 15400, 0, 15400),
(44, 22, 11, 40, 600, 10, 26400, 10, 23760),
(45, 38, 4, 50, 400, 0, 20000, 10, 18000),
(46, 50, 8, 20, 600, 0, 12000, 0, 12000),
(47, 38, 19, 40, 200, 0, 8000, 10, 7200),
(48, 1, 17, 30, 80, 0, 2400, 10, 2160),
(49, 37, 4, 30, 400, 10, 13200, 0, 13200),
(50, 39, 18, 40, 55, 10, 2420, 0, 2420),
(51, 46, 2, 40, 1100, 10, 48400, 10, 43560),
(52, 18, 8, 40, 600, 0, 24000, 0, 24000),
(53, 13, 18, 10, 55, 10, 605, 10, 544.5),
(54, 2, 5, 40, 350, 10, 15400, 0, 15400),
(55, 6, 11, 30, 600, 10, 19800, 10, 17820),
(56, 44, 2, 10, 1100, 0, 11000, 0, 11000),
(57, 39, 4, 20, 400, 10, 8800, 0, 8800),
(58, 50, 15, 10, 300, 10, 3300, 0, 3300),
(59, 10, 17, 10, 80, 10, 880, 10, 792),
(60, 24, 1, 30, 400, 10, 13200, 10, 11880),
(61, 41, 8, 40, 600, 0, 24000, 10, 21600),
(62, 14, 5, 40, 350, 0, 14000, 10, 12600),
(63, 19, 7, 10, 300, 10, 3300, 10, 2970),
(64, 46, 9, 10, 820, 0, 8200, 10, 7380),
(65, 13, 12, 30, 820, 10, 27060, 0, 27060),
(66, 37, 8, 30, 600, 0, 18000, 10, 16200),
(67, 11, 5, 40, 350, 10, 15400, 0, 15400),
(68, 42, 3, 30, 400, 10, 13200, 10, 11880),
(69, 14, 15, 40, 300, 0, 12000, 0, 12000),
(70, 41, 3, 10, 400, 10, 4400, 10, 3960),
(71, 42, 9, 30, 820, 10, 27060, 0, 27060),
(72, 13, 2, 20, 1100, 0, 22000, 0, 22000),
(73, 19, 18, 20, 55, 0, 1100, 10, 990),
(74, 40, 6, 40, 350, 10, 15400, 0, 15400),
(75, 29, 7, 20, 300, 0, 6000, 10, 5400),
(76, 12, 18, 20, 55, 10, 1210, 10, 1089),
(77, 32, 13, 30, 910, 10, 30030, 0, 30030),
(78, 8, 5, 30, 350, 0, 10500, 10, 9450),
(79, 31, 6, 10, 350, 10, 3850, 0, 3850),
(80, 30, 10, 20, 650, 0, 13000, 0, 13000),
(81, 19, 13, 10, 910, 10, 10010, 0, 10010),
(82, 3, 1, 40, 400, 10, 17600, 10, 15840),
(83, 46, 10, 40, 650, 10, 28600, 10, 25740),
(84, 12, 20, 30, 200, 10, 6600, 10, 5940),
(85, 50, 20, 10, 200, 0, 2000, 10, 1800),
(86, 11, 6, 30, 350, 10, 11550, 10, 10395),
(87, 14, 2, 10, 1100, 0, 11000, 0, 11000),
(88, 26, 7, 40, 300, 0, 12000, 0, 12000),
(89, 16, 1, 10, 400, 0, 4000, 0, 4000),
(90, 22, 4, 40, 400, 10, 17600, 10, 15840),
(91, 9, 13, 30, 910, 10, 30030, 0, 30030),
(92, 39, 14, 20, 1200, 10, 26400, 10, 23760),
(93, 23, 13, 40, 910, 0, 36400, 0, 36400),
(94, 17, 4, 20, 400, 0, 8000, 10, 7200),
(95, 37, 14, 40, 1200, 10, 52800, 0, 52800),
(96, 31, 6, 20, 350, 0, 7000, 0, 7000),
(97, 33, 10, 30, 650, 10, 21450, 0, 21450),
(98, 20, 9, 10, 820, 10, 9020, 10, 8118),
(99, 45, 3, 40, 400, 10, 17600, 10, 15840),
(100, 35, 10, 50, 650, 0, 32500, 10, 29250),
(101, 16, 14, 10, 1200, 0, 12000, 10, 10800),
(102, 13, 7, 40, 300, 10, 13200, 0, 13200),
(103, 19, 17, 40, 80, 10, 3520, 10, 3168),
(104, 7, 7, 10, 300, 0, 3000, 0, 3000),
(105, 18, 3, 10, 400, 10, 4400, 0, 4400),
(106, 34, 11, 40, 600, 10, 26400, 10, 23760),
(107, 19, 16, 40, 100, 10, 4400, 10, 3960),
(108, 28, 7, 30, 300, 0, 9000, 0, 9000),
(109, 24, 3, 40, 400, 10, 17600, 0, 17600),
(110, 15, 14, 10, 1200, 0, 12000, 0, 12000),
(111, 23, 2, 40, 1100, 10, 48400, 10, 43560),
(112, 23, 11, 40, 600, 10, 26400, 10, 23760),
(113, 21, 3, 30, 400, 10, 13200, 10, 11880),
(114, 33, 7, 40, 300, 10, 13200, 10, 11880),
(115, 26, 20, 10, 200, 0, 2000, 10, 1800),
(116, 19, 16, 40, 100, 10, 4400, 10, 3960),
(117, 20, 13, 30, 910, 10, 30030, 0, 30030),
(118, 40, 18, 30, 55, 0, 1650, 10, 1485),
(119, 18, 13, 20, 910, 0, 18200, 10, 16380),
(120, 38, 6, 10, 350, 0, 3500, 10, 3150),
(121, 46, 6, 30, 350, 0, 10500, 10, 9450),
(122, 16, 4, 30, 400, 0, 12000, 10, 10800),
(123, 25, 9, 20, 820, 0, 16400, 10, 14760),
(124, 48, 19, 20, 200, 0, 4000, 10, 3600),
(125, 37, 7, 40, 300, 10, 13200, 0, 13200),
(126, 39, 8, 40, 600, 0, 24000, 0, 24000),
(127, 48, 5, 30, 350, 10, 11550, 0, 11550),
(128, 22, 11, 30, 600, 0, 18000, 0, 18000),
(129, 8, 12, 20, 820, 10, 18040, 10, 16236),
(130, 12, 9, 40, 820, 0, 32800, 10, 29520),
(131, 11, 15, 30, 300, 10, 9900, 10, 8910),
(132, 47, 20, 10, 200, 10, 2200, 10, 1980),
(133, 13, 19, 40, 200, 10, 8800, 0, 8800),
(134, 43, 14, 40, 1200, 10, 52800, 10, 47520),
(135, 40, 11, 20, 600, 10, 13200, 10, 11880),
(136, 26, 10, 20, 650, 10, 14300, 0, 14300),
(137, 3, 14, 30, 1200, 0, 36000, 0, 36000),
(138, 49, 6, 40, 350, 0, 14000, 10, 12600),
(139, 42, 8, 20, 600, 10, 13200, 0, 13200),
(140, 9, 3, 10, 400, 10, 4400, 10, 3960),
(141, 47, 3, 20, 400, 0, 8000, 0, 8000),
(142, 12, 10, 40, 650, 0, 26000, 10, 23400),
(143, 31, 15, 30, 300, 0, 9000, 0, 9000),
(144, 19, 2, 40, 1100, 0, 44000, 0, 44000),
(145, 40, 19, 30, 200, 0, 6000, 10, 5400),
(146, 2, 5, 20, 350, 0, 7000, 10, 6300),
(147, 7, 15, 30, 300, 10, 9900, 0, 9900),
(148, 7, 11, 10, 600, 10, 6600, 0, 6600),
(149, 16, 6, 40, 350, 10, 15400, 0, 15400),
(150, 31, 18, 20, 55, 10, 1210, 0, 1210),
(151, 40, 2, 40, 1100, 0, 44000, 0, 44000),
(152, 18, 20, 40, 200, 10, 8800, 10, 7920),
(153, 4, 4, 10, 400, 0, 4000, 10, 3600),
(154, 20, 16, 40, 100, 0, 4000, 10, 3600),
(155, 39, 5, 20, 350, 0, 7000, 10, 6300),
(156, 28, 16, 20, 100, 10, 2200, 0, 2200),
(157, 29, 19, 40, 200, 0, 8000, 0, 8000),
(158, 26, 2, 30, 1100, 10, 36300, 10, 32670),
(159, 7, 7, 50, 300, 10, 16500, 10, 14850),
(160, 9, 15, 20, 300, 10, 6600, 0, 6600),
(161, 4, 18, 10, 55, 0, 550, 0, 550),
(162, 50, 13, 40, 910, 10, 40040, 10, 36036),
(163, 13, 14, 10, 1200, 0, 12000, 10, 10800),
(164, 18, 7, 20, 300, 0, 6000, 10, 5400),
(165, 25, 18, 10, 55, 10, 605, 10, 544.5),
(166, 14, 9, 10, 820, 0, 8200, 10, 7380),
(167, 1, 19, 40, 200, 0, 8000, 0, 8000),
(168, 12, 13, 30, 910, 0, 27300, 10, 24570),
(169, 37, 17, 40, 80, 0, 3200, 0, 3200),
(170, 11, 13, 30, 910, 10, 30030, 0, 30030),
(171, 41, 1, 40, 400, 10, 17600, 10, 15840),
(172, 42, 6, 30, 350, 0, 10500, 10, 9450),
(173, 38, 19, 40, 200, 0, 8000, 0, 8000),
(174, 13, 15, 10, 300, 10, 3300, 10, 2970),
(175, 34, 10, 10, 650, 10, 7150, 0, 7150),
(176, 13, 12, 40, 820, 10, 36080, 0, 36080),
(177, 5, 6, 40, 350, 0, 14000, 10, 12600),
(178, 31, 1, 30, 400, 0, 12000, 10, 10800),
(179, 49, 7, 20, 300, 10, 6600, 0, 6600),
(180, 26, 14, 30, 1200, 10, 39600, 10, 35640),
(181, 20, 11, 40, 600, 10, 26400, 10, 23760),
(182, 37, 18, 20, 55, 0, 1100, 0, 1100),
(183, 26, 12, 30, 820, 0, 24600, 10, 22140),
(184, 3, 2, 20, 1100, 0, 22000, 0, 22000),
(185, 37, 13, 10, 910, 0, 9100, 10, 8190),
(186, 17, 15, 20, 300, 10, 6600, 0, 6600),
(187, 22, 2, 40, 1100, 10, 48400, 0, 48400),
(188, 34, 17, 20, 80, 10, 1760, 10, 1584),
(189, 7, 10, 20, 650, 10, 14300, 0, 14300),
(190, 31, 9, 20, 820, 10, 18040, 0, 18040),
(191, 23, 13, 30, 910, 10, 30030, 10, 27027),
(192, 40, 1, 10, 400, 0, 4000, 0, 4000),
(193, 3, 3, 40, 400, 0, 16000, 0, 16000),
(194, 7, 12, 40, 820, 0, 32800, 10, 29520),
(195, 44, 18, 20, 55, 0, 1100, 10, 990),
(196, 25, 15, 20, 300, 0, 6000, 0, 6000),
(197, 50, 9, 10, 820, 10, 9020, 0, 9020),
(198, 27, 11, 50, 600, 0, 30000, 10, 27000),
(199, 48, 14, 10, 1200, 10, 13200, 0, 13200),
(200, 39, 9, 40, 820, 0, 32800, 0, 32800),
(201, 51, 4, 20, 400, 0, 8000, 0, 8000),
(202, 51, 7, 40, 300, 0, 12000, 0, 12000);

-- --------------------------------------------------------

--
-- Table structure for table `saleorders`
--

CREATE TABLE `saleorders` (
  `orderID` int(11) NOT NULL,
  `customerID` int(11) NOT NULL,
  `saleorderDate` datetime NOT NULL,
  `total` float NOT NULL,
  `description` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `userID` int(11) NOT NULL,
  `createdDate` datetime NOT NULL DEFAULT current_timestamp(),
  `updatedDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `saleorders`
--

INSERT INTO `saleorders` (`orderID`, `customerID`, `saleorderDate`, `total`, `description`, `userID`, `createdDate`, `updatedDate`) VALUES
(1, 8, '2021-05-26 00:00:00', 37810, NULL, 1, '2021-07-19 11:46:39', '2021-07-19 14:28:57'),
(2, 1, '2021-01-26 00:00:00', 36100, NULL, 9, '2021-07-19 11:46:39', NULL),
(3, 5, '2021-01-13 00:00:00', 89840, NULL, 9, '2021-07-19 11:46:39', NULL),
(4, 1, '2021-06-28 00:00:00', 47710, NULL, 2, '2021-07-19 11:46:39', NULL),
(5, 6, '2021-02-23 00:00:00', 12600, NULL, 4, '2021-07-19 11:46:39', NULL),
(6, 7, '2021-05-13 00:00:00', 17820, NULL, 5, '2021-07-19 11:46:39', NULL),
(7, 5, '2021-05-04 00:00:00', 87179, NULL, 10, '2021-07-19 11:46:39', NULL),
(8, 6, '2021-04-10 00:00:00', 58486, NULL, 4, '2021-07-19 11:46:39', NULL),
(9, 4, '2021-02-25 00:00:00', 40590, NULL, 8, '2021-07-19 11:46:39', NULL),
(10, 3, '2021-01-24 00:00:00', 9592, NULL, 4, '2021-07-19 11:46:39', NULL),
(11, 5, '2021-02-24 00:00:00', 96485, NULL, 6, '2021-07-19 11:46:39', NULL),
(12, 2, '2021-02-08 00:00:00', 87519, NULL, 11, '2021-07-19 11:46:39', NULL),
(13, 5, '2021-06-04 00:00:00', 121454, NULL, 6, '2021-07-19 11:46:39', NULL),
(14, 8, '2021-02-04 00:00:00', 72500, NULL, 1, '2021-07-19 11:46:39', NULL),
(15, 9, '2021-05-02 00:00:00', 21000, NULL, 3, '2021-07-19 11:46:39', NULL),
(16, 7, '2021-01-21 00:00:00', 41000, NULL, 11, '2021-07-19 11:46:39', NULL),
(17, 3, '2021-03-17 00:00:00', 13800, NULL, 9, '2021-07-19 11:46:39', NULL),
(18, 9, '2021-03-18 00:00:00', 103867, NULL, 10, '2021-07-19 11:46:39', NULL),
(19, 5, '2021-03-22 00:00:00', 69058, NULL, 10, '2021-07-19 11:46:39', NULL),
(20, 9, '2021-01-16 00:00:00', 90398, NULL, 8, '2021-07-19 11:46:39', NULL),
(21, 1, '2021-02-01 00:00:00', 11880, NULL, 5, '2021-07-19 11:46:39', NULL),
(22, 7, '2021-06-05 00:00:00', 106000, NULL, 9, '2021-07-19 11:46:39', NULL),
(23, 5, '2021-01-27 00:00:00', 146236, NULL, 6, '2021-07-19 11:46:39', NULL),
(24, 4, '2021-03-04 00:00:00', 29480, NULL, 6, '2021-07-19 11:46:39', NULL),
(25, 8, '2021-04-09 00:00:00', 21304.5, NULL, 1, '2021-07-19 11:46:39', NULL),
(26, 1, '2021-01-23 00:00:00', 118550, NULL, 7, '2021-07-19 11:46:39', NULL),
(27, 4, '2021-01-15 00:00:00', 53000, NULL, 8, '2021-07-19 11:46:39', NULL),
(28, 10, '2021-06-05 00:00:00', 32600, NULL, 1, '2021-07-19 11:46:39', NULL),
(29, 10, '2021-06-09 00:00:00', 13400, NULL, 2, '2021-07-19 11:46:39', NULL),
(30, 4, '2021-05-07 00:00:00', 80320, NULL, 5, '2021-07-19 11:46:39', NULL),
(31, 5, '2021-01-11 00:00:00', 62770, NULL, 4, '2021-07-19 11:46:39', NULL),
(32, 8, '2021-03-04 00:00:00', 36630, NULL, 9, '2021-07-19 11:46:39', NULL),
(33, 6, '2021-04-19 00:00:00', 36930, NULL, 5, '2021-07-19 11:46:39', NULL),
(34, 4, '2021-03-02 00:00:00', 39494, NULL, 7, '2021-07-19 11:46:39', NULL),
(35, 5, '2021-05-18 00:00:00', 30240, NULL, 9, '2021-07-19 11:46:39', NULL),
(36, 5, '2021-04-13 00:00:00', 35302, NULL, 7, '2021-07-19 11:46:39', NULL),
(37, 8, '2021-02-20 00:00:00', 116090, NULL, 6, '2021-07-19 11:46:39', NULL),
(38, 3, '2021-01-22 00:00:00', 43350, NULL, 10, '2021-07-19 11:46:39', NULL),
(39, 1, '2021-01-09 00:00:00', 106380, NULL, 11, '2021-07-19 11:46:39', NULL),
(40, 5, '2021-06-18 00:00:00', 107905, NULL, 4, '2021-07-19 11:46:39', NULL),
(41, 7, '2021-02-12 00:00:00', 41400, NULL, 4, '2021-07-19 11:46:39', NULL),
(42, 10, '2021-01-28 00:00:00', 87190, NULL, 10, '2021-07-19 11:46:39', NULL),
(43, 9, '2021-05-30 00:00:00', 47520, NULL, 5, '2021-07-19 11:46:39', NULL),
(44, 4, '2021-03-15 00:00:00', 11990, NULL, 10, '2021-07-19 11:46:39', NULL),
(45, 8, '2021-05-03 00:00:00', 35640, NULL, 9, '2021-07-19 11:46:39', NULL),
(46, 3, '2021-04-14 00:00:00', 95150, NULL, 5, '2021-07-19 11:46:39', NULL),
(47, 1, '2021-03-19 00:00:00', 9980, NULL, 11, '2021-07-19 11:46:39', NULL),
(48, 8, '2021-05-30 00:00:00', 28350, NULL, 9, '2021-07-19 11:46:39', NULL),
(49, 10, '2021-04-14 00:00:00', 19200, NULL, 7, '2021-07-19 11:46:39', NULL),
(50, 6, '2021-05-15 00:00:00', 77556, NULL, 4, '2021-07-19 11:46:39', NULL),
(51, 8, '2021-07-19 00:00:00', 20000, NULL, 9, '2021-07-19 14:23:52', '2021-07-19 14:23:52');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_statistical`
--

CREATE TABLE `tbl_statistical` (
  `id_statistical` int(11) NOT NULL,
  `order_date` varchar(50) NOT NULL,
  `sales` varchar(200) NOT NULL,
  `profit` varchar(200) NOT NULL,
  `quantity` int(11) NOT NULL,
  `total_order` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_statistical`
--

INSERT INTO `tbl_statistical` (`id_statistical`, `order_date`, `sales`, `profit`, `quantity`, `total_order`) VALUES
(1, '2021-06-25', '20000000', '7000000', 90, 10),
(2, '2021-06-24', '68000000', '9000000', 60, 8),
(3, '2021-06-23', '30000000', '3000000', 45, 7),
(4, '2021-06-22', '45000000', '3800000', 30, 9),
(5, '2021-06-21', '30000000', '1500000', 15, 12),
(6, '2021-06-20', '8000000', '700000', 65, 30),
(7, '2021-06-19', '28000000', '23000000', 32, 20),
(8, '2021-06-18', '25000000', '20000000', 7, 6),
(9, '2021-05-31', '36000000', '28000000', 40, 15),
(10, '2021-05-30', '50000000', '13000000', 89, 19),
(11, '2021-05-29', '20000000', '15000000', 63, 11),
(12, '2021-05-28', '25000000', '16000000', 94, 14),
(13, '2021-05-27', '32000000', '17000000', 16, 10),
(14, '2021-05-26', '33000000', '19000000', 14, 5),
(15, '2021-05-25', '36000000', '18000000', 22, 12),
(16, '2021-05-24', '34000000', '20000000', 33, 20),
(17, '2021-05-23', '25000000', '16000000', 94, 14),
(18, '2021-05-22', '12000000', '7000000', 16, 10),
(19, '2021-05-21', '63000000', '19000000', 14, 5),
(20, '2021-05-20', '66000000', '18000000', 22, 12),
(21, '2021-05-19', '74000000', '20000000', 33, 20),
(22, '2021-05-18', '63000000', '19000000', 14, 5),
(23, '2021-05-17', '66000000', '18000000', 23, 12),
(24, '2021-05-16', '74000000', '20000000', 32, 20),
(25, '2021-05-15', '63000000', '19000000', 14, 5),
(26, '2020-10-14', '66000000', '18000000', 23, 12),
(27, '2020-10-13', '74000000', '20000000', 33, 20),
(28, '2020-10-12', '66000000', '18000000', 23, 12),
(29, '2020-10-11', '74000000', '20000000', 10, 20),
(30, '2020-10-10', '63000000', '19000000', 14, 5),
(31, '2020-10-09', '66000000', '18000000', 23, 12),
(32, '2020-10-08', '74000000', '20000000', 15, 20),
(33, '2020-10-07', '66000000', '18000000', 23, 12),
(34, '2020-10-06', '74000000', '20000000', 30, 22),
(35, '2020-10-05', '66000000', '18000000', 23, 12),
(36, '2020-10-04', '74000000', '20000000', 32, 20),
(37, '2020-10-03', '63000000', '19000000', 14, 5),
(38, '2020-10-02', '66000000', '18000000', 23, 12),
(39, '2020-10-01', '74000000', '20000000', 32, 20),
(40, '2020-09-30', '63000000', '19000000', 14, 5),
(41, '2020-09-29', '66000000', '18000000', 23, 12),
(42, '2020-09-28', '74000000', '20000000', 15, 20),
(43, '2020-09-27', '66000000', '18000000', 23, 12),
(44, '2020-09-26', '74000000', '20000000', 30, 22),
(45, '2020-09-25', '66000000', '18000000', 23, 12),
(46, '2020-09-24', '74000000', '20000000', 32, 20),
(47, '2020-09-23', '63000000', '19000000', 14, 5),
(48, '2020-09-22', '66000000', '18000000', 23, 12),
(49, '2020-09-21', '74000000', '20000000', 32, 20),
(50, '2020-09-20', '63000000', '19000000', 14, 5),
(51, '2020-09-19', '66000000', '18000000', 23, 12),
(52, '2020-09-18', '74000000', '20000000', 15, 20),
(53, '2020-09-17', '66000000', '18000000', 23, 12),
(54, '2020-09-16', '74000000', '20000000', 30, 22),
(55, '2020-09-15', '66000000', '18000000', 23, 12),
(56, '2020-09-14', '74000000', '20000000', 32, 20),
(57, '2020-09-13', '63000000', '19000000', 14, 5),
(58, '2020-09-12', '66000000', '18000000', 23, 12),
(59, '2020-09-11', '74000000', '20000000', 32, 20),
(60, '2020-09-10', '63000000', '19000000', 14, 5),
(61, '2020-09-09', '66000000', '18000000', 23, 12),
(62, '2020-09-08', '74000000', '20000000', 15, 20),
(63, '2020-09-07', '66000000', '18000000', 23, 12),
(64, '2020-09-06', '74000000', '20000000', 30, 22),
(65, '2020-09-05', '66000000', '18000000', 23, 12),
(66, '2020-09-04', '74000000', '20000000', 32, 20),
(67, '2020-09-03', '63000000', '19000000', 14, 5),
(68, '2020-09-02', '66000000', '18000000', 23, 12),
(69, '2020-09-01', '74000000', '20000000', 32, 20);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userID` int(11) NOT NULL,
  `userName` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `role` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `fullname` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `active` int(1) NOT NULL DEFAULT 1,
  `description` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userID`, `userName`, `password`, `role`, `fullname`, `email`, `phone`, `active`, `description`) VALUES
(1, 'saleadmin', '123', 'SA2', 'Mau Linh', 'phuc@gmail.com', '123456789', 1, NULL),
(2, 'saleuser', '111', 'SA2', 'User Sale', 'sale@user.com', '1122334455', 1, NULL),
(3, 'logisadmin', '111', 'LO1', 'Logistics Admin', 'logistics@admin.com', '0147258369', 1, NULL),
(4, 'logisuser', '111', 'LO2', 'Logistics User', 'logistics@user.com', '0246813579', 1, NULL),
(5, 'hradmin', '111', 'HR1', 'HR Admin', 'hr@admin.com', '0135792468', 1, NULL),
(6, 'hruser', '111', 'HR2', 'HR User', 'hr@user.com', '0909667788', 1, NULL),
(7, 'accadmin', '111', 'AC1', 'Accounting Admin', 'acc@admin.com', '0903 456 789', 1, NULL),
(8, 'accuser', '111', 'AC2', 'Accounting User', 'acc@user.com', '079 289 1997', 1, NULL),
(9, 'master', '123', 'MA1', 'Thien Phuc', '1@a.com', '1122233344', 1, NULL),
(10, '2', '222', 'LO1', 'Ba Duy', '2@a.com', '22331144', 1, NULL),
(11, '3', '333', 'HR1', 'Anh Khoa', '3@gmail.com', '33321233', 2, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `vendors`
--

CREATE TABLE `vendors` (
  `vendorID` int(11) NOT NULL,
  `vendorName` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `taxNumber` bigint(13) DEFAULT NULL,
  `address` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `unpaid` float DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT 1,
  `description` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `vendors`
--

INSERT INTO `vendors` (`vendorID`, `vendorName`, `taxNumber`, `address`, `phone`, `email`, `unpaid`, `status`, `description`) VALUES
(1, 'NINTENDO INC.', 1234567890, '66 Đ. Thành Thái, Phường 12, Quận 10, Thành phố Hồ Chí Minh', '093 373 72 54', 'NintendoVN@gmail.com', 50000, 1, NULL),
(2, 'SONY ELECTRONICS VIETNAM', 305712139, '6th & 7th Floor, President Place Building, No. 93, Nguyen Du Street, Ben Nghe Ward, 1 District', '(84-28) 3822 2227', 'sales@sony.com.vn', 4000, 1, NULL),
(3, 'CÔNG TY CỔ PHẦN MẠNG TRỰC TUYẾN META', 2435686969, '716-718 Điện Biên Phủ, Phường 10, Quận 10 ', '02838336666', 'metavn@gmail.com', 80000, 1, NULL),
(4, 'Công ty TNHH Thương Mại Gearvn', 316517394, '78-80-82 Hoàng Hoa Thám, Phường 12, Quận Tân Bình.', '18006173', 'CSKH@GEARVN.COM', 14000, 1, NULL),
(5, 'Công Ty Hiroshima Việt Nam', 1245879, '19 Lê Lợi, SaiGon Center, P. Bến Nghé, Q1, HCMC', '1900636890', 'hiroshimavn@gmail.com', 30000, 1, NULL),
(6, 'Công ty Nintendo Viet Nam', 1234567890, '66 Thành Thái,Phường 12,Quận 10,Hồ Chí Minh', '0933737254', 'NintendoVN@gmail.com', 70000, 1, NULL),
(7, 'AN PHAT COMPUTER TRADING JOINT STOCK COMPANY', 108940873, '158 - 160 Lý Thường Kiệt - Quận 10 - TPHCM', '0918.858.797', 'thaohtt@anphatpc.com.vn', 1200, 1, NULL),
(8, 'CÔNG TY TNHH MTV CNTH VIỄN SƠN', 305725134, '162B Bùi Thị Xuân, P.Phạm Ngũ Lão, Quận 1, TPHCM', '028 38326 085', 'ms-info@microstar.com.vn', NULL, 1, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `billdetails`
--
ALTER TABLE `billdetails`
  ADD PRIMARY KEY (`billdetailsID`),
  ADD KEY `billID` (`billID`),
  ADD KEY `productID` (`productID`);

--
-- Indexes for table `bills`
--
ALTER TABLE `bills`
  ADD PRIMARY KEY (`billID`),
  ADD KEY `vendorID` (`vendorID`),
  ADD KEY `userID` (`userID`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customerID`);

--
-- Indexes for table `exportdetails`
--
ALTER TABLE `exportdetails`
  ADD PRIMARY KEY (`exportdetailsID`),
  ADD KEY `exportID` (`exportID`),
  ADD KEY `productID` (`productID`);

--
-- Indexes for table `exports`
--
ALTER TABLE `exports`
  ADD PRIMARY KEY (`exportID`),
  ADD KEY `invoiceID` (`invoiceID`),
  ADD KEY `customerID` (`customerID`),
  ADD KEY `userID` (`userID`);

--
-- Indexes for table `importdetails`
--
ALTER TABLE `importdetails`
  ADD PRIMARY KEY (`importdetailsID`),
  ADD KEY `importID` (`importID`),
  ADD KEY `productID` (`productID`);

--
-- Indexes for table `imports`
--
ALTER TABLE `imports`
  ADD PRIMARY KEY (`importID`),
  ADD KEY `billID` (`billID`),
  ADD KEY `vendorID` (`vendorID`),
  ADD KEY `userID` (`userID`);

--
-- Indexes for table `invoicedetails`
--
ALTER TABLE `invoicedetails`
  ADD PRIMARY KEY (`invoicedetailsID`),
  ADD KEY `invoiceID` (`invoiceID`),
  ADD KEY `productID` (`productID`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`invoiceID`),
  ADD KEY `orderID` (`orderID`),
  ADD KEY `customerID` (`customerID`),
  ADD KEY `userID` (`userID`);

--
-- Indexes for table `payabledetails`
--
ALTER TABLE `payabledetails`
  ADD PRIMARY KEY (`payabledetailsID`),
  ADD KEY `payableID` (`payableID`),
  ADD KEY `payabledetails_ibfk_2` (`billID`);

--
-- Indexes for table `payables`
--
ALTER TABLE `payables`
  ADD PRIMARY KEY (`payableID`),
  ADD KEY `vendorID` (`vendorID`),
  ADD KEY `userID` (`userID`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`productID`);

--
-- Indexes for table `purchaseorderdetails`
--
ALTER TABLE `purchaseorderdetails`
  ADD PRIMARY KEY (`purchaseorderdetailsID`),
  ADD KEY `purchaseorderID` (`purchaseorderID`),
  ADD KEY `productID` (`productID`);

--
-- Indexes for table `purchaseorders`
--
ALTER TABLE `purchaseorders`
  ADD PRIMARY KEY (`purchaseorderID`),
  ADD KEY `vendorID` (`vendorID`),
  ADD KEY `userID` (`userID`);

--
-- Indexes for table `receivabledetails`
--
ALTER TABLE `receivabledetails`
  ADD PRIMARY KEY (`receivabledetailsID`),
  ADD KEY `receivableID` (`receivableID`),
  ADD KEY `receivabledetails_ibfk_2` (`invoiceID`);

--
-- Indexes for table `receivables`
--
ALTER TABLE `receivables`
  ADD PRIMARY KEY (`receivableID`),
  ADD KEY `customerID` (`customerID`),
  ADD KEY `userID` (`userID`);

--
-- Indexes for table `saleorderdetails`
--
ALTER TABLE `saleorderdetails`
  ADD PRIMARY KEY (`saleorderdetailsID`),
  ADD KEY `orderID` (`orderID`),
  ADD KEY `productID` (`productID`);

--
-- Indexes for table `saleorders`
--
ALTER TABLE `saleorders`
  ADD PRIMARY KEY (`orderID`),
  ADD KEY `customerID` (`customerID`),
  ADD KEY `userID` (`userID`);

--
-- Indexes for table `tbl_statistical`
--
ALTER TABLE `tbl_statistical`
  ADD PRIMARY KEY (`id_statistical`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userID`);

--
-- Indexes for table `vendors`
--
ALTER TABLE `vendors`
  ADD PRIMARY KEY (`vendorID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `billdetails`
--
ALTER TABLE `billdetails`
  MODIFY `billdetailsID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `bills`
--
ALTER TABLE `bills`
  MODIFY `billID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customerID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `exportdetails`
--
ALTER TABLE `exportdetails`
  MODIFY `exportdetailsID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `exports`
--
ALTER TABLE `exports`
  MODIFY `exportID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `importdetails`
--
ALTER TABLE `importdetails`
  MODIFY `importdetailsID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `imports`
--
ALTER TABLE `imports`
  MODIFY `importID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `invoicedetails`
--
ALTER TABLE `invoicedetails`
  MODIFY `invoicedetailsID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `invoiceID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `payabledetails`
--
ALTER TABLE `payabledetails`
  MODIFY `payabledetailsID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `payables`
--
ALTER TABLE `payables`
  MODIFY `payableID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `productID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `purchaseorderdetails`
--
ALTER TABLE `purchaseorderdetails`
  MODIFY `purchaseorderdetailsID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=205;

--
-- AUTO_INCREMENT for table `purchaseorders`
--
ALTER TABLE `purchaseorders`
  MODIFY `purchaseorderID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `receivabledetails`
--
ALTER TABLE `receivabledetails`
  MODIFY `receivabledetailsID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `receivables`
--
ALTER TABLE `receivables`
  MODIFY `receivableID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `saleorderdetails`
--
ALTER TABLE `saleorderdetails`
  MODIFY `saleorderdetailsID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=203;

--
-- AUTO_INCREMENT for table `saleorders`
--
ALTER TABLE `saleorders`
  MODIFY `orderID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `tbl_statistical`
--
ALTER TABLE `tbl_statistical`
  MODIFY `id_statistical` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `vendors`
--
ALTER TABLE `vendors`
  MODIFY `vendorID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `billdetails`
--
ALTER TABLE `billdetails`
  ADD CONSTRAINT `billdetails_ibfk_1` FOREIGN KEY (`billID`) REFERENCES `bills` (`billID`),
  ADD CONSTRAINT `billdetails_ibfk_2` FOREIGN KEY (`productID`) REFERENCES `products` (`productID`);

--
-- Constraints for table `bills`
--
ALTER TABLE `bills`
  ADD CONSTRAINT `bill_ibfk_2` FOREIGN KEY (`vendorID`) REFERENCES `vendors` (`vendorID`),
  ADD CONSTRAINT `bill_ibfk_3` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`);

--
-- Constraints for table `exportdetails`
--
ALTER TABLE `exportdetails`
  ADD CONSTRAINT `exportdetails_ibfk_1` FOREIGN KEY (`exportID`) REFERENCES `exports` (`exportID`),
  ADD CONSTRAINT `exportdetails_ibfk_2` FOREIGN KEY (`productID`) REFERENCES `products` (`productID`);

--
-- Constraints for table `exports`
--
ALTER TABLE `exports`
  ADD CONSTRAINT `export_ibfk_1` FOREIGN KEY (`invoiceID`) REFERENCES `invoices` (`invoiceID`),
  ADD CONSTRAINT `export_ibfk_2` FOREIGN KEY (`customerID`) REFERENCES `customers` (`customerID`),
  ADD CONSTRAINT `export_ibfk_3` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`);

--
-- Constraints for table `importdetails`
--
ALTER TABLE `importdetails`
  ADD CONSTRAINT `importdetails_ibfk_1` FOREIGN KEY (`importID`) REFERENCES `imports` (`importID`),
  ADD CONSTRAINT `importdetails_ibfk_2` FOREIGN KEY (`productID`) REFERENCES `products` (`productID`);

--
-- Constraints for table `imports`
--
ALTER TABLE `imports`
  ADD CONSTRAINT `import_ibfk_1` FOREIGN KEY (`billID`) REFERENCES `bills` (`billID`),
  ADD CONSTRAINT `import_ibfk_2` FOREIGN KEY (`vendorID`) REFERENCES `vendors` (`vendorID`),
  ADD CONSTRAINT `import_ibfk_3` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`);

--
-- Constraints for table `invoicedetails`
--
ALTER TABLE `invoicedetails`
  ADD CONSTRAINT `invoicedetails_ibfk_1` FOREIGN KEY (`invoiceID`) REFERENCES `invoices` (`invoiceID`),
  ADD CONSTRAINT `invoicedetails_ibfk_2` FOREIGN KEY (`productID`) REFERENCES `products` (`productID`);

--
-- Constraints for table `invoices`
--
ALTER TABLE `invoices`
  ADD CONSTRAINT `invoice_ibfk_1` FOREIGN KEY (`orderID`) REFERENCES `saleorders` (`orderID`),
  ADD CONSTRAINT `invoice_ibfk_2` FOREIGN KEY (`customerID`) REFERENCES `customers` (`customerID`),
  ADD CONSTRAINT `invoice_ibfk_3` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`);

--
-- Constraints for table `payabledetails`
--
ALTER TABLE `payabledetails`
  ADD CONSTRAINT `payabledetails_ibfk_1` FOREIGN KEY (`payableID`) REFERENCES `payables` (`payableID`),
  ADD CONSTRAINT `payabledetails_ibfk_2` FOREIGN KEY (`billID`) REFERENCES `bills` (`billID`);

--
-- Constraints for table `payables`
--
ALTER TABLE `payables`
  ADD CONSTRAINT `payable_ibfk_1` FOREIGN KEY (`vendorID`) REFERENCES `vendors` (`vendorID`),
  ADD CONSTRAINT `payable_ibfk_2` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`);

--
-- Constraints for table `purchaseorderdetails`
--
ALTER TABLE `purchaseorderdetails`
  ADD CONSTRAINT `purchaseorderdetails_ibfk_1` FOREIGN KEY (`purchaseorderID`) REFERENCES `purchaseorders` (`purchaseorderID`),
  ADD CONSTRAINT `purchaseorderdetails_ibfk_2` FOREIGN KEY (`productID`) REFERENCES `products` (`productID`);

--
-- Constraints for table `purchaseorders`
--
ALTER TABLE `purchaseorders`
  ADD CONSTRAINT `purchaseorder_ibfk_1` FOREIGN KEY (`vendorID`) REFERENCES `vendors` (`vendorID`),
  ADD CONSTRAINT `purchaseorder_ibfk_2` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`);

--
-- Constraints for table `receivabledetails`
--
ALTER TABLE `receivabledetails`
  ADD CONSTRAINT `receivabledetails_ibfk_1` FOREIGN KEY (`receivableID`) REFERENCES `receivables` (`receivableID`),
  ADD CONSTRAINT `receivabledetails_ibfk_2` FOREIGN KEY (`invoiceID`) REFERENCES `invoices` (`invoiceID`);

--
-- Constraints for table `receivables`
--
ALTER TABLE `receivables`
  ADD CONSTRAINT `receivable_ibfk_1` FOREIGN KEY (`customerID`) REFERENCES `customers` (`customerID`),
  ADD CONSTRAINT `receivable_ibfk_2` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`);

--
-- Constraints for table `saleorderdetails`
--
ALTER TABLE `saleorderdetails`
  ADD CONSTRAINT `saleorderdetails_ibfk_1` FOREIGN KEY (`orderID`) REFERENCES `saleorders` (`orderID`),
  ADD CONSTRAINT `saleorderdetails_ibfk_2` FOREIGN KEY (`productID`) REFERENCES `products` (`productID`);

--
-- Constraints for table `saleorders`
--
ALTER TABLE `saleorders`
  ADD CONSTRAINT `saleorder_ibfk_1` FOREIGN KEY (`customerID`) REFERENCES `customers` (`customerID`),
  ADD CONSTRAINT `saleorder_ibfk_2` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
