<div class="post-body" style="background-color: #E2E2E2 !important;">
    <div class="container-wide container-form">
        <div class="wide-box">
            <h1 class="post-title">Управление аккаунтом</h1>
            <?php if (Yii::app()->user->hasFlash('send_email')): ?>
                <div class="form_section">
                    <div class="form_header form_success"><?= Yii::app()->user->getFlash('send_email') ?></div>
                </div>
            <?php endif; ?>
            <div class="form_wrap">
                <div class="form_wrap_inside form_wrap_inside_margin">
                    <div class="form_header form_header_margin">Информация</div>
                    <div class="form_section">
                        <div class="form_short-text form_short-text_center form_short-text_big">E-mail:</div>
                        <div class="form_text form_short-text_center"><?= $user->email ?></div>
                    </div>
                </div>
                <div class="form_wrap_inside">
                    <div class="form_header form_header_margin">Действия</div>
                    <div class="form_actions_wrapper">
                        <a href="<?= $this->createUrl('reset/password-email') ?>" class="form_actions_link">Сменить пароль</a>
                        <a href="<?= $this->createUrl('profile/manage-subscriptions') ?>" class="form_actions_link">Управлять подпиской</a>
                        <a href="<?= $this->createUrl('profile/account-delete') ?>" class="form_actions_link">Удалить аккаунт</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>