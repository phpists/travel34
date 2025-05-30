<?php

/**
 * This is the base model class for table "{{gtb_place}}" and "{{gtu_place}}".
 *
 * @property integer $id
 * @property integer $author_id
 * @property string $related_posts
 * @property string $related_posts_gtu
 * @property string $related_posts_gtb
 * @property integer $status_id
 * @property float $lat
 * @property float $lng
 * @property string $type
 * @property string $description
 * @property string $created_at
 * @property string $updated_at
 *
 * @method GtbPlace enabled()
 */
class BasePlace extends TravelActiveRecord
{
    const TYPE_MUST_SEE = 'must_see';
    const TYPE_NATURE = 'nature';
    const TYPE_PLACE = 'place';

    const TYPE_PINS = [
        'must_see' => "/themes/travel/i/pin1.svg",
        'place' => "/themes/travel/i/pin2.svg",
        'nature' => "/themes/travel/i/pin3.svg",
    ];

    const TYPE_COLORS = [
        'must_see' => "black",
        'place' => "#A89016",
        'nature' => "#739B53",
    ];

    const TYPE_STYLES = [
        'must_see' => "popup1-style",
        'place' => "popup2-style",
        'nature' => "popup3-style",
    ];

    public $related_posts_ids = [];
    public $related_posts_gtu_ids = [];
    public $related_posts_gtb_ids = [];

