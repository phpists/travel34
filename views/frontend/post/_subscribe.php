<?php
/* @var $this PostController */
/* @var $subscribeImage string */
?>
<div class="b-subscribe__container">
    <div class="b-subscribe__wrap"<?php if (!empty($subscribeImage)): ?> style="background-image: url('<?= $subscribeImage ?>')"<?php endif; ?>>
        <div class="b-subscribe" id="mc_embed_signup">
            <?= BlocksHelper::get('subscribe_text' . (Yii::app()->language == 'en' ? '_en' : '')) ?>

            <script src="//static-login.sendpulse.com/apps/fc3/build/loader.js" sp-form-id="e675e07bb6cdb93c827d5e2bd6795066aca34baa9218d71d6f34c869eb1be52f"></script>

            <?php /*<form action="//34travel.us12.list-manage.com/subscribe/post?u=e6a3a464e35ece98beff76da1&amp;id=e88e43f0ba" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="b-subscribe__form validate" target="_blank" novalidate>
                <div id="mc_embed_signup_scroll">
                    <div class="b-subscribe__field-wrap mc-field-group">
                        <label for="mce-EMAIL"><?= Yii::t('app', 'Your email') ?></label>
                        <input type="email" value="" name="EMAIL" id="mce-EMAIL" class="required email" placeholder="EMAIL">
                    </div>
                    <button type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe"><?= Yii::t('app', 'Done!') ?></button>
                    <div id="mce-responses" class="clear">
                        <div class="response" id="mce-error-response" style="display:none"></div>
                        <div class="response" id="mce-success-response" style="display:none"></div>
                    </div>
                    <div style="position: absolute; left: -5000px;" aria-hidden="true">
                        <input type="text" name="b_e6a3a464e35ece98beff76da1_e88e43f0ba" tabindex="-1" value="">
                    </div>
                </div>
            </form>
            <script type='text/javascript' src='//s3.amazonaws.com/downloads.mailchimp.com/js/mc-validate.js'></script>
            <script type='text/javascript'>
                (function ($) {
                    window.fnames = [];
                    window.ftypes = [];
                    fnames[0] = 'EMAIL';
                    ftypes[0] = 'email';
                    <?php if (Yii::app()->language != 'en'): ?>
                    $.extend($.validator.messages, {
                        required: "Это поле необходимо заполнить.",
                        remote: "Пожалуйста, введите правильное значение.",
                        email: "Пожалуйста, введите корректный адрес электронной почты.",
                        url: "Пожалуйста, введите корректный URL.",
                        date: "Пожалуйста, введите корректную дату.",
                        dateISO: "Пожалуйста, введите корректную дату в формате ISO.",
                        number: "Пожалуйста, введите число.",
                        digits: "Пожалуйста, вводите только цифры.",
                        creditcard: "Пожалуйста, введите правильный номер кредитной карты.",
                        equalTo: "Пожалуйста, введите такое же значение ещё раз.",
                        accept: "Пожалуйста, выберите файл с правильным расширением.",
                        maxlength: $.validator.format("Пожалуйста, введите не больше {0} символов."),
                        minlength: $.validator.format("Пожалуйста, введите не меньше {0} символов."),
                        rangelength: $.validator.format("Пожалуйста, введите значение длиной от {0} до {1} символов."),
                        range: $.validator.format("Пожалуйста, введите число от {0} до {1}."),
                        max: $.validator.format("Пожалуйста, введите число, меньшее или равное {0}."),
                        min: $.validator.format("Пожалуйста, введите число, большее или равное {0}.")
                    });
                    <?php endif; ?>
                }(jQuery));
                var $mcj = jQuery.noConflict(true);
            </script>*/?>

        </div>
    </div>
</div>
