<?php

/**
 * @property integer $id
 * @property integer $user_id
 * @property integer $promo_code_id
 * @property integer $subscription_id
 * @property float $price_discount
 */
class UserPromoCodes extends TravelActiveRecord
{
    public function tableName()
    {
        return '{{user_promo_codes}}';
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
            ['user_id', 'numerical'],
            ['promo_code_id', 'numerical'],
            ['price_discount', 'numerical'],
            ['subscription_id', 'numerical', 'integerOnly' => true],
            ['subscription_id', 'numerical', 'integerOnly' => true],
            ['user_id, subscription_id', 'safe', 'on' => 'search'],
            ['id, user_id, subscription_id', 'numerical', 'integerOnly' => false],
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
            'promo_code_id' => 'Promo code id',
            'subscription_id' => 'Subscription id',
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
        $criteria->compare('promo_code_id', $this->id);
        $criteria->compare('subscription_id', $this->id);

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

    /**
     * Вирахувати ціну підписки з знижкою
     * @param $subscriptionId
     * @param $promoCode
     * @return float
     * @throws Exception
     */
    public static function getDiscount($subscriptionId, $promoCode)
    {
        $subscription = Subscription::model()->findByPk($subscriptionId);

        if (!$subscription) {
            throw new Exception('Subscription not found.');
        }

        $price = $subscription->price;
        $discount = isset($promoCode->discount) ? $promoCode->discount : 0;

        if ($discount < 0 || $discount > 100) {
            throw new Exception('Invalid discount value.');
        }

        $discountedPrice = $price - ($price * $discount / 100);

        return number_format($discountedPrice, 2);
    }

    /**
     * Ціна підписки з знижкою промокоду
     * @return array|mixed
     */
    public static function getSubscriptionDiscountPriceCookie()
    {
        $data = SubscriptionComponent::getSubscriptionCookie();

        if (isset($data['discount'])) {
            return number_format($data['discount'], 2);
        }
    }


}