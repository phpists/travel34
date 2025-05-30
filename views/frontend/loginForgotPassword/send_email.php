<?php
/* @var $this LoginForgotPasswordController */
?>

<div class="post-body" style="background-color: #E2E2E2 !important;">
    <div class="container-wide container-form">
        <div classs="wide-box">
            <h1 class="post-title">Восстановить пароль</h1>
            <?php if (Yii::app()->user->hasFlash('send_email')): ?>
                <div class="form_section">
                    <div class="form_header form_success"><?= Yii::app()->user->getFlash('send_email') ?></div>
                </div>
            <?php endif; ?>
            <div class="form_wrap">
                <form action="<?= $this->createUrl('/reset/login/password-email') ?>" method="POST" id="enter__form" class="form">
                    <div class="form_section">
                        <div class="form__field">
                            <input type="email" name="email" placeholder="E-mail" class="form_long-input" required/>
                            <?php if(Yii::app()->user->hasFlash('email')): ?>
                                <label id="email-error" class="error" for="email"><?php echo Yii::app()->user->getFlash('email'); ?></label>
                            <?php endif; ?>
                        </div>
                        <button type="submit">ОТПРАВИТЬ
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

