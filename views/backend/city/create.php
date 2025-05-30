<?php
/* @var $this CityController */
/* @var $model City */

$this->pageTitle = 'Добавление города';
$this->breadcrumbs = [
    'Города' => ['index'],
    'Добавление',
];
$this->menu = [
    ['label' => 'Все города', 'url' => ['index']],
];
?>

<h1><?= $this->pageTitle ?></h1>

<?php $this->renderPartial('_form', ['model' => $model]); ?>