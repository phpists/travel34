<?php
/* @var $this EmailTemplateController */
/* @var $model EmailTemplate */

$this->pageTitle = 'Добавление шаблона письма';
$this->breadcrumbs = [
    'Шаблоны писем' => ['index'],
    'Добавление',
];
$this->menu = [
    ['label' => 'Все шаблоны', 'url' => ['index']],
];
?>

<h1><?= $this->pageTitle ?></h1>

<?php $this->renderPartial('_form', ['model' => $model]); ?>