<?php

class m221130_142609_create_post_footer_block_table extends CDbMigration
{
    const TABLE_NAME = '{{block_after_post}}';

    public function up()
    {
        $options = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';

        $this->createTable(self::TABLE_NAME, [
            'id' => 'pk',
            'title' => 'varchar(255) DEFAULT NULL',
            'text' => 'text  DEFAULT NULL',
            'image' => 'varchar(2048)  DEFAULT NULL',
            'button_url' => 'varchar(2048)  DEFAULT NULL',
            'button_text' => 'varchar(255)  DEFAULT NULL',
        ], $options);


        $this->insert(self::TABLE_NAME, [
            'title' => 'ПОДДЕРЖИ РЕДАКЦИЮ 34TRAVEL НА PATREON!',
            'text' => 'Уже больше года мы делаем журнал о путешествиях в мире, где путешествия стали настоящим квестом. Мы очень рады, что ты остаешься с нами и продолжаешь читать материалы 34travel. Будем благодарны за support в эти сложные времена.',
            'button_text' => 'ПОДПИСАТЬСЯ НА PATREON',
            'button_url' => 'https://www.patreon.com/34travel',
        ]);
    }

    public function down()
    {
        $this->dropTable(self::TABLE_NAME);
    }
}