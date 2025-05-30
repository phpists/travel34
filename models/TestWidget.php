<?php

/**
 * This is the model class for table "{{test_widget}}".
 *
 * The followings are the available columns in table '{{test_widget}}':
 * @property integer $id
 * @property integer $type
 * @property string $title
 * @property string $text
 * @property string $background_color
 * @property string $background_image
 * @property string $step2_background_color
 * @property string $step2_background_image
 * @property string $step3_background_color
 * @property string $step3_background_image
 * @property integer $has_border
 * @property string $border_color
 * @property string $step2_border_color
 * @property string $step3_border_color
 * @property string $step1_title_color
 * @property integer $step1_title_has_border
 * @property string $step1_title_border_color
 * @property string $step2_title_color
 * @property integer $step2_title_has_border
 * @property string $step2_title_border_color
 * @property string $step3_title_color
 * @property integer $step3_title_has_border
 * @property string $step3_title_border_color
 * @property string $step1_text_color
 * @property string $step2_text_color
 * @property string $step2_variants_text_color
 * @property string $step3_text_color
 * @property string $step1_button_text
 * @property string $step1_button_text_color
 * @property string $step1_button_color
 * @property string $step1_button_border_color
 * @property string $step1_button_shadow_color
 * @property string $step1_button_hover_color
 * @property string $step1_button_hover_shadow_color
 * @property string $step2_button_text
 * @property string $step2_button_text_color
 * @property string $step2_button_color
 * @property string $step2_button_border_color
 * @property string $step2_button_shadow_color
 * @property string $step2_button_hover_color
 * @property string $step2_button_hover_shadow_color
 * @property string $step3_button_text
 * @property string $step3_button_text_color
 * @property string $step3_button_color
 * @property string $step3_button_border_color
 * @property string $step3_button_shadow_color
 * @property string $step3_button_hover_color
 * @property string $step3_button_hover_shadow_color
 * @property string $correct_answer_color
 * @property string $wrong_answer_color
 * @property integer $has_top_branding
 * @property string $top_branding_image
 * @property string $top_branding_mobile_image
 * @property string $top_branding_url
 * @property integer $has_bottom_branding
 * @property string $bottom_branding_image
 * @property string $bottom_branding_mobile_image
 * @property string $bottom_branding_url
 * @property int $start_count
 * @property int $finish_count
 * @property string $created_at
 * @property string $updated_at
 * @property bool $delete_background_image
 * @property bool $delete_step2_background_image
 * @property bool $delete_step3_background_image
 *
 * The followings are the available model relations:
 * @property TestQuestion[] $testQuestions
 * @property TestResult[] $testResults
 */
class TestWidget extends TravelActiveRecord
{
    const TYPE_MANY = 0;
    const TYPE_ONE = 1;

