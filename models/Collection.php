<?php

/**
 * This is the model class for table "{{collection}}".
 *
 * The followings are the available columns in table '{{collection}}':
 * @property integer $id
 * @property string $title
 * @property string $user_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @method Collection enabled()
 */
class Collection extends TravelActiveRecord
{
    public function tableName()
    {
        return '{{collection}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return [
            ['title', 'required'],
            ['user_id', 'numerical', 'integerOnly' => true],
            ['title', 'length', 'max' => 255],
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
            'title' => 'Title',
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
            'userCollections' => array(self::HAS_MANY, 'UserCollection', 'collection_id'),
        );
    }

    public function getPostImage()
    {
        $themeUrl = Yii::app()->theme->baseUrl;
        $userCollections = $this->userCollections[0];
        if ($userCollections) {
            $post = Post::model()->findByAttributes(['id' => $userCollections->post_id]);

            if (empty($post)){
                return $themeUrl . '/img/collection_img.png';
            }
            $img = $post->getImageUrl('image');
        } else {
            $img = $themeUrl . '/img/collection_img.png';
        }

        return $img;
    }
}