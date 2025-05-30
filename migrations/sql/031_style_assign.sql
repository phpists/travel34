-- 1.

CREATE TABLE `tr_style_assign` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `style_id` int(11) NOT NULL,
  `page_key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `style_id` (`style_id`),
  CONSTRAINT `tr_style_assign_ibfk_1` FOREIGN KEY (`style_id`) REFERENCES `tr_style` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. Run 'yiic tools assignstyles' after sql

-- 3.

ALTER TABLE `tr_style` DROP `page_key`, DROP `item_id`;