    const IMAGES_PATH = 'media/widget';

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{test_widget}}';
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['uploadBgImage'] = [
            'class' => 'application.behaviors.UploadFileBehavior',
            'attrName' => 'background_image',
            'attrDelete' => 'delete_background_image',
            'savePath' => self::IMAGES_PATH,
        ];
        $behaviors['uploadStep2BgImage'] = [
            'class' => 'application.behaviors.UploadFileBehavior',
            'attrName' => 'step2_background_image',
            'attrDelete' => 'delete_step2_background_image',
            'savePath' => self::IMAGES_PATH,
        ];
        $behaviors['uploadStep3BgImage'] = [
            'class' => 'application.behaviors.UploadFileBehavior',
            'attrName' => 'step3_background_image',
            'attrDelete' => 'delete_step3_background_image',
            'savePath' => self::IMAGES_PATH,
        ];
        $behaviors['uploadTopBrandingImage'] = [
            'class' => 'application.behaviors.UploadFileBehavior',
            'attrName' => 'top_branding_image',
            'savePath' => self::IMAGES_PATH,
        ];
        $behaviors['uploadTopBrandingMobileImage'] = [
            'class' => 'application.behaviors.UploadFileBehavior',
            'attrName' => 'top_branding_mobile_image',
            'savePath' => self::IMAGES_PATH,
        ];
        $behaviors['uploadBottomBrandingImage'] = [
            'class' => 'application.behaviors.UploadFileBehavior',
            'attrName' => 'bottom_branding_image',
            'savePath' => self::IMAGES_PATH,
        ];
        $behaviors['uploadBottomBrandingMobileImage'] = [
            'class' => 'application.behaviors.UploadFileBehavior',
            'attrName' => 'bottom_branding_mobile_image',
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
            [
                'type, has_border, step1_title_has_border, step2_title_has_border, step3_title_has_border, has_top_branding, has_bottom_branding, start_count, finish_count',
                'numerical', 'integerOnly' => true,
            ],
            [
                'background_color, step2_background_color, step3_background_color, border_color, step2_border_color, step3_border_color, ' .
                'step1_title_color, step1_title_border_color, step2_title_color, step2_title_border_color, step3_title_color, step3_title_border_color, ' .
                'step1_text_color, step2_text_color, step2_variants_text_color, step3_text_color, step1_button_text_color, step2_button_text_color, step3_button_text_color, ' .
                'step1_button_color, step1_button_border_color, step1_button_shadow_color, step1_button_hover_color, step1_button_hover_shadow_color, ' .
                'step2_button_color, step2_button_border_color, step2_button_shadow_color, step2_button_hover_color, step2_button_hover_shadow_color, ' .
                'step3_button_color, step3_button_border_color, step3_button_shadow_color, step3_button_hover_color, step3_button_hover_shadow_color,' .
                'correct_answer_color, wrong_answer_color',
                'length', 'max' => 6,
            ],
            [
                'background_color, step2_background_color, step3_background_color, border_color, step2_border_color, step3_border_color, ' .
                'step1_title_color, step1_title_border_color, step2_title_color, step2_title_border_color, step3_title_color, step3_title_border_color, ' .
                'step1_text_color, step2_text_color, step2_variants_text_color, step3_text_color, step1_button_text_color, step2_button_text_color, step3_button_text_color, ' .
                'step1_button_color, step1_button_border_color, step1_button_shadow_color, step1_button_hover_color, step1_button_hover_shadow_color, ' .
                'step2_button_color, step2_button_border_color, step2_button_shadow_color, step2_button_hover_color, step2_button_hover_shadow_color, ' .
                'step3_button_color, step3_button_border_color, step3_button_shadow_color, step3_button_hover_color, step3_button_hover_shadow_color,' .
                'correct_answer_color, wrong_answer_color',
                'checkColor',
            ],
            [
                'background_image, step2_background_image, step3_background_image, step1_button_text, step2_button_text, step3_button_text, ' .
                'top_branding_image, top_branding_mobile_image, top_branding_url, bottom_branding_image, bottom_branding_mobile_image, bottom_branding_url',
                'length', 'max' => 255,
            ],
            ['title', 'length', 'max' => 255], // tinytext fields
            ['text', 'safe'],
            ['created_at, updated_at', 'date', 'format' => 'yyyy-MM-dd hh:mm:ss'],
            ['created_at, updated_at', 'default', 'setOnEmpty' => true, 'value' => null],
            // The following rule is used by search().
            ['id, type, title, created_at, updated_at', 'safe', 'on' => 'search'],
        ];
    }

    /**
     * @param string $attribute
     */
    public function checkColor($attribute)
    {
        if (!empty($this->$attribute) && !preg_match('/^([0-9a-f]{3}|[0-9a-f]{6})$/', $this->$attribute)) {
            $this->addError($attribute, '«' . $this->getAttributeLabel($attribute) . '» указан неверно');
        }
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return [
            'testQuestions' => [self::HAS_MANY, 'TestQuestion', 'test_widget_id'],
            'testResults' => [self::HAS_MANY, 'TestResult', 'test_widget_id'],
        ];
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Тип',
            'title' => 'Заголовок',
            'text' => 'Текст',
            'background_color' => 'Цвет фона',
            'background_image' => 'Изображение фона',
            'step2_background_color' => 'Цвет фона шага 2',
            'step2_background_image' => 'Изображение фона шага 2',
            'step3_background_color' => 'Цвет фона шага 3',
            'step3_background_image' => 'Изображение фона шага 3',
            'has_border' => 'Рамка',
            'border_color' => 'Цвет рамки',
            'step2_border_color' => 'Цвет рамки шага 2',
            'step3_border_color' => 'Цвет рамки шага 3',
            'step1_title_color' => 'Цвет заголовка шага 1',
            'step1_title_has_border' => 'Подчеркивание заголовка шага 1',
            'step1_title_border_color' => 'Цвет подчеркивания заголовка шага 1',
            'step2_title_color' => 'Цвет заголовка шага 2',
            'step2_title_has_border' => 'Подчеркивание заголовка шага 2',
            'step2_title_border_color' => 'Цвет подчеркивания заголовка шага 2',
            'step3_title_color' => 'Цвет заголовка шага 3',
            'step3_title_has_border' => 'Подчеркивание заголовка шага 3',
            'step3_title_border_color' => 'Цвет подчеркивания заголовка шага 3',
            'step1_text_color' => 'Цвет текста шага 1',
            'step2_text_color' => 'Цвет текста шага 2',
            'step2_variants_text_color' => 'Цвет текста вариантов ответов',
            'step3_text_color' => 'Цвет текста шага 3',
            'step1_button_text' => 'Текст кнопки шага 1',
            'step1_button_text_color' => 'Цвет текста кнопки шага 1',
            'step1_button_color' => 'Цвет фона кнопки шага 1',
            'step1_button_border_color' => 'Цвет рамки кнопки шага 1',
            'step1_button_shadow_color' => 'Цвет тени кнопки шага 1',
            'step1_button_hover_color' => 'Цвет фона кнопки шага 1 при наведении',
            'step1_button_hover_shadow_color' => 'Цвет тени кнопки шага 1 при наведении',
            'step2_button_text' => 'Текст кнопки шага 2',
            'step2_button_text_color' => 'Цвет текста кнопки шага 2',
            'step2_button_color' => 'Цвет фона кнопки шага 2',
            'step2_button_border_color' => 'Цвет рамки кнопки шага 2',
            'step2_button_shadow_color' => 'Цвет тени кнопки шага 2',
            'step2_button_hover_color' => 'Цвет фона кнопки шага 2 при наведении',
            'step2_button_hover_shadow_color' => 'Цвет тени кнопки шага 2 при наведении',
            'step3_button_text' => 'Текст кнопки шага 3',
            'step3_button_text_color' => 'Цвет текста кнопки шага 3',
            'step3_button_color' => 'Цвет фона кнопки шага 3',
            'step3_button_border_color' => 'Цвет рамки кнопки шага 3',
            'step3_button_shadow_color' => 'Цвет тени кнопки шага 3',
            'step3_button_hover_color' => 'Цвет фона кнопки шага 3 при наведении',
            'step3_button_hover_shadow_color' => 'Цвет тени кнопки шага 3 при наведении',
            'correct_answer_color' => 'Цвет правильного ответа',
            'wrong_answer_color' => 'Цвет неправильного ответа',
            'has_top_branding' => 'Верхнее брендирование',
            'top_branding_image' => 'Изображение верхнего брендирования',
            'top_branding_mobile_image' => 'Мобильное изображение верхнего брендирования',
            'top_branding_url' => 'URL верхнего брендирования',
            'has_bottom_branding' => 'Нижнее брендирование',
            'bottom_branding_image' => 'Изображение нижнего брендирования',
            'bottom_branding_mobile_image' => 'Мобильное изображение нижнего брендирования',
            'bottom_branding_url' => 'URL нижнего брендирования',
            'start_count' => 'Количество начавших',
            'finish_count' => 'Количество закончивших',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'delete_background_image' => 'Удалить изображение фона',
            'delete_step2_background_image' => 'Удалить изображение фона шага 2',
            'delete_step3_background_image' => 'Удалить изображение фона шага 3',
        ];
    }

    /**
     * @return CActiveDataProvider
     */
    public function search()
    {
        $criteria = new CDbCriteria();

        $criteria->compare('id', $this->id);
        $criteria->compare('type', $this->type);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('start_count', $this->start_count);
        $criteria->compare('finish_count', $this->finish_count);
        $criteria->compare('created_at', $this->created_at, true);
        $criteria->compare('updated_at', $this->updated_at, true);

        return new CActiveDataProvider($this, [
            'criteria' => $criteria,
            'pagination' => [
                'pageSize' => self::PAGE_SIZE,
            ],
            'sort' => [
                'defaultOrder' => 'id ASC',
            ],
        ]);
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return TestWidget the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return array
     */
    public static function getTypeOptions()
    {
        return [
            self::TYPE_MANY => 'Большинство ответов',
            self::TYPE_ONE => 'Правильный / неправильный',
        ];
    }

    private $_allVariants;

    /**
     * @return array
     */
    public function getAllVariants()
    {
        if ($this->_allVariants !== null) {
            return $this->_allVariants;
        }
        $this->_allVariants = [];
        if ($this->type == TestWidget::TYPE_MANY) {
            $questions = $this->testQuestions;
            $array = [];
            foreach ($questions as $question) {
                $q = [
                    'title' => $question->title,
                ];
                $variants = $question->testVariants;
                if (!empty($variants)) {
                    foreach ($variants as $variant) {
                        $q['variants'][$variant->id] = $variant->text;
                    }
                }
                $array[$question->id] = $q;
            }
            $this->_allVariants = $array;
        }
        return $this->_allVariants;
    }
}
