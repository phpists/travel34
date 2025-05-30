<?php
/* @var $this StyleController */
/* @var $model Style */

$this->pageTitle = 'Редактирование стиля';
$this->breadcrumbs = [
    'Стили' => ['index'],
    'Редактирование',
];
$this->menu = [
    ['label' => 'Все стили', 'url' => ['index']],
    ['label' => 'Добавить стиль', 'url' => ['create']],
];
?>

<h1><?= $this->pageTitle ?> «<?= $model->title ?>»</h1>

<?php $this->renderPartial('_form', ['model' => $model]); ?>