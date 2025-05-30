<?php


class RegistrationController extends FrontEndController
{
    public function actionStep1()
    {
        if (Yii::app()->userComponent->isAuthenticated()) {
            $this->redirect('/');
        }

        $model = new EmailForm();

        if (isset($_POST['email'])) {

            $validator = new CEmailValidator();
            if ($validator->validateValue($_POST['email'])) {
                $model->email = $_POST['email'];
            } else {
                Yii::app()->user->setFlash('email', 'Пожалуйста, введи корректный e-mail.');
                $this->redirect(Yii::app()->request->urlReferrer);
            }

            $existingUser = User::model()->findByAttributes(['email' => $model->email]);
            if ($existingUser) {
                Yii::app()->user->setFlash('email', 'Пользователь с таким e-mail уже существует.');
            } else {
                if ($model->validate()) {
                    Yii::app()->session['email'] = $model->email;
                    $this->redirect(array('registration/step2'));
                }
            }
        }

        $this->render('step1', ['model' => $model]);
    }

    public function actionStep2()
    {
        Yii::app()->cache->flush();
        if (!Yii::app()->session['email']) {
            $this->redirect(['registration/step1']);
        }

        $model = new PasswordForm();

        if (isset($_POST['password']) && isset($_POST['password_repeat'])) {
            $model->password = $_POST['password'];
            $model->password_repeat = $_POST['password_repeat'];

            if ($model->password !== $model->password_repeat) {
                Yii::app()->user->setFlash('password', 'Пароль и повторный пароль не совпадают.');
            } else {
                if ($model->validate()) {
                    $email = Yii::app()->session['email'];

                    $user = new User();
                    $user->email = $email;
                    $user->username = 'Unknown';
                    $user->password = $user->hashPassword($model->password);
                    $user->last_login_time = date('Y-m-d H:i:s');
                    $user->role = User::ROLE_USER;
                    $user->is_verification = User::NOT_VERIFICATION;

                    if ($user->save()) {
                        $this->sendConfirmationEmail($user->email, $user->id);
                        Yii::app()->user->setFlash('send_email', 'Письмо с подтверждением отправлено на твой e-mail.');
                    }
                }
            }
        }

        $this->render('step2', ['model' => $model]);
    }

    public function actionConfirmEmail($token, $email)
    {
        $userId = EmailService::decrypt($token);
        $user = User::model()->findByPk($userId);

        if ($user && $user->email === $email) {

            if ($user->is_verification == User::VERIFICATION){
                Yii::app()->session['user_id'] = $user->id;
                Yii::app()->session['user_email'] = $user->email;
                $this->redirect('/');
            }

            $user->is_verification = User::VERIFICATION;
            if ($user->save()) {
                Yii::app()->session['user_id'] = $user->id;
                Yii::app()->session['user_email'] = $user->email;

                $this->sendOnboardingEmail($email);
                $this->redirect('/');
            } else {
                Yii::app()->user->setFlash('email', 'Не вдалося підтвердити електронний адрес.');
                $this->redirect(array('registration/step1'));
            }
        } else {
            Yii::app()->user->setFlash('email', 'Неверный токен подтверждения или электронный адрес.');
            $this->redirect(array('registration/step1'));
        }
    }

    private function sendConfirmationEmail($email, $userId)
    {
        $encryptedUserId = EmailService::encrypt($userId);

        $confirmationLink = $this->createAbsoluteUrl('registration/confirmEmail', array(
            'token' => $encryptedUserId,
            'email' => $email,
        ));

        $template = EmailTemplate::getEmailTemplate(EmailTemplate::REGISTER_CONFIRM_EMAIL);
        $templateDescription = str_replace('@link', $confirmationLink, $template->description);

        $status = EmailService::sendEmail($email, $template->subject, $templateDescription);

        if (!$status) {
            Yii::app()->user->setFlash('email', 'Не удалось отправить письмо с подтверждением. Попробуйте еще раз.');
        }
    }

    private function sendOnboardingEmail($email)
    {
        $template = EmailTemplate::getEmailTemplate(EmailTemplate::WELCOME_EMAIL);
        $confirmationLink = Yii::app()->createAbsoluteUrl('/subscription/f4/step-one');
        $templateDescription = str_replace('@link', $confirmationLink, $template->description);
        $templateDescription = str_replace('@email', $email, $templateDescription);

        if ($template) {
            EmailService::sendEmail($email, $template->subject, $templateDescription);
        }

        return true;
    }
}