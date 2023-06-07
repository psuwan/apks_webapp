-- Adminer 4.8.1 MySQL 5.5.5-10.6.12-MariaDB-cll-lve dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `tbl_signin`;
CREATE TABLE `tbl_signin` (
  `signin_datetime` datetime NOT NULL,
  `signin_app` char(14) NOT NULL DEFAULT '',
  `signin_userref` varchar(100) NOT NULL DEFAULT '',
  `signin_token` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


DROP TABLE IF EXISTS `tbl_members`;
CREATE TABLE `tbl_members` (
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


-- 2023-06-07 12:57:06
