CREATE TABLE `tr_promo_codes`
(
    `id`                    int(11) NOT NULL AUTO_INCREMENT,
    `promo_code`            varchar(255),
    `status_id`             int      default 1,
    `date_create`           datetime DEFAULT NULL,
    `type_id`               text     default 1,
    `discount`              int      default null,
    `number_activations`    int      default null,
    `available_activations` int      default null,
    `date_active`           datetime DEFAULT NULL,
    `created_at`            datetime DEFAULT NULL,
    `updated_at`            datetime DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;
