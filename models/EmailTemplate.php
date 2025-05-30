<?php

/**
 * This is the model class for table "{{email_template}}".
 *
 * The followings are the available columns in table '{{email_template}}':
 * @property integer $id
 * @property string $subject
 * @property string $description
 * @property string $created_at
 * @property string $updated_at
 *
 * @method EmailTemplate enabled()
 */
class EmailTemplate extends TravelActiveRecord
{
    /**
     * @return string
     */

    const WELCOME_EMAIL = 1;
    const REGISTER_CONFIRM_EMAIL = 2;
    const FORGOT_PASSWORD_SUCCESS_EMAIL = 3;
    const FORGOT_PASSWORD_CONFIRM_EMAIL = 4;
    const USER_SUBSCRIPTION_EMAIL = 5;
    const PARENT_SUBSCRIPTION_GIFT = 6; //Подписка в подарок (дарителю)
    const CLIENT_SUBSCRIPTION_GIFT = 7; //Подписка в подарок (получателю)
    const CANCEL_SUBSCRIPTION = 8; //Отмена подписки
    const ACCOUNT_DELETE = 9; //Удаление аккаунта
    const ONBORDING_EMAIL = 10; // Onebording
    const FAILED_PAYMENT = 11; // Failed payment
    const FINAL_FAILED_PAYMENT = 12; // Final failed payment
    const NEXT_WRITE_OFF_MONTH = 13; // Предупреждение о следующем списании / Місяць
    const NEXT_WRITE_OFF_YEAR = 14; // Предупреждение о следующем списании / Рік
    const CONFIRMATION_WRITE_OFF_CHECK = 15; // Подтверждение нового списания с чеком

    public function tableName()
    {
        return '{{email_template}}';
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
            ['subject', 'length', 'max' => 255],
            ['description', 'safe'],
            ['created_at, updated_at', 'date', 'format' => 'yyyy-MM-dd hh:mm:ss'],
            ['created_at, updated_at', 'default', 'setOnEmpty' => true, 'value' => null],
            ['id, subject, description, created_at, updated_at', 'safe', 'on' => 'search'],
        ];
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'subject' => Yii::t('app', 'Тема'),
            'description' => Yii::t('app', 'Сообщение'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
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
        $criteria->compare('subject', $this->subject, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('created_at', $this->created_at, true);
        $criteria->compare('updated_at', $this->updated_at, true);

        return new CActiveDataProvider($this, [
            'criteria' => $criteria,
            'pagination' => [
                'pageSize' => self::PAGE_SIZE,
            ],
            'sort' => [
                'defaultOrder' => 'subject',
            ],
        ]);
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Block the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }


    public static function getEmailTemplate($templateId)
    {
        $template = EmailTemplate::model()->findByAttributes(['id' => $templateId]);

        return $template;
    }
}