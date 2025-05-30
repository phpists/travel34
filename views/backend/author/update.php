<?php
/* @var $this AuthorController */
/* @var $model Author */

$this->pageTitle = 'Редактирование автора';
$this->breadcrumbs = [
    'Авторы' => ['index'],
    'Редактирование',
];
$this->menu = [
    ['label' => 'Все авторы', 'url' => ['index']],
    ['label' => 'Добавить автора', 'url' => ['create']],
];
?>

<h1><?= $this->pageTitle ?> «<?= $model->title ?>»</h1>

<?php $this->renderPartial('_form', ['model' => $model]); ?>