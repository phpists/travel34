<?php


class SubscriptionComponent extends CApplicationComponent
{
    /**
     * @return array|mixed
     */
    public static function getSubscriptionCookie()
    {
        $cookies = Yii::app()->request->cookies;
        $subscriptionData = isset($cookies['subscription']) ? json_decode($cookies['subscription']->value, true) : array();

        return $subscriptionData;
    }

    public static function getGuideSubscriptionUrl()
    {
        if (Yii::app()->userComponent->isAuthenticated()) {
            $url = Yii::app()->createUrl('/subscription/f3/step-one');
        } else {
            $url = Yii::app()->createUrl('/subscription/f2/save-step-one');
        }

        return $url;
    }

    /**
     * Збереження підписки користувача
     * @param $user
     * @param $subscription
     * @return UserSubscription
     * @throws CException
     */
    public static function createUserSubscription($user, $subscription, $statusId = UserSubscription::NEW)
    {
        $data = SubscriptionComponent::getSubscriptionCookie();
        $existingSubscription = UserSubscription::model()->findByAttributes([
            'user_id' => $user->id,
            'status_id' => UserSubscription::SUCCESS,
            'subscription_type' => UserSubscription::MYSELF,
        ], [
            'order' => 'id DESC'
        ]);

        if ($existingSubscription) {
            $subscriptionDate = $subscription->getSubscriptionDates($existingSubscription['date_start'], $existingSubscription['date_end']);

            UserSubscription::model()->updateAll(
                ['is_auto_renewal' => 0],
                'user_id = :user_id AND subscription_type != :subscription_type',
                [
                    ':subscription_type' => UserSubscription::MYSELF,
                    ':user_id' => isset($user) ? $user->id : null,
                ]
            );

            $newSubscription = new UserSubscription();
            $newSubscription->user_id = isset($user) ? $user->id : null;
            $newSubscription->subscription_id = $subscription->id;
            $newSubscription->status_id = $statusId;
            $newSubscription->subscription_type = $data['type'];
            $newSubscription->date_start = $subscriptionDate['date_start'];
            $newSubscription->date_end = $subscriptionDate['date_end'];
            $newSubscription->created_at = date('Y-m-d H:i:s');
            $newSubscription->updated_at = date('Y-m-d H:i:s');
            $newSubscription->position = $existingSubscription->position + 1;
            $newSubscription->is_active = UserSubscription::INACTIVE;
            $newSubscription->is_auto_renewal = UserSubscription::ACTIVE;
            $newSubscription->save();

            return $newSubscription;
        }
        $subscriptionDate = $subscription->getSubscriptionDates();

        $userSubscription = new UserSubscription();
        $userSubscription->user_id = isset($user) ? $user->id : null;
        $userSubscription->subscription_id = $subscription->id;
        $userSubscription->status_id = $statusId;
        $userSubscription->subscription_type = $data['type'];
        $userSubscription->date_start = $subscriptionDate['date_start'];
        $userSubscription->date_end = $subscriptionDate['date_end'];
        $userSubscription->created_at = date('Y-m-d H:i:s');
        $userSubscription->updated_at = date('Y-m-d H:i:s');
        $userSubscription->position = 1;
        $userSubscription->is_active = UserSubscription::ACTIVE;
        $userSubscription->is_auto_renewal = UserSubscription::ACTIVE;

        if (!$userSubscription->save()) {
            throw new CException('Не вдалося створити нову підписку.');
        }

        return $userSubscription;
    }

    /**
     * Get Code
     * @return string
     * @throws Exception
     */
    public static function getGiftCode()
    {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $length = 6;
        $promocode = '';

        for ($i = 0; $i < $length; $i++) {
            $promocode .= $characters[random_int(0, strlen($characters) - 1)];
        }

        return $promocode;
    }

