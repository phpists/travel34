<?php
/* @var $this SettingController */
/* @var $model Setting */

$this->pageTitle = 'Добавить настройку';
$this->breadcrumbs = [
    'Настройки' => ['index'],
    'Добавление',
];
$this->menu = [
    ['label' => 'Все настройки', 'url' => ['index']],
];
?>

    <h1><?= $this->pageTitle ?></h1>

<?php $this->renderPartial('_form', ['model' => $model]); ?>