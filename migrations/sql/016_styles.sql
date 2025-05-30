ALTER TABLE `tr_style`
CHANGE `background_type_id` `background_type` tinyint(2) NOT NULL DEFAULT '0' AFTER `page_key`,
CHANGE `image_bkg` `background_image` varchar(255) NULL AFTER `background_type`,
CHANGE `image_bkg_height` `background_height` smallint(6) NOT NULL DEFAULT '0' AFTER `background_image`,
CHANGE `image_bkg_repeat` `background_repeat_image` varchar(255) NULL AFTER `background_height`,
CHANGE `image_bkg_padding_top` `page_padding` smallint(6) NOT NULL DEFAULT '0' AFTER `background_repeat_image`,
CHANGE `background_url` `url` varchar(255) NULL AFTER `page_padding`,
CHANGE `rubric_id` `item_id` int(11) NULL AFTER `page_key`;

ALTER TABLE `tr_style` ADD `background_color` varchar(10) NULL AFTER `background_type`;

ALTER TABLE `tr_style` CHANGE `page_key` `page_key` varchar(255) NOT NULL AFTER `title`;

ALTER TABLE `tr_rubric`
DROP `background_posts_type_id`,
DROP `image_posts_bkg`,
DROP `image_posts_repeat_bkg`,
DROP `background_posts_url`;

ALTER TABLE `tr_page`
DROP `background_type_id`,
DROP `bg_image`,
DROP `bg_image_repeat`,
DROP `bg_image_height`,
DROP `bg_image_padding_top`,
DROP `background_url`;

ALTER TABLE `tr_special_project`
DROP `background_type_id`,
DROP `bg_image`,
DROP `bg_image_repeat`,
DROP `bg_image_height`,
DROP `bg_image_padding_top`,
DROP `background_url`;

UPDATE `tr_style` SET `page_key` = 'main' WHERE `page_key` = 1;
UPDATE `tr_style` SET `page_key` = 'rubric' WHERE `page_key` = 2;

-- WARNING! Drop only after "php yiic tools movebg"

ALTER TABLE `tr_post`
DROP `image_bkg`,
DROP `image_bkg_repeat`,
DROP `background_type_id`,
DROP `background_url`,
DROP `image_bkg_height`,
DROP `image_bkg_padding_top`;