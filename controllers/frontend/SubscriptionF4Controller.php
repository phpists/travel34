<?php

use Stripe\Checkout\Session;
use Stripe\Customer;

class SubscriptionF4Controller extends FrontEndController
{
    /**
     * Step 1
     */
    public function actionStepOne()
    {
        $this->pageTitle = '34travel.me - Подписка';
        Subscription::clearSubscriptionCookies();

        $this->render('step_one');
    }

    /**
     * Step 1: save
     */
    public function actionSaveStepOne()
    {
        $this->pageTitle = '34travel.me - Подписка';
        if (isset($_POST['subscription']) && isset($_POST['type'])) {
            $subscription = $_POST['subscription'];
            $type = $_POST['type'];

            $subscriptionData = [
                'subscription' => $subscription,
                'type' => $type,
                'redirect_url' => Yii::app()->createAbsoluteUrl('/'),
                'subscription_text' => $_POST['subscription_text'],
                'subscription_type_text' => $_POST['subscription_type_text'],
            ];

            $cookies = Yii::app()->request->cookies;
            $cookies['subscription'] = new CHttpCookie('subscription', json_encode($subscriptionData));

            if ($type == Subscription::MYSELF) {
                $url = '/subscription/f4/step-two';
            } else {
                $url = '/subscription/f4/step-two-auth-gift';
            }

            return $this->renderJSON([
                'url' => $url,
                'params' => $subscriptionData
            ]);
        }

        return $this->renderJSON([
            'url' => Yii::app()->request->urlReferrer,
        ]);
    }

    public function actionStepTwoAuthGift()
    {
        $this->render('step_two_auth_gift');
    }

    /**
     * Step 2
     */
    public function actionStepTwo()
    {
        $this->pageTitle = '34travel.me - Подписка';
        $cookies = Yii::app()->request->cookies;
        if (isset($cookies['subscription'])) {
            $subscriptionData = json_decode($cookies['subscription']->value, true);

            if (!empty($subscriptionData['subscription'])) {
                $data = SubscriptionComponent::getSubscriptionCookie();
                $subscription = Subscription::model()->findByAttributes(['id' => $data['subscription']]);

                if ($data['type'] == Subscription::MYSELF) {
                    $this->render('step_two', ['subscription' => $subscription]);
                } else {
                    $this->render('step_two_gift', ['type' => $data['type']]);
                }
            }
        }

        $this->redirect(Yii::app()->request->urlReferrer);
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

            $successUrl = '/subscription/f4/step-three-payment/success';
            $cancelUrl = '/subscription/f4/step-three-payment/cancel';
            $session = StripeComponent::addSubscription($customer, $subscription, $userSubscription, $successUrl, $cancelUrl);

            $this->redirect($session->url);
        } catch (\Exception $e) {
            Yii::log("Помилка оплати: " . $e->getMessage(), CLogger::LEVEL_ERROR);
            throw new CHttpException(500, 'Ошибка при создании платежа.');
        }
    }

    /**
     * Step 3: Payment
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
                $this->render('step_three', [
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

        try {
            $sessionId = Yii::app()->request->getParam('session_id');
            if ($sessionId) {
                $userSubscriptionId = $_GET['user_subscription_id'];
                StripeComponent::paymentCancel($userSubscriptionId);

                $this->redirect('/subscription/payment-cancel');
            }

        } catch (\Exception $e) {
            Yii::log("Помилка оплати cancel: " . $e->getMessage(), CLogger::LEVEL_ERROR);
            throw new CHttpException(500, 'Ошибка при создании платежа.');
        }
    }

}