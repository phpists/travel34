-- Adminer 4.8.0 MySQL 5.7.34-0ubuntu0.18.04.1-log dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `tr_author`;
CREATE TABLE `tr_author` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `page_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `page_description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `tr_banner`;
CREATE TABLE `tr_banner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `banner_place_id` int(11) DEFAULT NULL,
  `banner_system` int(11) NOT NULL DEFAULT '0',
  `title` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci,
  `code` text COLLATE utf8mb4_unicode_ci,
  `status_id` tinyint(1) DEFAULT NULL,
  `geo_target` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `tr_block`;
CREATE TABLE `tr_block` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` mediumtext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `tr_city`;
CREATE TABLE `tr_city` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `status_id` tinyint(1) DEFAULT '1',
  `world_part_id` tinyint(2) DEFAULT '1',
  `url` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `tr_comment`;
CREATE TABLE `tr_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_id` int(11) NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `create_user_id` int(11) DEFAULT NULL,
  `update_user_id` int(11) DEFAULT NULL,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `status_id` tinyint(1) NOT NULL DEFAULT '1',
  `likes_count` int(5) DEFAULT '0',
  `dislikes_count` int(5) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_comment_post_idx` (`post_id`),
  CONSTRAINT `fk_comment_post` FOREIGN KEY (`post_id`) REFERENCES `tr_post` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `tr_country`;
CREATE TABLE `tr_country` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `status_id` tinyint(1) DEFAULT '1',
  `world_part_id` tinyint(2) DEFAULT '1',
  `url` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `tr_gtb_banner`;
CREATE TABLE `tr_gtb_banner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `banner_place_id` int(11) NOT NULL DEFAULT '0',
  `title` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `open_new_tab` tinyint(1) NOT NULL DEFAULT '0',
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_mobile` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `grid_position` int(11) NOT NULL DEFAULT '0',
  `language` varchar(6) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `status_id` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `tr_gtb_comment`;
CREATE TABLE `tr_gtb_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gtb_post_id` int(11) NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `tr_gtb_post`;
CREATE TABLE `tr_gtb_post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author_id` int(11) DEFAULT NULL,
  `gtb_rubric_id` int(11) DEFAULT NULL,
  `type_id` tinyint(2) NOT NULL DEFAULT '1',
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` datetime DEFAULT NULL,
  `summary` text COLLATE utf8mb4_unicode_ci,
  `text` longtext COLLATE utf8mb4_unicode_ci,
  `page_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `page_keywords` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `page_description` text COLLATE utf8mb4_unicode_ci,
  `page_og_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_top` tinyint(1) NOT NULL DEFAULT '0',
  `is_big_top` tinyint(1) NOT NULL DEFAULT '0',
  `is_home_big_top` tinyint(1) NOT NULL DEFAULT '0',
  `is_supertop` tinyint(1) NOT NULL DEFAULT '0',
  `is_home_supertop` tinyint(1) NOT NULL DEFAULT '0',
  `is_image_in_post` tinyint(1) NOT NULL DEFAULT '0',
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_top` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_big_top` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_supertop` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_home_supertop` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_in_post` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `related_posts` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_id` tinyint(1) NOT NULL DEFAULT '0',
  `language` varchar(6) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `hide_banners` tinyint(1) NOT NULL DEFAULT '0',
  `hide_comments` tinyint(1) NOT NULL DEFAULT '0',
  `hide_styles` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `comments_count` int(11) NOT NULL DEFAULT '0',
  `views_count` int(11) NOT NULL DEFAULT '0',
  `background_color` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `background_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_new` tinyint(1) NOT NULL DEFAULT '1',
  `hide_yandex_rss` tinyint(1) NOT NULL DEFAULT '0',
  `yandex_rss_genre` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hide_yandex_zen` tinyint(1) NOT NULL DEFAULT '0',
  `yandex_zen_adult` tinyint(1) NOT NULL DEFAULT '0',
  `yandex_zen_categories` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `author_idx` (`author_id`),
  KEY `gtb_rubric_idx` (`gtb_rubric_id`),
  CONSTRAINT `tr_gtb_post_ibfk_1` FOREIGN KEY (`gtb_rubric_id`) REFERENCES `tr_gtb_rubric` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `tr_gtb_rubric`;
