<div class="post-body" style="background-color: #E2E2E2 !important;">
    <div class="container-wide container-form">
        <div class="wide-box">
            <h1 class="post-title no-margin">Ошибка оплаты</h1>
            <div class="form_wrap form_wrap_no-margin">
                <div class="form">
                    <div class="form_header">Произошла ошибка!</div>
                    <p class="subscription__text_bold">К сожалению, оплата не прошла.</p>
                    <p class="subscription__text">Пожалуйста, попробуй снова или свяжись с нашей поддержкой для решения проблемы.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    window.dataLayer.push({
        event: 'stripe_payment_failed',
        reason: 'card_declined'
    });

    window.addEventListener("beforeunload", function() {
        window.dataLayer.push({
            event: 'stripe_payment_failed',
            reason: 'subscription_abandoned'
        });
    });
</script>

