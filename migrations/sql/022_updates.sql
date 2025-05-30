--- 10.01.2018

ALTER TABLE `tr_post` ADD `page_og_image` varchar(255) COLLATE 'utf8mb4_unicode_ci' NULL AFTER `page_keywords`;
ALTER TABLE `tr_gtb_post` ADD `page_og_image` varchar(255) COLLATE 'utf8mb4_unicode_ci' NULL AFTER `page_description`;

--- 12.01.2018

ALTER TABLE `tr_post`
DROP `is_home_supertop`;

ALTER TABLE `tr_post` ADD `hide_comments` tinyint(1) NOT NULL DEFAULT '0' AFTER `hide_banners`;
ALTER TABLE `tr_gtb_post` ADD `hide_comments` tinyint(1) NOT NULL DEFAULT '0' AFTER `hide_banners`;

ALTER TABLE `tr_post`
ADD `background_color` varchar(6) COLLATE 'utf8mb4_unicode_ci' NULL,
ADD `background_image` varchar(255) COLLATE 'utf8mb4_unicode_ci' NULL AFTER `background_color`;

ALTER TABLE `tr_gtb_post`
ADD `background_color` varchar(6) COLLATE 'utf8mb4_unicode_ci' NULL,
ADD `background_image` varchar(255) COLLATE 'utf8mb4_unicode_ci' NULL AFTER `background_color`;

ALTER TABLE `tr_gtb_post` ADD `image_home_supertop` varchar(255) COLLATE 'utf8mb4_unicode_ci' NULL AFTER `image_supertop`;

--- 16.01.2018

ALTER TABLE `tr_post` ADD `is_new` tinyint(1) NOT NULL DEFAULT '1';
UPDATE `tr_post` SET `is_new` = 0;

ALTER TABLE `tr_gtb_post` ADD `is_new` tinyint(1) NOT NULL DEFAULT '1';
UPDATE `tr_gtb_post` SET `is_new` = 0;

--- 23.02.2018

ALTER TABLE `tr_banner` ADD `code` text COLLATE 'utf8mb4_unicode_ci' NULL AFTER `content`;

ALTER TABLE `tr_banner`
CHANGE `banner_place_id` `banner_place_id` int(11) NULL AFTER `id`,
CHANGE `status_id` `status_id` tinyint(1) NULL AFTER `code`,
CHANGE `geo_target` `geo_target` varchar(255) COLLATE 'utf8mb4_unicode_ci' NULL AFTER `status_id`;

ALTER TABLE `tr_banner` ADD `banner_system` int(11) NOT NULL DEFAULT '0' AFTER `banner_place_id`;

--- 24.08.2018

ALTER TABLE `tr_post` ADD `hide_styles` tinyint(1) NOT NULL DEFAULT '0' AFTER `hide_comments`;
ALTER TABLE `tr_gtb_post` ADD `hide_styles` tinyint(1) NOT NULL DEFAULT '0' AFTER `hide_comments`;
