<?php
/* @var $text string */

$themeUrl = Yii::app()->theme->baseUrl;

// data-where="belarus"
// data-where="foreign"

// data-what="party"
// data-what="active"
// data-what="city"
?>

<div class="wide-box">
    <?= BlocksHelper::get('winter_roulette_intro_text') ?>
</div>

<div class="wide-box">
    <div class="roulette-wrap jagermeister-roulette">
        <img src="<?= $themeUrl ?>/images/ruletka/roulette-logo.png" class="logo" alt="">
        <div class="title">
            <img src="<?= $themeUrl ?>/images/ruletka/roulette-jagermeister.png" alt="">
            <h2><span>Зимние<br> приключения</span></h2>
        </div>
        <form action="" class="roulette-form" data-param1="where" data-param2="what">
            <div class="field-row">
                <div class="sel-wrap">
                    <label for="where-select">Где?</label>
                    <div class="want-select-wrap">
                        <select name="" class="jagermeister-select" id="where-select" style="width: 100%">
                            <option value="belarus">В Беларуси</option>
                            <option value="foreign">Не в Беларуси</option>
                        </select>
                    </div>
                </div>
                <div class="sel-wrap">
                    <label for="what-select">Что?</label>
                    <div class="season-select-wrap">
                        <select name="" class="jagermeister-select" id="what-select" style="width: 100%">
                            <option value="active">Активный отдых</option>
                            <option value="party">Вечеринки и концерты</option>
                            <option value="city">Городские вылазки</option>
                        </select>
                    </div>
                </div>
            </div>
            <button type="button" style="background: #f77a1e;">Поехали!</button>
        </form>
        <p class="nothing-found">Ничего не найдено</p>
        <div class="events-grid">

            <?= $text ?>

        </div>
        <button type="button" class="again" style="background: #f77a1f;">ЕЩЕ РАЗ!</button>
    </div>
</div>

<?= BlocksHelper::get('winter_roulette_footer_text') ?>
