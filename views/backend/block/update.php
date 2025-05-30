<?php
/* @var $this BlockController */
/* @var $model Block */

$this->pageTitle = 'Редактирование блока';
$this->breadcrumbs = [
    'Блоки' => ['index'],
    'Редактирование',
];
$this->menu = [
    ['label' => 'Все блоки', 'url' => ['index']],
    ['label' => 'Добавить блок', 'url' => ['create']],
];
?>

<h1><?= $this->pageTitle ?> «<?= $model->description ?>»</h1>

<?php $this->renderPartial('_form', ['model' => $model]); ?>