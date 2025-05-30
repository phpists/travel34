<?php

class EmailForm extends CFormModel
{
    public $email;

    public function rules()
    {
        return array(
            array('email', 'required', 'message' => 'Email is required.'),
            array('email', 'email', 'message' => 'Invalid email format.'),
            array('email', 'unique', 'className' => 'User', 'attributeName' => 'email', 'message' => 'This email is already registered.'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'email' => 'Email',
        );
    }
}
