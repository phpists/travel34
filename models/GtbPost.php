<?php

/**
 * This is the model class for table "{{gtb_post}}".
 *
 * The followings are the available columns in table '{{gtb_post}}':
 * @property integer $id
 * @property integer $author_id
 * @property integer $gtb_rubric_id
 * @property integer $type_id
 * @property string $url
 * @property string $title
 * @property string $date
 * @property string $summary
 * @property string $text
 * @property string $page_title
 * @property string $page_keywords
 * @property string $page_description
 * @property string $page_og_image
 * @property integer $is_top
 * @property integer $is_big_top
 * @property integer $is_home_big_top
 * @property integer $is_supertop
 * @property integer $is_home_supertop
 * @property integer $is_image_in_post
 * @property string $image
 * @property string $image_top
 * @property string $image_big_top
 * @property string $image_supertop
 * @property string $image_home_supertop
 * @property string $image_in_post
 * @property string $related_posts
 * @property integer $status_id
 * @property string $language
 * @property integer $hide_banners
 * @property integer $hide_comments
 * @property integer $hide_styles
 * @property string $created_at
 * @property string $updated_at
 * @property integer $comments_count
 * @property integer $views_count
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
 * The followings are the available model relations:
 * @property GtbComment[] $gtbComments
 * @property GtbRubric $gtbRubric
 * @property Author $author
 *
 * @method GtbPost enabled()
 * @method GtbPost statusEnabled()
 * @method GtbPost sorted()
 * @method GtbPost sitemapRu()
 * @method GtbPost sitemapEn()
 * @method GtbPost currentLanguage()
 * @method GtbPost yandexRss()
 * @method GtbPost yandexZen()
 */
