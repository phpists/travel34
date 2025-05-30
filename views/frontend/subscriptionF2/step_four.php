<?php
/* @var $this SubscriptionF2Controller */
?>
<div class="post-body subscription__body" style="background-color: #E2E2E2 !important;">
    <div class="container-wide container-form">
        <div class="wide-box">
            <?= $this->renderPartial('/subscriptionF2/parts/menu', [
                'step' => 4
            ]); ?>
            <h1 class="post-title no-margin">Купить подписку</h1>
            <div class="form_wrap form_wrap_no-margin">
                <div class="form_wrap_inside">
                    <div class="form_header form_success subscription__success">Оплата прошла успешно!</div>
                    <div class="form_section form_section_margin_medium_second">
                        <p class="subscription__text">Все гайды уже в твоем доступе.<br>Спасибо, что ты с нами!
                        </p>
                    </div>
                    <div class="form_text_line form_text_line_gray"><?= $subscription['title'] ?></div>
                    <div class="form_section_margin_big form__info_wrap">
                        <div class="form__label form__label_gray form_date_wrap"><span
                                class="form__info_text">Дата покупки:</span><span><?= Subscription::getSubscriptionStartDate(date('Y-m-d')) ?></span>
                        </div>
                        <div class="form__label form__label_gray form_ordernum_wrap"><span
                                class="form__info_text">Номер заказа</span><span>#<?= $userSubscription['id'] ?></span></div>
                    </div>
                    <a href="<?= $redirect_url ?>" class="form_link form_link_text subscription__link">На главную
                        <svg width="13" height="24" viewBox="0 0 13 24" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                  d="M7.7043 12.1421L0.0639486 23.8972L4.96334 23.8972L12.6038 12.1421L4.96341 0.387119L0.0639487 0.387112L7.7043 12.1421Z"
                                  fill="black" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

