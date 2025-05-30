<?php
/* @var $this UserController */
/* @var $model User */

$this->pageTitle = 'Добавление пользователя';
$this->breadcrumbs = [
    'Пользователи' => ['index'],
    'Добавление',
];
$this->menu = [
    ['label' => 'Все пользователи', 'url' => ['index']],
];
?>

<h1><?= $this->pageTitle ?></h1>

<?php $this->renderPartial('_form', ['model' => $model]); ?>