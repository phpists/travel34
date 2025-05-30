<?php

/**
 * This is the model class for table "{{test_result}}".
 *
 * The followings are the available columns in table '{{test_result}}':
 * @property integer $id
 * @property integer $test_widget_id
 * @property string $title
 * @property string $text
 * @property string $variants
 * @property integer $correct_count
 * @property string $created_at
 * @property string $updated_at
 *
 * The followings are the available model relations:
 * @property TestWidget $testWidget
 */
class TestResult extends TravelActiveRecord
{
    const CORRECT_5 = 4;
    const CORRECT_4 = 3;
    const CORRECT_3 = 2;
    const CORRECT_2 = 1;
    const CORRECT_1 = 0;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{test_result}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return [
            ['test_widget_id, correct_count', 'numerical', 'integerOnly' => true],
            ['text, variants', 'safe'],
            ['title', 'length', 'max' => 255], // tinytext fields
            ['created_at, updated_at', 'date', 'format' => 'yyyy-MM-dd hh:mm:ss'],
            ['created_at, updated_at', 'default', 'setOnEmpty' => true, 'value' => null],
            ['correct_count', 'checkUniqCorrectCount'],
            // The following rule is used by search().
            [
                'id, test_widget_id, title, text, variants, correct_count, created_at, updated_at', 'safe',
                'on' => 'search',
            ],
        ];
    }

    /**
     * @param string $attribute
     */
    public function checkUniqCorrectCount($attribute)
    {
        if ($this->test_widget_id > 0) {
            $parent = TestWidget::model()->findByPk($this->test_widget_id);
            if ($parent->type == TestWidget::TYPE_ONE) {
                if ($this->isNewRecord) {
                    $model = self::model()->findByAttributes(['test_widget_id' => $this->test_widget_id, 'correct_count' => $this->correct_count]);
                } else {
                    $model = self::model()->findByAttributes(['test_widget_id' => $this->test_widget_id, 'correct_count' => $this->correct_count], 'id != :id', [':id' => $this->id]);
                }
                if ($model !== null) {
                    $this->addError($attribute, 'Диапазон уже выбран');
                }
            }
        }
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return [
            'testWidget' => [self::BELONGS_TO, 'TestWidget', 'test_widget_id'],
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
            'variants' => 'Варианты',
            'correct_count' => 'Диапазон правильных ответов',
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
        $criteria->compare('text', $this->text, true);
        $criteria->compare('variants', $this->variants, true);
        $criteria->compare('correct_count', $this->correct_count);
        $criteria->compare('created_at', $this->created_at, true);
        $criteria->compare('updated_at', $this->updated_at, true);

        return new CActiveDataProvider($this, [
            'criteria' => $criteria,
        ]);
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return TestResult the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * {@inheritdoc}
     */
    protected function beforeSave()
    {
        if (is_array($this->variants)) {
            $this->variants = json_encode($this->variants);
        }

        return parent::beforeSave();
    }

    /**
     * {@inheritdoc}
     */
    protected function afterFind()
    {
        parent::afterFind();

        if (!empty($this->variants)) {
            $this->variants = (array)@json_decode($this->variants, true);
        }
    }

    /**
     * @return array
     */
    public static function getCorrectCountValues()
    {
        return [
            self::CORRECT_5 => '100%',
            self::CORRECT_4 => '80-99%',
            self::CORRECT_3 => '50-79%',
            self::CORRECT_2 => '30-49%',
            self::CORRECT_1 => '0-29%',
        ];
    }
}
