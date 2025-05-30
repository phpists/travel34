<?php
/* @var $this UserController */
/* @var $model User */

$this->pageTitle = 'Редактирование пользователя';
$this->breadcrumbs = [
    'Пользователи' => ['index'],
    'Редактирование',
];
$this->menu = [
    ['label' => 'Все пользователи', 'url' => ['index']],
    ['label' => 'Добавить пользователя', 'url' => ['create']],
];
?>

<h1><?= $this->pageTitle ?> «<?= $model->username ?>»</h1>

<?php $this->renderPartial('_form', ['model' => $model]); ?>