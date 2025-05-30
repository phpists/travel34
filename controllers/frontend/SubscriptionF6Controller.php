<?php

use Stripe\Checkout\Session;
use Stripe\Customer;

class SubscriptionF6Controller extends FrontEndController
{
    public function actionSaveStepThreeGift()
    {
        $email = $_POST['email'];
        $emailConfirm = $_POST['email_confirm'];
        $parentEmail = $_POST['parent_email'];
        $date = $_POST['date'];
        $time = $_POST['time'];

        if ($email !== $emailConfirm) {
            Yii::app()->user->setFlash('email', 'Введенные адреса не совпадают. Проверь, нет ли опечатки, и попробуй еще раз.');
            $this->redirect(Yii::app()->request->urlReferrer);
        }

        if (EmailService::validateGmailEmail($parentEmail)) {
            Yii::app()->user->setFlash('parent_email', 'Пожалуйста, введи корректный e-mail.');
            $this->redirect('/subscription/f4/step-two-auth-gift');
        }

        $gift = new UserSubscriptionGift();
        $gift->user_email = $parentEmail;
        $gift->gift_email = $email;
        $gift->gift_date = date('Y-m-d', strtotime($date));
        $gift->gift_time = $time;
        $gift->status_id = UserSubscriptionGift::INACTIVE;
        $gift->code = SubscriptionComponent::getGiftCode();

        if ($gift->save()) {
            $cookies = Yii::app()->request->cookies;
            $subscriptionData = isset($cookies['subscription']) ? json_decode($cookies['subscription']->value, true) : [];
            $subscriptionData['gift_id'] = $gift->id;
            $subscriptionData['gift_date'] = $date;
            $subscriptionData['email'] = $parentEmail;
            $cookies['subscription'] = new CHttpCookie('subscription', json_encode($subscriptionData));

            $this->redirect('/subscription/f1/step-three');
        }

        Yii::app()->user->setFlash('email', 'Неверно заполненные данные..');
        $this->redirect(Yii::app()->request->urlReferrer);
    }
}