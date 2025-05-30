<?php

use Stripe\Checkout\Session;
use Stripe\Customer;

class SubscriptionF9Controller extends FrontEndController
{
    /**
     * Step: 0 Update My Subscription
     */
    public function actionUpdateSubscription()
    {
        $this->pageTitle = '34travel.me - Подписка';
        if (Yii::app()->request->getParam('subscription')) {
            $user = Yii::app()->userComponent->getUser();
            $subscriptionId = Yii::app()->request->getParam('subscription');
            $userSubscription = UserSubscription::model()->find([
                'condition' => 'id = :id AND user_id = :user_id',
                'params' => [
                    ':id' => $subscriptionId,
                    ':user_id' => $user['id'],
                ],
            ]);

            $subscription = Subscription::model()->findByAttributes([
                'id' => $userSubscription->subscription_id,
            ]);
        }

        if (empty($userSubscription)) {
            $this->redirect(Yii::app()->request->urlReferrer);
        }

        $this->render('my_subscription', [
            'subscription' => $subscription,
            'userSubscription' => $userSubscription
        ]);
    }

    /**
     * Step: 1
     */
    public function actionStepOne()
    {
        Subscription::clearSubscriptionCookies();
        $this->pageTitle = '34travel.me - Подписка';
        $this->render('step_one');
    }

    /**
     * Step 1: save
     */
    public function actionSaveStepOne()
    {
        if (isset($_POST['subscription']) && isset($_POST['type'])) {
            $subscription = $_POST['subscription'];
            $type = $_POST['type'];

            $subscriptionData = [
                'subscription' => $subscription,
                'type' => $type,
                'redirect_url' => '/profile/account'
            ];

            $cookies = Yii::app()->request->cookies;
            $cookies['subscription'] = new CHttpCookie('subscription', json_encode($subscriptionData));

            $this->redirect('/subscription/f9/step-two');
        }

        $this->redirect(Yii::app()->request->urlReferrer);
    }

    /**
     * Step 2
     */
    public function actionStepTwo()
    {
        $cookies = Yii::app()->request->cookies;
        if (isset($cookies['subscription'])) {
            $subscriptionData = json_decode($cookies['subscription']->value, true);

            if (!empty($subscriptionData['subscription'])) {
                $data = SubscriptionComponent::getSubscriptionCookie();

                if ($data['type'] == Subscription::MYSELF) {
                    $this->renderJSON([
                        'url' => '/subscription/f9/save-step-two',
                        'params' => $subscriptionData
                    ]);
                } else {
                    $this->renderJSON([
                        'url' => '/subscription/f9/step-two-auth-gift',
                        'params' => $subscriptionData
                    ]);
                }
            }
        }

        $this->redirect(Yii::app()->request->urlReferrer);
    }

    public function actionSaveStepTwo()
    {
        $data = SubscriptionComponent::getSubscriptionCookie();
        $subscription = Subscription::model()->findByAttributes(['id' => $data['subscription']]);

        $this->render('step_two', [
            'subscription' => $subscription
        ]);
    }

    public function actionStepTwoAuthGift()
    {
        $data = SubscriptionComponent::getSubscriptionCookie();

        return $this->render('step_two_auth_gift', ['type' => $data['type']]);
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

            $successUrl = '/subscription/f9/step-three-payment/success';
            $cancelUrl = '/subscription/f9/step-three-payment/cancel';
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
            $userSubscriptionId = $_GET['user_subscription_id'];
            StripeComponent::paymentCancel($userSubscriptionId);

            $this->redirect('/subscription/payment-cancel');
        }
    }
}