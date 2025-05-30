<?php

class m221201_122412_add_access_by_link_column extends CDbMigration
{
    public function up()
    {
        $this->addColumn('{{post}}', 'access_by_link', 'boolean NOT NULL DEFAULT 0');
        $this->addColumn('{{gtu_post}}', 'access_by_link', 'boolean NOT NULL DEFAULT 0');
        $this->addColumn('{{gtb_post}}', 'access_by_link', 'boolean NOT NULL DEFAULT 0');
    }

    public function down()
    {
        $this->dropColumn('{{post}}', 'access_by_link');
        $this->dropColumn('{{gtu_post}}', 'access_by_link');
        $this->dropColumn('{{gtb_post}}', 'access_by_link');
    }
}