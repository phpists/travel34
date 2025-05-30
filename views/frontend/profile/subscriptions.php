<div class="form_wrap">
    <div class="form_wrap_inside">
        <div class="form_header_margin">Моя подписка</div>
        <?php if (count($userSubscriptions)): ?>
            <?php foreach ($userSubscriptions as $userSubscription): ?>
                <?php if ($userSubscription['is_active'] == UserSubscription::CANCELED): ?>
                    <div class="form_text_line"><?= $userSubscription->subscription['title'] . ' (автопродление остановлено)' ?></div>
                    <div class="form_section form__info_wrap">
                        <div class="form__label form__label_black form_date_wrap"><span class="form__info_text">Дата начала подписки:</span><span><?= Subscription::getSubscriptionStartDate($userSubscription['date_start']) ?></span>
                        </div>
                        <div class="form__label form__label_black form_status_wrap">
                            <span class="form__info_text">Статус подписки:</span>
                            <span class="form_error"><?= $userSubscription->getSubscriptionStatus() ?></span>
                        </div>
                        <div class="form__label form__label_black form_expire_wrap"><span class="form__info_text">Подписка истекает:</span><span
                                    class="form_expire"
                                    style="color: #DC1515"><?= Subscription::getSubscriptionStartDate($userSubscription['date_end']) ?></span>
                        </div>
                        <div class="form__label form__label_black form_ordernum_wrap"><span class="form__info_text">Номер заказа</span><span>#<?= $userSubscription['id'] ?></span>
                        </div>
                    </div>
                    <div class="form_section_margin">
                        <a href="<?= $this->createUrl('subscriptionF9/updateSubscription', ['subscription' => $userSubscription['id']]) ?>"
                           class="form_link">Управлять подпиской</a>
                    </div>
                <?php else: ?>
                    <div class="form_text_line"><?= $userSubscription->subscription['title'] ?><?= $userSubscription->is_auto_renewal == UserSubscription::ACTIVE ? ' (автопродление)' : '' ?></div>
                    <div class="form_section form__info_wrap">
                        <div class="form__label form__label_black form_date_wrap"><span class="form__info_text">Дата начала подписки:</span><span><?= Subscription::getSubscriptionStartDate($userSubscription['date_start']) ?></span>
                        </div>
                        <div class="form__label form__label_black form_status_wrap"><span class="form__info_text">Статус подписки:</span><span
                                    class="form_status"><?= $userSubscription->getSubscriptionStatus() ?></span></div>
                        <div class="form__label form__label_black form_expire_wrap"><span class="form__info_text">Подписка истекает:</span><span
                                    class="form_expire"><?= Subscription::getSubscriptionStartDate($userSubscription['date_end']) ?></span>
                        </div>
                        <div class="form__label form__label_black form_ordernum_wrap"><span class="form__info_text">Номер заказа</span><span>#<?= $userSubscription['id'] ?></span>
                        </div>
                    </div>
                    <div class="form_section">
                        <a href="#subscription_cancel"
                           class="form_simple_link form_short-text_left popup-with-form btnUserSubscription"
                           data-end_date="<?= Subscription::getSubscriptionStartDate($userSubscription['date_end']) ?>"
                           data-user_subscription_id="<?= $userSubscription['id'] ?>">Отменить подписку
                        </a>
                    </div>
                    <div class="form_section_margin">
                        <a href="<?= $this->createUrl('subscriptionF9/updateSubscription', ['subscription' => $userSubscription['id']]) ?>"
                           class="form_link">Управлять подпиской</a>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>

        <?php else: ?>
            <div class="form_short-text form_short-text_large form_short-text_left form_short-text_margin-big">
                У тебя еще нет активной подписки.
            </div>
            <div class="form_section_margin">
                <a href="<?= $this->createUrl('subscription/f4/step-one') ?>" class="form_link">
                    ПОДПИСАТЬСЯ
                    <svg width="13" height="24" viewBox="0 0 13 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                              d="M7.70381 12.1421L0.0634603 23.8972L4.96285 23.8972L12.6033 12.1421L4.96293 0.387119L0.0634605 0.387112L7.70381 12.1421Z"
                              fill="black"></path>
                    </svg>
                </a>
            </div>
        <?php endif; ?>

        <div class="form_promo">
            <form action="<?= $this->createUrl('profile/subscription/promo-activate') ?>" method="POST"
                  id="gift_promo__form">
                <label for="promo" class="form__label form__label_gray">Активировать подарочный промокод:</label>
                <div class="flex__wrap">
                    <div class="form__field form__field_short">
                        <input type="text" name="promo" id="promo" placeholder="" required/>
                    </div>
                    <div class="form_short_btn">
                        <button type="submit">Применить</button>
                    </div>
                </div>
            </form>
            <div class="form_promo_success" <?php if (Yii::app()->user->hasFlash('success')): ?> style="display: none" <?php endif; ?>><?= Yii::app()->user->getFlash('success') ?></div>
            <div class="form_promo_error" <?php if (Yii::app()->user->hasFlash('error')): ?> style="display: none" <?php endif; ?>><?= Yii::app()->user->getFlash('error') ?></div>
        </div>
    </div>
</div>
