<?php


class LoginForgotPasswordController extends FrontEndController
{
    /**
     * Step 1 Show page
     */
    public function actionResetPassword()
    {
        $this->render('send_email');
    }

    /**
     * Step 2 Send Email
     */
    public function actionResetPasswordEmail()
    {
        $user = User::model()->findByAttributes(['email' => Yii::app()->request->getPost('email')]);
        if (empty($user)) {
            Yii::app()->user->setFlash('email', 'Пользователь с таким e-mail не найден. Создайте пожалуйста новую учетную запись.');
            $this->redirect(Yii::app()->request->urlReferrer);
        }

        Yii::app()->user->setFlash('send_email', 'Запрос на восстановление пароля отправлен на почту.');
        EmailService::sendConfirmationEmail('loginForgotPassword/resetPasswordConfirmEmail', $user->email, $user->id);

        $this->redirect(Yii::app()->request->urlReferrer);
    }

    /**
     * Step 3 Confirm token
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
            $this->redirect('send_email');
        }
    }

    /**
     * Step 4
     */
    public function actionResetPasswordForm()
    {
        $user = User::model()->findByPk(Yii::app()->request->getPost('user_id'));
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

                    Yii::app()->session['user_id'] = $user->id;
                    Yii::app()->session['user_email'] = $user->email;
                    $this->redirect('/');
                }
            } else {
                Yii::app()->user->setFlash('new_password', 'Пароль и повторный пароль не совпадают.');
            }
        }

        $this->redirect(Yii::app()->request->urlReferrer);
    }
}