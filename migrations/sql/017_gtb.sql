DROP TABLE IF EXISTS `tr_gtb_comment`;
DROP TABLE IF EXISTS `tr_gtb_post`;
DROP TABLE IF EXISTS `tr_gtb_rubric`;

CREATE TABLE `tr_gtb_rubric` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(100) NOT NULL,
  `title` varchar(255) NOT NULL,
  `title_en` varchar(255) NOT NULL,
  `description` text,
  `description_en` text,
  `position` int(11) NOT NULL DEFAULT '0',
  `in_todo_list` tinyint(1) NOT NULL DEFAULT '0',
  `status_id` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `tr_gtb_post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author_id` int(11) DEFAULT NULL,
  `gtb_rubric_id` int(11) DEFAULT NULL,
  `type_id` tinyint(2) NOT NULL DEFAULT '1',
  `url` varchar(255) NOT NULL DEFAULT '',
  `title` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `summary` text,
  `text` longtext,
  `page_title` varchar(255) DEFAULT NULL,
  `page_keywords` varchar(255) DEFAULT NULL,
  `page_description` text,
  `is_top` tinyint(1) NOT NULL DEFAULT '0',
  `is_big_top` tinyint(1) NOT NULL DEFAULT '0',
  `is_home_big_top` tinyint(1) NOT NULL DEFAULT '0',
  `is_supertop` tinyint(1) NOT NULL DEFAULT '0',
  `is_home_supertop` tinyint(1) NOT NULL DEFAULT '0',
  `is_image_in_post` tinyint(1) NOT NULL DEFAULT '0',
  `image` varchar(255) DEFAULT NULL,
  `image_top` varchar(255) DEFAULT NULL,
  `image_big_top` varchar(255) DEFAULT NULL,
  `image_supertop` varchar(255) DEFAULT NULL,
  `image_in_post` varchar(255) DEFAULT NULL,
  `related_posts` varchar(255) DEFAULT NULL,
  `status_id` tinyint(1) NOT NULL DEFAULT '0',
  `language` varchar(6) NOT NULL DEFAULT '',
  `hide_banners` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `comments_count` int(11) NOT NULL DEFAULT '0',
  `views_count` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `author_idx` (`author_id`),
  KEY `gtb_rubric_idx` (`gtb_rubric_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `tr_gtb_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gtb_post_id` int(11) NOT NULL,
  `content` text,
  `email` varchar(255) DEFAULT NULL,
  `user_name` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `create_user_id` int(11) DEFAULT NULL,
  `update_user_id` int(11) DEFAULT NULL,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `status_id` tinyint(1) NOT NULL DEFAULT '1',
  `likes_count` int(11) NOT NULL DEFAULT '0',
  `dislikes_count` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `gtb_comment_post_idx` (`gtb_post_id`),
  CONSTRAINT `fk_gtb_comment_post` FOREIGN KEY (`gtb_post_id`) REFERENCES `tr_gtb_post` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- blocks

INSERT INTO `tr_block` (`name`, `description`, `content`) VALUES
('footer_menu_en', 'Меню в футере (EN)', '<ul>\r\n    <li><a href="/page/about-us"><span>About us</span></a></li>\r\n    <li><a href="/page/contacts"><span>Contact us</span></a></li>\r\n    <li><a href="/page/advertisement"><span>Advertise</span></a></li>\r\n    <li><a href="/page/disclaimer"><span>Legal information</span></a></li>\r\n</ul>'),
('footer_text_en', 'Текст в футере (EN)', '<p class="email">E-mail: <a href="mailto:34travelby@gmail.com" title="">34travelby@gmail.com</a></p>\r\n\r\n<p>All rights reserved. The reference to source is obligatory if you use materials of the site. 34travel.me does not bear responsibility for the advertisements.</p>\r\n\r\n<p>If you’ve found a typo, select it with mouse and press Ctrl+Enter – we will correct it.</p>\r\n\r\n<p class="b-deposit_photos">Stock photos from <a href="http://depositphotos.com/?utm_source=34travel&utm_medium=footer&utm_campaign=BY-brand" target="_blank" class="b-deposit_photos"></a></p>');

INSERT INTO `tr_block` (`name`, `description`, `content`) VALUES
('gtb_promo_link', 'Ссылка на промо материал', '<div class="special-link">\r\n    <a href="https://34travel.me/post/minsk"><img src="/themes/travel/images/victory_02.svg" width="29" alt=""><span>Minsk Guide</span></a>\r\n</div>'),
('gtb_promo_link_en', 'Ссылка на промо материал (EN)', '<div class="special-link">\r\n    <a href="https://34travel.me/post/minsk-english-guide"><img src="/themes/travel/images/victory_02.svg" width="29" alt=""><span>Minsk Guide</span></a>\r\n</div>'),
('gtb_promo_link_supertop', 'Ссылка на промо материал с супертопом', '<div class="special-link">\r\n    <a href="https://34travel.me/post/minsk"><img src="/themes/travel/images/victory_01.svg" width="29" alt=""><span>Minsk Guide</span></a>\r\n</div>'),
('gtb_promo_link_supertop_en', 'Ссылка на промо материал с супертопом (EN)', '<div class="special-link">\r\n    <a href="https://34travel.me/post/minsk-english-guide"><img src="/themes/travel/images/victory_01.svg" width="29" alt=""><span>Minsk Guide</span></a>\r\n</div>'),
('gtb_slogan', 'Слоган на GTB', '<p><span>BEST OF BELARUS</span></p>\r\n<p><span>PROJECT BY 34TRAVEL.ME</span></p>'),
('gtb_slogan_en', 'Слоган на GTB (EN)', '<p><span>BEST OF BELARUS</span></p>\r\n<p><span>PROJECT BY 34TRAVEL.ME</span></p>');

-- banners

DROP TABLE IF EXISTS `tr_gtb_banner`;

CREATE TABLE `tr_gtb_banner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `banner_place_id` int(11) NOT NULL DEFAULT '0',
  `title` varchar(45) NOT NULL,
  `url` varchar(255) NOT NULL,
  `open_new_tab` tinyint(1) NOT NULL DEFAULT '0',
  `image` varchar(255) DEFAULT NULL,
  `image_mobile` varchar(255) DEFAULT NULL,
  `grid_position` int(11) NOT NULL DEFAULT '0',
  `language` varchar(6) NOT NULL DEFAULT '',
  `status_id` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- posts

ALTER TABLE `tr_post` ADD `is_gtb_post` tinyint(1) NOT NULL DEFAULT '0' AFTER `news_link_title`;
ALTER TABLE `tr_post` ADD `gtb_post_id` int(11) DEFAULT NULL AFTER `is_gtb_post`;
