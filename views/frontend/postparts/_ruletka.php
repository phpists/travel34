<?php
/* @var $text string */

$themeUrl = Yii::app()->theme->baseUrl;
?>

<div class="full-width b-festival__promo calendar-2017">
    <?= BlocksHelper::get('ruletka_intro_text') ?>
</div>

<div class="roulette-wrap full-width">
    <div class="title">
        <img src="<?= $themeUrl ?>/images/ruletka/roulette.png" alt="">
        <h2><span>Рулетка<br> приключений</span></h2>
    </div>
    <div class="roulette-form" data-param1="want" data-param2="season">
        <div class="field-row">
            <div class="sel-wrap">
                <label for="want-select">Я хочу:</label>
                <div class="want-select-wrap">
                    <select id="want-select" style="width: 100%">
                        <option value="gastronomy">Совершить гастрономическое открытие</option>
                        <option value="party">Потусить, как в последний раз</option>
                        <option value="harmony">Почувствовать гармонию</option>
                        <option value="challenge">Проверить себя на прочность</option>
                        <option value="all">Что угодно</option>
                    </select>
                </div>
            </div>
            <div class="sel-wrap">
                <label for="season-select">Когда:</label>
                <div class="season-select-wrap">
                    <select id="season-select" style="width: 100%">
                        <option value="spring">Весной</option>
                        <option value="summer">Летом</option>
                        <option value="autumn">Осенью</option>
                        <option value="winter">Зимой</option>
                        <option value="all">Когда угодно</option>
                    </select>
                </div>
            </div>
        </div>
        <button type="button">Показать!</button>
    </div>
    <p class="nothing-found">Ничего не найдено</p>
    <div class="events-grid">

        <?= $text ?>

    </div>
    <button type="button" class="again">ЕЩЕ РАЗ!</button>
    <div class="bank-box">
        <div class="descr">
            <div class="bank-logo">
                <img src="<?= $themeUrl ?>/images/ruletka/prior.png" alt="">
            </div>
            <?= BlocksHelper::get('ruletka_form_text') ?>
        </div>
        <div class="bank-form-box">
            <?php $this->widget('application.widgets.ProposalFormWidget'); ?>
        </div>
    </div>
</div>

<?= BlocksHelper::get('ruletka_footer_text') ?>
