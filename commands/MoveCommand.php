<?php

class MoveCommand extends CConsoleCommand
{
    /**
     * WARNING: Перед запуском применить миграции 017-019 и сделать бэкап БД
     * Копирование постов в GTB
     * yiic move gtb
     */
    public function actionGtb()
    {
        if (!$this->confirm('Are you sure?')) {
            return;
        }

        $ru_rubric_id = 20;
        $en_rubric_id = 24;

        $rubric_ids = [$ru_rubric_id, $en_rubric_id];

        echo "\nTruncate tables\n";

        Yii::app()->db->createCommand('SET foreign_key_checks = 0;')->execute();
        Yii::app()->db->createCommand()->truncateTable('tr_gtb_comment');
        Yii::app()->db->createCommand()->truncateTable('tr_gtb_post');
        Yii::app()->db->createCommand()->truncateTable('tr_gtb_rubric');
        Yii::app()->db->createCommand('SET foreign_key_checks = 1;')->execute();

        echo "\nInsert rubrics\n";

        $guides_id = null;
        $rubric_id_by_name = [];

        $post_to_rubric = [
            '15-dizajjnerskikh-brendov-iz-belarusi' => 'shopping',
            'zelenyjj-minsk' => 'activities',
            'vitebsk' => 'guides',
            'eshhe-14-knig-o-belarusi' => 'shopping',
            'znajj-nashikh-travel-iniciativy-belarusov' => 'info',
            '8-neobychnykh-muzeev-grodno' => 'cultural-programme',
            'britanec-o-belarusi-turisty-naletyat-kak-sarancha' => 'cultural-programme',
            'alternativnye-marshruty-po-minsku' => 'routes',
            'gomel' => 'guides',
            'marshrut-gulyaem-po-konstruktivistskim-zdaniyam-minska' => 'routes',
            'skolko-stoit-sletat-v-belarus' => 'info',
            'v-gosti-v-belarus' => 'info',
            'zima-v-belarusi' => 'activities',
            'kak-polzovatsya-platnymi-dorogami-v-belarusi' => 'info',
            'eshhe-pyat-gorodov-belarusi-gde-nuzhno-provesti-uikehnd' => 'routes',
            'boloting-ehto-alternativa-goram' => 'activities',
            'faq-kak-priekhat-v-belarus-i-ne-oblazhatsya-1417' => 'info',
            '5-krutykh-kofeen-za-mkad' => 'eat-drink',
            '5-belarusskikh-gorodov-gde-stoit-provesti-uikend' => 'routes',
            'gastronomicheskie-ehndemiki-belarusi' => 'eat-drink',
            'minsk' => 'guides',
            '10-veshhejj-kotorye-obyazatelno-sdelat-v-minske' => 'cultural-programme',
            'from-belarus-with-love' => 'shopping',
            'rebrending-belavia-delala-vsya-strana' => 'to-stay',
            'gde-otdokhnut-s-palatkojj-v-belarusi' => 'activities',

            'minsk-english-guide' => 'guides',
            '10-things-to-do-in-minsk-like-a-local' => 'cultural-programme',
            '5-more-towns-for-weekend-in-belarus' => 'routes',
            'route-walking-around-constructivist-buildings-of-minsk' => 'routes',
            '5-belarusian-towns-perfect-for-weekend-getaway' => 'routes',
            'faq-how-to-come-to-belarus' => 'info',
        ];

        $items = [
            ['info', 'Информация', 'Basic Info', '', '', 1, 0, 1],
            ['cultural-programme', 'Культурная программа', 'Cultural programme', '', '', 10, 1, 1],
            ['eat-drink', 'Еда и напитки', 'Eat & Drink', '', '', 11, 1, 1],
            ['activities', 'Активный отдых', 'Activities', '', '', 12, 1, 1],
            ['routes', 'Маршруты', 'Routes', '', '', 13, 1, 1],
            ['shopping', 'Покупки', 'Shopping', '', '', 14, 1, 1],
            ['to-stay', 'События', 'To stay', '', '', 15, 1, 1],
            ['guides', 'Гайды', 'City Guides', '', '', 100, 0, 1],
        ];
        $cols = ['url', 'title', 'title_en', 'description', 'description_en', 'position', 'in_todo_list', 'status_id'];

        foreach ($items as $item) {
            echo "{$item[0]}: ";

            $data = array_combine($cols, $item);
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['updated_at'] = date('Y-m-d H:i:s');

            $res = Yii::app()->db->createCommand()->insert('tr_gtb_rubric', $data);

            if ($res > 0) {
                $l_id = Yii::app()->db->lastInsertID;
                $rubric_id_by_name[$data['url']] = $l_id;
                if ($data['url'] == 'guides') {
                    $guides_id = $l_id;
                }
                echo "Saved as $l_id\n";
            } else {
                echo "ERROR!\n";
            }
        }

        echo "\nCopy posts\n";

        $criteria = new CDbCriteria();
        $criteria->addInCondition('rubric_id', $rubric_ids);
        $criteria->order = 'id';

        /** @var Post[] $posts */
        $posts = Post::model()->findAll($criteria);

        $count = 1;
        $ids = [];

        $webroot = Yii::getPathOfAlias('webroot');
        $img_base_path = $webroot . '/media/posts/';

        foreach ($posts as $post) {
            echo "$count. {$post->url}\n";

            $images = [
                'image' => !empty($post->image) ? $post->image : null,
                'image_top' => $post->is_small_top == 1 ? $post->image : null,
                'image_big_top' => $post->is_home_top == 1 ? $post->image_home_top : null,
                'image_supertop' => $post->is_big_top == 1 ? $post->image_top : null,
                'image_in_post' => $post->need_image_big_post == 1 ? $post->image_big_post : null,
            ];

            foreach ($images as $key => $image) {
                if (!empty($image) && is_file($img_base_path . $image)) {
                    $parts = explode('-', $image, 2);
                    if (!empty($parts[1])) {
                        $new_name = uniqid() . '-' . $parts[1];
                        if (!is_file($img_base_path . $new_name)) {
                            copy($img_base_path . $image, $img_base_path . $new_name);
                            if (is_file($img_base_path . $new_name)) {
                                $images[$key] = $new_name;
                            }
                        }
                    }
                }
            }

            $_gtb_rubric_id = null;
            if (($post->type_id == Post::TYPE_GUIDE || $post->type_id == Post::TYPE_MINIGUIDE) && isset($rubric_id_by_name['guides'])) {
                $_gtb_rubric_id = $rubric_id_by_name['guides'];
            } elseif (isset($post_to_rubric[$post->url])) {
                $_r_url = $post_to_rubric[$post->url];
                if (isset($rubric_id_by_name[$_r_url])) {
                    $_gtb_rubric_id = $rubric_id_by_name[$_r_url];
                }
            }

            $data = [
                'author_id' => $post->author_id,
                'gtb_rubric_id' => $_gtb_rubric_id,
                'type_id' => GtbPost::TYPE_POST,
                'url' => $post->url,
                'title' => $post->title,
                'date' => $post->date,
                'summary' => $post->summary,
                'text' => $post->text,
                'page_title' => $post->page_title,
                'page_keywords' => $post->page_keywords,
                'page_description' => $post->description,
                'is_top' => $post->is_small_top,
                'is_big_top' => $post->is_home_top,
                'is_home_big_top' => $post->is_home_first_top,
                'is_supertop' => $post->is_big_top,
                'is_home_supertop' => $post->is_home_supertop,
                'is_image_in_post' => $post->need_image_big_post,
                'image' => $images['image'],
                'image_top' => $images['image_top'],
                'image_big_top' => $images['image_big_top'],
                'image_supertop' => $images['image_supertop'],
                'image_in_post' => $images['image_in_post'],
                'related_posts' => null,
                'status_id' => $post->status_id,
                'language' => $post->rubric_id == $en_rubric_id ? 'en' : 'ru',
                'created_at' => $post->created_at,
                'updated_at' => $post->updated_at,
                'comments_count' => $post->comments_count,
                'views_count' => $post->views_count,
            ];

            $res = Yii::app()->db->createCommand()->insert('tr_gtb_post', $data);

            if ($res > 0) {
                $l_id = Yii::app()->db->lastInsertID;
                $ids[$post->id] = $l_id;
                echo str_repeat(' ', strlen("$count")) . "  Saved as $l_id";
                // mark old post as gtb
                $res = Yii::app()->db->createCommand()->update('tr_post', ['is_gtb_post' => 1, 'gtb_post_id' => $l_id], 'id = :post_id', [':post_id' => $post->id]);
                if ($res > 0) {
                    echo '. Old post marked as GTB';
                }
                echo "\n";
            } else {
                echo str_repeat(' ', strlen("$count")) . "  ERROR!\n";
            }

            $count++;
        }

        echo "\nCopy comments\n";

        foreach ($ids as $old_post_id => $gtb_post_id) {
            echo "$old_post_id -> $gtb_post_id: ";

            $criteria = new CDbCriteria;
            $criteria->compare('post_id', $old_post_id);
            $criteria->order = 'id';

            /** @var Comment[] $comments */
            $comments = Comment::model()->findAll($criteria);

            if (count($comments) == 0) {
                echo "nothing\n";
                continue;
            }

            $parent_ids = [];

            foreach ($comments as $comment) {
                $data = [
                    'gtb_post_id' => $gtb_post_id,
                    'content' => $comment->content,
                    'email' => $comment->email,
                    'user_name' => $comment->user_name,
                    'created_at' => $comment->created_at,
                    'updated_at' => $comment->updated_at,
                    'create_user_id' => $comment->create_user_id,
                    'update_user_id' => $comment->update_user_id,
                    'parent_id' => isset($parent_ids[$comment->parent_id]) ? $parent_ids[$comment->parent_id] : 0,
                    'status_id' => $comment->status_id,
                    'likes_count' => $comment->likes_count,
                    'dislikes_count' => $comment->dislikes_count,
                ];

                $res = Yii::app()->db->createCommand()->insert('tr_gtb_comment', $data);

                if ($res > 0) {
                    $l_id = Yii::app()->db->lastInsertID;
                    $parent_ids[$comment->id] = $l_id;
                    echo $l_id . ' ';
                } else {
                    echo 'E ';
                }
            }
            echo "\n";
        }

        echo "\nCopy styles\n";

        foreach ($ids as $old_post_id => $gtb_post_id) {
            echo "$old_post_id -> $gtb_post_id: ";

            $criteria = new CDbCriteria;
            $criteria->compare('page_key', Style::PAGE_KEY_POST);
            $criteria->compare('item_id', $old_post_id);
            $criteria->order = 'id';

            /** @var Style[] $styles */
            $styles = Style::model()->findAll($criteria);

            if (count($styles) == 0) {
                echo "nothing\n";
                continue;
            }

            foreach ($styles as $style) {
                $data = [
                    'page_key' => Style::PAGE_KEY_GTB_POST,
                    'item_id' => $gtb_post_id,
                ];

                $res = Yii::app()->db->createCommand()->update('tr_style', $data, 'id = :id', [':id' => $style->id]);

                if ($res > 0) {
                    echo '. ';
                } else {
                    echo 'E ';
                }
            }
            echo "\n";
        }

        echo "\nDone\n";
    }

