<?php

/**
 * This is the model class for table "{{gtb_rubric}}".
 *
 * The followings are the available columns in table '{{gtb_rubric}}':
 * @property integer $id
 * @property string $url
 * @property string $title
 * @property string $title_en
 * @property string $title_be
 * @property string $description
 * @property string $description_en
 * @property string $description_be
 * @property integer $position
 * @property integer $in_todo_list
 * @property integer $hide_in_menu
 * @property integer $hide_in_menu_en
 * @property integer $hide_in_menu_be
 * @property integer $status_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property GtbPost[] $gtbPosts
 *
 * @method GtbRubric enabled()
 * @method GtbRubric sorted()
 */
class GtbRubric extends TravelActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{gtb_rubric}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return [
            ['url, title, title_en, title_be', 'required'],
            ['position, in_todo_list, hide_in_menu, hide_in_menu_en, hide_in_menu_be, status_id', 'numerical', 'integerOnly' => true],
            ['url', 'length', 'max' => 100],
            ['title, title_en, title_be', 'length', 'max' => 255],
            ['description, description_en, description_be, created_at, updated_at', 'safe'],
            ['status_id', 'in', 'range' => self::getAllowedStatusRange()],
            ['url', 'match', 'pattern' => '/^[A-Za-z0-9_-]+$/', 'message' => 'Только A-z, 0-9, _ и -'],
            // The following rule is used by search().
            ['id, url, title, title_en, title_be, description, description_en, description_be, position, in_todo_list, hide_in_menu, hide_in_menu_en, hide_in_menu_be, status_id, created_at, updated_at', 'safe', 'on' => 'search'],
        ];
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return [
            'gtbPosts' => [self::HAS_MANY, 'GtbPost', 'gtb_rubric_id'],
        ];
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
            'sorted' => [
                'order' => 'position, id',
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
            'url' => 'URL',
            'title' => 'Заголовок',
            'title_en' => 'Заголовок (EN)',
            'title_be' => 'Заголовок (BE)',
            'description' => 'Описание',
            'description_en' => 'Описание (EN)',
            'description_be' => 'Описание (BE)',
            'position' => 'Положение',
            'in_todo_list' => 'В TODO списке',
            'hide_in_menu' => 'Скрыть из меню',
            'hide_in_menu_en' => 'Скрыть из меню (EN)',
            'hide_in_menu_be' => 'Скрыть из меню (BE)',
            'status_id' => 'Статус',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
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
        $criteria->compare('title_en', $this->title_en, true);
        $criteria->compare('title_be', $this->title_be, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('description_en', $this->description_en, true);
        $criteria->compare('description_be', $this->description_be, true);
        $criteria->compare('position', $this->position);
        $criteria->compare('in_todo_list', $this->in_todo_list);
        $criteria->compare('hide_in_menu', $this->hide_in_menu);
        $criteria->compare('hide_in_menu_en', $this->hide_in_menu_en);
        $criteria->compare('hide_in_menu_be', $this->hide_in_menu_be);
        $criteria->compare('status_id', $this->status_id);
        $criteria->compare('created_at', $this->created_at, true);
        $criteria->compare('updated_at', $this->updated_at, true);

        return new CActiveDataProvider($this, [
            'criteria' => $criteria,
            'pagination' => [
                'pageSize' => self::PAGE_SIZE,
            ],
            'sort' => [
                'defaultOrder' => 'position, title',
            ],
        ]);
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return GtbRubric the static model class
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
            return Yii::app()->getBaseUrl(true) . '/gotobelarus/' . (Yii::app()->language != 'ru' ? Yii::app()->language . '/' : '') . 'rubric/' . $this->url;
        }
        return '#';
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        $lang = Yii::app()->language;
        $attr = $lang == 'ru' ? 'title' : 'title_' . $lang;
        return $this->{$attr};
    }
}
