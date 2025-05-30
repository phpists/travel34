CREATE TABLE `tr_subscription`
(
    `id`          int(11) NOT NULL AUTO_INCREMENT,
    `title`       varchar(255) NOT NULL,
    `description` text NULL,
    `price`       float NULL,
    `old_price`   float NULL,
    `position` integer null,
    `status_id` integer null,
    `product_id` varchar(255),
    `month` integer null,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
