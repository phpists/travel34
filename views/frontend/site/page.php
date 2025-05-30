<?php
/* @var $this SiteController */
/* @var $model Page */

$this->pageTitle = $model->page_title;
$this->pageTitle = $model->page_title;
if (!empty($model->description)) {
    $this->setMetaDescription($model->description);
}
$this->setMetaKeywords($model->page_keywords);
$this->setUrl($model->getUrl());

$themeUrl = Yii::app()->theme->baseUrl;

/** @var CClientScript $cs */
$cs = Yii::app()->clientScript;

$cs->registerCssFile(Common::assetsTime($themeUrl . '/css/galleria.classic.css'));
$cs->registerScriptFile(Common::assetsTime($themeUrl . '/js/galleria-1.2.7.js'));
$cs->registerScriptFile(Common::assetsTime($themeUrl . '/js/galleria.classic.js'));
?>

<div class="b-main">
    <div class="b-content">
        <div class="b-post">
            <h1 class="b-post__title"><?= $model->title ?></h1>
            <div class="b-post__text">
                <div class="b-post__text__wrapper">
                    <?= $model->text ?>
                </div>
            </div>
        </div>
    </div>
</div>
