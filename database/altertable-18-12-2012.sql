ALTER TABLE tutor_subjects
ADD COLUMN currency VARCHAR(30) AFTER level;

ALTER TABLE tutor_subjects
CHANGE ref_account_id ref_account_id INT(11) NULL;

ALTER TABLE tutor_subjects
ADD COLUMN status TINYINT(1) DEFAULT 1 AFTER hourly_rate;

ALTER TABLE profiles 
DROP COLUMN ref_category_id;

ALTER TABLE profiles
DROP COLUMN avatar;

INSERT INTO `tutor`.`pages` (`title`, `slug`, `body`, `status`, `created`)VALUES('Online Safety', 'online-safety', 'body', '1', NOW());

INSERT INTO `tutor`.`pages` (`title`, `slug`, `body`, `status`, `created`)VALUES('FAQs', 'faqs', 'body', '1', NOW());