INSERT INTO `i18n_source_messages` (`category`, `message`) VALUES ('search', 'or more'); 
INSERT INTO `i18n_source_messages` (`category`, `message`) VALUES ('search', 'Male'); 
INSERT INTO `i18n_source_messages` (`category`, `message`) VALUES ('search', 'Female'); 
INSERT INTO `i18n_source_messages` (`category`, `message`) VALUES ('search', 'Within');

INSERT INTO `i18n_source_messages` (`category`, `message`) VALUES ('search', 'Name'); 
INSERT INTO `i18n_source_messages` (`category`, `message`) VALUES ('search', 'Location'); 
INSERT INTO `i18n_source_messages` (`category`, `message`) VALUES ('search', 'Subjects');

INSERT INTO `i18n_source_messages` (`category`, `message`) VALUES ('validation', 'cannot be blank'); 
INSERT INTO `i18n_source_messages` (`category`, `message`) VALUES ('validation', 'Email is not a valid email address'); 

INSERT INTO `i18n_source_messages` (`category`, `message`) VALUES ('validation', 'Password is too short (minimum is 6 characters)'); 
INSERT INTO `i18n_source_messages` (`category`, `message`) VALUES ('validation', "Passwords don't match"); 
INSERT INTO `i18n_source_messages` (`category`, `message`) VALUES ('validation', "Your email was already used by another user"); 

ALTER TABLE deliveries ADD COLUMN `status` INT(11) DEFAULT 1 AFTER `name`;
