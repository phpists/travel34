<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
    private $_id;

    public $user;

    public function __construct($username, $password = null, $identifier = null, $provider = null)
    {
        // sets username and password values
        parent::__construct($username, $password);

        if (!empty($identifier) && !empty($provider)) {
            $this->user = User::model()->findByIdentifierProvider($identifier, $provider);
        }

        if ($this->user === null) {
            $this->user = User::model()->find('LOWER(username)=?', [strtolower($this->username)]);
            if ($this->user === null) {
                $this->errorCode = self::ERROR_USERNAME_INVALID;
            } else {
                $this->errorCode = self::ERROR_NONE;
            }
        } elseif ($password === null) {
            /**
             * you can set here states for user logged in with oauth if you need
             * you can also use hoauthAfterLogin()
             * @link https://github.com/SleepWalker/hoauth/wiki/Callbacks
             */
            $this->beforeAuthentication();
            $this->errorCode = self::ERROR_NONE;
        }
    }

    public function authenticate()
    {
        if ($this->user === null) {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        } elseif (!$this->user->validatePassword($this->password)) {
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
        } else {
            $this->beforeAuthentication();
            $this->errorCode = self::ERROR_NONE;
        }
        return $this->errorCode == self::ERROR_NONE;
    }

    public function getId()
    {
        return $this->_id;
    }

    public function beforeAuthentication()
    {
        $this->_id = $this->user->id;
        $this->username = $this->user->username;
        $this->setState('lastLogin', date('m/d/y g:i A', strtotime($this->user->last_login_time)));
        $this->user->saveAttributes(['last_login_time' => date('Y-m-d H:i:s')]);
    }
}
