CREATE TABLE `tr_user_subscription_gift`
(
    `id`                    int(11) NOT NULL AUTO_INCREMENT,
    `user_subscription_id`  bigint,
    `user_id`               bigint  null,
    `user_email`            varchar(255),
    `gift_email`            varchar(255),
    `gift_date`             date,
    `gift_time`             time,
    `status_id`             int          default 0,
    `type_id`               text          default 0,
    `code`                  varchar(100) default 0,
    `expiry_date`           datetime     DEFAULT NULL,
    `number_activations`    int          default 0,
    `available_activations` int          default 0,
    `date_create`            datetime     DEFAULT NULL,
    `created_at`            datetime     DEFAULT NULL,
    `updated_at`            datetime     DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8;


