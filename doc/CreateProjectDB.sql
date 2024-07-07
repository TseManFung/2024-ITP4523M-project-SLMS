-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1:3306
-- 產生時間： 2024 年 07 月 07 日 07:19
-- 伺服器版本： 8.3.0
-- PHP 版本： 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+08:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `projectdb`
--

-- --------------------------------------------------------

--
-- 資料表結構 `cart`
--

DROP TABLE IF EXISTS `cart`;
CREATE TABLE IF NOT EXISTS `cart` (
  `userID` int NOT NULL,
  `sparePartNum` int NOT NULL,
  `qty` int DEFAULT NULL,
  PRIMARY KEY (`userID`,`sparePartNum`),
  KEY `sparePartNum` (`sparePartNum`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3;

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
  `orderDateTime` timestamp NOT NULL,
  `deliveryAddress` varchar(255) NOT NULL,
  `deliveryDate` date NOT NULL,
  `salesManagerID` int DEFAULT NULL,
  `dealerID` int NOT NULL,
  `orderItemNumber` int NOT NULL,
  `TotalAmount` double NOT NULL,
  `shipCost` double NOT NULL,
  `state` char(1) NOT NULL DEFAULT 'C',
  PRIMARY KEY (`orderID`),
  KEY `idx_dealerID` (`dealerID`),
  KEY `idx_salesManagerID` (`salesManagerID`),
  KEY `idx_orderID` (`orderID`),
  KEY `idx_state_order` (`state`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3;

--
-- 傾印資料表的資料 `order`
--

INSERT INTO `order` (`orderID`, `orderDateTime`, `deliveryAddress`, `deliveryDate`, `salesManagerID`, `dealerID`, `orderItemNumber`, `TotalAmount`, `shipCost`, `state`) VALUES
(1, '2024-06-22 16:00:00', '北京市朝陽區建國路100號1樓', '2024-06-23', 1, 1, 15, 400, 25, 'C'),
(2, '2024-06-23 16:00:00', '北京市海淀區西三旗街道1號', '2024-06-24', 1, 2, 20, 1000, 50, 'A'),
(3, '2024-06-24 16:00:00', '北京市昌平區回龍觀東大街2號', '2024-06-25', 1, 3, 30, 1800, 75, 'R'),
(4, '2024-06-25 16:00:00', '北京市西城區西單北大街3號', '2024-06-26', 1, 4, 40, 2800, 100, 'T'),
(5, '2024-06-26 16:00:00', '香港中環皇后大道中1號', '2024-06-29', 1, 5, 50, 4000, 125, 'F');

-- --------------------------------------------------------

--
-- 資料表結構 `orderspare`
--

DROP TABLE IF EXISTS `orderspare`;
CREATE TABLE IF NOT EXISTS `orderspare` (
  `sparePartNum` int NOT NULL,
  `orderID` int NOT NULL,
  `orderQty` int NOT NULL,
  `sparePartOrderPrice` double NOT NULL,
  PRIMARY KEY (`sparePartNum`,`orderID`),
  KEY `idx_sparePartNum_orderSpare` (`sparePartNum`),
  KEY `idx_orderID_orderSpare` (`orderID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- 傾印資料表的資料 `orderspare`
--

INSERT INTO `orderspare` (`sparePartNum`, `orderID`, `orderQty`, `sparePartOrderPrice`) VALUES
(1, 1, 10, 40),
(2, 1, 5, 48),
(3, 2, 20, 60),
(4, 3, 30, 70),
(5, 4, 40, 80),
(6, 5, 50, 30);

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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3;

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
  `sparePartNum` int NOT NULL AUTO_INCREMENT,
  `category` enum('A','B','C','D') NOT NULL,
  `sparePartName` varchar(255) NOT NULL,
  `sparePartImage` varchar(100) NOT NULL,
  `sparePartDescription` text NOT NULL,
  `weight` double NOT NULL,
  `price` double NOT NULL,
  `state` char(1) NOT NULL DEFAULT 'N',
  PRIMARY KEY (`sparePartNum`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb3;

--
-- 傾印資料表的資料 `spare`
--

INSERT INTO `spare` (`sparePartNum`, `category`, `sparePartName`, `sparePartImage`, `sparePartDescription`, `weight`, `price`, `state`) VALUES
(1, 'A', 'T300 PANEL ASSEMBLY DASH LWR EXTN', '../../images/item/100001.jpg', 'Aluminium Hot Plate Automotive Die Casting, For Industrial', 65.8, 40, 'N'),
(2, 'B', ' starters and alternators to radiators and air conditioning components', '../../images/item/200001.jpg', 'From starters and alternators to radiators and air conditioning components, our products are designed with precision and durability in mind.', 71.2, 50, 'N'),
(3, 'C', 'Maxalight Halogen Fog Lamp Unit', '../../images/item/300001.jpg', 'MAXALIGHT INDUSTRIES Manufacturing company by Tractor Headlight and fog light and LED Fog lamp MINI Big Boss Black Body premium Quality H4 P-43t Bulb Fitment', 76.6, 60, 'N'),
(4, 'D', 'Solar Power TPMS with Internal Sensor', '../../images/item/400001.jpg', 'Solar Power TPMS with Internal Sensor', 82, 70, 'N'),
(5, 'A', 'car back rear doors', '../../images/item/100002.jpg', 'Car body kits Auto Parts Chinese Factory Supply car front Rear door car back rear doors for H6S 2021 wholesale', 87.4, 80, 'N'),
(6, 'B', 'GM 6.2 Liter V8 Supercharged LS9 Engine', '../../images/item/200002.jpg', 'The 6.2-liter V8 Supercharged LS9 was produced by General Motors for use in high-performance vehicles, and is still available as a crate engine offering from Chevrolet Performance. Being one of a handful of GM engines assembled by hand, the LS9 is part of GM’s fourth-generation V8 Small Block engine family and is notorious for being the automaker’s most powerful production engine. It was produced for the sixth-generation Corvette ZR1 — the flagship of the Corvette lineup.', 92.8, 30, 'N'),
(7, 'C', 'GMC Yukon Tail Light', '../../images/item/300002.jpg', 'Lenses Ensure Full illumination and Maximum Safety', 98.2, 40, 'N'),
(8, 'D', '1 Amp 1 USB Car Charger', '../../images/item/400002.jpg', 'Suitable for any Mobile Phone or SatNav', 103.6, 50, 'N'),
(9, 'A', 'ordinary car door', '../../images/item/100003.jpg', 'Most of the door exterior is a millimeters-thick mild steel. A .308 from a fair distance won\'t even notice it.', 109, 60, 'N'),
(10, 'B', 'GT-R HD gear kit', '../../images/item/200003.jpg', 'Custom ratio & tooth spec profile Stronger gears spline assembled design', 114.4, 70, 'N'),
(11, 'C', 'BMW X6 E71 [HID/Xenon AFS] Projector Black Headlights Driver Left+Passenger Right Pair Headlamps', '../../images/item/300003.jpg', '100% Brand New in Box With Customized Packaging Never Been Installed Before', 119.8, 80, 'N'),
(12, 'D', 'Car Cover', '../../images/item/400003.jpg', 'The Product made is customized as per the vehicle', 125.2, 90, 'N'),
(13, 'A', 'Wholesale OEM 1081390 Auto Parts Aluminum Hood Panel Sheet Metal Parts For Tesla Model 3 Series', '../../images/item/100004.jpg', 'Very good seller, professional, and very responsible.', 130.6, 100, 'N'),
(14, 'B', 'Dodge CHRYSLER OEM 98-99 RAM 2500 Front Brake-rotor 52069876AA', '../../images/item/200004.jpg', 'Brand:Mopar', 136, 110, 'N'),
(15, 'C', 'Interior Dome Light Roof Silver', '../../images/item/300004.jpg', 'Fit For Toyota Corolla Ae92 101 AT190 ST191 1991 96', 141.4, 120, 'N'),
(16, 'D', 'BelkinCar Vent Mount PRO with MagSafe', '../../images/item/400004.jpg', 'Just place your iPhone 12 against our Car Vent Mount engineered with the official MagSafe technology.', 146.8, 130, 'N'),
(17, 'A', 'CHEVY MALIBU REAR TRUNK LID', '../../images/item/100005.jpg', 'Trunk Lid', 152.2, 140, 'N'),
(18, 'B', 'Air Suspension Compressor SKP SKAS007', '../../images/item/200005.jpg', 'WARNING: This product may contain chemicals known to the State of California to cause cancer and birth defects or other reproductive harm.', 157.6, 150, 'N'),
(19, 'C', 'Model 3 X S Car Headlight New Model Accessories Original', '../../images/item/300005.jpg', 'Color: Warm White', 163, 160, 'N'),
(20, 'D', 'Adjustable Dash Car Mount', '../../images/item/400005.jpg', 'Our strongest and most ergonomic MagSafe car mount for iPhone 12, 13, and 14.', 168.4, 170, 'N');

-- --------------------------------------------------------

--
-- 資料表結構 `spareqty`
--

DROP TABLE IF EXISTS `spareqty`;
CREATE TABLE IF NOT EXISTS `spareqty` (
  `sparePartNum` int NOT NULL,
  `stockItemQty` int NOT NULL,
  PRIMARY KEY (`sparePartNum`),
  KEY `idx_sparePartNum_spareQty` (`sparePartNum`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- 傾印資料表的資料 `spareqty`
--

INSERT INTO `spareqty` (`sparePartNum`, `stockItemQty`) VALUES
(1, 990),
(2, 995),
(3, 980),
(4, 970),
(5, 960),
(6, 950),
(7, 1000),
(8, 1000),
(9, 1000),
(10, 1000),
(11, 1000),
(12, 1000),
(13, 1000),
(14, 1000),
(15, 1000),
(16, 1000),
(17, 1000),
(18, 1000),
(19, 1000),
(20, 1000);

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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb3;

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
