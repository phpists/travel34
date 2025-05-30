<?php


class SubscriptionCommand extends CConsoleCommand
{
    /**
     * Команда зміни статусів Куплених підписок
     */
    public function actionIndex()
    {
        try {
            $currentDate = date('Y-m-d H:i:s');

            // Отримуємо підписки, які потрібно активувати
            $subscriptionsToActivate = UserSubscription::model()->findAll(
                'date_start <= :current_date AND date_end >= :current_date AND is_active = :inactive',
                [
                    ':current_date' => $currentDate,
                    ':inactive' => UserSubscription::INACTIVE, // Тільки ті, що в очікуванні
                ]
            );

            foreach ($subscriptionsToActivate as $userSubscription) {
                // Активуємо підписку
                $userSubscription->is_active = UserSubscription::ACTIVE;
                if ($userSubscription->save()) {
                    // Знаходимо відповідний тип підписки
                    $subscription = Subscription::model()->findByAttributes(['id' => $userSubscription['subscription_id']]);
                    SubscriptionComponent::sendUserSubscriptionEmail($userSubscription, $subscription);
                }
            }

            // Деактивуємо підписки, якщо поточна дата вийшла за межі date_end
            $expiredSubscriptions = UserSubscription::model()->findAll(
                'date_end < :current_date AND is_active = :active',
                [
                    ':current_date' => $currentDate,
                    ':active' => UserSubscription::ACTIVE, // Тільки активні підписки
                ]
            );

            foreach ($expiredSubscriptions as $userSubscription) {
                $userSubscription->is_active = UserSubscription::EXPIRED;
                $userSubscription->save();
                // !!! Надсилаємо email про закінчення підписки
            }

            // Перевіряємо підписки, які ще не почалися, і змінюємо їх статус на INACTIVE
            $subscriptionsToPending = UserSubscription::model()->findAll(
                'date_start > :current_date AND is_active != :inactive',
                [
                    ':current_date' => $currentDate,
                    ':inactive' => UserSubscription::INACTIVE, // Тільки ті, що ще не почались і не в статусі "INACTIVE"
                ]
            );

            foreach ($subscriptionsToPending as $userSubscription) {
                $userSubscription->is_active = UserSubscription::INACTIVE;
                $userSubscription->save();
                // !!! Надсилаємо email користувачу про те, що підписка буде активована після попередньої
            }

            echo "OK!\n";
        } catch (\Exception $e) {
            Yii::log("Ошибка: " . $e->getMessage(), CLogger::LEVEL_ERROR);
        }
    }
}