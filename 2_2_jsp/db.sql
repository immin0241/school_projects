SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+09:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

CREATE DATABASE IF NOT EXISTS `jspproj` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `jspproj`;

CREATE TABLE `merch` (
  `id` int NOT NULL,
  `store_id` int NOT NULL,
  `merch_name` text COLLATE utf8mb4_general_ci NOT NULL,
  `merch_price` int NOT NULL,
  `merch_picture` text COLLATE utf8mb4_general_ci,
  `visible` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

TRUNCATE TABLE `merch`;

CREATE TABLE `order` (
  `id` int NOT NULL,
  `store_id` int NOT NULL,
  `table_id` int NOT NULL,
  `created_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `open` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

TRUNCATE TABLE `order`;

CREATE TABLE `orderitem` (
  `id` int NOT NULL,
  `order_id` int NOT NULL,
  `order_item` int NOT NULL,
  `amount` int NOT NULL,
  `notes` text COLLATE utf8mb4_general_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

TRUNCATE TABLE `orderitem`;

CREATE TABLE `qrcode` (
  `id` int NOT NULL,
  `store_id` int NOT NULL,
  `table` varchar(10) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

TRUNCATE TABLE `qrcode`;

CREATE TABLE `user` (
  `id` int NOT NULL,
  `user_id` text COLLATE utf8mb4_general_ci NOT NULL,
  `user_password` text COLLATE utf8mb4_general_ci NOT NULL,
  `user_store_name` text COLLATE utf8mb4_general_ci NOT NULL,
  `user_store_desc` text COLLATE utf8mb4_general_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

TRUNCATE TABLE `user`;

ALTER TABLE `merch`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_merch_store` (`store_id`);

ALTER TABLE `order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_order_store` (`store_id`);

ALTER TABLE `orderitem`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_orderitem_order` (`order_id`),
  ADD KEY `fk_orderitem_merch` (`order_item`);

ALTER TABLE `qrcode`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_qrcode_store` (`store_id`);

ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `merch`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE `order`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE `orderitem`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE `qrcode`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;


ALTER TABLE `merch`
  ADD CONSTRAINT `fk_merch_store` FOREIGN KEY (`store_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

ALTER TABLE `order`
  ADD CONSTRAINT `fk_order_store` FOREIGN KEY (`store_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_qrcode_id` FOREIGN KEY (`QRCODE_ID`) REFERENCES `qrcode` (`id`) ON DELETE CASCADE;

ALTER TABLE `orderitem`
  ADD CONSTRAINT `fk_orderitem_merch` FOREIGN KEY (`order_item`) REFERENCES `merch` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_orderitem_order` FOREIGN KEY (`order_id`) REFERENCES `order` (`id`) ON DELETE CASCADE;

ALTER TABLE `qrcode`
  ADD CONSTRAINT `fk_qrcode_store` FOREIGN KEY (`store_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
