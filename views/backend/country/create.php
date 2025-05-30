<?php
/* @var $this CountryController */
/* @var $model Country */

$this->pageTitle = 'Добавление страны';
$this->breadcrumbs = [
    'Страны' => ['index'],
    'Добавление',
];
$this->menu = [
    ['label' => 'Все страны', 'url' => ['index']],
];
?>

<h1><?= $this->pageTitle ?></h1>

<?php $this->renderPartial('_form', ['model' => $model]); ?>