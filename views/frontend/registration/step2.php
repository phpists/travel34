<?php
/* @var $this LoginController */
?>
<div class="post-body" style="background-color: #E2E2E2 !important;">
    <div class="container-wide container-form">
        <div classs="wide-box">
            <h1 class="post-title">Зарегистрироваться</h1>
            <div class="form_wrap form_wrap_short">
                <form action="<?= $this->createUrl('/registration/step2') ?>" method="POST" id="registration__form" class="form">
                    <?php if (Yii::app()->user->hasFlash('send_email')): ?>
                        <div class="form_section">
                            <div class="form_header form_success"><?php echo Yii::app()->user->getFlash('send_email'); ?></div>
                        </div>
                    <?php endif; ?>
                    <div class="form_header">Создать пароль</div>
                    <div class="form_section">
                        <div class="form__label form__label_gray">Минимум 8 символов</div>
                        <div class="form__field">
                            <input type="password" name="password" placeholder="Создай пароль" class="form_long-input  <?php if(Yii::app()->user->hasFlash('password')): ?> error <?php endif; ?>" required/>
                            <?php if(Yii::app()->user->hasFlash('password')): ?>
                                <label id="password-error" class="error" for="password"><?php echo Yii::app()->user->getFlash('password'); ?></label>
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
