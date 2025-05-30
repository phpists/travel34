<?php

/**
 * This is the model class for table "{{test_question}}".
 *
 * The followings are the available columns in table '{{test_question}}':
 * @property integer $id
 * @property integer $test_widget_id
 * @property string $title
 * @property string $text
 * @property string $answer
 * @property integer $grid_variant
 * @property string $correct_answer_text
 * @property string $wrong_answer_text
 * @property integer $position
 * @property string $created_at
 * @property string $updated_at
 *
 * The followings are the available model relations:
 * @property TestWidget $testWidget
 * @property TestVariant[] $testVariants
 *
 * @method TestQuestion sorted()
 */
class TestQuestion extends TravelActiveRecord
{
    const GRID_USUAL = 0;
    const GRID_IMAGES_VERTICAL = 1;
    const GRID_IMAGES = 2;

    const IMAGES_PATH = 'media/widget';

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{test_question}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return [
            ['test_widget_id, grid_variant, position', 'numerical', 'integerOnly' => true],
            ['correct_answer_text, wrong_answer_text', 'length', 'max' => 255],
            ['title', 'length', 'max' => 255], // tinytext fields
            ['text, answer', 'safe'],
            ['created_at, updated_at', 'date', 'format' => 'yyyy-MM-dd hh:mm:ss'],
            ['created_at, updated_at', 'default', 'setOnEmpty' => true, 'value' => null],
            // The following rule is used by search().
            ['id, test_widget_id, title, position, created_at, updated_at', 'safe', 'on' => 'search'],
        ];
    }

    /**
     * Scopes conditions
     * @return array
     */
    public function scopes()
    {
        $tableAlias = $this->getTableAlias();
        return array_merge(parent::scopes(), [
            'sorted' => [
                'order' => $tableAlias . '.position, ' . $tableAlias . '.id',
            ],
        ]);
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return [
            'testWidget' => [self::BELONGS_TO, 'TestWidget', 'test_widget_id'],
            'testVariants' => [self::HAS_MANY, 'TestVariant', 'test_question_id'],
        ];
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'test_widget_id' => 'Test Widget',
            'title' => 'Заголовок',
            'text' => 'Текст',
            'answer' => 'Ответ',
            'grid_variant' => 'Вид вариантов',
            'correct_answer_text' => 'Текст «Верно»',
            'wrong_answer_text' => 'Текст «Неверно»',
            'position' => 'Положение',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @param int $test_widget_id
     * @return CActiveDataProvider
     */
    public function search($test_widget_id)
    {
        $criteria = new CDbCriteria();

        $criteria->compare('id', $this->id);
        $criteria->compare('test_widget_id', $test_widget_id);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('position', $this->position);
        $criteria->compare('created_at', $this->created_at, true);
        $criteria->compare('updated_at', $this->updated_at, true);

        return new CActiveDataProvider($this, [
            'criteria' => $criteria,
            'pagination' => [
                'pageSize' => self::PAGE_SIZE,
            ],
            'sort' => [
                'defaultOrder' => 'position ASC',
            ],
        ]);
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return TestQuestion the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return array
     */
    public static function getGridVariantOptions()
    {
        return [
            self::GRID_USUAL => 'Обычный',
            self::GRID_IMAGES_VERTICAL => 'С картинками вертикально',
            self::GRID_IMAGES => 'С картинками',
        ];
    }

    /**
     * @param int $question_id
     * @return TestVariant[]
     */
    public static function getVariantsByID($question_id)
    {
        $criteria = new CDbCriteria();
        $criteria->compare('test_question_id', $question_id);
        $criteria->order = 'position, id';
        $models = TestVariant::model()->findAll($criteria);
        return $models;
    }
}
