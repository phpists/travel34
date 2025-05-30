<?php

/**
 * This is the model class for table "{{author}}".
 *
 * The followings are the available columns in table '{{author}}':
 * @property integer $id
 * @property string $title
 * @property string $page_title
 * @property string $page_description
 */
class Author extends CActiveRecord
{
    const PAGE_SIZE = 50;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{author}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return [
            ['title', 'required'],
            ['title', 'unique'],
            ['title, page_title, page_description', 'length', 'max' => 255],
            ['id, title, page_title, page_description', 'safe', 'on' => 'search'],
        ];
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Имя',
            'page_title' => 'Заголовок страницы',
            'page_description' => 'Описание страницы',
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
        $criteria->compare('title', $this->title, true);
        $criteria->compare('page_title', $this->page_title, true);
        $criteria->compare('page_description', $this->page_description, true);

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
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Author the static model class
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
        if (!empty($this->title)) {
            return Yii::app()->getBaseUrl(true) . '/authors/' . urlencode($this->title);
        }
        return '#';
    }
}
