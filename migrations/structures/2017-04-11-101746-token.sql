ALTER TABLE `users`
CHANGE `password_hash` `password_hash` varchar(255) COLLATE 'utf8mb4_czech_ci' NULL AFTER `email`,
ADD `token` varchar(255) COLLATE 'utf8mb4_czech_ci' NULL;
