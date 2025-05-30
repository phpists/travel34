<?php
/* @var $this SettingController */
/* @var $model Setting */

$this->pageTitle = 'Редактирование настройку';
$this->breadcrumbs = [
    'Настройки' => ['index'],
    'Редактирование',
];
$this->menu = [
    ['label' => 'Все настройки', 'url' => ['index']],
    ['label' => 'Добавить настройку', 'url' => ['create']],
];
?>

    <h1><?= $this->pageTitle ?> «<?= $model->name ?>»</h1>

<?php $this->renderPartial('_form', ['model' => $model]); ?>