ALTER TABLE `tr_test_widget`
ADD `start_count` int NOT NULL DEFAULT '0' AFTER `bottom_branding_url`,
ADD `finish_count` int NOT NULL DEFAULT '0' AFTER `start_count`;

CREATE TABLE `tr_test_widget_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(100) NOT NULL,
  `test_widget_id` int(11) NOT NULL,
  `test_result_id` int(11) DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `user_agent` text,
  `browser` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `started_at` int(11) DEFAULT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id_test_widget_id` (`user_id`,`test_widget_id`),
  KEY `test_widget_id` (`test_widget_id`),
  KEY `test_result_id` (`test_result_id`),
  CONSTRAINT `tr_test_widget_user_ibfk_1` FOREIGN KEY (`test_widget_id`) REFERENCES `tr_test_widget` (`id`) ON DELETE CASCADE,
  CONSTRAINT `tr_test_widget_user_ibfk_2` FOREIGN KEY (`test_result_id`) REFERENCES `tr_test_result` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
