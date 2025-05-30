<?php

/**
 * This is the model class for table "{{gtu_banner}}".
 *
 * The followings are the available columns in table '{{gtu_banner}}':
 * @property integer $id
 * @property integer $banner_place_id
 * @property string $title
 * @property string $url
 * @property integer $open_new_tab
 * @property string $image
 * @property string $image_mobile
 * @property integer $grid_position
 * @property string $language
 * @property integer $status_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @method GtuBanner enabled()
 * @method GtuBanner currentLanguage()
 */
class GtuBanner extends TravelActiveRecord
{
    const PLACE_GTU_HOME_TOP = 1;
    const PLACE_GTU_TOP_ALL = 2;
    const PLACE_GTU_HOME_SMALL_POST = 3;
    const PLACE_GTU_HOME_FULL_WIDTH = 4;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{gtu_banner}}';
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
        $behaviors['uploadImageMobile'] = [
            'class' => 'application.behaviors.UploadFileBehavior',
            'attrName' => 'image_mobile',
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
            ['title, url', 'required'],
            ['banner_place_id, open_new_tab, grid_position, status_id', 'numerical', 'integerOnly' => true],
            ['title', 'length', 'max' => 45],
            ['url, image, image_mobile', 'length', 'max' => 255],
            ['language', 'length', 'max' => 6],
            ['created_at, updated_at', 'safe'],
            ['banner_place_id', 'in', 'range' => self::getAllowedBannerPlaceRange()],
            ['status_id', 'in', 'range' => self::getAllowedStatusRange()],
            // The following rule is used by search().
            ['id, banner_place_id, title, url, open_new_tab, image, image_mobile, grid_position, language, status_id, created_at, updated_at', 'safe', 'on' => 'search'],
        ];
    }

    /**
     * Scopes conditions
     * @return array
     */
    public function scopes()
    {
        return array_merge(parent::scopes(), [
            'currentLanguage' => [
                'condition' => "language = '' OR language IS NULL OR language = :language",
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
            'banner_place_id' => 'Баннерное место',
            'title' => 'Заголовок',
            'url' => 'URL',
            'open_new_tab' => 'Открывать в новой вкладке',
            'image' => 'Картинка',
            'image_mobile' => 'Мобильная картинка (для имиджевого)',
            'grid_position' => 'Положение в сетке (для имиджевого)',
            'language' => 'Язык',
            'status_id' => 'Статус',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search()
    {
        $criteria = new CDbCriteria();

        $criteria->compare('id', $this->id);
        $criteria->compare('banner_place_id', $this->banner_place_id);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('url', $this->url, true);
        $criteria->compare('open_new_tab', $this->open_new_tab);
        $criteria->compare('image', $this->image, true);
        $criteria->compare('image_mobile', $this->image_mobile, true);
        $criteria->compare('grid_position', $this->grid_position);
        $criteria->compare('language', $this->language, true);
        $criteria->compare('status_id', $this->status_id);
        $criteria->compare('created_at', $this->created_at, true);
        $criteria->compare('updated_at', $this->updated_at, true);

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
     * @return GtuBanner the static model class
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
            self::PLACE_GTU_HOME_TOP => 'Вверху главной страницы',
            self::PLACE_GTU_TOP_ALL => 'Сквозной вверху страницы',
            self::PLACE_GTU_HOME_SMALL_POST => 'Вместо поста на главной',
            self::PLACE_GTU_HOME_FULL_WIDTH => 'Имиджевый на главной',
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
     * @param int $placeID
     * @return null|GtuBanner
     */
    public static function getByPlace($placeID)
    {
        $banners = self::getAllByPlace($placeID);
        if (($total = count($banners)) > 0) {
            $offset = mt_rand(0, $total - 1);
            return $banners[$offset];
        }
        return null;
    }

    /**
     * @param int $placeID
     * @return static[]
     */
    public static function getAllByPlace($placeID)
    {
        if (in_array($placeID, self::getAllowedBannerPlaceRange())) {
            return self::model()->enabled()->currentLanguage()->findAllByAttributes(['banner_place_id' => $placeID]);
        } else {
            return [];
        }
    }
}
