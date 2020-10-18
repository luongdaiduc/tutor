INSERT INTO `tutor`.`pages`(`id`,`title`,`slug`,`body`,`status`,`created`,`updated`) VALUES ( '-12','Upgrade Premium','upgrade-premium','Upgrade Premium Account','1','2013-01-24 14:12:20',NULL);

ALTER TABLE invoices
ADD COLUMN currency VARCHAR(30) AFTER amount;