use projectDB;

SET
  FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS orderSpare;

DROP TABLE IF EXISTS spareQty;

DROP TABLE IF EXISTS `order`;

DROP TABLE IF EXISTS cart;

DROP TABLE IF EXISTS user;

DROP TABLE IF EXISTS saleManager;

DROP TABLE IF EXISTS dealer;

DROP TABLE IF EXISTS spare;

SET
  FOREIGN_KEY_CHECKS = 1;

CREATE TABLE
  `user` (
    `userID` integer (10) PRIMARY KEY AUTO_INCREMENT,
    `LoginName` varchar(100) UNIQUE NOT NULL,
    `password` char(65) NOT NULL,
    `salesManagerID` integer (10),
    `dealerID` integer (10)
  ) ENGINE = InnoDB;

CREATE TABLE
  `dealer` (
    `dealerID` integer (10) PRIMARY KEY AUTO_INCREMENT,
    `dealerName` varchar(100) UNIQUE NOT NULL,
    `contactName` varchar(100) NOT NULL,
    `contactNumber` varchar(30) NOT NULL,
    `faxNumber` varchar(30) NOT NULL,
    `deliveryAddress` varchar(255) NOT NULL
  ) ENGINE = InnoDB;

CREATE TABLE
  `cart` (
    `userID` integer (10),
    `sparePartNum` char(6),
    `qty` integer (10),
    PRIMARY KEY (`userID`, `sparePartNum`)
  ) ENGINE = InnoDB;

CREATE TABLE
  `saleManager` (
    `salesManagerID` integer (10) PRIMARY KEY AUTO_INCREMENT,
    `managerName` varchar(100) UNIQUE NOT NULL,
    `contactName` varchar(100) NOT NULL,
    `contactNumber` varchar(30) NOT NULL
  ) ENGINE = InnoDB;

CREATE TABLE
  `order` (
    `orderID` integer (10) PRIMARY KEY AUTO_INCREMENT,
    `orderDateTime` timestamp NOT NULL,
    `deliveryAddress` varchar(255) NOT NULL,
    `deliveryDate` date,
    `salesManagerID` integer (10),
    `dealerID` integer (10) NOT NULL,
    `orderItemNumber` integer (10) NOT NULL,
    `TotalAmount` double NOT NULL,
    `shipCost` double NOT NULL,
    `state` char(1) NOT NULL DEFAULT 'C'
  ) ENGINE = InnoDB;

CREATE TABLE
  `spare` (
    `sparePartNum` char(6) PRIMARY KEY,
    `category` ENUM ('A', 'B', 'C', 'D') NOT NULL,
    `sparePartName` varchar(255) NOT NULL,
    `sparePartImage` varchar(100) NOT NULL,
    `sparePartDescription` text NOT NULL,
    `weight` double NOT NULL,
    `price` double NOT NULL,
    `state` char(1) NOT NULL DEFAULT 'N'
  ) ENGINE = InnoDB;

CREATE TABLE
  `spareQty` (
    `sparePartNum` char(6) PRIMARY KEY,
    `stockItemQty` integer (10) NOT NULL
  ) ENGINE = InnoDB;

CREATE TABLE
  `orderSpare` (
    `sparePartNum` char(6),
    `orderID` integer (10),
    `orderQty` integer (10) NOT NULL,
    `sparePartOrderPrice` double NOT NULL,
    PRIMARY KEY (`sparePartNum`, `orderID`)
  ) ENGINE = InnoDB;

ALTER TABLE `user` ADD FOREIGN KEY (`salesManagerID`) REFERENCES `saleManager` (`salesManagerID`);

ALTER TABLE `user` ADD FOREIGN KEY (`dealerID`) REFERENCES `dealer` (`dealerID`);

ALTER TABLE `cart` ADD FOREIGN KEY (`userID`) REFERENCES `user` (`userID`);

ALTER TABLE `cart` ADD FOREIGN KEY (`sparePartNum`) REFERENCES `spare` (`sparePartNum`);

ALTER TABLE `order` ADD FOREIGN KEY (`salesManagerID`) REFERENCES `saleManager` (`salesManagerID`);

ALTER TABLE `order` ADD FOREIGN KEY (`dealerID`) REFERENCES `dealer` (`dealerID`);

ALTER TABLE `spareQty` ADD FOREIGN KEY (`sparePartNum`) REFERENCES `spare` (`sparePartNum`);

ALTER TABLE `orderSpare` ADD FOREIGN KEY (`sparePartNum`) REFERENCES `spare` (`sparePartNum`);

ALTER TABLE `orderSpare` ADD FOREIGN KEY (`orderID`) REFERENCES `order` (`orderID`);

CREATE INDEX `idx_dealerID` ON `order` (`dealerID`);

CREATE INDEX `idx_salesManagerID` ON `order` (`salesManagerID`);

CREATE INDEX `idx_orderID` ON `order` (`orderID`);

CREATE INDEX idx_state_order ON `order` (`state`);

CREATE INDEX `idx_sparePartNum_spareQty` ON `spareQty` (`sparePartNum`);

CREATE INDEX `idx_sparePartNum_orderSpare` ON `orderSpare` (`sparePartNum`);

CREATE INDEX `idx_orderID_orderSpare` ON `orderSpare` (`orderID`);

CREATE INDEX idx_salesManagerID_user ON `user` (`salesManagerID`);

CREATE INDEX idx_dealerID_user ON `user` (`dealerID`);