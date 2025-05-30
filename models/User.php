<?php

/**
 * This is the model class for table "{{user}}".
 *
 * The followings are the available columns in table '{{user}}':
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $last_login_time
 * @property string $created_at
 * @property string $updated_at
 * @property string $email
 * @property string $provider
 * @property string $identifier
 * @property integer $role
 * @property boolean $is_verification
 * @property boolean $is_social
 * @property boolean $is_send_onboarding
 * @property string $profile_url
 * @property string $profile_img
 */
class User extends TravelActiveRecord
{
    const ROLE_USER = 0;
    const ROLE_ADMIN = 1;
    const ROLE_ADVERTISER = 5;

    /**
     * is_verification
     */
    const NOT_VERIFICATION = 0;
    const VERIFICATION = 1;

    /**
     * is_social
     */
    const SOCIAL = 1;
    const REGISTER = 0;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{user}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return [
            ['username, password', 'required'],
            ['role', 'numerical', 'integerOnly' => true],
            ['username, password, email, profile_url, profile_img', 'length', 'max' => 255],
            ['provider', 'length', 'max' => 100],
            ['identifier', 'length', 'max' => 45],
            ['last_login_time, created_at, updated_at', 'date', 'format' => 'yyyy-MM-dd hh:mm:ss'],
            ['last_login_time, created_at, updated_at', 'default', 'setOnEmpty' => true, 'value' => null],
            ['role', 'in', 'range' => self::getAllowedRoleRange()],
            ['is_verification', 'numerical', 'integerOnly' => true],
            ['is_social', 'numerical', 'integerOnly' => true],
            ['is_send_onboarding', 'numerical', 'integerOnly' => true],
            // The following rule is used by search().
            [
                'id, username, email, provider, identifier, profile_url, profile_img, last_login_time, created_at, updated_at, role',
                'safe',
                'on' => 'search',
            ],
        ];
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password' => 'Password',
            'email' => 'Email',
            'provider' => 'Provider',
            'identifier' => 'Identifier',
            'profile_url' => 'Profile Url',
            'profile_img' => 'Profile Img',
            'last_login_time' => 'Last Login Time',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'role' => 'Role',
            'is_verification' => 'Is verification',
            'is_social' => 'Is social',
            'is_send_onboarding' => 'Is onboarding'
        ];
    }

    /**
     * @return CActiveDataProvider
     */
    public function search()
    {
        $criteria = new CDbCriteria();

        $criteria->compare('id', $this->id);
        $criteria->compare('username', $this->username, true);
        $criteria->compare('password', $this->password, true);
        $criteria->compare('last_login_time', $this->last_login_time, true);
        $criteria->compare('created_at', $this->created_at, true);
        $criteria->compare('updated_at', $this->updated_at, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('provider', $this->provider, true);
        $criteria->compare('identifier', $this->identifier, true);
        $criteria->addNotInCondition('username', ['admin', 'dev']);
        $criteria->addCondition("provider IS NULL OR provider = ''");

        return new CActiveDataProvider($this, [
            'criteria' => $criteria,
            'pagination' => [
                'pageSize' => self::PAGE_SIZE,
            ],
            'sort' => [
                'defaultOrder' => 'id',
            ],
        ]);
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return User the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * apply a hash on the password before we store it in the database
     */
//    protected function afterValidate()
//    {
//        parent::afterValidate();
//        if (!$this->hasErrors()) {
//            $this->password = $this->hashPassword($this->password);
//        }
//    }

    /**
     * Generates the password hash.
     * @param string $password
     * @return string hash
     */
    public function hashPassword($password)
    {
        return md5($password);
    }

    /**
     * Checks if the given password is correct.
     * @param string $password the password to be validated
     * @return boolean whether the password is valid
     */
    public function validatePassword($password)
    {
        return $this->hashPassword($password) === trim($this->password);
    }

    /**
     * Returns User model by its identifier and provider
     * @param $identifier
     * @param $provider
     * @return User
     */
    public function findByIdentifierProvider($identifier, $provider)
    {
        return self::model()->findByAttributes(['identifier' => $identifier, 'provider' => $provider]);
    }

    /**
     * @return bool
     */
    public function isAdmin()
    {
        return !empty($this->role) ? $this->role == self::ROLE_ADMIN : false;
    }

    /**
     * @return bool
     */
    public function isAdvertiser()
    {
        return !empty($this->role) ? $this->role == self::ROLE_ADVERTISER : false;
    }

    /**
     * @return array
     */
    public static function getRoleOptions()
    {
        return [
            self::ROLE_USER => 'Пользователь',
            self::ROLE_ADMIN => 'Админ',
            self::ROLE_ADVERTISER => 'Рекламодатель',
        ];
    }

    /**
     * @return array
     */
    public static function getAllowedRoleRange()
    {
        return array_keys(self::getRoleOptions());
    }

    /**
     * @param int $roleId
     * @return string
     */
    public function getRoleText($roleId = null)
    {
        if (!$roleId) {
            $roleId = $this->role;
        }
        $roleOptions = self::getRoleOptions();
        return isset($roleOptions[$roleId]) ? $roleOptions[$roleId] : '';
    }

    public function isSocial()
    {
        return $this->is_social == self::SOCIAL ? false : true;
    }
}
