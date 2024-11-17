-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 07, 2023 at 09:32 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbims`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_category`
--

CREATE TABLE `tbl_category` (
  `category_ID` int(11) NOT NULL,
  `category_name` varchar(100) NOT NULL,
  `category_desc` longtext NOT NULL,
  `category_isDelete` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_category`
--

INSERT INTO `tbl_category` (`category_ID`, `category_name`, `category_desc`, `category_isDelete`) VALUES
(6, 'CAN GOODS', '', 0),
(7, 'VIDEO CARD', '\r\n\r\n', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_expenses`
--

CREATE TABLE `tbl_expenses` (
  `expense_ID` int(11) NOT NULL,
  `expense_receiptNo` varchar(100) NOT NULL,
  `expense_supplier` varchar(100) NOT NULL,
  `expense_itemID` int(11) NOT NULL,
  `expense_qty` int(11) NOT NULL,
  `expense_qtyLeft` int(11) NOT NULL,
  `expense_price` int(11) NOT NULL,
  `expense_expirationDate` varchar(50) NOT NULL,
  `expense_isDelete` int(11) NOT NULL,
  `expense_date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_expenses`
--

INSERT INTO `tbl_expenses` (`expense_ID`, `expense_receiptNo`, `expense_supplier`, `expense_itemID`, `expense_qty`, `expense_qtyLeft`, `expense_price`, `expense_expirationDate`, `expense_isDelete`, `expense_date`) VALUES
(9, '2011', 'WALTERMART CARMONA', 3, 16, 1, 80, '2023-06-30', 0, '2023-06-07'),
(10, '2000', 'ZAFEERA', 4, 25, 25, 8000, '2023-06-25', 0, '2023-06-07'),
(11, '2000', 'ZAFEERA', 3, 4, 0, 90, '2023-06-08', 0, '2023-06-07'),
(12, '2100', 'KINNARI MART', 3, 50, 50, 99, '2023-07-08', 0, '2023-06-07');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_items`
--

CREATE TABLE `tbl_items` (
  `item_ID` int(11) NOT NULL,
  `item_name` varchar(100) NOT NULL,
  `item_categoryID` int(11) NOT NULL,
  `item_tags` longtext NOT NULL,
  `item_isDelete` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_items`
--

INSERT INTO `tbl_items` (`item_ID`, `item_name`, `item_categoryID`, `item_tags`, `item_isDelete`) VALUES
(3, 'PUREFOODS CORN BEEF', 6, '', 0),
(4, 'RTX 4070', 7, '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_orders`
--

CREATE TABLE `tbl_orders` (
  `order_ID` int(11) NOT NULL,
  `order_userID` int(11) NOT NULL,
  `order_itemID` int(11) NOT NULL,
  `order_qty` int(11) NOT NULL,
  `order_price` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_orders`
--

INSERT INTO `tbl_orders` (`order_ID`, `order_userID`, `order_itemID`, `order_qty`, `order_price`) VALUES
(22, 12, 3, 25, 99);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `users_ID` int(11) NOT NULL,
  `users_name` varchar(100) NOT NULL,
  `users_email` varchar(100) NOT NULL,
  `users_password` varchar(200) NOT NULL,
  `users_isAdmin` int(11) NOT NULL,
  `users_isDelete` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`users_ID`, `users_name`, `users_email`, `users_password`, `users_isAdmin`, `users_isDelete`) VALUES
(12, 'EPHRAIM ARCEO', 'admin@email.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 1, 0),
(13, 'NORBERT GARTE', 'norbert@email.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 1, 0),
(14, 'YUKI USHIRO', 'yuki@email.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_category`
--
ALTER TABLE `tbl_category`
  ADD PRIMARY KEY (`category_ID`);

--
-- Indexes for table `tbl_expenses`
--
ALTER TABLE `tbl_expenses`
  ADD PRIMARY KEY (`expense_ID`);

--
-- Indexes for table `tbl_items`
--
ALTER TABLE `tbl_items`
  ADD PRIMARY KEY (`item_ID`);

--
-- Indexes for table `tbl_orders`
--
ALTER TABLE `tbl_orders`
  ADD PRIMARY KEY (`order_ID`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`users_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_category`
--
ALTER TABLE `tbl_category`
  MODIFY `category_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_expenses`
--
ALTER TABLE `tbl_expenses`
  MODIFY `expense_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tbl_items`
--
ALTER TABLE `tbl_items`
  MODIFY `item_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_orders`
--
ALTER TABLE `tbl_orders`
  MODIFY `order_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `users_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
