CREATE TABLE `tr_user_collection` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `collection_id` integer(11) NULL,
        `post_id` integer(11) NOT NULL,
        `user_id` integer(11) NOT NULL,
        `created_at` datetime DEFAULT NULL,
        `updated_at` datetime DEFAULT NULL,
        PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;