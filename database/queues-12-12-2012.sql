ALTER TABLE queues
ADD COLUMN sender_email VARCHAR(255) AFTER id;

ALTER TABLE queues
ADD COLUMN sender_name VARCHAR(255) AFTER sender_email;

ALTER TABLE queues
ADD COLUMN title VARCHAR(255) AFTER recipient_name;

ALTER TABLE queues
ADD COLUMN message TEXT AFTER title;

ALTER TABLE queues
ADD COLUMN status TINYINT(1) DEFAULT 0 AFTER message;