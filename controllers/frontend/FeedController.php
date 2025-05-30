<?php

class FeedController extends FrontEndController
{
    public function actionIndex()
    {
        $no_cache = Yii::app()->request->getQuery('nocache') === '1';

        $runtime = Yii::getPathOfAlias('application.runtime');
        $cache_filename = 'rss.xml';
        if (!$no_cache && is_file($runtime . '/' . $cache_filename) && filemtime($runtime . '/' . $cache_filename) > time() - 300) {
            header('Content-Type: application/xml; charset=utf-8');
            readfile($runtime . '/' . $cache_filename);
            exit;
        }

        $postTAlias = Post::model()->getTableAlias();

        $criteria = new CDbCriteria();
        $criteria->order = $postTAlias . '.date DESC, ' . $postTAlias . '.created_at DESC';
        $criteria->limit = 10;

        $posts = Post::model()->enabled()->findAll($criteria);

        $site_link = Yii::app()->getBaseUrl(true) . '/';
        $site_title = Yii::app()->name;
        $site_description = $this->getMetaDescription();

        $xml = new SimpleXMLElementExtended('<?xml version="1.0" encoding="utf-8"?><rss/>');
        $xml->addAttribute('version', '2.0');
        $xml->addAttribute('xmlns:xmlns:content', 'http://purl.org/rss/1.0/modules/content/');
        $xml->addAttribute('xmlns:xmlns:dc', 'http://purl.org/dc/elements/1.1/');
        $xml->addAttribute('xmlns:xmlns:atom', 'http://www.w3.org/2005/Atom');

        $channel = $xml->addChild('channel');
        $channel->addChild('title', $site_title);
        $channel->addChild('link', $site_link);
        $channel->addChild('description', $site_description);
        $channel->addChild('language', 'ru-RU');
        $channel->addChild('lastBuildDate', date(DATE_RSS, strtotime($posts[0]->date)));
        $channel->addChild('ttl', '60');

        $atom_item = $channel->addChild('xmlns:atom:link');
        $atom_item->addAttribute('href', $this->createAbsoluteUrl('/feed/index'));
        $atom_item->addAttribute('rel', 'self');
        $atom_item->addAttribute('type', 'application/rss+xml');

        foreach ($posts as $post) {
            $post_link = $post->getUrl();
            $image = '';
            if (!empty($post->image)) {
                $image = '<p>' . CHtml::link(CHtml::image($post->getImageUrl('image', true), '', ['border' => '0']), $post_link) . '</p>';
            }
            $title = $post->title;
            $title = iconv('UTF-8', 'UTF-8//IGNORE', $title);
            $content = !empty($post->summary) ? $post->summary : '<p>' . $post->description . '</p>';
            $content = iconv('UTF-8', 'UTF-8//IGNORE', $content);
            $content_notags = trim(strip_tags(html_entity_decode($content, ENT_QUOTES, 'UTF-8')));
            $content_notags = iconv('UTF-8', 'UTF-8//IGNORE', $content_notags);

            /** @var SimpleXMLElementExtended $item */
            $item = $channel->addChild('item');
            $item->addChild('title', self::encode($title));
            $item->addChild('link', self::encode($post_link));
            $item->addChild('xmlns:dc:creator', $site_title);
            $item->addChildCData('description', $content_notags);
            $item->addChildCData('xmlns:content:encoded', $content . $image);
            $guid = $item->addChild('guid', self::encode($post_link));
            $guid->addAttribute('isPermaLink', 'true');
            $item->addChild('pubDate', date(DATE_RSS, strtotime($post->date)));
        }

        $xml_out = $xml->asXML();

        file_put_contents($runtime . '/' . $cache_filename, $xml_out);

        // display
        header('Content-Type: application/xml; charset=utf-8');
        echo $xml_out;
        exit;
    }

