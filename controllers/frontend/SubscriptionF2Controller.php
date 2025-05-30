<?php

use Stripe\Checkout\Session;
use Stripe\Customer;

class SubscriptionF2Controller extends FrontEndController
{
    /**
     * Step 1 save
     */
    public function actionSaveStepOne()
    {
        Subscription::clearSubscriptionCookies();

        if (isset($_POST['subscription'])) {
            $subscription = $_POST['subscription'];

            $subscriptionData = [
                'subscription' => $subscription,
                'type' => Subscription::MYSELF,
                'redirect_url' => Yii::app()->request->getUrlReferrer(),
                'subscription_text' => $_POST['subscription_text'],
                'subscription_type_text' => $_POST['subscription_type_text'],
            ];

            $cookies = Yii::app()->request->cookies;
            $cookies['subscription'] = new CHttpCookie('subscription', json_encode($subscriptionData));

            $this->renderJSON([
                'url' => '/subscription/f2/step-two',
                'params' => $subscriptionData
            ]);
        }

        $this->redirect(Yii::app()->request->urlReferrer);
    }

    /**
     * Step 2: show page
     */
    public function actionStepTwo()
    {
        $this->pageTitle = '34travel.me - Подписка';
        $cookies = Yii::app()->request->cookies;
        if (isset($cookies['subscription'])) {
            $this->render('step_two', [
                'type' => Subscription::MYSELF
            ]);
        }

        $this->redirect(Yii::app()->request->urlReferrer);
    }

    /**
     * Step 2:save email
     */
    public function actionSaveStepTwo()
    {
        if (isset($_POST['email'])) {
            $email = $_POST['email'];

            $cookies = Yii::app()->request->cookies;
            $subscriptionData = isset($cookies['subscription']) ? json_decode($cookies['subscription']->value, true) : array();
            $subscriptionData['email'] = $email;
            $cookies['subscription'] = new CHttpCookie('subscription', json_encode($subscriptionData));

            $this->redirect('/subscription/f2/step-two-auth');
        }

        $this->redirect(Yii::app()->request->urlReferrer);
    }

    /**
     * Step 2: show auth page
     */
    public function actionStepTwoAuth()
    {
        $this->pageTitle = '34travel.me - Подписка';
        $cookies = Yii::app()->request->cookies;
        if (isset($cookies['subscription'])) {
            $subscriptionData = json_decode($cookies['subscription']->value, true);

            if (!empty($subscriptionData['email'])) {
                $this->render('step_two_auth');
            }
        }

        $this->redirect(Yii::app()->request->urlReferrer);
    }

    /**
     * Step 2: Login
     */
    public function actionSaveStepTwoLogin()
    {
        $data = SubscriptionComponent::getSubscriptionCookie();

        if (Yii::app()->request->isPostRequest) {
            $email = $data['email'];
            $password = $_POST['password'];

            $loginResult = Yii::app()->userComponent->login($email, $password);

            if ($loginResult['status']) {
                $this->redirect('/subscription/f2/step-three');
                return;
            } else {
                Yii::app()->user->setFlash($loginResult['input'], $loginResult['message']);
            }
        }

        $this->redirect(Yii::app()->request->urlReferrer);
    }

    /**
     * Step 2: Register
     */
    public function actionSaveStepTwoRegister()
    {
        $model = new PasswordForm();
        $modelEmail = new EmailForm();

        if (isset($_POST['password']) && isset($_POST['password_repeat'])) {
            $data = SubscriptionComponent::getSubscriptionCookie();

            $model->password = $_POST['password'];
            $model->password_repeat = $_POST['password_repeat'];
            $modelEmail->email = $data['email'];

            if ($model->password !== $model->password_repeat) {
                Yii::app()->user->setFlash('register_password', 'Пароль и повторный пароль не совпадают.');
                $this->redirect(Yii::app()->request->urlReferrer);
            } else {
                if ($modelEmail->validate()) {
                    if ($model->validate()) {
                        $user = new User();
                        $user->email = $data['email'];
                        $user->username = 'Unknown';
                        $user->password = $user->hashPassword($model->password);
                        $user->last_login_time = date('Y-m-d H:i:s');
                        $user->role = User::ROLE_USER;
                        $user->is_verification = User::NOT_VERIFICATION;

                        if ($user->save()) {
                            SubscriptionComponent::sendConfirmationEmail('subscriptionF2/confirmStepTwoRegister', $user->email, $user->id);
                        }

                        $this->redirect('/subscription/f2/step-two-success');
                    }
                } else {
                    Yii::app()->user->setFlash('register_email', 'Пользователь с таким e-mail уже существует.');
                    $this->redirect(Yii::app()->request->urlReferrer);
                }
            }
        }
    }

