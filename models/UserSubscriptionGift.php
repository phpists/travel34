<?php

/**
 * @property integer $id
 * @property integer $user_id
 * @property integer $user_subscription_id
 * @property string $user_email
 * @property string $gift_email
 * @property string $gift_date
 * @property string $gift_time
 * @property int $status_id
 * @property int $type_id
 * @property string $code
 * @property string $expiry_date
 * @property string $date_create
 * @property int $number_activations
 * @property int $available_activations
 * @property string $created_at
 * @property string $updated_at
 */
class UserSubscriptionGift extends TravelActiveRecord
{
    /**
     * Status id
     */
    const INACTIVE = 0; // Не активна
    const ACTIVE = 1; // Активна
    const SEND_CLIENT = 2; // Відправлена клієнту
    const SUSPENDED = 3; // Приостановлен
    const USED = 4; // Использован,

    /**
     * @return string
     */
    public function tableName()
    {
        return '{{user_subscription_gift}}';
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
            ['status_id', 'numerical', 'integerOnly' => true],
            ['type_id', 'required'],
            ['available_activations', 'length', 'max' => 255],
            ['number_activations', 'length', 'max' => 255],
            ['user_subscription_id', 'default', 'setOnEmpty' => true, 'value' => null],
            ['user_email', 'default'],
            ['gift_email', 'required'],
            ['expiry_date', 'default'],
            ['gift_date', 'required'],
            ['gift_time', 'required'],
            ['user_id, user_email, gift_email', 'safe', 'on' => 'search'],
            ['date_create, created_at, updated_at', 'date', 'format' => 'yyyy-MM-dd hh:mm:ss'],
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
            'user_subscription_id' => 'User subscription id',
            'user_email' => 'Email дарителя ',
            'gift_email' => 'Email получателя подарка',
            'gift_date' => 'Gift date',
            'gift_time' => 'Gift time',
            'status_id' => 'Статус',
            'type_id' => 'Тип подписки',
            'code' => 'Промокод',
            'expiry_date' => 'Cрок действия',
            'number_activations' => 'Количество активаций',
            'available_activations' => 'Доступные активации',
            'date_create' => 'Дата создания промокода',
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

    public static function isSubscriptionGift()
    {
        $user = Yii::app()->userComponent->getUser();
        $statusIds = [UserSubscriptionGift::SEND_CLIENT, UserSubscriptionGift::INACTIVE];
        $userSubscriptionGift = UserSubscriptionGift::model()->find(
            'gift_date <= :gift_date AND gift_time <= :gift_time AND gift_email = :gift_email AND status_id IN (' . implode(',', $statusIds) . ')',
            [
                ':gift_date' => date('Y-m-d'),
                ':gift_time' => date('H:i:00'),
                ':gift_email' => $user->email,
            ]
        );

        if (empty($userSubscriptionGift['user_subscription_id'])){
            return [
                'status' => false,
            ];
        }

        return [
            'status' => true,
            'url' => Yii::app()->createUrl('profile/subscriptionActivate', [
                'id' => $userSubscriptionGift['user_subscription_id'],
                'gift_id' => $userSubscriptionGift['id']
            ]),
        ];
    }

    public static function getStatuses()
    {
        return [
            self::ACTIVE => 'Активный',
            self::SUSPENDED => 'Приостановлен',
            self::USED => 'Использован',
        ];
    }

    public function getStatus()
    {
        $statuses = self::getStatuses();
        return $statuses[$this->status_id];
    }

    public static function addYearToToday()
    {
        $currentDateTime = new DateTime();
        $currentDateTime->modify('+1 year');
        return $currentDateTime->format('Y-m-d H:i:s');
    }

    public static function getTypesId($data)
    {
        $subscriptions = Subscription::model()->findAllByPk($data['type_id']);
        if (!$subscriptions) {
            return '';
        }

        $titles = array_map(function ($subscription) {
            return $subscription->title;
        }, $subscriptions);

        return implode(', ', $titles);
    }

    public function generatePromocode()
    {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $length = 6;
        $promocode = '';

        for ($i = 0; $i < $length; $i++) {
            $promocode .= $characters[random_int(0, strlen($characters) - 1)];
        }

        return $promocode;
    }

    public static function encryptId($id) {
        $key = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $data = $id . '|' . hash_hmac('sha256', $id, $key);
        return base64_encode($data);
    }

    public static function decryptId($encryptedId) {
        $key = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $decoded = base64_decode($encryptedId);

        if (!$decoded) {
            return null;
        }

        list($id, $hash) = explode('|', $decoded, 2);

        if (hash_hmac('sha256', $id, $key) !== $hash) {
            return null;
        }

        return $id;
    }


}