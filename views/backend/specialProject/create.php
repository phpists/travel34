<?php
/* @var $this SpecialProjectController */
/* @var $model SpecialProject */

$this->pageTitle = 'Добавление спецпроекта';
$this->breadcrumbs = [
    'Спецпроекты' => ['index'],
    'Добавление',
];
$this->menu = [
    ['label' => 'Все спецпроекты', 'url' => ['index']],
];
?>

<h1><?= $this->pageTitle ?></h1>

<?php $this->renderPartial('_form', ['model' => $model]); ?>