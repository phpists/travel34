<?php
/* @var $this BlockController */
/* @var $model Block */

$this->pageTitle = 'Добавление блока';
$this->breadcrumbs = [
    'Блоки' => ['index'],
    'Добавление',
];
$this->menu = [
    ['label' => 'Все блоки', 'url' => ['index']],
];
?>

<h1><?= $this->pageTitle ?></h1>

<?php $this->renderPartial('_form', ['model' => $model]); ?>