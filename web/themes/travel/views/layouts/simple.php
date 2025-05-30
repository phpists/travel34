<?php
/* @var $this FrontEndController */
/* @var $content string */

$themeUrl = Yii::app()->theme->baseUrl;

/** @var CClientScript $cs */
$cs = Yii::app()->clientScript;
$cs->registerPackage('jquery');

$cs->registerCssFile('https://fonts.googleapis.com/css?family=PT+Serif:400,400i,700,700i|Roboto+Condensed:400,400i,700,700i&subset=cyrillic');
$cs->registerCssFile(Common::assetsTime($themeUrl . '/css/vendor.css'));
$cs->registerCssFile(Common::assetsTime($themeUrl . '/css/style.css'));
$cs->registerCssFile(Common::assetsTime($themeUrl . '/css/select2.css'));
$cs->registerCssFile(Common::assetsTime($themeUrl . '/css/main.css'));
$cs->registerCssFile(Common::assetsTime($themeUrl . '/css/new_post_template.css'));
$cs->registerCssFile(Common::assetsTime($themeUrl . '/css/custom.css'));

$cs->registerScriptFile(Common::assetsTime($themeUrl . '/js/modernizr-custom.js'));

if ($this->interactive) {
    $cs->registerCssFile(Common::assetsTime($themeUrl . '/css/interactive.css'));
    $cs->registerScriptFile(Common::assetsTime($themeUrl . '/js/simple-share.min.js'));
    $cs->registerScriptFile(Common::assetsTime($themeUrl . '/js/interactive.js'));
}
if ($this->interactiveTest) {
    $cs->registerCssFile(Common::assetsTime($themeUrl . '/css/test.css'));
    $cs->registerScriptFile(Common::assetsTime($themeUrl . '/js/test.js'));
}
?>
<!DOCTYPE html>
<html lang="<?= Yii::app()->language == 'by' ? 'be' : Yii::app()->language ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= CHtml::encode($this->getPageTitle()) ?></title>
</head>
<body>

<?= $content ?>

</body>
</html>
