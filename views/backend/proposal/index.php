<?php
/* @var $this ProposalController */
/* @var $model Proposal */

$this->pageTitle = 'Заявки';
$this->breadcrumbs = [
    'Заявки',
];
$this->menu = [
    ['label' => 'Отправить заявки', 'url' => ['send']],
];
?>

<h1><?= $this->pageTitle ?></h1>

<?php
$this->widget('bootstrap.widgets.TbExtendedGridView', [
    'id' => 'comment-grid',
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
            'name' => 'form_type',
            'filter' => Yii::app()->params['proposalFormTypes'],
            'value' => function ($model) {
                return (isset(Yii::app()->params['proposalFormTypes'][$model->form_type]) ? Yii::app()->params['proposalFormTypes'][$model->form_type] : $model->form_type);
            },
        ],
        'name',
        'phone',
        'processed:boolean',
        [
            'class' => 'bootstrap.widgets.TbButtonColumn',
            'template' => '{view} {delete}',
            'headerHtmlOptions' => ['style' => 'width: 50px;'],
        ],
    ],
]);
?>
