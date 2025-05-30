<?php

class m210513_150029_gtu extends CDbMigration
{
    public function up()
    {
        $options = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';

        $this->createTable('{{gtu_rubric}}', [
            'id' => 'pk',
            'url' => 'varchar(100) NOT NULL',
            'title' => 'string NOT NULL',
            'title_ru' => 'string NOT NULL',
            'title_en' => 'string NOT NULL',
            'position' => "int NOT NULL DEFAULT '0'",
            'in_todo_list' => "boolean NOT NULL DEFAULT '0'",
            'hide_in_menu' => "boolean NOT NULL DEFAULT '0'",
            'hide_in_menu_ru' => "boolean NOT NULL DEFAULT '0'",
            'hide_in_menu_en' => "boolean NOT NULL DEFAULT '0'",
            'status_id' => "boolean NOT NULL DEFAULT '1'",
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ], $options);
        $this->createIndex('url', '{{gtu_rubric}}', ['url'], true);

        $this->createTable('{{gtu_post}}', [
            'id' => 'pk',
            'author_id' => 'integer',
            'gtu_rubric_id' => 'integer',
            'type_id' => "tinyint NOT NULL DEFAULT '1'",
            'language' => "varchar(6) NOT NULL DEFAULT ''",

            'url' => 'varchar(100) NOT NULL',

            'title' => 'string NOT NULL',

            'page_title' => 'string',
            'page_keywords' => 'string',
            'page_description' => 'text',
            'page_og_image' => 'string',

            'date' => 'datetime',

            'image' => 'string',

            'is_top' => "boolean NOT NULL DEFAULT '0'",
            'image_top' => 'string',

            'is_big_top' => "boolean NOT NULL DEFAULT '0'",
            'is_home_big_top' => "boolean NOT NULL DEFAULT '0'",
            'image_big_top' => 'string',

            'is_supertop' => "boolean NOT NULL DEFAULT '0'",
            'image_supertop' => 'string',

            'is_home_supertop' => "boolean NOT NULL DEFAULT '0'",
            'image_home_supertop' => 'string',

            'is_image_in_post' => "boolean NOT NULL DEFAULT '0'",
            'image_in_post' => 'string',

            'summary' => 'text',
            'text' => 'longtext',

            'background_color' => 'varchar(6)',
            'background_image' => 'string',

            'hide_banners' => "boolean NOT NULL DEFAULT '0'",
            'hide_styles' => "boolean NOT NULL DEFAULT '0'",

            'hide_yandex_rss' => "boolean NOT NULL DEFAULT '0'",
            'yandex_rss_genre' => 'varchar(10)',
            'hide_yandex_zen' => "boolean NOT NULL DEFAULT '0'",
            'yandex_zen_adult' => "boolean NOT NULL DEFAULT '0'",
            'yandex_zen_categories' => 'text',

            'views_count' => "integer NOT NULL DEFAULT '0'",

            'related_posts' => 'string',

            'status_id' => "boolean NOT NULL DEFAULT '0'",
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ], $options);
        $this->createIndex('url', '{{gtu_post}}', ['url'], true);
        $this->createIndex('language_url', '{{gtu_post}}', ['language', 'url']);
        $this->addForeignKey('fk_gtu_post_author_id', '{{gtu_post}}', 'author_id', '{{author}}', 'id', 'SET NULL');
        $this->addForeignKey('fk_gtu_post_gtu_rubric_id', '{{gtu_post}}', 'gtu_rubric_id', '{{gtu_rubric}}', 'id', 'SET NULL');

        $this->createTable('{{gtu_banner}}', [
            'id' => 'pk',
            'banner_place_id' => "int NOT NULL DEFAULT '0'",
            'title' => 'varchar(45) NOT NULL',
            'url' => 'string NOT NULL',
            'open_new_tab' => "boolean NOT NULL DEFAULT '0'",
            'image' => 'string',
            'image_mobile' => 'string',
            'grid_position' => "int NOT NULL DEFAULT '0'",
            'language' => "varchar(6) NOT NULL DEFAULT ''",
            'status_id' => "boolean NOT NULL DEFAULT '0'",
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ], $options);
    }

    public function down()
    {
        $this->dropForeignKey('fk_gtu_post_gtu_rubric_id', '{{gtu_post}}');
        $this->dropForeignKey('fk_gtu_post_author_id', '{{gtu_post}}');
        $this->dropTable('{{gtu_post}}');
        $this->dropTable('{{gtu_rubric}}');
    }
}