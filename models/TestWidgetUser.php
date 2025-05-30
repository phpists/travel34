<?php

/**
 * This is the model class for table "{{test_widget_user}}".
 *
 * The followings are the available columns in table '{{test_widget_user}}':
 * @property int $id
 * @property string $user_id
 * @property int $test_widget_id
 * @property int $test_result_id
 * @property string $ip
 * @property string $user_agent
 * @property string $browser
 * @property string $country
 * @property int $started_at
 * @property int $finished_at
 *
 * The followings are the available model relations:
 * @property TestWidget $testWidget
 * @property TestResult $testResult
 */
class TestWidgetUser extends TravelActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{test_widget_user}}';
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'CAdvancedArFindBehavior' => [
                'class' => 'application.behaviors.CAdvancedArFindBehavior',
            ],
            'CAdvancedArBehavior' => [
                'class' => 'application.behaviors.CAdvancedArBehavior',
            ],
        ];
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return [
            ['user_id, test_widget_id', 'required'],
            ['test_widget_id, test_result_id, started_at, finished_at', 'numerical', 'integerOnly' => true],
            ['user_id', 'length', 'max' => 100],
            ['ip, browser, country', 'length', 'max' => 255],
            ['user_agent', 'safe'],
            // The following rule is used by search().
            ['id, user_id, test_widget_id, test_result_id, ip, user_agent, browser, country, started_at, finished_at', 'safe', 'on' => 'search'],
        ];
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return [
            'testWidget' => [self::BELONGS_TO, 'TestWidget', 'test_widget_id'],
            'testResult' => [self::BELONGS_TO, 'TestResult', 'test_result_id'],
        ];
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User',
            'test_widget_id' => 'Виджет',
            'test_result_id' => 'Результат',
            'ip' => 'IP',
            'user_agent' => 'User Agent',
            'browser' => 'Браузер',
            'country' => 'Страна',
            'started_at' => 'Начат',
            'finished_at' => 'Окончен',
        ];
    }

    /**
     * @return CActiveDataProvider
     */
    public function search()
    {
        $criteria = new CDbCriteria();

        $criteria->compare('id', $this->id);
        $criteria->compare('user_id', $this->user_id, true);
        $criteria->compare('test_widget_id', $this->test_widget_id);
        $criteria->compare('test_result_id', $this->test_result_id);
        $criteria->compare('ip', $this->ip, true);
        $criteria->compare('user_agent', $this->user_agent, true);
        $criteria->compare('browser', $this->browser, true);
        $criteria->compare('country', $this->country, true);
        //$criteria->compare('started_at', $this->started_at);
        //$criteria->compare('finished_at', $this->finished_at);

        return new CActiveDataProvider($this, [
            'criteria' => $criteria,
            'pagination' => [
                'pageSize' => self::PAGE_SIZE,
            ],
            'sort' => [
                'defaultOrder' => 'id DESC',
            ],
        ]);
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return TestWidgetUser the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
