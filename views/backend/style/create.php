<?php
/* @var $this StyleController */
/* @var $model Style */

$this->pageTitle = 'Добавление стиля';
$this->breadcrumbs = [
    'Стили' => ['index'],
    'Добавление',
];
$this->menu = [
    ['label' => 'Все стили', 'url' => ['index']],
];
?>

<h1><?= $this->pageTitle ?></h1>

<?php $this->renderPartial('_form', ['model' => $model]); ?>