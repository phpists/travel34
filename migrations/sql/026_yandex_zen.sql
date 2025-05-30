ALTER TABLE `tr_post`
ADD `hide_yandex_zen` tinyint(1) NOT NULL DEFAULT '0',
ADD `yandex_zen_adult` tinyint(1) NOT NULL DEFAULT '0' AFTER `hide_yandex_zen`,
ADD `yandex_zen_categories` text COLLATE 'utf8mb4_unicode_ci' NULL AFTER `yandex_zen_adult`;

ALTER TABLE `tr_gtb_post`
ADD `hide_yandex_zen` tinyint(1) NOT NULL DEFAULT '0',
ADD `yandex_zen_adult` tinyint(1) NOT NULL DEFAULT '0' AFTER `hide_yandex_zen`,
ADD `yandex_zen_categories` text COLLATE 'utf8mb4_unicode_ci' NULL AFTER `yandex_zen_adult`;
