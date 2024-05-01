-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 01, 2024 at 06:14 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fooddb`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` varchar(100) NOT NULL DEFAULT uuid(),
  `name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `password`) VALUES
('7d9b0c9c-063f-11ef-8c37-98e74305e27c', 'bibek', '$2y$10$ttuv.3Xwep//SPclVPWq7uXRxzDgUTdktRHb9scRlMooy9ur48z.S');

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` varchar(100) NOT NULL DEFAULT uuid(),
  `userid` varchar(100) NOT NULL,
  `pid` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int(10) NOT NULL,
  `quantity` int(10) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`id`, `userid`, `pid`, `name`, `price`, `quantity`, `image`) VALUES
('6d6f88e6-075e-11ef-8a6a-98e74305e27c', 'a07d9cf2-05c1-11ef-9ec9-98e74305e27c', 'adf08299-0644-11ef-8c37-98e74305e27c', 'Olga Patterson', 893, 1, 'fooddfd0.jpg'),
('a1df576f-058c-11ef-8620-98e74305e27c', '0ab00048-058c-11ef-8620-98e74305e27c', '37a7ffa4-04a9-11ef-a18b-98e74305e27c', 'momo', 999, 1, 'cuisine-food-india-indian-wallpaper-preview.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` varchar(100) NOT NULL DEFAULT uuid(),
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
('d3ca9072-04a2-11ef-a18b-98e74305e27c', 'nepali'),
('d3caa4cc-04a2-11ef-a18b-98e74305e27c', 'indian'),
('d3caa566-04a2-11ef-a18b-98e74305e27c', 'chinese'),
('d3caa581-04a2-11ef-a18b-98e74305e27c', 'italian'),
('d3caa59e-04a2-11ef-a18b-98e74305e27c', 'mexican'),
('d3caa5b7-04a2-11ef-a18b-98e74305e27c', 'japanese'),
('d3caa5cb-04a2-11ef-a18b-98e74305e27c', 'french'),
('d3caa5df-04a2-11ef-a18b-98e74305e27c', 'thai'),
('d3caa639-04a2-11ef-a18b-98e74305e27c', 'mediterranean');

-- --------------------------------------------------------

--
-- Table structure for table `forgetrequest`
--

CREATE TABLE `forgetrequest` (
  `id` varchar(100) NOT NULL DEFAULT uuid(),
  `otp` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `userId` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `forgetrequest`
--

INSERT INTO `forgetrequest` (`id`, `otp`, `email`, `userId`) VALUES
('639fc2b2-056f-11ef-8620-98e74305e27c', 884219, 'hoqypuw@mailinator.com', '8e4739fc-055c-11ef-8620-98e74305e27c');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` varchar(100) NOT NULL DEFAULT uuid(),
  `userId` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `number` varchar(12) NOT NULL,
  `message` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` varchar(100) NOT NULL DEFAULT uuid(),
  `message` varchar(255) NOT NULL,
  `userId` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `message`, `userId`) VALUES
('3269a461-0770-11ef-8a6a-98e74305e27c', 'Your order (ID: afccd744764ebe7a6f117223077dbde4) has been ontheway.', 'a07d9cf2-05c1-11ef-9ec9-98e74305e27c'),
('399f5c51-0770-11ef-8a6a-98e74305e27c', 'Your order (ID: afccd744764ebe7a6f117223077dbde4) has been ontheway.', 'a07d9cf2-05c1-11ef-9ec9-98e74305e27c');

-- --------------------------------------------------------

--
-- Table structure for table `orderdetails`
--

CREATE TABLE `orderdetails` (
  `id` varchar(100) NOT NULL DEFAULT uuid(),
  `productId` varchar(100) DEFAULT NULL,
  `orderId` varchar(100) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orderdetails`
--

INSERT INTO `orderdetails` (`id`, `productId`, `orderId`, `quantity`, `price`) VALUES
('0add4ba9-06db-11ef-a255-98e74305e27c', '1cb1214e-06d8-11ef-a255-98e74305e27c', 'afccd744764ebe7a6f117223077dbde4', 1, 615);

-- --------------------------------------------------------

--
-- Table structure for table `orderss`
--

CREATE TABLE `orderss` (
  `id` varchar(100) NOT NULL DEFAULT uuid(),
  `orderStatus` enum('pending','confirm','ontheway','delivered','preparation','returned') DEFAULT 'pending',
  `amount` int(11) DEFAULT NULL,
  `userId` varchar(100) DEFAULT NULL,
  `paymentId` varchar(100) DEFAULT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `quantity` int(11) DEFAULT NULL,
  `shippingAddress` varchar(255) DEFAULT NULL,
  `phoneNumber` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orderss`
--

INSERT INTO `orderss` (`id`, `orderStatus`, `amount`, `userId`, `paymentId`, `createdAt`, `quantity`, `shippingAddress`, `phoneNumber`) VALUES
('afccd744764ebe7a6f117223077dbde4', 'ontheway', 615, 'a07d9cf2-05c1-11ef-9ec9-98e74305e27c', '9a9abf4e5773f7f1b51d0160eab64861', '2024-05-01 04:06:33', 1, 'cdcdscsdv', '80980796');

-- --------------------------------------------------------

--
-- Table structure for table `paymentdetails`
--

CREATE TABLE `paymentdetails` (
  `id` varchar(100) NOT NULL DEFAULT uuid(),
  `paymentMethod` enum('khalti','cod','esewa') DEFAULT 'cod',
  `paymentStatus` enum('paid','unpaid','refund') DEFAULT 'unpaid',
  `pidx` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `paymentdetails`
--

INSERT INTO `paymentdetails` (`id`, `paymentMethod`, `paymentStatus`, `pidx`) VALUES
('9a9abf4e5773f7f1b51d0160eab64861', 'cod', 'unpaid', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` varchar(100) NOT NULL DEFAULT uuid(),
  `name` varchar(100) NOT NULL,
  `price` int(10) NOT NULL,
  `image` varchar(100) NOT NULL,
  `description` varchar(500) DEFAULT NULL,
  `categoryID` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `image`, `description`, `categoryID`) VALUES
('1cb1214e-06d8-11ef-a255-98e74305e27c', 'Zahir Jenkins', 615, 'fooddfd1user.jpg', 'Est deleniti consect Est deleniti consectEst deleniti consectEst deleniti consectEst deleniti consectEst deleniti consectEst deleniti consectEst deleniti consectEst deleniti consect', 'd3caa59e-04a2-11ef-a18b-98e74305e27c'),
('adf08299-0644-11ef-8c37-98e74305e27c', 'Olga Patterson', 893, 'fooddfd0.jpg', 'In sit amet et cum In sit amet et cumIn sit amet et cumIn sit amet et cumIn sit amet et cumIn sit amet et cumIn sit amet et cumIn sit amet et cumIn sit amet et cumIn sit amet et cumIn sit amet et cumIn sit amet et cumIn sit amet et cumIn sit amet et cumIn sit amet et cumIn sit amet et cumIn sit amet et cumIn sit amet et cumIn sit amet et cumIn sit amet et cumIn sit amet et cum', 'd3caa5b7-04a2-11ef-a18b-98e74305e27c');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` varchar(100) NOT NULL DEFAULT uuid(),
  `name` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `number` varchar(10) NOT NULL,
  `password` varchar(255) NOT NULL,
  `address` varchar(500) NOT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `verified` tinyint(1) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `otp` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `number`, `password`, `address`, `gender`, `verified`, `dob`, `otp`) VALUES
('09922b85-055e-11ef-8620-98e74305e27c', 'pacicojiq@mailinator', 'rawi@mailinator.com', '', '$2y$10$Xaj8CKs3za6q4s0EpS8ezuZ87ePRiuFoVRUmdyBBvnS9ZZv8VEUdu', '', NULL, 1, NULL, 408212),
('0ab00048-058c-11ef-8620-98e74305e27c', 'xyqoxi@mailinator.co', 'guqibaki@mailinator.com', 'sdcsdcscsd', '$2y$10$wztp8vsr2cBJYO8skHFZv.P9mjQml8YFwT1U3AqaSHzifh7BgxAB.', 'csdcsdcdc', 'male', 1, '2024-04-12', 298044),
('8e4739fc-055c-11ef-8620-98e74305e27c', 'name', 'hoqypuw@mailinator.com', '', '$2y$10$.0or1MGCQF4WakjQr8smzONBDfIQ0QavjG7GKPxsO94peaLFnnA86', '', NULL, 1, NULL, 126629),
('a07d9cf2-05c1-11ef-9ec9-98e74305e27c', 'puteni@mailinator.co', 'calykocem@mailinator.com', '80980796', '$2y$10$Y3fyeZsksx/emxxXzMIYD.TFN15Dvwq8FWPR0SjC2N.O.HaiNyHL2', 'cdcdscsdv', 'male', 1, '2024-04-11', 799711);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_userid` (`userid`),
  ADD KEY `fk_pid` (`pid`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `forgetrequest`
--
ALTER TABLE `forgetrequest`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_users_id` (`userId`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fr_user_id` (`userId`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `frk_userId` (`userId`);

--
-- Indexes for table `orderdetails`
--
ALTER TABLE `orderdetails`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_order` (`orderId`),
  ADD KEY `fk_product` (`productId`);

--
-- Indexes for table `orderss`
--
ALTER TABLE `orderss`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user` (`userId`),
  ADD KEY `fr_paymentDetails_k` (`paymentId`);

--
-- Indexes for table `paymentdetails`
--
ALTER TABLE `paymentdetails`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_categories_id` (`categoryID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `fk_pid` FOREIGN KEY (`pid`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `fk_userid` FOREIGN KEY (`userid`) REFERENCES `users` (`id`);

--
-- Constraints for table `forgetrequest`
--
ALTER TABLE `forgetrequest`
  ADD CONSTRAINT `fk_users_id` FOREIGN KEY (`userId`) REFERENCES `users` (`id`);

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `fr_user_id` FOREIGN KEY (`userId`) REFERENCES `users` (`id`);

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `frk_userId` FOREIGN KEY (`userId`) REFERENCES `users` (`id`);

--
-- Constraints for table `orderdetails`
--
ALTER TABLE `orderdetails`
  ADD CONSTRAINT `fk_order` FOREIGN KEY (`orderId`) REFERENCES `orderss` (`id`),
  ADD CONSTRAINT `fk_product` FOREIGN KEY (`productId`) REFERENCES `products` (`id`);

--
-- Constraints for table `orderss`
--
ALTER TABLE `orderss`
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`userId`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fr_paymentDetails_k` FOREIGN KEY (`paymentId`) REFERENCES `paymentdetails` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_categories_id` FOREIGN KEY (`categoryID`) REFERENCES `categories` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
