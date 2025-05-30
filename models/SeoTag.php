<?php

/**
 * @property integer $id
 * @property string $path
 * @property string $title
 * @property string $description
 * @property string $image
 */
class SeoTag extends TravelActiveRecord
{
    const IMAGES_PATH = 'media/pages';

    /**
     * @return string
     */
    public function tableName()
    {
        return '{{seo_tag}}';
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
            'uploadImage' => [
                'class' => 'application.behaviors.UploadFileBehavior',
                'attrName' => 'image',
                'savePath' => self::IMAGES_PATH,
            ],
        ];
    }

    public function scopes()
    {
        return [];
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            ['path, title', 'required'],
            ['path', 'length', 'max' => 100],
            ['title, description, image', 'length', 'max' => 255],
            ['path', 'unique'],
            ['id, path, title, description, image', 'safe', 'on' => 'search'],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'path' => Yii::t('app', 'Path'),
            'title' => Yii::t('app', 'Title'),
            'description' => Yii::t('app', 'Description'),
            'image' => Yii::t('app', 'Image'),
        ];
    }

    /**
     * @return CActiveDataProvider
     */
    public function search()
    {
        $criteria = new CDbCriteria();

        $criteria->compare('id', $this->id);
        $criteria->compare('path', $this->path, true);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('image', $this->image, true);

        return new CActiveDataProvider($this, [
            'criteria' => $criteria,
            'pagination' => [
                'pageSize' => self::PAGE_SIZE,
            ],
            'sort' => [
                'defaultOrder' => 'path ASC',
            ],
        ]);
    }

    /**
     * @param string $className
     * @return SeoTag
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
