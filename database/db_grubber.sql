-- Adminer 4.8.1 MySQL 5.5.5-10.6.12-MariaDB-cll-lve dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `tbl_products`;
CREATE TABLE `tbl_products` (
  `prod_reference` char(14) NOT NULL,
  `prod_name` char(50) NOT NULL,
  `prod_properties` tinytext NOT NULL,
  `prod_group` char(2) NOT NULL DEFAULT '00',
  `prod_created` datetime NOT NULL,
  UNIQUE KEY `prod_reference` (`prod_reference`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='00: Rubber, 01: Plam';


DROP TABLE IF EXISTS `tbl_profiles`;
CREATE TABLE `tbl_profiles` (
  `profile_reference` char(14) NOT NULL,
  `profile_namefirst` varchar(250) NOT NULL,
  `profile_namelast` varchar(250) NOT NULL,
  UNIQUE KEY `profile_reference` (`profile_reference`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


DROP TABLE IF EXISTS `tbl_purchases`;
CREATE TABLE `tbl_purchases` (
  `po_reference` char(14) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `po_creator` char(14) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '999',
  `po_customer` char(14) NOT NULL,
  `po_created` datetime NOT NULL,
  UNIQUE KEY `po_reference` (`po_reference`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;


DROP TABLE IF EXISTS `tbl_sellers`;
CREATE TABLE `tbl_sellers` (
  `seller_reference` char(14) NOT NULL,
  `seller_name` varchar(250) NOT NULL,
  `seller_phone` char(10) NOT NULL,
  `seller_created` datetime NOT NULL,
  UNIQUE KEY `cust_reference` (`seller_reference`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


DROP TABLE IF EXISTS `tbl_signin`;
CREATE TABLE `tbl_signin` (
  `signin_datetime` datetime NOT NULL,
  `signin_app` char(14) NOT NULL DEFAULT '',
  `signin_userref` varchar(100) NOT NULL DEFAULT '',
  `signin_token` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


DROP TABLE IF EXISTS `tbl_users`;
CREATE TABLE `tbl_users` (
  `user_application` char(14) NOT NULL,
  `user_reference` char(14) NOT NULL,
  `user_username` char(28) NOT NULL,
  `user_password` varchar(140) NOT NULL,
  `user_division` char(4) NOT NULL DEFAULT '9999',
  `user_userlevel` tinyint(4) NOT NULL DEFAULT 99,
  `user_created` datetime NOT NULL,
  UNIQUE KEY `user_reference` (`user_reference`),
  UNIQUE KEY `user_username` (`user_username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


DROP TABLE IF EXISTS `tbl_weighing`;
CREATE TABLE `tbl_weighing` (
  `wg_reference` char(14) NOT NULL,
  `wg_seller` char(14) NOT NULL,
  `wg_product` char(14) NOT NULL,
  `wg_value` float NOT NULL,
  `wg_created` datetime NOT NULL,
  `wg_operator` char(14) NOT NULL,
  `wg_imgref` char(50) NOT NULL,
  `wg_water` float NOT NULL DEFAULT 97,
  `wg_price` float NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- 2023-06-07 21:33:39
