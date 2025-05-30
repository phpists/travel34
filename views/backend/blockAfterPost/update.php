<?php
/* @var $this BlockAfterPostController */
/* @var $model BlockAfterPost */

$this->pageTitle = 'Редактирование блока под постом';
$this->breadcrumbs = [
    'Блок под постом' => ['index'],
    'Редактирование',
];
$this->menu = [
    ['label' => 'Все блоки', 'url' => ['index']],
    ['label' => 'Добавить блок', 'url' => ['create']],
];
?>

    <h1><?= $this->pageTitle ?> «<?= $model->title ?>»</h1>

<?php $this->renderPartial('_form', ['model' => $model]); ?>