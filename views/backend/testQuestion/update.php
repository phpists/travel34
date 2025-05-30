<?php
/* @var $this TestResultController */
/* @var $model TestResult */
/* @var $parent_model TestWidget */

$this->pageTitle = 'Редактирование вопроса';
$this->breadcrumbs = [
    'Виджеты тестов' => ['testWidget/index'],
    'Редактирование' => ['testWidget/update', 'id' => $parent_model->id],
    'Вопросы виджета' => ['index', 'parent' => $parent_model->id],
    'Редактирование',
];
$this->menu = [
    ['label' => 'Все вопросы', 'url' => ['index', 'parent' => $parent_model->id]],
    ['label' => 'Добавить вопрос', 'url' => ['create', 'parent' => $parent_model->id]],
];
$this->menu[] = ['label' => 'Результаты виджета', 'url' => ['testResult/index', 'parent' => $parent_model->id], 'linkOptions' => ['class' => 'btn btn-inverse']];
?>

<h1><?= $this->pageTitle ?> «<?= $model->title ?>»</h1>
<div class="alert"><strong>Виджет:</strong> <?= CHtml::encode($parent_model->title) ?></div>

<?php $this->renderPartial('_form', ['model' => $model, 'parent_model' => $parent_model]); ?>

<div class="form-items">
    <?php $this->renderPartial('_variant_list', ['item_id' => $model->id]); ?>
</div>
