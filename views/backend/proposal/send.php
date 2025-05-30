<?php
/* @var $this ProposalController */
/* @var $model SendProposalsForm */
/* @var $data array */
/* @var $form TbActiveForm */

$this->pageTitle = 'Отправка заявок';
$this->breadcrumbs = [
    'Заявки' => ['index'],
    'Отправка',
];
$this->menu = [
    ['label' => 'Все заявки', 'url' => ['index']],
];
?>

<h1><?= $this->pageTitle ?></h1>


<div class="form">

    <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', [
        'id' => 'send-proposals-form',
        'enableAjaxValidation' => false,
        'type' => 'horizontal',
    ]); ?>

    <?= $form->errorSummary($model) ?>

    <?= $form->dropDownListRow($model, 'form_type', $data, ['class' => 'input-xlarge', 'disabled' => count($data) == 0], ['hint' => (count($data) == 0 ? 'Неотправленных заявок не найдено' : null)]) ?>

    <?= $form->textFieldRow($model, 'email', ['class' => 'input-xxlarge']) ?>

    <?= $form->textFieldRow($model, 'subject', ['class' => 'input-xxlarge']) ?>

    <div class="form-actions">
        <button type="submit" class="btn btn-primary"><?= Yii::t('app', 'Send') ?></button>
        <a href="<?= $this->createUrl('index') ?>" class="btn"><?= Yii::t('app', 'Cancel') ?></a>
    </div>

    <?php $this->endWidget(); ?>

</div>
