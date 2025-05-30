<?php


use Stripe\Checkout\Session;
use Stripe\PaymentIntent;
use Stripe\Stripe;
use Stripe\Webhook;

class SubscriptionController extends FrontEndController
{
    public function actionStripeWebhook()
    {
//        $endpoint_secret = 'whsec_ZBodAMkCXatU0znJOYhPRZSnsm1lLiAi';
        $endpoint_secret = 'whsec_bY1I0JTpJfnW2SfNlIYJFVAywgTrZ7mC';  // https://34t.farbatest.com

        $payload = @file_get_contents('php://input');
        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
        $event = null;

        try {
            $event = Webhook::constructEvent($payload, $sig_header, $endpoint_secret);

            if ($event['type'] === 'invoice.payment_succeeded') {
                $session = $event['data']['object'];

                $subscription_id = $session['subscription'];
                $userSubscription = UserSubscription::model()->findByAttributes([
                    'subscription_code' => $subscription_id
                ]);

                if ($userSubscription) {
                    $userSubscription->status_id = UserSubscription::SUCCESS;
                    if ($userSubscription->update()) {
                        file_put_contents('webhook_log.txt', date('Y-m-d H:i') . " ok \n", FILE_APPEND);
                    } else {
                        file_put_contents('webhook_log.txt', date('Y-m-d H:i') . " not ok \n", FILE_APPEND);
                    }
                }
            }

        } catch (\UnexpectedValueException $e) {
            http_response_code(400);
            exit();
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            http_response_code(400);
            exit();
        }

        return $this->renderJSON([
            'status' => true,
        ]);
    }

