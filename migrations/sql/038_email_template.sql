CREATE TABLE `tr_email_template`
(
    `id`          int(11) NOT NULL AUTO_INCREMENT,
    `subject`       varchar(255) NOT NULL,
    `description` text NULL,
    `created_at` datetime DEFAULT NULL,
    `updated_at` datetime DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
