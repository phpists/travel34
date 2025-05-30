<?php

class m220209_073832_places extends CDbMigration
{
    public function up()
    {
        $options = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';

        $this->createTable('{{gtu_place}}', [
            'id' => 'pk',
            'author_id' => 'integer',
            'lat' => 'float NOT NULL',
            'lng' => 'float NOT NULL',
            'type' => "string NOT NULL",
            'language' => "varchar(6) NOT NULL DEFAULT ''",

            'title' => 'string NOT NULL',
            'description' => 'text',
            'images' => 'text',

            'related_posts' => 'string',
            'related_posts_gtu' => 'string',
            'related_posts_gtb' => 'string',

            'status_id' => "boolean NOT NULL DEFAULT '0'",
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ], $options);

        $this->createTable('{{gtb_place}}', [
            'id' => 'pk',
            'author_id' => 'integer',
            'lat' => 'float NOT NULL',
            'lng' => 'float NOT NULL',
            'type' => "string NOT NULL",
            'language' => "varchar(6) NOT NULL DEFAULT ''",

            'title' => 'string NOT NULL',
            'description' => 'text',
            'images' => 'text',

            'related_posts' => 'string',
            'related_posts_gtu' => 'string',
            'related_posts_gtb' => 'string',

            'status_id' => "boolean NOT NULL DEFAULT '0'",
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ], $options);
    }

    public function down()
    {
        $this->dropTable('{{gtu_place}}');
        $this->dropTable('{{gtb_place}}');
    }
}