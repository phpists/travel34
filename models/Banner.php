<?php

/**
 * This is the model class for table "{{banner}}".
 *
 * The followings are the available columns in table '{{banner}}':
 * @property integer $id
 * @property int $banner_place_id
 * @property int $banner_system
 * @property string $title
 * @property string $content
 * @property string $code
 * @property int $status_id
 * @property string $created_at
 * @property string $updated_at
 * @property array $worldTypeOptions
 * @property string $url
 * @property string $geo_target
 * @property string $image
 * @property integer $open_new_tab
 */
class Banner extends TravelActiveRecord
{
    const PLACE_HOME_TOP_VERTICAL = 1;
    const PLACE_HOME_MIDDLE_VERTICAL = 2;
    const PLACE_HOME_BOTTOM_WIDE = 3;
    const PLACE_NEWS_VERTICAL = 4;
    const PLACE_SEARCH_VERTICAL = 10;
    const PLACE_HOME_TOP_WIDE = 5;
    const PLACE_OTHER_TOP_WIDE = 6;
    const PLACE_ALL_VERTICAL = 11;
    //const PLACE_ALL_TOP_WIDE = 12;
    const PLACE_AFTER_POST = 13;
    const PLACE_IN_POST = 14;

    const SYSTEM_OWN = 0;
    const SYSTEM_ADFOX = 1;

    public $geo_target_codes = [];

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{banner}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return [
            ['title', 'required'],
            ['content, code', 'safe'],
            ['title, geo_target', 'length', 'max' => 255],
            ['banner_place_id, banner_system, status_id', 'numerical', 'integerOnly' => true],
            ['status_id', 'in', 'range' => self::getAllowedStatusRange()],
            ['banner_place_id', 'in', 'range' => self::getAllowedBannerPlaceRange()],
            ['banner_system', 'in', 'range' => array_keys(self::getBannerSystems())],
            ['id, title, status_id, banner_place_id, banner_system, content, code', 'safe', 'on' => 'search'],
            ['geo_target_codes, url, image, open_new_tab', 'safe'],
            [
                'url',
                'match',
                'pattern' =>
                    '/^https?:\/\/(?:www\.)?[-a-zA-Z0-9@:%._\+~#=]{1,256}\.[a-zA-Z0-9()]{1,6}\b(?:[-a-zA-Z0-9()@:%_\+.~#?&\/=]*)$/',
                'message' => 'Введите валидный url, например: https://example.com/my-link.'
            ],
        ];
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'banner_place_id' => 'Баннерное место',
            'banner_system' => 'Баннерная система',
            'title' => 'Заголовок',
            'content' => 'Контент',
            'code' => 'Код',
            'status_id' => 'Статус',
            'geo_target' => 'Гео-цели',
            'geo_target_codes' => 'Гео-цели',
            'open_new_tab' => 'Открывать в новой вкладке',
            'url' => 'Ссылка',
            'image' => 'Картинка',
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
        $criteria->compare('status_id', $this->status_id, true);
        $criteria->compare('banner_place_id', $this->banner_place_id, true);
        $criteria->compare('banner_system', $this->banner_system, true);

        return new CActiveDataProvider($this, [
            'criteria' => $criteria,
            'pagination' => [
                'pageSize' => self::PAGE_SIZE,
            ],
            'sort' => [
                'defaultOrder' => 'created_at DESC',
            ],
        ]);
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Banner the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return array
     */
    public static function getBannerPlaceOptions()
    {
        return [
            self::PLACE_HOME_TOP_VERTICAL => 'Главная Топ',
            self::PLACE_HOME_MIDDLE_VERTICAL => 'Главная Миддл',
//            self::PLACE_HOME_BOTTOM_WIDE => 'Главная внизу (x100)',
            self::PLACE_NEWS_VERTICAL => 'Новости',
            self::PLACE_SEARCH_VERTICAL => 'Поиск',
            self::PLACE_ALL_VERTICAL => 'Сквозной', // Главная Топ + Новости + Поиск
            self::PLACE_HOME_TOP_WIDE => 'Главная над хедером',
            self::PLACE_OTHER_TOP_WIDE => 'Внутренние над хедером',
            //self::PLACE_ALL_TOP_WIDE => 'Сквозной над хедером',
            self::PLACE_AFTER_POST => 'После материала',
//            self::PLACE_IN_POST => 'В материалах',
        ];
    }

    /**
     * @return array
     */
    public static function getAllowedBannerPlaceRange()
    {
        return array_keys(self::getBannerPlaceOptions());
    }

    /**
     * @return array
     */
    public static function getBannerSystems()
    {
        return [
            self::SYSTEM_OWN => 'Своя',
            self::SYSTEM_ADFOX => 'AdFox',
        ];
    }

    /**
     * @inheritDoc
     */
    public function behaviors(): array
    {

        return array_merge(parent::behaviors(), [
            'uploadImage' => [
                'class' => 'application.behaviors.UploadFileBehavior',
                'attrName' => 'image',
                'savePath' => self::IMAGES_PATH,
                'fileTypes' => 'svg,png,jpeg,jpg,gif',
            ],
        ]);
    }

    //private static $_usedBanners = [];

    /**
     * @param int $placeID
     * @return null|Banner
     */
    public static function getByPlace($placeID)
    {
        if (in_array($placeID, self::getAllowedBannerPlaceRange())) {
            $banner = null;

            $criteria = new GeoDbCriteria();
            $criteria->compare('banner_place_id', $placeID);
            $criteria->compare('banner_system', self::SYSTEM_OWN);
            $criteria->compare('status_id', self::STATUS_ENABLED);
            /*if (!empty(self::$_usedBanners)) {
                $criteria->addNotInCondition('id', self::$_usedBanners);
            }*/
            $banners = self::model()->findAll($criteria);
            if (count($banners) > 0) {
                $randomOffset = rand(0, count($banners) - 1);
                $banner = $banners[$randomOffset];
                //self::$_usedBanners[$banner->id] = $banner->id;
                self::registerCode($banner);
                return $banner;
            }

            // если место "Главная Топ", "Новости", или "Поиск" - проверить сквозной вертикальный
            if (in_array($placeID, [self::PLACE_HOME_TOP_VERTICAL, self::PLACE_NEWS_VERTICAL, self::PLACE_SEARCH_VERTICAL])) {
                $place_all_vertical = self::getByPlace(self::PLACE_ALL_VERTICAL);
                if ($place_all_vertical !== null) {
                    $banner = $place_all_vertical;
                    //self::$_usedBanners[$banner->id] = $banner->id;
                    self::registerCode($banner);
                    return $banner;
                }
            }
        }
        return null;
    }

    /**
     * @param static $banner
     */
    public static function registerCode($banner)
    {
        if ($banner->banner_system == self::SYSTEM_ADFOX) {
            Yii::app()->controller->bannerSystems[self::SYSTEM_ADFOX] = true;
        }
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
     * @inheritdoc
     */
    protected function afterFind()
    {
        $this->geo_target_codes = preg_split('/\s*,\s*/', trim($this->geo_target), -1, PREG_SPLIT_NO_EMPTY);
        parent::afterFind();
    }
}