    public function actionGooglePay()
    {
        try {
            $input = file_get_contents('php://input');
            $data = json_decode($input, true);

            $paymentIntent = \Stripe\PaymentIntent::create([
                'amount' => 1000, // Сума у центах (10.00 USD)
                'currency' => 'usd',
                'payment_method' => $data['payment_method'],
                'confirmation_method' => 'manual',
                'confirm' => true,
            ]);

            echo json_encode(['success' => true]);
        } catch (\Stripe\Exception\ApiErrorException $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    public function actionTest()
    {
//        $email = $_GET['email'] ?? 'andy.tsyupa@gmail.com';
//
//        /* FINAL_FAILED_PAYMENT */
//        $accountLink = Yii::app()->createAbsoluteUrl('profile/account');
//        $template = EmailTemplate::getEmailTemplate(EmailTemplate::FINAL_FAILED_PAYMENT);
//        $templateDescription = str_replace('@order_id', 1111, $template->description);
//        $templateDescription = str_replace('@account_link', $accountLink, $templateDescription);
//
//        EmailService::sendEmail($email, $template->subject, $templateDescription);
//
//        /* NEXT_WRITE_OFF_MONTH */
//        $accountLink = Yii::app()->createAbsoluteUrl('profile/account');
//        $template = EmailTemplate::getEmailTemplate(EmailTemplate::NEXT_WRITE_OFF_MONTH);
//        $templateDescription = str_replace('@order_id', 2222, $template->description);
//        $templateDescription = str_replace('@price', '$' . 49, $templateDescription);
//        $templateDescription = str_replace('@old_price', '$' . 60, $templateDescription);
//        $templateDescription = str_replace('@date', date('Y-m-d'), $templateDescription);
//        $templateDescription = str_replace('@percent', 10, $templateDescription);
//        $templateDescription = str_replace('@account_link', $accountLink, $templateDescription);
//
//        EmailService::sendEmail($email, $template->subject, $templateDescription);
//
//        /* NEXT_WRITE_OFF_YEAR */
//        $accountLink = Yii::app()->createAbsoluteUrl('profile/account');
//        $template = EmailTemplate::getEmailTemplate(EmailTemplate::NEXT_WRITE_OFF_YEAR);
//        $templateDescription = str_replace('@order_id', 3333, $template->description);
//        $templateDescription = str_replace('@price', '$' . 49, $templateDescription);
//        $templateDescription = str_replace('@old_price', '$' . 60, $templateDescription);
//        $templateDescription = str_replace('@date', date('Y-m-d'), $templateDescription);
//        $templateDescription = str_replace('@account_link', $accountLink, $templateDescription);
//
//        EmailService::sendEmail($email, $template->subject, $templateDescription);
//
//        /* CONFIRMATION_WRITE_OFF_CHECK */
//        $template = EmailTemplate::getEmailTemplate(EmailTemplate::CONFIRMATION_WRITE_OFF_CHECK);
//        $templateDescription = str_replace('@order_id', 4444, $template->description);
//        $templateDescription = str_replace('@price', '$' . 49, $templateDescription);
//        $templateDescription = str_replace('@date', date('Y-m-d'), $templateDescription);
//        $templateDescription = str_replace('@subscription', 'Месячная', $templateDescription);
//
//        EmailService::sendEmail($email, $template->subject . ' №' . 4444, $templateDescription);


        $currentDate = date('Y-m-d H:i:s');
        $userSubscriptions = UserSubscription::model()->findAll(
            'status_id = :status_id AND is_active = :is_active AND is_auto_renewal = :is_auto_renewal AND date_end <= :date_end',
            [
                ':status_id' => UserSubscription::SUCCESS,
                ':is_active' => UserSubscription::ACTIVE,
                ':date_end' => $currentDate,
                ':is_auto_renewal' => UserSubscription::ACTIVE
            ]
        );

        if ($userSubscriptions) {
            foreach ($userSubscriptions as $userSubscription) {
                $user = User::model()->findByAttributes(['id' => $userSubscription['user_id']]);
                $subscription = Subscription::model()->findByAttributes(['id' => $userSubscription['subscription_id']]);
                $subscriptionDate = $subscription->getSubscriptionDates($userSubscription['date_start'], $userSubscription['date_end']);

                StripeComponent::initialize();
                $amount = $subscription->price * 100;
                $paymentIntent = PaymentIntent::create([
                    'amount' => $amount,
                    'currency' => 'eur',
                    'customer' => $userSubscription->customer_id,
                    'payment_method' => $userSubscription->payment_method_id,
                    'off_session' => true,
                    'confirm' => true,
                ]);

                if ($paymentIntent) {
                    $history = new UserSubscriptionHistory();
                    $history->user_id = $userSubscription->user_id;
                    $history->user_subscription_id = $userSubscription->id;
                    $history->subscription_id = $userSubscription->subscription_id;
                    $history->status_id = true;
                    $history->date_start = $subscriptionDate['date_start'];
                    $history->date_end = $subscriptionDate['date_end'];

                    if ($history->save()) {
                        $userSubscription->date_start = $subscriptionDate['date_start'];
                        $userSubscription->date_end = $subscriptionDate['date_end'];
                        $userSubscription->update();

                        /* CONFIRMATION_WRITE_OFF_CHECK */
                        $template = EmailTemplate::getEmailTemplate(EmailTemplate::CONFIRMATION_WRITE_OFF_CHECK);
                        $templateDescription = str_replace('@order_id', $userSubscription->id, $template->description);
                        $templateDescription = str_replace('@price', '$' . $amount, $templateDescription);
                        $templateDescription = str_replace('@date', date('Y-m-d'), $templateDescription);
                        $templateDescription = str_replace('@subscription', $subscription->title, $templateDescription);
                        EmailService::sendEmail($user->email, $template->subject . ' №' . $userSubscription->id, $templateDescription);
                    }
                }
            }
        }


        echo 1;
    }

    private function processGift($subscription)
    {
        SubscriptionComponent::sendClientSubscriptionGift($subscription);
    }

    public function actionCancelPaymentPage()
    {
        $this->render('cancel_payment_page');
    }

}