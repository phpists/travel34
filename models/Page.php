<?php

/**
 * @property integer $id
 * @property string $url
 * @property string $title
 * @property string $page_title
 * @property string $page_keywords
 * @property string $description
 * @property string $text
 * @property integer $status_id
 */
class Page extends TravelActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{page}}';
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
            ['url, title', 'required'],
            ['status_id', 'numerical', 'integerOnly' => true],
            ['url, title, page_title, page_keywords', 'length', 'max' => 255],
            ['description, text', 'safe'],
            ['status_id', 'in', 'range' => self::getAllowedStatusRange()],
            ['url', 'match', 'pattern' => '/^[a-z0-9-]+$/', 'message' => 'Только "a-z", "0-9" и "-".'],
            ['url', 'unique'],
            // The following rule is used by search().
            ['id, url, title, page_title, page_keywords, description, text, status_id', 'safe', 'on' => 'search'],
        ];
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'url' => 'URL',
            'title' => Yii::t('app', 'Title'),
            'page_title' => 'Заголовок страницы',
            'page_keywords' => 'Ключевые слова',
            'description' => 'Описание страницы',
            'text' => 'Текст страницы',
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
        $criteria->compare('page_title', $this->page_title, true);
        $criteria->compare('page_keywords', $this->page_keywords, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('text', $this->text, true);
        $criteria->compare('status_id', $this->status_id);

        return new CActiveDataProvider($this, [
            'criteria' => $criteria,
            'pagination' => [
                'pageSize' => self::PAGE_SIZE,
            ],
        ]);
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Page the static model class
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
            return Yii::app()->getBaseUrl(true) . '/page/' . $this->url;
        }
        return '#';
    }
}
