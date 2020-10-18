DROP TABLE IF EXISTS `accounts`;

CREATE TABLE `accounts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `rating` decimal(10,1) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '0',
  `is_feature` tinyint(1) DEFAULT '0',
  `is_enhance` tinyint(1) DEFAULT '0',
  `enhance_start` bigint(20) DEFAULT NULL,
  `enhance_expire` bigint(20) DEFAULT NULL,
  `is_premium` tinyint(1) DEFAULT '0',
  `premium_start` bigint(20) DEFAULT NULL,
  `premium_expire` bigint(20) DEFAULT NULL,
  `role` tinyint(4) NOT NULL,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `advertises`;

CREATE TABLE `advertises` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ref_account_id` int(11) NOT NULL,
  `domain` varchar(255) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `summary` text NOT NULL,
  `detail` text NOT NULL,
  `audiences` varchar(255) NOT NULL,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `blocks`;

CREATE TABLE `blocks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `status` tinyint(1) DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `deliveries`;

CREATE TABLE `deliveries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

LOCK TABLES `deliveries` WRITE;

insert  into `deliveries`(`id`,`name`,`created`) values (1,'Student home',NULL),(2,'Teacher home',NULL),(3,'Class',NULL),(4,'Phone',NULL),(5,'Online',NULL);

UNLOCK TABLES;

DROP TABLE IF EXISTS `errors`;

