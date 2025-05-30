<?php
/* @var $this SubscriptionF1Controller */
?>
<div class="post-body" style="background-color: #E2E2E2 !important;">
    <div class="container-wide container-form">
        <div class="wide-box">
            <?= $this->renderPartial('/subscriptionF1/parts/menu', [
                'step' => 2
            ]); ?>
            <h1 class="post-title big-margin no-margin">Купить подписку</h1>
            <div class="form_header">Для кого подписка?</div>
            <div class="tabs__wrapper">
                <div class="tabs">
                    <span class="tab <?= $type == Subscription::MYSELF ? 'active' : '' ?>">Для себя</span>
                    <span class="tab <?= $type == Subscription::GIFT ? 'active' : '' ?>">В подарок</span>
                </div>
                <div class="form_wrap">
                    <div class="tab__content">
                        <div class="tab__item"
                             style="display: <?= $type == Subscription::MYSELF ? '' : 'none' ?>">
                            <form action="<?= $this->createUrl('/subscription/f1/save-step-two') ?>" method="POST"
                                  id="fast-registration__form" class="form mySelfForm">
                                <div class="form_header form_header_margin_little">Войди или зарегистрируйся, чтобы
                                    продолжить
                                </div>
                                <div class="form_section">
                                    <div class="form__field">
                                        <input type="mail" name="email" placeholder="E-mail" class="form_long-input"
                                               required/>
                                    </div>
                                    <button type="submit">Продолжить
                                        <svg width="14" height="24" viewBox="0 0 14 24" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                  d="M8.1125 11.9707L0.472152 23.7257L5.37154 23.7257L13.012 11.9707L5.37162 0.215641L0.472152 0.215633L8.1125 11.9707Z"
                                                  fill="black"/>
                                        </svg>
                                    </button>
                                </div>
                                <div class="form_short-text form_short-text_margin_l">Или</div>
                                <div class="autorization">
                                    <a href="<?= $this->createUrl('login/loginWithGoogleSubscription'); ?>"
                                       class="autorization_aside">
                                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <g clip-path="url(#clip0_4030_2792)">
                                                <path
                                                        d="M10 8.18188V12.0546H15.3818C15.1455 13.3001 14.4363 14.3547 13.3727 15.0637L16.6181 17.5819C18.509 15.8365 19.5999 13.2729 19.5999 10.2274C19.5999 9.51836 19.5363 8.83648 19.4181 8.18199L10 8.18188Z"
                                                        fill="#4285F4"/>
                                                <path
                                                        d="M4.39568 11.9033L3.66371 12.4636L1.07275 14.4818C2.7182 17.7454 6.09068 20 9.99974 20C12.6997 20 14.9633 19.1091 16.6179 17.5818L13.3724 15.0636C12.4815 15.6636 11.3451 16.0273 9.99974 16.0273C7.39976 16.0273 5.19073 14.2728 4.39976 11.9091L4.39568 11.9033Z"
                                                        fill="#34A853"/>
                                                <path
                                                        d="M1.07265 5.51807C0.390868 6.86347 0 8.38167 0 9.99982C0 11.618 0.390868 13.1362 1.07265 14.4816C1.07265 14.4906 4.39998 11.8998 4.39998 11.8998C4.19998 11.2998 4.08177 10.6634 4.08177 9.99972C4.08177 9.336 4.19998 8.69967 4.39998 8.09968L1.07265 5.51807Z"
                                                        fill="#FBBC05"/>
                                                <path
                                                        d="M9.99995 3.98182C11.4727 3.98182 12.7818 4.49089 13.8272 5.47272L16.6908 2.60912C14.9545 0.990971 12.7 0 9.99995 0C6.09089 0 2.7182 2.24545 1.07275 5.51819L4.39998 8.10001C5.19084 5.73635 7.39996 3.98182 9.99995 3.98182Z"
                                                        fill="#EA4335"/>
                                            </g>
                                            <defs>
                                                <clipPath id="clip0_4030_2792">
                                                    <rect width="20" height="20" fill="white"/>
                                                </clipPath>
                                            </defs>
                                        </svg>
                                        <div class="autorization_aside_text">Продолжить с Google</div>
                                    </a>
                                </div>
                            </form>
                        </div>
                        <div class="tab__item" style="display: <?= $type == Subscription::GIFT ? '' : 'none' ?>">
                            <form action="<?= $this->createUrl('/subscription/f5/save-step-two-gift') ?>" method="POST" id="fast-registration__form" class="form mySelfForm">
                                <div class="form_header">Гайд и подписка в подарок – отличная идея!</div>
                                <div class="form_header form_header_margin_big">Осталось всего пару шагов.
                                </div>
                                <div class="subscription__choose-role">
                                    <div class="subscription__role_check__wrap">
                                        <div class="subscription__role_check">
                                            <input type="radio" class="custom-radio" id="enter" required
                                                   name="gift_type" value="<?= Subscription::REGISTER ?>"/>
                                            <label for="enter">Войти или зарегистрироваться</label>
                                        </div>
                                        <div class="subscription__role_check">
                                            <input type="radio" class="custom-radio" id="guest" required
                                                   name="gift_type" value="<?= Subscription::GUEST ?>"/>
                                            <label for="guest">Гостевой доступ</label>
                                        </div>
                                    </div>
                                    <div class="form_button_long">
                                        <button type="submit">Продолжить
                                            <svg width="14" height="24" viewBox="0 0 14 24" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                      d="M8.1125 11.9707L0.472152 23.7257L5.37154 23.7257L13.012 11.9707L5.37162 0.215641L0.472152 0.215633L8.1125 11.9707Z"
                                                      fill="black"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
