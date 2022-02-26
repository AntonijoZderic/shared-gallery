CREATE TABLE `users` (
  `id` int(11) UNSIGNED AUTO_INCREMENT NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL UNIQUE,
  `pwd` varchar(60) NOT NULL,
  PRIMARY KEY (`id`)
);