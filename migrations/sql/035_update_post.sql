-- 30.08.2024

ALTER TABLE `tr_post` ADD `status_paywall` tinyint(1) NOT NULL DEFAULT '0' after status_id;

/*0 - не установлен paywall*/
/*1 - установлен paywall*/

ALTER TABLE `tr_post` ADD `text_paywall` longtext null after text;