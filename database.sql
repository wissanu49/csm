-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 14, 2018 at 02:02 PM
-- Server version: 10.1.25-MariaDB
-- PHP Version: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `warehouse`
--

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` int(11) NOT NULL,
  `amount` int(11) DEFAULT NULL COMMENT 'จำนวน',
  `products_id` int(11) NOT NULL,
  `users_id` int(11) NOT NULL,
  `session` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `fullname` varchar(255) NOT NULL COMMENT 'ชื่อ-นามสกุล',
  `address` text NOT NULL COMMENT 'ที่อยู่',
  `phone` varchar(45) DEFAULT '-' COMMENT 'เบอร์ติดต่อ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `fullname`, `address`, `phone`) VALUES
(1, 'สมพงษ์  ดวงดี', '111 ต.ในเมือง อ.เมือง จ.นครราชสีมา', ''),
(2, 'อรชร หนองหอยหลอด', '2222', ''),
(3, 'ลำใย ไหทองคำ', 'ขอนแก่น', '0954442255'),
(4, 'ก้อง ห้วยไร่', 'ฟหกดฟกดฟหกดฟกดฟ', ''),
(5, 'บอย พนมไพร', 'สารคาม', '1234567890');

-- --------------------------------------------------------

--
-- Table structure for table `deposits`
--

CREATE TABLE `deposits` (
  `id` varchar(25) NOT NULL,
  `customers_id` int(11) NOT NULL COMMENT 'รหัสลูกค้า',
  `deposit_date` date NOT NULL COMMENT 'วันที่ฝาก',
  `users_id` int(11) NOT NULL COMMENT 'ผู้บันทึก',
  `comment` varchar(255) DEFAULT '-' COMMENT 'หมายเหตุ',
  `status` enum('remain','closed','void') NOT NULL DEFAULT 'remain' COMMENT 'สถานะ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `deposits`
--

INSERT INTO `deposits` (`id`, `customers_id`, `deposit_date`, `users_id`, `comment`, `status`) VALUES
('DEP1801001', 3, '2017-11-21', 2, '', 'closed'),
('DEP1801002', 1, '2018-01-21', 1, '123456', 'closed'),
('DEP1801003', 2, '2018-01-21', 1, '', 'closed'),
('DEP1801004', 3, '2018-01-23', 1, '', 'closed'),
('DEP1801005', 1, '2018-01-29', 1, 'xcvcvxvcxcvxcvxc', 'closed'),
('DEP1801006', 1, '2018-01-29', 1, '123123123', 'closed'),
('DEP1802001', 4, '2018-02-03', 1, '', 'void'),
('DEP1802002', 4, '2018-02-04', 1, 'ฝาก', 'closed'),
('DEP1802003', 2, '2018-02-05', 1, '', 'closed'),
('DEP1802004', 1, '2018-02-05', 1, '', 'closed'),
('DEP1802005', 3, '2018-02-07', 1, 'xzcxzxczxc', 'closed'),
('DEP1802006', 3, '2018-02-08', 1, '', 'remain'),
('DEP1802007', 1, '2018-02-08', 1, '', 'remain'),
('DEP1802008', 5, '2018-02-08', 2, '', 'remain'),
('DEP1802009', 4, '2018-02-13', 2, '', 'remain');

-- --------------------------------------------------------

--
-- Table structure for table `info`
--

CREATE TABLE `info` (
  `company_name` varchar(255) DEFAULT NULL,
  `address` text,
  `phone` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `info`
--

INSERT INTO `info` (`company_name`, `address`, `phone`, `logo`, `id`) VALUES
('บริษัท หลานย่าโมรุ่งเรือง จำกัด', 'ตลาดสุระนคร ต.ในเมือง อ.เมือง จ.นครราชสีมา', '044-222555', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL COMMENT 'ชื่อสินค้า',
  `price` int(11) NOT NULL DEFAULT '0' COMMENT 'ราคา',
  `units_id` int(11) NOT NULL COMMENT 'หน่วยนับ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `units_id`) VALUES
(1, 'ผักกะหล่ำ', 15, 1),
(2, 'ผักคะน้า', 15, 1),
(3, 'แอปเปิ้ล', 20, 2),
(4, 'ส้ม', 15, 2),
(5, 'หอมหัวใหญ่', 25, 1),
(6, 'มะละกอ', 15, 4),
(7, 'มะพร้าว', 20, 4),
(8, 'มะระ', 15, 4),
(9, 'ผักบุ้ง', 15, 4),
(10, 'มะเขือ', 14, 4),
(11, 'มะเขือเทศ ราชินี', 15, 4);

-- --------------------------------------------------------

--
-- Table structure for table `sub_deposits`
--

CREATE TABLE `sub_deposits` (
  `id` int(11) NOT NULL,
  `products_id` int(11) NOT NULL COMMENT 'รหัสสินค้า',
  `amount` int(11) NOT NULL DEFAULT '0' COMMENT 'จำนวน',
  `deposits_id` varchar(25) NOT NULL COMMENT 'รหัสใบฝาก',
  `balance` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sub_deposits`
