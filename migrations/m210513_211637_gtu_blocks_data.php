<?php

class m210513_211637_gtu_blocks_data extends CDbMigration
{
    public function up()
    {
        $blocks = Yii::app()->db->createCommand()
            ->select('name')
            ->from('{{block}}')
            ->where(['like', 'name', 'gtu_%'])
            ->queryColumn();

        if (!in_array('gtu_slogan', $blocks)) {
            echo "add gtu_slogan\n";
            $this->insert('{{block}}', [
                'name' => 'gtu_slogan',
                'description' => 'Слоган на GTU',
                'content' => "<p><span>BEST OF UKRAINE</span></p>\n<p><span>PROJECT BY trevel34.loc</span></p>",
                'status_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
        if (!in_array('gtu_slogan_ru', $blocks)) {
            echo "add gtu_slogan_ru\n";
            $this->insert('{{block}}', [
                'name' => 'gtu_slogan_ru',
                'description' => 'Слоган на GTU (RU)',
                'content' => "<p><span>BEST OF UKRAINE</span></p>\n<p><span>PROJECT BY trevel34.loc</span></p>",
                'status_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
        if (!in_array('gtu_slogan_en', $blocks)) {
            echo "add gtu_slogan_en\n";
            $this->insert('{{block}}', [
                'name' => 'gtu_slogan_en',
                'description' => 'Слоган на GTU (EN)',
                'content' => "<p><span>BEST OF UKRAINE</span></p>\n<p><span>PROJECT BY trevel34.loc</span></p>",
                'status_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }

        if (!in_array('gtu_footer_pages', $blocks)) {
            echo "add gtu_footer_pages\n";
            $this->insert('{{block}}', [
                'name' => 'gtu_footer_pages',
                'description' => 'Ссылки на страницы в футере на GTU',
                'content' => '<li><a href="/page/about-us"><span>Про проєкт</span></a></li>
<li><a href="/page/contacts"><span>Контакти</span></a></li>
<li><a href="/page/advertisement"><span>Рекламодавцям</span></a></li>
<li><a href="/page/disclaimer"><span>Правова інформація</span></a></li>
<!--<li><a href=""><span>Як стати автором</span></a></li>-->',
                'status_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
        if (!in_array('gtu_footer_pages_ru', $blocks)) {
            echo "add gtu_footer_pages_ru\n";
            $this->insert('{{block}}', [
                'name' => 'gtu_footer_pages_ru',
                'description' => 'Ссылки на страницы в футере на GTU (RU)',
                'content' => '<li><a href="/page/about-us"><span>О проекте</span></a></li>
<li><a href="/page/contacts"><span>Контакты</span></a></li>
<li><a href="/page/advertisement"><span>Рекламодателям</span></a></li>
<li><a href="/page/disclaimer"><span>Правовая информация</span></a></li>',
                'status_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
        if (!in_array('gtu_footer_pages_en', $blocks)) {
            echo "add gtu_footer_pages_en\n";
            $this->insert('{{block}}', [
                'name' => 'gtu_footer_pages_en',
                'description' => 'Ссылки на страницы в футере на GTU (EN)',
                'content' => '',
                'status_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }

        if (!in_array('gtu_social', $blocks)) {
            echo "add gtu_social\n";
            $this->insert('{{block}}', [
                'name' => 'gtu_social',
                'description' => 'Соц. ссылки в футере на GTU',
                'content' => '<li><a href="https://www.instagram.com/34travel" target="_blank">Instagram</a></li>
<li><a href="https://www.facebook.com/34travel" target="_blank">Facebook</a></li>
<li><a href="https://vk.com/34travel" target="_blank">Vkontakte</a></li>
<li><a href="https://telegram.me/travel34" target="_blank">Telegram</a></li>
<li><a href="https://twitter.com/34travelby" target="_blank">Twitter</a></li>',
                'status_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }

        if (!in_array('gtu_footer_contacts', $blocks)) {
            echo "add gtu_footer_contacts\n";
            $this->insert('{{block}}', [
                'name' => 'gtu_footer_contacts',
                'description' => 'Контакты в футере на GTU',
                'content' => '<p>E-mail: <a href="mailto:34travelby@gmail.com">34travelby@gmail.com</a></p>',
                'status_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }

        if (!in_array('gtu_footer_text', $blocks)) {
            echo "add gtu_footer_text\n";
            $this->insert('{{block}}', [
                'name' => 'gtu_footer_text',
                'description' => 'Текст в футере на GTU',
                'content' => '<p>Увага! Передрук будь-яких матеріалів сайту trevel34.loc без дозволу редакції заборонений.<br> Звертайтесь: 34travelby@gmail.com.</p>',
                'status_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
        if (!in_array('gtu_footer_text_ru', $blocks)) {
            echo "add gtu_footer_text_ru\n";
            $this->insert('{{block}}', [
                'name' => 'gtu_footer_text_ru',
                'description' => 'Текст в футере на GTU (RU)',
                'content' => '',
                'status_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
        if (!in_array('gtu_footer_text_en', $blocks)) {
            echo "add gtu_footer_text_en\n";
            $this->insert('{{block}}', [
                'name' => 'gtu_footer_text_en',
                'description' => 'Текст в футере на GTU (EN)',
                'content' => '',
                'status_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }

        if (!in_array('gtu_telegram', $blocks)) {
            echo "add gtu_telegram\n";
            $this->insert('{{block}}', [
                'name' => 'gtu_telegram',
                'description' => 'Ссылка на Telegram GTU',
                'content' => 'https://telegram.me/travel34',
                'status_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
        if (!in_array('gtu_instagram', $blocks)) {
            echo "add gtu_instagram\n";
            $this->insert('{{block}}', [
                'name' => 'gtu_instagram',
                'description' => 'Ссылка на Instagram GTU',
                'content' => 'https://www.instagram.com/34travel',
                'status_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }

    public function down()
    {
    }
}