    /**
     * WARNING: Выполнить только после переноса постов и проверки результата
     * yiic move deldata
     */
    public function actionDeldata()
    {
        if (!$this->confirm('Are you sure?')) {
            return;
        }

        $posts = Post::model()->findAllByAttributes(['is_gtb_post' => 1]);
        foreach ($posts as $post) {
            echo "{$post->id}. {$post->url}\n";
            $pad = str_repeat(' ', strlen("{$post->id}")) . '  ';

            // comments

            $criteria = new CDbCriteria;
            $criteria->compare('post_id', $post->id);
            $criteria->order = 'id';

            /** @var Comment[] $comments */
            $comments = Comment::model()->findAll($criteria);

            if (($total_comments = count($comments)) > 0) {
                echo "{$pad}Delete comments ($total_comments)...";
                $res = Yii::app()->db->createCommand()->delete('tr_comment', 'post_id = :post_id', [':post_id' => $post->id]);
                if ($res > 0) {
                    echo " OK\n";
                } else {
                    echo " ERROR!\n";
                }
            } else {
                echo "{$pad}No comments\n";
            }

            // counters & rubric id

            echo "{$pad}Clean post data...";
            $res = Yii::app()->db->createCommand()->update('tr_post', [
                'rubric_id' => null,
                'comments_count' => 0,
                'views_count' => 0,
                'text' => '',
                'need_image_big_post' => 0,
                'image_big_post' => null,
                'is_home_first_top' => 0,
                'is_home_supertop' => 0,
                'related_posts' => null,
                'updated_at' => date('Y-m-d H:i:s'),
            ], 'id = :post_id', [':post_id' => $post->id]);
            if ($res > 0) {
                echo " OK\n";
            } else {
                echo " ERROR!\n";
            }
        }

        echo "\nDone\n";
    }

