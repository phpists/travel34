<?php
/* @var $this EmailTemplateController */
/* @var $model EmailTemplate */

$this->pageTitle = 'Редактирование шаблона письма';
$this->breadcrumbs = [
    'Шаблоны писем' => ['index'],
    'Редактирование',
];
$this->menu = [
    ['label' => 'Все шаблоны', 'url' => ['index']],
];
?>

<h1><?= $this->pageTitle ?> «<?= $model->subject ?>»</h1>

<?php $this->renderPartial('_form', ['model' => $model]); ?>