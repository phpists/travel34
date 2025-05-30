<?php
/* @var $this SubscriptionF1Controller */
?>
<div class="post-body" style="background-color: #E2E2E2 !important;">
    <div class="container-wide container-form container-grid">
        <div class="wide-box">
            <?= $this->renderPartial('/subscriptionF4/parts/menu', [
                'step' => 2
            ]); ?>
            <h1 class="post-title">Купить подписку В ПОДАРОК</h1>
            <div class="form_wrap">
                <form action="<?= $this->createUrl('/subscription/f5/save-step-three-gift') ?>"
                      method="POST"
                      id="buyGift"
                      class="form">
                    <div class="form_header">Кому?</div>
                    <br>
                    <br>
                    <div class="form_section">
                        <div class="from-item from-item__mb_90">
                            <label for="email" class="form__label form__label_left form__label_black">
                                Введи e-mail того или той, кому собираешься подарить подписку:
                            </label>
                            <div class="form__label form__label_description">Не волнуйся, мы не испортим сюрприз и
                                отправим письмо в выбранные тобой время и дату.
                            </div>
                            <div class="form__field">
                                <input
                                        type="email"
                                        name="email"
                                        id="email1"
                                        placeholder="E-mail"
                                        class="form_long-input"
                                    <?php if (Yii::app()->user->hasFlash('old_email')): ?>
                                        value="<?php echo Yii::app()->user->getFlash('old_email'); ?>"
                                    <?php endif; ?>
                                        required>
                                <?php if (Yii::app()->user->hasFlash('email')): ?>
                                    <label id="email-error" class="error"
                                           for="email"><?php echo Yii::app()->user->getFlash('email'); ?></label>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="from-item from-item__mb_90">
                            <label for="email" class="form__label form__label_left form__label_black">
                                Повтори e-mail:
                            </label>
                            <div class="form__label form__label_description">Мы не хотим, чтобы подписка затерялась
                                из-за опечатки.
                            </div>
                            <div class="form__field">
                                <input
                                        type="email"
                                        name="email_confirm"
                                        id="email2"
                                        placeholder="E-mail"
                                        class="form_long-input"
                                    <?php if (Yii::app()->user->hasFlash('old_email_confirm')): ?>
                                        value="<?php echo Yii::app()->user->getFlash('old_email_confirm'); ?>"
                                    <?php endif; ?>
                                        required
                                >
                            </div>
                        </div>
                        <div class="from-item from-item__mb_80">
                            <label for="email" class="form__label form__label_left form__label_black">
                                Выбери время и дату, когда ты хочешь подарить подписку:
                            </label>
                            <div class="form__label form__label_description">Письмо придет ровно в выбранные тобой день
                                и час (GMT +2).
                            </div>
                            <div class="form__field form__group">
                                <input type="text" name="date" class="form-control" id="datepicker" required>
                                <label for="datepicker" class="form__group-info">
                                    <svg
                                            width="22"
                                            height="22"
                                            viewBox="0 0 22 22"
                                            fill="none"
                                            xmlns="http://www.w3.org/2000/svg"
                                            class="form__group-icon"
                                    >
                                        <path
                                                d="M20.5832 20.5852L17.6016 17.6035"
                                                stroke="black"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                        />
                                        <path
                                                fill-rule="evenodd"
                                                clip-rule="evenodd"
                                                d="M15.1665 18.502C17.2376 18.502 18.9165 16.823 18.9165 14.752C18.9165 12.6809 17.2376 11.002 15.1665 11.002C13.0954 11.002 11.4165 12.6809 11.4165 14.752C11.4165 16.823 13.0954 18.502 15.1665 18.502Z"
                                                stroke="black"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                        />
                                        <path
                                                d="M8.9165 16.4173H2.24984C1.7896 16.4173 1.4165 16.0442 1.4165 15.584V3.91732C1.4165 3.45708 1.7896 3.08398 2.24984 3.08398H17.2498C17.7101 3.08398 18.0832 3.45708 18.0832 3.91732V9.33398"
                                                stroke="black"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                        />
                                        <path
                                                d="M5.58301 1.41797V5.58464"
                                                stroke="black"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                        />
                                        <path
                                                d="M13.9165 1.41797V5.58464"
                                                stroke="black"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                        />
                                        <path
                                                d="M1.4165 7.25195H18.0832"
                                                stroke="black"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                        />
                                    </svg>
                                    <span>Выбрать дату</span>
                                </label>
                            </div>
                            <div class="form__field form__group subscription__select">
                                <select name="time" id="timeSelect" class="form-control form_long-input form__select-group" required>
                                    <?php foreach (Subscription::getTimes() as $time): ?>
                                        <option value="<?= $time ?>" <?= $time == Yii::app()->user->hasFlash('old_time') ? 'selected' : '' ?> ><?= $time ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <label for="timeSelect" class="form__group-info">
                                    <svg
                                            width="20"
                                            height="20"
                                            viewBox="0 0 20 20"
                                            fill="none"
                                            xmlns="http://www.w3.org/2000/svg"
                                            class="form__group-icon"
                                    >
                                        <path
                                                fill-rule="evenodd"
                                                clip-rule="evenodd"
                                                d="M9.99902 18.625C14.7625 18.625 18.624 14.7635 18.624 10C18.624 5.23654 14.7625 1.375 9.99902 1.375C5.23557 1.375 1.37402 5.23654 1.37402 10C1.37402 14.7635 5.23557 18.625 9.99902 18.625Z"
                                                stroke="black"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                        />
                                        <path
                                                d="M10 5.875V10L14.5 14.125"
                                                stroke="black"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                        />
                                    </svg>
                                    <span>Выбрать время</span>
                                </label>
                            </div>
                            <?php if (Yii::app()->user->hasFlash('time')): ?>
                                <label id="email-error" class="error"
                                       for="email"><?php echo Yii::app()->user->getFlash('time'); ?></label>
                            <?php endif; ?>
                        </div>
                        <div class="from-item">
                            <label for="email" class="form__label form__label_left form__label_black">
                                Твой e-mail:
                            </label>
                            <div class="form__label form__label_description">Мы продублируем подарок тебе на почту.
                                Просто на всякий случай.
                            </div>
                            <div class="form__field">
                                <input
                                        type="email"
                                        name="parent_email"
                                        id="email3"
                                        placeholder="E-mail"
                                        class="form_long-input"
                                        value="<?= Yii::app()->userComponent->getUserEmail() ?>"
                                        required>
                                <?php if (Yii::app()->user->hasFlash('parent_email')): ?>
                                    <label id="email-error" class="error"
                                           for="email"><?php echo Yii::app()->user->getFlash('parent_email'); ?></label>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="form_button_long">
                            <button type="submit">
                                Продолжить
                                <svg
                                        width="14"
                                        height="24"
                                        viewBox="0 0 14 24"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                >
                                    <path
                                            fill-rule="evenodd"
                                            clip-rule="evenodd"
                                            d="M8.1125 11.9707L0.472152 23.7257L5.37154 23.7257L13.012 11.9707L5.37162 0.215641L0.472152 0.215633L8.1125 11.9707Z"
                                            fill="black"
                                    />
                                </svg>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



