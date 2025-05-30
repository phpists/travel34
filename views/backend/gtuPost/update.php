<?php
/* @var $this GtuPostController */
/* @var $model GtuPost */

$this->pageTitle = 'Редактирование поста';
$this->breadcrumbs = [
    'Посты' => ['index'],
    'Редактирование',
];
$this->menu = [
    ['label' => 'Все посты', 'url' => ['index']],
    ['label' => 'Добавить пост', 'url' => ['create']],
];
?>

<h1><?= $this->pageTitle ?> «<?= $model->title ?>»</h1>

<?php $this->renderPartial('_form', ['model' => $model]); ?>