ALTER TABLE `tr_special_project`
ADD `background_type_id` tinyint(2) NOT NULL DEFAULT '0',
ADD `bg_image` varchar(255) NULL AFTER `background_type_id`,
ADD `bg_image_repeat` varchar(255) NULL AFTER `bg_image`,
ADD `bg_image_height` smallint NULL AFTER `bg_image_repeat`,
ADD `bg_image_padding_top` smallint NULL AFTER `bg_image_height`,
ADD `background_url` varchar(255) NULL AFTER `bg_image_padding_top`;