    public function actionTestgtb()
    {
        if (!$this->confirm('Are you sure?')) {
            return;
        }

        $rubric_id = 24;
        $new_rubric_id_min = 1;
        $new_rubric_id_max = 8;

        echo "\nCopy posts\n";

        $criteria = new CDbCriteria();
        $criteria->compare('rubric_id', '<>' . $rubric_id);
        $criteria->order = 'id';
        //$criteria->limit = 150;

        /** @var Post[] $posts */
        $posts = Post::model()->enabled()->not_news()->findAll($criteria);

        $count = 1;

        foreach ($posts as $post) {
            echo "$count. {$post->url}\n";

            $data = [
                'author_id' => $post->author_id,
                'gtb_rubric_id' => mt_rand($new_rubric_id_min, $new_rubric_id_max),
                'type_id' => GtbPost::TYPE_POST,
                'url' => $post->url,
                'title' => $post->title,
                'date' => $post->date,
                'summary' => $post->summary,
                'text' => $post->text,
                'page_title' => $post->page_title,
                'page_keywords' => $post->page_keywords,
                'page_description' => $post->description,
                'is_top' => $post->is_small_top,
                'is_big_top' => $post->is_home_top,
                'is_home_big_top' => $post->is_home_first_top,
                'is_supertop' => $post->is_big_top,
                'is_home_supertop' => $post->is_home_supertop,
                'is_image_in_post' => $post->need_image_big_post,
                'image' => $post->image,
                'image_top' => $post->is_small_top == 1 ? $post->image : null,
                'image_big_top' => $post->is_home_top == 1 ? $post->image_home_top : null,
                'image_supertop' => $post->is_big_top == 1 ? $post->image_top : null,
                'image_in_post' => $post->need_image_big_post == 1 ? $post->image_big_post : null,
                'related_posts' => null,
                'status_id' => $post->status_id,
                'language' => 'ru',
                'created_at' => $post->created_at,
                'updated_at' => $post->updated_at,
                'comments_count' => $post->comments_count,
                'views_count' => $post->views_count,
            ];

            $res = Yii::app()->db->createCommand()->insert('tr_gtb_post', $data);

            if ($res > 0) {
                $l_id = Yii::app()->db->lastInsertID;
                echo str_repeat(' ', strlen("$count")) . "  Saved as $l_id\n";
            } else {
                echo str_repeat(' ', strlen("$count")) . "  ERROR!\n";
            }

            $count++;
        }

        echo "\nDone\n";
    }
}
