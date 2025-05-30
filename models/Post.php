<?php

/**
 * This is the model class for table "{{post}}".
 *
 * The followings are the available columns in table '{{post}}':
 * @property integer $id
 * @property integer $author_id
 * @property string $url
 * @property string $title
 * @property string $date
 * @property string $image
 * @property string $image_big_post
 * @property string $text
 * @property string $text_paywall
 * @property string $title_paywall
 * @property string $description_paywall
 * @property integer $status_id
 * @property integer $status_paywall
 * @property string $summary
 * @property integer $type_id
 * @property integer $comments_count
 * @property integer $views_count
 * @property string $custom_icon
 * @property integer $rubric_id
 * @property string $created_at
 * @property string $updated_at
 * @property string $image_top
 * @property string $image_news
 * @property integer $need_image_big_post
 * @property integer $is_small_top
 * @property integer $is_big_top
 * @property integer $is_home_top
 * @property integer $is_home_first_top
 * @property string $image_home_top
 * @property string $page_title
 * @property string $page_keywords
 * @property string $page_og_image
 * @property string $news_link
 * @property string $news_link_title
 * @property integer $is_gtb_post
 * @property integer $gtb_post_id
 * @property integer $is_gtu_post
 * @property integer $gtu_post_id
 * @property integer $hide_banners
 * @property integer $hide_comments
 * @property integer $hide_styles
 * @property string $description
 * @property integer $special_id
 * @property string $related_posts
 * @property string $geo_target
 * @property string $background_color
 * @property string $background_image
 * @property int $is_new
 * @property int $hide_yandex_rss
 * @property string $yandex_rss_genre
 * @property int $hide_yandex_zen
 * @property int $yandex_zen_adult
 * @property string $yandex_zen_categories
 * @property int $access_by_link
 *
 * @property City[] $cities
 * @property Country[] $countries
 * @property Author $author
 * @property Rubric $rubric
 * @property Comment[] $comments
 *
 * @method Post enabled()
 * @method Post statusEnabled()
 * @method Post sorted()
 * @method Post guides()
 * @method Post sitemap()
 * @method Post news()
 * @method Post not_news()
 * @method Post materials()
 * @method Post news_limit()
 * @method Post yandexRss()
 * @method Post yandexZen()
 */
class Post extends TravelActiveRecord
{
    const TYPE_NEWS = 1;
    const TYPE_GUIDE = 2;
    const TYPE_PHOTO = 3;
    const TYPE_POST = 4;
    const TYPE_MINIGUIDE = 5;

    const YANDEX_GENRE_MESSAGE = 'message';
    const YANDEX_GENRE_ARTICLE = 'article';
    const YANDEX_GENRE_INTERVIEW = 'interview';

    public $citiesIds = [];
    public $countriesIds = [];
    public $related_posts_ids = [];
    public $geo_target_codes = [];

    public $country_search;
    public $city_search;
    public $rubric_search;

    public $yandex_zen_categories_array = [];

