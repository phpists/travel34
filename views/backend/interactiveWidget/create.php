<?php
/* @var $this InteractiveWidgetController */
/* @var $model InteractiveWidget */

$this->pageTitle = 'Добавление виджета';
$this->breadcrumbs = [
    'Интерактивные виджеты' => ['index'],
    'Добавление',
];
$this->menu = [
    ['label' => 'Все виджеты', 'url' => ['index']],
];
?>

<h1><?= $this->pageTitle ?></h1>

<?php $this->renderPartial('_form', ['model' => $model]); ?>