<?php
$subscriptions = Subscription::getSubscriptions();
$setting = Setting::getPaywallTitles($post);
?>
<?php if (Yii::app()->userComponent->checkMySubscription()): ?>
    <section class="rubric__subscription">
        <div class="rubric__subscription_blur"><span></span></div>
        <div class="container">
            <div class="wide-box rubric__subscription_wrap">
                <p class="rubric__subscription_header"><?= $setting['title'] ?></p>
                <p class="rubric__subscription_description"><?= $setting['description'] ?></p>
                <p class="rubric__subscription_header">Выбери<br>тарифный план</p>
                <div class="container-fluid">
                    <form action="<?= SubscriptionComponent::getGuideSubscriptionUrl() ?>" method="POST" id="check_subscription">
                        <div class="subscription__tariffs_wrap row">
                            <?php foreach ($subscriptions as $subscription): ?>
                                <div class="subscription__tariffs_item <?= $subscription->id == Subscription::FOR_YEAR ? 'active' : '' ?> <?= $subscription->id == Subscription::FAMILY ? 'blocked_subscription' : '' ?>  col-12 col-us-6 col-sm-6 col-md-4 col-lg-4">
                                    <div>
                                        <div class="subscription__tariff_title">
                                            <div class="subscription__tariffs_check">
                                                <input type="radio" class="custom-radio"
                                                       id="subscription_<?= $subscription->id ?>"
                                                       name="subscription"
                                                    <?= $subscription->id == Subscription::FOR_YEAR ? 'checked' : '' ?>
                                                       value="<?= $subscription->id ?>"
                                                       required/>
                                                <div class="subscription-square-radio"></div>
                                                <label for="subscription_<?= $subscription->id ?>"><?= $subscription->title ?></label>
                                            </div>
                                            <span class="subscription__tariffs_line"></span>
                                        </div>
                                        <?= $subscription->description ?>
                                        <?php if ($subscription->id == Subscription::FAMILY): ?>
                                            <div class="subscription__tariffs_price">
                                                Coming soon
                                            </div>
                                        <?php else: ?>
                                            <div class="subscription__tariffs_price">
                                                <?php if ($subscription->old_price > 0) { ?>
                                                    <span class="subscription__tariffs_old-price">€ <?= number_format($subscription->old_price, 2, '.', ''); ?></span>
                                                <?php } ?>
                                                <span class="subscription__tariffs_new-price">€ <?= number_format($subscription->price, 2, '.', ''); ?></span>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="form_button_long">
                            <input type="hidden" name="subscription_text" id="subscriptionText" value="Подписка на год">
                            <input type="hidden" name="subscription_type_text" id="subscriptionTypeText" value="Подписка для себя">

                            <button type="submit" class="subscription__link" id="subscriptionSubmitButton">
                                Перейти к оплате
                                <svg width="14" height="24" viewBox="0 0 14 24" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                          d="M8.1125 11.9707L0.472152 23.7257L5.37154 23.7257L13.012 11.9707L5.37162 0.215641L0.472152 0.215633L8.1125 11.9707Z"
                                          fill="black"/>
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>

                <?php if (!Yii::app()->userComponent->isAuthenticated()): ?>
                    <a href="<?= $this->createUrl('/i-have-account') ?>" class="have__account">У меня уже есть аккаунт. Войти</a>
                <?php endif; ?>
            </div>
        </div>
    </section>
<?php endif; ?>