<?php
/* @var $this GtbRubricController */
/* @var $model GtbRubric */

$this->pageTitle = 'Добавление рубрики';
$this->breadcrumbs = [
    'Рубрики' => ['index'],
    'Добавление',
];
$this->menu = [
    ['label' => 'Все рубрики', 'url' => ['index']],
];
?>

<h1><?= $this->pageTitle ?></h1>

<?php $this->renderPartial('_form', ['model' => $model]); ?>