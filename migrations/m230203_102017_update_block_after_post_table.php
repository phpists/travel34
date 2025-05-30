<?php

class m230203_102017_update_block_after_post_table extends CDbMigration
{
    const TABLE_NAME = '{{block_after_post}}';

    public function up()
    {
        $this->addColumn(self::TABLE_NAME, 'background_color', 'varchar(7) DEFAULT \'#ffe04e\'');
        $this->addColumn(self::TABLE_NAME, 'button_color', 'varchar(7) DEFAULT \'#ffffff\'');
        $this->addColumn(self::TABLE_NAME, 'text_color', 'varchar(7) DEFAULT \'#333333\'');
        $this->addColumn(self::TABLE_NAME, 'button_text_color', 'varchar(7) DEFAULT \'#000000\'');
    }

    public function down()
    {
        $this->dropColumn(self::TABLE_NAME, 'background_color');
        $this->dropColumn(self::TABLE_NAME, 'button_color');
        $this->dropColumn(self::TABLE_NAME, 'text_color');
        $this->dropColumn(self::TABLE_NAME, 'button_text_color');
    }
}