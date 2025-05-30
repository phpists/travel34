<?php

/**
 * This is the model class for table "{{interactive_result}}".
 *
 * The followings are the available columns in table '{{interactive_result}}':
 * @property integer $id
 * @property integer $interactive_widget_id
 * @property string $text
 * @property string $created_at
 * @property string $updated_at
 *
 * The followings are the available model relations:
 * @property InteractiveWidget $interactiveWidget
 */
class InteractiveResult extends TravelActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{interactive_result}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return [
            ['interactive_widget_id', 'numerical', 'integerOnly' => true],
            ['text', 'safe'],
            ['created_at, updated_at', 'date', 'format' => 'yyyy-MM-dd hh:mm:ss'],
            ['created_at, updated_at', 'default', 'setOnEmpty' => true, 'value' => null],
            // The following rule is used by search().
            ['id, interactive_widget_id, text, created_at, updated_at', 'safe', 'on' => 'search'],
        ];
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return [
            'interactiveWidget' => [self::BELONGS_TO, 'InteractiveWidget', 'interactive_widget_id'],
        ];
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'interactive_widget_id' => 'Interactive Widget',
            'text' => 'Текст',
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return CActiveDataProvider
     */
    public function search()
    {
        $criteria = new CDbCriteria();

        $criteria->compare('id', $this->id);
        $criteria->compare('interactive_widget_id', $this->interactive_widget_id);
        $criteria->compare('text', $this->text, true);
        $criteria->compare('created_at', $this->created_at, true);
        $criteria->compare('updated_at', $this->updated_at, true);

        return new CActiveDataProvider($this, [
            'criteria' => $criteria,
            'sort' => [
                'defaultOrder' => 'id ASC',
            ],
            'pagination' => [
                'pageSize' => self::PAGE_SIZE,
            ],
        ]);
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return InteractiveResult the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
