<?php
/* @var $this ProfileController */
$giftSubscription = UserSubscriptionGift::isSubscriptionGift()
?>
<div class="post-body" style="background-color: #E2E2E2 !important;">
    <div class="container-wide container-form">
        <div class="wide-box">
            <h1 class="post-title">Мой аккаунт</h1>

            <?php if ($giftSubscription['status']): ?>
                <?= $this->renderPartial('/profile/gift_subscription', [
                    'url' => $giftSubscription['url']
                ]); ?>
            <?php endif; ?>

            <div class="form_wrap">
                <div class="form_wrap_inside mobile_text-center">
                    <div class="form_header form_header_margin">Информация</div>
                    <div class="form_section">
                        <div class="form_short-text form_short-text_left form_short-text_big">E-mail:</div>
                        <div class="form_text"><?= $user->email ?></div>
                        <a href="<?= $this->createUrl('profile/account-settings') ?>"
                           class="form_simple_link form_short-text_left">
                            Управление аккаунтом
                        </a>
                    </div>
                </div>
            </div>

            <?= $this->renderPartial('/profile/subscriptions', [
                'userSubscriptions' => $userSubscriptions
            ]); ?>

            <div class="form_wrap">
                <div class="form_wrap_inside">
                    <div class="form_header form_header_margin">Купить подписку в подарок</div>
                    <div class="form_section form_section_text">
                        <p class="form_short-text_left">Доступ ко всем гайдам 34travel ты можешь подарить другу
                            или
                            подруге, которые отправляются в путешествие. </p>
                        <p class="form_short-text_left">Легче планирование – больше приятных впечатлений!</p>
                    </div>
                    <a href="<?= $this->createUrl('subscription/f11/step-one') ?>" class="form_link">Подарить
                        подписку</a>
                </div>
            </div>

            <div class="form_simple_link_wrap">
                <a href="<?= $this->createUrl('/logout') ?>" class="form_simple_link logout">Выйти</a>
            </div>
        </div>
    </div>
</div>
<?php $this->renderPartial('modals/subscription_cancel'); ?>