    public static $monthList = [
        1 => 'Январь',
        2 => 'Февраль',
        3 => 'Март',
        4 => 'Апрель',
        5 => 'Май',
        6 => 'Июнь',
        7 => 'Июль',
        8 => 'Август',
        9 => 'Сентябрь',
        10 => 'Октябрь',
        11 => 'Ноябрь',
        12 => 'Декабрь',
    ];

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{post}}';
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['uploadImage'] = [
            'class' => 'application.behaviors.UploadFileBehavior',
            'attrName' => 'image',
            'savePath' => self::IMAGES_PATH,
        ];
        $behaviors['uploadImageBigPost'] = [
            'class' => 'application.behaviors.UploadFileBehavior',
            'attrName' => 'image_big_post',
            'savePath' => self::IMAGES_PATH,
        ];
        $behaviors['uploadImageTop'] = [
            'class' => 'application.behaviors.UploadFileBehavior',
            'attrName' => 'image_top',
            'savePath' => self::IMAGES_PATH,
        ];
        $behaviors['uploadImageNews'] = [
            'class' => 'application.behaviors.UploadFileBehavior',
            'attrName' => 'image_news',
            'savePath' => self::IMAGES_PATH,
        ];
        $behaviors['uploadImageHomeTop'] = [
            'class' => 'application.behaviors.UploadFileBehavior',
            'attrName' => 'image_home_top',
            'savePath' => self::IMAGES_PATH,
        ];
        $behaviors['uploadPageOgImage'] = [
            'class' => 'application.behaviors.UploadFileBehavior',
            'attrName' => 'page_og_image',
            'savePath' => self::IMAGES_PATH,
        ];
        $behaviors['uploadBackgroundImage'] = [
            'class' => 'application.behaviors.UploadFileBehavior',
            'attrName' => 'background_image',
            'savePath' => self::IMAGES_PATH,
            'attrDelete' => 'del_background_image',
        ];
        return $behaviors;
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return [
            ['title, date', 'required'],
            ['author_id, status_id, status_paywall, type_id, comments_count, views_count, rubric_id, need_image_big_post, is_small_top, is_big_top, is_home_top, is_home_first_top, special_id, is_gtb_post, gtb_post_id, is_gtu_post, gtu_post_id, hide_banners, hide_comments, hide_styles, is_new, hide_yandex_rss, hide_yandex_zen, yandex_zen_adult', 'numerical', 'integerOnly' => true],
            ['url, title, image, image_big_post, image_top, image_news, image_home_top, custom_icon, page_og_image, related_posts, geo_target, background_image', 'length', 'max' => 255],
            ['yandex_rss_genre', 'length', 'max' => 10],
            ['background_color', 'length', 'max' => 6],
            ['status_id', 'in', 'range' => self::getAllowedStatusRange()],
            ['type_id', 'in', 'range' => self::getAllowedTypeRange()],
            ['special_id', 'in', 'range' => self::getAllowedSpecialRange()],
            ['date, text, text_paywall, title_paywall, description_paywall, summary, yandex_zen_categories, access_by_link', 'safe'],
            ['url', 'match', 'pattern' => '/^[a-z0-9-]+$/', 'message' => 'Только "a-z", "0-9" и "-".'],
            // The following rule is used by search().
            ['id, author_id, url, title, date, image, image_big, text, text_paywall, status_id, status_paywall, summary, type_id, comments_count, views_count, custom_icon, rubric_id, need_image_big_post, special_id, hide_banners, hide_comments, hide_styles, is_new', 'safe', 'on' => 'search'],
            ['related_posts_ids, geo_target_codes, cities, countries, countriesIds, citiesIds, need_image_big_post, is_small_top, is_big_top, is_home_top, is_home_first_top, page_title, page_keywords, page_og_image, news_link, news_link_title, description, country_search, city_search, rubric_search, background_color, yandex_zen_categories_array', 'safe'],
            // default
            ['gtb_post_id, gtu_post_id', 'default', 'setOnEmpty' => true, 'value' => null],
        ];
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return [
            'cities' => [self::MANY_MANY, 'City', 'tr_post_city_assignment(post_id, city_id)'],
            'countries' => [self::MANY_MANY, 'Country', 'tr_post_country_assignment(post_id, country_id)'],
            'author' => [self::BELONGS_TO, 'Author', 'author_id'],
            'rubric' => [self::BELONGS_TO, 'Rubric', 'rubric_id'],
            'comments' => [self::HAS_MANY, 'Comment', 'post_id'],
            'userCollections' => [self::HAS_MANY, 'UserCollection', 'post_id'],
        ];
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        Yii::app()->cache->flush();
        Yii::app()->db->schema->refresh();


        return [
            'id' => 'ID',
            'author_id' => 'Автор',
            'url' => 'URL',
            'title' => 'Заголовок поста',
            'date' => 'Дата',
            'image' => 'Тизер-картинка',
            'image_big_post' => 'Большая картинка в посте',
            'image_top' => 'Картинка топа',
            'image_news' => 'Картинка новости',
            'text' => 'Текст поста',
            'text_paywall' => 'Текст до Paywall',
            'title_paywall' => 'Заголовок Paywall',
            'description_paywall' => 'Описание Paywall',
            'status_id' => 'Статус',
            'status_paywall' => 'Платный материал',
            'summary' => 'Текст тизера',
            'type_id' => 'Тип поста',
            'comments_count' => 'Комментарии',
            'views_count' => 'Просмотры',
            'custom_icon' => 'Кастомная иконка',
            'rubric_id' => 'Рубрика',
            'citiesIds' => 'Города',
            'countriesIds' => 'Страны',
            'need_image_big_post' => 'Картинка в посте',
            'is_small_top' => 'Средний топ',
            'is_big_top' => 'Супертоп в посте',
            'is_home_top' => 'Топ-растяжка',
            'is_home_first_top' => 'Топ-растяжка вверху',
            'image_home_top' => 'Картинка топа-растяжки',
            'page_title' => 'Тайтл',
            'page_keywords' => 'Ключевые слова страницы',
            'page_og_image' => 'OG-картинка',
            'news_link' => 'Ссылка источника новости',
            'news_link_title' => 'Название источника новости',
            'is_gtb_post' => 'GTB пост?',
            'gtb_post_id' => 'GTB пост',
            'is_gtu_post' => 'GTU пост?',
            'gtu_post_id' => 'GTU пост',
            'hide_banners' => 'Скрыть баннеры',
            'hide_comments' => 'Скрыть комментарии',
            'hide_styles' => 'Скрыть стили',
            'description' => 'Описание страницы',
            'country_search' => 'Страны',
            'city_search' => 'Города',
            'rubric_search' => 'Рубрика',
            'special_id' => 'Спецпроект',
            'related_posts_ids' => 'Связанные посты',
            'geo_target' => 'Гео-цели',
            'geo_target_codes' => 'Гео-цели',
            'background_color' => 'Цвет фона всего поста',
            'background_image' => 'Картинка фона всего поста',
            'is_new' => 'Пост с новыми стилями',
            'hide_yandex_rss' => 'Убрать из Яндекс Новостей',
            'yandex_rss_genre' => 'Жанр сообщения в Яндекс Новостях',
            'del_background_image' => 'Удалить картинку фона',
            'hide_yandex_zen' => 'Убрать из Яндекс Дзен',
            'yandex_zen_adult' => 'Материал только для взрослых в Яндекс Дзен',
            'yandex_zen_categories' => 'Тематика в Яндекс Дзен',
            'yandex_zen_categories_array' => 'Тематика в Яндекс Дзен',
            'access_by_link' => 'Доступ по ссылке',
        ];
    }

    /**
     * @return CActiveDataProvider
     */
    public function search()
    {
        $criteria = new CDbCriteria();
        $criteria->with = ['cities', 'countries', 'rubric'];

        $must_use_ids = false;
        $post_ids = [];

        if (!empty($this->city_search)) {
            $must_use_ids = true;
            $criteria2 = new CDbCriteria();
            $criteria2->select = 't.id';
            $criteria2->compare('t.title', $this->city_search, true);
            $criteria2->with = ['posts'];
            $criteria2->together = true;
            /** @var City[] $cities */
            $cities = City::model()->findAll($criteria2);
            foreach ($cities as $city) {
                foreach ($city->posts as $one) {
                    $post_ids[$one->id] = $one->id;
                }
            }
        }
        if (!empty($this->country_search)) {
            $criteria2 = new CDbCriteria();
            $criteria2->select = 't.id';
            $criteria2->compare('t.title', $this->country_search, true);
            $criteria2->with = ['posts'];
            $criteria2->together = true;
            /** @var Country[] $countries */
            $countries = Country::model()->findAll($criteria2);
            $_post_ids = [];
            foreach ($countries as $country) {
                foreach ($country->posts as $one) {
                    $_post_ids[$one->id] = $one->id;
                }
            }
            if ($must_use_ids) {
                $post_ids = array_intersect($post_ids, $_post_ids);
            } else {
                $post_ids = $_post_ids;
            }
            $must_use_ids = true;
        }
        if (!empty($this->rubric_search)) {
            $criteria2 = new CDbCriteria();
            $criteria2->select = 't.id';
            $criteria2->compare('t.title', $this->rubric_search, true);
            $criteria2->with = ['posts'];
            $criteria2->together = true;
            /** @var Rubric[] $rubrics */
            $rubrics = Rubric::model()->findAll($criteria2);
            $_post_ids = [];
            foreach ($rubrics as $rubric) {
                foreach ($rubric->posts as $one) {
                    $_post_ids[$one->id] = $one->id;
                }
            }
            if ($must_use_ids) {
                $post_ids = array_intersect($post_ids, $_post_ids);
            } else {
                $post_ids = $_post_ids;
            }
            $must_use_ids = true;
        }

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.author_id', $this->author_id);
        $criteria->compare('t.url', $this->url, true);
        $criteria->compare('t.title', $this->title, true);
        $criteria->compare('t.date', $this->date, true);
        $criteria->compare('t.status_id', $this->status_id);
        $criteria->compare('t.type_id', $this->type_id);
        $criteria->compare('t.rubric_id', $this->rubric_id);
        $criteria->compare('t.is_small_top', $this->is_small_top);
        $criteria->compare('t.is_big_top', $this->is_big_top);
        $criteria->compare('t.is_home_top', $this->is_home_top);
        $criteria->compare('t.is_home_first_top', $this->is_home_first_top);
        $criteria->compare('t.page_title', $this->page_title);
        $criteria->compare('t.page_keywords', $this->page_keywords);
        $criteria->compare('t.news_link', $this->news_link);
        $criteria->compare('t.news_link_title', $this->news_link_title);
        $criteria->compare('t.hide_banners', $this->hide_banners);
        $criteria->compare('t.hide_comments', $this->hide_comments);
        $criteria->compare('t.hide_styles', $this->hide_styles);
        $criteria->compare('t.background_color', $this->background_color, true);
        $criteria->compare('t.is_new', $this->is_new);

        if ($must_use_ids) {
            $criteria->addInCondition('t.id', $post_ids);
        }

        return new CActiveDataProvider($this, [
            'criteria' => $criteria,
            'sort' => [
                'defaultOrder' => 't.date DESC',
            ],
            'pagination' => [
                'pageSize' => self::PAGE_SIZE,
            ],
        ]);
    }

    /**
     * Scopes conditions
     * @return array
     */
    public function scopes()
    {
        return array_merge(parent::scopes(), [
            'enabled' => [
                'condition' => 't.status_id = :status_id AND t.date <= NOW() AND t.access_by_link = 0',
                'params' => [':status_id' => self::STATUS_ENABLED],
            ],
            'statusEnabled' => [
                'condition' => 't.status_id = :status_id AND t.date <= NOW()',
                'params' => [':status_id' => self::STATUS_ENABLED],
            ],
            'sorted' => [
                'order' => 't.date DESC, t.created_at DESC',
            ],
            'sitemap' => [
                'select' => 'url, date',
                'condition' => 'status_id = :status_id AND date <= NOW()',
                'params' => [':status_id' => self::STATUS_ENABLED],
                'order' => 'date DESC, id DESC',
            ],
            'guides' => [
                'condition' => '(t.type_id = :type_id1 OR t.type_id = :type_id2)',
                'params' => [':type_id1' => self::TYPE_GUIDE, ':type_id2' => self::TYPE_MINIGUIDE],
            ],
            'news' => [
                'condition' => 't.type_id = :type_id',
                'params' => [':type_id' => self::TYPE_NEWS],
                'order' => 't.date DESC, t.created_at DESC',
            ],
            'materials' => [
                'condition' => 't.type_id IN (:type_id1, :type_id2) ',
                'params' => [':type_id1' => self::TYPE_POST, ':type_id2' => self::TYPE_PHOTO],
            ],
            'not_news' => [
                'condition' => 't.type_id != :type_id',
                'params' => [':type_id' => self::TYPE_NEWS],
            ],
            'yandexRss' => [
                'condition' => 't.hide_yandex_rss = 0 AND t.is_gtb_post = 0 AND t.is_gtu_post = 0',
            ],
            'yandexZen' => [
                'condition' => 't.hide_yandex_zen = 0 AND t.is_gtb_post = 0 AND t.is_gtu_post = 0',
            ],
        ]);
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Post the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return array
     */
    public static function getSpecialOptions()
    {
        return SpecialProject::getItems();
    }

    /**
     * @return array
     */
    public static function getTypeOptions()
    {
        return [
            self::TYPE_NEWS => 'Новость',
            self::TYPE_GUIDE => 'Гайд',
            self::TYPE_MINIGUIDE => 'Мини-гайд',
            self::TYPE_PHOTO => 'Фотоистория',
            self::TYPE_POST => 'Обычный',
        ];
    }

    /**
     * @return array
     */
    public static function getAllowedSpecialRange()
    {
        $items = SpecialProject::getItems();
        return array_keys($items);
    }

    /**
     * @return array
     */
    public static function getAllowedTypeRange()
    {
        return array_keys(self::getTypeOptions());
    }

    /**
     * @param int $typeID
     * @return $this
     */
    public function filterType($typeID)
    {
        $tableAlias = $this->getTableAlias();
        $typeID = in_array($typeID, $this->getAllowedTypeRange()) ? $typeID : self::TYPE_POST;
        $this->getDbCriteria()->mergeWith([
            'condition' => $tableAlias . '.type_id = ' . $typeID,
        ]);
        return $this;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        if ($this->is_gtb_post == 1 && !empty($this->gtb_post_id)) {
            $url = GtbPost::getUrlById($this->gtb_post_id);
            if ($url) {
                return $url;
            }
        }
        if ($this->is_gtu_post == 1 && !empty($this->gtu_post_id)) {
            $url = GtuPost::getUrlById($this->gtu_post_id);
            if ($url) {
                return $url;
            }
        }
        if (!empty($this->url)) {
            return Yii::app()->getBaseUrl(true) . '/post/' . $this->url;
        }
        return '#';
    }

    /**
     * @param string $attr
     * @return string
     */
    public function getBgColor($attr = 'background_color')
    {
        $bg_color = str_replace('#', '', $this->$attr);

        return $bg_color;
    }

    /**
     * @inheritdoc
     */
    protected function beforeSave()
    {
        if (parent::beforeSave()) {
            // related_posts
            $related_posts_ids = [];
            foreach ($this->related_posts_ids as $rid) {
                $rid = (int)$rid;
                if ($rid > 0) {
                    $related_posts_ids[] = $rid;
                }
            }
            $this->related_posts = implode(',', $related_posts_ids);
            // geo_target
            if (!is_array($this->geo_target_codes) || empty($this->geo_target_codes)) {
                $this->geo_target = '';
            } else {
                $geo_target_codes = [];
                foreach ($this->geo_target_codes as $code) {
                    if (!empty($code) && isset(Yii::app()->params['countries'][$code])) {
                        $geo_target_codes[] = $code;
                    }
                }
                $this->geo_target = implode(',', $geo_target_codes);
            }
            // date
            $this->date = date('Y-m-d H:i:00', strtotime($this->date));
            // force post with new styles
            if ($this->isNewRecord) {
                $this->is_new = 1;
            }
            // zen
            if (is_array($this->yandex_zen_categories_array)) {
                $this->yandex_zen_categories = implode(',', $this->yandex_zen_categories_array);
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * @inheritdoc
     */
    protected function afterFind()
    {
        $this->date = date('Y-m-d H:i', strtotime($this->date));
        $this->related_posts_ids = preg_split('/\s*,\s*/', trim($this->related_posts), -1, PREG_SPLIT_NO_EMPTY);
        $this->geo_target_codes = preg_split('/\s*,\s*/', trim($this->geo_target), -1, PREG_SPLIT_NO_EMPTY);
        $this->yandex_zen_categories_array = preg_split('/\s*,\s*/', trim($this->yandex_zen_categories), -1, PREG_SPLIT_NO_EMPTY);
        parent::afterFind();
    }

    /**
     * @inheritdoc
     */
    protected function afterSave()
    {
        parent::afterSave();

        $runtime = Yii::getPathOfAlias('application.runtime');
        $cache_filename = 'rss.xml';
        if (is_file($runtime . '/' . $cache_filename)) {
            @unlink(($runtime . '/' . $cache_filename));
        }
        $cache_filename = 'yandex.news.xml';
        if (is_file($runtime . '/' . $cache_filename)) {
            @unlink(($runtime . '/' . $cache_filename));
        }
    }

    /** @var GtbPost[] */
    private static $_gtb_posts = [];

    /** @var GtuPost[] */
    private static $_gtu_posts = [];

    /**
     * @return int
     */
    public function getViewsCount()
    {
        if ($this->is_gtb_post == 1 && !empty($this->gtb_post_id)) {
            if (!array_key_exists($this->gtb_post_id, self::$_gtb_posts)) {
                self::$_gtb_posts[$this->gtb_post_id] = GtbPost::model()->findByPk($this->gtb_post_id);
            }
            if (isset(self::$_gtb_posts[$this->gtb_post_id])) {
                return self::$_gtb_posts[$this->gtb_post_id]->views_count;
            }
        }
        if ($this->is_gtu_post == 1 && !empty($this->gtu_post_id)) {
            if (!array_key_exists($this->gtu_post_id, self::$_gtu_posts)) {
                self::$_gtu_posts[$this->gtu_post_id] = GtuPost::model()->findByPk($this->gtu_post_id);
            }
            if (isset(self::$_gtu_posts[$this->gtu_post_id])) {
                return self::$_gtu_posts[$this->gtu_post_id]->views_count;
            }
        }
        return $this->views_count;
    }

    /**
     * @return int
     */
    public function getCommentsCount()
    {
        if ($this->is_gtb_post == 1 && !empty($this->gtb_post_id)) {
            if (!array_key_exists($this->gtb_post_id, self::$_gtb_posts)) {
                self::$_gtb_posts[$this->gtb_post_id] = GtbPost::model()->findByPk($this->gtb_post_id);
            }
            if (isset(self::$_gtb_posts[$this->gtb_post_id])) {
                return self::$_gtb_posts[$this->gtb_post_id]->comments_count;
            }
        }
        if ($this->is_gtu_post == 1 && !empty($this->gtu_post_id)) {
            return 0;
        }
        return $this->comments_count;
    }

    /**
     * @return string
     */
    public function getGtbPostLang()
    {
        if ($this->is_gtb_post == 1 && !empty($this->gtb_post_id)) {
            if (!array_key_exists($this->gtb_post_id, self::$_gtb_posts)) {
                self::$_gtb_posts[$this->gtb_post_id] = GtbPost::model()->findByPk($this->gtb_post_id);
            }
            if (isset(self::$_gtb_posts[$this->gtb_post_id])) {
                return self::$_gtb_posts[$this->gtb_post_id]->language;
            }
        }
        return '';
    }

    /**
     * @return string
     */
    public function getRubricTitle()
    {
        if ($this->is_gtb_post == 1) {
            //return $this->getGtbPostLang() == 'en' ? 'Go to Belarus' : 'Едем в Беларусь';
            switch ($this->getGtbPostLang()) {
                case 'en':
                    $rubricTitle = 'Go to Belarus';
                    break;
                case 'be':
                    $rubricTitle = 'Падарожжы па Беларусі';
                    break;
                case 'ru':
                default:
                    $rubricTitle = 'Едем в Беларусь';
                    break;
            }
            return $rubricTitle;
        } elseif ($this->is_gtu_post == 1) {
            return 'Go to Ukraine';
        } elseif ($this->isAnyGuide()) {
            return 'Гайды';
        } else {
            return !empty($this->rubric) ? $this->rubric->title : '';
        }
    }

    /**
     * @return bool
     */
    public function isNews()
    {
        return $this->type_id == self::TYPE_NEWS;
    }

    /**
     * @return bool
     */
    public function isAnyGuide()
    {
        return $this->type_id == self::TYPE_GUIDE || $this->type_id == self::TYPE_MINIGUIDE;
    }

    /**
     * @return bool
     */
    public function isEnabled()
    {
        return $this->status_id == self::STATUS_ENABLED && $this->date <= date('Y-m-d H:i:s');
    }

    /**
     * Adds a comment to this taxi
     * @param Comment $comment
     * @return bool
     */
    public function addComment($comment)
    {
        $comment->post_id = $this->id;
        if (!Yii::app()->user->isGuest && Yii::app()->user->getOAuthProfile()) {
            $comment->create_user_id = Yii::app()->user->id;
        }
        return $comment->save();
    }

    /**
     * @return array
     */
    public function getCommentsTreeList()
    {
        $criteria = new CDbCriteria();
        $criteria->compare('post_id', $this->id);
        $criteria->order = 'created_at DESC';
        $comments = Comment::model()->findAll($criteria);

        $commentsTree = $this->_buildTree($comments);
        return $commentsTree;
    }

    /**
     * @param array $elements
     * @param int $parentId
     * @param int $level
     * @return array
     */
    private function _buildTree(array $elements, $parentId = 0, $level = 0)
    {
        $branch = [];

        foreach ($elements as $element) {
            if ($element->parent_id == $parentId) {
                $element->level = $level;
                $children = $this->_buildTree($elements, $element->id, $level + 1);
                if ($children) {
                    $element->children = $children;
                }
                $branch[] = $element;
                foreach ($children as $child) {
                    $branch[] = $child;
                }
            }
        }

        return $branch;
    }

    /**
     * @param int $limit
     * @return Post[]
     */
    public function getRelatedPostsList($limit = 6)
    {
        $postTAlias = $this->getTableAlias();
        $excludePostsIds = [$this->id];

        /** @var Post[] $relatedPosts */
        $relatedPosts = [];

        if (!empty($this->related_posts_ids)) {
            $criteria = new GeoDbCriteria();
            $criteria->with = ['rubric'];
            $criteria->addNotInCondition($postTAlias . '.id', $excludePostsIds);
            $criteria->addInCondition($postTAlias . '.id', $this->related_posts_ids);
            $criteria->offset = 0;
            $criteria->limit = $limit;
            $relatedPosts = self::model()->enabled()->not_news()->findAll($criteria);
        }
        if (count($relatedPosts) == 0) {
            $rubric_id = (int)$this->rubric_id;
            $criteria = new GeoDbCriteria();
            $criteria->select = '*, rand() as rand';
            $criteria->with = ['rubric'];
            $criteria->addNotInCondition($postTAlias . '.id', $excludePostsIds);
            if ($rubric_id > 0) {
                $criteria->addCondition('rubric_id = ' . $rubric_id);
            }
            $criteria->order = 'rand'; //$postTAlias . '. date DESC, ' . $postTAlias . '. created_at DESC';
            $criteria->offset = 0;
            $criteria->limit = $limit;
            $relatedPosts = self::model()->enabled()->not_news()->findAll($criteria);
        }

        return $relatedPosts;
    }

    /**
     * Еще посты под постом "Сейчас на главной"
     * @param array $counters
     * @param int $rowsPerPage
     * @param int $postId
     * @return array
     */
    public function getPostsList($counters, $rowsPerPage, $postId)
    {
        // using 'other' (int) and 'smallTop' (int) in $counters

        $excludePostsIds = [$postId];

        $postTAlias = self::model()->getTableAlias();

        /** @var self[] $postsPool */
        $postsPool = [];

        // local small top posts
        $criteria = new GeoDbCriteria();
        $criteria->with = ['rubric'];
        $criteria->addNotInCondition($postTAlias . '.id', $excludePostsIds);
        $criteria->addCondition('is_small_top = ' . self::YES);
        $criteria->order = $postTAlias . '. date DESC, ' . $postTAlias . '. created_at DESC';
        $criteria->offset = $counters['smallTop'];
        $criteria->limit = $rowsPerPage * 3;
        $otherSmallTopPostsPool = self::model()->enabled()->not_news()->findAll($criteria);

        foreach ($otherSmallTopPostsPool as $one) {
            $postsPool[$one->date . '_' . $one->created_at] = $one;
        }

        // other simple posts pool
        $criteria = new GeoDbCriteria();
        $criteria->with = ['rubric'];
        $criteria->addNotInCondition($postTAlias . '.id', $excludePostsIds);
        $criteria->addCondition('is_small_top = ' . self::NO);
        $criteria->order = $postTAlias . '. date DESC, ' . $postTAlias . '. created_at DESC';
        $criteria->offset = $counters['other'];
        $criteria->limit = $rowsPerPage * 3;
        $otherPostsPool = self::model()->enabled()->not_news()->findAll($criteria);

        foreach ($otherPostsPool as $one) {
            $postsPool[$one->date . '_' . $one->created_at] = $one;
        }

        krsort($postsPool, SORT_STRING);

        // current number of row we are adding posts to
        $currentRow = 0;

        $showMore = false;
        $resultPostsList = [];

        while (count($postsPool) > 0) {
            $colCount = 0;
            // col 1, 2 (and 3 if no banner)
            foreach ($postsPool as $k => $post) {
                if ($colCount >= 2) {
                    break;
                }
                if ($post->is_small_top == self::YES) {
                    $resultPostsList[] = $post;
                    $colCount += 2;
                    $counters['smallTop'] += 1;
                    unset($postsPool[$k]);
                } else {
                    $resultPostsList[] = $post;
                    $colCount += 1;
                    $counters['other'] += 1;
                    unset($postsPool[$k]);
                }
            }
            // fill last col
            if ($colCount == 2) {
                foreach ($postsPool as $k => $post) {
                    if ($post->is_small_top == self::NO) {
                        $resultPostsList[] = $post;
                        $counters['other'] += 1;
                        unset($postsPool[$k]);
                        break;
                    }
                }
            }
            $currentRow++;

            if ($currentRow >= $rowsPerPage) {
                if (count($postsPool) > 0) {
                    $showMore = true;
                }
                break;
            }
        }

        return [
            'resultPostsList' => $resultPostsList,
            'showMore' => $showMore,
            'counters' => $counters,
        ];
    }

    /**
     * Для главной с новым дизайном
     * @param array $counters
     * @param int $rowsPerPage
     * @param bool $firstPage
     * @return array
     */
    public static function getHomePostsList($counters, $rowsPerPage, $firstPage = true)
    {
        $excluded = !empty($counters['excluded']) ? explode('-', $counters['excluded']) : [];

        $postTAlias = self::model()->getTableAlias();

        // первый топ на главной
        $criteria = new GeoDbCriteria();
        $criteria->compare('is_home_top', self::YES);
        $criteria->compare('is_home_first_top', self::YES);
        $criteria->order = 'date DESC';
        $criteria->limit = 1;
        /** @var self $firstHomeTopPost */
        $firstHomeTopPost = self::model()->enabled()->find($criteria);
        if ($firstHomeTopPost !== null) {
            $excluded[] = $firstHomeTopPost->id;
        }

        if (!$firstPage) {
            $firstHomeTopPost = null;
        }

        // news
        $criteria = new GeoDbCriteria();
        $criteria->with = ['rubric'];
        if (count($excluded) > 0) {
            $criteria->addNotInCondition($postTAlias . '.id', $excluded);
        }
        $criteria->order = $postTAlias . '. date DESC, ' . $postTAlias . '. created_at DESC';
        $criteria->offset = $counters['news'];
        $criteria->limit = $rowsPerPage * 5 + 5;
        /** @var self[] $newsPool */
        $newsPool = self::model()->enabled()->news()->findAll($criteria);

        /** @var self[] $postsPool */
        $postsPool = [];

        // local small top posts
        $criteria = new GeoDbCriteria();
        $criteria->with = ['rubric'];
        if (count($excluded) > 0) {
            $criteria->addNotInCondition($postTAlias . '.id', $excluded);
        }
        $criteria->addCondition('is_small_top = ' . self::YES);
        $criteria->order = $postTAlias . '. date DESC, ' . $postTAlias . '. created_at DESC';
        $criteria->offset = $counters['smallTop'];
        $criteria->limit = $rowsPerPage * 4 + 10;
        /** @var self[] $otherSmallTopPostsPool */
        $otherSmallTopPostsPool = self::model()->enabled()->not_news()->findAll($criteria);

        foreach ($otherSmallTopPostsPool as $one) {
            $postsPool[$one->date . '_' . $one->created_at] = $one;
        }

        // other simple posts pool
        $criteria = new GeoDbCriteria();
        $criteria->with = ['rubric'];
        if (count($excluded) > 0) {
            $criteria->addNotInCondition($postTAlias . '.id', $excluded);
        }
        $criteria->addCondition('is_small_top = ' . self::NO);
        $criteria->order = $postTAlias . '. date DESC, ' . $postTAlias . '. created_at DESC';
        $criteria->offset = $counters['other'];
        $criteria->limit = $rowsPerPage * 4 + 10;
        /** @var self[] $otherPostsPool */
        $otherPostsPool = self::model()->enabled()->not_news()->findAll($criteria);

        foreach ($otherPostsPool as $one) {
            $postsPool[$one->date . '_' . $one->created_at] = $one;
        }

        krsort($postsPool, SORT_STRING);

        // find first home top
        if (!$firstPage) {
            foreach ($postsPool as $k => $one) {
                if ($one->is_home_top == self::YES) {
                    $firstHomeTopPost = $one;
                    if ($one->is_small_top == self::YES) {
                        $counters['smallTop'] += 1;
                    } else {
                        $counters['other'] += 1;
                    }
                    $excluded[] = $one->id;
                    unset($postsPool[$k]);
                    break;
                }
            }
        }

        /** @var self[] $otherHomeTopPosts */
        $otherHomeTopPosts = [];

        // find other home tops
        $topCount = 0;
        foreach ($postsPool as $k => $one) {
            if ($topCount >= 3) {
                break;
            }
            if ($one->is_home_top == self::YES) {
                $otherHomeTopPosts[] = $one;
                if ($one->is_small_top == self::YES) {
                    $counters['smallTop'] += 1;
                } else {
                    $counters['other'] += 1;
                }
                $excluded[] = $one->id;
                unset($postsPool[$k]);
                $topCount++;
            }
        }

        // banners for top and middle row
        $rowsBannersPool = [
            'top' => null,
            'middle' => null,
        ];
        if ($firstPage) {
            $homeTopBanner = Banner::getByPlace(Banner::PLACE_HOME_TOP_VERTICAL);
            $homeMiddleBanner = Banner::getByPlace(Banner::PLACE_HOME_MIDDLE_VERTICAL);

            if (!empty($homeTopBanner)) {
                $rowsBannersPool['top'] = [
                    'type' => 'banner',
                    'content' => BannerHelper::getHtml($homeTopBanner),
                ];
            }

            if (!empty($homeMiddleBanner)) {
                $rowsBannersPool['middle'] = [
                    'type' => 'banner',
                    'content' => BannerHelper::getHtml($homeMiddleBanner),
                ];
            }
        }

        // current number of row we are adding posts to
        $currentRow = 0;

        $showMore = false;
        $resultPostsList = [];

        while (count($postsPool) > 0) {
            if ($currentRow % 3 == 0) {
                // news & banners
                $colCount = 0;
                if (!empty($newsPool)) {
                    $rowPosts = array_splice($newsPool, 0, 5);
                    $object = new stdClass();
                    $object->type = 'news';
                    $object->value = $rowPosts;
                    $resultPostsList[] = $object;
                    $counters['news'] += count($rowPosts);
                    $colCount += 1;
                }
                // get banner
                $banner = null;
                if ($currentRow == 0 && !empty($rowsBannersPool['top'])) {
                    $banner = (object)$rowsBannersPool['top'];
                }
                // col 1, 2 (and 3 if no banner)
                foreach ($postsPool as $k => $post) {
                    if ($colCount >= ($banner !== null ? 2 : 3)) {
                        break;
                    }
                    if ($post->is_small_top == self::YES) {
                        $resultPostsList[] = $post;
                        $colCount += 2;
                        $counters['smallTop'] += 1;
                        unset($postsPool[$k]);
                    } else {
                        $resultPostsList[] = $post;
                        $colCount += 1;
                        $counters['other'] += 1;
                        unset($postsPool[$k]);
                    }
                }
                // fill last col
                if ($colCount == ($banner !== null ? 2 : 3)) {
                    foreach ($postsPool as $k => $post) {
                        if ($post->is_small_top == self::NO) {
                            $resultPostsList[] = $post;
                            $counters['other'] += 1;
                            unset($postsPool[$k]);
                            break;
                        }
                    }
                }
                // set banner
                if ($banner !== null) {
                    $resultPostsList[] = $banner;
                }
            } else {
                $colCount = 0;
                // get banner
                $banner = null;
                if ($currentRow == 1 && !empty($rowsBannersPool['middle'])) {
                    $banner = (object)$rowsBannersPool['middle'];
                }
                // usual posts
                if ($currentRow % 3 == 2) {
                    // news
                    if (!empty($newsPool)) {
                        $rowPosts = array_splice($newsPool, 0, 5);
                        $object = new stdClass();
                        $object->type = 'news';
                        $object->value = $rowPosts;
                        $resultPostsList[] = $object;
                        $counters['news'] += count($rowPosts);
                        $colCount += 1;
                    }
                }
                foreach ($postsPool as $k => $post) {
                    if ($colCount >= ($banner !== null ? 2 : 3)) {
                        break;
                    }
                    if ($post->is_small_top == self::YES) {
                        $resultPostsList[] = $post;
                        $colCount += 2;
                        $counters['smallTop'] += 1;
                        unset($postsPool[$k]);
                    } else {
                        $resultPostsList[] = $post;
                        $colCount += 1;
                        $counters['other'] += 1;
                        unset($postsPool[$k]);
                    }
                }
                // fill last col
                if ($colCount == ($banner !== null ? 2 : 3)) {
                    foreach ($postsPool as $k => $post) {
                        if ($post->is_small_top == self::NO) {
                            $resultPostsList[] = $post;
                            $counters['other'] += 1;
                            unset($postsPool[$k]);
                            break;
                        }
                    }
                }
                // set banner
                if ($banner !== null) {
                    $resultPostsList[] = $banner;
                }
            }

            $currentRow++;

            if ($currentRow >= $rowsPerPage) {
                if (count($postsPool) > 0) {
                    $showMore = true;
                }
                break;
            }
        }

        // если остались топы (а вдруг!), уменьшить кол-во использованных постов
        foreach ($otherHomeTopPosts as $one) {
            if ($one->is_big_top == self::YES) {
                $counters['smallTop'] -= 1;
            } else {
                $counters['other'] -= 1;
            }
        }

        $excluded = array_unique($excluded);

        $counters['excluded'] = implode('-', $excluded);

        return [
            'firstHomeTopPost' => $firstHomeTopPost,
            'otherHomeTopPosts' => $otherHomeTopPosts,
            'resultPostsList' => $resultPostsList,
            'showMore' => $showMore,
            'counters' => $counters,
        ];
    }

    /**
     * @return string
     */
    public static function getLastPostDate()
    {
        $criteria = new GeoDbCriteria();
        $criteria->select = 'date';
        $criteria->order = 'date DESC, created_at DESC';
        $criteria->limit = 1;
        $post = self::model()->enabled()->find($criteria);
        return ($post !== null) ? $post->date : '';
    }

    /**
     * @return string
     */
    public static function getLastNewsDate()
    {
        $criteria = new GeoDbCriteria();
        $criteria->select = 'date';
        $criteria->order = 'date DESC, created_at DESC';
        $criteria->limit = 1;
        $post = self::model()->enabled()->news()->find($criteria);
        return ($post !== null) ? $post->date : '';
    }

    /**
     * @return array
     */
    public static function yandexGenres()
    {
        return [
            self::YANDEX_GENRE_MESSAGE => 'Новостное сообщение (message)',
            self::YANDEX_GENRE_ARTICLE => 'Статья (article)',
            self::YANDEX_GENRE_INTERVIEW => 'Интервью (interview)',
        ];
    }

    private static $_items;

    /**
     * @return array
     */
    public static function getItems()
    {
        if (self::$_items === null) {
            /** @var self[] $models */
            $models = self::model()->findAll(['order' => 'date DESC, created_at DESC']);
            foreach ($models as $one) {
                self::$_items[$one->id] = $one->title . ' (' . strtoupper($one->language) . ')';
            }
        }
        return self::$_items;
    }

    public function getDateCreate()
    {
        return date('d.m.Y', strtotime($this->date));
    }

    public function getPostText($model, $text)
    {
        if (Yii::app()->userComponent->isAuthenticated()) {
            $content = $this->getText($model, $text);
        } else {
            $content = $this->getPaywallText($model, $text);
        }

        return $content;
    }

    public function getText($model, $text)
    {
        if (!Yii::app()->userComponent->checkMySubscription()) {
            $content = $this->getContent($model, $text);
        } else {
            $content = $this->getPaywallText($model, $text);
        }
        return $content;
    }

    public function getContent($model, $text)
    {
        switch ($model->url) {
            case 'destinations2018':
                $content = Yii::app()->controller->renderPartial('//postparts/_destinations2018', ['text' => $text]);
                break;
            case 'winter-roulette':
                $content = Yii::app()->controller->renderPartial('//postparts/_winter-roulette', ['text' => $text]);
                break;
            case 'business-trip':
                $content = $text . ' ' . Yii::app()->controller->renderPartial('//postparts/_business-trip', ['text' => $text]);
                break;
            default:
                $content = $text;
                break;
        }

        return $content;
    }

    public function getPaywallText($model, $text)
    {
        if (empty($model->status_paywall)){
            return $this->getContent($model, $text);
        }

        if (empty($model->text_paywall)) {
            $setting = Setting::model()->findByAttributes(['name' => 'paywall']);

            if (empty($setting)) {
                $content = '';
            } else {
                $content = $setting->description;
            }
        } else {
            $content = $model->text_paywall;
        }

        return $content;
    }

    public function isFavorite()
    {
        $userId = Yii::app()->session['user_id'];
        $favorite = UserCollection::model()->findByAttributes([
            'post_id' => $this->id,
            'user_id' => $userId
        ]);

        if (empty($favorite)) {
            return false;
        }

        return true;
    }

    /**
     * Умови відображення Paywall для поста
     * @param $model
     * @return bool
     */
    public static function checkPostPaywall($model)
    {
        $content = $model['text'];

        if (!Yii::app()->userComponent->isAuthenticated()) {
            return true; // Увімкнути Paywall
        }

        if (Yii::app()->userComponent->checkMySubscription()){
            return true; // Увімкнути Paywall
        }

        $status = false;
        if (strpos($content, '@paywall') !== false) {
            $status = true;
        }

        return $status;
    }
}



