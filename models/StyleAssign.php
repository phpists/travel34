<?php

/**
 * This is the model class for table "{{style_assign}}".
 *
 * The followings are the available columns in table '{{style_assign}}':
 * @property integer $id
 * @property integer $style_id
 * @property string $page_key
 * @property integer $item_id
 *
 * The followings are the available model relations:
 * @property Style $style
 */
class StyleAssign extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{style_assign}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return [
            ['style_id, page_key', 'required'],
            ['style_id, item_id', 'numerical', 'integerOnly' => true],
            ['page_key', 'length', 'max' => 255],
            // The following rule is used by search().
            ['id, style_id, page_key, item_id', 'safe', 'on' => 'search'],
        ];
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return [
            'style' => [self::BELONGS_TO, 'Style', 'style_id'],
        ];
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'style_id' => 'Стиль',
            'page_key' => 'Страница',
            'item_id' => 'Элемент',
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
        $criteria->compare('style_id', $this->style_id);
        $criteria->compare('page_key', $this->page_key, true);
        $criteria->compare('item_id', $this->item_id);

        return new CActiveDataProvider($this, [
            'criteria' => $criteria,
        ]);
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return StyleAssign the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return mixed
     */
    public function getItem()
    {
        if ($this->page_key == Style::PAGE_KEY_PAGE) {
            return Page::model()->findByPk($this->item_id);
        }
        if ($this->page_key == Style::PAGE_KEY_POST) {
            return Post::model()->findByPk($this->item_id);
        }
        if ($this->page_key == Style::PAGE_KEY_RUBRIC) {
            return Rubric::model()->findByPk($this->item_id);
        }
        if ($this->page_key == Style::PAGE_KEY_SPECIAL) {
            return SpecialProject::model()->findByPk($this->item_id);
        }
        if ($this->page_key == Style::PAGE_KEY_GTB_POST) {
            return GtbPost::model()->findByPk($this->item_id);
        }
        if ($this->page_key == Style::PAGE_KEY_GTB_RUBRIC || $this->page_key == Style::PAGE_KEY_GTB_RUBRIC_EN) {
            return GtbRubric::model()->findByPk($this->item_id);
        }
        if ($this->page_key == Style::PAGE_KEY_GTU_POST) {
            return GtuPost::model()->findByPk($this->item_id);
        }
        if ($this->page_key == Style::PAGE_KEY_GTU_RUBRIC || $this->page_key == Style::PAGE_KEY_GTU_RUBRIC_RU || $this->page_key == Style::PAGE_KEY_GTU_RUBRIC_EN) {
            return GtuRubric::model()->findByPk($this->item_id);
        }
        return null;
    }

    /**
     * @param static $assign
     * @param bool $with_page_key
     * @return string
     */
    public static function getItemLink($assign, $with_page_key = true)
    {
        $data = '';
        if ($with_page_key) {
            $page_keys_all = Style::getPageKeysAll();
            $page_key_title = isset($page_keys_all[$assign->page_key]) ? $page_keys_all[$assign->page_key] : '';
            $data .= '<strong>' . $page_key_title . '</strong>' . "\n";
        }
        $item = $assign->getItem();
        if ($item instanceof GtbRubric && $assign->page_key == Style::PAGE_KEY_GTB_RUBRIC_EN) {
            $lang = Yii::app()->language;
            Yii::app()->language = 'en';
            $data .= CHtml::link($item->title_en, $item->getUrl(), ['target' => '_blank']) . "\n";
            Yii::app()->language = $lang;
        } elseif ($item instanceof GtuRubric && $assign->page_key == Style::PAGE_KEY_GTU_RUBRIC_RU) {
            $lang = Yii::app()->language;
            Yii::app()->language = 'ru';
            $data .= CHtml::link($item->title_ru, $item->getUrl(), ['target' => '_blank']) . "\n";
            Yii::app()->language = $lang;
        } elseif ($item instanceof GtuRubric && $assign->page_key == Style::PAGE_KEY_GTU_RUBRIC_EN) {
            $lang = Yii::app()->language;
            Yii::app()->language = 'en';
            $data .= CHtml::link($item->title_en, $item->getUrl(), ['target' => '_blank']) . "\n";
            Yii::app()->language = $lang;
        } elseif ($item instanceof Page || $item instanceof Post || $item instanceof Rubric || $item instanceof SpecialProject || $item instanceof GtbPost || $item instanceof GtbRubric || $item instanceof GtuPost || $item instanceof GtuRubric) {
            $data .= CHtml::link($item->title, $item->getUrl(), ['target' => '_blank']) . "\n";
        } elseif (in_array($assign->page_key, Style::getPageKeysWithItemsRange())) {
            $data .= "?\n";
        }
        return $data;
    }
}
