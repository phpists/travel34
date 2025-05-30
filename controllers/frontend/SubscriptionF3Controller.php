<?php

use Stripe\Checkout\Session;
use Stripe\Customer;

class SubscriptionF3Controller extends FrontEndController
{
    /**
     * Step 1
     */
    public function actionStepOne()
    {
        $this->pageTitle = '34travel.me - Подписка';
        Subscription::clearSubscriptionCookies();

        if (isset($_POST['subscription'])) {
            $subscription = $_POST['subscription'];

            $subscriptionData = [
                'subscription' => $subscription,
                'type' => Subscription::MYSELF,
                'redirect_url' => Yii::app()->request->urlReferrer,
                'subscription_text' => $_POST['subscription_text'],
                'subscription_type_text' => $_POST['subscription_type_text'],
            ];

            $cookies = Yii::app()->request->cookies;
            $cookies['subscription'] = new CHttpCookie('subscription', json_encode($subscriptionData));

            return $this->renderJSON([
                'url' => '/subscription/f3/show-step-one',
                'params' => $subscriptionData
            ]);
        }

        $this->redirect(Yii::app()->request->urlReferrer);
    }

    public function actionShowStepOne()
    {
        $cookies = Yii::app()->request->cookies;
        if (isset($cookies['subscription'])) {
            $data = SubscriptionComponent::getSubscriptionCookie();

            $this->render('step_one', ['type' => $data['type']]);
        }

        $this->redirect(Yii::app()->request->urlReferrer);
    }

    /**
     * Step 1: save
     */
    public function actionSaveStepOne()
    {
        $cookies = Yii::app()->request->cookies;
        if (isset($cookies['subscription'])) {
            $this->redirect('/subscription/f3/step-two');
        }

        $this->redirect(Yii::app()->request->urlReferrer);
    }

    public function actionStepTwo()
    {
        $this->pageTitle = '34travel.me - Подписка';
        $cookies = Yii::app()->request->cookies;
        if (isset($cookies['subscription'])) {
            $subscriptionData = json_decode($cookies['subscription']->value, true);

            if (!empty($subscriptionData['subscription'])) {
                return $this->renderJSON([
                    'url' => '/subscription/f3/show-step-two',
                ]);
            }
        }

        $this->redirect(Yii::app()->request->urlReferrer);
    }

    public function actionShowStepTwo()
    {
        $data = SubscriptionComponent::getSubscriptionCookie();
        $subscription = Subscription::model()->findByAttributes(['id' => $data['subscription']]);
        $this->render('step_two', ['subscription' => $subscription]);
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

            $successUrl = '/subscription/f3/step-three-payment/success';
            $cancelUrl = '/subscription/f3/step-three-payment/cancel';
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

        $sessionId = Yii::app()->request->getParam('session_id');
        if ($sessionId) {
            $userSubscription = UserSubscription::model()->findByPk($_GET['user_subscription_id']);
            $userSubscription->status_id = UserSubscription::ERROR;
            $userSubscription->save();

            Yii::app()->user->setFlash('email', 'Ошибка оплаты.');

            $this->redirect('/subscription/payment-cancel');
        }
    }

}