<?php
/* @var $this InteractiveWidgetController */
/* @var $model InteractiveWidget */

$this->pageTitle = 'Интерактивные виджеты';
$this->breadcrumbs = [
    'Интерактивные виджеты',
];
$this->menu = [
    ['label' => 'Добавить виджет', 'url' => ['create']],
];
?>

<h1><?= $this->pageTitle ?></h1>

<?php
$this->widget('bootstrap.widgets.TbExtendedGridView', [
    'id' => 'interactive-widget-grid',
    'type' => 'striped bordered',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => [
        [
            'name' => 'id',
            'headerHtmlOptions' => ['style' => 'text-align: center; width: 30px'],
            'htmlOptions' => ['style' => 'text-align: center'],
        ],
        'title',
        [
            'header' => 'Шорткод',
            'headerHtmlOptions' => ['style' => 'width: 140px'],
            'type' => 'raw',
            'value' => function ($data) {
                return '<samp class="copytext">[interactive id=' . $data->id . ']</samp>';
            },
        ],
        [
            'class' => 'bootstrap.widgets.TbButtonColumn',
            'htmlOptions' => ['style' => 'width: 50px'],
            'template' => '{update}{delete}',
        ],
    ],
]);
