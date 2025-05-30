<?php

class m221129_155422_gtb_add_promo_link_for_be_lang extends CDbMigration
{
    public function up()
    {
        $this->insert('{{block}}', [
            'name' => 'gtb_promo_link_supertop_be',
            'description' => 'Ссылка на промо материал с супертопом (BY)',
            'content' => '<div class="special-link">
    <a href="https://trevel34.loc/gotobelarus/be/post/minsk"><img src="/themes/travel/images/victory_01.svg" width="29" alt=""><span>Minsk Guide</span></a>
</div>',
            'status_id' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        $this->insert('{{block}}', [
            'name' => 'gtb_promo_link_be',
            'description' => 'Ссылка на промо материал (BY)',
            'content' => '<div class="special-link">
    <a href="https://trevel34.loc/gotobelarus/be/post/minsk"><img src="/themes/travel/images/victory_01.svg" width="29" alt=""><span>Minsk Guide</span></a>
</div>',
            'status_id' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }

    public function down()
    {
        echo "m221129_155422_add_promo_link_for_be_lang does not support migration down.\n";
        return false;
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