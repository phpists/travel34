<?php
/* @var $this TestQuestionController */
/* @var $model TestQuestion */
/* @var $parent_model TestWidget */

$this->pageTitle = 'Добавление вопроса';
$this->breadcrumbs = [
    'Виджеты тестов' => ['testWidget/index'],
    'Редактирование' => ['testWidget/update', 'id' => $parent_model->id],
    'Вопросы виджета' => ['index', 'parent' => $parent_model->id],
    'Добавление',
];
$this->menu = [
    ['label' => 'Все вопросы', 'url' => ['index', 'parent' => $parent_model->id]],
];
$this->menu[] = ['label' => 'Результаты виджета', 'url' => ['testResult/index', 'parent' => $parent_model->id], 'linkOptions' => ['class' => 'btn btn-inverse']];
?>

<h1><?= $this->pageTitle ?></h1>
<div class="alert"><strong>Виджет:</strong> <?= CHtml::encode($parent_model->title) ?></div>

<?php $this->renderPartial('_form', ['model' => $model, 'parent_model' => $parent_model]); ?>