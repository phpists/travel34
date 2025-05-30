<?php
/* @var $this TestResultController */
/* @var $model TestResult */
/* @var $parent_model TestWidget */

$this->pageTitle = 'Добавление результата';
$this->breadcrumbs = [
    'Виджеты тестов' => ['testWidget/index'],
    'Редактирование' => ['testWidget/update', 'id' => $parent_model->id],
    'Результаты виджета' => ['index', 'parent' => $parent_model->id],
    'Добавление',
];
$this->menu = [
    ['label' => 'Все результаты', 'url' => ['index', 'parent' => $parent_model->id]],
];
$this->menu[] = ['label' => 'Вопросы виджета', 'url' => ['testQuestion/index', 'parent' => $parent_model->id], 'linkOptions' => ['class' => 'btn btn-inverse']];
?>

<h1><?= $this->pageTitle ?></h1>
<div class="alert"><strong>Виджет:</strong> <?= CHtml::encode($parent_model->title) ?></div>

<?php $this->renderPartial('_form', ['model' => $model, 'parent_model' => $parent_model]); ?>