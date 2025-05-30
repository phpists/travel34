<?php

class WebUser extends CWebUser
{
    private $_model;

    /**
     * Yii::app()->user->isAdmin()
     * @return bool
     */
    public function isAdmin()
    {
        $user = $this->loadUser($this->id);
        if (!empty($user)) {
            return $user->isAdmin();
        } else {
            return false;
        }
    }

    /**
     * @return bool
     */
    public function isAdvertiser()
    {
        $user = $this->loadUser($this->id);
        if (!empty($user)) {
            return $user->isAdvertiser();
        } else {
            return false;
        }
    }

    /**
     * @return bool|UserOAuth
     */
    public function getUserOAuth()
    {
        try {
            Yii::import('ext.hoauth.models.UserOAuth');
            $user = $this->loadUser($this->id);
            if ($user !== null) {
                return UserOAuth::model()->findUser($user->id, $user->provider);
            }
        } catch (Exception $e) {

        }
        return false;
    }

    /**
     * Return UserOAuth model profile if user is logged in with social network
     * @return bool|\Hybridauth\User\Profile
     */
    public function getOAuthProfile()
    {
        $userOAuth = $this->getUserOAuth();
        try {
            if (!empty($userOAuth) && is_a($userOAuth, 'UserOAuth')) {
                return $userOAuth->getProfile();
            }
        } catch (Exception $e) {
            Yii::app()->request->cookies->clear();
        }
        return false;
    }

    /**
     * @param int $id
     * @return User|null
     */
    protected function loadUser($id = null)
    {
        if ($this->isGuest || $id === null) {
            return null;
        }
        if ($this->_model === null) {
            $this->_model = User::model()->findByPk($id);
        }
        return $this->_model;
    }
}