CREATE TABLE `tr_gtb_rubric` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title_en` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `description_en` text COLLATE utf8mb4_unicode_ci,
  `position` int(11) NOT NULL DEFAULT '0',
  `in_todo_list` tinyint(1) NOT NULL DEFAULT '0',
  `hide_in_menu` tinyint(1) NOT NULL DEFAULT '0',
  `hide_in_menu_en` tinyint(1) NOT NULL DEFAULT '0',
  `status_id` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `tr_interactive_result`;
CREATE TABLE `tr_interactive_result` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `interactive_widget_id` int(11) DEFAULT NULL,
  `text` text COLLATE utf8mb4_unicode_ci,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `interactive_widget_id` (`interactive_widget_id`),
  CONSTRAINT `fk_interactive_result_widget_id` FOREIGN KEY (`interactive_widget_id`) REFERENCES `tr_interactive_widget` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `tr_interactive_widget`;
CREATE TABLE `tr_interactive_widget` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` tinytext COLLATE utf8mb4_unicode_ci,
  `skip_step2` tinyint(1) NOT NULL DEFAULT '0',
  `step3_title` tinytext COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `background_color` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `background_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `step3_background_color` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `step3_background_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `has_border` tinyint(1) NOT NULL DEFAULT '0',
  `border_color` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `step1_title_color` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `step1_title_has_border` tinyint(1) NOT NULL DEFAULT '0',
  `step1_title_border_color` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `step2_title_color` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `step2_title_has_border` tinyint(1) NOT NULL DEFAULT '0',
  `step2_title_border_color` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `step3_title_color` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `step3_title_has_border` tinyint(1) NOT NULL DEFAULT '0',
  `step3_title_border_color` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `step3_text_after` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `step1_button_color` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `step1_button_border_color` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `step1_button_shadow_color` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `step1_button_hover_color` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `step1_button_hover_shadow_color` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `step2_button_color` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `step2_button_border_color` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `step2_button_shadow_color` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `step2_button_hover_color` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `step2_button_hover_shadow_color` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `step3_button_color` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `step3_button_border_color` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `step3_button_shadow_color` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `step3_button_hover_color` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `step3_button_hover_shadow_color` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `step2_text` tinytext COLLATE utf8mb4_unicode_ci,
  `step2_text_color` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `step3_text_color` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `has_top_branding` tinyint(1) NOT NULL DEFAULT '0',
  `top_branding_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `top_branding_mobile_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `top_branding_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `has_bottom_branding` tinyint(1) NOT NULL DEFAULT '0',
  `bottom_branding_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bottom_branding_mobile_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bottom_branding_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `tr_page`;
