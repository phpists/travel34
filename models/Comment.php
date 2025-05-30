<?php

/**
 * This is the model class for table "{{comment}}".
 *
 * The followings are the available columns in table '{{comment}}':
 * @property integer $id
 * @property string $content
 * @property integer $post_id
 * @property string $email
 * @property string $user_name
 * @property string $created_at
 * @property string $updated_at
 * @property integer $create_user_id
 * @property integer $update_user_id
 * @property integer $parent_id
 * @property integer $status_id
 * @property integer $likes_count
 * @property integer $dislikes_count
 *
 * The followings are the available model relations:
 * @property User $updateUser
 * @property User $author
 * @property Post $post
 */
class Comment extends TravelActiveRecord
{
    const POSITIVE_COOKIE_VALUE = 'plus';
    const NEGATIVE_COOKIE_VALUE = 'minus';

    const POSITIVE_COUNTER_FIELD = 'likes_count';
    const NEGATIVE_COUNTER_FIELD = 'dislikes_count';

    public $post_title_search;
    public $post_url_search;
    public $verifyCode;
    public $children;
    public $level;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{comment}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return [
            ['content, post_id', 'required'],
            ['post_id, create_user_id, update_user_id, parent_id, status_id, likes_count, dislikes_count', 'numerical', 'integerOnly' => true],
            ['email', 'email', 'message' => "Пожалуйста, укажите правильный адрес e-mail"],
            ['likes_count, dislikes_count', 'safe'],
            ['created_at, updated_at', 'date', 'format' => 'yyyy-MM-dd hh:mm:ss'],
            ['email, user_name', 'checkRegisterd'],
            // авторизованным пользователям код можно не вводить
            ['verifyCode', 'captcha', 'allowEmpty' => !Yii::app()->user->isGuest || !CCaptcha::checkRequirements()],
            ['created_at, updated_at', 'default', 'setOnEmpty' => true, 'value' => null],
            // The following rule is used by search().
            ['id, content, post_id, created_at, create_user_id, updated_at, update_user_id, status, email, user_name, post_title_search, post_url_search, parent_id, likes_count, dislikes_count', 'safe', 'on' => 'search'],
        ];
    }

    public function checkRegisterd($attribute)
    {
        //var_dump($this->$attribute);die;
        if (Yii::app()->user->isGuest || !Yii::app()->user->getOAuthProfile()) {
            if (empty($this->$attribute)) {
                $this->addError($attribute, 'Пожалуйста, заполните поле');
            }
        }
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return [
            'updateUser' => [self::BELONGS_TO, 'User', 'update_user_id'],
            'author' => [self::BELONGS_TO, 'User', 'create_user_id'],
            'post' => [self::BELONGS_TO, 'Post', 'post_id'],
        ];
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'content' => 'Комментарий',
            'post_id' => 'Пост',
            'email' => 'Email',
            'user_name' => 'User Name',
            'created_at' => 'Create Time',
            'updated_at' => 'Update Time',
            'create_user_id' => 'Create User',
            'update_user_id' => 'Update User',
            'parent_id' => 'Parent',
            'status_id' => 'Статус',
            'likes_count' => 'Лайки',
            'dislikes_count' => 'Дислайки',
            'post_title_search' => 'Пост',
            'post_url_search' => 'URL Поста',
        ];
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search()
    {
        $criteria = new CDbCriteria();
        $criteria->with = ['post'];
        $criteria->together = true;

        $tableAlias = $this->getTableAlias();

        $criteria->compare($tableAlias . '.id', $this->id);
        $criteria->compare('content', $this->content, true);
        $criteria->compare('post_id', $this->post_id);
        $criteria->compare($tableAlias . '.created_at', $this->created_at, true);
        $criteria->compare('create_user_id', $this->create_user_id);
        $criteria->compare($tableAlias . '.updated_at', $this->updated_at, true);
        $criteria->compare('update_user_id', $this->update_user_id);
        $criteria->compare('post.title', $this->post_title_search, true);
        $criteria->compare('post.url', $this->post_url_search, true);
        $criteria->order = $tableAlias . '.created_at DESC';

        return new CActiveDataProvider($this, [
            'criteria' => $criteria,
            'sort' => [
                'defaultOrder' => $tableAlias . '.created_at DESC',
                'attributes' => [
                    'post_title_search' => [
                        'asc' => 'post.title',
                        'desc' => 'post.title DESC',
                    ],
                    'post_url_search' => [
                        'asc' => 'post.url',
                        'desc' => 'post.url DESC',
                    ],
                    '*',
                ],
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
     * @return Comment the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * Scopes conditions
     * @return array
     */
    public function scopes()
    {
        return array_merge(parent::scopes(), [
            'orderedLast' => [
                'order' => 'created_at DESC',
            ],
        ]);
    }
}
