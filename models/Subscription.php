<?php

/**
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property float $price
 * @property float $old_price
 * @property integer $status_id
 * @property integer $position
 * @property string $product_id
 * @property integer $month
 */
class Subscription extends TravelActiveRecord
{
    /**
     * Subscription
     */
    const FOR_YEAR = 3;
    const FAMILY = 4;

    /**
     * Status
     */
    const ENABLED = 1;
    const DISABLED = 0;

    /**
     * Type
     */
    const MYSELF = 1; // Подписка для себя
    const GIFT = 2; // Подписка в подарок

    /**
     * Type Gift
     */
    const REGISTER = 1; // Войти или зарегистрироваться
    const GUEST = 2; // Гостевой доступ

    /**
     * @return string
     */
    public function tableName()
    {
        return '{{subscription}}';
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
            ['title', 'required'],
            ['description', 'required'],
            ['title, description', 'safe', 'on' => 'search'],
            ['price, old_price, position, status_id, product_id, month', 'numerical', 'integerOnly' => false],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Id',
            'title' => 'Название',
            'description' => 'Описание',
            'price' => 'Цена',
            'old_price' => 'Старая цена',
            'status_id' => 'Статус',
            'product_id' => 'Product',
            'month' => 'Month'
        ];
    }

    /**
     * @return CActiveDataProvider
     */
    public function search()
    {
        $criteria = new CDbCriteria();

        $criteria->compare('id', $this->id);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('description', $this->description, true);

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
     * @param string $className
     * @return SeoTag
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * Subscriptions
     */
    public static function getSubscriptions()
    {
        $subscriptions = Subscription::model()->findAll([
            'condition' => 'status_id = :status_id',
            'params' => [
                ':status_id' => 1,
            ],
        ]);

        return $subscriptions;
    }

    /**
     * Створення дати початку та тати кінця підписки
     * @param null $dateStart
     * @param null $endDate
     * @return array
     */
    public function getSubscriptionDates($dateStart = null, $endDate = null)
    {
        $months = $this->month;

        /**
         * TODO: це потрібно прибрати з умови
         */
        if ($this->id == 5) {
            if ($dateStart && $endDate) {
                $newDateEnd = $endDate . ' +1 days';
                $dateStart = date('Y-m-d H:i:s', strtotime($newDateEnd));
                $endDate = date('Y-m-d H:i:s', strtotime($dateStart . " +2 days"));
            } else {
                $dateStart = date('Y-m-d H:i:s');
                $endDate = date('Y-m-d H:i:s', strtotime("+2 days"));
            }
        } else {
            if ($dateStart && $endDate) {
                $newDateEnd = $endDate . ' +1 day';
                $dateStart = date('Y-m-d H:i:s', strtotime($newDateEnd));
                $endDate = date('Y-m-d H:i:s', strtotime($dateStart . "+$months month"));
            } else {
                $dateStart = date('Y-m-d H:i:s');
                $endDate = date('Y-m-d H:i:s', strtotime("+$months month"));
            }
        }

        return [
            'date_start' => $dateStart,
            'date_end' => $endDate,
        ];
    }

    /**
     * Встановлення дати початку та дати кінця підписки.
     * @param $dateStart
     * @return array
     */
    public function getGiftSubscriptionDates($dateStart)
    {
        $months = $this->month;

        $dateStart = date('Y-m-d H:i:s', strtotime($dateStart));
        $endDate = date('Y-m-d H:i:s', strtotime("+$months month", strtotime($dateStart)));

        return [
            'date_start' => $dateStart,
            'date_end' => $endDate,
        ];
    }


    /**
     * Clear Subscription Cookies
     */
    public static function clearSubscriptionCookies()
    {
        $cookies = Yii::app()->request->cookies;
        unset($cookies['subscription']);
    }

    public static function getDateFormat($date)
    {
        $dateTime = new DateTime($date);

        $months = [
            1 => 'января',
            2 => 'февраля',
            3 => 'марта',
            4 => 'апреля',
            5 => 'мая',
            6 => 'июня',
            7 => 'июля',
            8 => 'августа',
            9 => 'сентября',
            10 => 'октября',
            11 => 'ноября',
            12 => 'декабря'
        ];

        $day = $dateTime->format('j');
        $month = $months[(int)$dateTime->format('n')];
        $year = $dateTime->format('Y');

        return [
            'day' => $day,
            'month' => $month,
            'year' => $year
        ];
    }

    public static function getSubscriptionStartDate($date = null)
    {
        $data = SubscriptionComponent::getSubscriptionCookie();

        if (isset($data['gift_date'])) {
            $date = $data['gift_date'];
        }

        if (empty($date)) {
            $existingSubscription = UserSubscription::model()->findByAttributes([
                'user_id' => Yii::app()->userComponent->getUserId(),
                'status_id' => UserSubscription::SUCCESS,
            ], [
                'order' => 'id DESC'
            ]);

            if ($existingSubscription) {
                $subscription = Subscription::model()->findByPk($data['subscription']);
                $subscriptionDate = $subscription->getSubscriptionDates($existingSubscription['date_start'], $existingSubscription['date_end']);

                $date = $subscriptionDate['date_start'];
            } else {
                $date = date('Y-m-d');
            }
        }

        $dateFormat = self::getDateFormat($date);


        return "{$dateFormat['day']} {$dateFormat['month']} {$dateFormat['year']}";
    }

    /**
     * Отримати ціну підписки з перевіркою на наявність знижки промокоду
     * @param $amount
     * @return float|int
     */
    public static function getSubscriptionPrice($amount)
    {
        $promoDiscountPrice = UserPromoCodes::getSubscriptionDiscountPriceCookie();
        if (isset($promoDiscountPrice)) {
            $amount = $promoDiscountPrice * 100;
        } else {
            $amount = $amount * 100;
        }

        return $amount;
    }

    public static function getTimes()
    {
        return [
            "00:00", "01:00", "02:00", "03:00", "04:00", "05:00",
            "06:00", "07:00", "08:00", "09:00", "10:00", "11:00",
            "12:00", "13:00", "14:00", "15:00", "16:00", "17:00",
            "18:00", "19:00", "20:00", "21:00", "22:00", "23:00", "23:59",
        ];
    }
}