<?php

use Stripe\Checkout\Session;
use Stripe\Customer;

class SubscriptionF5Controller extends FrontEndController
{
    /**
     * Step 2:save gift type
     */
    public function actionSaveStepTwoGift()
    {
        $this->pageTitle = '34travel.me - Подписка';
        $giftType = $_POST['gift_type'];
        if (isset($giftType)) {
            $cookies = Yii::app()->request->cookies;
            $subscriptionData = isset($cookies['subscription']) ? json_decode($cookies['subscription']->value, true) : array();
            $subscriptionData['gift_type'] = $giftType;
            $cookies['subscription'] = new CHttpCookie('subscription', json_encode($subscriptionData));

            if (Yii::app()->userComponent->isAuthenticated()) {
                $url = '/subscription/f5/show-step-three-gift';
            } else {
                $url = '/subscription/f5/step-two-gift-auth';
            }

            if (Yii::app()->request->isAjaxRequest) {
                 $this->renderJSON([
                    'url' => $url
                ]);
            } else {
                $this->redirect($url);
            }
        }

        $this->redirect(Yii::app()->request->urlReferrer);
    }

    public function actionShowStepThreeGift()
    {
        $this->render('step_three_gift');
    }

    /**
     * Step 2: Gift Login
     */
    public function actionSaveStepTwoGiftLogin()
    {
        if (Yii::app()->request->isPostRequest) {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $loginResult = Yii::app()->userComponent->login($email, $password);

            if ($loginResult['status']) {
                $this->redirect('/subscription/f5/step-three-gift');
                return;
            } else {
                Yii::app()->user->setFlash($loginResult['input'], $loginResult['message']);
            }
        }

        $this->redirect('/subscription/f5/step-two-gift-auth');
    }

    /**
     * Подписка в подарок - Gift
     */
    public function actionStepTwoGiftAuth()
    {
        $this->pageTitle = '34travel.me - Подписка';
        $cookies = Yii::app()->request->cookies;
        if (isset($cookies['subscription'])) {
            $subscriptionData = json_decode($cookies['subscription']->value, true);

            if (!empty($subscriptionData['gift_type'])) {
                $page = $subscriptionData['gift_type'] == Subscription::REGISTER ? 'step_two_gift_auth' : '//subscriptionF6/step_two';
                $this->render($page);
            }
        }

        $this->redirect(Yii::app()->request->urlReferrer);
    }

    /**
     * Step 2: Register Gift
     */
    public function actionSaveStepTwoGiftRegister()
    {
        $model = new PasswordForm();
        $modelEmail = new EmailForm();

        if (isset($_POST['password']) && isset($_POST['password_repeat'])) {
            $model->password = $_POST['password'];
            $model->password_repeat = $_POST['password_repeat'];
            $modelEmail->email = $_POST['email'];

            if ($model->password !== $model->password_repeat) {
                Yii::app()->user->setFlash('register_password', 'Пароль и повторный пароль не совпадают.');
                $this->redirect(Yii::app()->request->urlReferrer);
            } else {
                if ($modelEmail->validate()) {
                    if ($model->validate()) {
                        $user = new User();
                        $user->email = $_POST['email'];
                        $user->username = 'Unknown';
                        $user->password = $user->hashPassword($model->password);
                        $user->last_login_time = date('Y-m-d H:i:s');
                        $user->role = User::ROLE_USER;
                        $user->is_verification = User::NOT_VERIFICATION;

                        if ($user->save()) {
                            SubscriptionComponent::sendConfirmationEmail('subscriptionF5/confirmStepTwoGiftRegister', $user->email, $user->id);
                        }

                        $this->redirect('/subscription/f1/step-two-success');
                    }
                } else {
                    Yii::app()->user->setFlash('register_email', 'Пользователь с таким e-mail уже существует.');
                    $this->redirect(Yii::app()->request->urlReferrer);
                }
            }
        }
    }

    /**
     * Step 2: Register Gift Confirm
     */
    public function actionConfirmStepTwoGiftRegister($token, $email)
    {
        $userId = EmailService::decrypt($token);
        $user = User::model()->findByPk($userId);

        if ($user && $user->email === $email) {
            $user->is_verification = User::VERIFICATION;

            if ($user->save()) {
                Yii::app()->session['user_id'] = $user->id;
                Yii::app()->session['user_email'] = $user->email;

                $this->redirect('/subscription/f5/step-three-gift');
            } else {
                Yii::app()->user->setFlash('email', 'Не удалось подтвердить электронный адрес.');
                $this->redirect(Yii::app()->request->urlReferrer);
            }
        } else {
            Yii::app()->user->setFlash('email', 'Неверный токен подтверждения или электронный адрес.');
            $this->redirect(Yii::app()->request->urlReferrer);
        }
    }

    /**
     * Step 3 Gift
     */
    public function actionStepThreeGift()
    {
        $this->pageTitle = '34travel.me - Подписка';
        $user = Yii::app()->userComponent->getUser();
        $this->render('step_three_gift', [
            'user' => $user
        ]);
    }

