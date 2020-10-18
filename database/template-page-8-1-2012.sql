INSERT INTO `tutor`.`templates` (`name`, `subject`, `content`, `description`, `created`)VALUES('reset_password', 'Reset Password', 'Hi %name%, visit this url %resetUrl% to reset your password.', 'reset password', NOW());

INSERT INTO `tutor`.`pages` (`id`, `title`, `slug`, `body`, `status`, `created`)VALUES('-11', 'Forgot Password', 'forgot-password', 'Forgot Password', '1', NOW() );
