<?php
/* @var $this FrontEndController */
?>
<?php if (!isset(Yii::app()->request->cookies['user_agree'])): ?>
    <div class="bottom__cookies">
        <?= Yii::app()->language == 'en' ? BlocksHelper::get('cookies_en') : BlocksHelper::get('cookies') ?>
        <div class="bottom__cookies_btns">
            <button id="cookies__accept" class="popup-with-form_faves" data-href="#form_cookies">Отклонить</button>
            <button id="cookies__cancel">Принять</button>
        </div>
    </div>
<?php endif; ?>
<div class="form_wrap form__edit_wrap form__popup mfp-hide" id="form_cookies">
    <form action="<?= $this->createUrl('/set/cookie') ?>" method="POST" id="form_cookie" class="form">
        <p class="form_header">Управление файлами Cookies</p>
        <div class="edit-collection-types">
            <div class="square-radio edit-collection-type">
                <input type="checkbox"
                       id="productivity"
                       name="user_agree"
                       checked>
                <label for="productivity">
                    Производительность (обязательно)
                    <span>Обеспечивают корректную работу сайта.</span>
                </label>
            </div>
            <div class="square-radio edit-collection-type">
                <input type="checkbox" id="analytics" name="analytics">
                <label for="analytics">
                    Аналитика
                    <span>Позволяют понять, какие наши материалы читают больше.</span>
                </label>
            </div>
            <div class="square-radio edit-collection-type">
                <input type="checkbox" id="marketing" name="marketing">
                <label for="marketing">
                    Маркетинг
                    <span>Позволяют нам показывать релевантную для тебя рекламу.</span>
                </label>
            </div>
        </div>
        <div class="form_button_long">
            <button type="submit">
                Применить
            </button>
        </div>
    </form>
</div>


