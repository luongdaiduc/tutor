ALTER TABLE reviews
CHANGE ref_tutor_account_id ref_account_id INT(11);

ALTER TABLE reviews
CHANGE post_by post_by VARCHAR(255);

ALTER TABLE reviews
CHANGE `status` `status` TINYINT(1) DEFAULT 1;

ALTER TABLE reviews
ADD COLUMN updated DATETIME;

ALTER TABLE reviews 
ADD COLUMN login_provider_id VARCHAR(255) AFTER content;

ALTER TABLE reviews 
ADD COLUMN provider VARCHAR(255) AFTER login_provider_id;

ALTER TABLE accounts 
ADD COLUMN rating DECIMAL(10,1) AFTER `password`;