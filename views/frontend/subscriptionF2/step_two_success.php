<?php
/* @var $this SubscriptionF1Controller */
?>
<div class="post-body" style="background-color: #E2E2E2 !important;">
    <div class="container-wide container-form">
        <div class="wide-box">
            <?= $this->renderPartial('/subscriptionF2/parts/menu', [
                'step' => 2
            ]); ?>
            <h1 class="post-title no-margin">Купить подписку</h1>
            <div class="form_wrap form_wrap_no-margin">
                <div class="form">
                    <div class="form_header">Почти готово!</div>
                    <p class="subscription__text_bold">Мы отправили на твой email письмо, чтобы подтвердить регистрацию аккаунта.</p>
                    <p class="subscription__text">Пожалуйста, открой письмо и перейди по ссылке.</p>
                </div>
            </div>
        </div>

    </div>

</div>
