<?php
/* @var $this PageController */
/* @var $model Page */

$this->pageTitle = 'Редактирование страницы';
$this->breadcrumbs = [
    'Страницы' => ['index'],
    'Редактирование',
];
$this->menu = [
    ['label' => 'Все страницы', 'url' => ['index']],
    ['label' => 'Добавить страницу', 'url' => ['create']],
];
?>

<h1><?= $this->pageTitle ?> «<?= $model->title ?>»</h1>

<?php $this->renderPartial('_form', ['model' => $model]); ?>