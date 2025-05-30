<?php

class m210513_205033_block_attrs extends CDbMigration
{
    public function up()
    {
        $this->addColumn('{{block}}', 'status_id', "boolean NOT NULL DEFAULT '1'");
        $this->addColumn('{{block}}', 'created_at', 'datetime');
        $this->addColumn('{{block}}', 'updated_at', 'datetime');
    }

    public function down()
    {
        $this->dropColumn('{{block}}', 'status_id');
        $this->dropColumn('{{block}}', 'created_at');
        $this->dropColumn('{{block}}', 'updated_at');
    }
}