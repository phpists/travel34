<?php
/* @var $this GtbRubricController */
/* @var $model GtbRubric */

$this->pageTitle = 'Редактирование рубрики';
$this->breadcrumbs = [
    'Рубрики' => ['index'],
    'Редактирование',
];
$this->menu = [
    ['label' => 'Все рубрики', 'url' => ['index']],
    ['label' => 'Добавить рубрику', 'url' => ['create']],
];
?>

<h1><?= $this->pageTitle ?> «<?= $model->title ?>»</h1>

<?php $this->renderPartial('_form', ['model' => $model]); ?>