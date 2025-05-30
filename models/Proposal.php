<?php

/**
 * This is the model class for table "{{proposal}}".
 *
 * The followings are the available columns in table '{{proposal}}':
 * @property integer $id
 * @property string $form_type
 * @property string $name
 * @property string $phone
 * @property integer $processed
 * @property string $created_at
 * @property string $updated_at
 */
class Proposal extends TravelActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{proposal}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return [
            ['processed', 'numerical', 'integerOnly' => true],
            ['form_type', 'length', 'max' => 30],
            ['name, phone', 'length', 'max' => 255],
            ['created_at, updated_at', 'safe'],
            // The following rule is used by search().
            ['id, form_type, name, phone, processed, created_at, updated_at', 'safe', 'on' => 'search'],
        ];
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'form_type' => 'Тип формы',
            'name' => 'Имя',
            'phone' => 'Телефон',
            'processed' => 'Обработан',
            'created_at' => 'Создано',
            'updated_at' => 'Обновлено',
        ];
    }

    /**
     * @return CActiveDataProvider
     */
    public function search()
    {
        $criteria = new CDbCriteria();

        $criteria->compare('id', $this->id);
        $criteria->compare('form_type', $this->form_type, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('phone', $this->phone, true);
        $criteria->compare('processed', $this->processed);
        $criteria->compare('created_at', $this->created_at, true);
        $criteria->compare('updated_at', $this->updated_at, true);

        return new CActiveDataProvider($this, [
            'criteria' => $criteria,
            'sort' => [
                'defaultOrder' => 't.id DESC',
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
     * @return Proposal the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
