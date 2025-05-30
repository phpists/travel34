<?php
/* @var $this GeoController */
/* @var $page Geo page */
/* @var $lettersDict array */
/* @var $worldParts array */

$baseUrl = Yii::app()->baseUrl;
$cs = Yii::app()->getClientScript();
$cs->registerScriptFile($baseUrl . '/themes/travel/js/tags.js');
?>


<div class="b-main">
    <div class="b-counties">
        <div class="b-counties__select js-tags-type">
            Показать:
            <a href="javascript:void(0)" data-type="country" class="current">Страны</a>
            <a href="javascript:void(0)" data-type="city">Города</a>
        </div>

        <div class="b-counties__alph">
            <?php foreach ($lettersDict as $letterKey => $value) { ?>
                <a class="js-letter" data-value="<?= strtoupper($letterKey) ?>" href="javascript:void(0)"><?= strtoupper($value['title']) ?></a>
            <?php } ?>
        </div>

        <div class="b-counties__cont">
            <?php foreach ($worldParts as $worldPartId => $worldPartData) { ?>
                <a href="javascript:void(0)" data-value="<?= $worldPartId ?>" class="js-world-part">
                    <?= $worldPartData['title'] ?>
                </a>
            <?php } ?>
        </div>

        <!-- По континетнам -->

        <div class="b-counties__list b-countries__list__cont">
            <?php foreach ($worldParts as $worldPartId => $worldPartData) { ?>
                <?php if (!empty($worldPartData['countries']) || !empty($worldPartData['cities'])) { ?>
                    <div class="b-counties__list__simple" data-world-part="<?= $worldPartId; ?>">
                        <h2><?= $worldPartData['title'] ?></h2>
                        <ul>
                            <?php foreach ($worldPartData['countries'] as $item) { ?>
                                <li class="js-tag-country" data-visible="1"><a href="<?= $item->getUrl() ?>"><?= $item->title ?></a></li>
                            <?php } ?>
                            <?php foreach ($worldPartData['cities'] as $item) { ?>
                                <li class="js-tag-city" data-visible="1"><a href="<?= $item->getUrl() ?>"><?= $item->title ?></a></li>
                            <?php } ?>
                        </ul>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>

        <!-- По алфавиту -->
        <div class="b-counties__list b-counties__list__alph" style="display:none;">
            <?php foreach ($lettersDict as $letterKey => $data) { ?>
                <div class="b-counties__list__simple" data-letter="<?= strtoupper($letterKey) ?>">
                    <h2><?= $data['title'] ?></h2>
                    <ul>
                        <?php foreach ($data['countries'] as $item) { ?>
                            <li class="js-tag-country" data-visible="1"><a href="<?= $item->getUrl() ?>"><?= $item->title ?></a></li>
                        <?php } ?>
                        <?php foreach ($data['cities'] as $item) { ?>
                            <li class="js-tag-city" data-visible="1"><a href="<?= $item->getUrl() ?>"><?= $item->title ?></a></li>
                        <?php } ?>
                    </ul>
                </div>
            <?php } ?>
        </div>
    </div>

</div>