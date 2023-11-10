-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 10, 2023 at 07:42 AM
-- Server version: 5.7.36
-- PHP Version: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `orgacare`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `admin_id` int(10) NOT NULL AUTO_INCREMENT,
  `admin_email` varchar(150) NOT NULL,
  `admin_password` varchar(255) NOT NULL,
  PRIMARY KEY (`admin_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `admin_email`, `admin_password`) VALUES
(1, 'admin@gmail.com', '$2y$10$IhtAH.LG/Bb0D8WSXVhHBeyQTb8QycSux17/JjyQ2vOs7pTTGoKf2');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

DROP TABLE IF EXISTS `cart`;
CREATE TABLE IF NOT EXISTS `cart` (
  `cart_id` int(10) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `quantity` int(10) NOT NULL,
  PRIMARY KEY (`cart_id`),
  KEY `fk_user` (`user_id`),
  KEY `fk_product_id` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cart_id`, `user_id`, `product_id`, `quantity`) VALUES
(42, 6, 21, 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `order_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(10) UNSIGNED NOT NULL,
  `order_date` date NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `payment_method` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Pending',
  PRIMARY KEY (`order_id`),
  KEY `fk_user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `order_date`, `total_amount`, `payment_method`, `status`) VALUES
(26, 2, '2023-11-06', '19.90', 'Paypal', 'Pending'),
(27, 6, '2023-11-06', '13.90', 'TouchNGo', 'Shipped'),
(28, 6, '2023-11-06', '16.90', 'Paypal', 'Pending'),
(29, 6, '2023-11-06', '24.90', 'Paypal', 'Pending'),
(30, 2, '2023-11-08', '12.60', 'Paypal', 'Shipped'),
(31, 2, '2023-11-08', '12.60', 'Paypal', 'Pending'),
(32, 3, '2023-11-08', '23.40', 'TouchNGo', 'Pending'),
(33, 2, '2023-11-10', '36.80', 'Paypal', 'Pending'),
(34, 2, '2023-11-10', '16.90', 'Paypal', 'Pending'),
(35, 3, '2023-11-10', '9.50', 'Boost', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
CREATE TABLE IF NOT EXISTS `order_items` (
  `order_item_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `order_id` int(11) UNSIGNED NOT NULL,
  `product_id` int(11) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  PRIMARY KEY (`order_item_id`),
  KEY `fk_order_id` (`order_id`),
  KEY `product_id_fk` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`order_item_id`, `order_id`, `product_id`, `quantity`) VALUES
(52, 26, 2, 1),
(53, 27, 25, 1),
(54, 28, 20, 1),
(55, 29, 21, 1),
(56, 30, 27, 1),
(57, 31, 27, 1),
(58, 32, 37, 1),
(59, 32, 22, 1),
(60, 33, 20, 1),
(61, 33, 2, 1),
(62, 34, 20, 1),
(63, 35, 37, 1);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

DROP TABLE IF EXISTS `product`;
CREATE TABLE IF NOT EXISTS `product` (
  `product_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `product_name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `category` varchar(50) NOT NULL,
  `image` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `stock` int(10) NOT NULL,
  `seller_id` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`product_id`),
  KEY `seller_id` (`seller_id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `product_name`, `price`, `category`, `image`, `description`, `stock`, `seller_id`) VALUES
(2, 'Organic Dried Cherries', '19.90', 'Fruit', 'organic-dried-cherries.jpg', '40g', 1, 1),
(20, 'Love Earth Baby Yogurt Melt Mango', '16.90', 'Baby', 'loveearthmango.png', '20g', 108, 2),
(21, 'Mushroom Powder', '24.90', 'Baby', 'mushroom-powder.png', '40g 100% Pure Mushroom', 45, 2),
(22, 'Baby Noodle', '13.90', 'Baby', 'baby-noodle.png', '200g (40g x 5servings)', 90, 2),
(24, 'Organic Black Soy Sauce', '28.90', 'Seasoning', 'sauce.jpg', '450g', 90, 1),
(25, 'Organic High Protein Flour', '13.90', 'Bake', 'flour.png', '1 kg', 70, 3),
(26, 'Organic Coconut Flour', '12.00', 'Bake', 'coconutflour.png', '500g', 80, 3),
(27, 'Antibiotic-Free Chicken', '12.60', 'Fresh-Meat', 'hen.jpg', 'Half Deskinned Hen 500g-700g', 500, 6),
(28, 'Antibiotic-Free (Manta Chicken)', '26.90', 'Fresh-Meat', 'manta.jpg', 'Half chicken 1kg', 400, 6),
(29, 'BioNova Dressing Yoghurt', '16.50', 'Seasoning', 'dressing-yoghurt.jpg', '300ml', 50, 1),
(30, 'Baby Rice', '12.50', 'Baby', 'baby-rice.png', '450g', 200, 2),
(31, 'Organic Beetroot Baby Noodle', '11.90', 'Baby', 'baby-noodle.jpg', '0.5 kg', 200, 7),
(32, 'Organic Mystery Box', '35.00', 'Vegetables', 'vegetable.jpg', '6-7 varieties', 29, 6),
(33, 'SN Dehydrated Mixed Nut', '4.90', 'Nut', 'dyhyadrated-nut.jpg', ' 30g', 400, 6),
(34, 'Fruits And Nuts (Bottle) ', '16.50', 'Nut', 'nuts.jpg', '200g ', 200, 6),
(35, 'Organic Tofu', '4.90', 'Dairy-Product', 'organictoufu.png', 'One piece', 200, 8),
(36, 'Organic Frozen Tofu (Pumpkin)', '7.00', 'Dairy-Product', 'pumpkintoufu.png', 'made by pumpkin', 200, 8),
(37, 'Cocomelon snack bar', '9.50', 'Snacks', 'snack.jpg', '1x30g', 200, 9),
(38, 'Organic Wheat Grain', '14.90', 'Grains', 'grain.jpg', '1 kg', 200, 10);

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

DROP TABLE IF EXISTS `review`;
CREATE TABLE IF NOT EXISTS `review` (
  `review_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `rating` int(10) NOT NULL,
  `comment` varchar(255) NOT NULL,
  `review_datetime` datetime NOT NULL,
  `order_item_id` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`review_id`),
  KEY `fk_order_item_id` (`order_item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `review`
--

INSERT INTO `review` (`review_id`, `rating`, `comment`, `review_datetime`, `order_item_id`) VALUES
(4, 5, 'Organic cherries offer a delicious and eco-conscious snacking experience.', '2023-11-06 08:42:58', 52),
(5, 5, 'Boosts protein, enhances baking, certified organic. A great choice for health-conscious bakers.', '2023-11-06 08:46:55', 53),
(6, 5, 'The chicken is very fresh and cheap! 5 star recommend', '2023-11-08 01:29:52', 57),
(7, 5, 'My baby loves this cocomelon snack bar, so delicious!!!!', '2023-11-08 01:32:17', 58),
(8, 5, 'Baby noodles are fantastic! Delicious and perfect for little ones. A must-try for your baby\'s meals.', '2023-11-08 01:37:58', 59),
(10, 5, 'My son very like it', '2023-11-10 15:18:25', 63);

-- --------------------------------------------------------

--
-- Table structure for table `seller`
--

DROP TABLE IF EXISTS `seller`;
CREATE TABLE IF NOT EXISTS `seller` (
  `seller_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `seller_name` varchar(150) NOT NULL,
  `seller_email` varchar(100) NOT NULL,
  `seller_password` varchar(255) NOT NULL,
  `seller_phone` varchar(150) NOT NULL,
  `seller_city` varchar(200) NOT NULL,
  `seller_state` varchar(200) NOT NULL,
  `seller_status` varchar(255) NOT NULL DEFAULT 'Pending',
  `organic_cert` varchar(255) NOT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`seller_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `seller`
--

INSERT INTO `seller` (`seller_id`, `seller_name`, `seller_email`, `seller_password`, `seller_phone`, `seller_city`, `seller_state`, `seller_status`, `organic_cert`, `reset_token`) VALUES
(1, 'Lohas', 'lohas@gmail.com', '$2y$10$IhtAH.LG/Bb0D8WSXVhHBeyQTb8QycSux17/JjyQ2vOs7pTTGoKf2', '01127442911', 'Bukit Mertajam', 'Penang', 'Approved', 'lohas.png', NULL),
(2, 'Myloveearth', 'myloveearth@gmail.com', '$2y$10$IhtAH.LG/Bb0D8WSXVhHBeyQTb8QycSux17/JjyQ2vOs7pTTGoKf2', '01127442911', 'Batu Caves', 'Selangor', 'Approved', 'myloveearth.png', NULL),
(3, 'Matahari', 'matahari@gmail.com', '$2y$10$IhtAH.LG/Bb0D8WSXVhHBeyQTb8QycSux17/JjyQ2vOs7pTTGoKf2', '03 3318 9980', 'Klang', 'Selangor', 'Approved', 'matahari.png', '585e36317897384b2e37c2074902ab39'),
(6, 'Zenxin Organic', 'zenxin@gmail.com', '$2y$10$IAVjp4UIYBjo8CgdQMZ0WORWEkXm8A1tzTlzyeRlvjT/iXU2uoQAS', '0127058199', 'Kluang', 'Johor', 'Approved', 'zenxin.jpg', NULL),
(7, 'Everprosper Food Sdn Bhs', 'Ever@gmail.com', '$2y$10$f8htCF3y8btMz91J6a4Vcu3l4kSytLuCKraSYEVs5cplXOX97kdQK', '0163055621', 'Sungai Petani', 'Kedah', 'Approved', 'organikmalaysia.jpeg', NULL),
(8, 'Organicfyou', 'organic@gmail.com', '$2y$10$/YSjAmTWo8gCq6bNonnP5.6rkIIFuxa.XHGdtmbFaFQMZgMWLxUEC', '0127338853', 'Kepong', 'Kelantan', 'Approved', 'organicfyou.png', '15d1368fb16bfdceddc9abea135a8a04'),
(9, 'Sprout Organic', 'Jowyn2002@gmail.com', '$2y$10$QHuduUmZge//BI/6GwUv7u1pO7CQzbN2ab0Rs4m7VUopndwFS1CPG', '01158743862', 'CyberJaya', 'Selangor', 'Approved', 'sprout.png', 'e8154fb372d3eda78823644c285669a7'),
(10, 'Radiant Whole Food', 'radiant@gmail.com', '$2y$10$MzVvpU5IFeElR3QhQVTFXe8EnW/OhNAsrTHf/MG9xx0..3BuzgG2i', '03 8066 6226', 'Puchong', 'Selangor', 'Approved', 'radiant.png', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `username`, `email`, `password`, `address`, `reset_token`) VALUES
(1, 'test', 'test@gmail.com', '$2y$10$BeLGplQaPpV3OTmD8VnjQu9rg.wMB58GxZxjf6iRq.qyxiwTsJmhW', '1541,jalan test, taman test', NULL),
(2, 'Jowyn', 'Jowyn2002@gmail.com', '$2y$10$BeLGplQaPpV3OTmD8VnjQu9rg.wMB58GxZxjf6iRq.qyxiwTsJmhW', '1541,jalan test taman test 14000 bukit mertajam penang', '5e0a6c1aadd3a85962ba9e2b5fb3e8bd'),
(3, 'Joey', 'joey123@gmail.com', '$2y$10$BeLGplQaPpV3OTmD8VnjQu9rg.wMB58GxZxjf6iRq.qyxiwTsJmhW', 'Joey road ', NULL),
(4, 'Wei Jie', 'WeiJie@gmail.com', '$2y$10$BeLGplQaPpV3OTmD8VnjQu9rg.wMB58GxZxjf6iRq.qyxiwTsJmhW', '1541,jalan test taman test 14000 bukit test', NULL),
(5, 'Khor', 'khor@gmail.com', '$2y$10$BeLGplQaPpV3OTmD8VnjQu9rg.wMB58GxZxjf6iRq.qyxiwTsJmhW', '1541,jalan test taman test 14000 bukit test', NULL),
(6, 'Tommy', 'Tommy@gmail.com', '$2y$10$BeLGplQaPpV3OTmD8VnjQu9rg.wMB58GxZxjf6iRq.qyxiwTsJmhW', '1, Taman Tembikai', NULL),
(7, 'Shenghai', 'sheng@gmail.com', '$2y$10$BeLGplQaPpV3OTmD8VnjQu9rg.wMB58GxZxjf6iRq.qyxiwTsJmhW', '1541,jalan test taman test 14000 bukit test', 'f0b9a798a5c9ed1b61896db5b625719e'),
(9, 'Beh', 'beh@gmail.com', '$2y$10$7oitDCu1WQIlcBr3JzVOruqWj.kl8t9MPdov5pDGmQsfonDzp3DjS', '1, Taman Harmoni, Jalan Harmoni, 14000 Bukit Mertajam, Penang', NULL);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `fk_product_id` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`),
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `fk_order_id` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`),
  ADD CONSTRAINT `product_id_fk` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`);

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `fk_seller_id` FOREIGN KEY (`seller_id`) REFERENCES `seller` (`seller_id`);

--
-- Constraints for table `review`
--
ALTER TABLE `review`
  ADD CONSTRAINT `fk_order_item_id` FOREIGN KEY (`order_item_id`) REFERENCES `order_items` (`order_item_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
