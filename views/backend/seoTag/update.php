<?php
/* @var $this SeoTagController */
/* @var $model SeoTag */

$this->pageTitle = 'Редактирование тега';
$this->breadcrumbs = [
    'SEO-теги' => ['index'],
    'Редактирование',
];
$this->menu = [
    ['label' => 'Все SEO-теги', 'url' => ['index']],
    ['label' => 'Добавить тег', 'url' => ['create']],
];
?>

<h1><?= $this->pageTitle ?> «<?= $model->title ?>»</h1>

<?php $this->renderPartial('_form', ['model' => $model]); ?>