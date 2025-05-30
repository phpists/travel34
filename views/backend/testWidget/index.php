<?php
/* @var $this TestWidgetController */
/* @var $model TestWidget */

$this->pageTitle = 'Виджеты тестов';
$this->breadcrumbs = [
    'Виджеты тестов',
];
$this->menu = [
    ['label' => 'Добавить виджет', 'url' => ['create']],
    ['label' => 'Лог', 'url' => ['log']],
];
?>

<h1><?= $this->pageTitle ?></h1>

<?php
$this->widget('bootstrap.widgets.TbExtendedGridView', [
    'id' => 'test-widget-grid',
    'type' => 'striped bordered',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => [
        [
            'name' => 'id',
            'headerHtmlOptions' => ['style' => 'text-align: center; width: 30px'],
            'htmlOptions' => ['style' => 'text-align: center'],
        ],
        [
            'name' => 'type',
            'filter' => TestWidget::getTypeOptions(),
            'value' => function ($data) {
                /** @var $data TestWidget */
                $options = TestWidget::getTypeOptions();
                return isset($options[$data->type]) ? $options[$data->type] : '';
            },
        ],
        'title',
        [
            'name' => 'start_count',
            'class' => 'bootstrap.widgets.TbEditableColumn',
            'editable' => [
                'url' => $this->createUrl('editableSaver'),
            ],
            'headerHtmlOptions' => ['style' => 'width: 80px'],
        ],
        [
            'name' => 'finish_count',
            'class' => 'bootstrap.widgets.TbEditableColumn',
            'editable' => [
                'url' => $this->createUrl('editableSaver'),
            ],
            'headerHtmlOptions' => ['style' => 'width: 80px'],
        ],
        [
            'header' => 'Процент закончивших',
            'headerHtmlOptions' => ['style' => 'width: 80px'],
            'type' => 'raw',
            'value' => function ($data) {
                return $data->finish_count > 0 ? round(100 * $data->finish_count / $data->start_count, 1) : '0';
            },
        ],
        [
            'header' => 'Шорткод',
            'headerHtmlOptions' => ['style' => 'width: 130px'],
            'type' => 'raw',
            'value' => function ($data) {
                return '<samp class="copytext">[test id=' . $data->id . ']</samp>';
            },
        ],
        [
            'headerHtmlOptions' => ['style' => 'width: 150px'],
            'type' => 'raw',
            'value' => function ($data) {
                return CHtml::link('Вопросы', ['testQuestion/index', 'parent' => $data->id], ['class' => 'btn btn-mini', 'style' => 'margin:0']) . "\n" .
                    CHtml::link('Результаты', ['testResult/index', 'parent' => $data->id], ['class' => 'btn btn-mini', 'style' => 'margin:0']);
            },
        ],
        [
            'class' => 'bootstrap.widgets.TbButtonColumn',
            'htmlOptions' => ['style' => 'width: 50px'],
            'template' => '{update}{delete}',
        ],
    ],
]);
