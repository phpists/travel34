<?php
/* @var $this SeoTagController */
/* @var $model SeoTag */

$this->pageTitle = 'Добавление тега';
$this->breadcrumbs = [
    'SEO-теги' => ['index'],
    'Добавление',
];
$this->menu = [
    ['label' => 'Все теги', 'url' => ['index']],
];
?>

<h1><?= $this->pageTitle ?></h1>

<?php $this->renderPartial('_form', ['model' => $model]); ?>