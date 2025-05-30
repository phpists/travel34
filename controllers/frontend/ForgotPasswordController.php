<?php


class ForgotPasswordController extends FrontEndController
{
    /**
     * Step 1
     */
    public function actionResetPasswordEmail()
    {
        if (!Yii::app()->userComponent->isAuthenticated()) {
            $this->redirect('/login');
        }

        $user = Yii::app()->userComponent->getUser();

        if (!$user->isSocial()) {
            $this->redirect('/profile/account');
        }

        EmailService::sendConfirmationEmail('forgotPassword/resetPasswordConfirmEmail', $user->email, $user->id);
        Yii::app()->user->setFlash('send_email', 'Запрос на восстановление пароля отправлен на почту.');

        $this->redirect(Yii::app()->request->urlReferrer);
    }

    /**
     * Step 2
     * @param $token
     * @param $email
     */
    public function actionResetPasswordConfirmEmail($token, $email)
    {
        $userId = EmailService::decrypt($token);
        $user = User::model()->findByPk($userId);

        if ($user && $user->email === $email) {
            $this->render('reset_password', [
                'user' => $user
            ]);
        } else {
            Yii::app()->user->setFlash('email', 'Неверный токен подтверждения пользователя.');
            $this->redirect(array('registration/step1'));
        }
    }

    /**
     * Step 22 Confirm User Subscription Email
     * @param $token
     * @param $email
     * @param $flow
     */
    public function actionSubscriptionResetPasswordConfirmEmail($token, $email, $flow)
    {
        $userId = EmailService::decrypt($token);
        $user = User::model()->findByPk($userId);

        if ($user && $user->email === $email) {
            $this->render('subscription_reset_password', [
                'user' => $user,
                'flow' => $flow
            ]);
        } else {
            Yii::app()->user->setFlash('email', 'Неверный токен подтверждения пользователя.');
            $this->redirect(array('/'));
        }
    }

    /**
     * Step 3
     */
    public function actionResetPassword()
    {
        try {
            $user = Yii::app()->userComponent->getUser();
            Yii::app()->user->setFlash('success', null);
            if (Yii::app()->request->isPostRequest) {
                $newPassword = $_POST['new_password'];
                $repeatPassword = $_POST['repeat_password'];

                $model = new PasswordForm();
                $model->password = $newPassword;
                $model->password_repeat = $repeatPassword;

                if ($model->password == $model->password_repeat) {
                    $user->password = $user->hashPassword($_POST['new_password']);
                    if ($user->save()) {
                        EmailService::sendSuccessEmail($user->email);
                        Yii::app()->user->setFlash('success', true);
                    }
                } else {
                    Yii::app()->user->setFlash('new_password', 'Пароль и повторный пароль не совпадают.');
                }
            }

            $this->render('reset_password', [
                'user' => $user
            ]);
        } catch (\Exception $e) {
            Yii::app()->user->setFlash('send_email', 'Срок действия ссылки подтверждения регистрации завершен');
            $this->redirect('/login');
        }
    }

    /**
     * Step 3
     */
    public function actionResetUserSubscriptionPassword()
    {
        if (Yii::app()->request->isPostRequest) {
            $userId = $_POST['user_id'];
            $flow = $_POST['flow'];
            $newPassword = $_POST['new_password'];
            $repeatPassword = $_POST['repeat_password'];

            $model = new PasswordForm();
            $model->password = $newPassword;
            $model->password_repeat = $repeatPassword;

            if ($model->password == $model->password_repeat) {
                $user = User::model()->findByPk($userId);
                $user->password = $user->hashPassword($_POST['new_password']);
                if ($user->save()) {
                    Yii::app()->session['user_id'] = $user->id;
                    Yii::app()->session['user_email'] = $user->email;

                    EmailService::sendSuccessEmail($user->email);

                    if ($flow == 1) {
                        $this->redirect('/subscription/f1/step-three');
                    }

                    if ($flow == 2) {
                        $this->redirect('/subscription/f2/step-three');
                    }
                }
            } else {
                Yii::app()->user->setFlash('new_password', 'Пароль и повторный пароль не совпадают.');
                $this->redirect(Yii::app()->request->urlReferrer);
            }
        }
    }
}