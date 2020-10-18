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

/*Data for the table `settings` */

insert  into `settings`(`id`,`name`,`value`,`description`,`created`,`updated`) values (1,'search_km_choices','1,2',NULL,NULL,NULL),(2,'search_review_choices','1,2,3,4',NULL,NULL,NULL),(3,'search_feedback_choices','1,2,3',NULL,NULL,NULL),(4,'site_title','Melbourne Tutors',NULL,NULL,NULL),(5,'short_date_format','Y-m-d',NULL,NULL,NULL),(6,'long_date_format','Y-m-d H:i:s',NULL,NULL,NULL),(7,'google_api_key','12',NULL,NULL,NULL),(8,'google_track_code','track code',NULL,NULL,NULL),(9,'mail_server','smtp.sendgrid.com',NULL,NULL,NULL),(10,'username','dinhthuong',NULL,NULL,NULL),(11,'password','123',NULL,NULL,NULL),(12,'ssl','1',NULL,NULL,NULL),(13,'no_reply_name','no reply name',NULL,NULL,NULL),(14,'no_reply_address','no reply address',NULL,NULL,NULL),(15,'reply_name','reply name',NULL,NULL,NULL),(16,'reply_address','reply address',NULL,NULL,NULL),(17,'port','85',NULL,NULL,NULL),(18,'count_latest_tutor','5',NULL,NULL,NULL),(19,'count_search_result','3',NULL,NULL,NULL),(20,'count_browse_tutor','2',NULL,NULL,NULL),(21,'video_enable','1',NULL,NULL,NULL),(22,'video_player_width','800',NULL,NULL,NULL),(23,'video_player_length','600',NULL,NULL,NULL),(24,'video_summary_minimum','1',NULL,NULL,NULL),(25,'video_summary_maximum','3',NULL,NULL,NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