class GtbPost extends TravelActiveRecord
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
        return '{{gtb_post}}';
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
            ['title, date', 'required'],
            ['author_id, gtb_rubric_id, type_id, is_top, is_big_top, is_home_big_top, is_supertop, is_home_supertop, is_image_in_post, status_id, hide_banners, hide_comments, hide_styles, comments_count, views_count, is_new, hide_yandex_rss, hide_yandex_zen, yandex_zen_adult', 'numerical', 'integerOnly' => true],
            ['url, title, page_title, page_keywords, page_og_image, image, image_top, image_big_top, image_supertop, image_home_supertop, image_in_post, related_posts, background_image', 'length', 'max' => 255],
            ['yandex_rss_genre', 'length', 'max' => 10],
            ['background_color, language', 'length', 'max' => 6],
            ['date, summary, text, page_description, created_at, updated_at, yandex_zen_categories', 'safe'],
            ['status_id', 'in', 'range' => self::getAllowedStatusRange()],
            ['type_id', 'in', 'range' => self::getAllowedTypeRange()],
            ['url', 'match', 'pattern' => '/^[a-z0-9-]+$/', 'message' => 'Только "a-z", "0-9" и "-".'],
            ['related_posts_ids, yandex_zen_categories_array, access_by_link', 'safe'],
            // The following rule is used by search().
            ['id, author_id, gtb_rubric_id, type_id, url, title, date, summary, text, page_title, page_keywords, page_description, is_top, is_big_top, is_home_big_top, is_supertop, is_home_supertop, is_image_in_post, related_posts, status_id, language, hide_banners, hide_comments, hide_styles, created_at, updated_at, comments_count, views_count, rubric_search, background_color, is_new', 'safe', 'on' => 'search'],
        ];
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return [
            'gtbComments' => [self::HAS_MANY, 'GtbComment', 'gtb_post_id'],
            'gtbRubric' => [self::BELONGS_TO, 'GtbRubric', 'gtb_rubric_id'],
            'author' => [self::BELONGS_TO, 'Author', 'author_id'],
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
            'author_id' => 'Автор',
            'gtb_rubric_id' => 'Рубрика',
            'type_id' => 'Тип поста',
            'url' => 'URL',
            'title' => 'Заголовок',
            'date' => 'Дата',
            'summary' => 'Текст тизера',
            'text' => 'Текст поста',
            'page_title' => 'Тайтл',
            'page_keywords' => 'Ключевые слова страницы',
            'page_description' => 'Описание страницы',
            'page_og_image' => 'OG-картинка',
            'is_top' => 'Средний топ',
            'is_big_top' => 'Топ-растяжка',
            'is_home_big_top' => 'Топ-растяжка вверху',
            'is_supertop' => 'Супертоп в посте',
            'is_home_supertop' => 'Супертоп главной',
            'is_image_in_post' => 'Большая картинка поста',
            'image' => 'Тизер-картинка', // 400x400
            'image_top' => 'Картинка среднего топа',
            'image_big_top' => 'Картинка топ-растяжки',
            'image_supertop' => 'Картинка супертопа в посте',
            'image_home_supertop' => 'Картинка супертопа главной',
            'image_in_post' => 'Большая картинка в посте',
            'related_posts' => 'Связанные посты',
            'status_id' => 'Статус',
            'language' => 'Лента / язык',
            'hide_banners' => 'Скрыть баннеры',
            'hide_comments' => 'Скрыть комментарии',
            'hide_styles' => 'Скрыть стили',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'comments_count' => 'Комментарии',
            'views_count' => 'Просмотры',
            'rubric_search' => 'Рубрика',
            'related_posts_ids' => 'Связанные посты',
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
        $criteria->with = ['gtbRubric'];

        $must_use_ids = false;
        $post_ids = [];

        if (!empty($this->rubric_search)) {
            $rubric_search = '%' . strtr($this->rubric_search, ['%' => '\%', '_' => '\_', '\\' => '\\\\']) . '%';
            $criteria2 = new CDbCriteria();
            $criteria2->select = 't.id';
            $criteria2->addCondition('t.title LIKE :rubric_search OR t.title_en LIKE :rubric_search');
            $criteria2->params = [':rubric_search' => $rubric_search];
            $criteria2->with = ['gtbPosts'];
            $criteria2->together = true;
            /** @var GtbRubric[] $rubrics */
            $rubrics = GtbRubric::model()->findAll($criteria2);
            $_post_ids = [];
            foreach ($rubrics as $rubric) {
                foreach ($rubric->gtbPosts as $one) {
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
        $criteria->compare('t.type_id', $this->type_id);
        $criteria->compare('t.url', $this->url, true);
        $criteria->compare('t.title', $this->title, true);
        $criteria->compare('t.date', $this->date, true);
        $criteria->compare('t.is_top', $this->is_top);
        $criteria->compare('t.is_big_top', $this->is_big_top);
        $criteria->compare('t.is_home_big_top', $this->is_home_big_top);
        $criteria->compare('t.is_supertop', $this->is_supertop);
        $criteria->compare('t.is_home_supertop', $this->is_home_supertop);
        $criteria->compare('t.is_image_in_post', $this->is_image_in_post);
        $criteria->compare('t.status_id', $this->status_id);
        $criteria->compare('t.language', $this->language, true);
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
            'pagination' => [
                'pageSize' => self::PAGE_SIZE,
            ],
            'sort' => [
                'defaultOrder' => 't.id DESC',
            ],
        ]);
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return GtbPost the static model class
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
            return Yii::app()->getBaseUrl(true) . '/gotobelarus/' . ($this->language != 'ru' ? $this->language . '/' : '') . 'post/' . $this->url;
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
     * Adds a comment to this taxi
     * @param GtbComment $comment
     * @return bool
     */
    public function addComment($comment)
    {
        $comment->gtb_post_id = $this->id;
        if (!Yii::app()->user->isGuest && Yii::app()->user->getOAuthProfile()) {
            $comment->create_user_id = Yii::app()->user->id;
        }
        return $comment->save();
    }

    /**
     * @return GtbComment[]
     */
    public function getCommentsTreeList()
    {
        $criteria = new CDbCriteria();
        $criteria->compare('gtb_post_id', $this->id);
        $criteria->order = 'created_at DESC';
        /** @var GtbComment[] $comments */
        $comments = GtbComment::model()->findAll($criteria);
        return $this->_buildTree($comments);
    }

    /**
     * @param GtbComment[] $elements
     * @param int $parentId
     * @param int $level
     * @return GtbComment[]
     */
    private function _buildTree($elements, $parentId = 0, $level = 0)
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
            $criteria = new CDbCriteria();
            $criteria->with = ['gtbRubric'];
            $criteria->addNotInCondition($postTAlias . '.id', $excludePostsIds);
            $criteria->addInCondition($postTAlias . '.id', $this->related_posts_ids);
            $criteria->offset = 0;
            $criteria->limit = $limit;
            $relatedPosts = self::model()->enabled()->findAll($criteria);
        }
        if (count($relatedPosts) == 0) {
            $rubric_id = (int)$this->gtb_rubric_id;
            $criteria = new CDbCriteria();
            $criteria->select = '*, rand() as rand';
            $criteria->with = ['gtbRubric'];
            $criteria->addNotInCondition($postTAlias . '.id', $excludePostsIds);
            if ($rubric_id > 0) {
                $criteria->addCondition('gtb_rubric_id = ' . $rubric_id);
            }
            $criteria->order = 'rand'; //$postTAlias . '. date DESC, ' . $postTAlias . '. created_at DESC';
            $criteria->offset = 0;
            $criteria->limit = $limit;
            $relatedPosts = self::model()->currentLanguage()->enabled()->findAll($criteria);
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
        $criteria->select = 'date';
        $criteria->order = 'date DESC, created_at DESC';
        $criteria->condition = 'language = :language';
        $criteria->params = [':language' => $lang];
        $criteria->limit = 1;
        $post = self::model()->enabled()->find($criteria);
        return ($post !== null) ? $post->date : '';
    }

    /**
     * Еще посты под постом "Сейчас на главной"
     * @param array $counters
     * @param int $rowsPerPage
     * @param int|null $postId
     * @return array
     */
    public static function getAdditionalPostsList($counters, $rowsPerPage, $postId = null)
    {
        // using 'other' (int) and 'top' (int) in $counters

        $excluded = $postId ? [$postId] : [];

        $postTAlias = self::model()->getTableAlias();

        // other simple posts pool
        $criteria = new CDbCriteria();
        $criteria->with = ['gtbRubric'];
        if (count($excluded) > 0) {
            $criteria->addNotInCondition($postTAlias . '.id', $excluded);
        }
        $criteria->order = $postTAlias . '. date DESC, ' . $postTAlias . '. created_at DESC';
        $criteria->offset = $counters['other'];
        $criteria->limit = $rowsPerPage * 3 + 1;
        $postsPool = self::model()->currentLanguage()->enabled()->findAll($criteria);

        $showMore = count($postsPool) > $rowsPerPage * 3;
        $resultPostsList = array_slice($postsPool, 0, $rowsPerPage * 3);
        $counters['other'] += count($resultPostsList);

        return [
            'posts' => $resultPostsList,
            'show_more' => $showMore,
            'counters' => $counters,
            'post_id' => $postId,
        ];
    }

    /**
     * Еще посты
     * @param array $counters
     * @param int $rowsPerPage
     * @param bool $firstPage
     * @return array
     */
    public static function getHomePostsList($counters, $rowsPerPage, $firstPage = true)
    {
        $excluded = !empty($counters['excluded']) ? explode('-', $counters['excluded']) : [];

        $postTAlias = self::model()->getTableAlias();

        // пост на весь экран на главной - указан "Супертоп на главной"
        $criteria = new CDbCriteria();
        //$criteria->compare('is_supertop', self::YES);
        $criteria->compare('is_home_supertop', self::YES);
        $criteria->order = 'date DESC';
        $criteria->limit = 1;
        /** @var self $supertopPost */
        $supertopPost = self::model()->currentLanguage()->enabled()->find($criteria);
        if ($supertopPost !== null) {
            $excluded[] = $supertopPost->id;
        }

        // первый топ на главной
        $criteria = new CDbCriteria();
        $criteria->compare('is_big_top', self::YES);
        $criteria->compare('is_home_big_top', self::YES);
        $criteria->order = 'date DESC';
        $criteria->limit = 1;
        /** @var self $homeBigTopPost */
        $homeBigTopPost = self::model()->currentLanguage()->enabled()->find($criteria);
        if ($homeBigTopPost !== null) {
            $excluded[] = $homeBigTopPost->id;
        }

        if (!$firstPage) {
            $supertopPost = null;
            $homeBigTopPost = null;
        }

        /** @var self[] $postsPool */
        $postsPool = [];

        // local small top posts
        $criteria = new CDbCriteria();
        $criteria->with = ['gtbRubric'];
        if (count($excluded) > 0) {
            $criteria->addNotInCondition($postTAlias . '.id', $excluded);
        }
        $criteria->addCondition('is_top = ' . self::YES);
        $criteria->order = $postTAlias . '. date DESC, ' . $postTAlias . '. created_at DESC';
        $criteria->offset = $counters['top'];
        $criteria->limit = $rowsPerPage * 2 + 6; // 2 на запасную строку + 4 больших топа
        $otherSmallTopPostsPool = self::model()->currentLanguage()->enabled()->findAll($criteria);

        foreach ($otherSmallTopPostsPool as $one) {
            $postsPool[$one->date . '_' . $one->created_at] = $one;
        }

        // other simple posts pool
        $criteria = new CDbCriteria();
        $criteria->with = ['gtbRubric'];
        if (count($excluded) > 0) {
            $criteria->addNotInCondition($postTAlias . '.id', $excluded);
        }
        $criteria->addCondition('is_top = ' . self::NO);
        $criteria->order = $postTAlias . '. date DESC, ' . $postTAlias . '. created_at DESC';
        $criteria->offset = $counters['other'];
        $criteria->limit = $rowsPerPage * 4 + 8; // 4 на запасную строку + 4 больших топа
        $otherPostsPool = self::model()->currentLanguage()->enabled()->findAll($criteria);

        foreach ($otherPostsPool as $one) {
            $postsPool[$one->date . '_' . $one->created_at] = $one;
        }

        krsort($postsPool, SORT_STRING);

        // find first home top
        if (!$firstPage) {
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

        // banners
        $banner = null;
        $wide_banners = [];
        if ($firstPage) {
            $_banner = GtbBanner::getByPlace(GtbBanner::PLACE_GTB_HOME_SMALL_POST);
            if ($_banner !== null && !empty($_banner->url) && !empty($_banner->image)) {
                $banner = $_banner;
            }
            $_wide_banners = GtbBanner::getAllByPlace(GtbBanner::PLACE_GTB_HOME_FULL_WIDTH);
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
            $models = self::model()->findAll(['order' => 'date DESC, created_at DESC']);
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
