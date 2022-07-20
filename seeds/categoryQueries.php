<?php
$categoryCreateTableQueries = [
  "CREATE TABLE IF NOT EXISTS `books` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `product_id` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `weight` decimal(6,2) UNSIGNED NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
",
  "CREATE TABLE IF NOT EXISTS `dvds` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `product_id` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `size` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
",
  "CREATE TABLE IF NOT EXISTS `furnitures` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `product_id` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `height` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `width` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `length` int(10) UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
",
  "CREATE TABLE IF NOT EXISTS `products` (
  `product_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `sku` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `price` decimal(10,2) UNSIGNED NOT NULL DEFAULT '0.00',
  `category_id` bigint(20) UNSIGNED NOT NULL DEFAULT '0',
  `description` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`product_id`),
  UNIQUE KEY `sku` (`sku`),
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
",
  "CREATE TABLE IF NOT EXISTS `categories` (
    `category_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
    PRIMARY KEY (`category_id`),
    UNIQUE KEY `category_name` (`name`)
    ) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
  ",
];

$categoryIndexQueries = [
  "ALTER TABLE `books`
  ADD CONSTRAINT `books_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);
  COMMIT;",
  "ALTER TABLE `dvds`
  ADD CONSTRAINT `dvds_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);
  COMMIT;",
  "ALTER TABLE `furnitures`
  ADD CONSTRAINT `furnitures_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);
  COMMIT;",
  "ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`);
  COMMIT;",
];

$categoryInsertQueries = [
  "START TRANSACTION;
INSERT INTO categories (name) VALUES ('books');
COMMIT;",
  "START TRANSACTION;
INSERT INTO categories (name) VALUES ('dvds');
COMMIT;",
  "START TRANSACTION;
INSERT INTO categories (name) VALUES ('furnitures');
COMMIT;"
];