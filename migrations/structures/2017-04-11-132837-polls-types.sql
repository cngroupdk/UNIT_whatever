ALTER TABLE `polls`
ADD COLUMN `type` ENUM('single_category', 'multiple_category', 'ratings') NULL DEFAULT 'single_category' AFTER `description`;
