-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1:3306
-- 產生時間： 2024 年 07 月 23 日 15:06
-- 伺服器版本： 8.3.0
-- PHP 版本： 8.2.18

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `projectdb`
--
DROP DATABASE IF EXISTS `projectDB`;
CREATE DATABASE IF NOT EXISTS `projectDB` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `projectDB`;

-- --------------------------------------------------------

--
-- 資料表結構 `cart`
--

DROP TABLE IF EXISTS `cart`;
CREATE TABLE IF NOT EXISTS `cart` (
  `userID` int NOT NULL,
  `sparePartNum` char(6) NOT NULL,
  `qty` int DEFAULT NULL,
  PRIMARY KEY (`userID`,`sparePartNum`),
  KEY `sparePartNum` (`sparePartNum`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 資料表新增資料前，先清除舊資料 `cart`
--

TRUNCATE TABLE `cart`;
-- --------------------------------------------------------

--
-- 資料表結構 `dealer`
--

DROP TABLE IF EXISTS `dealer`;
CREATE TABLE IF NOT EXISTS `dealer` (
  `dealerID` int NOT NULL AUTO_INCREMENT,
  `dealerName` varchar(100) NOT NULL,
  `contactName` varchar(100) NOT NULL,
  `contactNumber` varchar(30) NOT NULL,
  `faxNumber` varchar(30) NOT NULL,
  `deliveryAddress` varchar(255) NOT NULL,
  PRIMARY KEY (`dealerID`),
  UNIQUE KEY `dealerName` (`dealerName`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

--
-- 資料表新增資料前，先清除舊資料 `dealer`
--

TRUNCATE TABLE `dealer`;
--
-- 傾印資料表的資料 `dealer`
--

INSERT INTO `dealer` (`dealerID`, `dealerName`, `contactName`, `contactNumber`, `faxNumber`, `deliveryAddress`) VALUES
(1, 'FY Ltd.', '陳美惠', '13912345678', '1234567890', '北京市朝陽區建國路100號1樓'),
(2, 'Happy Ltd.', '朱家弘', ' 15898765432', '1234567891', '北京市海淀區西三旗街道1號'),
(3, 'IT Ltd.', '吳如香', '13678901234', '1234567892', '北京市昌平區回龍觀東大街2號'),
(4, 'SDP Ltd.', '李家銘', '15056789012', '1234567893', '北京市西城區西單北大街3號'),
(5, 'OOT Ltd.', '李怡君', '13123456789', '1234567894', '香港中環皇后大道中1號');

-- --------------------------------------------------------

--
-- 資料表結構 `order`
--

DROP TABLE IF EXISTS `order`;
CREATE TABLE IF NOT EXISTS `order` (
  `orderID` int NOT NULL AUTO_INCREMENT,
  `orderDateTime` datetime NOT NULL,
  `deliveryAddress` varchar(255) NOT NULL,
  `deliveryDate` date DEFAULT NULL,
  `salesManagerID` int DEFAULT NULL,
  `dealerID` int NOT NULL,
  `orderItemNumber` int NOT NULL,
  `TotalAmount` decimal(10,2) NOT NULL,
  `shipCost` decimal(10,2) NOT NULL,
  `isPaid` bit(1) NOT NULL DEFAULT b'0',
  `receipt` varchar(100) DEFAULT NULL,
  `state` char(1) NOT NULL DEFAULT 'C',
  PRIMARY KEY (`orderID`),
  KEY `idx_dealerID` (`dealerID`),
  KEY `idx_salesManagerID` (`salesManagerID`),
  KEY `idx_orderID` (`orderID`),
  KEY `idx_state_order` (`state`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

--
-- 資料表新增資料前，先清除舊資料 `order`
--

TRUNCATE TABLE `order`;
--
-- 傾印資料表的資料 `order`
--

INSERT INTO `order` (`orderID`, `orderDateTime`, `deliveryAddress`, `deliveryDate`, `salesManagerID`, `dealerID`, `orderItemNumber`, `TotalAmount`, `shipCost`, `isPaid`, `receipt`, `state`) VALUES
(1, '2024-07-23 22:58:23', '北京市朝陽區建國路100號1樓', NULL, NULL, 1, 20, 1800.00, 1700.00, b'0', NULL, 'C'),
(2, '2024-07-23 22:59:09', '北京市朝陽區建國路100號1樓', NULL, NULL, 1, 12, 690.00, 960.00, b'0', NULL, 'C'),
(3, '2024-07-23 22:59:32', '北京市朝陽區建國路100號1樓', NULL, NULL, 1, 2, 190.00, 450.00, b'0', NULL, 'C'),
(4, '2024-07-23 22:59:46', '北京市朝陽區建國路100號1樓', NULL, NULL, 1, 3, 320.00, 500.00, b'0', NULL, 'C');

-- --------------------------------------------------------

--
-- 資料表結構 `orderspare`
--

DROP TABLE IF EXISTS `orderspare`;
CREATE TABLE IF NOT EXISTS `orderspare` (
  `sparePartNum` char(6) NOT NULL,
  `orderID` int NOT NULL,
  `orderQty` int NOT NULL,
  `sparePartOrderPrice` decimal(10,2) NOT NULL,
  PRIMARY KEY (`sparePartNum`,`orderID`),
  KEY `idx_sparePartNum_orderSpare` (`sparePartNum`),
  KEY `idx_orderID_orderSpare` (`orderID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 資料表新增資料前，先清除舊資料 `orderspare`
--

TRUNCATE TABLE `orderspare`;
--
-- 傾印資料表的資料 `orderspare`
--

INSERT INTO `orderspare` (`sparePartNum`, `orderID`, `orderQty`, `sparePartOrderPrice`) VALUES
('100001', 1, 1, 40.00),
('100002', 1, 1, 80.00),
('100003', 1, 1, 60.00),
('100003', 2, 1, 60.00),
('100004', 1, 1, 100.00),
('100005', 1, 1, 140.00),
('200001', 1, 1, 50.00),
('200002', 1, 1, 30.00),
('200002', 2, 1, 30.00),
('200003', 1, 1, 70.00),
('200004', 1, 1, 110.00),
('200005', 1, 1, 150.00),
('200005', 3, 1, 150.00),
('300001', 1, 1, 60.00),
('300001', 2, 10, 600.00),
('300002', 1, 1, 40.00),
('300002', 3, 1, 40.00),
('300003', 1, 1, 80.00),
('300004', 1, 1, 120.00),
('300005', 1, 1, 160.00),
('300005', 4, 1, 160.00),
('400001', 1, 1, 70.00),
('400001', 4, 1, 70.00),
('400002', 1, 1, 50.00),
('400003', 1, 1, 90.00),
('400003', 4, 1, 90.00),
('400004', 1, 1, 130.00),
('400005', 1, 1, 170.00);

-- --------------------------------------------------------

--
-- 資料表結構 `salemanager`
--

DROP TABLE IF EXISTS `salemanager`;
CREATE TABLE IF NOT EXISTS `salemanager` (
  `salesManagerID` int NOT NULL AUTO_INCREMENT,
  `managerName` varchar(100) NOT NULL,
  `contactName` varchar(100) NOT NULL,
  `contactNumber` varchar(30) NOT NULL,
  PRIMARY KEY (`salesManagerID`),
  UNIQUE KEY `managerName` (`managerName`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

--
-- 資料表新增資料前，先清除舊資料 `salemanager`
--

TRUNCATE TABLE `salemanager`;
--
-- 傾印資料表的資料 `salemanager`
--

INSERT INTO `salemanager` (`salesManagerID`, `managerName`, `contactName`, `contactNumber`) VALUES
(1, '陳依海', '陳培倫', '13123456759'),
(2, '劉怡萱', '林家豪', '23020831'),
(3, '王雅文', '葉真凌', '90747203'),
(4, '曾明珠', '鄭婉君', '69400737'),
(5, '林郁婷', '余其宸', '31376030');

-- --------------------------------------------------------

--
-- 資料表結構 `spare`
--

DROP TABLE IF EXISTS `spare`;
CREATE TABLE IF NOT EXISTS `spare` (
  `sparePartNum` char(6) NOT NULL,
  `category` enum('A','B','C','D') NOT NULL,
  `sparePartName` varchar(255) NOT NULL,
  `sparePartImage` varchar(100) NOT NULL,
  `sparePartDescription` text NOT NULL,
  `weight` double NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `state` char(1) NOT NULL DEFAULT 'N',
  PRIMARY KEY (`sparePartNum`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 資料表新增資料前，先清除舊資料 `spare`
--

TRUNCATE TABLE `spare`;
--
-- 傾印資料表的資料 `spare`
--

INSERT INTO `spare` (`sparePartNum`, `category`, `sparePartName`, `sparePartImage`, `sparePartDescription`, `weight`, `price`, `state`) VALUES
('100001', 'A', 'T300 PANEL ASSEMBLY DASH LWR EXTN', '../../images/item/100001.jpg', 'Aluminium Hot Plate Automotive Die Casting, For Industrial', 0.5, 40.00, 'N'),
('100002', 'A', 'car back rear doors', '../../images/item/100002.jpg', 'Car body kits Auto Parts Chinese Factory Supply car front Rear door car back rear doors for H6S 2021 wholesale', 0.9, 80.00, 'N'),
('100003', 'A', 'ordinary car door', '../../images/item/100003.jpg', 'Most of the door exterior is a millimeters-thick mild steel. A .308 from a fair distance won\'t even notice it.', 1.3, 60.00, 'N'),
('100004', 'A', 'Wholesale OEM 1081390 Auto Parts Aluminum Hood Panel Sheet Metal Parts For Tesla Model 3 Series', '../../images/item/100004.jpg', 'Very good seller, professional, and very responsible.', 1.7, 100.00, 'N'),
('100005', 'A', 'CHEVY MALIBU REAR TRUNK LID', '../../images/item/100005.jpg', 'Trunk Lid', 2.1, 140.00, 'N'),
('200001', 'B', 'starters and alternators to radiators and air conditioning components', '../../images/item/200001.jpg', 'From starters and alternators to radiators and air conditioning components, our products are designed with precision and durability in mind.', 0.6, 50.00, 'N'),
('200002', 'B', 'GM 6.2 Liter V8 Supercharged LS9 Engine', '../../images/item/200002.jpg', 'The 6.2-liter V8 Supercharged LS9 was produced by General Motors for use in high-performance vehicles, and is still available as a crate engine offering from Chevrolet Performance. Being one of a handful of GM engines assembled by hand, the LS9 is part of GM’s fourth-generation V8 Small Block engine family and is notorious for being the automaker’s most powerful production engine. It was produced for the sixth-generation Corvette ZR1 — the flagship of the Corvette lineup.', 1, 30.00, 'N'),
('200003', 'B', 'GT-R HD gear kit', '../../images/item/200003.jpg', 'Custom ratio & tooth spec profile Stronger gears spline assembled design', 1.4, 70.00, 'N'),
('200004', 'B', 'Dodge CHRYSLER OEM 98-99 RAM 2500 Front Brake-rotor 52069876AA', '../../images/item/200004.jpg', 'Brand:Mopar', 1.8, 110.00, 'N'),
('200005', 'B', 'Air Suspension Compressor SKP SKAS007', '../../images/item/200005.jpg', 'WARNING: This product may contain chemicals known to the State of California to cause cancer and birth defects or other reproductive harm.', 2.2, 150.00, 'N'),
('300001', 'C', 'Maxalight Halogen Fog Lamp Unit', '../../images/item/300001.jpg', 'MAXALIGHT INDUSTRIES Manufacturing company by Tractor Headlight and fog light and LED Fog lamp MINI Big Boss Black Body premium Quality H4 P-43t Bulb Fitment', 0.7, 60.00, 'N'),
('300002', 'C', 'GMC Yukon Tail Light', '../../images/item/300002.jpg', 'Lenses Ensure Full illumination and Maximum Safety', 1.1, 40.00, 'N'),
('300003', 'C', 'BMW X6 E71 [HID/Xenon AFS] Projector Black Headlights Driver Left+Passenger Right Pair Headlamps', '../../images/item/300003.jpg', '100% Brand New in Box With Customized Packaging Never Been Installed Before', 1.5, 80.00, 'N'),
('300004', 'C', 'Interior Dome Light Roof Silver', '../../images/item/300004.jpg', 'Fit For Toyota Corolla Ae92 101 AT190 ST191 1991 96', 1.9, 120.00, 'N'),
('300005', 'C', 'Model 3 X S Car Headlight New Model Accessories Original', '../../images/item/300005.jpg', 'Color: Warm White', 2.3, 160.00, 'N'),
('400001', 'D', 'Solar Power TPMS with Internal Sensor', '../../images/item/400001.jpg', 'Solar Power TPMS with Internal Sensor', 0.8, 70.00, 'N'),
('400002', 'D', '1 Amp 1 USB Car Charger', '../../images/item/400002.jpg', 'Suitable for any Mobile Phone or SatNav', 1.2, 50.00, 'N'),
('400003', 'D', 'Car Cover', '../../images/item/400003.jpg', 'The Product made is customized as per the vehicle', 1.6, 90.00, 'N'),
('400004', 'D', 'BelkinCar Vent Mount PRO with MagSafe', '../../images/item/400004.jpg', 'Just place your iPhone 12 against our Car Vent Mount engineered with the official MagSafe technology.', 2, 130.00, 'N'),
('400005', 'D', 'Adjustable Dash Car Mount', '../../images/item/400005.jpg', 'Our strongest and most ergonomic MagSafe car mount for iPhone 12, 13, and 14.', 2.4, 170.00, 'N');

-- --------------------------------------------------------

--
-- 資料表結構 `spareqty`
--

DROP TABLE IF EXISTS `spareqty`;
CREATE TABLE IF NOT EXISTS `spareqty` (
  `sparePartNum` char(6) NOT NULL,
  `stockItemQty` int NOT NULL,
  PRIMARY KEY (`sparePartNum`),
  KEY `idx_sparePartNum_spareQty` (`sparePartNum`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 資料表新增資料前，先清除舊資料 `spareqty`
--

TRUNCATE TABLE `spareqty`;
--
-- 傾印資料表的資料 `spareqty`
--

INSERT INTO `spareqty` (`sparePartNum`, `stockItemQty`) VALUES
('100001', 999),
('100002', 999),
('100003', 998),
('100004', 999),
('100005', 999),
('200001', 999),
('200002', 998),
('200003', 999),
('200004', 999),
('200005', 998),
('300001', 989),
('300002', 998),
('300003', 999),
('300004', 999),
('300005', 998),
('400001', 998),
('400002', 999),
('400003', 998),
('400004', 999),
('400005', 999);

-- --------------------------------------------------------

--
-- 資料表結構 `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `userID` int NOT NULL AUTO_INCREMENT,
  `LoginName` varchar(100) NOT NULL,
  `password` char(65) NOT NULL,
  `salesManagerID` int DEFAULT NULL,
  `dealerID` int DEFAULT NULL,
  PRIMARY KEY (`userID`),
  UNIQUE KEY `LoginName` (`LoginName`),
  KEY `idx_salesManagerID_user` (`salesManagerID`),
  KEY `idx_dealerID_user` (`dealerID`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4;

--
-- 資料表新增資料前，先清除舊資料 `user`
--

TRUNCATE TABLE `user`;
--
-- 傾印資料表的資料 `user`
--

INSERT INTO `user` (`userID`, `LoginName`, `password`, `salesManagerID`, `dealerID`) VALUES
(1, 'SM1', '0a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 1, NULL),
(2, 'SM2', '0a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 2, NULL),
(3, 'SM3', '0a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 3, NULL),
(4, 'SM4', '0a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 4, NULL),
(5, 'SM5', '0a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 5, NULL),
(6, 'D1', '0a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', NULL, 1),
(7, 'D2', '0a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', NULL, 2),
(8, 'D3', '0a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', NULL, 3),
(9, 'D4', '0a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', NULL, 4),
(10, 'D5', '0a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', NULL, 5);

--
-- 已傾印資料表的限制式
--

--
-- 資料表的限制式 `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`sparePartNum`) REFERENCES `spare` (`sparePartNum`);

--
-- 資料表的限制式 `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `order_ibfk_1` FOREIGN KEY (`salesManagerID`) REFERENCES `salemanager` (`salesManagerID`),
  ADD CONSTRAINT `order_ibfk_2` FOREIGN KEY (`dealerID`) REFERENCES `dealer` (`dealerID`);

--
-- 資料表的限制式 `orderspare`
--
ALTER TABLE `orderspare`
  ADD CONSTRAINT `orderspare_ibfk_1` FOREIGN KEY (`sparePartNum`) REFERENCES `spare` (`sparePartNum`),
  ADD CONSTRAINT `orderspare_ibfk_2` FOREIGN KEY (`orderID`) REFERENCES `order` (`orderID`);

--
-- 資料表的限制式 `spareqty`
--
ALTER TABLE `spareqty`
  ADD CONSTRAINT `spareqty_ibfk_1` FOREIGN KEY (`sparePartNum`) REFERENCES `spare` (`sparePartNum`);

--
-- 資料表的限制式 `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`salesManagerID`) REFERENCES `salemanager` (`salesManagerID`),
  ADD CONSTRAINT `user_ibfk_2` FOREIGN KEY (`dealerID`) REFERENCES `dealer` (`dealerID`);
SET FOREIGN_KEY_CHECKS=1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
