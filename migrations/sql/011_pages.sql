CREATE TABLE `tr_page` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `page_title` varchar(255) NULL,
  `page_keywords` varchar(255) NULL,
  `description` text NULL,
  `text` longtext NULL,
  `status_id` tinyint(1) NOT NULL DEFAULT '0',
  `background_type_id` tinyint(2) NOT NULL DEFAULT '0',
  `bg_image` varchar(255) NULL,
  `bg_image_repeat` varchar(255) NULL,
  `bg_image_height` smallint(6) NULL,
  `bg_image_padding_top` smallint(6) NULL,
  `background_url` varchar(255) NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;