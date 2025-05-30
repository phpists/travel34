<?php

/**
 * This is the model class for table "{{city}}".
 *
 * The followings are the available columns in table '{{city}}':
 * @property integer $id
 * @property string $title
 * @property string $created_at
 * @property string $updated_at
 * @property integer $world_part_id
 * @property string $url
 *
 * @property Post[] $posts
 *
 * @method City enabled()
 * @method City sitemap()
 */
class City extends TravelActiveRecord
{
    const WORLD_PART_EUROPE = 1;
    const WORLD_PART_ASIA = 2;
    const WORLD_PART_NORTH_AMERICA = 3;
    const WORLD_PART_SOUTH_AMERICA = 4;
    const WORLD_PART_AUSTRALIA = 5;
    const WORLD_PART_AFRICA = 6;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{city}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return [
            ['title, url', 'required'],
            ['title, url', 'unique'],
            ['title', 'length', 'max' => 255],
            ['world_part_id, status_id', 'numerical', 'integerOnly' => true],
            ['status_id', 'in', 'range' => self::getAllowedStatusRange()],
            ['world_part_id', 'in', 'range' => self::getAllowedWorldPartRange()],
            ['id, title, status_id, world_part_id, url', 'safe', 'on' => 'search'],
        ];
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => Yii::t('app', 'Title'),
            'status_id' => Yii::t('app', 'Status'),
            'world_part_id' => 'Часть света',
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
        $criteria->compare('world_part_id', $this->world_part_id, true);

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
            'posts' => [self::MANY_MANY, 'Post', 'tr_post_city_assignment(city_id, post_id)'],
        ];
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return City the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return array
     */
    public static function getWorldPartOptions()
    {
        return [
            self::WORLD_PART_EUROPE => 'Европа',
            self::WORLD_PART_ASIA => 'Азия',
            self::WORLD_PART_NORTH_AMERICA => 'Северная Америка',
            self::WORLD_PART_SOUTH_AMERICA => 'Южная Америка',
            self::WORLD_PART_AUSTRALIA => 'Австралия и Океания',
            self::WORLD_PART_AFRICA => 'Африка',
        ];
    }

    /**
     * @return array
     */
    public static function getAllowedWorldPartRange()
    {
        return array_keys(self::getWorldPartOptions());
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        if (!empty($this->url)) {
            return Yii::app()->getBaseUrl(true) . '/tags/' . urlencode($this->url);
        }
        return '#';
    }
}
