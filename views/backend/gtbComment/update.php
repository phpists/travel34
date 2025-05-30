<?php
/* @var $this GtbCommentController */
/* @var $model GtbComment */

$this->pageTitle = 'Редактирование комментария';
$this->breadcrumbs = [
    'Комментарии' => ['index'],
    'Редактирование',
];
$this->menu = [
    ['label' => 'Все комментарии', 'url' => ['index']],
];
?>

<h1><?= $this->pageTitle ?> «<?= $model->id ?>»</h1>

<?php $this->renderPartial('_form', ['model' => $model]); ?>