<?php

class m230207_102833_update_block_after_post_table extends CDbMigration
{
    const TABLE_NAME = '{{block_after_post}}';

    public function up()
    {
        $this->addColumn(self::TABLE_NAME, 'button_hover_color', 'varchar(7) DEFAULT \'#f9e586\'');
    }

    public function down()
    {
        $this->dropColumn(self::TABLE_NAME, 'button_hover_color');
    }
}