    /**
     * Email оформлення підписки
     * @param $userSubscription
     * @param $subscription
     * @throws CException
     * @throws phpmailerException
     */
    public static function sendUserSubscriptionEmail($userSubscription, $subscription)
    {
        try {
            $data = SubscriptionComponent::getSubscriptionCookie();
            $user = User::model()->findByAttributes(['id' => $userSubscription->user_id]);
            $template = EmailTemplate::getEmailTemplate(EmailTemplate::USER_SUBSCRIPTION_EMAIL);

            $price = isset($data['discount']) ? $data['discount'] : $subscription->price;

            $templateDescription = str_replace('@subscription', $subscription->title, $template->description);
            $templateDescription = str_replace('@date_payment', date('d.m.Y'), $templateDescription);
            $templateDescription = str_replace('@transactionId', '#' . $userSubscription->id, $templateDescription);
            $templateDescription = str_replace('@price', '€' . $price, $templateDescription);
            $templateDescription = str_replace('@date_end', $userSubscription->date_end, $templateDescription);

            $status = EmailService::sendEmail($user->email, $template->subject, $templateDescription);

            if (!$status) {
                Yii::app()->user->setFlash('email', 'Не удалось отправить письмо для оформления подписки.');
            }
        } catch (\Exception $e) {
            Yii::log("User subscription error: " . $e->getMessage(), CLogger::LEVEL_ERROR);
        }
    }

    /**
     * Email Подписка в подарок (дарителю)
     */
    public static function sendParentSubscriptionGift($userSubscription, $subscription)
    {
        try {
            $data = SubscriptionComponent::getSubscriptionCookie();
            $template = EmailTemplate::getEmailTemplate(EmailTemplate::PARENT_SUBSCRIPTION_GIFT);
            $giftSubscription = UserSubscriptionGift::model()->findByAttributes(['id' => $data['gift_id']]);

            $price = isset($data['discount']) ? $data['discount'] : $subscription->price;

            $templateDescription = str_replace('@type', $subscription->title, $template->description);
            $templateDescription = str_replace('@date_create', date('d.m.Y'), $templateDescription);
            $templateDescription = str_replace('@price', '€' . $price, $templateDescription);
            $templateDescription = str_replace('@code', $giftSubscription->code, $templateDescription);

            $status = EmailService::sendEmail($giftSubscription->user_email, $template->subject, $templateDescription);

            if (!$status) {
                Yii::app()->user->setFlash('email', 'Не удалось отправить письмо. Попробуйте еще раз.');
            }
        } catch (\Exception $e) {
            Yii::log("User subscription error: " . $e->getMessage(), CLogger::LEVEL_ERROR);
        }
    }

    /**
     * Email Подписка в подарок (получателю)
     */
    public static function sendClientSubscriptionGift($giftSubscription)
    {
        try {
            $template = EmailTemplate::getEmailTemplate(EmailTemplate::CLIENT_SUBSCRIPTION_GIFT);

            $loginLink = Yii::app()->createAbsoluteUrl('/login');
            $registerLink = Yii::app()->createAbsoluteUrl('/registration');

            $templateDescription = str_replace('@loginLink', "<a href='" . $loginLink . "'>ссылке</a>", $template->description);
            $templateDescription = str_replace('@registerLink', "<a href='" . $registerLink . "'>ссылке</a>", $templateDescription);
            $templateDescription = str_replace('@code', $giftSubscription->code, $templateDescription);

            $status = EmailService::sendEmail($giftSubscription->gift_email, $template->subject . ' 🎁', $templateDescription);

            if ($status) {
                file_put_contents(Yii::app()->runtimePath . '/custom.log', 'Лист з подарованою підпискою відправлений: ' . $giftSubscription->gift_email . '\n', FILE_APPEND);
            } else {
                Yii::app()->user->setFlash('email', 'Не удалось отправить письмо. Попробуйте еще раз.');
            }
        } catch (\Exception $e) {
            file_put_contents(Yii::app()->runtimePath . '/custom.log', "Помилка відправлення листа: " . $e->getMessage() . "\n", FILE_APPEND);
        }
    }

