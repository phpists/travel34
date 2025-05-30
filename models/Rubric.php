<?php

/**
 * This is the model class for table "{{rubric}}".
 *
 * The followings are the available columns in table '{{rubric}}':
 * @property integer $id
 * @property string $title
 * @property string $image
 * @property string $url
 * @property string $description
 * @property integer $status_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Post[] $posts
 */
class Rubric extends TravelActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{rubric}}';
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
        return $behaviors;
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return [
            ['title, url', 'required'],
            ['title, url', 'unique'],
            ['url', 'length', 'max' => 100],
            ['title, image', 'length', 'max' => 255],
            ['status_id', 'numerical', 'integerOnly' => true],
            ['description', 'safe'],
            ['status_id', 'in', 'range' => self::getAllowedStatusRange()],
            ['url', 'match', 'pattern' => '/^[A-Za-z0-9_-]+$/', 'message' => 'Только "A-z", "0-9" и "-".'],
            ['id, title, status_id, image, description', 'safe', 'on' => 'search'],
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
            'status_id' => 'Статус',
            'description' => 'Описание',
            'image' => 'Картинка',
            'url' => 'URL',
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
        $criteria->compare('description', $this->description, true);
        $criteria->compare('url', $this->url, true);

        return new CActiveDataProvider($this, [
            'criteria' => $criteria,
            'pagination' => [
                'pageSize' => self::PAGE_SIZE,
            ],
            'sort' => [
                'defaultOrder' => 'title ASC',
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
            'sitemap' => [
                'select' => 'url',
                'condition' => 'status_id = :status_id',
                'params' => [':status_id' => self::STATUS_ENABLED],
                'order' => 'id',
            ],
        ]);
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return [
            'posts' => [self::HAS_MANY, 'Post', 'rubric_id'],
        ];
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Rubric the static model class
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
            return Yii::app()->getBaseUrl(true) . '/rubrics/' . $this->url;
        }
        return '#';
    }
}
