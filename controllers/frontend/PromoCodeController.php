<?php


class PromoCodeController extends FrontEndController
{

    public function actionActivatePromoCode()
    {
        $user = Yii::app()->userComponent->getUser();
        $criteria = new CDbCriteria([
            'condition' => 'LOWER(promo_code) = :promo_code AND status_id = :status_id AND available_activations > :available_activations',
            'params' => [
                ':promo_code' => strtolower($_POST['promo']),
                ':status_id' => UserSubscriptionGift::ACTIVE,
                ':available_activations' => 0
            ],
        ]);

        $promo = PromoCode::model()->find($criteria);
        if (empty($promo)) {
            Yii::app()->user->setFlash('error', 'Промокод не найден или уже использован!');
            $this->redirect(Yii::app()->request->urlReferrer);
        }

        $userPromoCode = UserPromoCodes::model()->findByAttributes([
            'promo_code_id' => $promo->id,
            'user_id' => $user->id
        ]);
        if (isset($userPromoCode)) {
            Yii::app()->user->setFlash('error', 'Промокод уже использован.');
            $this->redirect(Yii::app()->request->urlReferrer);
        }


        $data = SubscriptionComponent::getSubscriptionCookie();
        $discount = UserPromoCodes::getDiscount($data['subscription'], $promo);

        $userPromoCode = new UserPromoCodes();
        $userPromoCode->user_id = $user->id;
        $userPromoCode->promo_code_id = $promo->id;
        $userPromoCode->subscription_id = $data['subscription'];
        $userPromoCode->price_discount = $discount;

        if ($userPromoCode->save()) {
            $promo->available_activations = $promo->checkAvailableActivations();
            $promo->update();

            SubscriptionComponent::updateSubscriptionCookie('discount', $discount);
        }


        Yii::app()->user->setFlash('success', 'Промокод применен!');
        $this->redirect(Yii::app()->request->urlReferrer);
    }
}