    /**
     * Підтвердження реєстрації
     * @param $action
     * @param $email
     * @param $userId
     * @throws CException
     * @throws phpmailerException
     */
    public static function sendConfirmationEmail($action, $email, $userId)
    {
        $encryptedUserId = EmailService::encrypt($userId);
        $confirmationLink = Yii::app()->createAbsoluteUrl($action, [
            'token' => $encryptedUserId,
            'email' => $email,
        ]);

        $template = EmailTemplate::getEmailTemplate(EmailTemplate::REGISTER_CONFIRM_EMAIL);
        $templateDescription = str_replace('@link', $confirmationLink, $template->description);

        $status = EmailService::sendEmail($email, $template->subject, $templateDescription);

        if (!$status) {
            Yii::app()->user->setFlash('email', 'Не удалось отправить письмо с подтверждением. Попробуйте еще раз.');
        }
    }

    /**
     * Скидання паролю
     * @param $url
     * @param $email
     * @param $userId
     * @param $flow
     * @throws CException
     * @throws phpmailerException
     */
    public static function sendResetPasswordEmail($url, $email, $userId, $flow)
    {
        $encryptedUserId = EmailService::encrypt($userId);

        $confirmationLink = Yii::app()->createAbsoluteUrl($url, [
            'token' => $encryptedUserId,
            'email' => $email,
            'flow' => $flow,
        ]);

        $template = EmailTemplate::getEmailTemplate(EmailTemplate::FORGOT_PASSWORD_CONFIRM_EMAIL);
        $templateDescription = str_replace('@link', $confirmationLink, $template->description);

        $status = EmailService::sendEmail($email, $template->subject, $templateDescription);

        if (!$status) {
            Yii::app()->user->setFlash('email', 'Не удалось отправить письмо восстановление пароля. Попробуйте еще раз.');
        }
    }

    /**
     * Отмена подписки
     * @param $email
     * @throws CException
     * @throws phpmailerException
     */
    public static function sendUnsubscribeEmail($email)
    {
        $link = Yii::app()->createAbsoluteUrl('/');
        $template = EmailTemplate::getEmailTemplate(EmailTemplate::CANCEL_SUBSCRIPTION);
        $templateDescription = str_replace('@link', $link, $template->description);

        $status = EmailService::sendEmail($email, $template->subject, $templateDescription);

        if (!$status) {
            Yii::app()->user->setFlash('email', 'Не удалось отправить письмо с подтверждением. Попробуйте еще раз.');
        }
    }

    /**
     * Удаление аккаунта
     * @param $email
     * @throws CException
     * @throws phpmailerException
     */
    public static function sendAccountDeleteEmail($email)
    {
        $link = Yii::app()->createAbsoluteUrl('/');
        $template = EmailTemplate::getEmailTemplate(EmailTemplate::ACCOUNT_DELETE);
        $templateDescription = str_replace('@link', $link, $template->description);

        $status = EmailService::sendEmail($email, $template->subject, $templateDescription);

        if (!$status) {
            Yii::app()->user->setFlash('email', 'Не удалось отправить письмо с подтверждением. Попробуйте еще раз.');
        }
    }

    /**
     * Оновлення кук підписки
     * @param string $key
     * @param $value
     */
    public static function updateSubscriptionCookie(string $key, $value): void
    {
        $cookies = Yii::app()->request->cookies;

        $subscriptionData = isset($cookies['subscription'])
            ? json_decode($cookies['subscription']->value, true)
            : [];

        $subscriptionData[$key] = $value;

        $cookies['subscription'] = new CHttpCookie('subscription', json_encode($subscriptionData));
    }

    /**
     * Отримання кук по Id
     * @param string $key
     * @return mixed|null
     */
    public static function getSubscriptionCookieValue(string $key)
    {
        $cookies = Yii::app()->request->cookies;

        if (!isset($cookies['subscription'])) {
            return null;
        }

        $subscriptionData = json_decode($cookies['subscription']->value, true);

        return $subscriptionData[$key] ?? null;
    }

}