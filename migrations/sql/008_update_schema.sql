ALTER TABLE `tr_post`
CHANGE `url` `url` varchar(255) NOT NULL DEFAULT '' AFTER `author_id`,
CHANGE `title` `title` varchar(255) NOT NULL AFTER `url`,
CHANGE `image` `image` varchar(255) NULL AFTER `date`,
CHANGE `image_big_post` `image_big_post` varchar(255) NULL AFTER `image`,
CHANGE `text` `text` longtext NULL AFTER `image_big_post`,
CHANGE `summary` `summary` mediumtext NULL AFTER `status_id`,
CHANGE `custom_icon` `custom_icon` varchar(255) NULL AFTER `views_count`,
CHANGE `image_top` `image_top` varchar(255) NULL AFTER `updated_at`,
CHANGE `image_news` `image_news` varchar(255) NULL AFTER `image_top`,
CHANGE `page_title` `page_title` varchar(255) NOT NULL DEFAULT '' AFTER `is_home_top`,
CHANGE `page_keywords` `page_keywords` varchar(255) NOT NULL DEFAULT '' AFTER `page_title`,
CHANGE `news_link` `news_link` varchar(255) NULL AFTER `page_keywords`,
CHANGE `news_link_title` `news_link_title` varchar(255) NULL AFTER `news_link`,
CHANGE `description` `description` text NULL AFTER `news_link_title`,
CHANGE `image_bkg` `image_bkg` varchar(255) NULL AFTER `description`,
CHANGE `image_bkg_repeat` `image_bkg_repeat` varchar(255) NULL AFTER `image_bkg`,
CHANGE `background_url` `background_url` varchar(255) NULL AFTER `background_type_id`,
CHANGE `related_posts` `related_posts` varchar(255) NULL AFTER `is_home_supertop`,
COLLATE 'utf8_general_ci';

ALTER TABLE `tr_post_city_assignment`
COLLATE 'utf8_general_ci';

ALTER TABLE `tr_post_country_assignment`
COLLATE 'utf8_general_ci';

ALTER TABLE `tr_style`
CHANGE `title` `title` varchar(255) NOT NULL AFTER `id`,
CHANGE `image_bkg` `image_bkg` varchar(255) NULL AFTER `status_id`,
CHANGE `image_bkg_height` `image_bkg_height` varchar(255) NULL AFTER `rubric_id`,
CHANGE `background_url` `background_url` varchar(255) NULL AFTER `image_bkg_height`,
CHANGE `image_bkg_repeat` `image_bkg_repeat` varchar(255) NULL AFTER `image_bkg_padding_top`;
