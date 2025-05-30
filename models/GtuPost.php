<?php

/**
 * This is the model class for table "{{gtu_post}}".
 *
 * The followings are the available columns in table '{{gtu_post}}':
 * @property integer $id
 * @property integer $author_id
 * @property integer $gtu_rubric_id
 * @property integer $type_id
 * @property string $language
 * @property string $url
 * @property string $title
 * @property string $page_title
 * @property string $page_keywords
 * @property string $page_description
 * @property string $page_og_image
 * @property string $date
 * @property string $image
 * @property integer $is_top
 * @property string $image_top
 * @property integer $is_big_top
 * @property integer $is_home_big_top
 * @property string $image_big_top
 * @property integer $is_supertop
 * @property string $image_supertop
 * @property integer $is_home_supertop
 * @property string $image_home_supertop
 * @property integer $is_image_in_post
 * @property string $image_in_post
 * @property string $summary
 * @property string $text
 * @property string $background_color
 * @property string $background_image
 * @property integer $hide_banners
 * @property integer $hide_styles
 * @property integer $hide_yandex_rss
 * @property string $yandex_rss_genre
 * @property integer $hide_yandex_zen
 * @property integer $yandex_zen_adult
 * @property string $yandex_zen_categories
 * @property integer $views_count
 * @property string $related_posts
 * @property integer $status_id
 * @property string $created_at
 * @property string $updated_at
 * @property int $access_by_link
 *
 * The followings are the available model relations:
 * @property Author $author
 * @property GtuRubric $gtuRubric
 *
 * @method GtuPost enabled()
 * @method GtuPost statusEnabled()
 * @method GtuPost sorted()
 * @method GtuPost sitemapRu()
 * @method GtuPost sitemapEn()
 * @method GtuPost currentLanguage()
 * @method GtuPost yandexRss()
 * @method GtuPost yandexZen()
 */
class GtuPost extends TravelActiveRecord
{
    const TYPE_POST = 1;
    const TYPE_GUIDE = 2;

    const YANDEX_GENRE_MESSAGE = 'message';
    const YANDEX_GENRE_ARTICLE = 'article';
    const YANDEX_GENRE_INTERVIEW = 'interview';

    public $display_as_big = false;

    public $related_posts_ids = [];

    public $rubric_search;

