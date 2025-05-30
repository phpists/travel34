<?php

/**
 * This is the model class for table "{{test_variant}}".
 *
 * The followings are the available columns in table '{{test_variant}}':
 * @property integer $id
 * @property integer $test_question_id
 * @property string $text
 * @property string $image
 * @property integer $is_correct
 * @property integer $position
 * @property string $created_at
 * @property string $updated_at
 * @property bool $delete_image
 *
 * The followings are the available model relations:
 * @property TestQuestion $testQuestion
 *
 * @method TestVariant sorted()
 */
class TestVariant extends TravelActiveRecord
{
    const IMAGES_PATH = 'media/widget';

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{test_variant}}';
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['uploadImage'] = [
            'class' => 'application.behaviors.UploadFileBehavior',
            'attrName' => 'image',
            'attrDelete' => 'delete_image',
            'savePath' => self::IMAGES_PATH,
        ];
        return $behaviors;
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return [
            ['test_question_id, is_correct, position', 'numerical', 'integerOnly' => true],
            ['image', 'length', 'max' => 255],
            ['text', 'length', 'max' => 255], // tinytext fields
            ['created_at, updated_at', 'date', 'format' => 'yyyy-MM-dd hh:mm:ss'],
            ['created_at, updated_at', 'default', 'setOnEmpty' => true, 'value' => null],
            ['is_correct', 'checkUniqCorrectVariant'],
            // The following rule is used by search().
            ['id, test_question_id, text, is_correct, position, created_at, updated_at', 'safe', 'on' => 'search'],
        ];
    }

    /**
     * @param string $attribute
     */
    public function checkUniqCorrectVariant($attribute)
    {
        if ("{$this->$attribute}" === '1') {
            if ($this->isNewRecord) {
                $model = self::model()->findByAttributes(['test_question_id' => $this->test_question_id, 'is_correct' => 1]);
            } else {
                $model = self::model()->findByAttributes(['test_question_id' => $this->test_question_id, 'is_correct' => 1], 'id != :id', [':id' => $this->id]);
            }
            if ($model !== null) {
                $this->addError($attribute, 'Правильный вариант уже выбран');
            }
        }
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
            'testQuestion' => [self::BELONGS_TO, 'TestQuestion', 'test_question_id'],
        ];
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'test_question_id' => 'Test Question',
            'text' => 'Текст',
            'image' => 'Изображение',
            'is_correct' => 'Правильный ответ',
            'position' => 'Положение',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'delete_image' => 'Удалить изображение',
        ];
    }

    /**
     * @return CActiveDataProvider
     */
    public function search()
    {
        $criteria = new CDbCriteria();

        $criteria->compare('id', $this->id);
        $criteria->compare('test_question_id', $this->test_question_id);
        $criteria->compare('text', $this->text, true);
        $criteria->compare('is_correct', $this->is_correct);
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
     * @return TestVariant the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
