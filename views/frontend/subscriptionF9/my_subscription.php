<div class="post-body" style="background-color: #E2E2E2 !important;">
    <div class="container-wide container-form">
        <div class="wide-box">
            <h1 class="post-title">Управление подпиской</h1>
            <div class="form_wrap">
                <div class="form_wrap_inside">
                    <div class="form_header form_header_margin">Моя подписка</div>
                    <div class="form_text_line"><?= $subscription['title'] ?></div>
                    <div class="form_section form__info_wrap">
                        <div class="form__label form__label_black form_date_wrap">
                            <span class="form__info_text">Дата начала подписки:</span>
                            <span><?= Subscription::getSubscriptionStartDate($userSubscription['date_start']) ?></span>
                        </div>
                        <div class="form__label form__label_black form_status_wrap">
                            <span class="form__info_text">Статус подписки:</span>
                            <?php if ($userSubscription['is_active'] == UserSubscription::CANCELED): ?>
                                <span class="form_error"><?= $userSubscription->getSubscriptionStatus() ?></span>
                            <?php else: ?>
                                <span class="form_status"><?= $userSubscription->getSubscriptionStatus() ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="form__label form__label_black form_ordernum_wrap">
                            <span class="form__info_text">Номер заказа</span>
                            <span>#<?= $userSubscription['id'] ?></span>
                        </div>
                    </div>
                    <a href="<?= $this->createUrl('subscription/f9/step-one') ?>" class="form_link">Изменить план</a>
                </div>
            </div>
        </div>
    </div>
</div>