    public $yandex_zen_categories_array = [];

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{gtu_post}}';
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
        $behaviors['uploadImageTop'] = [
            'class' => 'application.behaviors.UploadFileBehavior',
            'attrName' => 'image_top',
            'savePath' => self::IMAGES_PATH,
        ];
        $behaviors['uploadImageBigTop'] = [
            'class' => 'application.behaviors.UploadFileBehavior',
            'attrName' => 'image_big_top',
            'savePath' => self::IMAGES_PATH,
        ];
        $behaviors['uploadImageSupertop'] = [
            'class' => 'application.behaviors.UploadFileBehavior',
            'attrName' => 'image_supertop',
            'savePath' => self::IMAGES_PATH,
        ];
        $behaviors['uploadImageHomeSupertop'] = [
            'class' => 'application.behaviors.UploadFileBehavior',
            'attrName' => 'image_home_supertop',
            'savePath' => self::IMAGES_PATH,
        ];
        $behaviors['uploadImageInPost'] = [
            'class' => 'application.behaviors.UploadFileBehavior',
            'attrName' => 'image_in_post',
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
            ['url, title', 'required'],
            ['author_id, gtu_rubric_id, type_id, is_top, is_big_top, is_home_big_top, is_supertop, is_home_supertop, is_image_in_post, hide_banners, hide_styles, hide_yandex_rss, hide_yandex_zen, yandex_zen_adult, views_count, status_id', 'numerical', 'integerOnly' => true],
            ['language, background_color', 'length', 'max' => 6],
            ['url', 'length', 'max' => 100],
            ['title, page_title, page_keywords, page_og_image, image, image_top, image_big_top, image_supertop, image_home_supertop, image_in_post, background_image, related_posts', 'length', 'max' => 255],
            ['yandex_rss_genre', 'length', 'max' => 10],
            ['page_description, date, summary, text, yandex_zen_categories', 'safe'],
            ['created_at, updated_at', 'date', 'format' => 'yyyy-MM-dd hh:mm:ss'],
            ['date, created_at, updated_at', 'default', 'setOnEmpty' => true, 'value' => null],
            ['status_id', 'in', 'range' => self::getAllowedStatusRange()],
            ['type_id', 'in', 'range' => self::getAllowedTypeRange()],
            ['url', 'match', 'pattern' => '/^[a-z0-9-]+$/', 'message' => 'Только a-z, 0-9 и -'],
            ['related_posts_ids, yandex_zen_categories_array, access_by_link', 'safe'],
            // The following rule is used by search().
            ['id, author_id, gtu_rubric_id, type_id, language, url, title, page_title, page_keywords, page_description, page_og_image, date, image, is_top, image_top, is_big_top, is_home_big_top, image_big_top, is_supertop, image_supertop, is_home_supertop, image_home_supertop, is_image_in_post, image_in_post, summary, text, background_color, background_image, hide_banners, hide_styles, hide_yandex_rss, yandex_rss_genre, hide_yandex_zen, yandex_zen_adult, yandex_zen_categories, views_count, related_posts, status_id, created_at, updated_at', 'safe', 'on' => 'search'],
        ];
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return [
            'author' => [self::BELONGS_TO, 'Author', 'author_id'],
            'gtuRubric' => [self::BELONGS_TO, 'GtuRubric', 'gtu_rubric_id'],
        ];
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
            'sitemapUk' => [
                'select' => 'url, date, language',
                'condition' => 'language = :language AND status_id = :status_id AND date <= NOW()',
                'params' => [':language' => 'uk', ':status_id' => self::STATUS_ENABLED],
                'order' => 'date DESC, id DESC',
            ],
            'sitemapRu' => [
                'select' => 'url, date, language',
                'condition' => 'language = :language AND status_id = :status_id AND date <= NOW()',
                'params' => [':language' => 'ru', ':status_id' => self::STATUS_ENABLED],
                'order' => 'date DESC, id DESC',
            ],
            'sitemapEn' => [
                'select' => 'url, date, language',
                'condition' => 'language = :language AND status_id = :status_id AND date <= NOW()',
                'params' => [':language' => 'en', ':status_id' => self::STATUS_ENABLED],
                'order' => 'date DESC, id DESC',
            ],
            'currentLanguage' => [
                'condition' => 't.language = :language',
                'params' => [':language' => Yii::app()->language],
            ],
            'yandexRss' => [
                'condition' => 't.hide_yandex_rss = 0 AND t.language = :language',
                'params' => [':language' => 'ru'],
            ],
            'yandexZen' => [
                'condition' => 't.hide_yandex_zen = 0 AND t.language = :language',
                'params' => [':language' => 'ru'],
            ],
        ]);
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'author_id' => Yii::t('app', 'Author'),
            'gtu_rubric_id' => Yii::t('app', 'Rubric'),
            'type_id' => 'Тип поста',
            'language' => 'Лента / язык',
            'url' => 'URL',
            'title' => Yii::t('app', 'Title'),
            'page_title' => Yii::t('app', 'Page Title'),
            'page_keywords' => Yii::t('app', 'Page Keywords'),
            'page_description' => Yii::t('app', 'Page Description'),
            'page_og_image' => Yii::t('app', 'Page Og Image'),
            'date' => 'Дата',
            'image' => 'Тизер-картинка',
            'is_top' => 'Средний топ',
            'image_top' => 'Картинка среднего топа',
            'is_big_top' => 'Топ-растяжка',
            'is_home_big_top' => 'Топ-растяжка вверху',
            'image_big_top' => 'Картинка топ-растяжки',
            'is_supertop' => 'Супертоп в посте',
            'image_supertop' => 'Картинка супертопа в посте',
            'is_home_supertop' => 'Супертоп главной',
            'image_home_supertop' => 'Картинка супертопа главной',
            'is_image_in_post' => 'Большая картинка поста',
            'image_in_post' => 'Большая картинка в посте',
            'summary' => Yii::t('app', 'Summary'),
            'text' => Yii::t('app', 'Text'),
            'background_color' => Yii::t('app', 'Background Color'),
            'background_image' => Yii::t('app', 'Background Image'),
            'hide_banners' => Yii::t('app', 'Hide Banners'),
            'hide_styles' => Yii::t('app', 'Hide Styles'),
            'hide_yandex_rss' => 'Убрать из Яндекс Новостей',
            'yandex_rss_genre' => 'Жанр сообщения в Яндекс Новостях',
            'hide_yandex_zen' => 'Убрать из Яндекс Дзен',
            'yandex_zen_adult' => 'Материал только для взрослых в Яндекс Дзен',
            'yandex_zen_categories' => 'Тематика в Яндекс Дзен',
            'views_count' => Yii::t('app', 'Views Count'),
            'related_posts' => Yii::t('app', 'Related Posts'),
            'status_id' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'yandex_zen_categories_array' => 'Тематика в Яндекс Дзен',
            'related_posts_ids' => 'Связанные посты',
            'del_background_image' => 'Удалить картинку',
            'rubric_search' => 'Рубрика',
            'access_by_link' => 'Доступ по ссылке',

        ];
    }

    /**
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search()
    {
        $criteria = new CDbCriteria();
        $criteria->with = ['gtuRubric'];

        $must_use_ids = false;
        $post_ids = [];

        if (!empty($this->rubric_search)) {
            $rubric_search = '%' . strtr($this->rubric_search, ['%' => '\%', '_' => '\_', '\\' => '\\\\']) . '%';
            $criteria2 = new CDbCriteria();
            $criteria2->select = 't.id';
            $criteria2->addCondition('t.title LIKE :rubric_search OR t.title_en LIKE :rubric_search');
            $criteria2->params = [':rubric_search' => $rubric_search];
            $criteria2->with = ['gtuPosts'];
            $criteria2->together = true;
            /** @var GtuRubric[] $rubrics */
            $rubrics = GtuRubric::model()->findAll($criteria2);
            $_post_ids = [];
            foreach ($rubrics as $rubric) {
                foreach ($rubric->gtuPosts as $one) {
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
        $criteria->compare('t.gtu_rubric_id', $this->gtu_rubric_id);
        $criteria->compare('t.type_id', $this->type_id);
        $criteria->compare('t.language', $this->language, true);
        $criteria->compare('t.url', $this->url, true);
        $criteria->compare('t.title', $this->title, true);
        $criteria->compare('t.date', $this->date, true);
        $criteria->compare('t.is_top', $this->is_top);
        $criteria->compare('t.is_big_top', $this->is_big_top);
        $criteria->compare('t.is_home_big_top', $this->is_home_big_top);
        $criteria->compare('t.is_supertop', $this->is_supertop);
        $criteria->compare('t.is_home_supertop', $this->is_home_supertop);
        $criteria->compare('t.is_image_in_post', $this->is_image_in_post);
        $criteria->compare('t.hide_banners', $this->hide_banners);
        $criteria->compare('t.hide_styles', $this->hide_styles);
        $criteria->compare('t.hide_yandex_rss', $this->hide_yandex_rss);
        $criteria->compare('t.yandex_rss_genre', $this->yandex_rss_genre, true);
        $criteria->compare('t.hide_yandex_zen', $this->hide_yandex_zen);
        $criteria->compare('t.yandex_zen_adult', $this->yandex_zen_adult);
        $criteria->compare('t.yandex_zen_categories', $this->yandex_zen_categories, true);
        $criteria->compare('t.views_count', $this->views_count);
        $criteria->compare('t.related_posts', $this->related_posts, true);
        $criteria->compare('t.status_id', $this->status_id);
        $criteria->compare('t.created_at', $this->created_at, true);
        $criteria->compare('t.updated_at', $this->updated_at, true);

        if ($must_use_ids) {
            $criteria->addInCondition('t.id', $post_ids);
        }

        return new CActiveDataProvider($this, [
            'criteria' => $criteria,
            'pagination' => [
                'pageSize' => self::PAGE_SIZE,
            ],
            'sort' => [
                'defaultOrder' => 't.date DESC',
            ],
        ]);
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return GtuPost the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
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
            // date
            $this->date = date('Y-m-d H:i:00', strtotime($this->date));
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

    /**
     * @return array
     */
    public static function getTypeOptions()
    {
        return [
            self::TYPE_POST => 'Обычный',
            //self::TYPE_GUIDE => 'Гайд',
        ];
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
        if (!empty($this->url)) {
            $l = $this->language;
            return Yii::app()->getBaseUrl(true) . '/gotoukraine/' . ($l && $l != 'uk' ? $l . '/' : '') . 'post/' . $this->url;
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
        if (!empty($bg_color) && !preg_match('/^([0-9a-f]{3}|[0-9a-f]{6})$/', $bg_color)) {
            $bg_color = '';
        }
        return $bg_color;
    }

    /**
     * @return bool
     */
    public function isEnabled()
    {
        return $this->status_id == self::STATUS_ENABLED && $this->date <= date('Y-m-d H:i:s');
    }

    /**
     * @param int $limit
     * @return Post[]
     */
    public function getRelatedPostsList($limit = 6)
    {
        $excludePostsIds = [$this->id];

        /** @var Post[] $relatedPosts */
        $relatedPosts = [];

        if (!empty($this->related_posts_ids)) {
            $criteria = new CDbCriteria();
            $criteria->with = ['gtuRubric'];
            $criteria->addNotInCondition('t.id', $excludePostsIds);
            $criteria->addInCondition('t.id', $this->related_posts_ids);
            $criteria->scopes = ['enabled', 'sorted'];
            $criteria->offset = 0;
            $criteria->limit = $limit;
            $relatedPosts = self::model()->findAll($criteria);
        }
        if (count($relatedPosts) == 0) {
            $rubric_id = $this->gtu_rubric_id;
            $criteria = new CDbCriteria();
            $criteria->select = '*, rand() as rand';
            $criteria->with = ['gtuRubric'];
            $criteria->addNotInCondition('t.id', $excludePostsIds);
            if ($rubric_id > 0) {
                $criteria->addCondition('gtu_rubric_id = ' . $rubric_id);
            }
            $criteria->scopes = ['enabled', 'currentLanguage'];
            $criteria->order = 'rand';
            $criteria->offset = 0;
            $criteria->limit = $limit;
            $relatedPosts = self::model()->findAll($criteria);
        }

        return $relatedPosts;
    }

    /**
     * @param string|null $lang
     * @return string
     */
    public static function getLastPostDate($lang = null)
    {
        if ($lang === null) {
            $lang = Yii::app()->language;
        }
        $criteria = new CDbCriteria();
        $criteria->scopes = ['enabled', 'sorted'];
        $criteria->select = 'date';
        $criteria->condition = 'language = :language';
        $criteria->params = [':language' => $lang];
        $criteria->limit = 1;
        $post = self::model()->find($criteria);
        return ($post !== null) ? $post->date : '';
    }

    /**
     * Еще посты
     * @param array $counters
     * @param int $rowsPerPage
     * @param bool $firstPage
     * @return array
     */
    public static function getPostsList($counters, $rowsPerPage, $firstPage = true, $fromHome = false)
    {
        $excluded = !empty($counters['excluded']) ? explode('-', $counters['excluded']) : [];

        $supertopPost = null;
        $homeBigTopPost = null;

        if ($fromHome) {
            // пост на весь экран на главной - указан "Супертоп на главной"
            $criteria = new CDbCriteria();
            //$criteria->compare('is_supertop', self::YES);
            $criteria->compare('is_home_supertop', self::YES);
            $criteria->scopes = ['enabled', 'sorted', 'currentLanguage'];
            $criteria->limit = 1;
            /** @var self $supertopPost */
            $supertopPost = self::model()->find($criteria);
            if ($supertopPost !== null) {
                $excluded[] = $supertopPost->id;
            }

            // первый топ на главной
            $criteria = new CDbCriteria();
            $criteria->compare('is_big_top', self::YES);
            $criteria->compare('is_home_big_top', self::YES);
            $criteria->scopes = ['enabled', 'sorted', 'currentLanguage'];
            $criteria->limit = 1;
            /** @var self $homeBigTopPost */
            $homeBigTopPost = self::model()->find($criteria);
            if ($homeBigTopPost !== null) {
                $excluded[] = $homeBigTopPost->id;
            }

            if (!$firstPage) {
                $supertopPost = null;
                $homeBigTopPost = null;
            }
        }

        /** @var self[] $postsPool */
        $postsPool = [];

        // local small top posts
        $criteria = new CDbCriteria();
        $criteria->with = ['gtuRubric'];
        if (count($excluded) > 0) {
            $criteria->addNotInCondition('t.id', $excluded);
        }
        $criteria->compare('t.is_top', self::YES);
        $criteria->scopes = ['enabled', 'sorted', 'currentLanguage'];
        $criteria->offset = $counters['top'];
        $criteria->limit = $rowsPerPage * 2 + 6; // 2 на запасную строку + 4 больших топа
        $otherSmallTopPostsPool = self::model()->findAll($criteria);

        foreach ($otherSmallTopPostsPool as $one) {
            $postsPool[$one->date . '_' . $one->created_at] = $one;
        }

        // other simple posts pool
        $criteria = new CDbCriteria();
        $criteria->with = ['gtuRubric'];
        if (count($excluded) > 0) {
            $criteria->addNotInCondition('t.id', $excluded);
        }
        $criteria->compare('t.is_top', self::NO);
        $criteria->scopes = ['enabled', 'sorted', 'currentLanguage'];
        $criteria->offset = $counters['other'];
        $criteria->limit = $rowsPerPage * 4 + 8; // 4 на запасную строку + 4 больших топа
        $otherPostsPool = self::model()->findAll($criteria);

        foreach ($otherPostsPool as $one) {
            $postsPool[$one->date . '_' . $one->created_at] = $one;
        }

        krsort($postsPool, SORT_STRING);

        // find first home top
        if (!$firstPage && $fromHome) {
            foreach ($postsPool as $k => $one) {
                if ($one->is_big_top == self::YES) {
                    $homeBigTopPost = $one;
                    if ($one->is_top == self::YES) {
                        $counters['top'] += 1;
                    } else {
                        $counters['other'] += 1;
                    }
                    $excluded[] = $one->id;
                    unset($postsPool[$k]);
                    break;
                }
            }
        }

        $otherBigTopPosts = [];

        // find other home tops
        $topCount = 0;
        if ($fromHome) {
            foreach ($postsPool as $k => $one) {
                if ($topCount >= 3) {
                    break;
                }
                if ($one->is_big_top == self::YES) {
                    $otherBigTopPosts[] = $one;
                    if ($one->is_top == self::YES) {
                        $counters['top'] += 1;
                    } else {
                        $counters['other'] += 1;
                    }
                    $excluded[] = $one->id;
                    unset($postsPool[$k]);
                    $topCount++;
                }
            }
        }

        // banners
        $banner = null;
        $wide_banners = [];
        if ($firstPage && $fromHome) {
            $_banner = GtuBanner::getByPlace(GtuBanner::PLACE_GTU_HOME_SMALL_POST);
            if ($_banner !== null && !empty($_banner->url) && !empty($_banner->image)) {
                $banner = $_banner;
            }
            $_wide_banners = GtuBanner::getAllByPlace(GtuBanner::PLACE_GTU_HOME_FULL_WIDTH);
            foreach ($_wide_banners as $_wide_banner) {
                $wide_banners[$_wide_banner->grid_position][] = $_wide_banner;
            }
        }

        // current number of row we are adding posts to
        $currentRow = 0;

        $showMore = false;
        $resultPostsList = [];

        while (count($postsPool) > 0) {
            // add big top
            if ($currentRow > 0 && $currentRow % 3 == 0 && !empty($otherBigTopPosts)) {
                $big_post = reset($otherBigTopPosts);
                $big_post->display_as_big = true;
                $k = key($otherBigTopPosts);
                $resultPostsList[] = $big_post;
                unset($otherBigTopPosts[$k]);
            }
            $colCount = 0;
            // 1st small or medium
            foreach ($postsPool as $k => $post) {
                if ($post->is_top == self::YES) {
                    $resultPostsList[] = $post;
                    $colCount += 2;
                    $counters['top'] += 1;
                    unset($postsPool[$k]);
                } else {
                    $resultPostsList[] = $post;
                    $colCount += 1;
                    $counters['other'] += 1;
                    unset($postsPool[$k]);
                }
                break;
            }
            // 2nd small if 1st small
            if ($colCount == 1) {
                foreach ($postsPool as $k => $post) {
                    if ($post->is_top == self::NO) {
                        $resultPostsList[] = $post;
                        $counters['other'] += 1;
                        unset($postsPool[$k]);
                        break;
                    }
                }
                $colCount += 1;
            }
            // 3rd small or medium
            foreach ($postsPool as $k => $post) {
                if ($post->is_top == self::YES) {
                    if ($currentRow == 0 && $banner !== null) {
                        continue;
                    }
                    $resultPostsList[] = $post;
                    $colCount += 2;
                    $counters['top'] += 1;
                    unset($postsPool[$k]);
                } else {
                    $resultPostsList[] = $post;
                    $colCount += 1;
                    $counters['other'] += 1;
                    unset($postsPool[$k]);
                }
                break;
            }
            // 4th small if 3rd small
            if ($currentRow == 0 && $banner !== null) {
                $resultPostsList[] = $banner;
                $colCount += 1;
            }
            if ($colCount == 3) {
                foreach ($postsPool as $k => $post) {
                    if ($post->is_top == self::NO) {
                        $resultPostsList[] = $post;
                        $counters['other'] += 1;
                        unset($postsPool[$k]);
                        break;
                    }
                }
            }

            if (isset($wide_banners[$currentRow])) {
                $total_banners = count($wide_banners[$currentRow]);
                $banner_offset = mt_rand(0, $total_banners - 1);
                $resultPostsList[] = $wide_banners[$currentRow][$banner_offset];
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
        foreach ($otherBigTopPosts as $one) {
            if ($one->is_top == self::YES) {
                $counters['top'] -= 1;
            } else {
                $counters['other'] -= 1;
            }
        }

        $excluded = array_unique($excluded);

        $counters['excluded'] = implode('-', $excluded);

        return [
            'supertop_post' => $supertopPost,
            'home_top_post' => $homeBigTopPost,
            'posts' => $resultPostsList,
            'show_more' => $showMore,
            'counters' => $counters,
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
            $models = self::model()->sorted()->findAll();
            foreach ($models as $one) {
                self::$_items[$one->id] = $one->title . ' (' . strtoupper($one->language) . ')';
            }
        }
        return self::$_items;
    }

    private static $_urls = [];

    /**
     * @param int $id
     * @return bool|string
     */
    public static function getUrlById($id)
    {
        if (!array_key_exists($id, self::$_urls)) {
            $model = self::model()->findByPk($id);
            if ($model !== null) {
                self::$_urls[$id] = $model->getUrl();
            } else {
                self::$_urls[$id] = false;
            }
        }
        return self::$_urls[$id];
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
}