<footer class="footer">
    <div class="footer__container clearfix">
        <div class="footer__section footer__section_logo">
            <a href="/" class="logo" title="34travel"></a>
        </div>
        <div class="footer__top">

            <div class="footer__section">
                <p class="footer__header">Информация:</p>
                <?= Yii::app()->language == 'en' ? BlocksHelper::get('footer_menu_en') : BlocksHelper::get('footer_menu') ?>
            </div>
            <div class="footer__section footer__section_second footer__section_hide">
                <p class="footer__header">
                    <svg width="22" height="21" viewBox="0 0 22 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                                d="M21.8873 7.5028C21.6722 6.78588 21.2421 6.2124 20.5969 5.87784C19.7844 5.44769 18.8285 5.49546 18.1594 5.61495L16.7494 0.692116C16.6538 0.357557 16.391 0.094735 16.0564 0.0230437C15.7219 -0.0486477 15.3634 0.0469874 15.1244 0.309856C11.7071 4.1334 10.2972 5.06534 6.52147 6.71424L3.55822 7.57456C0.953435 8.33926 -0.552077 11.0875 0.188733 13.6922C0.54719 14.9588 1.38358 16.0342 2.55454 16.6794C3.29535 17.0856 4.10786 17.3006 4.92036 17.3006C5.30271 17.3006 5.70897 17.2529 6.09132 17.1573L6.40198 18.2804C6.56926 18.8778 6.90382 19.4036 7.33396 19.8337L7.83581 20.3117C8.02699 20.479 8.26596 20.5746 8.50493 20.5746C8.7678 20.5746 9.00677 20.4789 9.19795 20.2878C9.55641 19.9054 9.55641 19.308 9.15015 18.9257L8.64831 18.4477C8.45713 18.2566 8.31376 18.0176 8.24207 17.7548L7.93139 16.6315L9.31744 16.2252C13.2844 15.6278 15.0766 15.6756 19.9277 17.0616C20.0233 17.0855 20.095 17.1095 20.1906 17.1095C20.4296 17.1095 20.6925 17.0139 20.8597 16.8227C21.0987 16.5837 21.1943 16.2253 21.0987 15.8907L19.6888 10.9918C20.3101 10.7528 21.1465 10.3227 21.6245 9.53405C22.0068 8.93662 22.1024 8.24361 21.8873 7.5028ZM3.51042 15.0304C2.79351 14.648 2.29168 13.979 2.05271 13.2143C1.59866 11.5893 2.53064 9.91643 4.10785 9.43849L6.25859 8.81714L7.23838 12.2822L7.9075 14.6719L5.75676 15.2933C5.01595 15.5084 4.20344 15.4127 3.51042 15.0304ZM13.2366 13.9789C12.1612 13.9789 11.0858 14.0746 9.81927 14.2418L8.43324 9.34292L8.09867 8.14806C11.1575 6.76203 12.7825 5.68664 15.4351 2.86678L18.8285 14.7914C16.5344 14.2179 14.9094 13.9789 13.2366 13.9789ZM20.0233 8.55436C19.88 8.81723 19.5215 9.00841 19.1869 9.15179L18.709 7.47899C19.0675 7.4312 19.4737 7.43117 19.7366 7.57456C19.8561 7.64625 19.9756 7.74179 20.0711 8.00466C20.1428 8.29142 20.0711 8.43488 20.0233 8.55436ZM13.9774 6.97713C14.2402 7.35948 14.1685 7.8852 13.7862 8.14806C12.902 8.76939 11.8983 9.31902 11.8505 9.34292C11.731 9.41461 11.5877 9.43849 11.4682 9.43849C11.1575 9.43849 10.8707 9.27123 10.7274 8.98446C10.5123 8.57821 10.6796 8.07633 11.0858 7.86125C11.0858 7.86125 12.0417 7.35944 12.8064 6.8098C13.1649 6.49914 13.6906 6.59478 13.9774 6.97713Z"
                                fill="black"/>
                    </svg>
                    Соцсети
                </p>
                <ul class="footer__menu">
                    <li>
                        <a href="https://www.instagram.com/34travel/" target="_blank">
                            Instagram
                        </a>
                    </li>
                    <li>
                        <a href="https://www.facebook.com/34travel" target="_blank">
                            Facebook
                        </a>
                    </li>
                    <li>
                        <a href="https://twitter.com/34travelby" target="_blank">
                            Twitter
                        </a>
                    </li>
                    <li>
                        <a href="https://telegram.me/travel34" target="_blank">
                            Telegram
                        </a>
                    </li>
                    <li>
                        <a href="/" target="_blank">
                            Patreon
                        </a>
                    </li>
                </ul>
            </div>
            <div class="footer__section footer__section_third footer__section_hide">
                <p class="footer__header">
                    <svg width="20" height="22" viewBox="0 0 20 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                              d="M11.3982 0.0827545C11.8054 0.259523 12.0474 0.683592 11.9923 1.12409L11.1328 8.00006H19C19.388 8.00006 19.741 8.22452 19.9056 8.5759C20.0702 8.92729 20.0166 9.34216 19.7682 9.64024L9.76823 21.6402C9.48404 21.9813 9.00903 22.0941 8.60182 21.9174C8.1946 21.7406 7.95267 21.3165 8.00773 20.876L8.86723 14.0001H1.00001C0.611995 14.0001 0.259003 13.7756 0.0944228 13.4242C-0.070157 13.0728 -0.0166119 12.658 0.231791 12.3599L10.2318 0.359872C10.516 0.0188374 10.991 -0.0940143 11.3982 0.0827545ZM3.13505 12.0001H10C10.2868 12.0001 10.5599 12.1232 10.7497 12.3383C10.9395 12.5533 11.0279 12.8395 10.9923 13.1241L10.4154 17.7396L16.865 10.0001H10C9.71318 10.0001 9.44016 9.87689 9.25033 9.66186C9.06051 9.44683 8.97216 9.16064 9.00773 8.87602L9.58467 4.26051L3.13505 12.0001Z"
                              fill="black"/>
                    </svg>
                    Проекты
                </p>
                <ul class="footer__menu">
                    <li>
                        <a href="https://34travel.me/gotobelarus">
                            GO TO BELARUS!
                        </a>
                    </li>
                </ul>
            </div>
            <div class="footer__section footer__section_hide">
                <p class="footer__header footer__header_big">
                    <svg width="22" height="13" viewBox="0 0 22 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                                d="M21.9043 0.886303C21.9043 0.862979 21.9043 0.816326 21.9043 0.793003C21.9043 0.769679 21.9043 0.746344 21.9043 0.723021C21.9043 0.699697 21.8804 0.676396 21.8804 0.629749C21.8804 0.606425 21.8565 0.559772 21.8565 0.536449C21.8565 0.513125 21.8326 0.48979 21.8087 0.466467C21.7848 0.443143 21.7848 0.39649 21.7608 0.373166V0.349849C21.7369 0.326525 21.7369 0.326536 21.713 0.303213C21.6891 0.279889 21.6652 0.256554 21.6413 0.23323C21.6174 0.209907 21.5935 0.186595 21.5696 0.186595C21.5457 0.163271 21.5218 0.13993 21.4978 0.13993C21.4739 0.116607 21.45 0.116618 21.4261 0.0932945C21.4022 0.0699708 21.3782 0.0699822 21.3543 0.0466586C21.3304 0.0466586 21.2826 0.0233122 21.2587 0.0233122C21.2348 0.0233122 21.2108 -5.69424e-06 21.163 -5.69424e-06C21.1391 -5.69424e-06 21.0913 -5.69424e-06 21.0674 -5.69424e-06C21.0435 -5.69424e-06 21.0196 -5.69424e-06 20.9956 -5.69424e-06H0.908684C0.884771 -5.69424e-06 0.860875 -5.69424e-06 0.836962 -5.69424e-06C0.813049 -5.69424e-06 0.765217 -5.69424e-06 0.741304 -5.69424e-06C0.717391 -5.69424e-06 0.693472 0.0233122 0.645646 0.0233122C0.621733 0.0233122 0.573901 0.0466586 0.549988 0.0466586C0.526075 0.0466586 0.50218 0.0699708 0.478267 0.0932945C0.454354 0.116618 0.430429 0.116607 0.406516 0.13993C0.382603 0.163254 0.358707 0.163271 0.334794 0.186595C0.310881 0.209918 0.286957 0.23323 0.263043 0.23323C0.23913 0.256554 0.215206 0.279889 0.191293 0.303213C0.16738 0.326536 0.167391 0.326525 0.143478 0.349849V0.373166C0.119565 0.39649 0.0956639 0.443143 0.0956639 0.466467C0.0717508 0.48979 0.0717333 0.513125 0.0478202 0.536449C0.0239072 0.559772 0.023913 0.583102 0.023913 0.629749C0.023913 0.653073 5.83815e-06 0.676373 5.83815e-06 0.723021C5.83815e-06 0.746344 5.83815e-06 0.769679 5.83815e-06 0.793003C5.83815e-06 0.816326 5.83815e-06 0.862979 5.83815e-06 0.886303V0.909621V11.6385C5.83815e-06 12.1516 0.430441 12.5714 0.956528 12.5714H21.0435C21.5695 12.5714 22 12.1516 22 11.6385L21.9043 0.886303C21.9043 0.909627 21.9043 0.886303 21.9043 0.886303ZM18.0543 1.84257L10.9043 7.0204L3.75434 1.84257H18.0543ZM1.81739 10.7055V2.77551L10.3304 8.93295C10.4978 9.04957 10.6891 9.11952 10.9043 9.11952C11.1196 9.11952 11.3109 9.04957 11.4783 8.93295L19.9913 2.77551V10.7055H1.81739Z"
                                fill="black"/>
                    </svg>
                    Связь с редакцией
                </p>
                <ul class="footer__menu_connection">
                    <li>
                        <div class="footer__menu_connection_text">Стать автором / предложить идею:</div>
                        <a href="mailto:34travelby@gmail.com"
                           class="footer__menu_connection_link">34travelby@gmail.com</a>
                    </li>
                    <li>
                        <div class="footer__menu_connection_text">По вопросам подписки / оплаты:</div>
                        <a href="mailto:support@34travel.me"
                           class="footer__menu_connection_link">support@34travel.me</a>
                    </li>
                    <li>
                        <div class="footer__menu_connection_text">По вопросам размещения рекламы:</div>
                        <a href="mailto:34travelby@gmail.com"
                           class="footer__menu_connection_link">ad34travel@gmail.com</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="footer__bottom">
            <?= Yii::app()->language == 'en' ? BlocksHelper::get('footer_text_en') : BlocksHelper::get('footer_text') ?>
            <a href="#" class="footer__bottom_text popup-with-form_faves" data-href="#form_cookies">Управление файлами
                Cookies</a>
        </div>
    </div>
</footer>

