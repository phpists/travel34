<?php

/**
 * This is the model class for table "{{block}}".
 *
 * The followings are the available columns in table '{{block}}':
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $content
 * @property integer $status_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @method Block enabled()
 */
class Block extends TravelActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{block}}';
    }

    public function behaviors()
    {
        return [];
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return [
            ['name', 'required'],
            ['status_id', 'numerical', 'integerOnly' => true],
            ['name', 'length', 'max' => 100],
            ['description', 'length', 'max' => 255],
            ['content', 'safe'],
            ['created_at, updated_at', 'date', 'format' => 'yyyy-MM-dd hh:mm:ss'],
            ['created_at, updated_at', 'default', 'setOnEmpty' => true, 'value' => null],
            ['status_id', 'in', 'range' => self::getAllowedStatusRange()],
            ['name', 'match', 'pattern' => '/^[a-z0-9_]+$/', 'message' => 'Только a-z, 0-9 и _'],
            ['name', 'unique'],
            // The following rule is used by search().
            ['id, name, description, content, status_id, created_at, updated_at', 'safe', 'on' => 'search'],
        ];
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'description' => Yii::t('app', 'Description'),
            'content' => Yii::t('app', 'Content'),
            'status_id' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
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
        $criteria->compare('name', $this->name, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('content', $this->content, true);
        $criteria->compare('status_id', $this->status_id);
        $criteria->compare('created_at', $this->created_at, true);
        $criteria->compare('updated_at', $this->updated_at, true);

        return new CActiveDataProvider($this, [
            'criteria' => $criteria,
            'pagination' => [
                'pageSize' => self::PAGE_SIZE,
            ],
            'sort' => [
                'defaultOrder' => 'name',
            ],
        ]);
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Block the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
