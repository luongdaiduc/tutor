ALTER TABLE `i18n_messages` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;
ALTER TABLE `i18n_messages` 
MODIFY `translation` VARCHAR(50) 
CHARACTER SET utf8 COLLATE utf8_general_ci;