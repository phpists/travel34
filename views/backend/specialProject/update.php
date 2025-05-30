<?php
/* @var $this SpecialProjectController */
/* @var $model SpecialProject */

$this->pageTitle = 'Редактирование спецпроекта';
$this->breadcrumbs = [
    'Спецпроекты' => ['index'],
    'Редактирование',
];
$this->menu = [
    ['label' => 'Все спецпроекты', 'url' => ['index']],
    ['label' => 'Добавить спецпроект', 'url' => ['create']],
];
?>

<h1><?= $this->pageTitle ?> «<?= $model->title ?>»</h1>

<?php $this->renderPartial('_form', ['model' => $model]); ?>