<?php
/* @var $this EmailTemplateController */
/* @var $model EmailTemplate */

$this->pageTitle = 'Шаблоны писем';
$this->breadcrumbs = [
    'Шаблоны писем',
];
$this->menu = [
    ['label' => 'Добавить шаблон', 'url' => ['create']],
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
        'subject',
        'description',
        [
            'class' => 'bootstrap.widgets.TbButtonColumn',
            'htmlOptions' => ['style' => 'width: 50px'],
            'template' => '{update}',
            'buttons' => [
                'update' => [
                    'url' => 'Yii::app()->createUrl("emailTemplate/update", ["id"=>$data->id])',
                ],
            ],
        ],
    ],
]);
?>
