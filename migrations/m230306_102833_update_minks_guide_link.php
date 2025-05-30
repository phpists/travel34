<?php

class m230306_102833_update_minks_guide_link extends CDbMigration
{
    const TABLE_NAME = '{{block}}';

    public function up()
    {
        if ($block = Block::model()->findByAttributes(['name' => 'gtb_promo_link_be'])) {
            $block->content = '<div class="special-link">
    <a href="https://trevel34.loc/gotobelarus/be/post/minsk"><img src="/themes/travel/images/victory_02.svg" width="29" alt=""><span>Minsk Guide</span></a>
</div>';
            $block->save();
        }
    }

    public function down()
    {
        if ($block = Block::model()->findByAttributes(['name' => 'gtb_promo_link_be'])) {
            $block->content = '<div class="special-link">
    <a href="https://trevel34.loc/gotobelarus/be/post/minsk"><img src="/themes/travel/images/victory_01.svg" width="29" alt=""><span>Minsk Guide</span></a>
</div>';
            $block->save();
        }
    }
}