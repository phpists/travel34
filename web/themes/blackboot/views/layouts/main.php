<?php
/* @var $this BackEndController */
/* @var $content string */

$themeUrl = Yii::app()->theme->baseUrl;

/** @var CClientScript $cs */
$cs = Yii::app()->clientScript;
$cs->registerCssFile(Common::assetsTime($themeUrl . '/css/style.css'));
$cs->registerScriptFile(Common::assetsTime($themeUrl . '/js/alerts.js'));
$cs->registerScriptFile(Common::assetsTime($themeUrl . '/js/clipboard.min.js'));
$cs->registerScriptFile(Common::assetsTime($themeUrl . '/js/admin.js'));
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?= CHtml::encode($this->pageTitle) ?></title>
</head>
<body>

<div class="notify-box">
    <?php $this->widget('bootstrap.widgets.TbAlert'); ?>
</div>

<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container-fluid">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <a class="brand" href="<?= Yii::app()->getBaseUrl(true) ?>"><?= explode('.', Yii::app()->name)[0] ?></a>
            <?php $this->renderPartial('//layouts/_menu'); ?>
        </div>
    </div>
</div>

<div class="cont">
    <div class="container-fluid">
        <?php
        $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
            'homeLink' => CHtml::link('<i class="icon-home"></i>', Yii::app()->homeUrl, array('title' => Yii::t('zii', 'Home'))),
            'links' => isset($this->breadcrumbs) ? $this->breadcrumbs : array(),
        ));
        ?>

        <?= $content ?>

    </div>
</div>

</body>
</html>
