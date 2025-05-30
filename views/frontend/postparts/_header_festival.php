<?php
$themeUrl = Yii::app()->theme->baseUrl;
/** @var CClientScript $cs */
$cs = Yii::app()->clientScript;
$cs->registerScriptFile($themeUrl . '/js/festival.js');
?>
<div class="full-width b-festival__promo">
    <p><strong>
            Вместе с <a href="http://velcom.by" title="" target="_blank">velcom</a> мы подготовили для тебя огромный гид по главным и самым интересным музыкальным фестивалям этого сезона.
        В нашей подборке ты найдешь, кажется, все, что душа пожелает: от пляжных пикников с дружеской атмосферой до масштабных недельных марафонов с лайнапом в половину твоего трек-листа из плеера.
        Выбраться на природу с палаткой, посетить городские шоукейсы или забраться в гейзерный источник, пока поет PJ Harvey, – решать тебе.
        </strong>
    </p>
</div>
<div class="full-width b-festival__header">
    <div class="b-festival__header__logos">
        <a href="http://velcom.by" class="b-festival__headerl__logo left" target="_blank" title="velcom">
            <img alt="" src="<?= $themeUrl ?>/images/festival/velcom-logo.png">
        </a>
        <a href="http://velcom.by" class="b-festival__headerl__logo right" target="_blank" title="velcom">
            <img alt="" src="<?= $themeUrl ?>/images/festival/velcom-V.png">
        </a>
    </div>
    <div class="b-festival__header__col b-festival__header__col1 desktop-view"><h2>Дата</h2></div>
    <div class="b-festival__header__col b-festival__header__col2 desktop-view"><h2>Страна</h2></div>
    <div class="b-festival__header__col b-festival__header__col3 desktop-view"><h2>Музыкальный стиль</h2></div>
    <p><img alt="" class="full-width-img b-festival__soundline" src="<?= $themeUrl ?>/images/festival/soundline.png" ></p>
    <div class="b-festival__header__filters">
        <div class="b-festival__header__col b-festival__header__col1">
            <div class="mobile-view"><h2>Дата</h2></div>
            <ul>
                <img alt="" src="<?= $themeUrl ?>/images/festival/check.png" style="width:0;height:0;display: none;" />
                <img alt="" src="<?= $themeUrl ?>/images/festival/check.png" style="width:0;height:0;display: none"/>
                <img alt="" src="<?= $themeUrl ?>/images/festival/button-active.png" style="width:0;height:0;display: none"/>
                <li class="b-festival__li__group">
                    <input id="check_month_all" type="checkbox" checked class="b-festival__check__month__group" value="">
                    <label for="check_month_all">Любые даты</label>
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
                        <input id="check_be" type="checkbox" class="b-festival__check__country" value="Be">
                        <label for="check_be">Бельгия</label>
                    </li>
                    <li>
                        <input id="check_bu" type="checkbox" class="b-festival__check__country" value="Bu">
                        <label for="check_bu">Болгария</label>
                    </li>
                    <li>
                        <input id="check_gr" type="checkbox" class="b-festival__check__country" value="Br">
                        <label for="check_gr">Великобритания</label>
                    </li>
                    <li>
                        <input id="check_hu" type="checkbox" class="b-festival__check__country" value="Hu">
                        <label for="check_hu">Венгрия</label>
                    </li>
                    <li>
                        <input id="check_de" type="checkbox" class="b-festival__check__country" value="De">
                        <label for="check_de">Германия</label>
                    </li>
                    <li>
                        <input id="check_ge" type="checkbox" class="b-festival__check__country" value="Gr">
                        <label for="check_ge">Грузия</label>
                    </li>
                    <li>
                        <input id="check_dk" type="checkbox" class="b-festival__check__country" value="Dk">
                        <label for="check_dk">Дания</label>
                    </li>
                    <li>
                        <input id="check_ir" type="checkbox" class="b-festival__check__country" value="Ir">
                        <label for="check_ir">Ирландия</label>
                    </li>
                    <li>
                        <input id="check_is" type="checkbox" class="b-festival__check__country" value="Is">
                        <label for="check_is">Исландия</label>
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
                        <input id="check_lv" type="checkbox" class="b-festival__check__country" value="Lv">
                        <label for="check_lv">Латвия</label>
                    </li>
                    <li>
                        <input id="check_lt" type="checkbox" class="b-festival__check__country" value="Lt">
                        <label for="check_lt">Литва</label>
                    </li>
                    <li>
                        <input id="check_nl" type="checkbox" class="b-festival__check__country" value="Nl">
                        <label for="check_nl">Нидерланды</label>
                    </li>
                </ul>
                <ul>
                    <li>
                        <input id="check_no" type="checkbox" class="b-festival__check__country" value="No">
                        <label for="check_no">Норвегия</label>
                    </li>
                    <li>
                        <input id="check_pl" type="checkbox" class="b-festival__check__country" value="Pl">
                        <label for="check_pl">Польша</label>
                    </li>
                    <li>
                        <input id="check_po" type="checkbox" class="b-festival__check__country" value="Po">
                        <label for="check_po">Португалия</label>
                    </li>
                    <li>
                        <input id="check_ru" type="checkbox" class="b-festival__check__country" value="Ru">
                        <label for="check_ru">Россия</label>
                    </li>
                    <li>
                        <input id="check_se" type="checkbox" class="b-festival__check__country" value="Se">
                        <label for="check_se">Сербия</label>
                    </li>
                    <li>
                        <input id="check_sk" type="checkbox" class="b-festival__check__country" value="Sk">
                        <label for="check_sk">Словакия</label>
                    </li>
                    <li>
                        <input id="check_sl" type="checkbox" class="b-festival__check__country" value="Sl">
                        <label for="check_sl">Словения</label>
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
                        <input id="check_hh" type="checkbox" class="b-festival__check__country" value="Hh">
                        <label for="check_hh">Хорватия</label>
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
                </ul>
            </div>
        </div>
        <div class="b-festival__header__col b-festival__header__col3">
            <div class="mobile-view"><h2>Музыкальный стиль</h2></div>
            <ul>
                <li class="b-festival__li__group">
                    <input id="check_style_all" type="checkbox"  checked class="b-festival__check__style__group" value="">
                    <label for="check_style_all">Любой стиль</label>
                </li>
                <li>
                    <input id="check_pop" type="checkbox" class="b-festival__check__style" value="pop">
                    <label for="check_pop">Pop</label>
                </li>
                <li>
                    <input id="check_rock" type="checkbox" class="b-festival__check__style" value="rock">
                    <label for="check_rock">Rock</label>
                </li>
                <li>
                    <input id="check_electro" type="checkbox" class="b-festival__check__style" value="electro">
                    <label for="check_electro">Electronic</label>
                </li>
                <li>
                    <input id="check_metal" type="checkbox" class="b-festival__check__style" value="metal">
                    <label for="check_metal">Metal</label>
                </li>
                <li>
                    <input id="check_punk" type="checkbox" class="b-festival__check__style" value="punk">
                    <label for="check_punk">Punk</label>
                </li>
                <li>
                    <input id="check_hiphop" type="checkbox" class="b-festival__check__style" value="hiphop">
                    <label for="check_hiphop">Hip-Hop</label>
                </li>
                <li>
                    <input id="check_jazz" type="checkbox" class="b-festival__check__style" value="jazz">
                    <label for="check_jazz">Jazz</label>
                </li>
                <li>
                    <input id="check_world" type="checkbox" class="b-festival__check__style" value="world">
                    <label for="check_world">World music</label>
                </li>
                <li>
                    <input id="check_reggae" type="checkbox" class="b-festival__check__style" value="reggae">
                    <label for="check_reggae">Reggae</label>
                </li>
            </ul>
        </div>
    </div>
    <div class="b-festival__button__submit__wrap">
        <input type="button" class="b-festival__button__submit"/>
    </div>
</div>
<div class="full-width nothing-found">
    Извини, ничего нет. Попробуй изменить настройки поиска
</div>