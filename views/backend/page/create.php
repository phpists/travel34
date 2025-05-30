<?php
/* @var $this PageController */
/* @var $model Page */

$this->pageTitle = 'Добавление страницы';
$this->breadcrumbs = [
    'Страницы' => ['index'],
    'Добавление',
];
$this->menu = [
    ['label' => 'Все страницы', 'url' => ['index']],
];
?>

<h1><?= $this->pageTitle ?></h1>

<?php $this->renderPartial('_form', ['model' => $model]); ?>