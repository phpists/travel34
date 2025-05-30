<?php
/* @var $this SubscriptionF1Controller */
$promoDiscountPrice = UserPromoCodes::getSubscriptionDiscountPriceCookie();
?>
<div class="post-body subscription__body" style="background-color: #E2E2E2 !important;">
    <div class="container-wide container-form">
        <div class="wide-box">
            <?= $this->renderPartial('/subscriptionF1/parts/menu', [
                'step' => 3
            ]); ?>
            <h1 class="post-title no-margin">Купить подписку</h1>
            <div class="form_wrap form_wrap_no-margin">
                <div class="form_wrap_inside">
                    <div class="form_header form_header_margin_little">Оплата</div>
                    <div class="form_section">
                        <div class="form__label form__label_gray form__label_margin_little">Тариф:</div>
                        <div class="form_text__inline_wrap">
                            <div class="form_text__inline">
                                <?= $subscription['title'] ?>
                            </div>
                            <?php if ($promoDiscountPrice): ?>
                                <div class="form_text__inline form_text__inline_prices">
                                    <div class="subscription__inline_old-price">€ <?= number_format($subscription['price'], 2) ?></div>
                                    <div class="subscription__inline_new-price">€ <?= $promoDiscountPrice ?></div>
                                </div>
                            <?php else: ?>
                                <div class="form_text__inline form_text__inline_prices">
                                    <?php if (isset($subscription['old_price'])): ?>
                                        <div class="subscription__inline_old-price">
                                            € <?= $subscription['old_price'] ?></div>
                                    <?php endif; ?>
                                    <div class="subscription__inline_new-price">€ <?= number_format($subscription['price'], 2) ?></div>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="subscription__hidden">
                            <div class="subscription_open-hidden form__label form__label_gray">
                                Информация о заказе
                                <svg width="11" height="6" viewBox="0 0 11 6" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5.5 6L0.736861 0.75L10.2631 0.749999L5.5 6Z" fill="#A2A2A2"/>
                                </svg>
                            </div>
                            <div class="subscriptions__list_hidden">
                                <ul class="subscriptions__list">
                                    <li class="subscriptions__item">
                                        <div>Полный доступ к фирменным гайдам 34travel</div>
                                    </li>
                                    <li class="subscriptions__item">
                                        <div>Доступ ко всем платным материалам сайта с эксклюзивными маршрутами,
                                            подробными мануалами и советами для путешественников
                                        </div>
                                    </li>
                                    <li class="subscriptions__item">
                                        <div>Возможность сохранять нужные материалы и создавать коллекции в личном
                                            кабинете 
                                        </div>
                                    </li>
                                    <li class="subscriptions__item">
                                        <div>Специальные предложения от наших партнеров</div>
                                    </li>
                                </ul>
                                <div>Дата начала подписки – <?= Subscription::getSubscriptionStartDate() ?></div>
                            </div>
                        </div>
                        <div class="form_promo subscription__promo">
                            <form action="<?= $this->createUrl('promo-code/activate') ?>" method="POST"
                                  id="promo__form">
                                <label for="promo" class="form__label form__label_gray">Промокод:</label>
                                <div class="flex__wrap">
                                    <div class="form__field form__field_short">
                                        <input type="text" name="promo" id="promo" placeholder=""
                                               required/>
                                    </div>
                                    <div class="form_short_btn">
                                        <button type="submit">Применить</button>
                                    </div>
                                </div>
                            </form>
                            <?php if (Yii::app()->user->hasFlash('success')): ?>
                                <div class="form_promo_success"><?= Yii::app()->user->getFlash('success') ?></div>
                            <?php endif; ?>

                            <?php if (Yii::app()->user->hasFlash('error')): ?>
                                <div class="form_promo_error"><?= Yii::app()->user->getFlash('error') ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="subscription__terms subscription__terms_margin_big subscription__terms_checkbox">
                            <input type="checkbox" class="custom-checkbox" id="terms" name="terms" value="terms" required/>
                            <label for="terms"><span>Прочитал(-а) и принимаю </span><a href="<?= $this->createUrl('/page/terms-conditions') ?>">Terms &
                                    Conditions</a>.</label>
                        </div>

                        <div class="subscription__payment_block">
                            <div class="form_button_long">
                                <button class="paymentBtn" type="button" data-url="<?= $this->createUrl('/subscription/f1/step-three-payment') ?>">
                                    ОПЛАТИТЬ
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
                            <div class="subscription__payment_list">
                                <div class="subscription__payment_item">
                                    <svg
                                            width="20"
                                            height="13"
                                            viewBox="0 0 20 13"
                                            fill="none"
                                            xmlns="http://www.w3.org/2000/svg"
                                    >
                                        <rect width="20" height="13" fill="#1E1E1E"/>
                                        <g clip-path="url(#clip0_1_2)">
                                            <rect
                                                    width="1440"
                                                    height="1924"
                                                    transform="translate(-594 -1155)"
                                                    fill="white"
                                            />
                                            <mask
                                                    id="mask0_1_2"
                                                    style="mask-type:alpha"
                                                    maskUnits="userSpaceOnUse"
                                                    x="-594"
                                                    y="-985"
                                                    width="1440"
                                                    height="2159"
                                            >
                                                <rect
                                                        x="-594"
                                                        y="-985"
                                                        width="1440"
                                                        height="2159"
                                                        fill="#F3F3F3"
                                                />
                                            </mask>
                                            <g mask="url(#mask0_1_2)">
                                                <rect
                                                        x="-594"
                                                        y="-994"
                                                        width="1440"
                                                        height="2168"
                                                        fill="#E2E2E2"
                                                />
                                            </g>
                                            <rect
                                                    x="-304"
                                                    y="-789"
                                                    width="860"
                                                    height="975"
                                                    fill="#F1F1F1"
                                            />
                                            <g style="mix-blend-mode:luminosity" opacity="0.6">
                                                <path
                                                        fill-rule="evenodd"
                                                        clip-rule="evenodd"
                                                        d="M10 10.8062C8.94083 11.7202 7.5669 12.272 6.06557 12.272C2.71565 12.272 0 9.5248 0 6.13599C0 2.74717 2.71565 0 6.06557 0C7.5669 0 8.94083 0.55178 10 1.46581C11.0592 0.55178 12.4331 0 13.9344 0C17.2844 0 20 2.74717 20 6.13599C20 9.5248 17.2844 12.272 13.9344 12.272C12.4331 12.272 11.0592 11.7202 10 10.8062Z"
                                                        fill="#ED0006"
                                                />
                                                <path
                                                        fill-rule="evenodd"
                                                        clip-rule="evenodd"
                                                        d="M10 10.8062C11.3042 9.68071 12.1311 8.00605 12.1311 6.13599C12.1311 4.26593 11.3042 2.59126 10 1.46581C11.0592 0.551779 12.4331 0 13.9344 0C17.2844 0 20 2.74717 20 6.13599C20 9.5248 17.2844 12.272 13.9344 12.272C12.4331 12.272 11.0592 11.7202 10 10.8062Z"
                                                        fill="#F9A000"
                                                />
                                                <path
                                                        fill-rule="evenodd"
                                                        clip-rule="evenodd"
                                                        d="M10.0002 10.806C11.3043 9.68055 12.1312 8.00592 12.1312 6.13591C12.1312 4.2659 11.3043 2.59127 10.0002 1.46582C8.69607 2.59127 7.86914 4.2659 7.86914 6.13591C7.86914 8.00592 8.69607 9.68055 10.0002 10.806Z"
                                                        fill="#FF5E00"
                                                />
                                            </g>
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_1_2">
                                                <rect
                                                        width="1440"
                                                        height="1924"
                                                        fill="white"
                                                        transform="translate(-594 -1155)"
                                                />
                                            </clipPath>
                                        </defs>
                                    </svg>
                                </div>
                                <div class="subscription__payment_item">
                                    <svg
                                            width="28"
                                            height="9"
                                            viewBox="0 0 28 9"
                                            fill="none"
                                            xmlns="http://www.w3.org/2000/svg"
                                    >
                                        <rect width="28" height="9" fill="#1E1E1E"/>
                                        <g clip-path="url(#clip0_1_2)">
                                            <rect
                                                    width="1440"
                                                    height="1924"
                                                    transform="translate(-637 -1157)"
                                                    fill="white"
                                            />
                                            <mask
                                                    id="mask0_1_2"
                                                    style="mask-type:alpha"
                                                    maskUnits="userSpaceOnUse"
                                                    x="-637"
                                                    y="-987"
                                                    width="1440"
                                                    height="2159"
                                            >
                                                <rect
                                                        x="-637"
                                                        y="-987"
                                                        width="1440"
                                                        height="2159"
                                                        fill="#F3F3F3"
                                                />
                                            </mask>
                                            <g mask="url(#mask0_1_2)">
                                                <rect
                                                        x="-637"
                                                        y="-996"
                                                        width="1440"
                                                        height="2168"
                                                        fill="#E2E2E2"
                                                />
                                            </g>
                                            <rect
                                                    x="-347"
                                                    y="-791"
                                                    width="860"
                                                    height="975"
                                                    fill="#F1F1F1"
                                            />
                                            <g style="mix-blend-mode:luminosity" opacity="0.6">
                                                <path
                                                        fill-rule="evenodd"
                                                        clip-rule="evenodd"
                                                        d="M7.00029 8.86659H4.57707L2.75995 1.93416C2.6737 1.61527 2.49057 1.33335 2.22119 1.20048C1.54893 0.866566 0.808135 0.600823 0 0.466796V0.199898H3.90362C4.44238 0.199898 4.84645 0.600823 4.91379 1.06645L5.85662 6.06704L8.27866 0.199898H10.6345L7.00029 8.86659ZM11.9815 8.86659H9.69293L11.5774 0.199898H13.8659L11.9815 8.86659ZM16.8268 2.60082C16.8941 2.13403 17.2982 1.86713 17.7696 1.86713C18.5104 1.80012 19.3173 1.93415 19.9908 2.2669L20.3948 0.400925C19.7214 0.134027 18.9806 0 18.3083 0C16.0871 0 14.4709 1.20047 14.4709 2.86656C14.4709 4.13404 15.6157 4.79955 16.4239 5.20048C17.2982 5.60024 17.6349 5.86714 17.5675 6.26691C17.5675 6.86657 16.8941 7.13347 16.2218 7.13347C15.4137 7.13347 14.6056 6.93358 13.866 6.59967L13.4619 8.4668C14.27 8.79956 15.1443 8.93359 15.9525 8.93359C18.443 8.99944 19.9908 7.80014 19.9908 6.00002C19.9908 3.73311 16.8268 3.60024 16.8268 2.60082ZM28 8.86659L26.1828 0.199898H24.231C23.827 0.199898 23.4229 0.466796 23.2882 0.866566L19.9233 8.86659H22.2792L22.7495 7.60026H25.6441L25.9135 8.86659H28ZM24.5678 2.53373L25.2401 5.80006H23.3556L24.5678 2.53373Z"
                                                        fill="#172B85"
                                                />
                                            </g>
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_1_2">
                                                <rect
                                                        width="1440"
                                                        height="1924"
                                                        fill="white"
                                                        transform="translate(-637 -1157)"
                                                />
                                            </clipPath>
                                        </defs>
                                    </svg>
                                </div>
                                <div class="subscription__payment_item">
                                    <svg
                                            width="32"
                                            height="14"
                                            viewBox="0 0 32 14"
                                            fill="none"
                                            xmlns="http://www.w3.org/2000/svg"
                                    >
                                        <rect width="32" height="14" fill="#1E1E1E"/>
                                        <g clip-path="url(#clip0_1_2)">
                                            <rect
                                                    width="1440"
                                                    height="1924"
                                                    transform="translate(-749 -1154)"
                                                    fill="white"
                                            />
                                            <mask
                                                    id="mask0_1_2"
                                                    style="mask-type:alpha"
                                                    maskUnits="userSpaceOnUse"
                                                    x="-749"
                                                    y="-984"
                                                    width="1440"
                                                    height="2159"
                                            >
                                                <rect
                                                        x="-749"
                                                        y="-984"
                                                        width="1440"
                                                        height="2159"
                                                        fill="#F3F3F3"
                                                />
                                            </mask>
                                            <g mask="url(#mask0_1_2)">
                                                <rect
                                                        x="-749"
                                                        y="-993"
                                                        width="1440"
                                                        height="2168"
                                                        fill="#E2E2E2"
                                                />
                                            </g>
                                            <rect
                                                    x="-459"
                                                    y="-788"
                                                    width="860"
                                                    height="975"
                                                    fill="#F1F1F1"
                                            />
                                            <g style="mix-blend-mode:luminosity" opacity="0.6">
                                                <path
                                                        fill-rule="evenodd"
                                                        clip-rule="evenodd"
                                                        d="M14.7585 10.3065V6.43973H16.7542C17.572 6.43973 18.2623 6.1657 18.825 5.62526L18.96 5.48825C19.9879 4.36931 19.9204 2.6262 18.825 1.59099C18.2773 1.04294 17.527 0.746076 16.7542 0.7613H13.5505V10.3065H14.7585ZM14.7586 5.2676V1.93361H16.7847C17.22 1.93361 17.6327 2.10107 17.9403 2.40555C18.5932 3.04494 18.6082 4.1106 17.9779 4.77283C17.6702 5.10014 17.235 5.28282 16.7847 5.2676H14.7586ZM24.5946 4.28564C24.0769 3.8061 23.3716 3.56252 22.4788 3.56252C21.3309 3.56252 20.4681 3.98878 19.8978 4.83369L20.9632 5.51115C21.3534 4.93265 21.8861 4.6434 22.5613 4.6434C22.989 4.6434 23.4016 4.80325 23.7243 5.0925C24.0394 5.36652 24.2194 5.76234 24.2194 6.18099V6.46263C23.7543 6.20383 23.1691 6.06681 22.4488 6.06681C21.6085 6.06681 20.9332 6.26472 20.4305 6.66815C19.9279 7.07158 19.6728 7.6044 19.6728 8.28186C19.6578 8.89842 19.9204 9.48453 20.3855 9.88034C20.8582 10.3066 21.4584 10.5197 22.1637 10.5197C22.9965 10.5197 23.6567 10.1468 24.1594 9.4008H24.2119V10.3066H25.3674V6.27994C25.3674 5.43503 25.1123 4.76519 24.5946 4.28564ZM21.3163 9.10397C21.0686 8.92129 20.9186 8.62443 20.9186 8.30473C20.9186 7.94697 21.0836 7.65011 21.4063 7.41415C21.7365 7.17818 22.1492 7.05639 22.637 7.05639C23.3123 7.04878 23.8376 7.20101 24.2128 7.50549C24.2128 8.02309 24.0102 8.47219 23.6125 8.85278C23.2523 9.21815 22.7645 9.42367 22.2543 9.42367C21.9166 9.43128 21.5864 9.31711 21.3163 9.10397ZM27.9634 13.1762L31.9999 3.77555H30.6869L28.8187 8.46444H28.7962L26.883 3.77555H25.57L28.2185 9.88785L26.718 13.1762H27.9634Z"
                                                        fill="#3C4043"
                                                        fill-opacity="0.71"
                                                />
                                                <path d="M10.5885 5.60254C10.5885 5.22956 10.5585 4.85658 10.4984 4.49121H5.40405V6.59969H8.32263C8.20259 7.27714 7.81244 7.88609 7.24223 8.26668V9.63681H8.98288C10.0033 8.68533 10.5885 7.27714 10.5885 5.60254Z"
                                                      fill="#4285F4"/>
                                                <path d="M5.40412 10.9613C6.85966 10.9613 8.09012 10.4742 8.98295 9.63688L7.2423 8.26675C6.75462 8.60167 6.13189 8.79197 5.40412 8.79197C3.9936 8.79197 2.80066 7.82526 2.373 6.53125H0.579834V7.94705C1.49517 9.79673 3.36337 10.9613 5.40412 10.9613Z"
                                                      fill="#34A853"/>
                                                <path d="M2.37313 6.53127C2.14801 5.85382 2.14801 5.11547 2.37313 4.43041V3.02222H0.579682C-0.193227 4.56742 -0.193227 6.39426 0.579682 7.93947L2.37313 6.53127Z"
                                                      fill="#FBBC04"/>
                                                <path d="M5.40412 2.16971C6.17691 2.15448 6.91968 2.45134 7.47489 2.99178L9.02046 1.42375C8.0376 0.495101 6.74712 -0.0148924 5.40412 0.000331275C3.36337 0.000331275 1.49517 1.17255 0.579834 3.02223L2.373 4.43803C2.80066 3.13641 3.9936 2.16971 5.40412 2.16971Z"
                                                      fill="#EA4335"/>
                                            </g>
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_1_2">
                                                <rect
                                                        width="1440"
                                                        height="1924"
                                                        fill="white"
                                                        transform="translate(-749 -1154)"
                                                />
                                            </clipPath>
                                        </defs>
                                    </svg>
                                </div>
                                <div class="subscription__payment_item">
                                    <svg
                                            width="40"
                                            height="11"
                                            viewBox="0 0 40 11"
                                            fill="none"
                                            xmlns="http://www.w3.org/2000/svg"
                                    >
                                        <rect width="40" height="11" fill="#1E1E1E"/>
                                        <g clip-path="url(#clip0_1_2)">
                                            <rect
                                                    width="1440"
                                                    height="1924"
                                                    transform="translate(-805 -1155)"
                                                    fill="white"
                                            />
                                            <mask
                                                    id="mask0_1_2"
                                                    style="mask-type:alpha"
                                                    maskUnits="userSpaceOnUse"
                                                    x="-805"
                                                    y="-985"
                                                    width="1440"
                                                    height="2159"
                                            >
                                                <rect
                                                        x="-805"
                                                        y="-985"
                                                        width="1440"
                                                        height="2159"
                                                        fill="#F3F3F3"
                                                />
                                            </mask>
                                            <g mask="url(#mask0_1_2)">
                                                <rect
                                                        x="-805"
                                                        y="-994"
                                                        width="1440"
                                                        height="2168"
                                                        fill="#E2E2E2"
                                                />
                                            </g>
                                            <rect
                                                    x="-515"
                                                    y="-789"
                                                    width="860"
                                                    height="975"
                                                    fill="#F1F1F1"
                                            />
                                            <g style="mix-blend-mode:luminosity" opacity="0.6">
                                                <path
                                                        fill-rule="evenodd"
                                                        clip-rule="evenodd"
                                                        d="M4.80003 0.000488281H1.68879C1.47588 0.000488281 1.29481 0.155226 1.26161 0.365332L0.00326377 8.34349C-0.0217469 8.50096 0.100171 8.64286 0.259856 8.64286H1.74519C1.9581 8.64286 2.13917 8.48812 2.17237 8.27759L2.51176 6.12579C2.5445 5.91505 2.72602 5.76052 2.93848 5.76052H3.92339C5.97288 5.76052 7.15562 4.76873 7.46468 2.80345C7.60384 1.94366 7.47057 1.26807 7.06783 0.794808C6.62573 0.275436 5.8413 0.000488281 4.80003 0.000488281ZM5.15898 2.9144C4.98887 4.03083 4.13586 4.03083 3.31107 4.03083H2.84158L3.17095 1.94576C3.19051 1.81987 3.29968 1.72703 3.42707 1.72703H3.64225C4.20409 1.72703 4.73414 1.72702 5.00803 2.04724C5.17119 2.2384 5.2213 2.52219 5.15898 2.9144ZM14.1003 2.87861H12.6104C12.4834 2.87861 12.3738 2.97145 12.3542 3.09756L12.2883 3.5142L12.1841 3.36325C11.8615 2.89503 11.1424 2.73861 10.4245 2.73861C8.77795 2.73861 7.37184 3.98557 7.09794 5.73484C6.95562 6.60727 7.15794 7.44159 7.65289 8.02349C8.107 8.55844 8.75669 8.78139 9.52953 8.78139C10.8561 8.78139 11.5919 7.92833 11.5919 7.92833L11.5253 8.34244C11.5003 8.50075 11.6222 8.64265 11.7809 8.64265H13.123C13.3365 8.64265 13.5165 8.48791 13.5502 8.27738L14.3555 3.17798C14.3809 3.02114 14.2595 2.87861 14.1003 2.87861ZM12.0234 5.77842C11.8797 6.62958 11.2041 7.20096 10.3426 7.20096C9.90996 7.20096 9.56406 7.06222 9.34216 6.79927C9.12195 6.53821 9.03816 6.16642 9.10827 5.75253C9.24259 4.90852 9.92954 4.31862 10.778 4.31862C11.2009 4.31862 11.5449 4.45904 11.7714 4.72431C11.9984 4.99231 12.0885 5.3662 12.0234 5.77842ZM20.538 2.8784H22.0353C22.245 2.8784 22.3673 3.11356 22.2481 3.28556L17.2685 10.4734C17.1879 10.5898 17.0551 10.6591 16.9132 10.6591H15.4178C15.2073 10.6591 15.0843 10.422 15.2062 10.2496L16.7567 8.06096L15.1077 3.22135C15.0506 3.05314 15.1748 2.8784 15.3538 2.8784H16.8249C17.0161 2.8784 17.1847 3.00388 17.2399 3.18682L18.1151 6.10979L20.1801 3.06809C20.261 2.94935 20.3953 2.8784 20.538 2.8784Z"
                                                        fill="#253B80"
                                                />
                                                <path
                                                        fill-rule="evenodd"
                                                        clip-rule="evenodd"
                                                        d="M36.7711 8.34342L38.0479 0.219371C38.0675 0.0932645 38.1768 0.000421055 38.3037 0H39.7412C39.8999 0 40.0218 0.142316 39.9968 0.299791L38.7376 8.27753C38.7048 8.48806 38.5237 8.64279 38.3105 8.64279H37.0267C36.8679 8.64279 36.746 8.5009 36.7711 8.34342ZM26.9923 0.000421627H23.8805C23.6681 0.000421627 23.487 0.155159 23.4537 0.365266L22.1954 8.34342C22.1704 8.5009 22.2923 8.64279 22.4512 8.64279H24.0478C24.1963 8.64279 24.3232 8.53458 24.3464 8.38721L24.7034 6.12572C24.7363 5.91499 24.9177 5.76046 25.1302 5.76046H26.1146C28.1645 5.76046 29.347 4.76866 29.6563 2.80339C29.7959 1.94359 29.6618 1.26801 29.2592 0.794741C28.8173 0.275369 28.0336 0.000421627 26.9923 0.000421627ZM27.3512 2.91433C27.1815 4.03076 26.3285 4.03076 25.5032 4.03076H25.0342L25.3641 1.9457C25.3836 1.8198 25.4919 1.72696 25.6196 1.72696H25.8348C26.3963 1.72696 26.9268 1.72696 27.2005 2.04717C27.3639 2.23833 27.4136 2.52212 27.3512 2.91433ZM36.2917 2.87854H34.8029C34.6749 2.87854 34.5662 2.97139 34.5471 3.09749L34.4812 3.51413L34.3765 3.36318C34.054 2.89497 33.3353 2.73854 32.6174 2.73854C30.9708 2.73854 29.5651 3.9855 29.2912 5.73477C29.1494 6.6072 29.3508 7.44152 29.8458 8.02342C30.3007 8.55837 30.9496 8.78132 31.7224 8.78132C33.049 8.78132 33.7845 7.92826 33.7845 7.92826L33.7182 8.34237C33.6932 8.50069 33.8151 8.64258 33.9749 8.64258H35.3163C35.5288 8.64258 35.7098 8.48784 35.7431 8.27731L36.5488 3.17792C36.5734 3.02107 36.4515 2.87854 36.2917 2.87854ZM34.2151 5.77835C34.0721 6.62951 33.3957 7.20089 32.534 7.20089C32.1022 7.20089 31.7557 7.06215 31.5336 6.7992C31.3134 6.53815 31.2306 6.16636 31.2999 5.75246C31.4348 4.90845 32.1209 4.31855 32.9694 4.31855C33.3925 4.31855 33.7363 4.45897 33.9631 4.72424C34.1909 4.99224 34.281 5.36614 34.2151 5.77835Z"
                                                        fill="#179BD7"
                                                />
                                            </g>
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_1_2">
                                                <rect
                                                        width="1440"
                                                        height="1924"
                                                        fill="white"
                                                        transform="translate(-805 -1155)"
                                                />
                                            </clipPath>
                                        </defs>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div class="subscription_after_text">Не проходит оплата? Напиши на support@34travel.me, и мы найдем решение!</div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>



