-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 18, 2023 at 02:21 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `car_sharing`
--

-- --------------------------------------------------------

--
-- Table structure for table `car`
--

CREATE TABLE `car` (
  `id` int(11) NOT NULL,
  `car_model_id` int(11) NOT NULL,
  `car_type_of_fuel_id` int(11) NOT NULL,
  `car_transmission_id` int(11) NOT NULL,
  `car_state_id` int(11) NOT NULL,
  `buying_price` decimal(10,2) NOT NULL,
  `driven_kilometers` decimal(8,1) NOT NULL,
  `number_of_seats` int(3) NOT NULL,
  `power` int(4) NOT NULL,
  `manufacturing year` int(11) NOT NULL,
  `vehicle_identification_number` char(17) NOT NULL,
  `image_location` varchar(100) NOT NULL,
  `car_colour_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `car`
--

INSERT INTO `car` (`id`, `car_model_id`, `car_type_of_fuel_id`, `car_transmission_id`, `car_state_id`, `buying_price`, `driven_kilometers`, `number_of_seats`, `power`, `manufacturing year`, `vehicle_identification_number`, `image_location`, `car_colour_id`) VALUES
(1, 1, 2, 1, 2, '10380.00', '252525.0', 5, 40, 2002, '4Y1SL65848Z411439', 'Škoda_Fabia_Yellow.jpg', 1),
(5, 3, 1, 2, 3, '55412.00', '50248.0', 5, 211, 2019, '9P9AW92148Z411821', 'Tesla_Model_3_Dualmotor_Long_Range_Autopilot.jpg', 2),
(6, 3, 1, 2, 2, '65412.00', '50000.0', 5, 211, 2019, '9P9AL92148Z445821', 'Tesla_Model_3_Dualmotor_Long_Range_Autopilot.jpg', 2),
(7, 3, 1, 2, 3, '58482.00', '100000.0', 5, 211, 2019, '9P9AL92148Z894821', 'Tesla_Model_3_Dualmotor_Long_Range_Autopilot.jpg', 2),
(8, 3, 1, 2, 1, '58555.00', '65872.0', 5, 211, 2019, '9P9AL92148Z485821', 'Tesla_Model_3_Dualmotor_Long_Range_Autopilot.jpg', 2),
(9, 3, 1, 2, 1, '58000.00', '25555.0', 5, 211, 2019, '9P9AL98448Z485821', 'Tesla_Model_3_Dualmotor_Long_Range_Autopilot.jpg', 2),
(10, 3, 1, 2, 1, '55555.00', '22222.0', 5, 211, 2019, '9P9PO98448Z485821', 'Tesla_Model_3_Dualmotor_Long_Range_Autopilot.jpg', 2),
(11, 3, 1, 2, 1, '48945.00', '48524.0', 5, 211, 2019, '9P9PO12448Z485821', 'Tesla_Model_3_Dualmotor_Long_Range_Autopilot.jpg', 2),
(12, 3, 1, 2, 1, '49999.00', '54206.0', 5, 211, 2019, '9P9PO12446L455821', 'Tesla_Model_3_Dualmotor_Long_Range_Autopilot.jpg', 2),
(13, 3, 1, 2, 1, '49145.00', '54978.0', 5, 211, 2019, '9P9PO12988L455821', 'Tesla_Model_3_Dualmotor_Long_Range_Autopilot.jpg', 2),
(14, 3, 1, 2, 1, '49984.00', '51253.0', 5, 211, 2019, '9P9PO12988L412521', 'Tesla_Model_3_Dualmotor_Long_Range_Autopilot.jpg', 2),
(15, 1, 2, 1, 2, '8725.00', '200000.0', 5, 40, 2002, '4Y1SL12848Z411439', 'Škoda_Fabia_Yellow.jpg', 1),
(16, 1, 2, 1, 1, '9990.00', '415425.0', 5, 40, 2002, '4Y1SL65847Z541439', 'Škoda_Fabia_Yellow.jpg', 1),
(17, 1, 2, 1, 1, '8880.00', '754125.0', 5, 40, 2002, '4Y1SL12347Z541439', 'Škoda_Fabia_Yellow.jpg', 1),
(18, 3, 1, 2, 1, '45782.00', '15780.0', 5, 211, 2019, '9P9AL92988Z894821', 'Tesla_Model_3_Dualmotor_Long_Range_Autopilot.jpg', 2);

-- --------------------------------------------------------

--
-- Table structure for table `car_body_style`
--

CREATE TABLE `car_body_style` (
  `id` int(11) NOT NULL,
  `name` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `car_body_style`
--

INSERT INTO `car_body_style` (`id`, `name`) VALUES
(1, 'hatchback'),
(2, 'sedan'),
(3, 'liftback'),
(4, 'MPV'),
(5, 'SUV');

-- --------------------------------------------------------

--
-- Table structure for table `car_car_feature`
--

CREATE TABLE `car_car_feature` (
  `id` int(11) NOT NULL,
  `car_id` int(11) NOT NULL,
  `car_feature_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `car_car_feature`
--

INSERT INTO `car_car_feature` (`id`, `car_id`, `car_feature_id`) VALUES
(1, 5, 6);

-- --------------------------------------------------------

--
-- Table structure for table `car_colour`
--

CREATE TABLE `car_colour` (
  `id` int(11) NOT NULL,
  `colour` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `car_colour`
--

INSERT INTO `car_colour` (`id`, `colour`) VALUES
(1, 'žltá'),
(2, 'sivá');

-- --------------------------------------------------------

--
-- Table structure for table `car_feature`
--

CREATE TABLE `car_feature` (
  `id` int(11) NOT NULL,
  `car_feature_category_id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `description` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `car_feature`
--

INSERT INTO `car_feature` (`id`, `car_feature_category_id`, `name`, `description`) VALUES
(2, 1, 'tempomat', 'tempomat'),
(3, 2, 'ABS', 'ABS'),
(4, 2, 'brzdový asistent', 'brzdový asistent'),
(5, 1, 'posilňovač riadenia', 'posilňovač riadenia'),
(6, 1, 'vyhrievané sedadlá', 'vyhrievané sedadlá');

-- --------------------------------------------------------

--
-- Table structure for table `car_feature_category`
--

CREATE TABLE `car_feature_category` (
  `id` int(11) NOT NULL,
  `category` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `car_feature_category`
--

INSERT INTO `car_feature_category` (`id`, `category`) VALUES
(1, 'komfortné'),
(2, 'bezpečnostné');

-- --------------------------------------------------------

--
-- Table structure for table `car_mafucaturer`
--

CREATE TABLE `car_mafucaturer` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `car_mafucaturer`
--

INSERT INTO `car_mafucaturer` (`id`, `name`) VALUES
(1, 'Škoda'),
(2, 'Tesla');

-- --------------------------------------------------------

--
-- Table structure for table `car_model`
--

CREATE TABLE `car_model` (
  `id` int(11) NOT NULL,
  `car_manufacturer_id` int(11) NOT NULL,
  `car_body_style_id` int(11) NOT NULL,
  `model` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `car_model`
--

INSERT INTO `car_model` (`id`, `car_manufacturer_id`, `car_body_style_id`, `model`) VALUES
(1, 1, 1, 'Fabia 6Y 1.2 HTP'),
(3, 2, 3, 'Model 3 Dualmotor Long Range Autopilot');

-- --------------------------------------------------------

--
-- Table structure for table `car_model_car_feature`
--

CREATE TABLE `car_model_car_feature` (
  `id` int(11) NOT NULL,
  `car_model_id` int(11) NOT NULL,
  `car_feature_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `car_model_car_feature`
--

INSERT INTO `car_model_car_feature` (`id`, `car_model_id`, `car_feature_id`) VALUES
(1, 3, 3),
(2, 3, 2),
(3, 3, 4),
(4, 3, 5);

-- --------------------------------------------------------

--
-- Table structure for table `car_state`
--

CREATE TABLE `car_state` (
  `id` int(11) NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `car_state`
--

INSERT INTO `car_state` (`id`, `status`) VALUES
(1, 'k dispozícii'),
(2, 'vrátené zákazníkom'),
(3, 'zapožičané'),
(4, 'v servise'),
(5, 'trvalo vyradené ');

-- --------------------------------------------------------

--
-- Table structure for table `car_transmission`
--

CREATE TABLE `car_transmission` (
  `id` int(11) NOT NULL,
  `type` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `car_transmission`
--

INSERT INTO `car_transmission` (`id`, `type`) VALUES
(1, 'manuálna'),
(2, 'automatická');

-- --------------------------------------------------------

--
-- Table structure for table `car_type_of_fuel`
--

CREATE TABLE `car_type_of_fuel` (
  `id` int(11) NOT NULL,
  `type` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `car_type_of_fuel`
--

INSERT INTO `car_type_of_fuel` (`id`, `type`) VALUES
(1, 'elektro'),
(2, 'benzín'),
(3, 'diesel');

-- --------------------------------------------------------

--
-- Table structure for table `car_user`
--

CREATE TABLE `car_user` (
  `id` int(11) NOT NULL,
  `car_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rent_from` date NOT NULL,
  `rent_to` date DEFAULT NULL,
  `rent_to_expected` date NOT NULL,
  `deposit` decimal(10,2) NOT NULL,
  `deposit_iban` varchar(32) NOT NULL,
  `deposit_status_id` int(11) NOT NULL,
  `payment` decimal(8,2) DEFAULT NULL,
  `payment_iban` varchar(34) DEFAULT NULL,
  `payment_status_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `car_user`
--

INSERT INTO `car_user` (`id`, `car_id`, `user_id`, `rent_from`, `rent_to`, `rent_to_expected`, `deposit`, `deposit_iban`, `deposit_status_id`, `payment`, `payment_iban`, `payment_status_id`) VALUES
(70, 9, 1, '2022-04-19', '2022-04-22', '2022-04-22', '34.14', 'SK123456789', 3, '232.00', 'SK8975000000000012345671', 2),
(71, 1, 1, '2022-04-04', '2022-04-22', '2022-04-10', '33.02', 'SK1234', 3, '1397.22', 'SK8975000000000012345671', 2),
(73, 6, 1, '2022-04-19', '2022-04-23', '2022-04-20', '36.19', 'SK564', 3, '620.78', 'SK8975000000000012345671', 2),
(74, 5, 1, '2022-04-22', NULL, '2022-04-23', '33.55', 'SK8975000000000012345671', 1, NULL, NULL, NULL),
(75, 7, 1, '2022-04-23', NULL, '2022-04-23', '33.29', 'SK8975000000000012345671', 1, NULL, NULL, NULL),
(76, 15, 1, '2022-04-24', '2022-04-24', '2022-04-28', '33.08', 'SK123456789', 3, '8.56', 'SK8975000000000012345671', 2);

--
-- Triggers `car_user`
--
DELIMITER $$
CREATE TRIGGER `update_car` AFTER INSERT ON `car_user` FOR EACH ROW UPDATE car
    SET car_state_id = (SELECT id FROM car_state WHERE status = 'zapožičané')
    WHERE id = NEW.car_id
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `cons`
--

CREATE TABLE `cons` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `value` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cons`
--

INSERT INTO `cons` (`id`, `name`, `value`) VALUES
(1, 'image directory', 'img/');

-- --------------------------------------------------------

--
-- Table structure for table `deposit_status`
--

CREATE TABLE `deposit_status` (
  `id` int(11) NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `deposit_status`
--

INSERT INTO `deposit_status` (`id`, `status`) VALUES
(1, 'čakajúca na úhradu'),
(2, 'uhradená'),
(3, 'čakajúca na vrátenie'),
(4, 'vrátená');

-- --------------------------------------------------------

--
-- Table structure for table `discount`
--

CREATE TABLE `discount` (
  `id` int(11) NOT NULL,
  `coeficient` decimal(3,2) NOT NULL,
  `payed` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `discount`
--

INSERT INTO `discount` (`id`, `coeficient`, `payed`) VALUES
(1, '0.01', '1000.00'),
(2, '0.02', '2000.00'),
(3, '0.03', '4000.00'),
(4, '0.05', '8000.00');

-- --------------------------------------------------------

--
-- Table structure for table `payment_status`
--

CREATE TABLE `payment_status` (
  `id` int(11) NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `payment_status`
--

INSERT INTO `payment_status` (`id`, `status`) VALUES
(1, 'čakajúca na úhradu'),
(2, 'uhradená');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password_hashed` char(64) NOT NULL,
  `forename` varchar(100) NOT NULL,
  `surname` varchar(100) NOT NULL,
  `birthdate` date NOT NULL,
  `email` varchar(320) NOT NULL,
  `iban` varchar(34) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password_hashed`, `forename`, `surname`, `birthdate`, `email`, `iban`) VALUES
(1, 'knorm', '994251057a95546f2eccdcf1cc25140017b3f5c9ba360f1e34891b1b9dc58f4b', 'Michal', 'Knor', '2000-01-01', '', 'SK8975000000000012345671');

-- --------------------------------------------------------

--
-- Table structure for table `user_token`
--

CREATE TABLE `user_token` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `token` char(32) NOT NULL,
  `valid_from` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `valid_to` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_token`
--

INSERT INTO `user_token` (`id`, `user_id`, `token`, `valid_from`, `valid_to`) VALUES
(743, 1, 'BAbcf6tx2FKAPF4sPs8mqGIMiLeyhrSE', '2022-04-24 00:03:52', '2022-04-25 00:03:52');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `car`
--
ALTER TABLE `car`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `vehicle_identification_number` (`vehicle_identification_number`),
  ADD KEY `car_model_id` (`car_model_id`),
  ADD KEY `car_type_of_fuel_id` (`car_type_of_fuel_id`),
  ADD KEY `car_transmission_id` (`car_transmission_id`),
  ADD KEY `car_state_id` (`car_state_id`),
  ADD KEY `car_colour_id` (`car_colour_id`);

--
-- Indexes for table `car_body_style`
--
ALTER TABLE `car_body_style`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `car_car_feature`
--
ALTER TABLE `car_car_feature`
  ADD PRIMARY KEY (`id`),
  ADD KEY `car_id` (`car_id`),
  ADD KEY `car_feature_id` (`car_feature_id`);

--
-- Indexes for table `car_colour`
--
ALTER TABLE `car_colour`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `car_feature`
--
ALTER TABLE `car_feature`
  ADD PRIMARY KEY (`id`),
  ADD KEY `car_feature_category_id` (`car_feature_category_id`);

--
-- Indexes for table `car_feature_category`
--
ALTER TABLE `car_feature_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `car_mafucaturer`
--
ALTER TABLE `car_mafucaturer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `car_model`
--
ALTER TABLE `car_model`
  ADD PRIMARY KEY (`id`),
  ADD KEY `car_manufacturer_id` (`car_manufacturer_id`),
  ADD KEY `car_body_style_id` (`car_body_style_id`);

--
-- Indexes for table `car_model_car_feature`
--
ALTER TABLE `car_model_car_feature`
  ADD PRIMARY KEY (`id`),
  ADD KEY `car_model_id` (`car_model_id`),
  ADD KEY `car_feature_id` (`car_feature_id`);

--
-- Indexes for table `car_state`
--
ALTER TABLE `car_state`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `car_transmission`
--
ALTER TABLE `car_transmission`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `car_type_of_fuel`
--
ALTER TABLE `car_type_of_fuel`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `car_user`
--
ALTER TABLE `car_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `car_id` (`car_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `payment_status_id` (`payment_status_id`),
  ADD KEY `deposit_status_id` (`deposit_status_id`);

--
-- Indexes for table `cons`
--
ALTER TABLE `cons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deposit_status`
--
ALTER TABLE `deposit_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `discount`
--
ALTER TABLE `discount`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_status`
--
ALTER TABLE `payment_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `user_token`
--
ALTER TABLE `user_token`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `token` (`token`) USING BTREE,
  ADD UNIQUE KEY `user_id` (`user_id`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `car`
--
ALTER TABLE `car`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `car_body_style`
--
ALTER TABLE `car_body_style`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `car_car_feature`
--
ALTER TABLE `car_car_feature`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `car_colour`
--
ALTER TABLE `car_colour`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `car_feature`
--
ALTER TABLE `car_feature`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `car_feature_category`
--
ALTER TABLE `car_feature_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `car_mafucaturer`
--
ALTER TABLE `car_mafucaturer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `car_model`
--
ALTER TABLE `car_model`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `car_model_car_feature`
--
ALTER TABLE `car_model_car_feature`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `car_state`
--
ALTER TABLE `car_state`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `car_transmission`
--
ALTER TABLE `car_transmission`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `car_type_of_fuel`
--
ALTER TABLE `car_type_of_fuel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `car_user`
--
ALTER TABLE `car_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `cons`
--
ALTER TABLE `cons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `deposit_status`
--
ALTER TABLE `deposit_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `discount`
--
ALTER TABLE `discount`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `payment_status`
--
ALTER TABLE `payment_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_token`
--
ALTER TABLE `user_token`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=744;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `car`
--
ALTER TABLE `car`
  ADD CONSTRAINT `car_ibfk_1` FOREIGN KEY (`car_state_id`) REFERENCES `car_state` (`id`),
  ADD CONSTRAINT `car_ibfk_2` FOREIGN KEY (`car_transmission_id`) REFERENCES `car_transmission` (`id`),
  ADD CONSTRAINT `car_ibfk_3` FOREIGN KEY (`car_type_of_fuel_id`) REFERENCES `car_type_of_fuel` (`id`),
  ADD CONSTRAINT `car_ibfk_4` FOREIGN KEY (`car_model_id`) REFERENCES `car_model` (`id`),
  ADD CONSTRAINT `car_ibfk_5` FOREIGN KEY (`car_colour_id`) REFERENCES `car_colour` (`id`);

--
-- Constraints for table `car_car_feature`
--
ALTER TABLE `car_car_feature`
  ADD CONSTRAINT `car_car_feature_ibfk_1` FOREIGN KEY (`car_id`) REFERENCES `car` (`id`),
  ADD CONSTRAINT `car_car_feature_ibfk_2` FOREIGN KEY (`car_feature_id`) REFERENCES `car_feature` (`id`);

--
-- Constraints for table `car_feature`
--
ALTER TABLE `car_feature`
  ADD CONSTRAINT `car_feature_ibfk_1` FOREIGN KEY (`car_feature_category_id`) REFERENCES `car_feature_category` (`id`);

--
-- Constraints for table `car_model`
--
ALTER TABLE `car_model`
  ADD CONSTRAINT `car_model_ibfk_1` FOREIGN KEY (`car_manufacturer_id`) REFERENCES `car_mafucaturer` (`id`),
  ADD CONSTRAINT `car_model_ibfk_2` FOREIGN KEY (`car_body_style_id`) REFERENCES `car_body_style` (`id`);

--
-- Constraints for table `car_model_car_feature`
--
ALTER TABLE `car_model_car_feature`
  ADD CONSTRAINT `car_model_car_feature_ibfk_1` FOREIGN KEY (`car_feature_id`) REFERENCES `car_feature` (`id`),
  ADD CONSTRAINT `car_model_car_feature_ibfk_2` FOREIGN KEY (`car_model_id`) REFERENCES `car_model` (`id`);

--
-- Constraints for table `car_user`
--
ALTER TABLE `car_user`
  ADD CONSTRAINT `car_user_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `car_user_ibfk_2` FOREIGN KEY (`car_id`) REFERENCES `car` (`id`),
  ADD CONSTRAINT `car_user_ibfk_3` FOREIGN KEY (`deposit_status_id`) REFERENCES `deposit_status` (`id`),
  ADD CONSTRAINT `car_user_ibfk_4` FOREIGN KEY (`payment_status_id`) REFERENCES `payment_status` (`id`);

--
-- Constraints for table `user_token`
--
ALTER TABLE `user_token`
  ADD CONSTRAINT `user_token_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