CREATE TABLE `tr_page` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `page_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `page_keywords` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `text` longtext COLLATE utf8mb4_unicode_ci,
  `status_id` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `tr_post`;
CREATE TABLE `tr_post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author_id` int(11) NOT NULL DEFAULT '0',
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` datetime DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_big_post` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `text` longtext COLLATE utf8mb4_unicode_ci,
  `status_id` tinyint(1) NOT NULL DEFAULT '0',
  `summary` mediumtext COLLATE utf8mb4_unicode_ci,
  `type_id` tinyint(2) NOT NULL DEFAULT '1',
  `comments_count` int(11) DEFAULT '0',
  `views_count` int(11) DEFAULT '0',
  `custom_icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rubric_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `image_top` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_news` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `need_image_big_post` tinyint(1) NOT NULL DEFAULT '0',
  `is_small_top` tinyint(1) NOT NULL DEFAULT '0',
  `is_big_top` tinyint(1) NOT NULL DEFAULT '0',
  `is_home_top` tinyint(1) NOT NULL DEFAULT '0',
  `is_home_first_top` tinyint(1) NOT NULL DEFAULT '0',
  `image_home_top` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `page_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `page_keywords` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `page_og_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `news_link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `news_link_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_gtb_post` tinyint(1) NOT NULL DEFAULT '0',
  `gtb_post_id` int(11) DEFAULT NULL,
  `hide_banners` tinyint(1) NOT NULL DEFAULT '0',
  `hide_comments` tinyint(1) NOT NULL DEFAULT '0',
  `hide_styles` tinyint(1) NOT NULL DEFAULT '0',
  `description` text COLLATE utf8mb4_unicode_ci,
  `special_id` int(11) NOT NULL DEFAULT '0',
  `related_posts` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `geo_target` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `background_color` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `background_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_new` tinyint(1) NOT NULL DEFAULT '1',
  `hide_yandex_rss` tinyint(1) NOT NULL DEFAULT '0',
  `yandex_rss_genre` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hide_yandex_zen` tinyint(1) NOT NULL DEFAULT '0',
  `yandex_zen_adult` tinyint(1) NOT NULL DEFAULT '0',
  `yandex_zen_categories` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `FK_author_idx` (`author_id`),
  KEY `FK_rubric_idx` (`rubric_id`),
  CONSTRAINT `tr_post_ibfk_1` FOREIGN KEY (`rubric_id`) REFERENCES `tr_rubric` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `tr_post_city_assignment`;
CREATE TABLE `tr_post_city_assignment` (
  `post_id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  PRIMARY KEY (`post_id`,`city_id`),
  KEY `FK_city_post_idx` (`city_id`),
  CONSTRAINT `FK_city_post` FOREIGN KEY (`city_id`) REFERENCES `tr_city` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_post_city` FOREIGN KEY (`post_id`) REFERENCES `tr_post` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `tr_post_country_assignment`;
CREATE TABLE `tr_post_country_assignment` (
  `post_id` int(11) NOT NULL,
  `country_id` int(11) NOT NULL,
  PRIMARY KEY (`post_id`,`country_id`),
  KEY `FK_country_post_idx` (`country_id`),
  CONSTRAINT `FK_country_post` FOREIGN KEY (`country_id`) REFERENCES `tr_country` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_post_country` FOREIGN KEY (`post_id`) REFERENCES `tr_post` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `tr_proposal`;
CREATE TABLE `tr_proposal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `form_type` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `processed` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `tr_rubric`;
CREATE TABLE `tr_rubric` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `status_id` tinyint(1) DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `tr_seo_tag`;
CREATE TABLE `tr_seo_tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `path` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `tr_special_project`;
CREATE TABLE `tr_special_project` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `image_list` varbinary(255) DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_width` int(11) DEFAULT NULL,
  `position` int(11) NOT NULL DEFAULT '0',
  `is_new` tinyint(1) NOT NULL DEFAULT '0',
  `status_id` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `tr_style`;
CREATE TABLE `tr_style` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `background_type` tinyint(2) NOT NULL DEFAULT '0',
  `background_color` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `background_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `background_image_mobile` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `background_width_mobile` smallint(6) NOT NULL DEFAULT '0',
  `background_height` smallint(6) NOT NULL DEFAULT '0',
  `background_repeat_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `page_padding` smallint(6) NOT NULL DEFAULT '0',
  `page_padding_mobile` smallint(6) NOT NULL DEFAULT '0',
  `url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `views_count` int(11) NOT NULL DEFAULT '0',
  `status_id` smallint(3) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `geo_target` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `tr_style_assign`;
CREATE TABLE `tr_style_assign` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `style_id` int(11) NOT NULL,
  `page_key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `style_id` (`style_id`),
  CONSTRAINT `tr_style_assign_ibfk_1` FOREIGN KEY (`style_id`) REFERENCES `tr_style` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `tr_test_question`;
CREATE TABLE `tr_test_question` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `test_widget_id` int(11) DEFAULT NULL,
  `title` tinytext COLLATE utf8mb4_unicode_ci,
  `text` text COLLATE utf8mb4_unicode_ci,
  `answer` text COLLATE utf8mb4_unicode_ci,
  `grid_variant` smallint(6) NOT NULL DEFAULT '0',
  `correct_answer_text` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `wrong_answer_text` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `position` int(11) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `test_widget_id` (`test_widget_id`),
  CONSTRAINT `fk_test_question_widget_id` FOREIGN KEY (`test_widget_id`) REFERENCES `tr_test_widget` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `tr_test_result`;
CREATE TABLE `tr_test_result` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `test_widget_id` int(11) DEFAULT NULL,
  `title` tinytext COLLATE utf8mb4_unicode_ci,
  `text` text COLLATE utf8mb4_unicode_ci,
  `variants` text COLLATE utf8mb4_unicode_ci,
  `correct_count` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `test_widget_id` (`test_widget_id`),
  CONSTRAINT `fk_test_result_widget_id` FOREIGN KEY (`test_widget_id`) REFERENCES `tr_test_widget` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `tr_test_variant`;
CREATE TABLE `tr_test_variant` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `test_question_id` int(11) DEFAULT NULL,
  `text` text COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_correct` tinyint(1) NOT NULL DEFAULT '0',
  `position` int(11) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `test_question_id` (`test_question_id`),
  CONSTRAINT `fk_test_variant_question_id` FOREIGN KEY (`test_question_id`) REFERENCES `tr_test_question` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `tr_test_widget`;
