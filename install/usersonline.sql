-- Adminer 4.6.3 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';

DROP TABLE IF EXISTS `usersonline`;
CREATE TABLE `usersonline` (
  `timestamp` int(15) NOT NULL DEFAULT '0',
  `id` int(15) NOT NULL AUTO_INCREMENT,
  `ip` varchar(254) NOT NULL DEFAULT '',
  `file` varchar(254) NOT NULL DEFAULT '',
  `HTTP_HOST` varchar(254) NOT NULL,
  `sess_id` varchar(254) NOT NULL,
  `HTTP_REFERER` varchar(254) NOT NULL,
  `REQUEST_METHOD` varchar(254) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `timestamp` (`timestamp`),
  KEY `ip` (`ip`),
  KEY `file` (`file`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- 2021-03-26 20:18:10
