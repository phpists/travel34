<?php
/* @var $this AuthorController */
/* @var $model Author */

$this->pageTitle = 'Добавление автора';
$this->breadcrumbs = [
    'Авторы' => ['index'],
    'Добавление',
];
$this->menu = [
    ['label' => 'Все авторы', 'url' => ['index']],
];
?>

<h1><?= $this->pageTitle ?></h1>

<?php $this->renderPartial('_form', ['model' => $model]); ?>