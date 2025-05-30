<?php

class PasswordForm extends CFormModel
{
    public $password;
    public $password_repeat;

    public function rules()
    {
        return array(
            array('password, password_repeat', 'required', 'message' => 'Password is required.'),
            array('password', 'length', 'min' => 1, 'max' => 40, 'message' => 'Password should be between 6 and 40 characters.'),
            array('password_repeat', 'compare', 'compareAttribute' => 'password', 'message' => 'Passwords do not match.'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'password' => 'Password',
            'password_repeat' => 'Repeat Password',
        );
    }
}
