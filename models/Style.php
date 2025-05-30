<?php

/**
 * This is the model class for table "{{style}}".
 *
 * The followings are the available columns in table '{{style}}':
 * @property int $id
 * @property string $title
 * @property int $background_type
 * @property string $background_color
 * @property string $background_image
 * @property string $background_image_mobile
 * @property int $background_width_mobile
 * @property int $background_height
 * @property string $background_repeat_image
 * @property int $page_padding
 * @property int $page_padding_mobile
 * @property string $url
 * @property int $views_count
 * @property int $status_id
 * @property string $created_at
 * @property string $updated_at
 * @property string $geo_target
 *
 * The followings are the available model relations:
 * @property StyleAssign[] $styleAssigns
 *
 * @method Style enabled()
 */
class Style extends TravelActiveRecord
{
    const BG_TYPE_ONLY_COLOR = 0;
    const BG_TYPE_REPEAT_ALL = 1;
    const BG_TYPE_CENTER_NO_REPEAT = 2;
    const BG_TYPE_CENTER_REPEAT_OTHER = 3;

    // при добавлении ключа, которому нужен item_id, обновить getPageKeysWithItemsRange(), getItemTitleById(), getAssignedItems(), getAllItems()
    // + добавить вывод ссылки в "style/_links.php"
    // + добавить шаблон "partials/_styles" в форму нового типа

    const PAGE_KEY_MAIN = 'main';
    const PAGE_KEY_GUIDES = 'guides';
    const PAGE_KEY_SPECIALS = 'specials';
    const PAGE_KEY_PAGE = 'page'; // + item
    const PAGE_KEY_POST = 'post'; // + item
    const PAGE_KEY_RUBRIC = 'rubric'; // + item
    const PAGE_KEY_SPECIAL = 'special'; // + item
    const PAGE_KEY_ALL = 'all';

    const PAGE_KEY_GTB_MAIN = 'gtbmain';
    const PAGE_KEY_GTB_MAIN_EN = 'gtbmainen';
    const PAGE_KEY_GTB_TODO = 'gtbtodo';
    const PAGE_KEY_GTB_TODO_EN = 'gtbtodoen';
    const PAGE_KEY_GTB_RUBRIC = 'gtbrubric'; // + item
    const PAGE_KEY_GTB_RUBRIC_EN = 'gtbrubricen'; // + item
    const PAGE_KEY_GTB_POST = 'gtbpost'; // + item
    const PAGE_KEY_GTB_ALL = 'gtball';
    const PAGE_KEY_GTB_ALL_EN = 'gtballen';

    const PAGE_KEY_GTU_MAIN = 'gtumain';
    const PAGE_KEY_GTU_MAIN_RU = 'gtumainru';
    const PAGE_KEY_GTU_MAIN_EN = 'gtumainen';
    const PAGE_KEY_GTU_TODO = 'gtutodo';
    const PAGE_KEY_GTU_TODO_RU = 'gtutodoru';
    const PAGE_KEY_GTU_TODO_EN = 'gtutodoen';
    const PAGE_KEY_GTU_RUBRIC = 'gturubric'; // + item
    const PAGE_KEY_GTU_RUBRIC_RU = 'gturubricru'; // + item
    const PAGE_KEY_GTU_RUBRIC_EN = 'gturubricen'; // + item
    const PAGE_KEY_GTU_POST = 'gtupost'; // + item
    const PAGE_KEY_GTU_ALL = 'gtuall';
    const PAGE_KEY_GTU_ALL_RU = 'gtuallru';
    const PAGE_KEY_GTU_ALL_EN = 'gtuallen';
    const PAGE_KEY_GTU_MAP = 'gtumap';
    const PAGE_KEY_GTB_MAP = 'gtbmap';

    const IMAGES_PATH = 'media/style';

    public $geo_target_codes = [];

