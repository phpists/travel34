CREATE TABLE `tr_user_promo_codes`
(
    `id`              int(11) NOT NULL AUTO_INCREMENT,
    `user_id`         int,
    `promo_code_id`   int,
    `subscription_id` int,
    `price_discount`        float null ,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;


