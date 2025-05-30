<?php
/* @var $this CityController */
/* @var $model City */

$this->pageTitle = 'Редактирование города';
$this->breadcrumbs = [
    'Города' => ['index'],
    'Редактирование',
];
$this->menu = [
    ['label' => 'Все города', 'url' => ['index']],
    ['label' => 'Добавить город', 'url' => ['create']],
];
?>

<h1><?= $this->pageTitle ?> «<?= $model->title ?>»</h1>

<?php $this->renderPartial('_form', ['model' => $model]); ?>