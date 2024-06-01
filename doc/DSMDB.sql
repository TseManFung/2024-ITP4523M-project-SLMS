CREATE TABLE `user` (
  `userID` integer(10) PRIMARY KEY AUTO_INCREMENT,
  `password` varchar(50) NOT NULL,
  `salesManagerID` integer(10),
  `dealerID` integer(10)
);

CREATE TABLE `dealer` (
  `dealerID` integer(10) PRIMARY KEY AUTO_INCREMENT,
  `dealerName` varchar(100) UNIQUE NOT NULL,
  `contactName` varchar(100) NOT NULL,
  `contactNumber` integer(30) NOT NULL,
  `faxNumber` integer(30) NOT NULL,
  `deliveryAddress` varchar(255) NOT NULL
);

CREATE TABLE `cart` (
  `userID` integer(10),
  `sparePartNum` integer(10),
  `qty` integer(10),
  PRIMARY KEY (`userID`, `sparePartNum`)
);

CREATE TABLE `saleManager` (
  `salesManagerID` integer(10) NOT NULL AUTO_INCREMENT,
  `managerName` varchar(100) UNIQUE NOT NULL,
  `contactName` varchar(100) NOT NULL,
  `contactNumber` integer(30) NOT NULL
);

CREATE TABLE `order` (
  `orderID` integer(10) PRIMARY KEY AUTO_INCREMENT,
  `orderDateTime` timestamp NOT NULL,
  `deliveryAddress` varchar(255) NOT NULL,
  `deliveryDate` date NOT NULL,
  `salesManagerID` integer(10),
  `dealerID` integer(10) NOT NULL,
  `orderItemNumber` integer(10) NOT NULL,
  `TotalAmount` double NOT NULL,
  `shipCost` double NOT NULL,
  `state` char(1) NOT NULL
);

CREATE TABLE `spare` (
  `sparePartNum` integer(10) PRIMARY KEY AUTO_INCREMENT,
  `category` Category NOT NULL,
  `sparePartName` varchar(255) NOT NULL,
  `sparePartImage` varchar(100) NOT NULL,
  `sparePartDescription` text NOT NULL,
  `weight` double NOT NULL,
  `price` double NOT NULL,
  `state` char(1) NOT NULL
);

CREATE TABLE `spareQty` (
  `sparePartNum` integer(10) PRIMARY KEY,
  `stockItemQty` integer(10) NOT NULL
);

CREATE TABLE `orderSpare` (
  `sparePartNum` integer(10),
  `orderID` integer(10),
  `orderQty` integer(10) NOT NULL,
  `sparePartOrderPrice` double NOT NULL,
  PRIMARY KEY (`sparePartNum`, `orderID`)
);

ALTER TABLE `user` ADD FOREIGN KEY (`salesManagerID`) REFERENCES `saleManager` (`salesManagerID`);

ALTER TABLE `user` ADD FOREIGN KEY (`dealerID`) REFERENCES `dealer` (`dealerID`);

ALTER TABLE `cart` ADD FOREIGN KEY (`userID`) REFERENCES `user` (`userID`);

ALTER TABLE `cart` ADD FOREIGN KEY (`sparePartNum`) REFERENCES `spare` (`sparePartName`);

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