CREATE TABLE `errors` (
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  `level` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `source` varchar(255) DEFAULT NULL,
  `content` text,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=451 DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `faqs`;

CREATE TABLE `faqs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `category` int(11) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '0',
  `created` date DEFAULT NULL,
  `updated` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

LOCK TABLES `faqs` WRITE;

insert  into `faqs`(`id`,`title`,`content`,`category`,`order`,`status`,`created`,`updated`) values (1,'I can\'t log in','i can\'t log in, please help',0,5,1,'2013-04-17','2013-04-18'),(2,'How can i contact a tutor?','How can i contact a tutor?',1,4,1,'2013-04-17','2013-04-18'),(3,'What is silver package?','I\'m not sure about silver package.',2,34,1,'2013-04-17','2013-04-18'),(5,'What is golden package?','what benefit will i have if i upgrade my account to golden package?',2,40,1,'2013-04-17','2013-04-18'),(6,'what is this?','this is what',0,6,1,'2013-04-18','2013-04-18'),(7,'what is normal package?','what is normal package?',2,33,0,'2013-04-18','2013-04-18'),(14,'how can i upgrade my account without paying money?','how can i upgrade my account without paying money?',2,41,1,'2013-04-18','2013-04-18');

UNLOCK TABLES;

DROP TABLE IF EXISTS `galleries`;

CREATE TABLE `galleries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ref_account_id` int(11) DEFAULT NULL,
  `photo` varchar(255) NOT NULL,
  `description` text,
  `is_favourite` tinyint(1) DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `hash`;

CREATE TABLE `hash` (
  `hash` char(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `expire` bigint(20) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`hash`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS `i18n_source_messages`;

CREATE TABLE `i18n_source_messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(32) DEFAULT NULL,
  `message` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=289 DEFAULT CHARSET=latin1;

LOCK TABLES `i18n_source_messages` WRITE;

insert  into `i18n_source_messages`(`id`,`category`,`message`) values (1,'header','My Shortlist'),(3,'header','FAQs'),(4,'header','Contact'),(5,'header','Login'),(6,'header','Register'),(7,'header','My Account'),(8,'header','Logout'),(9,'home','Search Tutors'),(10,'home','Choose Subject'),(11,'home','Postcode'),(12,'home','Postcode Only'),(13,'home','Search'),(14,'home','Advanced Search'),(15,'home','FOR STUDENTS'),(16,'home','Browse Tutors'),(17,'home','Search Tutors'),(18,'home','Map of Tutors'),(19,'home','Rate your tutor'),(20,'home','FOR TUTORS'),(21,'home','Advertise'),(22,'home','Subjects Available'),(23,'home','Feature Suggestion'),(24,'home','Online Safety'),(25,'home','Featured Tutor'),(26,'home','View details'),(27,'home','Name'),(28,'home','Location'),(29,'home','Rate'),(30,'home','Subjects'),(31,'home','View more'),(32,'home','Latest Tutors'),(65,'footer','About'),(66,'footer','Sitemap'),(67,'footer','Privacy'),(68,'footer','Terms & Conditions'),(69,'content','Home'),(70,'content','Shortlist'),(71,'content','No result found'),(72,'content','Tutor'),(73,'content','From'),(74,'content','FAQs'),(75,'content','Contact'),(76,'content','Name'),(77,'content','Email'),(78,'content','Message'),(79,'content','Submit'),(80,'content','Search'),(81,'content','Subjects Available'),(82,'content','Feature Suggestion'),(83,'content','Fields with * are required'),(84,'register','Home'),(85,'register','Register'),(86,'register','Step 1'),(87,'register','Step 2'),(88,'register','Step 3'),(89,'register','Step 4'),(90,'register','Login Details'),(91,'register','Contact Information'),(92,'register','Background'),(93,'register','Subject Expertise'),(94,'register','First Name'),(95,'register','Last Name'),(96,'register','Email'),(97,'register','Password'),(98,'register','Confirm Password'),(99,'register','Next'),(100,'register','Salutation'),(101,'register','Gender'),(102,'register','Company'),(103,'register','Address'),(104,'register','Street'),(105,'register','Suburb'),(106,'register','State'),(107,'register','Postcode'),(108,'register','Phone'),(109,'register','Website'),(110,'register','Default Hourly Rate'),(111,'register','Previous'),(112,'register','Url'),(113,'register','Title'),(114,'register','Summary'),(115,'register','Detail'),(116,'register','Audience'),(117,'register','Delivery'),(118,'register','The activating account link had been sent to your mail. You must activate your account before using'),(119,'register','Subject'),(120,'register','Experience'),(121,'register','Level'),(122,'register','Status'),(123,'register','Add Subject'),(124,'register','Hourly Rate'),(125,'register','Submit'),(126,'register','Subjects'),(128,'search','Advanced Search'),(129,'search','Subject'),(130,'search','Choose Subject'),(131,'search','Location'),(132,'search','Postcode'),(133,'search','Postcode Only'),(134,'search','Level'),(135,'search','Any'),(136,'search','Delivery'),(137,'search','Gender'),(138,'search','Experience'),(139,'search','Hourly Rate'),(140,'search','Years'),(141,'search','Feedback'),(142,'search','Review'),(143,'search','Stars'),(144,'search','Reset'),(145,'search','Submit'),(146,'search','Featured Tutor'),(147,'search','Search Results'),(148,'search','View details'),(149,'search','YEAR EXPERIENCE'),(150,'search','Search'),(151,'search','Tutor'),(152,'search','From'),(153,'search','Tutors'),(154,'search','Map'),(155,'search','No result found'),(180,'profile','Tutors'),(181,'profile','Profile'),(182,'profile','tutor in'),(183,'profile','Gallery'),(184,'profile','Reviews'),(185,'profile','Contact'),(186,'profile','Gender'),(187,'profile','Location'),(188,'profile','Audience'),(189,'profile','Website'),(190,'profile','Description'),(191,'profile','Subjects'),(192,'profile','Name'),(193,'profile','Levels'),(194,'profile','Experience'),(195,'profile','Rate'),(196,'profile','Add a Review'),(197,'profile','Signin to add a review'),(198,'profile','Fields with * are required'),(200,'profile','Email'),(201,'profile','Message'),(202,'profile','Phone'),(203,'profile','Submit'),(204,'account','My Account'),(205,'account','MY DETAILS'),(206,'account','Login Details'),(207,'account','Contact Details'),(208,'account','Advertisement'),(209,'account','Subjects'),(210,'account','Gallery'),(211,'account','Videos'),(212,'account','Reviews'),(213,'account','Hide My Advert'),(214,'account','Billing'),(215,'account','Summary'),(216,'account','Upgrade'),(217,'account','Invoices'),(218,'account','Close Account'),(220,'account','Subject'),(221,'account','Experience'),(223,'account','Status'),(224,'account','With Selected'),(225,'account','Delete'),(226,'account','Enable'),(227,'account','Disable'),(228,'account','Add Subject'),(230,'account','Level'),(231,'account','Years Experience'),(232,'account','Hourly Rate'),(233,'account','Image'),(234,'account','Description'),(235,'account','Favourite'),(236,'account','Make Favourite'),(238,'account','Add Image'),(239,'account','Video'),(240,'account','Add Video'),(241,'account','URL'),(242,'account','Title'),(243,'account','Youtube Thumbnail will be used as a representation of this video'),(244,'account','Author'),(245,'account','Review'),(246,'account','Rating'),(247,'account','Created'),(248,'account','Request Removal'),(249,'account','Reason'),(250,'account','Request For Requesting Removal'),(251,'account','Hide My Profile'),(252,'account','If you wish to temporarily remove your profile from the site you may wish to hide it rather than deleting it'),(253,'account','Cancel'),(254,'account','Confirm'),(255,'account','You currently have a silver package expiring'),(256,'account','Start Date'),(257,'account','Expiry'),(258,'account','Upgrade'),(259,'account','Availability'),(260,'account','Amount'),(261,'account','Total'),(262,'account','Please confirm you wish to delete your account'),(263,'home','Load'),(264,'home','Teachers in'),(265,'content','Available Subjects'),(266,'content','Tutor Locations'),(267,'register','Personal urls are only available to paid advertisements. Only letters and dashes are allowed'),(268,'profile','Video'),(269,'account','You currently have a basic listing'),(270,'account','Active My Advert'),(274,'account','ProfileSubject'),(275,'account','ProfileStart Date'),(276,'account','ProfileExpiry'),(279,'account','Home'),(285,'content','FAQs'),(286,'content','General'),(287,'content','Students'),(288,'content','Tutors');

UNLOCK TABLES;

DROP TABLE IF EXISTS `i18n_messages`;

CREATE TABLE `i18n_messages` (
  `id` int(11) NOT NULL DEFAULT '0',
  `language` varchar(16) NOT NULL DEFAULT '',
  `translation` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`,`language`),
  CONSTRAINT `FK_Message_SourceMessage` FOREIGN KEY (`id`) REFERENCES `i18n_source_messages` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `i18n_messages` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE `i18n_messages` MODIFY `translation` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci;

LOCK TABLES `i18n_messages` WRITE;

insert  into `i18n_messages`(`id`,`language`,`translation`) values (1,'Vietnamese','Danh sách rút gọn'),(3,'Vietnamese','Câu hỏi thường gặp'),(4,'Vietnamese','Liên hệ liên lạc'),(5,'Vietnamese','Đăng Nhập'),(6,'Vietnamese','Đăng kí'),(7,'Vietnamese','Tài Khoản của tôi'),(8,'Vietnamese','Thoát'),(9,'Vietnamese','Tim gia su'),(10,'Vietnamese','Chon mon hoc'),(11,'Vietnamese','Ma vung'),(12,'Vietnamese','Tim kiem voi ma vung'),(13,'Vietnamese','Tim kiem'),(14,'Vietnamese','Tim kiem nang cao'),(15,'Vietnamese','Sinh vien'),(16,'Vietnamese','Tim kiem gia su'),(17,'Vietnamese','Tim kiem gia su'),(18,'Vietnamese','Ban do'),(19,'Vietnamese','Danh gia'),(20,'Vietnamese','Gia su'),(21,'Vietnamese','Quang cao'),(22,'Vietnamese','Mon hoc hien co'),(23,'Vietnamese','De nghi chuc nang'),(24,'Vietnamese','An toan truc tuyen'),(25,'Vietnamese','Gia su noi bat'),(26,'Vietnamese','Xem chi tiet'),(27,'Vietnamese','Ten'),(28,'Vietnamese','Vi tri'),(29,'Vietnamese','Danh gia'),(30,'Vietnamese','Mon hoc'),(31,'Vietnamese','Xem them'),(32,'Vietnamese','Gia su moi'),(65,'Vietnamese','Gioi thieu'),(66,'Vietnamese','Ban do trang'),(67,'Vietnamese','Rieng tu'),(68,'Vietnamese','Dieu khoan va dieu kien'),(69,'English',''),(69,'Vietnamese','Trang chu'),(70,'English',''),(70,'Vietnamese','Danh sach rut gon'),(71,'English',''),(71,'Vietnamese','Khong tim thay ket qua nao'),(72,'English',''),(72,'Vietnamese','Gia su'),(73,'English',''),(73,'Vietnamese','Tu'),(74,'English',''),(74,'Vietnamese','Cau hoi thuong gap'),(75,'English',''),(75,'Vietnamese','Lien he'),(76,'English',''),(76,'Vietnamese','Ten'),(77,'English',''),(77,'Vietnamese','Thu dien tu'),(78,'English',''),(78,'Vietnamese','TIn nhan'),(79,'English',''),(79,'Vietnamese','Gui di'),(80,'English',''),(80,'Vietnamese','Tim kiem'),(81,'English',''),(81,'Vietnamese','Mon hoc hien tai'),(82,'English',''),(82,'Vietnamese','De nghi chuc nang'),(83,'English',''),(83,'Vietnamese','Du lieu co dau * bat buoc nhap'),(84,'Vietnamese','Trang chu'),(85,'Vietnamese','Dang ki'),(86,'Vietnamese','Buoc 1'),(87,'Vietnamese','Buoc 2'),(88,'Vietnamese','Buoc 3'),(89,'Vietnamese','Buoc 4'),(90,'Vietnamese','Chi tiet dang nhap'),(91,'Vietnamese','Thong tin lien he'),(92,'Vietnamese','Li lich'),(93,'Vietnamese','Mon hoc am hieu'),(94,'Vietnamese','Ho'),(95,'Vietnamese','Ten'),(96,'Vietnamese','Thu dien tu'),(97,'Vietnamese','Mat khau'),(98,'Vietnamese','Xac nhan mat khau'),(99,'Vietnamese','Tiep'),(100,'Vietnamese','Danh xung'),(101,'Vietnamese','Gioi tinh'),(102,'Vietnamese','Cong ty'),(103,'Vietnamese','Dia chi'),(104,'Vietnamese','Ten duong'),(105,'Vietnamese','Ngoai o'),(106,'Vietnamese','Bang'),(107,'Vietnamese','Ma vung'),(108,'Vietnamese','Dien thoai'),(109,'Vietnamese','Trang web'),(110,'Vietnamese','Hoc phi mac dinh'),(111,'Vietnamese','Tro ve'),(112,'Vietnamese','url'),(113,'Vietnamese','Tieu de'),(114,'Vietnamese','Tom tat'),(115,'Vietnamese','Chi tiet'),(116,'Vietnamese','audience'),(117,'Vietnamese','delivery'),(118,'Vietnamese','Lien ket de kich hoat da dc gui toi thu dien tu cu'),(119,'Vietnamese','Mon hoc'),(120,'Vietnamese','Kinh nghiem'),(121,'Vietnamese','Cap do'),(122,'Vietnamese','Trang thai'),(123,'Vietnamese','Them mon hoc'),(124,'Vietnamese','Hoc phi'),(125,'Vietnamese','Gui di'),(126,'Vietnamese','Mon hoc'),(128,'Vietnamese','Tim kiem nang cao'),(129,'Vietnamese','Mon hoc'),(130,'Vietnamese','Chon mon hoc'),(131,'Vietnamese','Vi tri'),(132,'Vietnamese','Ma vung'),(133,'Vietnamese','Ma vung only'),(134,'Vietnamese','Cap do'),(135,'Vietnamese','Bat ki'),(136,'Vietnamese','delivery'),(137,'Vietnamese','Gioi tinh'),(138,'Vietnamese','Kinh nguyet'),(139,'Vietnamese','Hoc phi'),(140,'Vietnamese','Nam'),(141,'Vietnamese','Phan hoi'),(142,'Vietnamese','Danh gia'),(143,'Vietnamese','Sao'),(144,'Vietnamese','Lai'),(145,'Vietnamese','Gui di'),(146,'Vietnamese','Gia su noi bat'),(147,'Vietnamese','Ket qua tim kiem'),(148,'Vietnamese','Xem chi tiet'),(149,'Vietnamese','Kinh nguyet'),(150,'Vietnamese','Tim kiem'),(151,'Vietnamese','Gia su'),(152,'Vietnamese','Khoang'),(153,'Vietnamese','Gia su'),(154,'Vietnamese','Ban do'),(155,'Vietnamese','Khong tim thay ket qua nao'),(180,'Vietnamese','Gia su'),(181,'Vietnamese','Ho so'),(182,'Vietnamese','gia su o'),(183,'Vietnamese','Tranh anh'),(184,'Vietnamese','Danh gia'),(185,'Vietnamese','Lien he'),(186,'Vietnamese','Gioi tinh'),(187,'Vietnamese','Vi tri'),(188,'Vietnamese','audience'),(189,'Vietnamese','trang web'),(190,'Vietnamese','Mo ta'),(191,'Vietnamese','Mon hoc'),(192,'Vietnamese','Ten'),(193,'Vietnamese','Cap do'),(194,'Vietnamese','Kinh nghiem'),(195,'Vietnamese','Danh gia'),(196,'Vietnamese','Them 1 danh gia'),(197,'Vietnamese','Dang nhap de danh gia'),(198,'Vietnamese','Du lieu co dau * bat buoc nhap'),(200,'Vietnamese','Thu dien tu'),(201,'Vietnamese','Tin nhan'),(202,'Vietnamese','Dien thoai'),(203,'Vietnamese','Gui di'),(204,'English',''),(204,'Vietnamese','tai khoan cua toi'),(205,'English',''),(205,'Vietnamese','Chi tiet'),(206,'English',''),(206,'Vietnamese','Chi tiet dang nhap'),(207,'English',''),(207,'Vietnamese','Chi tiet lien he'),(208,'English',''),(208,'Vietnamese','Quang cao'),(209,'English',''),(209,'Vietnamese','Mon hoc'),(210,'English',''),(210,'Vietnamese','Tranh anh'),(211,'English',''),(211,'Vietnamese','Phim'),(212,'English',''),(212,'Vietnamese','Danh gia'),(213,'English',''),(213,'Vietnamese','An quang cao'),(214,'English',''),(214,'Vietnamese','Hoa don'),(215,'English',''),(215,'Vietnamese','Tom tat'),(216,'English',''),(216,'Vietnamese','Nang cap'),(217,'English',''),(217,'Vietnamese','Hoa don'),(218,'English',''),(218,'Vietnamese','Dong tai khoan'),(220,'English',''),(220,'Vietnamese','Mon hoc'),(221,'English',''),(221,'Vietnamese','Kinh nghiem'),(223,'English',''),(223,'Vietnamese','Trang thai'),(224,'English',''),(224,'Vietnamese','Lua chon'),(225,'English',''),(225,'Vietnamese','Xoa'),(226,'English',''),(226,'Vietnamese','Cho phep'),(227,'English',''),(227,'Vietnamese','Khong cho phep'),(228,'English',''),(228,'Vietnamese','Them mon hoc'),(230,'English',''),(230,'Vietnamese','Cap do'),(231,'English',''),(231,'Vietnamese','Nam kinh nghiem'),(232,'English',''),(232,'Vietnamese','Hoc phi'),(233,'English',''),(233,'Vietnamese','Tranh anh'),(234,'English',''),(234,'Vietnamese','Mo ta'),(235,'English',''),(235,'Vietnamese','Ua thich'),(236,'English',''),(236,'Vietnamese','Lap thanh ua thich'),(238,'English',''),(238,'Vietnamese','Them anh'),(239,'English',''),(239,'Vietnamese','Phim'),(240,'English',''),(240,'Vietnamese','Them phim'),(241,'English',''),(241,'Vietnamese','url'),(242,'English',''),(242,'Vietnamese','Tua de'),(243,'English',''),(243,'Vietnamese','Dung hinh utube lam dai dien'),(244,'English',''),(244,'Vietnamese','Tac gia'),(245,'English',''),(245,'Vietnamese','Danh gia'),(246,'English',''),(246,'Vietnamese','Sap hang'),(247,'English',''),(247,'Vietnamese','Tao'),(248,'English',''),(248,'Vietnamese','De nghi xoa'),(249,'English',''),(249,'Vietnamese','Li do'),(250,'English',''),(250,'Vietnamese','De nghi xoa'),(251,'English',''),(251,'Vietnamese','An tai khoan cua toi'),(252,'English',''),(252,'Vietnamese','An tai khoan phai khong'),(253,'English',''),(253,'Vietnamese','khong'),(254,'English',''),(254,'Vietnamese','Uh'),(255,'English',''),(255,'Vietnamese','may dang la tai khoan bac'),(256,'English',''),(256,'Vietnamese','Ngay bat dau'),(257,'English',''),(257,'Vietnamese','Het han'),(258,'English',''),(258,'Vietnamese','Nang cap'),(259,'English',''),(259,'Vietnamese','Kha dung'),(260,'English',''),(260,'Vietnamese','Gia'),(261,'English',''),(261,'Vietnamese','Tong cong'),(262,'English',''),(262,'Vietnamese','Xoa tai khoan ha'),(263,'Vietnamese','Tim'),(264,'Vietnamese','Gia su o'),(265,'English',''),(265,'Vietnamese','Mon hoc hien tai'),(266,'English',''),(266,'Vietnamese','Vi tri gia su'),(267,'Vietnamese','Lien ket ca nhan chi duoc su dung boi thanh vien c'),(268,'Vietnamese','Phim'),(269,'English',''),(269,'Vietnamese','Tai khoan cui bap'),(270,'English',''),(270,'Vietnamese','Kich hoat Tai khoan'),(274,'English',''),(275,'English',''),(276,'English',''),(279,'English',''),(285,'English',''),(286,'English',''),(287,'English',''),(288,'English','');

UNLOCK TABLES;

DROP TABLE IF EXISTS `invoices`;

CREATE TABLE `invoices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ref_account_id` int(11) DEFAULT NULL,
  `account_type` tinyint(1) DEFAULT NULL,
  `ref_transaction_id` int(11) DEFAULT NULL,
  `subscription_subject_ids` varchar(255) DEFAULT NULL,
  `expire_day` datetime DEFAULT NULL,
  `amount` varchar(30) DEFAULT NULL,
  `currency` varchar(30) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `messages`;

CREATE TABLE `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sender_name` varchar(255) DEFAULT NULL,
  `sender_email` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `content` text NOT NULL,
  `is_read` tinyint(1) DEFAULT '0',
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `page_blocks`;

CREATE TABLE `page_blocks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ref_page_id` int(11) NOT NULL,
  `ref_block_id` int(11) NOT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=82 DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `pages`;

CREATE TABLE `pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `status` tinyint(1) DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

LOCK TABLES `pages` WRITE;

insert  into `pages`(`id`,`title`,`slug`,`body`,`status`,`created`,`updated`) values (-12,'Upgrade Premium','upgrade-premium','Upgrade Premium Account',1,'2013-01-24 14:12:20',NULL),(-11,'Forgot Password','forgot-password','Forgot Password',1,'2013-01-08 17:21:09',NULL),(-10,'Premium Account','premium-account','Premium Account',1,'2012-12-20 15:57:58',NULL),(-9,'Enhance Account','enhance-account','Enhance Account',1,'2012-12-20 15:57:58',NULL),(-8,'Basic Account','basic-account','Basic Account',1,'2012-12-20 15:57:58',NULL),(-7,'Tutor Upgrade','tutor-upgrade','Tutor Upgrade',1,'2012-12-20 15:54:49',NULL),(-6,'Subjects Available','subjects-available','Subject Available',1,'2013-02-18 11:07:22',NULL),(-5,'Tutor\'s Home','tutor-home','Tutor\'s Home',1,'2012-12-06 14:51:21',NULL),(-4,'Home','home','Home',1,'2012-12-06 14:51:21',NULL),(-3,'Site Map','site-map','Site Map',1,'2012-12-06 14:51:21',NULL),(-2,'Contact','contact','Contact',1,'2012-12-06 14:51:21',NULL),(-1,'Feature Suggestion','feature-suggestion','Feature Suggestion',1,'2012-12-06 14:51:21',NULL),(1,'about','about','about',1,'2012-11-21 10:23:21','2012-12-19 13:58:29'),(2,'Privacy','privacy','privacy',1,'2012-11-07 10:44:06','2012-12-19 13:58:29'),(4,'Terms & Condition','terms-conditions','terms & condition',1,'2012-11-28 14:51:08','2012-12-19 13:58:29'),(5,'Online Safety','online-safety','Online Safety',1,'2012-12-18 16:37:35','2012-12-19 13:58:29'),(7,'FAQs','faqs','FAQ',1,'2012-12-18 16:43:14','2013-01-09 08:57:48'),(8,'Rate Your Tutor','rate-your-tutor','Rate Your Tutor',1,'2013-04-26 11:57:59',NULL);

UNLOCK TABLES;

DROP TABLE IF EXISTS `profiles`;

CREATE TABLE `profiles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ref_account_id` int(11) DEFAULT NULL,
  `salutation` varchar(30) DEFAULT NULL,
  `gender` varchar(30) NOT NULL,
  `company` varchar(255) DEFAULT NULL,
  `address` varchar(255) NOT NULL,
  `suburb` varchar(255) DEFAULT NULL,
  `state` varchar(30) NOT NULL,
  `post_code` varchar(30) NOT NULL,
  `phone` varchar(30) NOT NULL,
  `default_hourly_rate` varchar(30) NOT NULL,
  `website` varchar(255) DEFAULT NULL,
  `lat` double DEFAULT NULL,
  `lng` double DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `queues`;

CREATE TABLE `queues` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sender_email` varchar(255) DEFAULT NULL,
  `sender_name` varchar(255) DEFAULT NULL,
  `recipient_email` varchar(255) NOT NULL,
  `recipient_name` varchar(255) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `message` text,
  `status` tinyint(1) DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `reviews`;

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ref_account_id` int(11) DEFAULT NULL,
  `post_by` varchar(255) DEFAULT NULL,
  `rating` int(11) NOT NULL,
  `content` text NOT NULL,
  `login_provider_id` varchar(255) DEFAULT NULL,
  `provider` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `settings`;

CREATE TABLE `settings` (
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `value` text,
  `description` text,
  `created` date DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=69 DEFAULT CHARSET=latin1;

LOCK TABLES `settings` WRITE;

insert  into `settings`(`id`,`name`,`value`,`description`,`created`,`updated`) values (1,'search_km_choices','1,2,10,50',NULL,NULL,'2013-04-17 14:20:23'),(2,'search_review_choices','1,2,3,4',NULL,NULL,'2013-01-17 09:48:54'),(3,'search_feedback_choices','1,2,3,4',NULL,NULL,'2013-04-17 14:20:23'),(4,'site_title','Melbourne Tutor',NULL,NULL,'2013-04-17 14:20:23'),(5,'short_date_format','m-d-Y',NULL,NULL,'2013-04-17 14:20:23'),(6,'long_date_format','Y-m-d H:i:s',NULL,NULL,'2013-04-17 14:20:23'),(7,'google_api_key','109222673218-q4c1pvk7a3ejt7lecg6ej7bjdf5qtg63.apps.googleusercontent.com',NULL,NULL,'2013-04-17 14:20:23'),(8,'google_track_code','track code',NULL,NULL,'2013-01-08 18:00:46'),(9,'mail_server','smtp.sendgrid.com',NULL,NULL,'2013-02-18 11:27:40'),(10,'username','dinhthuong',NULL,NULL,'2013-02-18 11:27:40'),(11,'password','123',NULL,NULL,'2013-02-18 11:27:40'),(12,'ssl','1',NULL,NULL,'2013-02-18 11:27:40'),(13,'no_reply_name','Melbournetutor.org',NULL,NULL,'2013-02-18 11:27:40'),(14,'no_reply_address','noreply@melbournetutor.org',NULL,NULL,'2013-02-18 11:27:40'),(15,'reply_name','Melbournetutor.org',NULL,NULL,'2013-02-18 11:27:40'),(16,'reply_address','contact@melbournetutor.org',NULL,NULL,'2013-02-18 11:27:40'),(17,'port','85',NULL,NULL,'2013-02-18 11:27:40'),(18,'count_latest_tutor','5',NULL,NULL,'2013-02-01 15:14:11'),(19,'count_search_result','3',NULL,NULL,'2013-02-01 15:14:11'),(20,'count_browse_tutor','5',NULL,NULL,'2013-02-01 15:14:11'),(21,'video_enable','1',NULL,NULL,'2013-01-07 14:35:34'),(22,'video_player_width','800',NULL,NULL,'2013-01-07 14:35:34'),(23,'video_player_length','600',NULL,NULL,'2013-01-07 14:35:34'),(24,'video_summary_minimum','1',NULL,NULL,'2013-01-07 14:35:34'),(25,'video_summary_maximum','3',NULL,NULL,'2013-01-07 14:35:34'),(26,'invoice_company','Ossigeno Pty Ltd',NULL,NULL,'2013-04-17 11:23:46'),(27,'invoice_address','88 Wattle Road',NULL,NULL,'2013-04-17 11:23:46'),(28,'invoice_suburb','Hawthorn',NULL,NULL,'2013-04-17 11:23:46'),(29,'invoice_state','1',NULL,NULL,'2013-04-17 11:23:46'),(30,'invoice_footer','Ossigeno Pty Ltd, PO Box 4015, Auburn South, Victoria, 3122 Australia',NULL,NULL,'2013-04-17 11:23:46'),(31,'paypal_sandbox_mode','1',NULL,NULL,'2013-04-17 11:23:46'),(32,'paypal_email','xuanlo_1353492146_biz@gmail.com',NULL,NULL,'2013-04-17 11:23:46'),(36,'invoice_description','Description',NULL,NULL,'2013-01-31 12:01:54'),(37,'invoice_postcode','3122',NULL,NULL,'2013-04-17 11:23:46'),(41,'notify_expire_day','4',NULL,NULL,'2013-02-18 11:27:40'),(42,'min_rate','9',NULL,NULL,'2013-01-30 08:39:23'),(43,'max_rate','99',NULL,NULL,'2013-01-30 08:39:23'),(44,'min_experience','1',NULL,NULL,'2013-01-30 08:39:23'),(45,'max_experience','10',NULL,NULL,'2013-01-30 08:39:23'),(46,'currency','EUR',NULL,NULL,'2013-04-17 14:20:23'),(48,'paypal_currency','GBP',NULL,NULL,'2013-01-15 10:35:42'),(49,'google_api_secret','R7E2G-yFUAitUSFlNH_8jKw2',NULL,NULL,'2013-04-17 14:20:23'),(50,'facebook_api_key','243640999103046',NULL,NULL,'2013-04-17 14:20:23'),(51,'facebook_api_secret','3abed7f5a0547b2359184395d68460f1',NULL,NULL,'2013-04-17 14:20:23'),(52,'twitter_api_key','zIfvTVHJJZbYFzNuPSPT2w',NULL,NULL,'2013-04-17 14:20:23'),(53,'twitter_api_secret','pB9hWg4TPbbfboqLt9mDTTy1Lh6szVqOZaj2T7C2Uo',NULL,NULL,'2013-04-17 14:20:23'),(54,'gst_enable','1',NULL,NULL,'2013-04-17 11:23:46'),(55,'gst_rate','10',NULL,NULL,'2013-04-17 11:23:46'),(56,'default_currency_symbol','EU',NULL,NULL,'2013-04-17 14:20:23'),(57,'summary_minimum','20',NULL,NULL,'2013-02-01 15:14:11'),(58,'summary_maximum','200',NULL,NULL,'2013-02-01 15:14:11'),(59,'description_minimum','100',NULL,NULL,'2013-02-01 15:14:11'),(60,'description_maximum','500',NULL,NULL,'2013-02-01 15:14:11'),(61,'city','Melbournes',NULL,NULL,'2013-04-17 14:20:23'),(62,'meta_keywords','meta Melbournes',NULL,NULL,'2013-04-17 14:20:23'),(63,'meta_description','meta tutors',NULL,NULL,'2013-04-17 14:20:23'),(64,'language','English',NULL,NULL,'2013-04-17 14:20:23'),(66,'google_analytics_account','UA-40022559-1',NULL,NULL,'2013-04-17 14:20:23'),(68,'paypal_return_text','Return to sandbox@ossigeno.com.au',NULL,NULL,NULL);

UNLOCK TABLES;

DROP TABLE IF EXISTS `states`;

CREATE TABLE `states` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `state` varchar(30) NOT NULL,
  `is_default` tinyint(1) DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

LOCK TABLES `states` WRITE;

insert  into `states`(`id`,`state`,`is_default`,`created`,`updated`) values (1,'VIC',0,'2012-12-27 16:59:45','2013-01-17 09:49:50'),(2,'TAS',0,'2012-12-27 16:59:56','2013-01-17 09:56:51'),(4,'NSW',1,'2012-12-27 17:00:30','2013-01-17 09:58:44'),(6,'ACT',0,'2012-12-28 09:08:13','2013-01-17 09:58:44');

UNLOCK TABLES;

DROP TABLE IF EXISTS `subject_levels`;

CREATE TABLE `subject_levels` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `status` tinyint(1) DEFAULT '0',
  `created` date DEFAULT NULL,
  `updated` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

LOCK TABLES `subject_levels` WRITE;

insert  into `subject_levels`(`id`,`name`,`status`,`created`,`updated`) values (1,'Primary',1,'2013-04-17','2013-04-17'),(2,'Secondary',1,'2013-04-17','2013-04-17'),(3,'Tertiary',1,'2013-04-17','2013-04-17'),(4,'Adult',1,'2013-04-17','2013-04-17');

UNLOCK TABLES;

DROP TABLE IF EXISTS `subjects`;

CREATE TABLE `subjects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ref_parent_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `root` varchar(255) DEFAULT NULL,
  `level` int(11) DEFAULT NULL,
  `index` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  `available_date` bigint(20) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=latin1;

LOCK TABLES `subjects` WRITE;

insert  into `subjects`(`id`,`ref_parent_id`,`name`,`root`,`level`,`index`,`status`,`available_date`,`created`,`updated`) values (1,1,'Mathematics','1',1,'1',1,'','2012-11-26 14:50:45','2013-03-26 10:26:40');

UNLOCK TABLES;

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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

LOCK TABLES `subscriptions` WRITE;

insert  into `subscriptions`(`id`,`title`,`type`,`currency`,`amount`,`period`,`status`,`created`,`updated`) values (2,'Enhanced 1',1,'AU','40','1 Month',1,'2012-12-20 15:20:53','2013-01-28 11:34:09'),(3,'Enhanced 2',1,'GBP','70','2 Months',1,'2012-12-20 15:21:32','2012-12-20 15:24:12'),(4,'Enhanced 3',1,'GBP','100','3 Months',0,'2012-12-20 15:22:10','2013-02-19 15:36:35'),(5,'Premium 1',2,'GBP','50','1 Month',1,'2012-12-20 15:22:38','2013-01-28 10:52:40'),(6,'Premium 2',2,'GBP','90','2 Months',1,'2012-12-20 15:22:51','2012-12-20 15:24:12'),(7,'Premium 3',2,'GBP','130','3 Months',0,'2012-12-20 15:23:11','2013-02-19 15:36:35');

UNLOCK TABLES;

DROP TABLE IF EXISTS `templates`;

CREATE TABLE `templates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `subject` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `description` text,
  `status` tinyint(1) DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

LOCK TABLES `templates` WRITE;

insert  into `templates`(`id`,`name`,`subject`,`content`,`description`,`status`,`created`,`updated`) values (1,'sign_up','Sign Up','Hi %name%,\r\nyour account has been created. Visit this url to activate your account: %activateUrl%.','description',0,'2012-11-27 15:00:40','2012-12-25 09:08:28'),(4,'notify_expire_account','Notify Expire Account','Hi %name%, \nYour %account_type% account is going to expire %remain%.','Notify users if their account is going to expire',0,'2012-12-31 16:33:28',NULL),(6,'reset_password','Reset Password','Hi %name%, visit this url %resetUrl% to reset your password.','reset password',0,'2013-01-08 16:26:35',NULL),(7,'close_account','Close Account','Hi %name%, you had deleted your account at %url%.','delete account',0,'2013-01-22 15:02:33',NULL),(8,'hide_advert','Hide Advertise','Hi %name%, you had hidden your advertise at %url%.','hide advertise',0,'2013-01-22 17:05:43',NULL),(9,'active_advert','Active Advertise','Hi %name%, you had activated your advertise at %url%.','active advertise',0,'2013-01-22 17:07:02',NULL),(11,'resend_activate_link','Resend Activate Link','Hi %name%, here is your new activate account link %url%','resend activate account link',0,'2013-01-23 15:52:31',NULL),(12,'notify_expire_gold_account','Notify Expire Gold Account','<p>\r\n	Hi %name%, Your %account_type% account with %subject% subject is going to expire %remain%.</p>\r\n','notify expire gold account with subject',0,'2013-02-18 12:02:57','2013-02-27 14:47:30');

UNLOCK TABLES;

DROP TABLE IF EXISTS `transaction`;

CREATE TABLE `transaction` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ref_account_id` int(11) DEFAULT NULL,
  `txn_id` varchar(64) NOT NULL,
  `payment_status` varchar(16) NOT NULL,
  `payment_date` varchar(64) NOT NULL,
  `mc_gross` decimal(6,2) NOT NULL,
  `info` text NOT NULL,
  `status` enum('created','verified') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `tutor_deliveries`;

CREATE TABLE `tutor_deliveries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ref_account_id` int(1) DEFAULT NULL,
  `ref_delivery_id` int(1) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=109 DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `tutor_premiums`;

CREATE TABLE `tutor_premiums` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ref_account_id` int(11) DEFAULT NULL,
  `ref_subject_id` int(11) DEFAULT NULL,
  `ref_subscription_id` int(11) DEFAULT NULL,
  `start_date` bigint(20) DEFAULT NULL,
  `expire_date` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `tutor_subjects`;

CREATE TABLE `tutor_subjects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ref_account_id` int(11) DEFAULT NULL,
  `ref_subject_id` int(11) DEFAULT NULL,
  `experience` int(11) DEFAULT NULL,
  `level` varchar(30) DEFAULT NULL,
  `hourly_rate` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=84 DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `videos`;

CREATE TABLE `videos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ref_account_id` int(11) DEFAULT NULL,
  `video_url` varchar(255) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;INSERT INTO `i18n_source_messages` (`category`, `message`) VALUES ('account', 'Member since'); ALTER TABLE accounts
ADD COLUMN previous_login DATETIME;