<?php
/* @var $this GtbPostController */
/* @var $model GtbPost */

$this->pageTitle = 'Добавление поста';
$this->breadcrumbs = [
    'Посты' => ['index'],
    'Добавление',
];
$this->menu = [
    ['label' => 'Все посты', 'url' => ['index']],
];
?>

<h1><?= $this->pageTitle ?></h1>

<?php $this->renderPartial('_form', ['model' => $model]); ?>