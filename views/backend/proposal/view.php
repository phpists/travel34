<?php
/* @var $this ProposalController */
/* @var $model Proposal */

$this->pageTitle = 'Просмотр заявки';
$this->breadcrumbs = [
    'Заявки' => ['index'],
    'Просмотр',
];
$this->menu = [
    ['label' => 'Все заявки', 'url' => ['index']],
    ['label' => 'Отправить заявки', 'url' => ['send']],
];
?>

<h1><?= $this->pageTitle ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
    'htmlOptions' => array(
        'class' => 'table table-striped table-hover table-detail-view',
    ),
    'data' => $model,
    'attributes' => array(
        'id',
        [
            'name' => 'form_type',
            'value' => (isset(Yii::app()->params['proposalFormTypes'][$model->form_type]) ? Yii::app()->params['proposalFormTypes'][$model->form_type] : $model->form_type),
        ],
        'name',
        'phone',
        'processed:boolean',
        'created_at:datetime',
    ),
)); ?>
