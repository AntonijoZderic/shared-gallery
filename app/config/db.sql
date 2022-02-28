CREATE TABLE `users` (
  `id` int(11) UNSIGNED AUTO_INCREMENT NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL UNIQUE,
  `pwd` varchar(60) NOT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `auth_tokens` (
  `id` integer(11) UNSIGNED AUTO_INCREMENT NOT NULL,
  `selector` char(12),
  `token` char(64),
  `user_id` integer(11) UNSIGNED NOT NULL,
  `expires` datetime,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
);