--- 13.05.2019

ALTER TABLE `tr_style`
ADD `background_image_mobile` varchar(255) COLLATE 'utf8mb4_unicode_ci' NULL AFTER `background_image`,
ADD `page_padding_mobile` smallint(6) NOT NULL DEFAULT '0' AFTER `page_padding`;
