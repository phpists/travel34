<?php

/**
 * @property integer $id
 * @property integer $user_id
 * @property integer $subscription_id
 * @property integer $customer_id
 * @property integer $payment_intent
 * @property integer $payment_method_id
 * @property string $subscription_code
 * @property integer $status_id
 * @property integer $subscription_type
 * @property string $date_start
 * @property string $date_end
 * @property integer $position
 * @property integer $is_active
 * @property integer $is_auto_renewal
 * @property string $created_at
 * @property string $updated_at
 */
class UserSubscription extends TravelActiveRecord
{
    /**
     * Status id
     */
    const NEW = 1; // Нова підписки
    const SUCCESS = 2; // Успішно сплачена
    const ERROR = 3; // Відхилена
    const CANCELED = 4; // Отменена
    const DONATED = 5; // Подарована підписка

    /**
     * Active status
     */
    const INACTIVE = 0; // Не активна підписка
    const ACTIVE = 1; // Активна підписка
    const EXPIRED = 2; // Срок истек.

    /**
     * Subscription type
     */
    const MYSELF = 1; // Подписка для себя
    const GIFT = 2; // Подписка в подарок

    /**
     * Is auto_renewal (автопродление) true/false
     */


    /**
     * @return string
     */
    public function tableName()
    {
        return '{{user_subscription}}';
    }

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

    public function relations()
    {
        return [
            'subscription' => [self::BELONGS_TO, 'Subscription', 'subscription_id'],
        ];
    }

    public function scopes()
    {
        return [];
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            ['user_id', 'numerical', 'integerOnly' => true],
            ['subscription_id', 'numerical', 'integerOnly' => true],
            ['subscription_type', 'numerical', 'integerOnly' => true],
            ['customer_id, payment_intent, payment_method_id', 'length', 'max' => 255],
            ['user_id, subscription_id', 'safe', 'on' => 'search'],
            ['id, user_id, subscription_id, position, is_active, is_auto_renewal', 'numerical', 'integerOnly' => false],
            ['created_at, updated_at', 'date', 'format' => 'yyyy-MM-dd hh:mm:ss'],
            ['created_at, updated_at', 'default', 'setOnEmpty' => true, 'value' => null],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Id',
            'user_id' => 'User id',
            'subscription_id' => 'Subscription id',
            'customer_id' => 'Customer id',
            'payment_intent' => 'Payment Intent',
            'payment_method_id' => 'Payment method id',
            'subscription_code' => 'Subscription code',
            'status_id' => 'Status',
            'subscription_type' => 'Subscription type', // Тип підписки 1 - для себе, 2 - в подарунок
            'date_start' => 'Date start',
            'date_end' => 'Date end',
            'position' => 'Position',
            'is_active' => 'Active',
            'is_auto_renewal' => 'Active',
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
        $criteria->compare('user_id', $this->id);
        $criteria->compare('subscription_id', $this->id);
        $criteria->compare('created_at', $this->created_at, true);
        $criteria->compare('updated_at', $this->updated_at, true);

        return new CActiveDataProvider($this, [
            'criteria' => $criteria,
            'sort' => [
                'defaultOrder' => 't.id DESC',
            ],
            'pagination' => [
                'pageSize' => self::PAGE_SIZE,
            ],
        ]);
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Proposal the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function getDateStart()
    {
        setlocale(LC_TIME, 'ru_RU.UTF-8');
        return strftime('%e %B %Y', strtotime($this->date_start));
    }

    public function getStatus()
    {
        $status = '';
        switch ($this->is_active) {
            case self::ACTIVE:
                $status = "Активна";
                break;
            case self::INACTIVE:
                $status = "Активируется после окончания предыдущей";
                break;
            case self::EXPIRED:
                $status = "Срок истек";
                break;
            case self::CANCELED:
                $status = "Отменена";
                break;
        }

        return $status;
    }

    public function getSubscriptionStatus()
    {
        $today = strtotime(date('Y-m-d H:i:s'));
        $dateStart = strtotime($this->date_start);
        $dateEnd = strtotime($this->date_end);

        if ($this->status_id == 2 && $this->is_active == 1){
            return "Активна";
        }

        if ($this->status_id == 2 && $this->is_active == 4){
            return "Отменена";
        }

        if ($dateStart >= $today && $dateEnd >= $today) {
            return "Активируется после окончания предыдущей";
        }

        return "Срок истек";
    }
}