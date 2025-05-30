<?php
/* @var $this BlockAfterPostController */
/* @var $model BlockAfterPost */

$this->pageTitle = 'Добавление блока под постом';
$this->breadcrumbs = [
    'Блок под постом' => ['index'],
    'Добавление',
];
$this->menu = [
    ['label' => 'Все блоки', 'url' => ['index']],
];
?>

    <h1><?= $this->pageTitle ?></h1>

<?php $this->renderPartial('_form', ['model' => $model]); ?>