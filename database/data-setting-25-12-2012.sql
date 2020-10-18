INSERT INTO `tutor`.`settings` (`name`, `value`)VALUES('invoice_company', 'Ossigeno Pty Ltd');
INSERT INTO `tutor`.`settings` (`name`, `value`)VALUES('invoice_address', '88 Wattle Road');
INSERT INTO `tutor`.`settings` (`name`, `value`)VALUES('invoice_suburb', 'Hawthorn');
INSERT INTO `tutor`.`settings` (`name`, `value`)VALUES('invoice_state', 'VIC');
INSERT INTO `tutor`.`settings` (`name`, `value`)VALUES('invoice_postcode', '3122');

INSERT INTO `tutor`.`settings` (`name`, `value`)VALUES('invoice_footer', 'Ossigeno Pty Ltd, PO Box 4015, Auburn South, Victoria, 3122 Australia');
INSERT INTO `tutor`.`settings` (`name`, `value`)VALUES('invoice_description', 'invoice description');
INSERT INTO `tutor`.`settings` (`name`, `value`)VALUES('paypal_sandbox_mode', '1');

INSERT INTO `tutor`.`settings` (`name`, `value`)VALUES('paypal_email', 'xuanlo_1353468913_biz@gmail.com');

INSERT INTO `tutor`.`settings` (`name`, `value`)VALUES('paypal_username', 'xuanlo_1353492146_biz_api1.gmail.com');

INSERT INTO `tutor`.`settings` (`name`, `value`)VALUES('paypal_password', '1353492166');
INSERT INTO `tutor`.`settings` (`name`, `value`)VALUES('paypal_signature', 'AIAwHl9zezVvqkf.uCIQekxUj3qgAv0RA-vWs7ILoo.UJD38lLypJ.H1');

ALTER TABLE invoices 
ADD COLUMN ref_transaction_id INT(11) AFTER account_type;

ALTER TABLE invoices 
DROP COLUMN pdf;