ALTER TABLE `tr_special_project` ADD `image` varchar(255) NULL AFTER `title`;
ALTER TABLE `tr_special_project`
CHANGE `position` `position` int(11) NOT NULL DEFAULT '0' AFTER `image`,
ADD `is_new` tinyint(1) NOT NULL DEFAULT '0' AFTER `position`;