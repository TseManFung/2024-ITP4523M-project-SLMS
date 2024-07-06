-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1:3306
-- 產生時間： 2024 年 07 月 06 日 05:52
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
  `contactNumber` int NOT NULL,
  `faxNumber` int NOT NULL,
  `deliveryAddress` varchar(255) NOT NULL,
  PRIMARY KEY (`dealerID`),
  UNIQUE KEY `dealerName` (`dealerName`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

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

-- --------------------------------------------------------

--
-- 資料表結構 `salemanager`
--

DROP TABLE IF EXISTS `salemanager`;
CREATE TABLE IF NOT EXISTS `salemanager` (
  `salesManagerID` int NOT NULL AUTO_INCREMENT,
  `managerName` varchar(100) NOT NULL,
  `contactName` varchar(100) NOT NULL,
  `contactNumber` int NOT NULL,
  PRIMARY KEY (`salesManagerID`),
  UNIQUE KEY `managerName` (`managerName`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

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
  `state` char(1) NOT NULL DEFAULT "N",
  PRIMARY KEY (`sparePartNum`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

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

-- --------------------------------------------------------

--
-- 資料表結構 `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `userID` int NOT NULL AUTO_INCREMENT,
  `password` char(65) NOT NULL,
  `salesManagerID` int DEFAULT NULL,
  `dealerID` int DEFAULT NULL,
  PRIMARY KEY (`userID`),
  KEY `idx_salesManagerID_user` (`salesManagerID`),
  KEY `idx_dealerID_user` (`dealerID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

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
