<?php

class m221206_092828__ad_columns_to_banner_table extends CDbMigration
{
    const TABLE_NAME = '{{banner}}';

    public function up()
    {
        $this->addColumn(self::TABLE_NAME, 'open_new_tab', 'boolean NOT NULL DEFAULT 0');
        $this->addColumn(self::TABLE_NAME, 'url', 'VARCHAR(2048) DEFAULT NULL');
        $this->addColumn(self::TABLE_NAME, 'image', 'VARCHAR(2048) DEFAULT NULL');
    }

    public function down()
    {
        $this->dropColumn(self::TABLE_NAME, 'open_new_tab');
        $this->dropColumn(self::TABLE_NAME, 'url');
        $this->dropColumn(self::TABLE_NAME, 'image');
    }

    /*
    // Use safeUp/safeDown to do migration with transaction
    public function safeUp()
    {
    }
    public function safeDown()
    {
    }
    */
}