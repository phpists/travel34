<?php
/* @var $this SubscriptionF11Controller */
?>
<div class="post-body subscription__body" style="background-color: #E2E2E2 !important;">
    <div class="container-wide container-form">
        <div class="wide-box">
            <h1 class="post-title no-margin">Купить подписку</h1>
            <div class="form_wrap form_wrap_no-margin">
                <div class="form_wrap_inside">
                    <div class="form_header form_header_margin_medium form_success subscription__success">Оплата прошла успешно!</div>
                    <div class="form_section form_section_margin_medium">
                        <p class="subscription__text_bold subscription__text_bold_full">Подарочный сертификат отправлен на e-mail.</p>
                        <div class="subscription__success_img">
                            <svg
                                    width="24"
                                    height="32"
                                    viewBox="0 0 24 32"
                                    fill="none"
                                    xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                        fill-rule="evenodd"
                                        clip-rule="evenodd"
                                        d="M6 2.09863C6 1.54635 6.44772 1.09863 7 1.09863H17C17.5523 1.09863 18 1.54635 18 2.09863V11.6935C18 12.2458 17.5523 12.6935 17 12.6935H7C6.44772 12.6935 6 12.2458 6 11.6935V2.09863Z"
                                        stroke="black"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                />
                                <path
                                        d="M6.33594 1.42323L11.3999 6.31627C11.7555 6.65983 12.2444 6.65983 12.5999 6.31627L17.6639 1.42065"
                                        stroke="black"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                />
                                <path
                                        d="M12 19.1351V30.73"
                                        stroke="black"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                />
                                <path
                                        d="M9 16.5585V25.5767"
                                        stroke="black"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                />
                                <path
                                        d="M15 16.5585V25.5767"
                                        stroke="black"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                />
                                <path
                                        d="M18 4.31944L21.553 2.03138C21.8629 1.83188 22.2309 1.85323 22.5256 2.08782C22.8203 2.32241 22.9998 2.73682 23 3.18314V4.09141C22.9997 4.61811 22.7507 5.09157 22.371 5.28697L20.5 6.25192L21.12 6.78529C21.3488 6.98156 21.5048 7.29049 21.5513 7.63949C21.5978 7.98849 21.5308 8.34678 21.366 8.63016L20.8 9.60156C20.6111 9.92597 20.3148 10.1169 20 10.1169"
                                        stroke="black"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                />
                                <path
                                        d="M6 4.31944L2.447 2.03138C2.1371 1.83188 1.76912 1.85323 1.47439 2.08782C1.17967 2.32241 1.00018 2.73682 1 3.18314V4.09141C1.00026 4.61811 1.24935 5.09157 1.629 5.28697L3.5 6.25192L2.88 6.78529C2.65122 6.98156 2.49523 7.29049 2.4487 7.63949C2.40216 7.98849 2.46918 8.34678 2.634 8.63016L3.2 9.60156C3.38885 9.92597 3.68524 10.1169 4 10.1169"
                                        stroke="black"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                />
                            </svg>
                        </div>
                        <p class="subscription__text">Спасибо, что ты с нами!</p>
                    </div>
                    <div class="form_text_line form_text_line_gray"><?= $subscription['title'] ?></div>
                    <div class="form_section_margin_big form__info_wrap">
                        <div class="form__label form__label_gray form_date_wrap">
                            <span class="form__info_text">Дата покупки:</span>
                            <span>с момента активации пользователем</span>
                        </div>
                        <div class="form__label form__label_gray form_ordernum_wrap">
                            <span class="form__info_text">Номер заказа</span>
                            <span>#<?= $userSubscription['id'] ?></span>
                        </div>
                    </div>
                    <a href="<?= $redirect_url ?>" class="form_link form_link_text subscription__link">
                        На главную
                        <svg
                                width="13"
                                height="24"
                                viewBox="0 0 13 24"
                                fill="none"
                                xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                    fill-rule="evenodd"
                                    clip-rule="evenodd"
                                    d="M7.7043 12.1421L0.0639486 23.8972L4.96334 23.8972L12.6038 12.1421L4.96341 0.387119L0.0639487 0.387112L7.7043 12.1421Z"
                                    fill="black"
                            />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>



