<?php

/**
 * @property integer $id
 * @property string $promo_code
 * @property integer $status_id
 * @property string $date_create
 * @property integer $type_id
 * @property integer $discount
 * @property integer $number_activations
 * @property integer $available_activations
 * @property string $date_active
 * @property string $created_at
 * @property string $updated_at
 */
class PromoCode extends TravelActiveRecord
{
    /**
     * Status
     */
    const ACTIVE = 1; // Активный
    const SUSPENDED = 2; // Приостановлен
    const USED = 3; // Использован,

    /**
     * @return string
     */
    public function tableName()
    {
        return '{{promo_codes}}';
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
            ['promo_code', 'default'],
            ['status_id', 'required'],
            ['number_activations', 'required'],
            ['discount', 'required'],
            ['type_id', 'required'],
            ['available_activations', 'length', 'max' => 255],
            ['date_create', 'date', 'format' => 'yyyy-MM-dd hh:mm:ss'],
            ['date_active', 'required'],
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
            'promo_code' => 'Промокод',
            'status_id' => 'Статус',
            'date_create' => 'Дата создания промокода',
            'type_id' => 'Тип подписки',
            'discount' => 'Размер скидки',
            'number_activations' => 'Количество активаций',
            'available_activations' => 'Доступные активации',
            'date_active' => 'Срок действия',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
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
        $criteria->compare('promo_code', $this->promo_code, true);
        $criteria->compare('status_id', $this->status_id, true);
        $criteria->compare('created_at', $this->created_at, true);
        $criteria->compare('updated_at', $this->updated_at, true);

        return new CActiveDataProvider($this, [
            'criteria' => $criteria,
            'pagination' => [
                'pageSize' => self::PAGE_SIZE,
            ],
            'sort' => [
                'defaultOrder' => 'created_at',
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

    public static function getStatuses()
    {
        return [
            self::ACTIVE => 'Активный',
            self::SUSPENDED => 'Приостановлен',
            self::USED => 'Использован',
        ];
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

    public static function getTypesId($data)
    {
        if (!isset($data['type_id']) || empty($data['type_id'])) {
            return '';
        }

        $ids = json_decode($data['type_id']);
        if (!is_array($ids) || empty($ids)) {
            return '';
        }

        $subscriptions = Subscription::model()->findAllByPk($ids);
        if (!$subscriptions) {
            return '';
        }

        $titles = array_map(function ($subscription) {
            return $subscription->title;
        }, $subscriptions);

        return implode(', ', $titles);
    }

    public function getStatus()
    {
        $statuses = self::getStatuses();
        return $statuses[$this->status_id];
    }

    public function checkAvailableActivations()
    {
        if ($this->available_activations <= 0){
            return 0;
        } else {
            return $this->available_activations = $this->available_activations - 1;
        }
    }

}