CREATE TABLE `tr_test_widget` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` tinyint(1) NOT NULL DEFAULT '0',
  `title` tinytext COLLATE utf8mb4_unicode_ci,
  `text` text COLLATE utf8mb4_unicode_ci,
  `background_color` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `background_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `step2_background_color` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `step2_background_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `step3_background_color` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `step3_background_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `has_border` tinyint(1) NOT NULL DEFAULT '0',
  `border_color` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `step2_border_color` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `step3_border_color` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `step1_title_color` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `step1_title_has_border` tinyint(1) NOT NULL DEFAULT '0',
  `step1_title_border_color` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `step2_title_color` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `step2_title_has_border` tinyint(1) NOT NULL DEFAULT '0',
  `step2_title_border_color` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `step3_title_color` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `step3_title_has_border` tinyint(1) NOT NULL DEFAULT '0',
  `step3_title_border_color` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `step1_text_color` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `step2_text_color` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `step2_variants_text_color` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `step3_text_color` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `step1_button_text` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `step1_button_text_color` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `step1_button_color` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `step1_button_border_color` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `step1_button_shadow_color` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `step1_button_hover_color` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `step1_button_hover_shadow_color` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `step2_button_text` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `step2_button_text_color` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `step2_button_color` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `step2_button_border_color` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `step2_button_shadow_color` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `step2_button_hover_color` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `step2_button_hover_shadow_color` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `step3_button_text` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `step3_button_text_color` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `step3_button_color` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `step3_button_border_color` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `step3_button_shadow_color` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `step3_button_hover_color` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `step3_button_hover_shadow_color` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `correct_answer_color` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `wrong_answer_color` varchar(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `has_top_branding` tinyint(1) NOT NULL DEFAULT '0',
  `top_branding_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `top_branding_mobile_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `top_branding_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `has_bottom_branding` tinyint(1) NOT NULL DEFAULT '0',
  `bottom_branding_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bottom_branding_mobile_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bottom_branding_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `start_count` int(11) NOT NULL DEFAULT '0',
  `finish_count` int(11) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `tr_test_widget_user`;
CREATE TABLE `tr_test_widget_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `test_widget_id` int(11) NOT NULL,
  `test_result_id` int(11) DEFAULT NULL,
  `ip` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `browser` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `started_at` int(11) DEFAULT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id_test_widget_id` (`user_id`,`test_widget_id`),
  KEY `test_widget_id` (`test_widget_id`),
  KEY `test_result_id` (`test_result_id`),
  CONSTRAINT `tr_test_widget_user_ibfk_1` FOREIGN KEY (`test_widget_id`) REFERENCES `tr_test_widget` (`id`) ON DELETE CASCADE,
  CONSTRAINT `tr_test_widget_user_ibfk_2` FOREIGN KEY (`test_result_id`) REFERENCES `tr_test_result` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `tr_user`;
CREATE TABLE `tr_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_login_time` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `identifier` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` int(2) NOT NULL DEFAULT '0',
  `profile_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profile_img` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `user_oauth`;
CREATE TABLE `user_oauth` (
  `user_id` int(11) NOT NULL,
  `provider` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `identifier` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `profile_cache` text COLLATE utf8mb4_unicode_ci,
  `session_data` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`provider`,`identifier`),
  UNIQUE KEY `unic_user_id_name` (`user_id`,`provider`),
  KEY `oauth_user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- 2021-05-13 15:16:09