--

INSERT INTO `sub_deposits` (`id`, `products_id`, `amount`, `deposits_id`, `balance`) VALUES
(1, 2, 5, 'DEP1801001', 0),
(2, 1, 2, 'DEP1801001', 0),
(3, 1, 3, 'DEP1801002', 0),
(4, 2, 10, 'DEP1801002', 0),
(5, 3, 5, 'DEP1801003', 0),
(6, 4, 3, 'DEP1801004', 0),
(7, 4, 5, 'DEP1801005', 0),
(8, 3, 10, 'DEP1801006', 0),
(9, 4, 10, 'DEP1801006', 0),
(10, 1, 10, 'DEP1802001', 10),
(11, 2, 10, 'DEP1802001', 10),
(12, 5, 5, 'DEP1802002', 0),
(13, 2, 10, 'DEP1802002', 0),
(14, 1, 6, 'DEP1802002', 0),
(15, 4, 3, 'DEP1802002', 0),
(16, 2, 6, 'DEP1802003', 0),
(17, 1, 10, 'DEP1802003', 0),
(18, 5, 6, 'DEP1802004', 0),
(19, 3, 10, 'DEP1802004', 0),
(20, 4, 6, 'DEP1802004', 0),
(21, 5, 3, 'DEP1802005', 0),
(22, 2, 5, 'DEP1802005', 0),
(23, 4, 5, 'DEP1802005', 5),
(24, 3, 10, 'DEP1802006', 5),
(25, 10, 10, 'DEP1802007', 0),
(26, 11, 10, 'DEP1802007', 0),
(27, 6, 5, 'DEP1802007', 0),
(28, 8, 5, 'DEP1802007', 5),
(29, 9, 2, 'DEP1802008', 2),
(30, 6, 6, 'DEP1802008', 0),
(31, 4, 5, 'DEP1802009', 5),
(32, 3, 6, 'DEP1802009', 6),
(33, 6, 2, 'DEP1802009', 2);

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE `units` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL COMMENT 'หน่วยนับ'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `units`
--

INSERT INTO `units` (`id`, `name`) VALUES
(1, 'เข่ง'),
(2, 'ลัง'),
(3, 'กล่อง'),
(4, 'ถุง');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL COMMENT 'ชื่อผู้ใช้',
  `password` varchar(255) NOT NULL COMMENT 'รหัสผ่าน',
  `fullname` varchar(255) NOT NULL COMMENT 'ชื่อ-นามสกุล',
  `status` enum('Active','Suspend') NOT NULL DEFAULT 'Active' COMMENT 'สถานะ',
  `role` enum('User','Admin') NOT NULL DEFAULT 'User' COMMENT 'สิทธิ์การใช้งาน',
  `authKey` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `fullname`, `status`, `role`, `authKey`) VALUES
(1, 'admin', '$2y$13$WnC2yq5dbbBAcyUnmGIA9O4FYNBg8MjI7dwhR3Kg990kNc/oULpGG', 'วิษณุ กาศไธสง', 'Active', 'Admin', 'ZTLT1BzxTuEONVkfz7VahkV1IsjHuHoK'),
(2, 'user', '$2y$13$K99.d9CQXbN6dhuLTcmLNuldjYIzdgLakwLeOjQ4KeMDhzy1tR59W', 'user ', 'Active', 'User', 'I9Gs5nqiV79TtEeNtW-fl_ru0XIm7V0B');

-- --------------------------------------------------------

--
-- Table structure for table `void`
--

