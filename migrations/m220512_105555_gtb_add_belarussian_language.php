<?php

class m220512_105555_gtb_add_belarussian_language extends CDbMigration
{
	public function up()
	{
        $this->addColumn('{{gtb_rubric}}', 'title_be', "string NOT NULL AFTER title_en");
        $this->addColumn('{{gtb_rubric}}', 'description_be', "text AFTER description_en");
        $this->addColumn('{{gtb_rubric}}', 'hide_in_menu_be', "boolean NOT NULL DEFAULT '0' AFTER hide_in_menu_en");
	}

	public function down()
	{
		$this->dropColumn('{{gtb_rubric}}', 'hide_in_menu_be');
		$this->dropColumn('{{gtb_rubric}}', 'description_be');
		$this->dropColumn('{{gtb_rubric}}', 'title_be');
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