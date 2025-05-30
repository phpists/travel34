<?php
/* @var $this BlockController */
/* @var $model Block */

$this->pageTitle = 'Блоки';
$this->breadcrumbs = [
    'Блоки',
];
$this->menu = [
    ['label' => 'Добавить блок', 'url' => ['create']],
];
?>

<h1><?= $this->pageTitle ?></h1>

<?php
$this->widget('bootstrap.widgets.TbExtendedGridView', [
    'id' => 'block-grid',
    'type' => 'striped bordered',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => [
        [
            'name' => 'id',
            'headerHtmlOptions' => ['style' => 'text-align: center; width: 30px'],
            'htmlOptions' => ['style' => 'text-align: center'],
        ],
        'name',
        'description',
        [
            'name' => 'status_id',
            'class' => 'bootstrap.widgets.TbToggleColumn',
            'filter' => Block::getStatusOptions(),
            'toggleAction' => 'toggle',
            'headerHtmlOptions' => ['style' => 'text-align: center; width: 80px'],
            'htmlOptions' => ['style' => 'text-align: center'],
            'uncheckedButtonLabel' => 'Опубликовать',
            'checkedButtonLabel' => 'Скрыть',
        ],
        [
            'class' => 'bootstrap.widgets.TbButtonColumn',
            'htmlOptions' => ['style' => 'width: 50px'],
            'template' => '{update}{delete}',
            'buttons' => [
                'update' => [
                    'url' => 'Yii::app()->createUrl("block/update", ["id"=>$data->id])',
                ],
                'delete' => [
                    'url' => 'Yii::app()->createUrl("block/delete", ["id"=>$data->id])',
                ],
            ],
        ],
    ],
]);
?>
