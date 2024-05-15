CREATE TABLE `dealer` (
  `dealerID` integer(10) PRIMARY KEY,
  `password` varchar(50) NOT NULL,
  `dealerName` varchar(100) UNIQUE NOT NULL,
  `contactName` varchar(100) NOT NULL,
  `contactNumber` integer(30) NOT NULL,
  `faxNumber` integer(30) NOT NULL,
  `deliveryAddress` varchar(255) NOT NULL
);

CREATE TABLE `saleManager` (
  `salesManagerID` integer(10) NOT NULL,
  `password` varchar(50) NOT NULL,
  `managerName` varchar(100) UNIQUE NOT NULL,
  `contactName` varchar(100) NOT NULL,
  `contactNumber` integer(30) NOT NULL
);

CREATE TABLE `order` (
  `orderID` integer(10) PRIMARY KEY,
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
  `sparePartNum` integer(10) PRIMARY KEY,
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

ALTER TABLE `order` ADD FOREIGN KEY (`salesManagerID`) REFERENCES `saleManager` (`salesManagerID`);

ALTER TABLE `order` ADD FOREIGN KEY (`dealerID`) REFERENCES `dealer` (`dealerID`);

ALTER TABLE `spareQty` ADD FOREIGN KEY (`sparePartNum`) REFERENCES `spare` (`sparePartNum`);

ALTER TABLE `orderSpare` ADD FOREIGN KEY (`sparePartNum`) REFERENCES `spare` (`sparePartNum`);

ALTER TABLE `orderSpare` ADD FOREIGN KEY (`orderID`) REFERENCES `order` (`orderID`);
