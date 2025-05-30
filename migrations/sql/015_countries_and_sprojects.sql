ALTER TABLE `tr_banner` ADD `geo_target` varchar(255) NULL;
ALTER TABLE `tr_post` ADD `geo_target` varchar(255) NULL;
ALTER TABLE `tr_style` ADD `geo_target` varchar(255) NULL;

ALTER TABLE `tr_special_project`
ADD `description` text NULL AFTER `title`,
ADD `image_list` varbinary(255) NULL AFTER `description`;
