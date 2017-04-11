ALTER TABLE `feedbacks`
ADD COLUMN `rating` INT(10) NULL DEFAULT NULL AFTER `created_at`;
