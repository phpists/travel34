<?php

/**
 * This is the model class for table "{{gtu_rubric}}".
 *
 * The followings are the available columns in table '{{gtu_rubric}}':
 * @property integer $id
 * @property string $url
 * @property string $title
 * @property string $title_ru
 * @property string $title_en
 * @property integer $position
 * @property integer $in_todo_list
 * @property integer $hide_in_menu
 * @property integer $hide_in_menu_ru
 * @property integer $hide_in_menu_en
 * @property integer $status_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property GtuPost[] $gtuPosts
 *
 * @method GtuRubric enabled()
 * @method GtuRubric sorted()
 */
class GtuRubric extends TravelActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{gtu_rubric}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return [
            ['url, title, title_ru, title_en', 'required'],
            ['position, in_todo_list, hide_in_menu, hide_in_menu_ru, hide_in_menu_en, status_id', 'numerical', 'integerOnly' => true],
            ['url', 'length', 'max' => 100],
            ['title, title_ru, title_en', 'length', 'max' => 255],
            ['created_at, updated_at', 'safe'],
            ['status_id', 'in', 'range' => self::getAllowedStatusRange()],
            ['url', 'match', 'pattern' => '/^[A-Za-z0-9_-]+$/', 'message' => 'Только A-z, 0-9, _ и -'],
            // The following rule is used by search().
            ['id, url, title, title_ru, title_en, position, in_todo_list, hide_in_menu, hide_in_menu_ru, hide_in_menu_en, status_id, created_at, updated_at', 'safe', 'on' => 'search'],
        ];
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return [
            'gtuPosts' => [self::HAS_MANY, 'GtuPost', 'gtu_rubric_id'],
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
            'title_ru' => 'Заголовок Ru',
            'title_en' => 'Заголовок En',
            'position' => 'Положение',
            'in_todo_list' => 'В TODO списке',
            'hide_in_menu' => 'Скрыть из меню',
            'hide_in_menu_ru' => 'Скрыть из меню Ru',
            'hide_in_menu_en' => 'Скрыть из меню En',
            'status_id' => 'Статус',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
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
        $criteria->compare('url', $this->url, true);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('title_ru', $this->title_ru, true);
        $criteria->compare('title_en', $this->title_en, true);
        $criteria->compare('position', $this->position);
        $criteria->compare('in_todo_list', $this->in_todo_list);
        $criteria->compare('hide_in_menu', $this->hide_in_menu);
        $criteria->compare('hide_in_menu_ru', $this->hide_in_menu_ru);
        $criteria->compare('hide_in_menu_en', $this->hide_in_menu_en);
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
     * @return GtuRubric the static model class
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
            $l = Yii::app()->language;
            return Yii::app()->getBaseUrl(true) . '/gotoukraine/' . ($l != 'uk' ? $l . '/' : '') . 'rubric/' . $this->url;
        }
        return '#';
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        if (Yii::app()->language == 'en') {
            return $this->title_en ?: $this->title;
        } elseif (Yii::app()->language == 'ru') {
            return $this->title_ru ?: $this->title;
        } else {
            return $this->title;
        }
    }
}
