<?php


class UserComponent extends CApplicationComponent
{
    private $_user = null;

    /**
     * Auth status
     * @return bool
     */
    public function isAuthenticated()
    {
        return Yii::app()->session->contains('user_id');
    }

    /**
     * Get auth user
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === null && $this->isAuthenticated()) {
            $this->_user = User::model()->findByPk(Yii::app()->session['user_id']);
        }
        return $this->_user;
    }

    /**
     * Get auth user id
     * @return User|null
     */
    public function getUserId()
    {
        if ($this->_user === null && $this->isAuthenticated()) {
            $this->_user = User::model()->findByPk(Yii::app()->session['user_id']);
        }
        return $this->_user->id;
    }

    /**
     * Get user auth email
     * @return string|null
     */
    public function getUserEmail()
    {
        if ($this->isAuthenticated()) {
            return Yii::app()->session['user_email'];
        }
        return null;
    }

    /**
     * Logout
     */
    public function logout()
    {
        if ($this->isAuthenticated()) {
            Yii::app()->session->clear();
            Yii::app()->session->destroy();
            Yii::app()->request->redirect(Yii::app()->homeUrl);
        }
    }

    /**
     * Login
     * @param $email
     * @param $password
     * @return bool
     */
    public function login($email, $password)
    {
        $user = User::model()->findByAttributes(array('email' => $email));

        if ($user === null) {
            return [
                'status' => false,
                'input' => 'email',
                'message' => "Пользователь не найден"
            ];
        }

        if ($user->is_verification == User::NOT_VERIFICATION) {
            return [
                'status' => false,
                'input' => 'email',
                'message' => "Ваша электронная почта не подтверждена. Проверьте пожалуйста почтовый ящик."
            ];
        }

        if ($user->validatePassword($password)) {
            Yii::app()->session['user_id'] = $user->id;
            Yii::app()->session['user_email'] = $user->email;

            return [
                'status' => true,
            ];
        } else {
            return [
                'status' => false,
                'input' => 'password',
                'message' => "Пароль неверный"
            ];
        }
    }

    /**
     * Перевірка наявонсті активної підписки
     * @return bool
     */
    public function checkSubscription()
    {
        if (empty($this->isAuthenticated())) {
            return true;
        }

        $userSubscription = UserSubscription::model()->findByAttributes(
            ['user_id' => Yii::app()->session['user_id']],
            [
                'condition' => 'date_end >= :today AND status_id != :status',
                'params' => [
                    ':today' => date('Y-m-d H:i:s'),
                    ':status' => UserSubscription::DONATED
                ]
            ]
        );

        if ($userSubscription) {
            return false; // Як підписка є вимикаємо Paywall
        }

        return true;
    }

    /**
     * Перевірка наявності моєї підписки
     * @return bool
     */
    public function checkMySubscription()
    {
        if (empty($this->isAuthenticated())) {
            return true;
        }

        $userSubscription = UserSubscription::model()->findByAttributes(
            ['user_id' => Yii::app()->session['user_id']],
            [
                'condition' => 'status_id = :status_id AND subscription_type = :subscription_type AND date_end >= :date_now',
                'params' => [
                    ':status_id' => UserSubscription::SUCCESS,
                    ':subscription_type' => UserSubscription::MYSELF,
                    ':date_now' => date('Y-m-d'),
                ]
            ]
        );


        if ($userSubscription) {
            return false;
        }

        return true;
    }

}