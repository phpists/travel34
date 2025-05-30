<?php
/* @var $this TestQuestionController */
/* @var $model TestQuestion */
/* @var $parent_model TestWidget */

$this->pageTitle = 'Вопросы виджета';
$this->breadcrumbs = [
    'Виджеты тестов' => ['testWidget/index'],
    'Редактирование' => ['testWidget/update', 'id' => $parent_model->id],
    'Вопросы виджета',
];
$this->menu = [
    ['label' => 'Добавить вопрос', 'url' => ['create', 'parent' => $parent_model->id]],
];
$this->menu[] = ['label' => 'Результаты виджета', 'url' => ['testResult/index', 'parent' => $parent_model->id], 'linkOptions' => ['class' => 'btn btn-inverse']];
?>

<h1><?= $this->pageTitle ?></h1>
<div class="alert" style="margin: 0"><strong>Виджет:</strong> <?= CHtml::encode($parent_model->title) ?></div>

<?php
$this->widget('bootstrap.widgets.TbExtendedGridView', [
    'id' => 'test-question-grid',
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
            'name' => 'position',
            'class' => 'bootstrap.widgets.TbEditableColumn',
            'editable' => [
                'url' => $this->createUrl('editableSaver'),
                'type' => 'text',
            ],
        ],
        [
            'class' => 'bootstrap.widgets.TbButtonColumn',
            'htmlOptions' => ['style' => 'width: 50px'],
            'template' => '{update}{delete}',
        ],
    ],
]);
