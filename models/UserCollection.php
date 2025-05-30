<?php

/**
 * This is the model class for table "{{user_collection}}".
 *
 * The followings are the available columns in table '{{collection}}':
 * @property integer $id
 * @property integer $collection_id
 * @property integer $post_id
 * @property integer $user_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @method UserCollection enabled()
 */
class UserCollection extends TravelActiveRecord
{
    /**
     * Type Delete
     */
    const DELETE_FROM_COLLECTION = 1;
    const DELETE_FROM_FAVORITE = 2;


    public function tableName()
    {
        return '{{user_collection}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return [
            ['collection_id', 'numerical', 'integerOnly' => true],
            ['post_id', 'numerical', 'integerOnly' => true],
            ['user_id', 'numerical', 'integerOnly' => true],
            ['created_at, updated_at', 'date', 'format' => 'yyyy-MM-dd hh:mm:ss'],
            ['created_at, updated_at', 'default', 'setOnEmpty' => true, 'value' => null],
        ];
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'collection_id' => 'Collection id',
            'post_id' => 'Port id',
            'user_id' => 'User id',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
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

    public function relations()
    {
        return array(
            'post' => array(self::HAS_MANY, 'Post', 'id'),
        );
    }
}