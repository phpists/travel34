<?php
/* @var $this SubscriptionF1Controller */
$promoDiscountPrice = UserPromoCodes::getSubscriptionDiscountPriceCookie();
?>
<div class="post-body subscription__body" style="background-color: #E2E2E2 !important;">
    <div class="container-wide container-form">
        <div class="wide-box">
            <?= $this->renderPartial('/subscriptionF2/parts/menu', [
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
                                <button class="paymentBtn" type="button" data-url="<?= $this->createUrl('/subscription/f2/step-three-payment') ?>">
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
                                                    transform="translate(-692 -1154)"
                                                    fill="white"
                                            />
                                            <mask
                                                    id="mask0_1_2"
                                                    style="mask-type:alpha"
                                                    maskUnits="userSpaceOnUse"
                                                    x="-692"
                                                    y="-984"
                                                    width="1440"
                                                    height="2159"
                                            >
                                                <rect
                                                        x="-692"
                                                        y="-984"
                                                        width="1440"
                                                        height="2159"
                                                        fill="#F3F3F3"
                                                />
                                            </mask>
                                            <g mask="url(#mask0_1_2)">
                                                <rect
                                                        x="-692"
                                                        y="-993"
                                                        width="1440"
                                                        height="2168"
                                                        fill="#E2E2E2"
                                                />
                                            </g>
                                            <rect
                                                    x="-402"
                                                    y="-788"
                                                    width="860"
                                                    height="975"
                                                    fill="#F1F1F1"
                                            />
                                            <g style="mix-blend-mode:luminosity" opacity="0.6">
                                                <path
                                                        fill-rule="evenodd"
                                                        clip-rule="evenodd"
                                                        d="M4.27189 2.46767C4.87196 2.51829 5.47202 2.16395 5.84707 1.71471C6.21586 1.25282 6.45963 0.632735 6.39713 0C5.86582 0.0253094 5.20949 0.354332 4.83445 0.816229C4.49066 1.21485 4.19688 1.86024 4.27189 2.46767ZM11.4102 10.6173V0.753001H15.0669C16.9546 0.753001 18.2735 2.06909 18.2735 3.9926C18.2735 5.91612 16.9296 7.24486 15.0169 7.24486H12.9229V10.6173H11.4102ZM6.3908 2.58786C5.86215 2.55706 5.37979 2.74879 4.99016 2.90366C4.73943 3.00333 4.52711 3.08772 4.36558 3.08772C4.1843 3.08772 3.96321 2.99881 3.71498 2.89899C3.38972 2.76819 3.01785 2.61865 2.62788 2.62582C1.73403 2.63848 0.902686 3.15099 0.446384 3.96722C-0.491221 5.59968 0.202607 8.01673 1.10896 9.34547C1.55276 10.0035 2.08407 10.7248 2.78415 10.6995C3.09214 10.6878 3.31369 10.5926 3.54298 10.4941C3.80695 10.3807 4.08117 10.2629 4.50934 10.2629C4.92267 10.2629 5.1849 10.3777 5.43662 10.4878C5.67597 10.5925 5.90582 10.693 6.24704 10.6869C6.97212 10.6742 7.42842 10.0288 7.87222 9.37078C8.35116 8.66451 8.56162 7.97523 8.59356 7.87064L8.5973 7.85854C8.59654 7.85777 8.59063 7.85503 8.5802 7.8502L8.58018 7.85019C8.42007 7.77599 7.19638 7.20891 7.18464 5.68826C7.17286 4.41189 8.15525 3.7652 8.3099 3.66341C8.31931 3.65721 8.32565 3.65303 8.32852 3.65086C7.70345 2.71441 6.72834 2.61317 6.3908 2.58786ZM21.0363 10.6932C21.9864 10.6932 22.8678 10.206 23.2678 9.43404H23.2991V10.6173H24.6992V5.70723C24.6992 4.28358 23.5741 3.36611 21.8427 3.36611C20.2362 3.36611 19.0486 4.29623 19.0048 5.57435H20.3675C20.48 4.96693 21.0363 4.56831 21.7989 4.56831C22.724 4.56831 23.2428 5.00489 23.2428 5.80847V6.35262L21.3551 6.46651C19.5986 6.57408 18.6485 7.30172 18.6485 8.56719C18.6485 9.84532 19.6299 10.6932 21.0363 10.6932ZM21.4425 9.52273C20.6362 9.52273 20.1236 9.13044 20.1236 8.52934C20.1236 7.90926 20.6174 7.5486 21.5613 7.49165L23.2427 7.38409V7.9409C23.2427 8.86469 22.4676 9.52273 21.4425 9.52273ZM29.3435 11.0032C28.7371 12.7306 28.0433 13.3 26.5682 13.3C26.4556 13.3 26.0806 13.2874 25.9931 13.2621V12.0789C26.0868 12.0915 26.3181 12.1042 26.4369 12.1042C27.1057 12.1042 27.4808 11.8194 27.712 11.0791L27.8495 10.6426L25.2868 3.46101H26.8682L28.6496 9.2885H28.6809L30.4623 3.46101H32L29.3435 11.0032ZM12.9227 2.04365H14.6667C15.9793 2.04365 16.7294 2.75232 16.7294 3.9988C16.7294 5.24529 15.9793 5.96028 14.6604 5.96028H12.9227V2.04365Z"
                                                        fill="black"
                                                />
                                            </g>
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_1_2">
                                                <rect
                                                        width="1440"
                                                        height="1924"
                                                        fill="white"
                                                        transform="translate(-692 -1154)"
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
                            </div>
                        </div>

                        <div class="subscription_after_text">Не проходит оплата? Напиши на support@34travel.me, и мы найдем решение!</div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>



