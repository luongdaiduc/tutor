/*
SQLyog Community v9.63 
MySQL - 5.5.16 : Database - tutor
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`tutor` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `tutor`;

/*Table structure for table `subscriptions` */

DROP TABLE IF EXISTS `subscriptions`;

CREATE TABLE `subscriptions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `type` tinyint(1) DEFAULT NULL,
  `currency` varchar(30) DEFAULT NULL,
  `amount` varchar(30) NOT NULL,
  `period` varchar(30) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;


ALTER TABLE accounts
ADD COLUMN is_enhance TINYINT(1) DEFAULT 0 AFTER is_feature;

ALTER TABLE accounts
ADD COLUMN enhance_expire BIGINT(20) AFTER is_enhance;

ALTER TABLE accounts
ADD COLUMN is_premium TINYINT(1) DEFAULT 0 AFTER enhance_expire;

ALTER TABLE accounts
ADD COLUMN premium_expire BIGINT(20) AFTER is_premium;

INSERT INTO `tutor`.`pages` (`id`, `title`, `slug`, `body`, `status`, `created`)VALUES('-7', 'Tutor Upgrade', 'tutor-upgrade', 'Tutor Upgrade', '1', NOW());
INSERT INTO `tutor`.`pages` (`id`, `title`, `slug`, `body`, `status`, `created`)VALUES('-8', 'Basic Account', 'basic-account', 'Basic Account', '1', NOW());
INSERT INTO `tutor`.`pages` (`id`, `title`, `slug`, `body`, `status`, `created`)VALUES('-9', 'Enhance Account', 'enhance-account', 'Enhance Account', '1', NOW());
INSERT INTO `tutor`.`pages` (`id`, `title`, `slug`, `body`, `status`, `created`)VALUES('-10', 'Premium Account', 'premium-account', 'Premium Account', '1', NOW());