    /**
     * RSS для Яндекс Дзен
     * @url https://yandex.ru/support/zen/website/rss-connect.html
     * @url https://yandex.ru/support/zen/website/rss-modify.html
     */
    public function actionZen()
    {
        $no_cache = Yii::app()->request->getQuery('nocache') === '1';

        $runtime = Yii::getPathOfAlias('application.runtime');
        $cache_filename = 'yandex.zen.xml';
        if (!$no_cache && is_file($runtime . '/' . $cache_filename) && filemtime($runtime . '/' . $cache_filename) > time() - 300) {
            header('Content-Type: application/xml; charset=utf-8');
            readfile($runtime . '/' . $cache_filename);
            exit;
        }

        $all_posts = [];

        // 34 travel posts

        $postTAlias = Post::model()->getTableAlias();
        $criteria = new CDbCriteria();
        $criteria->order = $postTAlias . '.date DESC, ' . $postTAlias . '.created_at DESC';
        $criteria->limit = 10;
        $posts = Post::model()->enabled()->yandexZen()->with('author')->findAll($criteria);

        $count = 0;
        foreach ($posts as $post) {
            $post_link = $post->getUrl();

            $title = trim($post->title);
            $title = iconv('UTF-8', 'UTF-8//IGNORE', $title);

            $description = !empty($post->summary) ? $post->summary : $post->description;
            $description = trim(strip_tags(html_entity_decode($description, ENT_QUOTES, 'UTF-8')));
            $description = iconv('UTF-8', 'UTF-8//IGNORE', $description);

            $content = !empty($post->text) ? $post->text : $post->summary;
            if ($post->is_big_top == 1 && !empty($post->image_top)) {
                $content = '<p><img src="' . $post->getImageUrl('image_top') . '" alt=""></p>' . "\n" . $content;
            } elseif (!$post->isNews() && $post->need_image_big_post == 1 && $post->image_big_post) {
                $content = '<p><img src="' . $post->getImageUrl('image_big_post') . '" alt=""></p>' . "\n" . $content;
            } elseif ($post->isNews() && !empty($post->image_big_post)) {
                $content = '<p><img src="' . $post->getImageUrl('image_big_post') . '" alt=""></p>' . "\n" . $content;
            }
            $content = iconv('UTF-8', 'UTF-8//IGNORE', $content);
            $content = Shortcodes::parse($content);
            $content = preg_replace('/[\r\n]+/', ' ', $content);

            $date = date(DATE_RSS, strtotime($post->date));

            $date_key = strtotime($post->date) . '-a' . $count;

            $genre = 'article';
            if (!empty($post->yandex_rss_genre)) {
                $genre = $post->yandex_rss_genre;
            } elseif ($post->type_id = Post::TYPE_NEWS) {
                $genre = 'message';
            }

            $all_posts[$date_key] = [
                'link' => $post_link,
                'title' => $title,
                'description' => $description,
                'content' => $content,
                'date' => $date,
                'author' => $post->author !== null ? trim($post->author->title) : '',
                'genre' => $genre,
                'category' => $post->yandex_zen_categories_array,
                'adult' => $post->yandex_zen_adult == 1,
            ];

            $count++;
        }

        // GTB

        Yii::app()->language = 'ru';

        $postTAlias = GtbPost::model()->getTableAlias();
        $criteria = new CDbCriteria();
        $criteria->order = $postTAlias . '.date DESC, ' . $postTAlias . '.created_at DESC';
        $criteria->limit = 10;
        $posts = GtbPost::model()->enabled()->yandexZen()->with('author')->findAll($criteria);

        $count = 0;
        foreach ($posts as $post) {
            $post_link = $post->getUrl();

            $title = trim($post->title);
            $title = iconv('UTF-8', 'UTF-8//IGNORE', $title);

            $description = !empty($post->summary) ? $post->summary : $post->page_description;
            $description = trim(strip_tags(html_entity_decode($description, ENT_QUOTES, 'UTF-8')));
            $description = iconv('UTF-8', 'UTF-8//IGNORE', $description);

            $content = !empty($post->text) ? $post->text : $post->summary;
            if ($post->is_supertop == 1 && !empty($post->image_supertop)) {
                $content = '<p><img src="' . $post->getImageUrl('image_supertop') . '" alt=""></p>' . "\n" . $content;
            } elseif ($post->is_image_in_post == 1 && $post->image_in_post) {
                $content = '<p><img src="' . $post->getImageUrl('image_in_post') . '" alt=""></p>' . "\n" . $content;
            }
            $content = iconv('UTF-8', 'UTF-8//IGNORE', $content);
            $content = Shortcodes::parse($content);
            $content = preg_replace('/[\r\n]+/', ' ', $content);

            $date = date(DATE_RSS, strtotime($post->date));

            $date_key = strtotime($post->date) . '-b' . $count;

            $genre = 'article';
            if (!empty($post->yandex_rss_genre)) {
                $genre = $post->yandex_rss_genre;
            }

            $all_posts[$date_key] = [
                'link' => $post_link,
                'title' => $title,
                'description' => $description,
                'content' => $content,
                'date' => $date,
                'author' => $post->author !== null ? trim($post->author->title) : '',
                'genre' => $genre,
                'category' => $post->yandex_zen_categories_array,
                'adult' => $post->yandex_zen_adult == 1,
            ];

            $count++;
        }

        krsort($all_posts);

        // generate xml

        $site_link = Yii::app()->getBaseUrl(true) . '/';
        $site_title = Yii::app()->name;
        $site_description = $this->getMetaDescription();

        $xml = new SimpleXMLElementExtended('<?xml version="1.0" encoding="utf-8"?><rss/>');
        $xml->addAttribute('version', '2.0');
        $xml->addAttribute('xmlns:xmlns:content', 'http://purl.org/rss/1.0/modules/content/');
        $xml->addAttribute('xmlns:xmlns:dc', 'http://purl.org/dc/elements/1.1/');
        $xml->addAttribute('xmlns:xmlns:media', 'http://search.yahoo.com/mrss/');
        $xml->addAttribute('xmlns:xmlns:atom', 'http://www.w3.org/2005/Atom');
        $xml->addAttribute('xmlns:xmlns:georss', 'http://www.georss.org/georss');

        $channel = $xml->addChild('channel');
        $channel->addChild('title', self::encode($site_title));
        $channel->addChild('link', self::encode($site_link));
        $channel->addChild('description', self::encode($site_description));
        $channel->addChild('language', 'ru');

        foreach ($all_posts as $post) {

            /** @var SimpleXMLElementExtended $item */
            $item = $channel->addChild('item');
            $item->addChild('title', self::encode($post['title']));
            $item->addChild('link', self::encode($post['link']));
            $item->addChild('pubDate', $post['date']);
            $item->addChildCData('description', self::encode($post['description']));
            //$item->addChild('xmlns:yandex:genre', $post['genre']);
            if (!empty($post['author'])) {
                $item->addChild('author', self::encode($post['author']));
            }
            foreach ($post['category'] as $category) {
                $item->addChild('category', self::encode($category));
            }
            $rating = $item->addChild('xmlns:media:rating', $post['adult'] ? 'adult' : 'nonadult');
            $rating->addAttribute('scheme', 'urn:simple');
            $guid = $item->addChild('guid', self::encode($post['link']));
            $guid->addAttribute('isPermaLink', 'true');

            list($enclosure, $content) = $this->parseHtml($post['content'], $post['title']);

            if (!empty($enclosure)) {
                foreach ($enclosure as $i => $img) {
                    $enclosure = $item->addChild('enclosure');
                    $enclosure->addAttribute('url', self::urlEncode($img['url']));
                    $enclosure->addAttribute('type', $img['mime']);
                }
            }

            $item->addChildCData('xmlns:content:encoded', $content);
        }

        $xml_out = $xml->asXML();

        file_put_contents($runtime . '/' . $cache_filename, $xml_out);

        // display
        header('Content-Type: application/xml; charset=utf-8');
        echo $xml_out;
        exit;
    }

