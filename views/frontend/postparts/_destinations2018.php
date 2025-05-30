<?php
/* @var $text string */

$themeUrl = Yii::app()->theme->baseUrl;

// data-want="europe"
// data-want="exotic"
// data-want="far"

// data-short="short"
// data-short="long"
?>

<div class="wide-box">
    <?= BlocksHelper::get('destinations2018_intro_text') ?>
</div>

<div class="wide-box">
    <div class="roulette-wrap">
        <div class="title">
            <img src="<?= $themeUrl ?>/images/ruletka/roulette-new.png" alt="">
            <h2><span>Рулетка<br> путешествий</span></h2>
        </div>
        <form action="" class="roulette-form" data-param1="want" data-param2="season">
            <div class="field-row">
                <div class="sel-wrap">
                    <label for="want-select">КУДА?</label>
                    <div class="want-select-wrap">
                        <select name="" id="want-select" style="width: 100%">
                            <option value="europe">Нераскрученная Европа</option>
                            <option value="exotic">Доступная экзотика</option>
                            <option value="far">Дальние края</option>
                        </select>
                    </div>
                </div>
                <div class="sel-wrap">
                    <label for="season-select">КАК ДОЛГО?</label>
                    <div class="season-select-wrap">
                        <select name="" id="season-select" style="width: 100%">
                            <option value="short">Короткая поездка</option>
                            <option value="long">Долгая поездка</option>
                        </select>
                    </div>
                </div>
            </div>
            <button type="button" style="background: #ffd800;">Показать!</button>
        </form>
        <p class="nothing-found">Ничего не найдено</p>
        <div class="events-grid">

            <?= $text ?>

        </div>
        <button type="button" class="again" style="background: #ffd800;">ЕЩЕ РАЗ!</button>
        <div class="box-bottom">
            <img src="<?= $themeUrl ?>/images/visa.png" alt="">
        </div>
    </div>
</div>
