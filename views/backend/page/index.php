<?php
/* @var $this PageController */
/* @var $model Page */

$this->pageTitle = 'Страницы';
$this->breadcrumbs = [
    'Страницы',
];
$this->menu = [
    ['label' => 'Добавить страницу', 'url' => ['create']],
];
?>

<h1><?= $this->pageTitle ?></h1>

<?php
$this->widget('bootstrap.widgets.TbExtendedGridView', [
    'id' => 'page-grid',
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
            'name' => 'url',
            'type' => 'raw',
            'value' => function ($data) {
                /** @var Page $data */
                return CHtml::link($data->url, $data->getUrl(), ['target' => '_blank']);
            },
        ],
        'title',
        [
            'name' => 'status_id',
            'class' => 'bootstrap.widgets.TbToggleColumn',
            'filter' => Page::getStatusOptions(),
            'toggleAction' => 'toggle',
            'headerHtmlOptions' => ['style' => 'text-align: center; width: 80px'],
            'htmlOptions' => ['style' => 'text-align: center'],
            'uncheckedButtonLabel' => 'Опубликовать',
            'checkedButtonLabel' => 'Черновик',
        ],
        [
            'class' => 'bootstrap.widgets.TbButtonColumn',
            'htmlOptions' => ['style' => 'width: 50px'],
            'template' => '{update}{delete}',
            'buttons' => [
                'update' => [
                    'url' => 'Yii::app()->createUrl("page/update", ["id"=>$data->id])',
                ],
                'delete' => [
                    'url' => 'Yii::app()->createUrl("page/delete", ["id"=>$data->id])',
                ],
            ],
        ],
    ],
]);
?>
