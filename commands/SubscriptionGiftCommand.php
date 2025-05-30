<?php


class SubscriptionGiftCommand extends CConsoleCommand
{
    /**
     * Команда відправлення на пошту подарованих підписок
     */
    public function actionIndex()
    {
        date_default_timezone_set('Europe/Vilnius');
        $currentDate = date('Y-m-d');
        $currentTime = date('H:i:00');

        file_put_contents(Yii::app()->runtimePath . '/custom.log', "Останнє оновлення: {$currentDate} {$currentTime}\n", FILE_APPEND);

        $criteria = new CDbCriteria();
        $criteria->condition = 'gift_date = :currentDate AND gift_time >= :currentTimeStart AND gift_time < :currentTimeEnd AND status_id = :statusId';
        $criteria->params = [
            ':currentDate' => $currentDate,
            ':currentTimeStart' => date('H:i:00', strtotime('-1 minute', strtotime($currentTime))),
            ':currentTimeEnd' => date('H:i:00', strtotime('+1 minute', strtotime($currentTime))),
            ':statusId' => UserSubscriptionGift::INACTIVE,
        ];

        $giftSubscriptions = UserSubscriptionGift::model()->findAll($criteria);

        if (!empty($giftSubscriptions)) {
            foreach ($giftSubscriptions as $subscription) {
                $subscription->status_id = UserSubscriptionGift::SEND_CLIENT; // Позначаємо як оброблену

                if ($subscription->save()) {
                    $template = EmailTemplate::getEmailTemplate(EmailTemplate::CLIENT_SUBSCRIPTION_GIFT);

                    $encryptedId = UserSubscriptionGift::encryptId($subscription->id);
                    $loginLink = 'http://34t.farbatest.com/activate-gift?token=' . urlencode($encryptedId);
                    $registerLink = 'http://34t.farbatest.com/registration';

                    $templateDescription = str_replace('@loginLink', "<a href='" . $loginLink . "'>ссылке</a>", $template->description);
                    $templateDescription = str_replace('@registerLink', "<a href='" . $registerLink . "'>ссылке</a>", $templateDescription);
                    $templateDescription = str_replace('@code', $subscription->code, $templateDescription);

                    $status = EmailService::sendEmail($subscription->gift_email, $template->subject . ' 🎁', $templateDescription);

                    if ($status) {
                        file_put_contents(Yii::app()->runtimePath . '/custom.log', 'Лист з подарованою підпискою відправлений: ' . $subscription->gift_email . '\n', FILE_APPEND);
                    } else {
                        file_put_contents(Yii::app()->runtimePath . '/custom.log', 'Помилка відправлення листа з подарованою підпискою : ' . $subscription->gift_email . '\n', FILE_APPEND);
                    }
                } else {
                    file_put_contents(Yii::app()->runtimePath . '/custom.log', "Помилка збереження: " . "\n", FILE_APPEND);
                }
            }
        } else {
            file_put_contents(Yii::app()->runtimePath . '/custom.log', "Немає підписок для відправлення\n", FILE_APPEND);
        }

        $this->sendOnboardingEmails();
        $this->updateSubscriptionEndDate();
    }

    /**
     * Відправка листів Onboarding
     */
    public function sendOnboardingEmails()
    {
        $users = User::model()->findAllByAttributes([
            'is_verification' => true,
            'is_send_onboarding' => false,
        ]);

        if ($users) {
            foreach ($users as $user) {
                try {
                    $template = EmailTemplate::getEmailTemplate(EmailTemplate::ONBORDING_EMAIL);
                    $status = EmailService::sendEmail($user->email, $template->subject, $template->description);

                    if ($status) {
                        $user->is_send_onboarding = 1; // true

                        if ($user->save()) {
                            file_put_contents(Yii::app()->runtimePath . '/custom.log', "Send_onboarding to user ID: {$user->id}\n", FILE_APPEND);
                        } else {
                            $errors = print_r($user->getErrors(), true);
                            Yii::log("Failed to update user ID: {$user->id}. Errors: $errors", CLogger::LEVEL_ERROR);
                        }
                    }
                } catch (\Exception $e) {
                    Yii::log("Send email error for user ID: {$user->id}, email: {$user->email}. Error: " . $e->getMessage(), CLogger::LEVEL_ERROR);
                }
            }
        } else {
            Yii::log("No users found for onboarding.", CLogger::LEVEL_INFO);
        }
    }

    /**
     * Оновлення терміну роботи підписок
     */
    public function updateSubscriptionEndDate()
    {
        try {
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
        } catch (\Stripe\Exception\ApiErrorException $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
}