    /**
     * RSS для Яндекс Новостей
     * @url https://yandex.ru/support/news/feed.html
     */
    public function actionYandex()
    {
        $no_cache = Yii::app()->request->getQuery('nocache') === '1';

        $runtime = Yii::getPathOfAlias('application.runtime');
        $cache_filename = 'yandex.news.xml';
        if (!$no_cache && is_file($runtime . '/' . $cache_filename) && filemtime($runtime . '/' . $cache_filename) > time() - 300) {
            header('Content-Type: application/xml; charset=utf-8');
            readfile($runtime . '/' . $cache_filename);
            exit;
        }

        $all_posts = [];

        // 34 travel posts

        $postTAlias = Post::model()->getTableAlias();
        $criteria = new CDbCriteria();
        $criteria->order = $postTAlias . '.date DESC, ' . $postTAlias . '.created_at DESC';
        $criteria->limit = 10;
        $posts = Post::model()->enabled()->yandexRss()->with('author')->findAll($criteria);

        $count = 0;
        foreach ($posts as $post) {
            $post_link = $post->getUrl();

            $title = trim($post->title);
            $title = iconv('UTF-8', 'UTF-8//IGNORE', $title);

            $description = !empty($post->summary) ? $post->summary : $post->description;
            $description = trim(strip_tags(html_entity_decode($description, ENT_QUOTES, 'UTF-8')));
            $description = iconv('UTF-8', 'UTF-8//IGNORE', $description);

            $content = !empty($post->text) ? $post->text : $post->summary;
            if ($post->is_big_top == 1 && !empty($post->image_top)) {
                $content = '<p><img src="' . $post->getImageUrl('image_top') . '" alt=""></p>' . "\n" . $content;
            } elseif (!$post->isNews() && $post->need_image_big_post == 1 && $post->image_big_post) {
                $content = '<p><img src="' . $post->getImageUrl('image_big_post') . '" alt=""></p>' . "\n" . $content;
            } elseif ($post->isNews() && !empty($post->image_big_post)) {
                $content = '<p><img src="' . $post->getImageUrl('image_big_post') . '" alt=""></p>' . "\n" . $content;
            }
            $content = iconv('UTF-8', 'UTF-8//IGNORE', $content);
            $content = Shortcodes::parse($content);
            $content = preg_replace('/[\r\n]+/', ' ', $content);

            $date = date(DATE_RSS, strtotime($post->date));

            $date_key = strtotime($post->date) . '-a' . $count;

            $genre = 'article';
            if (!empty($post->yandex_rss_genre)) {
                $genre = $post->yandex_rss_genre;
            } elseif ($post->type_id = Post::TYPE_NEWS) {
                $genre = 'message';
            }

            $all_posts[$date_key] = [
                'link' => $post_link,
                'title' => $title,
                'description' => $description,
                'content' => $content,
                'date' => $date,
                'author' => $post->author !== null ? $post->author->title : '',
                'genre' => $genre,
            ];

            $count++;
        }

        // GTB

        Yii::app()->language = 'ru';

        $postTAlias = GtbPost::model()->getTableAlias();
        $criteria = new CDbCriteria();
        $criteria->order = $postTAlias . '.date DESC, ' . $postTAlias . '.created_at DESC';
        $criteria->limit = 10;
        $posts = GtbPost::model()->enabled()->yandexRss()->with('author')->findAll($criteria);

        $count = 0;
        foreach ($posts as $post) {
            $post_link = $post->getUrl();

            $title = trim($post->title);
            $title = iconv('UTF-8', 'UTF-8//IGNORE', $title);

            $description = !empty($post->summary) ? $post->summary : $post->page_description;
            $description = trim(strip_tags(html_entity_decode($description, ENT_QUOTES, 'UTF-8')));
            $description = iconv('UTF-8', 'UTF-8//IGNORE', $description);

            $content = !empty($post->text) ? $post->text : $post->summary;
            if ($post->is_supertop == 1 && !empty($post->image_supertop)) {
                $content = '<p><img src="' . $post->getImageUrl('image_supertop') . '" alt=""></p>' . "\n" . $content;
            } elseif ($post->is_image_in_post == 1 && $post->image_in_post) {
                $content = '<p><img src="' . $post->getImageUrl('image_in_post') . '" alt=""></p>' . "\n" . $content;
            }
            $content = iconv('UTF-8', 'UTF-8//IGNORE', $content);
            $content = Shortcodes::parse($content);
            $content = preg_replace('/[\r\n]+/', ' ', $content);

            $date = date(DATE_RSS, strtotime($post->date));

            $date_key = strtotime($post->date) . '-b' . $count;

            $genre = 'article';
            if (!empty($post->yandex_rss_genre)) {
                $genre = $post->yandex_rss_genre;
            }

            $all_posts[$date_key] = [
                'link' => $post_link,
                'title' => $title,
                'description' => $description,
                'content' => $content,
                'date' => $date,
                'author' => $post->author !== null ? $post->author->title : '',
                'genre' => $genre,
            ];

            $count++;
        }

        krsort($all_posts);

        // generate xml

        $site_link = Yii::app()->getBaseUrl(true) . '/';
        $site_title = Yii::app()->name;
        $site_description = $this->getMetaDescription();

        $xml = new SimpleXMLElementExtended('<?xml version="1.0" encoding="utf-8"?><rss/>');
        $xml->addAttribute('version', '2.0');
        $xml->addAttribute('xmlns:xmlns:yandex', 'http://news.yandex.ru');
        $xml->addAttribute('xmlns:xmlns:media', 'http://search.yahoo.com/mrss/');
        $xml->addAttribute('xmlns:xmlns:turbo', 'http://turbo.yandex.ru');

        $channel = $xml->addChild('channel');
        $channel->addChild('title', self::encode($site_title));
        $channel->addChild('link', self::encode($site_link));
        $channel->addChild('description', self::encode($site_description));
        $channel->addChild('language', 'ru');

        foreach ($all_posts as $post) {
            /** @var SimpleXMLElementExtended $item */
            $item = $channel->addChild('item');
            $item->addAttribute('turbo', 'false');
            $item->addChild('title', self::encode($post['title']));
            $item->addChild('link', self::encode($post['link']));
            $item->addChild('pubDate', $post['date']);
            $item->addChild('description', self::encode($post['description']));
            $item->addChild('xmlns:yandex:genre', $post['genre']);
            if (!empty($post['author'])) {
                $item->addChild('author', self::encode($post['author']));
            }

            $enclosure = $this->item_enclosure($post['content']);
            if (!empty($enclosure)) {
                foreach ($enclosure as $i => $img) {
                    $enclosure = $item->addChild('enclosure');
                    $enclosure->addAttribute('url', self::urlEncode($img['url']));
                    $enclosure->addAttribute('type', $img['mime']);
                }
            }

            $media = $this->item_media($post['content']);
            if (!empty($media)) {
                foreach ($media as $media_obj) {
                    if (!empty($media_obj['content']) || !empty($media_obj['player'])) {
                        $media_group = $item->addChild('xmlns:media:group');
                        if (!empty($media_obj['content'])) {
                            $media_content = $media_group->addChild('xmlns:media:content');
                            $media_content->addAttribute('url', self::encode($media_obj['content']));
                        }
                        if (!empty($media_obj['player'])) {
                            $media_player = $media_group->addChild('xmlns:media:player');
                            $media_player->addAttribute('url', self::encode($media_obj['player']));
                        }
                        if (!empty($media_obj['thumb'])) {
                            $media_thumbnail = $media_group->addChild('xmlns:media:thumbnail');
                            $media_thumbnail->addAttribute('url', self::encode($media_obj['thumb']));
                        }
                    }
                }
            }

            $item->addChild('xmlns:yandex:full-text', self::encode($this->cleanText($post['content'])));
        }

        $xml_out = $xml->asXML();

        file_put_contents($runtime . '/' . $cache_filename, $xml_out);

        // display
        header('Content-Type: application/xml; charset=utf-8');
        echo $xml_out;
        exit;
    }

