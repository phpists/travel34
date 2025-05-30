<?php

class m210513_214658_copy_posts_to_gtu extends CDbMigration
{
    public function up()
    {
        $this->addColumn('{{post}}', 'is_gtu_post', "boolean NOT NULL DEFAULT '0' AFTER gtb_post_id");
        $this->addColumn('{{post}}', 'gtu_post_id', 'int');

        $rubric_titles = Yii::app()->db->createCommand()
            ->select('title')
            ->from('{{gtu_rubric}}')
            ->queryColumn();

        $posts = [
            'Культурна програма' => [
                'view-lvi', 'dvorcy-lviv', '11-vill-lviva', 'kyiv-podjezd', 'kyiv-brutalism', 'kyiv-mosaic',
                'levy-bereg', 'books-ukraine', 'meet-kyiv', 'must-see-ukraine', 'rassvety-zakaty-kyiv', 'mikro-kyiv',
                'kyiv-metro', 'reytarskaya-ulica', '10-mest-ot-ukrainer', '5-free-museum-kiyv', 'vinnica',
                'kinogajjd-po-ukraine-8-mest-iz-kultovykh-filmov', 'gajjd-po-chernobylyu-dlya-legalnykh-puteshestvennikov',
            ],
            'Активний відпочинок' => [
                'hotels-kyiv', '5-mest-u-morya-v-ukraine', 'ski-ukraine', 'carpathians-guide', 'vinodelni-ukrainy',
                'dikie-plyazhi-odessy', 'vremya-privala-7-mest-dlya-piknika-v-kieve',
            ],
            'Маршрути' => [
                'around-lviv', 'radomysl-okrestnosti', 'marshruty-po-ukraine', 'marshruty-lviv', 'okrestnosti-kyiv',
                'lutsk-rovno', '3towns-ukraine', 'bessarabia', '3ua-autumn-routes', '10-neizvestnykh-mest-zapadnojj-ukrainy',
            ],
            'Гайди' => [
                'kiev', 'kharkov', 'ivano-frankivsk', 'uzhgorod', 'lvov', 'odessa', 'vinnica-guide', 'chernovcy',
                'dnepr', 'ternopol', 'kherson', 'chernigov',
            ],
            'Їжа' => [
                'breakfast-kyiv', 'one-euro-kyiv', '11-new-kyiv', 'zavtraki-odessa', 'knizhnye-mesta-kyiv',
            ],
            'Фото' => [
                'odessa-dmitriy-sologub', 'lviv-reklama', 'majjskoe-zakarpate-ot-niny-popko',
                'magnetizm-lvova-ot-pavla-panasenkova', 'odessa-ot-tani-kapitonovojj',
            ],
        ];

        $translations_ru = [
            'Культурна програма' => 'Культурная программа',
            'Активний відпочинок' => 'Активный отдых',
            'Маршрути' => 'Маршруты',
            'Гайди' => 'Гайды',
            'Їжа' => 'Еда',
            'Фото' => 'Фото',
        ];

        $position = 1;
        foreach ($posts as $rubric_title => $post_urls) {
            if (!in_array($rubric_title, $rubric_titles)) {
                $url = Transliteration::slug($rubric_title);
                $this->insert('{{gtu_rubric}}', [
                    'url' => $url,
                    'title' => $rubric_title,
                    'title_ru' => isset($translations_ru[$rubric_title]) ? $translations_ru[$rubric_title] : $rubric_title,
                    'title_en' => $rubric_title,
                    'position' => $position++,
                    'in_todo_list' => in_array($rubric_title, ['Маршрути', 'Гайди']) ? 0 : 1,
                    'hide_in_menu' => 0,
                    'hide_in_menu_ru' => 0,
                    'hide_in_menu_en' => 0,
                    'status_id' => 1,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
            }
        }

        $rubric_titles = Yii::app()->db->createCommand()
            ->select('id, title')
            ->from('{{gtu_rubric}}')
            ->queryAll();
        $rubric_titles = CHtml::listData($rubric_titles, 'title', 'id');

        foreach ($posts as $rubric_title => $post_urls) {
            if (!isset($rubric_titles[$rubric_title])) {
                continue;
            }
            $rubric_id = $rubric_titles[$rubric_title];

            $posts = Yii::app()->db->createCommand()
                ->select()
                ->from('{{post}}')
                ->where(['in', 'url', $post_urls])
                ->queryAll();

            $gtu_posts = Yii::app()->db->createCommand()
                ->select('url')
                ->from('{{gtu_post}}')
                ->where(['in', 'url', $post_urls])
                ->queryColumn();

            echo "$rubric_id: " . count($post_urls) . " " . count($posts) . " " . count($gtu_posts) . "\n";

            foreach ($posts as $post) {
                if (in_array($post['url'], $gtu_posts)) {
                    continue;
                }

                echo "add {$post['url']}\n";

                $page_og_image = $this->copyImage($post['page_og_image']);
                $image = $this->copyImage($post['image']);
                if ($post['is_small_top'] == 1) {
                    $image2 = $this->copyImage($post['image'], '2');
                } else {
                    $image2 = null;
                }
                $image_home_top = $this->copyImage($post['image_home_top']);
                $image_big_post = $this->copyImage($post['image_big_post']);

                $this->insert('{{gtu_post}}', [
                    'author_id' => $post['author_id'] ?: null,
                    'gtu_rubric_id' => $rubric_id,
                    'type_id' => GtuPost::TYPE_POST,
                    'language' => 'uk',
                    'url' => $post['url'],
                    'title' => $post['title'],
                    'page_title' => $post['page_title'],
                    'page_keywords' => $post['page_keywords'],
                    'page_description' => $post['description'],
                    'page_og_image' => $page_og_image,
                    'date' => $post['date'],

                    'image' => $image,
                    'is_top' => $post['is_small_top'],
                    'image_top' => $image2,

                    'is_big_top' => $post['is_home_top'],
                    'is_home_big_top' => $post['is_home_first_top'],
                    'image_big_top' => $image_home_top,

                    //'is_supertop' => $post['status_id'],
                    //'image_supertop' => $post['status_id'],
                    //'is_home_supertop' => $post['status_id'],
                    //'image_home_supertop' => $post['status_id'],

                    'is_image_in_post' => $post['need_image_big_post'],
                    'image_in_post' => $image_big_post,

                    'summary' => $post['summary'],
                    'text' => $post['text'],
                    'background_color' => $post['background_color'],
                    'background_image' => $post['background_image'],
                    'hide_banners' => $post['hide_banners'],
                    'hide_styles' => $post['hide_styles'],
                    'hide_yandex_rss' => $post['hide_yandex_rss'],
                    'yandex_rss_genre' => $post['yandex_rss_genre'],
                    'hide_yandex_zen' => $post['hide_yandex_zen'],
                    'yandex_zen_adult' => $post['yandex_zen_adult'],
                    'yandex_zen_categories' => $post['yandex_zen_categories'],
                    'views_count' => $post['views_count'],

                    'status_id' => $post['status_id'],
                    'created_at' => $post['created_at'],
                    'updated_at' => $post['created_at'],
                ]);
            }
        }

        if ($this->notFound) {
            echo "\nnot found images:\n";
            echo implode("\n", $this->notFound);
            echo "\n";
        }

        $gtu_posts = Yii::app()->db->createCommand()
            ->select('id, url')
            ->from('{{gtu_post}}')
            ->queryAll();

        foreach ($gtu_posts as $gtu_post) {
            $this->update('{{post}}', ['is_gtu_post' => 1, 'gtu_post_id' => $gtu_post['id']], 'url = :post_url', [':post_url' => $gtu_post['url']]);
        }

        /*$all_post_urls = [];
        if ($rubric_id) {
            $all_post_urls = Yii::app()->db->createCommand()
                ->select('url')
                ->from('{{post}}')
                ->where('rubric_id = :uk_rubric_id', [':uk_rubric_id' => $rubric_id])
                ->queryColumn();
        }

        echo "\nunused:\n";
        foreach ($all_post_urls as $post_url) {
            if (!in_array($post_url, $gtu_posts)) {
                echo "$post_url\n";
            }
        }*/
    }

    public function down()
    {
        $this->dropColumn('{{post}}', 'gtu_post_id');
        $this->dropColumn('{{post}}', 'is_gtu_post');
    }

    private $notFound = [];

    private function copyImage($image, $add = '')
    {
        if ($image && strlen($image) > 18) {
            $path = Yii::getPathOfAlias('webroot') . '/media/posts/' . $image;
            if (is_file($path)) {
                $new_name = substr($image, 0, 13) . '-gtu' . $add . '-' . substr($image, 14);
                $new_path = Yii::getPathOfAlias('webroot') . '/media/posts/' . $new_name;
                if (!is_file($new_path)) {
                    copy($path, $new_path);
                }
                if (is_file($new_path)) {
                    return $new_name;
                }
            } else {
                $this->notFound[] = $image;
            }
        }
        return null;
    }
}