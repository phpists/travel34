--- 22.02.2019

ALTER TABLE `tr_post` ADD `hide_yandex_rss` tinyint(1) NOT NULL DEFAULT '0';
ALTER TABLE `tr_gtb_post` ADD `hide_yandex_rss` tinyint(1) NOT NULL DEFAULT '0';

--- 25.02.2019

ALTER TABLE `tr_post` ADD `date_new` datetime NULL AFTER `date`;
UPDATE `tr_post` a INNER JOIN `tr_post` b ON a.id = b.id SET a.`date_new` = CONCAT(b.`date`, ' 12:00:00');
ALTER TABLE `tr_post` DROP `date`, CHANGE `date_new` `date` datetime NULL AFTER `title`;

ALTER TABLE `tr_gtb_post` ADD `date_new` datetime NULL AFTER `date`;
UPDATE `tr_gtb_post` a INNER JOIN `tr_gtb_post` b ON a.id = b.id SET a.`date_new` = CONCAT(b.`date`, ' 12:00:00');
ALTER TABLE `tr_gtb_post` DROP `date`, CHANGE `date_new` `date` datetime NULL AFTER `title`;

ALTER TABLE `tr_post` ADD `yandex_rss_genre` varchar(10) NULL;

ALTER TABLE `tr_gtb_post` ADD `yandex_rss_genre` varchar(10) NULL;
