CREATE TABLE `tr_user_subscription`
(
    `id`                int(11) NOT NULL AUTO_INCREMENT,
    `user_id`           bigint null,
    `subscription_id`   bigint not null,
    `subscription_code` varchar(255) null,
    `customer_id`       varchar null,
    `payment_intent`    varchar null,
    `payment_method_id` varchar null,
    `status_id`         int      default 1,
    `subscription_type` int      default 1,
    `date_start`        datetime DEFAULT NULL,
    `date_end`          datetime DEFAULT NULL,
    `position`          int      default 1,
    `is_active`          int      default 1,
    `is_active`          int      default 1,
    `created_at`        datetime DEFAULT NULL,
    `updated_at`        datetime DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;