    const IMAGES_PATH = 'media/places';

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return [
            ['title, lat, lng', 'required'],
            ['status_id, author_id', 'numerical', 'integerOnly' => true],
            ['lat, lng', 'numerical', 'integerOnly' => false],
            ['language', 'length', 'max' => 6],
            ['title, related_posts, related_posts_gtu, related_posts_gtb', 'length', 'max' => 255],
            ['type, description, images', 'safe'],
            ['created_at, updated_at', 'date', 'format' => 'yyyy-MM-dd hh:mm:ss'],
            ['created_at, updated_at', 'default', 'setOnEmpty' => true, 'value' => null],
            ['status_id', 'in', 'range' => self::getAllowedStatusRange()],
            ['related_posts_ids, related_posts_gtu_ids, related_posts_gtb_ids', 'safe'],
            // The following rule is used by search().
            ['id, author_id, related_posts, related_posts_gtu, related_posts_gtb, status_id, created_at, updated_at', 'safe', 'on' => 'search'],
        ];
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'CTimestampBehavior' => [
                'class' => 'zii.behaviors.CTimestampBehavior',
                'createAttribute' => 'created_at',
                'updateAttribute' => 'updated_at',
                'setUpdateOnCreate' => true,
            ],
            'CAdvancedArFindBehavior' => [
                'class' => 'application.behaviors.CAdvancedArFindBehavior',
            ],
            'CAdvancedArBehavior' => [
                'class' => 'application.behaviors.CAdvancedArBehavior',
            ],
        ];
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return [
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
                'condition' => 't.status_id = :status_id AND t.date <= NOW()',
                'params' => [':status_id' => self::STATUS_ENABLED],
            ],
            'currentLanguage' => [
                'condition' => 't.language = :language',
                'params' => [':language' => Yii::app()->language],
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
            'lat' => Yii::t('app', 'Latitude'),
            'lng' => Yii::t('app', 'Longitude'),
            'type' => 'Тип',
            'language' => 'Лента / язык',
            'title' => Yii::t('app', 'Title'),
            'image' => 'Тизер-картинка',
            'summary' => Yii::t('app', 'Summary'),
            'text' => Yii::t('app', 'Text'),
            'related_posts' => Yii::t('app', 'Related Posts'),
            'status_id' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'related_posts_ids' => 'Связанные посты',
            'related_posts_gtu_ids' => 'Связанные посты GTU',
            'related_posts_gtb_ids' => 'Связанные посты GTB',
        ];
    }

    /**
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search()
    {
        $criteria = new CDbCriteria();

        $must_use_ids = false;
        $post_ids = [];

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.author_id', $this->author_id);
        $criteria->compare('t.type', $this->type);
        $criteria->compare('t.language', $this->language, true);
        $criteria->compare('t.lat', $this->lat, true);
        $criteria->compare('t.lng', $this->lng, true);
        $criteria->compare('t.title', $this->title, true);
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
                'defaultOrder' => 't.created_at DESC',
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
     * @param string $attr
     * @return bool
     */
    protected function saveRelatedPosts($attr = 'related_posts')
    {
        $model_attr = $attr . '_ids';
        // related_posts
        $related_posts_ids = [];
        foreach ($this->$model_attr as $rid) {
            $rid = (int)$rid;
            if ($rid > 0) {
                $related_posts_ids[] = $rid;
            }
        }
        $this->$attr = implode(',', $related_posts_ids);

        return true;
    }

    /**
     * @return bool
     */
    protected function beforeSave()
    {
        if (parent::beforeSave()) {

            $this->saveRelatedPosts('related_posts');
            $this->saveRelatedPosts('related_posts_gtu');
            $this->saveRelatedPosts('related_posts_gtb');

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
        $this->related_posts_ids = preg_split('/\s*,\s*/', trim($this->related_posts), -1, PREG_SPLIT_NO_EMPTY);
        $this->related_posts_gtu_ids = preg_split('/\s*,\s*/', trim($this->related_posts_gtu), -1, PREG_SPLIT_NO_EMPTY);
        $this->related_posts_gtb_ids = preg_split('/\s*,\s*/', trim($this->related_posts_gtb), -1, PREG_SPLIT_NO_EMPTY);

        parent::afterFind();
    }

    /**
     * @return array
     */
    public static function getTypeOptions()
    {
        return [
            self::TYPE_MUST_SEE => Yii::t('app', 'Must see'),
            self::TYPE_PLACE => Yii::t('app', 'Place'),
            self::TYPE_NATURE => Yii::t('app', 'Nature'),
        ];
    }

    /**
     * @return mixed
     */
    public function getTypePin()
    {
        if (isset(self::TYPE_PINS[$this->type])) {
            return self::TYPE_PINS[$this->type];
        }
        return self::TYPE_PINS[self::TYPE_PLACE];
    }

    /**
     * @return mixed
     */
    public function getStylePopup()
    {
        if (isset(self::TYPE_STYLES[$this->type])) {
            return self::TYPE_STYLES[$this->type];
        }
        return self::TYPE_STYLES[self::TYPE_PLACE];
    }

    /**
     * @return mixed
     */
    public static function getTypeColor($type)
    {
        if (isset(self::TYPE_COLORS[$type])) {
            return self::TYPE_COLORS[$type];
        }
        return self::TYPE_COLORS[self::TYPE_PLACE];
    }

    /**
     * @return bool
     */
    public function isEnabled()
    {
        return $this->status_id == self::STATUS_ENABLED;
    }

    /**
     * @param string $attr
     * @param string $class
     * @param int $limit
     * @return array
     */
    public function getRelatedPosts($attr = 'related_posts_ids', $class = 'Post', $limit = 6)
    {
        $relatedPosts = [];

        if (!empty($this->$attr)) {
            $criteria = new CDbCriteria();
            $criteria->addInCondition('t.id', $this->$attr);
            $criteria->scopes = ['enabled', 'sorted'];
            $criteria->offset = 0;
            $criteria->limit = $limit;
            $relatedPosts = $class::model()->findAll($criteria);
        }

        return $relatedPosts;
    }

    /**
     * @param int $limit
     * @return mixed
     */
    public function getRelatedPostsList($limit = 6)
    {
        $relatedPosts = $this->getRelatedPosts('related_posts_ids', 'Post', $limit);
        $relatedPosts = array_merge($relatedPosts, $this->getRelatedPosts('related_posts_gtu_ids', 'GtuPost', $limit));
        $relatedPosts = array_merge($relatedPosts, $this->getRelatedPosts('related_posts_gtb_ids', 'GtbPost', $limit));

        return $relatedPosts;
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
     * @param string $type
     * @param null $class
     * @return array
     */
    public static function getPlacesForMap($type = '', $class = null ) {
        $atts = ['status_id' => 1];

        if ($type) $atts['type'] = [$type];

        $places = $class::model()->currentLanguage()->findAllByAttributes($atts);

        $features = [];

        foreach ($places as $place) {
            $related = $place->getRelatedPostsList();
            $links = [];

            $controllers = [
                'Post' => 'post',
                'GtuPost' => 'gtu',
                'GtbPost' => 'gtb',
            ];

            foreach ($related as $post) {
                $links[] = [
                    'text' => $post->title,
                    //'href' => Yii::app()->createUrl($controllers[get_class($post)] . '/view', ['url' => $post->url]),
                    'href' => Yii::app()->urlManager->createUrl($controllers[get_class($post)] . '/view', ['url' => $post->url, 'language' => isset($post->language) ? $post->language : 'ru'])
                ];
            }

            $images = explode(PHP_EOL, $place->images);
            foreach ($images as $key => $image) {
                $images[$key] = trim($image);
            }

            $features[] = [
                "type" => 'Feature',
                "geometry" => [
                    "type" => "Point",
                    "coordinates" => [
                        $place->lat,
                        $place->lng
                    ]
                ],
                'properties' => [
                    "title" => $place->title,
                    "coordinates" => $place->lat . ', ' . $place->lng,
                    "description" => $place->description,
                    "links" => $links,
                    "stylePopup" => $place->getStylePopup(),
                    "objectImgSlider" => $images
                ],
                'options' => [
                    "pinUrl" => $place->getTypePin()
                ],
            ];
        }

        return [
            "type" => 'FeatureCollection',
            "features" => $features
        ];

    }

}
