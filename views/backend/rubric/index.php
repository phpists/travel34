<?php
/* @var $this RubricController */
/* @var $model Rubric */

$this->pageTitle = 'Рубрики';
$this->breadcrumbs = [
    'Рубрики',
];
$this->menu = [
    ['label' => 'Добавить рубрику', 'url' => ['create']],
];
?>

<h1><?= $this->pageTitle ?></h1>

<?php
$this->widget('bootstrap.widgets.TbExtendedGridView', [
    'id' => 'rubric-grid',
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
            'name' => 'url',
            'type' => 'raw',
            'value' => function ($data) {
                /** @var Rubric $data */
                return CHtml::link($data->url, $data->getUrl(), ['target' => '_blank']);
            },
        ],
        [
            'name' => 'status_id',
            'class' => 'bootstrap.widgets.TbToggleColumn',
            'filter' => Rubric::getStatusOptions(),
            'toggleAction' => 'toggle',
            'headerHtmlOptions' => ['style' => 'text-align: center; width: 150px'],
            'htmlOptions' => ['style' => 'text-align: center; width: 150px'],
            'uncheckedButtonLabel' => 'Отобразить рубрику',
            'checkedButtonLabel' => 'Скрыть рубрику',
        ],
        [
            'class' => 'bootstrap.widgets.TbButtonColumn',
            'htmlOptions' => ['style' => 'width: 50px'],
            'template' => '{update}{delete}',
        ],
    ],
]);
?>
