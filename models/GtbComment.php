<?php

/**
 * This is the model class for table "{{gtb_comment}}".
 *
 * The followings are the available columns in table '{{gtb_comment}}':
 * @property integer $id
 * @property integer $gtb_post_id
 * @property string $content
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
 * @property GtbPost $gtbPost
 * @property User $updateUser
 * @property User $author
 */
class GtbComment extends TravelActiveRecord
{
    const POSITIVE_COOKIE_VALUE = 'plus';
    const NEGATIVE_COOKIE_VALUE = 'minus';

    const POSITIVE_COUNTER_FIELD = 'likes_count';
    const NEGATIVE_COUNTER_FIELD = 'dislikes_count';

    public $post_title_search;
    public $verifyCode;
    public $children;
    public $level;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{gtb_comment}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return [
            ['gtb_post_id', 'required'],
            ['gtb_post_id, create_user_id, update_user_id, parent_id, status_id, likes_count, dislikes_count', 'numerical', 'integerOnly' => true],
            ['email, user_name', 'length', 'max' => 255],
            ['content, created_at, updated_at', 'safe'],
            ['email', 'email'],
            ['email, user_name', 'checkRegisterd'],
            [
                'verifyCode',
                'captcha',
                // авторизованным пользователям код можно не вводить
                'allowEmpty' => !Yii::app()->user->isGuest || !CCaptcha::checkRequirements(),
            ],
            ['id, gtb_post_id, content, email, user_name, created_at, updated_at, create_user_id, update_user_id, parent_id, status_id, likes_count, dislikes_count, post_title_search', 'safe', 'on' => 'search'],
        ];
    }

    public function checkRegisterd($attribute)
    {
        if (Yii::app()->user->isGuest || !Yii::app()->user->getOAuthProfile()) {
            if (empty($this->$attribute)) {
                $message = Yii::t('yii', '{attribute} cannot be blank.', ['{attribute}' => $this->getAttributeLabel($attribute)]);
                $this->addError($attribute, $message);
            }
        }
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return [
            'gtbPost' => [self::BELONGS_TO, 'GtbPost', 'gtb_post_id'],
            'updateUser' => [self::BELONGS_TO, 'User', 'update_user_id'],
            'author' => [self::BELONGS_TO, 'User', 'create_user_id'],
        ];
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

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'gtb_post_id' => 'Пост',
            'content' => Yii::t('app', 'Comment'),
            'email' => 'Email',
            'user_name' => Yii::t('app', 'Name'),
            'created_at' => 'Дата создания',
            'updated_at' => 'Updated At',
            'create_user_id' => 'Create User',
            'update_user_id' => 'Update User',
            'parent_id' => 'Parent',
            'status_id' => 'Статус',
            'likes_count' => 'Лайки',
            'dislikes_count' => 'Дислайки',
            'gtbPost' => 'Пост',
            'post_title_search' => 'Пост',
        ];
    }

    /**
     * @return CActiveDataProvider
     */
    public function search()
    {
        $criteria = new CDbCriteria();
        $criteria->with = ['gtbPost'];
        $criteria->together = true;

        $tableAlias = $this->getTableAlias();

        $criteria->compare($tableAlias . '.id', $this->id);
        $criteria->compare($tableAlias . '.gtb_post_id', $this->gtb_post_id);
        $criteria->compare($tableAlias . '.content', $this->content, true);
        $criteria->compare($tableAlias . '.email', $this->email, true);
        $criteria->compare($tableAlias . '.user_name', $this->user_name, true);
        $criteria->compare($tableAlias . '.created_at', $this->created_at, true);
        $criteria->compare($tableAlias . '.updated_at', $this->updated_at, true);
        $criteria->compare($tableAlias . '.create_user_id', $this->create_user_id);
        $criteria->compare($tableAlias . '.update_user_id', $this->update_user_id);
        $criteria->compare($tableAlias . '.parent_id', $this->parent_id);
        $criteria->compare($tableAlias . '.status_id', $this->status_id);
        $criteria->compare($tableAlias . '.likes_count', $this->likes_count);
        $criteria->compare($tableAlias . '.dislikes_count', $this->dislikes_count);

        $criteria->compare('gtbPost.title', $this->post_title_search, true);

        $criteria->order = $tableAlias . '.created_at DESC';

        return new CActiveDataProvider($this, [
            'criteria' => $criteria,
            'sort' => [
                'defaultOrder' => $tableAlias . '.created_at DESC',
                'attributes' => [
                    'post_title_search' => [
                        'asc' => 'gtbPost.title',
                        'desc' => 'gtbPost.title DESC',
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
     * @return GtbComment the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
