<?php
/* @var $this TestResultController */
/* @var $model TestResult */
/* @var $parent_model TestWidget */

$this->pageTitle = 'Результаты виджета';
$this->breadcrumbs = [
    'Виджеты тестов' => ['testWidget/index'],
    'Редактирование' => ['testWidget/update', 'id' => $parent_model->id],
    'Результаты виджета',
];
$this->menu = [
    ['label' => 'Добавить результат', 'url' => ['create', 'parent' => $parent_model->id]],
];
$this->menu[] = ['label' => 'Вопросы виджета', 'url' => ['testQuestion/index', 'parent' => $parent_model->id], 'linkOptions' => ['class' => 'btn btn-inverse']];
?>

<h1><?= $this->pageTitle ?></h1>
<div class="alert" style="margin: 0"><strong>Виджет:</strong> <?= CHtml::encode($parent_model->title) ?></div>

<?php
$this->widget('bootstrap.widgets.TbExtendedGridView', [
    'id' => 'test-result-grid',
    'type' => 'striped bordered',
    'dataProvider' => $model->search($parent_model->id),
    'filter' => $model,
    'columns' => [
        [
            'name' => 'id',
            'headerHtmlOptions' => ['style' => 'text-align: center; width: 30px'],
            'htmlOptions' => ['style' => 'text-align: center'],
        ],
        'title',
        [
            'name' => 'correct_count',
            'filter' => TestResult::getCorrectCountValues(),
            'value' => function ($data) {
                /** @var $data TestResult */
                $options = TestResult::getCorrectCountValues();
                return isset($options[$data->correct_count]) ? $options[$data->correct_count] : '';
            },
            'visible' => $parent_model->type == TestWidget::TYPE_ONE,
        ],
        [
            'class' => 'bootstrap.widgets.TbButtonColumn',
            'htmlOptions' => ['style' => 'width: 50px'],
            'template' => '{update}{delete}',
        ],
    ],
]);
