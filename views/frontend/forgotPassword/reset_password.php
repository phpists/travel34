<?php
/* @var $this ForgotPasswordController */
?>
<div class="post-body" style="background-color: #E2E2E2 !important;">
    <div class="container-wide container-form">
        <?php if (Yii::app()->user->hasFlash('success')): ?>
            <div class="wide-box">
                <h1 class="post-title">Сменить пароль</h1>
                <div class="form_wrap">
                    <div class="form_wrap_inside">
                        <div class="form_section">
                            <div class="form_header form_success">Пароль изменен!</div>
                        </div>
                        <a href="<?= $this->createUrl('profile/account') ?>" class="form_link form_link_text">Вернуться
                            в личный кабинет
                            <svg width="14" height="24" viewBox="0 0 14 24" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                      d="M8.1125 11.9707L0.472152 23.7257L5.37154 23.7257L13.012 11.9707L5.37162 0.215641L0.472152 0.215633L8.1125 11.9707Z"
                                      fill="black"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="wide-box">
                <h1 class="post-title">Сменить пароль</h1>
                <div class="form_wrap">
                    <form action="<?= $this->createUrl('/reset/password') ?>" method="POST" id="change_pass_form" class="form_wrap_inside">
                        <div class="form_section__username">
                            <div class="form__label form__label_left form__label_black">E-mail:
                                <span><?= $user->email ?></span></div>
                        </div>
                        <div class="form_section_margin">
                            <div class="form_header form_header_left">Новый пароль</div>
                            <div class="form__label form__label_gray">Минимум 8 символов</div>
                            <div class="form__field">
                                <input type="password" name="new_password" id="new_pass" placeholder="Создай пароль"
                                       class="form_short-input-long" required/>
                                <?php if (Yii::app()->user->hasFlash('new_password')): ?>
                                    <label id="new_password-error" class="error"
                                           for="new_password"><?php echo Yii::app()->user->getFlash('new_password'); ?></label>
                                <?php endif; ?>
                            </div>
                            <div class="form__field">
                                <input type="password" name="repeat_password" id="repeat_pass"
                                       class="form_short-input-long"
                                       placeholder="Повтори пароль" required/>
                            </div>
                        </div>
                        <div class="form_button_long">
                            <button type="submit">Сменить пароль
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
            </div>
        <?php endif; ?>
    </div>
</div>
