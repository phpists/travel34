<?php

use Stripe\Checkout\Session;
use Stripe\Customer;

class SubscriptionF11Controller extends FrontEndController
{
    /**
     * Step 1
     */
    public function actionStepOne()
    {
        Subscription::clearSubscriptionCookies();

        $this->pageTitle = '34travel.me - Подписка';
        $this->render('step_one');
    }

    public function actionSaveStepOne()
    {
        if (isset($_POST['subscription'])) {
            $subscription = $_POST['subscription'];
            $subscriptionData = [
                'subscription' => $subscription,
                'type' => Subscription::GIFT,
                'redirect_url' => Yii::app()->createAbsoluteUrl('/profile/account'),
                'subscription_text' => $_POST['subscription_text'],
                'subscription_type_text' => 'Подписка в подарок',
            ];

            $cookies = Yii::app()->request->cookies;
            $cookies['subscription'] = new CHttpCookie('subscription', json_encode($subscriptionData));

            $this->renderJSON([
                'url' => '/subscription/f11/step-two',
                'params' => $subscriptionData
            ]);
        }

        $this->redirect(Yii::app()->request->urlReferrer);
    }


    /**
     * Step 2
     */
    public function actionStepTwo()
    {
        $this->pageTitle = '34travel.me - Подписка';
        $this->render('step_two');
    }


    /**
     * Step 1 save
     */
    public function actionSaveStepTwo()
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
        Yii::app()->user->setFlash('user_email', $email);

        if ($email !== $emailConfirm) {
            Yii::app()->user->setFlash('email', 'Введенные адреса не совпадают. Проверь, нет ли опечатки, и попробуй еще раз.');
            $this->redirect(Yii::app()->request->urlReferrer);
        }

        if ($parentEmail == $email) {
            Yii::app()->user->setFlash('email', 'Email дарителя не может совпадать с email клиента.');
            $this->redirect(Yii::app()->request->urlReferrer);
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
            $this->redirect(Yii::app()->request->urlReferrer);
        }

        SubscriptionComponent::updateSubscriptionCookie('email_confirm', $emailConfirm);

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

            $this->redirect('/subscription/f11/step-three');
        }

        Yii::app()->user->setFlash('email', 'Неверно заполненные данные.');
        $this->redirect(Yii::app()->request->urlReferrer);
    }

    /**
     * Step 2
     */
    public function actionStepThree()
    {
        $data = SubscriptionComponent::getSubscriptionCookie();
        $subscription = Subscription::model()->findByAttributes(['id' => $data['subscription']]);

        $this->pageTitle = '34travel.me - Подписка';
        $this->render('step_three', [
            'subscription' => $subscription
        ]);
    }

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

            $successUrl = '/subscription/f11/step-three-payment/success';
            $cancelUrl = '/subscription/f11/step-three-payment/cancel';
            $session = StripeComponent::addSubscription($customer, $subscription, $userSubscription, $successUrl, $cancelUrl);

            $this->redirect($session->url);
        } catch (\Exception $e) {
            Yii::log("Stripe error: " . $e->getMessage(), CLogger::LEVEL_ERROR);
            throw new CHttpException(500, 'Ошибка при создании платежа.');
        }
    }

    /**
     * Step 2: Payment Success
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

                Subscription::clearSubscriptionCookies();
                $this->render('step_four_gift', [
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