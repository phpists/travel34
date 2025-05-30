<?php

/* @var $this GtbController */
/* @var $text string */

$themeUrl = Yii::app()->theme->baseUrl;
?>

<div class="wide-box">
    <div class="vetliva-roulette-box">

        <?= BlocksHelper::get('vetliva_intro_text') ?>

        <div class="full-width b-festival__header calendar-2017">
            <div class="b-festival__header__logos">
                <span class="b-festival__headerl__logo">
                    <img src="<?= $themeUrl ?>/images/vetliva-roulette-logo.png" alt="">
                </span>
            </div>

            <div class="b-festival__header__col b-festival__header__col1 desktop-view">
                <h2>
                    <span>Что хочу</span>
                </h2>
            </div>
            <div class="b-festival__header__col b-festival__header__col2 desktop-view">
                <h2>
                    <span>Куда хочу</span>
                </h2>
            </div>
            <div class="b-festival__header__col b-festival__header__col3 desktop-view">
                <h2>
                    <span>Популярность</span>
                </h2>
            </div>

            <div class="b-festival__header__filters">
                <div class="b-festival__header__col b-festival__header__col1">
                    <div class="mobile-view">
                        <h2>
                            <span>Что хочу</span>
                        </h2>
                    </div>
                    <ul>
                        <li class="b-festival__li__group">
                            <input id="chk_param1_all" checked="" class="b-festival__check__param1__group" value="" type="checkbox">
                            <label for="chk_param1_all">Все сразу!</label>
                        </li>
                        <li>
                            <input id="chk_param1_1" class="b-festival__check__param1" value="1" type="checkbox">
                            <label for="chk_param1_1">Природа и отдых</label>
                        </li>
                        <li>
                            <input id="chk_param1_2" class="b-festival__check__param1" value="2" type="checkbox">
                            <label for="chk_param1_2">Заброшенные руины</label>
                        </li>
                        <li>
                            <input id="chk_param1_3" class="b-festival__check__param1" value="3" type="checkbox">
                            <label for="chk_param1_3">Культовые сооружения</label>
                        </li>
                        <li>
                            <input id="chk_param1_4" class="b-festival__check__param1" value="4" type="checkbox">
                            <label for="chk_param1_4">Замки, дворцы и усадьбы</label>
                        </li>
                        <li>
                            <input id="chk_param1_5" class="b-festival__check__param1" value="5" type="checkbox">
                            <label for="chk_param1_5">Музеи и галереи</label>
                        </li>
                        <li>
                            <input id="chk_param1_6" class="b-festival__check__param1" value="6" type="checkbox">
                            <label for="chk_param1_6">Городские достопримечательности</label>
                        </li>
                    </ul>
                </div>
                <div class="b-festival__header__col b-festival__header__col2-alt">
                    <div class="mobile-view">
                        <h2>
                            <span>Куда хочу</span>
                        </h2>
                    </div>
                    <ul>
                        <li class="b-festival__li__group">
                            <input id="chk_param2_all" checked="" class="b-festival__check__param2__group" value="" type="checkbox">
                            <label for="chk_param2_all">Вся Беларусь</label>
                        </li>
                    </ul>
                    <div class="b-festival__header__col2-alt-wrapper">
                        <ul>
                            <li>
                                <input id="chk_param2_1" class="b-festival__check__param2" value="Br" type="checkbox">
                                <label for="chk_param2_1">Брестская область</label>
                            </li>
                            <li>
                                <input id="chk_param2_2" class="b-festival__check__param2" value="Vi" type="checkbox">
                                <label for="chk_param2_2">Витебская область</label>
                            </li>
                            <li>
                                <input id="chk_param2_3" class="b-festival__check__param2" value="Gr" type="checkbox">
                                <label for="chk_param2_3">Гродненская область</label>
                            </li>
                            <li>
                                <input id="chk_param2_4" class="b-festival__check__param2" value="Go" type="checkbox">
                                <label for="chk_param2_4">Гомельская область</label>
                            </li>
                            <li>
                                <input id="chk_param2_5" class="b-festival__check__param2" value="Mi" type="checkbox">
                                <label for="chk_param2_5">Минская область</label>
                            </li>
                            <li>
                                <input id="chk_param2_6" class="b-festival__check__param2" value="Mo" type="checkbox">
                                <label for="chk_param2_6">Могилевская область </label>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="b-festival__header__col b-festival__header__col3">
                    <div class="mobile-view">
                        <h2>
                            <span>Популярность</span>
                        </h2>
                    </div>
                    <ul>
                        <li class="b-festival__li__group">
                            <input id="chk_param3_all" checked="" class="b-festival__check__param3__group" value="" type="checkbox">
                            <label for="chk_param3_all">Любые</label>
                        </li>
                        <li>
                            <input id="chk_param3_1" class="b-festival__check__param3" value="fam" type="checkbox">
                            <label for="chk_param3_1">Известные</label>
                        </li>
                        <li>
                            <input id="chk_param3_2" class="b-festival__check__param3" value="unk" type="checkbox">
                            <label for="chk_param3_2">Нераскрученные</label>
                        </li>
                        <li>
                            <input id="chk_param3_3" class="b-festival__check__param3" value="34" type="checkbox">
                            <label for="chk_param3_3">Выбор 34</label>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="b-festival__button__submit__wrap">
                <button class="b-festival__button__submit" type="button">Поехали !</button>
            </div>
        </div>

        <div class="full-width nothing-found" style="display: none;">
            Извини, ничего нет. Попробуй изменить настройки поиска.
        </div>

        <div class="full-content-width">
            <?= $text ?>
        </div>

    </div>
</div>