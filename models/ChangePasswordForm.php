<?php

class ChangePasswordForm extends CFormModel
{
    public $pwd_current;
    public $password;
    public $pwd_confirm;

    public function rules()
    {
        return [
            ['pwd_current, password, pwd_confirm', 'required'],
            ['pwd_confirm', 'compare', 'compareAttribute' => 'password'],
            ['password, pwd_confirm', 'length', 'min' => 5],
            ['pwd_current, password, pwd_confirm', 'emptyOnInvalid'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'pwd_current' => Yii::t('app', 'Current Password'),
            'password' => Yii::t('app', 'New Password'),
            'pwd_confirm' => Yii::t('app', 'Repeat Password'),
        ];
    }

    /**
     * Обнулить введенные данные при ошибке
     *
     * @param $attribute
     */
    public function emptyOnInvalid($attribute)
    {
        if ($this->hasErrors()) {
            $this->$attribute = null;
        }
    }

    /**
     * Очистим пароли
     */
    public function emptyAttributes()
    {
        $this->pwd_current = null;
        $this->password = null;
        $this->pwd_confirm = null;
    }

    /**
     * Запись нового пароля
     * @param User $user
     * @return bool|User
     */
    public function savePassword(User $user)
    {
        if ($user === null) {
            return false;
        }
        $user->password = $this->password;
        if ($user->save(true, ['password', 'updated_at'])) {
            return $user;
        }
        return false;
    }
}