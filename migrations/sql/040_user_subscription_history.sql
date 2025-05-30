CREATE TABLE `tr_user_subscription_history`
(
    `id`                int(11)      NOT NULL AUTO_INCREMENT,
    `user_id`           bigint null,
    `user_subscription_id` bigint null,
    `subscription_id`   bigint not null,
    `status_id`         int      default 1,
    `date_start`        datetime DEFAULT NULL,
    `date_end`          datetime DEFAULT NULL,
    `created_at`        datetime DEFAULT NULL,
    `updated_at`        datetime DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;


