<?php
$themeUrl = Yii::app()->theme->baseUrl;
/** @var CClientScript $cs */
$cs = Yii::app()->clientScript;
$cs->registerScriptFile($themeUrl . '/js/festival.js');
?>
<div class="full-width b-festival__promo calendar-2017">
    <p><strong>Вместе с Absolut мы подготовили внушительный гайд по главным выставкам современного искусства, которые
            будут проходить в Европе в 2017-м. Выбрать есть из чего: от швейцарской арт-ярмарки, которую называют
            «олимпиадой в сфере искусства», до локальных рассуждений на тему Big Data и queer. Чекай даты, направления
            и выбирай – сходить на выставку обложек пластинок, позалипать на кинетические скульптуры или даже прикупить
            работу какого-нибудь подающего надежды литовского художника.</strong></p>
</div>
<div class="full-width b-festival__header calendar-2017">
    <div class="b-festival__header__logos">
        <p>Партнер проекта:</p>
        <span class="b-festival__headerl__logo">
            <img alt="" src="<?= $themeUrl ?>/images/calendar/absolut-logo.png">
        </span>
    </div>

    <div class="b-festival__header__col b-festival__header__col1 desktop-view"><h2>Дата</h2></div>
    <div class="b-festival__header__col b-festival__header__col2 desktop-view"><h2>Страна</h2></div>
    <div class="b-festival__header__col b-festival__header__col3 desktop-view"><h2>Форма</h2></div>

    <div class="b-festival__header__filters">
        <div class="b-festival__header__col b-festival__header__col1">
            <div class="mobile-view"><h2>Дата</h2></div>
            <ul>
                <img alt="" src="<?= $themeUrl ?>/images/calendar/check.png" style="width:0;height:0;display: none;">
                <img alt="" src="<?= $themeUrl ?>/images/calendar/check.png" style="width:0;height:0;display: none">
                <img alt="" src="<?= $themeUrl ?>/images/calendar/button-active.png" style="width:0;height:0;display: none">
                <li class="b-festival__li__group">
                    <input id="check_month_all" type="checkbox" checked class="b-festival__check__month__group" value="">
                    <label for="check_month_all">Любые даты</label>
                </li>
                <li>
                    <input id="check_jan" type="checkbox" class="b-festival__check__month" value="01">
                    <label for="check_jan">Январь</label>
                </li>
                <li>
                    <input id="check_feb" type="checkbox" class="b-festival__check__month" value="02">
                    <label for="check_feb">Февраль</label>
                </li>
                <li>
                    <input id="check_mar" type="checkbox" class="b-festival__check__month" value="03">
                    <label for="check_mar">Март</label>
                </li>
                <li>
                    <input id="check_apr" type="checkbox" class="b-festival__check__month" value="04">
                    <label for="check_apr">Апрель</label>
                </li>
                <li>
                    <input id="check_may" type="checkbox" class="b-festival__check__month" value="05">
                    <label for="check_may">Май</label>
                </li>
                <li>
                    <input id="check_jun" type="checkbox" class="b-festival__check__month" value="06">
                    <label for="check_jun">Июнь</label>
                </li>
                <li>
                    <input id="check_jul" type="checkbox" class="b-festival__check__month" value="07">
                    <label for="check_jul">Июль</label>
                </li>
                <li>
                    <input id="check_aug" type="checkbox" class="b-festival__check__month" value="08">
                    <label for="check_aug">Август</label>
                </li>
                <li>
                    <input id="check_sep" type="checkbox" class="b-festival__check__month" value="09">
                    <label for="check_sep">Сентябрь</label>
                </li>
                <li>
                    <input id="check_oct" type="checkbox" class="b-festival__check__month" value="10">
                    <label for="check_oct">Октябрь</label>
                </li>
                <li>
                    <input id="check_nov" type="checkbox" class="b-festival__check__month" value="11">
                    <label for="check_nov">Ноябрь</label>
                </li>
                <li>
                    <input id="check_dec" type="checkbox" class="b-festival__check__month" value="12">
                    <label for="check_dec">Декабрь</label>
                </li>
            </ul>
        </div>
        <div class="b-festival__header__col b-festival__header__col2-alt">
            <div class="mobile-view"><h2>Страна</h2></div>
            <ul>
                <li class="b-festival__li__group">
                    <input id="check_country_all" type="checkbox" checked class="b-festival__check__country__group" value="">
                    <label for="check_country_all">Любая страна</label>
                </li>
            </ul>
            <div class="b-festival__header__col2-alt-wrapper">
                <ul>
                    <li>
                        <input id="check_au" type="checkbox" class="b-festival__check__country" value="Au">
                        <label for="check_au">Австрия</label>
                    </li>
                    <li>
                        <input id="check_gr" type="checkbox" class="b-festival__check__country" value="Br">
                        <label for="check_gr">Великобритания</label>
                    </li>
                    <li>
                        <input id="check_de" type="checkbox" class="b-festival__check__country" value="De">
                        <label for="check_de">Германия</label>
                    </li>
                    <li>
                        <input id="check_dk" type="checkbox" class="b-festival__check__country" value="Dk">
                        <label for="check_dk">Дания</label>
                    </li>
                    <li>
                        <input id="check_sp" type="checkbox" class="b-festival__check__country" value="Sp">
                        <label for="check_sp">Испания</label>
                    </li>
                    <li>
                        <input id="check_it" type="checkbox" class="b-festival__check__country" value="It">
                        <label for="check_it">Италия</label>
                    </li>
                    <li>
                        <input id="check_lt" type="checkbox" class="b-festival__check__country" value="Lt">
                        <label for="check_lt">Литва</label>
                    </li>
                    <li>
                        <input id="check_nl" type="checkbox" class="b-festival__check__country" value="Nl">
                        <label for="check_nl">Нидерланды</label>
                    </li>
                    <li>
                        <input id="check_no" type="checkbox" class="b-festival__check__country" value="No">
                        <label for="check_no">Норвегия</label>
                    </li>
                    <li>
                        <input id="check_pl" type="checkbox" class="b-festival__check__country" value="Pl">
                        <label for="check_pl">Польша</label>
                    </li>
                </ul>
                <ul>
                    <li>
                        <input id="check_po" type="checkbox" class="b-festival__check__country" value="Po">
                        <label for="check_po">Португалия</label>
                    </li>
                    <li>
                        <input id="check_ru" type="checkbox" class="b-festival__check__country" value="Ru">
                        <label for="check_ru">Россия</label>
                    </li>
                    <li>
                        <input id="check_ua" type="checkbox" class="b-festival__check__country" value="Ua">
                        <label for="check_ua">Украина</label>
                    </li>
                    <li>
                        <input id="check_fl" type="checkbox" class="b-festival__check__country" value="Fl">
                        <label for="check_fl">Финляндия</label>
                    </li>
                    <li>
                        <input id="check_fe" type="checkbox" class="b-festival__check__country" value="Fr">
                        <label for="check_fe">Франция</label>
                    </li>
                    <li>
                        <input id="check_cz" type="checkbox" class="b-festival__check__country" value="Cz">
                        <label for="check_cz">Чехия</label>
                    </li>
                    <li>
                        <input id="check_sh" type="checkbox" class="b-festival__check__country" value="Sh">
                        <label for="check_sh">Швейцария</label>
                    </li>
                    <li>
                        <input id="check_sv" type="checkbox" class="b-festival__check__country" value="Sv">
                        <label for="check_sv">Швеция</label>
                    </li>
                    <li>
                        <input id="check_ee" type="checkbox" class="b-festival__check__country" value="Ee">
                        <label for="check_ee">Эстония</label>
                    </li>
                </ul>
            </div>
        </div>
        <div class="b-festival__header__col b-festival__header__col3">
            <div class="mobile-view"><h2>Форма</h2></div>
            <ul>
                <li class="b-festival__li__group">
                    <input id="check_style_all" type="checkbox"  checked class="b-festival__check__style__group" value="">
                    <label for="check_style_all">Любая форма</label>
                </li>
                <li>
                    <input id="check_sculpture" type="checkbox" class="b-festival__check__style" value="sculpture">
                    <label for="check_sculpture">Скульптура</label>
                </li>
                <li>
                    <input id="check_installation" type="checkbox" class="b-festival__check__style" value="installation">
                    <label for="check_installation">Инсталляция</label>
                </li>
                <li>
                    <input id="check_photo" type="checkbox" class="b-festival__check__style" value="photo">
                    <label for="check_photo">Фотография</label>
                </li>
                <li>
                    <input id="check_painting" type="checkbox" class="b-festival__check__style" value="painting">
                    <label for="check_painting">Живопись / графика</label>
                </li>
                <li>
                    <input id="check_digitalart" type="checkbox" class="b-festival__check__style" value="digitalart">
                    <label for="check_digitalart">Digital-art</label>
                </li>
            </ul>
        </div>
    </div>
    <div class="b-festival__button__submit__wrap">
        <input type="button" class="b-festival__button__submit">
    </div>
</div>
<div class="full-width nothing-found">
    Извини, ничего нет. Попробуй изменить настройки поиска.
</div>