    public function actionSaveStepThreeGift()
    {
        $data = SubscriptionComponent::getSubscriptionCookie();
        $email = $_POST['email'];
        $date = $_POST['date'];
        $time = $_POST['time'];
        $emailConfirm = $_POST['email_confirm'];
        $parentEmail = $_POST['parent_email'];
        $user = Yii::app()->userComponent->getUser();

        Yii::app()->user->setFlash('old_email', $email);
        Yii::app()->user->setFlash('old_date', $date);
        Yii::app()->user->setFlash('old_time', $time);
        Yii::app()->user->setFlash('old_email_confirm', $emailConfirm);
        Yii::app()->user->setFlash('old_parent_email', $parentEmail);

        if ($email !== $emailConfirm) {
            Yii::app()->user->setFlash('email', 'Введенные адреса не совпадают. Проверь, нет ли опечатки, и попробуй еще раз.');
            $this->redirect('/subscription/f4/step-two-auth-gift');
        }

        if ($parentEmail == $email) {
            Yii::app()->user->setFlash('email', 'Email дарителя не может совпадать с email клиента.');
            $this->redirect('/subscription/f4/step-two-auth-gift');
        }

        if (EmailService::validateGmailEmail($parentEmail)) {
            Yii::app()->user->setFlash('parent_email', 'Пожалуйста, введи корректный e-mail.');
            $this->redirect('/subscription/f4/step-two-auth-gift');
        }

        $datetimeString = $date . ' ' . $time;
        $inputDateTime = DateTime::createFromFormat('d.m.Y H:i', $datetimeString);
        $currentDateTime = new DateTime();

        if ($inputDateTime < $currentDateTime) {
            Yii::app()->user->setFlash('time', 'Похоже, выбранное время уже прошло. Пожалуйста, выбери другое время.');
            $this->redirect('/subscription/f4/step-two-auth-gift');
        }

        $gift = new UserSubscriptionGift();
        $gift->user_id = $user->id;
        $gift->user_email = $parentEmail;
        $gift->gift_email = $email;
        $gift->gift_date = date('Y-m-d', strtotime($date));
        $gift->gift_time = $time;
        $gift->status_id = UserSubscriptionGift::INACTIVE;
        $gift->type_id = $data['subscription'];
        $gift->code = SubscriptionComponent::getGiftCode();
        $gift->number_activations = 1;
        $gift->expiry_date = UserSubscriptionGift::addYearToToday();
        $gift->date_create = date('Y-m-d H:i:s');

        if ($gift->save()) {
            $cookies = Yii::app()->request->cookies;
            $subscriptionData = isset($cookies['subscription']) ? json_decode($cookies['subscription']->value, true) : [];
            $subscriptionData['gift_id'] = $gift->id;
            $subscriptionData['gift_date'] = $date;
            $subscriptionData['gift_type'] = Subscription::REGISTER;
            $subscriptionData['email'] = $parentEmail;
            $cookies['subscription'] = new CHttpCookie('subscription', json_encode($subscriptionData));

            $this->redirect('/subscription/f5/step-three');
        }

        Yii::app()->user->setFlash('email', 'Неверно заполненные данные.');
        $this->redirect(Yii::app()->request->urlReferrer);
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
            $userSubscription = SubscriptionComponent::createUserSubscription($user, $subscription, UserSubscription::DONATED);

            $successUrl = '/subscription/f5/step-three-payment/success';
            $cancelUrl = '/subscription/f5/step-three-payment/cancel';
            $session = StripeComponent::addSubscription($customer, $subscription, $userSubscription, $successUrl, $cancelUrl);

            $this->redirect($session->url);
        } catch (\Exception $e) {
            Yii::log("Stripe error: " . $e->getMessage(), CLogger::LEVEL_ERROR);
            throw new CHttpException(500, 'Ошибка при создании платежа.');
        }
    }

    /**
     * Step 3: Payment Success
     * @throws CHttpException
     */
    public function actionStepThreePaymentSuccess()
    {
        StripeComponent::initialize();

        try {
            $cookie = SubscriptionComponent::getSubscriptionCookie();
            $sessionId = Yii::app()->request->getParam('session_id');

            if ($sessionId && $cookie) {
                $data = StripeComponent::paymentSuccess($sessionId, UserSubscription::DONATED);

                /* Оплата */
                StripeComponent::paymentIntent(
                    $data["userSubscription"]["customer_id"],
                    $data["userSubscription"]["payment_method_id"],
                    $data["subscription"]["price"]
                );

                if ($cookie['gift_type'] == Subscription::REGISTER) {
                    SubscriptionComponent::sendParentSubscriptionGift($data['userSubscription'], $data['subscription']);
                    $page = '//subscriptionF5/step_four_gift';
                } else {
                    SubscriptionComponent::sendUserSubscriptionEmail($data['userSubscription'], $data['subscription']);
                    $page = 'step_four';
                }

                Subscription::clearSubscriptionCookies();
                $this->render($page, [
                    'redirect_url' => $cookie['redirect_url'] ?? Yii::app()->createAbsoluteUrl('/'),
                    'start_date' => isset($cookie['gift_date']) ? $cookie['gift_date'] : $data['userSubscription']['date_start'],
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

    /**
     * Step 3: Payment Cancel
     * @throws CHttpException
     */
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
}