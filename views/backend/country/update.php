<?php
/* @var $this CountryController */
/* @var $model Country */

$this->pageTitle = 'Редактирование страны';
$this->breadcrumbs = [
    'Страны' => ['index'],
    'Редактирование',
];
$this->menu = [
    ['label' => 'Все страны', 'url' => ['index']],
    ['label' => 'Добавить страну', 'url' => ['create']],
];
?>

<h1><?= $this->pageTitle ?> «<?= $model->title ?>»</h1>

<?php $this->renderPartial('_form', ['model' => $model]); ?>