    /**
     * Step 2: Register Confirm
     */
    public function actionConfirmStepTwoRegister($token, $email)
    {
        $userId = EmailService::decrypt($token);
        $user = User::model()->findByPk($userId);

        if ($user && $user->email === $email) {
            $user->is_verification = User::VERIFICATION;

            if ($user->save()) {
                Yii::app()->session['user_id'] = $user->id;
                Yii::app()->session['user_email'] = $user->email;

                $this->redirect('/subscription/f2/step-three');
            } else {
                Yii::app()->user->setFlash('email', 'Не удалось подтвердить электронный адрес.');
                $this->redirect('subscription/f2/step-two-auth');
            }
        } else {
            Yii::app()->user->setFlash('email', 'Неверный токен подтверждения или электронный адрес.');
            $this->redirect('subscription/f2/step-two-auth');
        }
    }

    /**
     * Step 2: Reset password email
     */
    public function actionStepTwoResetPasswordEmail()
    {
        $this->pageTitle = '34travel.me - Подписка';
        $data = SubscriptionComponent::getSubscriptionCookie();
        $user = User::model()->findByAttributes(['email' => $data['email']]);
        if (empty($user)) {
            Yii::app()->user->setFlash('email', 'Пользователь с таким e-mail не найден. Создайте пожалуйста новую учетную запись.');
            $this->redirect(Yii::app()->request->urlReferrer);
        }

        $flow = 2;
        $url = 'forgotPassword/subscriptionResetPasswordConfirmEmail';
        SubscriptionComponent::sendResetPasswordEmail($url, $user->email, $user->id, $flow);

        $this->render('step_two_send_reset_pass');
    }

    /**
     * Step 2: Success
     */
    public function actionStepTwoSuccess()
    {
        $this->pageTitle = '34travel.me - Подписка';
        $this->render('step_two_success');
    }

    /**
     * Step 3
     */
    public function actionStepThree()
    {
        $this->pageTitle = '34travel.me - Подписка';
        $data = SubscriptionComponent::getSubscriptionCookie();
        $subscription = Subscription::model()->findByAttributes(['id' => $data['subscription']]);

        $this->render('step_three', [
            'subscription' => $subscription
        ]);
    }

    /**
     * Step 3: Payment
     */
    public function actionStepThreePayment()
    {
        StripeComponent::initialize();

        try {
            $data = SubscriptionComponent::getSubscriptionCookie();
            $subscription = Subscription::model()->findByAttributes(['id' => $data['subscription']]);
            $user = Yii::app()->userComponent->getUser();

            $email = isset($data['email']) ? $data['email'] : $user->email;
            $customer = Customer::create([
                'email' => $email,
            ]);

            /** @var  $userSubscription */
            $userSubscription = SubscriptionComponent::createUserSubscription($user, $subscription);

            $successUrl = '/subscription/f2/step-three-payment/success';
            $cancelUrl = '/subscription/f2/step-three-payment/cancel';
            $session = StripeComponent::addSubscription($customer, $subscription, $userSubscription, $successUrl, $cancelUrl);

            $this->redirect($session->url);
        } catch (\Exception $e) {
            Yii::log("Stripe error: " . $e->getMessage(), CLogger::LEVEL_ERROR);
            throw new CHttpException(500, 'Ошибка при создании платежа.');
        }
    }

    /**
     * Step 3: Payment Success
     */
    public function actionStepThreePaymentSuccess()
    {
        StripeComponent::initialize();

        try {
            $this->pageTitle = '34travel.me - Подписка';
            $cookie = SubscriptionComponent::getSubscriptionCookie();
            $sessionId = Yii::app()->request->getParam('session_id');
            if ($sessionId && $cookie) {
                $data = StripeComponent::paymentSuccess($sessionId);

                /* Оплата */
                StripeComponent::paymentIntent(
                    $data["userSubscription"]["customer_id"],
                    $data["userSubscription"]["payment_method_id"],
                    $data["subscription"]["price"]
                );

                SubscriptionComponent::sendUserSubscriptionEmail($data['userSubscription'], $data['subscription']);
                Subscription::clearSubscriptionCookies();
                $this->render('step_four', [
                    'redirect_url' => $cookie['redirect_url'] ?? Yii::app()->createAbsoluteUrl('/'),
                    'subscription' => $data['subscription'],
                    'userSubscription' => $data['userSubscription'],
                ]);
            } else {
                $this->redirect('/');
            }
        } catch (\Exception $e) {
            Yii::log("Помилка оплати success: " . $e->getMessage(), CLogger::LEVEL_ERROR);
            throw new CHttpException(500, 'Ошибка при создании платежа.');
        }
    }

    public function actionStepThreePaymentCancel()
    {
        StripeComponent::initialize();

        $sessionId = Yii::app()->request->getParam('session_id');
        if ($sessionId) {
            $userSubscriptionId = $_GET['user_subscription_id'];
            StripeComponent::paymentCancel($userSubscriptionId);

            $this->redirect('/subscription/payment-cancel');
        }
    }

    private function sendConfirmationEmail($email, $userId)
    {
        $encryptedUserId = EmailService::encrypt($userId);

        $confirmationLink = $this->createAbsoluteUrl('subscriptionF2/confirmStepTwoRegister', array(
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
}