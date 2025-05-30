<?php

/**
 * @property integer $id
 * @property string $url
 * @property string $title
 * @property string $description
 * @property string $image_list
 * @property string $image
 * @property integer $image_width
 * @property integer $is_new
 * @property integer $position
 * @property integer $status_id
 *
 * @method SpecialProject enabled()
 */
class SpecialProject extends TravelActiveRecord
{
    /**
     * @return string
     */
    public function tableName()
    {
        return '{{special_project}}';
    }

    public function behaviors()
    {
        return [
            'CAdvancedArFindBehavior' => [
                'class' => 'application.behaviors.CAdvancedArFindBehavior',
            ],
            'CAdvancedArBehavior' => [
                'class' => 'application.behaviors.CAdvancedArBehavior',
            ],
            'uploadImageList' => [
                'class' => 'application.behaviors.UploadFileBehavior',
                'attrName' => 'image_list',
                'savePath' => self::IMAGES_PATH,
            ],
            'uploadImage' => [
                'class' => 'application.behaviors.UploadFileBehavior',
                'attrName' => 'image',
                'savePath' => self::IMAGES_PATH,
                'fileTypes' => 'jpg,jpeg,gif,png,svg',
            ],
        ];
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            ['url, title', 'required'],
            ['image_width, is_new, position, status_id', 'numerical', 'integerOnly' => true],
            ['url', 'length', 'max' => 100],
            ['title', 'length', 'max' => 255],
            ['is_new', 'in', 'range' => self::getAllowedStatusRange()],
            ['status_id', 'in', 'range' => self::getAllowedStatusRange()],
            ['url', 'match', 'pattern' => '/^[a-z0-9]+$/', 'message' => 'Разрешены только цифры и латинские буквы.'],
            ['url', 'unique'],
            ['id, url, title, description, image_list, image, is_new, position, status_id', 'safe', 'on' => 'search'],
            ['description, image_list, image', 'safe'],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'url' => 'URL',
            'title' => Yii::t('app', 'Title'),
            'description' => 'Описание',
            'image_list' => 'Картинка (300x200)',
            'image' => 'Картинка для меню',
            'image_width' => 'Ширина SVG картинки',
            'is_new' => 'Новый спецпроект',
            'position' => 'Положение в меню',
            'status_id' => 'Статус',
        ];
    }

    /**
     * @return CActiveDataProvider
     */
    public function search()
    {
        $criteria = new CDbCriteria();

        $criteria->compare('id', $this->id);
        $criteria->compare('url', $this->url, true);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('image_list', $this->image_list, true);
        $criteria->compare('image', $this->image, true);
        $criteria->compare('image_width', $this->image);
        $criteria->compare('is_new', $this->is_new);
        $criteria->compare('position', $this->position);
        $criteria->compare('status_id', $this->status_id);

        return new CActiveDataProvider($this, [
            'criteria' => $criteria,
            'pagination' => [
                'pageSize' => self::PAGE_SIZE,
            ],
            'sort' => [
                'defaultOrder' => 'position ASC',
            ],
        ]);
    }

    /**
     * @param string $className
     * @return SpecialProject
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        if (!empty($this->url)) {
            return Yii::app()->getBaseUrl(true) . '/special/' . $this->url;
        }
        return '#';
    }

    private static $_items;

    /**
     * @return array
     */
    public static function getItems()
    {
        if (self::$_items === null) {
            self::$_items = [0 => 'Нет'];
            /** @var self[] $models */
            $models = self::model()->findAll(['order' => 'title ASC']);
            foreach ($models as $one) {
                self::$_items[(int)$one->id] = $one->title;
            }
        }
        return self::$_items;
    }

    private static $_enabledItems;

    /**
     * @return self[]
     */
    public static function getNewItems()
    {
        if (self::$_enabledItems === null) {
            self::$_enabledItems = [];
            /** @var self[] $models */
            $models = self::model()->enabled()->findAll([
                'condition' => 'is_new = ' . self::STATUS_ENABLED,
                'order' => 'position ASC',
            ]);
            foreach ($models as $one) {
                self::$_enabledItems[] = $one;
            }
        }
        return self::$_enabledItems;
    }
}
