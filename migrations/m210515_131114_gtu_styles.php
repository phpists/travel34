<?php

class m210515_131114_gtu_styles extends CDbMigration
{
    public function up()
    {
        $gtu_post = Yii::app()->db->createCommand()
            ->select('id, gtu_post_id')
            ->from('{{post}}')
            ->where('is_gtu_post = 1')
            ->queryAll();
        $gtu_post = CHtml::listData($gtu_post, 'id', 'gtu_post_id');

        $assigns = Yii::app()->db->createCommand()
            ->select('style_id, item_id')
            ->from('{{style_assign}}')
            ->where('page_key = :sa_page_key', [':sa_page_key' => Style::PAGE_KEY_POST])
            ->andWhere(['in', 'item_id', array_keys($gtu_post)])
            ->queryAll();

        $gtu_assigns = Yii::app()->db->createCommand()
            ->select('item_id')
            ->from('{{style_assign}}')
            ->where('page_key = :sa_page_key', [':sa_page_key' => Style::PAGE_KEY_GTU_POST])
            ->queryColumn();

        foreach ($assigns as $assign) {
            if (isset($gtu_post[$assign['item_id']])) {
                $gtu_id = $gtu_post[$assign['item_id']];
                if (isset($gtu_assigns[$gtu_id])) {
                    continue;
                }
                $this->insert('{{style_assign}}', [
                    'style_id' => $assign['style_id'],
                    'page_key' => Style::PAGE_KEY_GTU_POST,
                    'item_id' => $gtu_id,
                ]);
            }
        }
    }

    public function down()
    {
    }
}