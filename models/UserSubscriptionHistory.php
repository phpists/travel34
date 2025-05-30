<?php

/**
 * @property integer $id
 * @property integer $user_id
 * @property integer $user_subscription_id
 * @property integer $subscription_id
 * @property integer $status_id
 * @property string $date_start
 * @property string $date_end
 * @property string $created_at
 * @property string $updated_at
 */
class UserSubscriptionHistory extends TravelActiveRecord
{
    /**
     * Status id
     */
    const ACTIVE = 1;
    const INACTIVE = 2;

    public function tableName()
    {
        return '{{user_subscription_history}}';
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
            ['subscription_id', 'numerical', 'integerOnly' => true],
            ['user_subscription_id', 'numerical', 'integerOnly' => true],
            ['user_id, subscription_id', 'safe', 'on' => 'search'],
            ['id, user_id, subscription_id', 'numerical', 'integerOnly' => false],
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
            'user_subscription_id' => 'User subscription id',
            'subscription_id' => 'Subscription id',
            'status_id' => 'Статус',
            'date_start' => 'Date start',
            'date_end' => 'Date end',
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
}