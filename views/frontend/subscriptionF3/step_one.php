<?php
/* @var $this SubscriptionF1Controller */
?>
<div class="post-body" style="background-color: #E2E2E2 !important;">
    <div class="container-wide container-form">
        <div class="wide-box">
            <?= $this->renderPartial('/subscriptionF3/parts/menu', [
                'step' => 2
            ]); ?>
            <h1 class="post-title big-margin no-margin">Купить подписку</h1>
            <div class="form_header">Для кого подписка?</div>
            <div class="tabs__wrapper">
                <div class="tabs">
                    <span class="tab <?= $type == Subscription::MYSELF ? 'active' : '' ?>">Для себя</span>
                    <span class="tab <?= $type == Subscription::GIFT ? 'active' : '' ?>">В подарок</span>
                </div>
                <div class="form_wrap">
                    <div class="tab__content">
                        <div class="tab__item"
                             style="display: <?= $type == Subscription::MYSELF ? '' : 'none' ?>">
                            <form class="form mySelfForm" action="<?= $this->createUrl('/subscription/f3/step-two') ?>" method="POST" id="fast-registration__form">
                                <div class="form_header form_header_margin_little">Твой аккаунт:
                                    <p class="subscription__text subscription__text_margin user__gift_email"><?= Yii::app()->userComponent->getUserEmail() ?></p>
                                </div>
                                <div class="form_section">
                                    <div class="form__field">
                                        <p class="subscription__text subscription__text_margin user__gift_email_subscriptions">
                                            Подписка будет связана с этим аккаунтом. <br>
                                            Если хочешь связать ее с другим аккаунтом, выйди и зайди снова.
                                        </p>
                                    </div>
                                    <button type="submit">Продолжить
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
                        <div class="tab__item" style="display: <?= $type == Subscription::GIFT ? '' : 'none' ?>">
                            <form class="form giftForm" action="<?= $this->createUrl('/subscription/f5/save-step-two-gift') ?>" method="POST" id="fast-registration__form">
                                <input type="hidden" name="gift_type" value="<?= Subscription::GUEST ?>">
                                <div class="form_header">Гайд и подписка в подарок – отличная идея!</div>
                                <div class="form_header form_header_margin_big">Осталось всего пару шагов.</div>
                                <div class="subscription__choose-role">
                                    <div class="form_button_long">
                                        <button type="submit">Продолжить
                                            <svg width="14" height="24" viewBox="0 0 14 24" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                      d="M8.1125 11.9707L0.472152 23.7257L5.37154 23.7257L13.012 11.9707L5.37162 0.215641L0.472152 0.215633L8.1125 11.9707Z"
                                                      fill="black"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