    public $page_keys;
    public $item_ids;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{style}}';
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['uploadBgImage'] = [
            'class' => 'application.behaviors.UploadFileBehavior',
            'attrName' => 'background_image',
            'savePath' => self::IMAGES_PATH,
        ];
        $behaviors['uploadBgImageMobile'] = [
            'class' => 'application.behaviors.UploadFileBehavior',
            'attrName' => 'background_image_mobile',
            'savePath' => self::IMAGES_PATH,
        ];
        $behaviors['uploadBgImageRepeat'] = [
            'class' => 'application.behaviors.UploadFileBehavior',
            'attrName' => 'background_repeat_image',
            'savePath' => self::IMAGES_PATH,
        ];
        return $behaviors;
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return [
            ['title', 'required'],
            ['background_type, background_width_mobile, background_height, page_padding, page_padding_mobile, views_count, status_id', 'numerical', 'integerOnly' => true],
            ['title, background_image, background_image_mobile, background_repeat_image, url, geo_target', 'length', 'max' => 255],
            ['background_color', 'length', 'max' => 6],
            ['created_at, updated_at', 'date', 'format' => 'yyyy-MM-dd hh:mm:ss'],
            ['created_at, updated_at', 'default', 'setOnEmpty' => true, 'value' => null],
            ['status_id', 'in', 'range' => self::getAllowedStatusRange()],
            ['background_type', 'in', 'range' => self::getAllowedBgTypeRange()],
            ['page_keys, item_ids', 'safe'],
            // The following rule is used by search().
            ['id, title, background_type, background_color, background_width_mobile, background_height, page_padding, page_padding_mobile, url, views_count, status_id, created_at, updated_at, geo_target', 'safe', 'on' => 'search'],
            ['geo_target_codes', 'safe'],
        ];
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return [
            'styleAssigns' => [self::HAS_MANY, 'StyleAssign', 'style_id'],
        ];
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Заголовок',
            'background_type' => 'Тип фона',
            'background_color' => 'Фоновый цвет',
            'background_image' => 'Фоновая картинка',
            'background_image_mobile' => 'Фоновая картинка (mobile)',
            'background_width_mobile' => 'Ширина фона (mobile)',
            'background_height' => 'Высота фона',
            'background_repeat_image' => 'Фоновая картинка для повтора',
            'page_padding' => 'Отступ страницы',
            'page_padding_mobile' => 'Отступ страницы (mobile)',
            'url' => 'URL',
            'views_count' => 'Просмотры',
            'status_id' => 'Статус',
            'created_at' => 'Создано',
            'updated_at' => 'Обновлено',
            'page_keys' => 'Страница',
            'item_ids' => 'Элемент',
            'geo_target' => 'Гео-цели',
            'geo_target_codes' => 'Гео-цели',
        ];
    }

    /**
     * @return CActiveDataProvider
     */
    public function search()
    {
        $criteria = new CDbCriteria();

        $criteria->compare('id', $this->id);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('background_type', $this->background_type);
        $criteria->compare('background_color', $this->background_color, true);
        $criteria->compare('background_image', $this->background_image, true);
        $criteria->compare('background_width_mobile', $this->background_width_mobile);
        $criteria->compare('background_height', $this->background_height);
        $criteria->compare('background_repeat_image', $this->background_repeat_image, true);
        $criteria->compare('page_padding', $this->page_padding);
        $criteria->compare('page_padding_mobile', $this->page_padding_mobile);
        $criteria->compare('url', $this->url, true);
        $criteria->compare('status_id', $this->status_id);
        $criteria->compare('created_at', $this->created_at, true);
        $criteria->compare('updated_at', $this->updated_at, true);
        $criteria->compare('geo_target', $this->geo_target, true);

        return new CActiveDataProvider($this, [
            'criteria' => $criteria,
            'pagination' => [
                'pageSize' => self::PAGE_SIZE,
            ],
            'sort' => [
                'defaultOrder' => 'id DESC',
            ],
        ]);
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Style the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * {@inheritDoc}
     */
    protected function afterFind()
    {
        $this->geo_target_codes = preg_split('/\s*,\s*/', trim($this->geo_target), -1, PREG_SPLIT_NO_EMPTY);
        parent::afterFind();
    }

    /**
     * @inheritdoc
     */
    protected function beforeSave()
    {
        if (parent::beforeSave()) {
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
            return true;
        } else {
            return false;
        }
    }

    /**
     * {@inheritDoc}
     */
    protected function afterSave()
    {
        parent::afterSave();
        if (!is_array($this->page_keys) && $this->page_keys != '0') {
            return;
        }
        if (!is_array($this->item_ids) && $this->item_ids != '0') {
            return;
        }
        if (!is_array($this->page_keys)) {
            $this->page_keys = [];
        }
        if (!is_array($this->item_ids)) {
            $this->item_ids = [];
        }
        // удалить ранее созданные привязки
        StyleAssign::model()->deleteAllByAttributes(['style_id' => $this->id]);
        // добавить заново
        foreach ($this->page_keys as $k => $page_key) {
            if (!in_array($page_key, self::getPageKeysAllRange())) {
                continue;
            }
            $item_id = isset($this->item_ids[$k]) ? (int)$this->item_ids[$k] : 0;
            if (in_array($page_key, self::getPageKeysWithItemsRange()) && !$item_id) {
                continue;
            }
            $model = new StyleAssign();
            $model->style_id = $this->id;
            $model->page_key = $page_key;
            $model->item_id = $item_id;
            $model->save();
        }
    }

    /**
     * @return array
     */
    public static function getPageKeysAll()
    {
        return [
            self::PAGE_KEY_ALL => 'Все страницы',
            self::PAGE_KEY_MAIN => 'Главная страница',
            self::PAGE_KEY_GUIDES => 'Гайды',
            self::PAGE_KEY_SPECIALS => 'Спецпроекты',
            self::PAGE_KEY_PAGE => 'Статическая страница',
            self::PAGE_KEY_SPECIAL => 'Страница спецпроекта',
            self::PAGE_KEY_RUBRIC => 'Страница рубрики',
            self::PAGE_KEY_POST => 'Страница поста',
            self::PAGE_KEY_GTB_ALL => 'Все страницы GTB',
            self::PAGE_KEY_GTB_ALL_EN => 'Все страницы GTB (EN)',
            self::PAGE_KEY_GTB_MAIN => 'Главная страница GTB',
            self::PAGE_KEY_GTB_MAIN_EN => 'Главная страница GTB (EN)',
            self::PAGE_KEY_GTB_TODO => 'Страница TO DO GTB',
            self::PAGE_KEY_GTB_TODO_EN => 'Страница TO DO GTB (EN)',
            self::PAGE_KEY_GTB_RUBRIC => 'Страница рубрики GTB',
            self::PAGE_KEY_GTB_RUBRIC_EN => 'Страница рубрики GTB (EN)',
            self::PAGE_KEY_GTB_POST => 'Страница поста GTB',
            self::PAGE_KEY_GTU_ALL => 'Все страницы GTU',
            self::PAGE_KEY_GTU_ALL_RU => 'Все страницы GTU (RU)',
            self::PAGE_KEY_GTU_ALL_EN => 'Все страницы GTU (EN)',
            self::PAGE_KEY_GTU_MAIN => 'Главная страница GTU',
            self::PAGE_KEY_GTU_MAIN_RU => 'Главная страница GTU (RU)',
            self::PAGE_KEY_GTU_MAIN_EN => 'Главная страница GTU (EN)',
            self::PAGE_KEY_GTU_TODO => 'Страница TO DO GTU',
            self::PAGE_KEY_GTU_TODO_RU => 'Страница TO DO GTU (RU)',
            self::PAGE_KEY_GTU_TODO_EN => 'Страница TO DO GTU (EN)',
            self::PAGE_KEY_GTU_RUBRIC => 'Страница рубрики GTU',
            self::PAGE_KEY_GTU_RUBRIC_RU => 'Страница рубрики GTU (RU)',
            self::PAGE_KEY_GTU_RUBRIC_EN => 'Страница рубрики GTU (EN)',
            self::PAGE_KEY_GTU_POST => 'Страница поста GTU',
            self::PAGE_KEY_GTU_MAP => 'Страница Карты GTU',
            self::PAGE_KEY_GTB_MAP => 'Страница Карты GTB',
        ];
    }

    /**
     * @return array
     */
    public static function getGtbKeys()
    {
        return [
            self::PAGE_KEY_GTB_MAIN,
            self::PAGE_KEY_GTB_MAIN_EN,
            self::PAGE_KEY_GTB_ALL,
            self::PAGE_KEY_GTB_ALL_EN,
            self::PAGE_KEY_GTB_TODO,
            self::PAGE_KEY_GTB_TODO_EN,
            self::PAGE_KEY_GTB_RUBRIC,
            self::PAGE_KEY_GTB_RUBRIC_EN,
            self::PAGE_KEY_GTB_POST,
        ];
    }

    /**
     * @return array
     */
    public static function getGtbEnKeys()
    {
        return [
            self::PAGE_KEY_GTB_ALL_EN,
            self::PAGE_KEY_GTB_MAIN_EN,
            self::PAGE_KEY_GTB_TODO_EN,
            self::PAGE_KEY_GTB_RUBRIC_EN,
        ];
    }

    /**
     * @return array
     */
    public static function getGtuKeys()
    {
        return [
            self::PAGE_KEY_GTU_MAIN,
            self::PAGE_KEY_GTU_MAIN_RU,
            self::PAGE_KEY_GTU_MAIN_EN,
            self::PAGE_KEY_GTU_ALL,
            self::PAGE_KEY_GTU_ALL_RU,
            self::PAGE_KEY_GTU_ALL_EN,
            self::PAGE_KEY_GTU_TODO,
            self::PAGE_KEY_GTU_TODO_RU,
            self::PAGE_KEY_GTU_TODO_EN,
            self::PAGE_KEY_GTU_RUBRIC,
            self::PAGE_KEY_GTU_RUBRIC_RU,
            self::PAGE_KEY_GTU_RUBRIC_EN,
            self::PAGE_KEY_GTU_POST,
        ];
    }

    /**
     * @return array
     */
    public static function getGtuRuKeys()
    {
        return [
            self::PAGE_KEY_GTU_ALL_RU,
            self::PAGE_KEY_GTU_MAIN_RU,
            self::PAGE_KEY_GTU_TODO_RU,
            self::PAGE_KEY_GTU_RUBRIC_RU,
        ];
    }

    /**
     * @return array
     */
    public static function getGtuEnKeys()
    {
        return [
            self::PAGE_KEY_GTU_ALL_EN,
            self::PAGE_KEY_GTU_MAIN_EN,
            self::PAGE_KEY_GTU_TODO_EN,
            self::PAGE_KEY_GTU_RUBRIC_EN,
        ];
    }

    /**
     * @return array
     */
    public static function getBgTypeOptions()
    {
        return [
            self::BG_TYPE_ONLY_COLOR => 'Только фоновый цвет',
            self::BG_TYPE_REPEAT_ALL => 'Повтор по всем направлениям от центра сверху',
            self::BG_TYPE_CENTER_NO_REPEAT => 'По центру сверху, без повтора',
            self::BG_TYPE_CENTER_REPEAT_OTHER => 'По центру сверху, повтор другого фона на десктопе',
        ];
    }

    /**
     * @return array
     */
    public static function getPageKeysAllRange()
    {
        return array_keys(self::getPageKeysAll());
    }

    /**
     * Список page_key, которым нужен item_id
     * @return array
     */
    public static function getPageKeysWithItemsRange()
    {
        return [
            self::PAGE_KEY_PAGE,
            self::PAGE_KEY_POST,
            self::PAGE_KEY_RUBRIC,
            self::PAGE_KEY_SPECIAL,
            self::PAGE_KEY_GTB_RUBRIC,
            self::PAGE_KEY_GTB_RUBRIC_EN,
            self::PAGE_KEY_GTB_POST,
            self::PAGE_KEY_GTU_RUBRIC,
            self::PAGE_KEY_GTU_RUBRIC_RU,
            self::PAGE_KEY_GTU_RUBRIC_EN,
            self::PAGE_KEY_GTU_POST,
        ];
    }

    /**
     * @return array
     */
    public static function getAllowedBgTypeRange()
    {
        return array_keys(self::getBgTypeOptions());
    }

    /**
     * @param string $page_key
     * @param int $id
     * @return string
     */
    public static function getItemTitleById($page_key, $id)
    {
        if ($page_key == self::PAGE_KEY_POST) {
            $model = Post::model()->findByPk($id);
            return $model !== null ? $model->title : '';
        }
        if ($page_key == self::PAGE_KEY_PAGE) {
            $model = Page::model()->findByPk($id);
            return $model !== null ? $model->title : '';
        }
        if ($page_key == self::PAGE_KEY_RUBRIC) {
            $model = Rubric::model()->findByPk($id);
            return $model !== null ? $model->title : '';
        }
        if ($page_key == self::PAGE_KEY_SPECIAL) {
            $model = SpecialProject::model()->findByPk($id);
            return $model !== null ? $model->title : '';
        }
        if ($page_key == self::PAGE_KEY_GTB_POST) {
            $model = GtbPost::model()->findByPk($id);
            return $model !== null ? $model->title : '';
        }
        if ($page_key == self::PAGE_KEY_GTB_RUBRIC || $page_key == self::PAGE_KEY_GTB_RUBRIC_EN) {
            $model = GtbRubric::model()->findByPk($id);
            return $model !== null ? $model->title : '';
        }
        if ($page_key == self::PAGE_KEY_GTU_POST) {
            $model = GtbPost::model()->findByPk($id);
            return $model !== null ? $model->title : '';
        }
        if ($page_key == self::PAGE_KEY_GTU_RUBRIC || $page_key == self::PAGE_KEY_GTU_RUBRIC_RU || $page_key == self::PAGE_KEY_GTU_RUBRIC_EN) {
            $model = GtbRubric::model()->findByPk($id);
            return $model !== null ? $model->title : '';
        }
        return '';
    }

    /**
     * @return array
     */
    public function getAllItems()
    {
        $all_items = [];

        // PAGE_KEY_PAGE
        $all_items[self::PAGE_KEY_PAGE] = Page::getItemsList();

        // PAGE_KEY_POST
        $all_post_items = Post::getItemsList('date DESC, id DESC');
        $items = array_slice($all_post_items, 0, 500, true);
        if (!$this->isNewRecord) {
            // добавить ранее добавленные, если не попали в список последних
            foreach ($this->styleAssigns as $assign) {
                if ($assign->page_key == self::PAGE_KEY_POST && !isset($items[$assign->item_id]) && isset($all_post_items[$assign->item_id])) {
                    $items[$assign->item_id] = $all_post_items[$assign->item_id];
                }
            }
        }
        $all_items[self::PAGE_KEY_POST] = $items;

        // PAGE_KEY_RUBRIC
        $all_items[self::PAGE_KEY_RUBRIC] = Rubric::getItemsList();

        // PAGE_KEY_SPECIAL
        $all_items[self::PAGE_KEY_SPECIAL] = SpecialProject::getItemsList();

        // PAGE_KEY_GTB_POST
        $all_post_items = GtbPost::getItemsList('date DESC, id DESC');
        $items = array_slice($all_post_items, 0, 500, true);
        if (!$this->isNewRecord) {
            // добавить ранее добавленные, если не попали в список последних
            foreach ($this->styleAssigns as $assign) {
                if ($assign->page_key == self::PAGE_KEY_GTB_POST && !isset($items[$assign->item_id]) && isset($all_post_items[$assign->item_id])) {
                    $items[$assign->item_id] = $all_post_items[$assign->item_id];
                }
            }
        }
        $all_items[self::PAGE_KEY_GTB_POST] = $items;

        // PAGE_KEY_GTB_RUBRIC
        $all_items[self::PAGE_KEY_GTB_RUBRIC] = GtbRubric::getItemsList('position, title');

        // PAGE_KEY_GTB_RUBRIC_EN
        $all_items[self::PAGE_KEY_GTB_RUBRIC_EN] = GtbRubric::getItemsList('position, title_en', 'id', 'title_en');

        // PAGE_KEY_GTU_POST
        $all_post_items = GtuPost::getItemsList('date DESC, id DESC');
        $items = array_slice($all_post_items, 0, 500, true);
        if (!$this->isNewRecord) {
            // добавить ранее добавленные, если не попали в список последних
            foreach ($this->styleAssigns as $assign) {
                if ($assign->page_key == self::PAGE_KEY_GTU_POST && !isset($items[$assign->item_id]) && isset($all_post_items[$assign->item_id])) {
                    $items[$assign->item_id] = $all_post_items[$assign->item_id];
                }
            }
        }
        $all_items[self::PAGE_KEY_GTU_POST] = $items;

        // PAGE_KEY_GTU_RUBRIC
        $all_items[self::PAGE_KEY_GTU_RUBRIC] = GtuRubric::getItemsList('position, title');

        // PAGE_KEY_GTU_RUBRIC_RU
        $all_items[self::PAGE_KEY_GTU_RUBRIC_RU] = GtuRubric::getItemsList('position, title_ru', 'id', 'title_ru');

        // PAGE_KEY_GTU_RUBRIC_EN
        $all_items[self::PAGE_KEY_GTU_RUBRIC_EN] = GtuRubric::getItemsList('position, title_en', 'id', 'title_en');

        return $all_items;
    }

    /**
     * @param string $page_key
     * @param int|null $item_id
     * @return static[]
     */
    public static function getAllStylesByPageKey($page_key, $item_id = null)
    {
        $criteria = new CDbCriteria();
        if (!empty($item_id)) {
            $criteria->with = [
                'styleAssigns' => [
                    'select' => false,
                    'joinType' => 'INNER JOIN',
                    'condition' => 'styleAssigns.page_key = :page_key AND styleAssigns.item_id = :item_id',
                    'params' => [':page_key' => $page_key, ':item_id' => $item_id],
                ],
            ];
        } else {
            $criteria->with = [
                'styleAssigns' => [
                    'select' => false,
                    'joinType' => 'INNER JOIN',
                    'condition' => 'styleAssigns.page_key = :page_key',
                    'params' => [':page_key' => $page_key],
                ],
            ];
        }
        $criteria->order = 't.updated_at DESC';

        return self::model()->findAll($criteria);
    }

    /**
     * @param string $page_key
     * @param int|null $item_id
     * @return array
     */
    public static function getStyleByPageKey($page_key = self::PAGE_KEY_MAIN, $item_id = null)
    {
        $is_gtb = in_array($page_key, self::getGtbKeys());
        $is_gtu = in_array($page_key, self::getGtuKeys());

        $criteria = new GeoDbCriteria();
        if (!empty($item_id)) {
            $criteria->with = [
                'styleAssigns' => [
                    'select' => false,
                    'joinType' => 'INNER JOIN',
                    'condition' => 'styleAssigns.page_key = :page_key AND styleAssigns.item_id = :item_id',
                    'params' => [':page_key' => $page_key, ':item_id' => $item_id],
                ],
            ];
        } else {
            $criteria->with = [
                'styleAssigns' => [
                    'select' => false,
                    'joinType' => 'INNER JOIN',
                    'condition' => 'styleAssigns.page_key = :page_key',
                    'params' => [':page_key' => $page_key],
                ],
            ];
        }
        $criteria->order = 't.updated_at DESC';

        /** @var self $model */
        $model = self::model()->enabled()->find($criteria);
        if ($model === null) {
            // стили для всех внутренних gtb
            if ($is_gtb && !in_array($page_key, [self::PAGE_KEY_ALL, self::PAGE_KEY_GTB_MAIN, self::PAGE_KEY_GTB_MAIN_EN, self::PAGE_KEY_GTB_ALL, self::PAGE_KEY_GTB_ALL_EN])) {
                if (Yii::app()->language == 'en') {
                    return self::getStyleByPageKey(self::PAGE_KEY_GTB_ALL_EN);
                }
                return self::getStyleByPageKey(self::PAGE_KEY_GTB_ALL);
            }
            // стили для всех внутренних gtu
            if ($is_gtu && !in_array($page_key, [self::PAGE_KEY_ALL, self::PAGE_KEY_GTU_MAIN, self::PAGE_KEY_GTU_MAIN_RU, self::PAGE_KEY_GTU_MAIN_EN, self::PAGE_KEY_GTU_ALL, self::PAGE_KEY_GTU_ALL_RU, self::PAGE_KEY_GTU_ALL_EN])) {
                if (Yii::app()->language == 'en') {
                    return self::getStyleByPageKey(self::PAGE_KEY_GTU_ALL_EN);
                }
                if (Yii::app()->language == 'ru') {
                    return self::getStyleByPageKey(self::PAGE_KEY_GTU_ALL_RU);
                }
                return self::getStyleByPageKey(self::PAGE_KEY_GTU_ALL);
            }
            if (!$is_gtb && !$is_gtu && !in_array($page_key, [self::PAGE_KEY_ALL, self::PAGE_KEY_GTB_ALL, self::PAGE_KEY_GTB_ALL_EN, self::PAGE_KEY_GTU_ALL, self::PAGE_KEY_GTU_ALL_RU, self::PAGE_KEY_GTU_ALL_EN])) {
                return self::getStyleByPageKey(self::PAGE_KEY_ALL);
            }
            return ['style' => '', 'url' => ''];
        }

        $bg_style = '';
        $bg_style_mobile = '';
        $bg_url = '';

        $bg_range = self::getAllowedBgTypeRange();

        if (in_array($model->background_type, $bg_range)) {
            // views count
            $request_md5 = md5(trim(explode('?', Yii::app()->request->getRequestUri())[0], '/') ?: 'index') . '-' . $model->id;
            $style_view_count = (array)Yii::app()->session->get('style_view_count', []);
            if (!isset($style_view_count[$request_md5])) {
                $model->views_count += 1;
                $model->save(false, ['views_count']);
                if (count($style_view_count) > 100) {
                    $style_view_count = [];
                }
                $style_view_count[$request_md5] = true;
                Yii::app()->session->add('style_view_count', $style_view_count);
            }

            $image = $model->getImageUrl('background_image');
            $image_mobile = $model->getImageUrl('background_image_mobile');
            $image_repeat = $model->getImageUrl('background_repeat_image');
            $bg_url = !empty($model->url) ? 'http://' . $model->url : '';
            $bg_color = (!empty($model->background_color) ? '#' . $model->background_color : '#fff');
            $page_padding = "padding-top: {$model->page_padding}px !important;";
            $page_padding_mobile = $model->page_padding_mobile > 0 ? "padding-top: {$model->page_padding_mobile}px !important;" : $page_padding;
            $bg_size_mobile = $model->background_width_mobile > 0 ? "background-size: {$model->background_width_mobile}px auto !important;" : 'background-size: contain !important;';
            switch ($model->background_type) {
                case self::BG_TYPE_CENTER_REPEAT_OTHER:
                    if (empty($image)) {
                        break;
                    }
                    if (empty($image_repeat)) {
                        $bg_style .= "background: scroll $bg_color url(\"$image\") 50% 0 no-repeat !important; $page_padding";
                    } else {
                        $bg_height = !empty($model->background_height) ? $model->background_height . 'px' : '0';
                        $bg_style .= "background-attachment: scroll, scroll;";
                        $bg_style .= "background-color: $bg_color !important;";
                        $bg_style .= "background-image: url(\"$image\"), url(\"$image_repeat\");";
                        $bg_style .= "background-position: 49.99999% 0, 49.99999% $bg_height !important;";
                        $bg_style .= "background-repeat: no-repeat, repeat;";
                        $bg_style .= $page_padding;
                    }
                    if (!empty($image_mobile)) {
                        $bg_style_mobile .= "background: scroll $bg_color url(\"$image_mobile\") 50% 0 no-repeat !important; $page_padding_mobile";
                        if (!empty($bg_size_mobile)) {
                            $bg_style_mobile .= " $bg_size_mobile";
                        }
                    }
                    break;
                case self::BG_TYPE_CENTER_NO_REPEAT :
                    if (empty($image)) {
                        break;
                    }
                    $bg_style .= "background: scroll $bg_color url(\"$image\") 50% 0 no-repeat !important; $page_padding";
                    if (!empty($image_mobile)) {
                        $bg_style_mobile .= "background: scroll $bg_color url(\"$image_mobile\") 50% 0 no-repeat !important; $page_padding_mobile";
                        if (!empty($bg_size_mobile)) {
                            $bg_style_mobile .= " $bg_size_mobile";
                        }
                    }
                    break;
                case self::BG_TYPE_REPEAT_ALL:
                    if (empty($image)) {
                        break;
                    }
                    $bg_style .= "background: scroll $bg_color url(\"$image\") 50% 0 repeat !important; $page_padding";
                    if (!empty($image_mobile)) {
                        $bg_style_mobile .= "background: scroll $bg_color url(\"$image_mobile\") 50% 0 repeat !important; $page_padding_mobile";
                        if (!empty($bg_size_mobile)) {
                            $bg_style_mobile .= " $bg_size_mobile";
                        }
                    }
                    break;
                default:
                    $bg_style .= "background: $bg_color !important; $page_padding";
                    $bg_style_mobile .= "background: $bg_color !important; $page_padding_mobile";
                    break;
            }
        }

        return [
            'style' => trim($bg_style),
            'style_mobile' => trim($bg_style_mobile),
            'url' => $bg_url,
        ];
    }
}
