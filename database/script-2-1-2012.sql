ALTER TABLE profiles
DROP COLUMN currency;

ALTER TABLE tutor_subjects
DROP COLUMN currency


INSERT INTO `tutor`.`settings` (`name`, `value`)VALUES('currency', 'AUD');
