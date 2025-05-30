<?php


use Stripe\Checkout\Session;
use Stripe\Customer;
use Stripe\Exception\CardException;
use Stripe\PaymentIntent;
use Stripe\PaymentMethod;
use Stripe\Stripe;

class StripeComponent extends CApplicationComponent
{
    /**
     * Init
     */
    public static function initialize()
    {
        Stripe::setApiKey('KEY');
    }


    public static function addSubscription($customer, $subscription, $userSubscription, $successUrl, $cancelUrl)
    {
        $session = Session::create([
            'payment_method_types' => ['card'],
            'customer' => $customer->id,
            'mode' => 'setup',
            'success_url' => Yii::app()->createAbsoluteUrl($successUrl) . '?session_id={CHECKOUT_SESSION_ID}&user_subscription_id=' . $userSubscription->id,
            'cancel_url' => Yii::app()->createAbsoluteUrl($cancelUrl) . '?session_id={CHECKOUT_SESSION_ID}&user_subscription_id=' . $userSubscription->id,
        ]);

        return $session;
    }


    /**
     * Get PaymentMethodId
     * @param $paymentIntentId
     * @return string|PaymentMethod|null
     */
    public static function getPaymentMethodId($paymentIntentId)
    {
        StripeComponent::initialize();

        try {
            $paymentIntent = \Stripe\PaymentIntent::retrieve($paymentIntentId);
            $paymentMethodId = $paymentIntent->payment_method;

            return $paymentMethodId;
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Customer create
     * @param $email
     * @return Customer
     * @throws \Stripe\Exception\ApiErrorException
     */
    public static function createStripeCustomer($email)
    {
        $customer = Customer::create([
            'email' => $email,
        ]);

        return $customer;
    }

    /**
     * Payment Success
     * @param $sessionId
     * @return array
     * @throws CException
     * @throws \Stripe\Exception\ApiErrorException
     * @throws phpmailerException
     */
    public static function paymentSuccess($sessionId, $statusId = UserSubscription::SUCCESS)
    {
        $cookie = SubscriptionComponent::getSubscriptionCookie();

        $session = Session::retrieve($sessionId);
        $customerId = $session->customer;

        $setupIntentId = $session->setup_intent;
        $setupIntent = \Stripe\SetupIntent::retrieve($setupIntentId);

        $paymentMethodId = $setupIntent->payment_method;

        $paymentMethod = \Stripe\PaymentMethod::retrieve($paymentMethodId);
        $paymentMethod->attach(['customer' => $customerId]);

        Customer::update($customerId, [
            'invoice_settings' => [
                'default_payment_method' => $paymentMethodId,
            ],
        ]);

        $userSubscription = UserSubscription::model()->findByPk($_GET['user_subscription_id']);
        if ($userSubscription) {
            $userSubscription->customer_id = $customerId;
            $userSubscription->payment_method_id = $paymentMethodId;
            $userSubscription->status_id = $statusId;

            if ($userSubscription->save()) {
                if (isset($cookie['gift_id'])) {
                    self::updateUserSubscriptionGift($cookie['gift_id'], $userSubscription->id);
                }

                $subscription = Subscription::model()->findByPk($userSubscription['subscription_id']);
            }
        }

        return [
            'subscription' => $subscription,
            'userSubscription' => $userSubscription
        ];
    }

    /**
     * Payment Cancel
     * @param $userSubscriptionId
     */
    public static function paymentCancel($userSubscriptionId)
    {
        $userSubscription = UserSubscription::model()->findByPk($userSubscriptionId);
        if ($userSubscription) {
            $userSubscription->status_id = UserSubscription::ERROR;

            if ($userSubscription->save()) {
                $user = User::model()->findByAttributes(['id' => $userSubscription->user_id]);

                $accountLink = Yii::app()->createAbsoluteUrl('profile/account');
                $template = EmailTemplate::getEmailTemplate(EmailTemplate::FAILED_PAYMENT);
                $templateDescription = str_replace('@order_id', $userSubscription->id, $template->description);
                $templateDescription = str_replace('@account_link', $accountLink, $templateDescription);

                EmailService::sendEmail($user->email, $template->subject, $templateDescription);
            }
        }

        Yii::app()->user->setFlash('email', 'Ошибка оплаты.');
    }

    /**
     * Update user_subscription_id
     * @param $id
     * @param $userSubscriptionId
     */
    public static function updateUserSubscriptionGift($id, $userSubscriptionId)
    {
        $gift = UserSubscriptionGift::model()->findByPk($id);
        if ($gift) {
            $gift->user_subscription_id = $userSubscriptionId;
            $gift->save();
        }
    }

    /**
     * Відкладена оплата
     * @param $customerId
     * @param $paymentMethodId
     * @param $amount
     * @param string $currency
     * @return array
     */
    public static function paymentIntent($customerId, $paymentMethodId, $amount, $currency = 'eur')
    {
        StripeComponent::initialize();

        try {
            $paymentIntent = PaymentIntent::create([
                'amount' => Subscription::getSubscriptionPrice($amount),
                'currency' => $currency,
                'customer' => $customerId,
                'payment_method' => $paymentMethodId,
                'off_session' => true,
                'confirm' => true,
            ]);

            return [
                'paymentIntent' => $paymentIntent
            ];
        } catch (CardException $e) {
            return [
                'status' => 'error',
                'message' => $e->getError()->message,
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage(),
            ];
        }
    }
}