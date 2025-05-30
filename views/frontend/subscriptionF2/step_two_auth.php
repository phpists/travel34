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
            <div class="form_wrap form_wrap_no-padding">
                <div class="subscription__sections">
                    <div class="subscription__section subscription__section_left">
                        <form action="<?= $this->createUrl('/subscription/f2/save-step-two-login') ?>" method="POST" id="registration__form" class="form">
                            <div class="form_header form_header_left">Вход</div>
                            <div class="form_section form_section_margin_medium_third">
                                <div class="form__field form__field_pass">
                                    <input type="password" name="password" placeholder="Пароль" class="form_long-input" required />
                                    <?php if(Yii::app()->user->hasFlash('email')): ?>
                                        <label id="email-error" class="error" for="email"><?php echo Yii::app()->user->getFlash('email'); ?></label>
                                    <?php endif; ?>
                                    <?php if(Yii::app()->user->hasFlash('password')): ?>
                                        <label id="password-error" class="error" for="password"><?php echo Yii::app()->user->getFlash('password'); ?></label>
                                    <?php endif; ?>
                                    <a href="<?= $this->createUrl('/subscription/f2/reset-password') ?>" class="form__link_gray">Я забыл/а пароль</a>
                                </div>
                            </div>

                            <div class="form_button_long">
                                <button type="submit">Войти
                                    <svg width="14" height="24" viewBox="0 0 14 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M8.1125 11.9707L0.472152 23.7257L5.37154 23.7257L13.012 11.9707L5.37162 0.215641L0.472152 0.215633L8.1125 11.9707Z" fill="black"/>
                                    </svg>
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="subscription__section subscription__section_right">
                        <form action="<?= $this->createUrl('/subscription/f2/save-step-two-register') ?>" method="POST" id="registration__form" class="form">
                            <div class="form_header form_header_left">Регистрация</div>
                            <div class="form_section form_section_margin_little">
                                <div class="form__label form__label_gray">Минимум 8 символов</div>
                                <div class="form__field">
                                    <input type="password" name="password" placeholder="Создай пароль" class="form_long-input" required />
                                    <?php if(Yii::app()->user->hasFlash('register_password')): ?>
                                        <label id="password-error" class="error" for="password"><?php echo Yii::app()->user->getFlash('register_password'); ?></label>
                                    <?php endif; ?>
                                    <?php if(Yii::app()->user->hasFlash('register_email')): ?>
                                        <label id="password-error" class="error" for="password"><?php echo Yii::app()->user->getFlash('register_email'); ?></label>
                                    <?php endif; ?>
                                </div>
                                <div class="form__field">
                                    <input type="password" name="password_repeat" class="form_long-input" placeholder="Повтори пароль" required/>
                                </div>
                            </div>
                            <div class="form_button_long">
                                <button type="submit">Создать аккаунт
                                    <svg width="14" height="24" viewBox="0 0 14 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M8.1125 11.9707L0.472152 23.7257L5.37154 23.7257L13.012 11.9707L5.37162 0.215641L0.472152 0.215633L8.1125 11.9707Z" fill="black"/>
                                    </svg>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
