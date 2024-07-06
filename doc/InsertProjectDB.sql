-- Insert data into the `user` table
INSERT INTO `user` (`userID`, `password`, `salesManagerID`, `dealerID`) VALUES
(1, '0a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 1, NULL),
(2, '0a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae4', 2, NULL),
(3, '0a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae5', 3, NULL),
(4, '0a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae6', 4, NULL),
(5, '0a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae7', 5, NULL),
(6, '0a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae8', NULL, 1),
(7, '0a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae9', NULL, 2),
(8, '0a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae10', NULL, 3),
(9, '0a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae11', NULL, 4),
(10, '0a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae11', NULL, 5);

-- Insert data into the `spare` table
INSERT INTO `spare` (`sparePartNum`, `category`, `sparePartName`, `sparePartImage`, `sparePartDescription`, `weight`, `price`, `state`) VALUES
(1, 'A', 'WTF Aluminium alloy sheet', '100001/暫定', 'Aluminium Hot Plate Automotive Die Casting, For Industrial', 65.8, 40, 'N'),
(2, 'B', 'Hole engine', '200001/暫定', 'From starters and alternators to radiators and air conditioning components, our products are designed with precision and durability in mind.', 71.2, 50, 'N'),
(3, 'C', 'Shiift Tail Light Assembly', '300001/暫定', 'MAXALIGHT INDUSTRIES Manufacturing company by Tractor Headlight and fog light and LED Fog lamp MINI Big Boss Black Body premium Quality H4 P-43t Bulb Fitment', 76.6, 60, 'N'),
(4, 'D', 'Tis Vehicle Car Recorder', '400001/暫定', 'Solar Power TPMS with Internal Sensor', 82, 70, 'N'),
(5, 'A', 'fire Stainless Steel Sheet', '100002/暫定', 'Car body kits Auto Parts Chinese Factory Supply car front Rear door car back rear doors for H6S 2021 wholesale', 87.4, 80, 'N');