    protected static function encode($content)
    {
        $content = CHtml::encode($content);
        $content = str_replace('’', '&apos;', $content);
        return $content;
    }

    protected static function urlEncode($content)
    {
        $content = str_replace(['%3A', '%2F'], [':', '/'], rawurlencode($content));
        $content = CHtml::encode($content);
        return $content;
    }

    protected function cleanText($content)
    {
        $content = str_replace('[ULEJ]', '', $content);
        $content = preg_replace('@<(script|style)[^>]*?>.*?</\\1>@si', '', $content);
        $content = html_entity_decode($content, ENT_QUOTES, 'UTF-8');
        $content = str_replace([' ', '&nbsp;'], ' ', $content);
        $content = preg_replace('/<p>\s*<\/p>/', '', $content);
        $content = trim(strip_tags($content));
        $content = preg_replace('/\s+/', ' ', $content);
        //$content = preg_replace('/\s\s+/', ' ', $content);
        //$content = preg_replace('/(\r|\n|\r\n){3,}/', '', $content);
        $content = trim($content);
        return $content;
    }

    /**
     * Для Дзен
     * @param string $content
     * @param string $title
     * @return array
     */
    protected function parseHtml($content, $title)
    {
        $title = self::encode($title);

        $content = str_replace('[ULEJ]', '', $content);

        $content = preg_replace('@<(script|style)[^>]*?>.*?</\\1>@si', '', $content);
        $content = html_entity_decode($content, ENT_QUOTES, 'UTF-8');
        $content = str_replace([' ', '&nbsp;'], ' ', $content);
        $content = preg_replace('/<p>\s*<\/p>/', '', $content);
        $content = preg_replace('/(p|div)>(\s*)<(p|div)/', "$1>\n<$3", $content);
        $content = preg_replace('/<a([^>]+)href=""([^>]*)>(.*?)<\/a>/', '', $content);

        $content = trim(strip_tags($content, '<iframe><img><a>'));

        $content = preg_replace('/(<(iframe|img).*?>)/', "\n$1\n", $content);
        $content = preg_replace('/\s*<\/iframe>/', "</iframe>\n", $content);
        $content = preg_replace('/\s*[\r\n]+\s*/', "\n\n", $content);

        $enclosure = $this->item_enclosure($content);

        $enclosure_in_use = [];

        $new_parts = [];
        $parts = preg_split('/[\n]+/', $content);
        foreach ($parts as $part) {
            $part_text = trim(strip_tags($part));
            if (empty($part_text)) {
                $youtube_regexp = "/(?:http(?:s)?:\/\/)?(?:www\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([\w-]{10,12})/";
                if (preg_match($youtube_regexp, $content, $matches)) {
                    $new_parts[] = '<a href="https://www.youtube.com/watch?v=' . $matches[1] . '">YouTube</a>';
                } elseif (preg_match('!<img(.*)src="(.*)"!U', $part, $matches)) {
                    $img = urldecode($matches[2]);
                    //$img = preg_replace('/-\d+x\d+(\.\w+)$/', '$1', $img);
                    if (isset($enclosure[$img]) && !isset($enclosure_in_use[$img])) {
                        $enclosure_in_use[$img] = true;
                        if (preg_match('!<img(.*)alt="(.*)"!U', $content, $matches)) {
                            $alt = self::encode($matches[2]);
                        }
                        if (empty($alt)) {
                            $alt = $title;
                        }
                        $new_parts[] = '<img src="' . self::urlEncode($enclosure[$img]['url']) . '" alt="' . $alt . '">';
                    }
                }
            } else {
                $part = strip_tags($part, '<a>');
                if (!empty($part)) {
                    $part = preg_replace_callback('/<a(.*)href="(.*)"(.*)>/U', function ($v) {
                        $url = $v[2];
                        if (!preg_match('/https?:\/\//', $url)) {
                            $url = self::make_abs_url($url);
                        }
                        return '<a href="' . $url . '">';
                    }, $part);
                    $new_parts[] = $part;
                }
            }
        }

        $new_parts = array_map(function ($part) {
            return '<p>' . $part . '</p>';
        }, $new_parts);

        $content = implode("\n", $new_parts);
        return [$enclosure, $content];
    }

