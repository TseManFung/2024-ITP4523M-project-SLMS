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
INSERT INTO `spare` (
    `category`, `sparePartName`, `sparePartImage`, `sparePartDescription`, `weight`, `price`, `state`
) VALUES 
('A', 'WTF Aluminium alloy sheet', '../../images/item/100001.jpg', 'Aluminium Hot Plate Automotive Die Casting, For Industrial', 65.8, 40, 'N'),
('B', 'Hole engine', '../../images/item/200001.jpg', 'From starters and alternators to radiators and air conditioning components, our products are designed with precision and durability in mind.', 71.2, 50, 'N'),
('C', 'Shiift Tail Light Assembly', '../../images/item/300001.jpg', 'MAXALIGHT INDUSTRIES Manufacturing company by Tractor Headlight and fog light and LED Fog lamp MINI Big Boss Black Body premium Quality H4 P-43t Bulb Fitment', 76.6, 60, 'N'),
('D', 'Tis Vehicle Car Recorder', '../../images/item/400001.jpg', 'Solar Power TPMS with Internal Sensor', 82, 70, 'N'),
('A', 'fire Stainless Steel Sheet', '../../images/item/100002.jpg', 'Car body kits Auto Parts Chinese Factory Supply car front Rear door car back rear doors for H6S 2021 wholesale', 87.4, 80, 'N'),
('B', 'GM 6.2 Liter V8 Supercharged LS9 Engine', '../../images/item/200002.jpg', 'The 6.2-liter V8 Supercharged LS9 was produced by General Motors for use in high-performance vehicles, and is still available as a crate engine offering from Chevrolet Performance. Being one of a handful of GM engines assembled by hand, the LS9 is part of GM’s fourth-generation V8 Small Block engine family and is notorious for being the automaker’s most powerful production engine. It was produced for the sixth-generation Corvette ZR1 — the flagship of the Corvette lineup.', 92.8, 30, 'N'),
('C', 'GMC Yukon Tail Light', '../../images/item/300002.jpg', 'Lenses Ensure Full illumination and Maximum Safety', 98.2, 40, 'N'),
('D', '1 Amp 1 USB Car Charger', '../../images/item/400002.jpg', 'Suitable for any Mobile Phone or SatNav', 103.6, 50, 'N'),
('A', 'ordinary car door', '../../images/item/100003.jpg', "Most of the door exterior is a millimeters-thick mild steel. A .308 from a fair distance won't even notice it.", 109, 60, 'N'),
('B', 'GT-R HD gear kit', '../../images/item/200003.jpg', 'Custom ratio & tooth spec profile Stronger gears spline assembled design', 114.4, 70, 'N'),
('C', 'BMW X6 E71 [HID/Xenon AFS] Projector Black Headlights Driver Left+Passenger Right Pair Headlamps', '../../images/item/300003.jpg', '100% Brand New in Box With Customized Packaging Never Been Installed Before', 119.8, 80, 'N'),
('D', 'Car Cover', '../../images/item/400003.jpg', 'The Product made is customized as per the vehicle', 125.2, 90, 'N'),
('A', 'Wholesale OEM 1081390 Auto Parts Aluminum Hood Panel Sheet Metal Parts For Tesla Model 3 Series', '../../images/item/100004.jpg', 'Very good seller, professional, and very responsible.', 130.6, 100, 'N'),
('B', 'Dodge CHRYSLER OEM 98-99 RAM 2500 Front Brake-rotor 52069876AA', '../../images/item/200004.jpg', 'Brand:Mopar', 136, 110, 'N'),
('C', 'Interior Dome Light Roof Silver', '../../images/item/300004.jpg', 'Fit For Toyota Corolla Ae92 101 AT190 ST191 1991 96', 141.4, 120, 'N'),
('D', 'BelkinCar Vent Mount PRO with MagSafe', '../../images/item/400004.jpg', 'Just place your iPhone 12 against our Car Vent Mount engineered with the official MagSafe technology.', 146.8, 130, 'N'),
('A', 'TRL36436', '../../images/item/100005.jpg', 'Trunk Lid', 152.2, 140, 'N'),
('B', 'Air Suspension Compressor SKP SKAS007', '../../images/item/200005.jpg', 'WARNING: This product may contain chemicals known to the State of California to cause cancer and birth defects or other reproductive harm.', 157.6, 150, 'N'),
('C', 'Model 3 X S Car Headlight New Model Accessories Original', '../../images/item/300005.jpg', 'Color: Warm White', 163, 160, 'N'),
('D', 'Adjustable Dash Car Mount', '../../images/item/400005.jpg', 'Our strongest and most ergonomic MagSafe car mount for iPhone 12, 13, and 14.', 168.4, 170, 'N');
