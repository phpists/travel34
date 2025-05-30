--- 06.03.2019

DROP TABLE IF EXISTS `tr_test_result`;
DROP TABLE IF EXISTS `tr_test_variant`;
DROP TABLE IF EXISTS `tr_test_question`;
DROP TABLE IF EXISTS `tr_test_widget`;

CREATE TABLE `tr_test_widget` (
  `id` int(11) NOT NULL AUTO_INCREMENT,

  `type` tinyint(1) NOT NULL DEFAULT '0',

  `title` tinytext,
  `text` text,

  `background_color` varchar(6) DEFAULT NULL,
  `background_image` varchar(255) DEFAULT NULL,

  `step2_background_color` varchar(6) DEFAULT NULL,
  `step2_background_image` varchar(255) DEFAULT NULL,

  `step3_background_color` varchar(6) DEFAULT NULL,
  `step3_background_image` varchar(255) DEFAULT NULL,

  `has_border` tinyint(1) NOT NULL DEFAULT '0',
  `border_color` varchar(6) DEFAULT NULL,

  `step1_title_color` varchar(6) DEFAULT NULL,
  `step1_title_has_border` tinyint(1) NOT NULL DEFAULT '0',
  `step1_title_border_color` varchar(6) DEFAULT NULL,

  `step2_title_color` varchar(6) DEFAULT NULL,
  `step2_title_has_border` tinyint(1) NOT NULL DEFAULT '0',
  `step2_title_border_color` varchar(6) DEFAULT NULL,

  `step3_title_color` varchar(6) DEFAULT NULL,
  `step3_title_has_border` tinyint(1) NOT NULL DEFAULT '0',
  `step3_title_border_color` varchar(6) DEFAULT NULL,

  `step1_button_text` varchar(255) DEFAULT NULL,
  `step1_button_color` varchar(6) DEFAULT NULL,
  `step1_button_border_color` varchar(6) DEFAULT NULL,
  `step1_button_shadow_color` varchar(6) DEFAULT NULL,
  `step1_button_hover_color` varchar(6) DEFAULT NULL,
  `step1_button_hover_shadow_color` varchar(6) DEFAULT NULL,

  `step2_button_text` varchar(255) DEFAULT NULL,
  `step2_button_color` varchar(6) DEFAULT NULL,
  `step2_button_border_color` varchar(6) DEFAULT NULL,
  `step2_button_shadow_color` varchar(6) DEFAULT NULL,
  `step2_button_hover_color` varchar(6) DEFAULT NULL,
  `step2_button_hover_shadow_color` varchar(6) DEFAULT NULL,

  `step3_button_text` varchar(255) DEFAULT NULL,
  `step3_button_color` varchar(6) DEFAULT NULL,
  `step3_button_border_color` varchar(6) DEFAULT NULL,
  `step3_button_shadow_color` varchar(6) DEFAULT NULL,
  `step3_button_hover_color` varchar(6) DEFAULT NULL,
  `step3_button_hover_shadow_color` varchar(6) DEFAULT NULL,

  `has_top_branding` tinyint(1) NOT NULL DEFAULT '0',
  `top_branding_image` varchar(255) DEFAULT NULL,
  `top_branding_mobile_image` varchar(255) DEFAULT NULL,
  `top_branding_url` varchar(255) DEFAULT NULL,

  `has_bottom_branding` tinyint(1) NOT NULL DEFAULT '0',
  `bottom_branding_image` varchar(255) DEFAULT NULL,
  `bottom_branding_mobile_image` varchar(255) DEFAULT NULL,
  `bottom_branding_url` varchar(255) DEFAULT NULL,

  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `tr_test_question` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `test_widget_id` int(11) DEFAULT NULL,

  `title` tinytext,
  `text` text,
  `grid_variant` smallint(6) NOT NULL DEFAULT '0',
  `correct_answer_text` varchar(255) DEFAULT NULL,
  `wrong_answer_text` varchar(255) DEFAULT NULL,
  `position` int(11) NOT NULL DEFAULT '0',

  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `test_widget_id` (`test_widget_id`),
  CONSTRAINT `fk_test_question_widget_id` FOREIGN KEY (`test_widget_id`) REFERENCES `tr_test_widget` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `tr_test_variant` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `test_question_id` int(11) DEFAULT NULL,

  `text` text,
  `image` varchar(255) DEFAULT NULL,
  `is_correct` tinyint(1) NOT NULL DEFAULT '0',
  `position` int(11) NOT NULL DEFAULT '0',

  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `test_question_id` (`test_question_id`),
  CONSTRAINT `fk_test_variant_question_id` FOREIGN KEY (`test_question_id`) REFERENCES `tr_test_question` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `tr_test_result` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `test_widget_id` int(11) DEFAULT NULL,

  `title` tinytext,
  `text` text,
  `variants` text,
  `correct_count` int(11) DEFAULT NULL,

  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `test_widget_id` (`test_widget_id`),
  CONSTRAINT `fk_test_result_widget_id` FOREIGN KEY (`test_widget_id`) REFERENCES `tr_test_widget` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE `tr_test_widget`
ADD `step2_border_color` varchar(6) COLLATE 'utf8mb4_unicode_ci' NULL AFTER `border_color`,
ADD `step3_border_color` varchar(6) COLLATE 'utf8mb4_unicode_ci' NULL AFTER `step2_border_color`;

ALTER TABLE `tr_test_question`
ADD `answer` text COLLATE 'utf8mb4_unicode_ci' NULL AFTER `text`;

ALTER TABLE `tr_test_widget`
ADD `step1_text_color` varchar(6) COLLATE 'utf8mb4_unicode_ci' NULL AFTER `step3_title_border_color`,
ADD `step2_text_color` varchar(6) COLLATE 'utf8mb4_unicode_ci' NULL AFTER `step1_text_color`,
ADD `step3_text_color` varchar(6) COLLATE 'utf8mb4_unicode_ci' NULL AFTER `step2_text_color`,
ADD `step1_button_text_color` varchar(6) COLLATE 'utf8mb4_unicode_ci' NULL AFTER `step1_button_text`,
ADD `step2_button_text_color` varchar(6) COLLATE 'utf8mb4_unicode_ci' NULL AFTER `step2_button_text`,
ADD `step3_button_text_color` varchar(6) COLLATE 'utf8mb4_unicode_ci' NULL AFTER `step3_button_text`;

ALTER TABLE `tr_test_widget`
ADD `correct_answer_color` varchar(6) COLLATE 'utf8mb4_unicode_ci' NULL AFTER `step3_button_hover_shadow_color`,
ADD `wrong_answer_color` varchar(6) COLLATE 'utf8mb4_unicode_ci' NULL AFTER `correct_answer_color`;

ALTER TABLE `tr_test_widget`
ADD `step2_variants_text_color` varchar(6) COLLATE 'utf8mb4_unicode_ci' NULL AFTER `step2_text_color`;