    protected function item_media($content)
    {
        $matches = $res = [];
        $return = [];

        $youtube_regexp = "/(?:http(?:s)?:\/\/)?(?:www\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([\w-]{10,12})/";
        preg_match_all($youtube_regexp, $content, $matches);
        $youtube_videos = [];
        if (isset($matches[1]) && !empty($matches[1])) {
            $youtube_videos = $matches[1];
        }
        $youtube_videos = array_unique($youtube_videos);

        if (!empty($youtube_videos)) {
            foreach ($youtube_videos as $id) {
                $return[] = [
                    'player' => 'https://www.youtube.com/embed/' . $id,
                    'thumb' => 'https://img.youtube.com/vi/' . $id . '/0.jpg',
                ];
            }
        }

        return $return;
    }

    private function item_enclosure($content)
    {
        $enclosure = $matches = $res = [];

        preg_match_all('!<img(.*)src="(.*)"!U', $content, $matches);

        //$site_domain = preg_replace('/http[s]?:\/\//', '', Yii::app()->getBaseUrl(true));
        //$site_domain = preg_replace('/\/.*/', '', $site_domain);

        if (isset($matches[2])) {
            foreach ($matches[2] as $img) {
                $img = urldecode($img);
                $enclosure[$img] = explode('?', $img)[0];
            }
        }

        if (empty($enclosure)) {
            return $enclosure;
        }

        $new_enclosure = [];
        foreach ($enclosure as $orig_src => $img) {
            //if (preg_match('/^(http[s]?:)?\/\/.*/', $img) && strpos($img, $site_domain) !== false) {
            //    $img = preg_replace('/-\d+x\d+(\.\w+)$/', '$1', $img);
            //}
            $new_enclosure[$img] = $img;
        }
        $enclosure = $new_enclosure;

        foreach ($enclosure as $orig_src => $img) {
            $mime = self::_get_mime($img);
            if (!empty($mime)) {
                $res[$orig_src] = [
                    'url' => self::make_abs_url($img),
                    'mime' => $mime,
                ];
            }
        }

        $host = Yii::app()->request->hostInfo;
        $root_path = Yii::getPathOfAlias('webroot');
        foreach ($res as $orig_src => $item) {
            if (strpos($item['url'], $host) === 0) {
                $file_path = str_replace($host, '', $item['url']);
                $full_file_path = $root_path . urldecode($file_path);
                if (is_file($full_file_path)) {
                    $sizes = @getimagesize($full_file_path);
                    if ($sizes && isset($sizes[0], $sizes[1]) && ($sizes[0] < 240 || $sizes[1] < 300)) {
                        unset($res[$orig_src]);
                    }
                }
            }
        }

        return $res;
    }

    private static function _get_mime($img)
    {
        //@to-do make this poetic
        $mime = '';

        $img = mb_strtolower($img);
        if (false !== strpos($img, '.jpg') || false !== strpos($img, '.jpeg')) {
            $mime = 'image/jpeg';
        } elseif (false !== strpos($img, '.png')) {
            $mime = 'image/png';
        } elseif (false !== strpos($img, '.gif')) {
            $mime = 'image/gif';
        }

        return $mime;
    }

    private static function make_abs_url($url)
    {
        if (preg_match('#^(https?:)?//#', $url)) {
            $url = preg_replace('/^https?:/', '', $url);
            $url = (Yii::app()->request->isSecureConnection ? 'https' : 'http') . ':' . $url;
        } else {
            $url = Yii::app()->getBaseUrl(true) . '/' . ltrim($url, '/');
        }
        return $url;
    }
}