CREATE TABLE `void` (
  `id` int(11) NOT NULL,
  `type` enum('dep','rec') NOT NULL,
  `void_id` varchar(15) NOT NULL,
  `status` enum('request','approve','reject') NOT NULL DEFAULT 'request',
  `date_request` datetime NOT NULL,
  `date_action` datetime NOT NULL,
  `comment` text,
  `users_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `void`
--

INSERT INTO `void` (`id`, `type`, `void_id`, `status`, `date_request`, `date_action`, `comment`, `users_id`) VALUES
(1, 'dep', 'DEP1802001', 'approve', '2018-02-04 23:48:40', '2018-02-04 23:48:50', 'dfgsfsfgs\r\ndfgdfgdfgdfg', 1),
(2, 'dep', 'DEP1802004', 'reject', '2018-02-05 21:38:57', '2018-02-05 21:47:52', 'sdsdsdsdsdsd', 1),
(3, 'rec', 'REC1802009', 'approve', '2018-02-05 21:48:42', '2018-02-06 21:06:23', 'jfgjgfgj', 1),
(4, 'rec', 'REC1802005', 'approve', '2018-02-06 21:25:10', '2018-02-06 21:25:19', 'aaa', 1),
(5, 'rec', 'REC1802010', 'reject', '2018-02-06 22:18:11', '2018-02-06 22:31:21', 'sdfdsf', 1),
(6, 'rec', 'REC1802014', 'approve', '2018-02-09 20:19:20', '2018-02-09 20:19:47', '', 2);

-- --------------------------------------------------------

--
-- Table structure for table `withdraw`
--

CREATE TABLE `withdraw` (
  `id` varchar(25) NOT NULL,
  `date_withdraw` date NOT NULL COMMENT 'วันที่เบิก',
  `deposits_id` varchar(25) NOT NULL COMMENT 'รหัสใบฝาก',
  `users_id` int(11) NOT NULL COMMENT 'ผู้บันทึก',
  `products_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `withdraw_id` varchar(255) NOT NULL,
  `void` enum('true','false') NOT NULL DEFAULT 'false' COMMENT 'ยกเลิก'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `withdraw`
--

INSERT INTO `withdraw` (`id`, `date_withdraw`, `deposits_id`, `users_id`, `products_id`, `amount`, `price`, `withdraw_id`, `void`) VALUES
('1', '2018-01-28', 'DEP1801002', 1, 2, 6, 90, 'REC1801001', 'false'),
('10', '2018-01-29', 'DEP1801005', 1, 4, 3, 45, 'REC1801008', 'false'),
('11', '2018-02-01', 'DEP1801005', 1, 4, 2, 30, 'REC1802001', 'false'),
('12', '2018-02-01', 'DEP1801006', 1, 3, 5, 100, 'REC1802002', 'false'),
('13', '2018-02-01', 'DEP1801006', 1, 4, 10, 150, 'REC1802003', 'false'),
('14', '2018-02-01', 'DEP1801006', 1, 3, 3, 60, 'REC1802004', 'false'),
('15', '2018-02-03', 'DEP1801006', 1, 3, 2, 40, 'REC1802005', 'true'),
('16', '2018-02-05', 'DEP1802002', 1, 4, 3, 45, 'REC1802006', 'false'),
('17', '2018-02-05', 'DEP1802002', 1, 1, 6, 90, 'REC1802006', 'false'),
('18', '2018-02-05', 'DEP1802002', 1, 2, 5, 75, 'REC1802007', 'false'),
('19', '2018-02-05', 'DEP1802003', 1, 1, 10, 150, 'REC1802008', 'false'),
('2', '2018-01-28', 'DEP1801002', 1, 1, 3, 45, 'REC1801002', 'false'),
('20', '2018-02-05', 'DEP1802003', 1, 2, 6, 90, 'REC1802008', 'false'),
('21', '2018-02-05', 'DEP1802002', 1, 5, 3, 75, 'REC1802009', 'true'),
('22', '2018-02-05', 'DEP1802002', 1, 2, 3, 45, 'REC1802009', 'true'),
('23', '2018-02-06', 'DEP1801006', 1, 3, 2, 40, 'REC1802010', 'false'),
('24', '2018-02-07', 'DEP1802002', 1, 2, 5, 75, 'REC1802011', 'false'),
('25', '2018-02-07', 'DEP1802002', 1, 5, 5, 125, 'REC1802011', 'false'),
('26', '2018-02-07', 'DEP1802004', 1, 3, 5, 100, 'REC1802012', 'false'),
('27', '2018-02-07', 'DEP1802004', 1, 4, 6, 90, 'REC1802012', 'false'),
('28', '2018-02-08', 'DEP1802005', 1, 2, 5, 75, 'REC1802013', 'false'),
('29', '2018-02-08', 'DEP1802005', 1, 5, 3, 75, 'REC1802013', 'false'),
('3', '2018-01-28', 'DEP1801002', 1, 2, 4, 60, 'REC1801002', 'false'),
('30', '2018-02-09', 'DEP1802008', 2, 9, 2, 30, 'REC1802014', 'true'),
('31', '2018-02-09', 'DEP1802008', 2, 6, 6, 90, 'REC1802015', 'false'),
('32', '2018-02-09', 'DEP1802007', 2, 11, 10, 150, 'REC1802016', 'false'),
('33', '2018-02-09', 'DEP1802007', 2, 10, 10, 140, 'REC1802016', 'false'),
('34', '2018-02-09', 'DEP1802007', 2, 6, 5, 75, 'REC1802017', 'false'),
('35', '2018-02-09', 'DEP1802004', 2, 5, 6, 150, 'REC1802018', 'false'),
('36', '2018-02-09', 'DEP1802004', 2, 3, 5, 100, 'REC1802019', 'false'),
('37', '2018-02-13', 'DEP1802006', 2, 3, 5, 100, 'REC1802020', 'false'),
('4', '2018-01-28', 'DEP1801001', 1, 2, 5, 225, 'REC1801003', 'false'),
('5', '2018-01-28', 'DEP1801001', 1, 1, 2, 90, 'REC1801003', 'false'),
('6', '2018-01-28', 'DEP1801003', 1, 3, 3, 60, 'REC1801004', 'false'),
('7', '2018-01-28', 'DEP1801003', 1, 3, 2, 40, 'REC1801005', 'false'),
('8', '2018-01-28', 'DEP1801004', 1, 4, 1, 15, 'REC1801006', 'false'),
('9', '2018-01-29', 'DEP1801004', 1, 4, 2, 30, 'REC1801007', 'false');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_carts_products1_idx` (`products_id`),
  ADD KEY `fk_carts_users1_idx` (`users_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deposits`
--
ALTER TABLE `deposits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_tickets_customers1_idx` (`customers_id`),
  ADD KEY `fk_tickets_users1_idx` (`users_id`);

--
-- Indexes for table `info`
--
ALTER TABLE `info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_products_units1_idx` (`units_id`);

--
-- Indexes for table `sub_deposits`
--
ALTER TABLE `sub_deposits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_sub_tickets_products1_idx` (`products_id`),
  ADD KEY `fk_sub_deposits_deposits1_idx` (`deposits_id`);

--
-- Indexes for table `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `void`
--
ALTER TABLE `void`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_void_users1_idx` (`users_id`) USING BTREE;

--
-- Indexes for table `withdraw`
--
ALTER TABLE `withdraw`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_withdraw_deposits1_idx` (`deposits_id`),
  ADD KEY `fk_withdraw_users1_idx` (`users_id`),
  ADD KEY `fk_withdraw_products1_idx` (`products_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `info`
--
ALTER TABLE `info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `void`
--
ALTER TABLE `void`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `fk_carts_products1` FOREIGN KEY (`products_id`) REFERENCES `products` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_carts_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `deposits`
--
ALTER TABLE `deposits`
  ADD CONSTRAINT `fk_tickets_customers1` FOREIGN KEY (`customers_id`) REFERENCES `customers` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_tickets_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_products_units1` FOREIGN KEY (`units_id`) REFERENCES `units` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `sub_deposits`
--
ALTER TABLE `sub_deposits`
  ADD CONSTRAINT `fk_sub_deposits_deposits1` FOREIGN KEY (`deposits_id`) REFERENCES `deposits` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_sub_tickets_products1` FOREIGN KEY (`products_id`) REFERENCES `products` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `withdraw`
--
ALTER TABLE `withdraw`
  ADD CONSTRAINT `fk_withdraw_deposits1` FOREIGN KEY (`deposits_id`) REFERENCES `deposits` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_withdraw_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
