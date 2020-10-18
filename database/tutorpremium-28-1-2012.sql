CREATE TABLE `tutor_premiums` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ref_account_id` int(11) DEFAULT NULL,
  `ref_subject_id` int(11) DEFAULT NULL,
  `start_date` bigint(20) DEFAULT NULL,
  `expire_date` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

ALTER TABLE invoices 
ADD COLUMN subscription_subject_ids VARCHAR(255) AFTER ref_transaction_id;

ALTER TABLE subjects 
ADD COLUMN available_date BIGINT(20) AFTER `status`;
