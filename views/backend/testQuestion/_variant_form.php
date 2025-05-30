<?php
/* @var $this TestQuestionController */
/* @var $model TestVariant */
/* @var $show_image bool */
/* @var $single_correct bool */
/* @var $form TbActiveForm */
?>

<div class="form well">

    <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', [
        'id' => 'test-variant-form',
        'enableAjaxValidation' => false,
        'type' => 'horizontal',
        'htmlOptions' => [
            'enctype' => 'multipart/form-data',
        ],
    ]); ?>

    <?= $form->errorSummary($model) ?>

    <?= $form->textAreaRow($model, 'text', ['rows' => 2, 'cols' => 50, 'class' => 'input-xxlarge']) ?>

    <?= $show_image ? $form->fileFieldRow($model, 'image', [], [
        'hint' => AdminHelper::hintPreview($model, 'image', '200x200'),
    ]) : '' ?>

    <?= !empty($model->image) ? $form->checkBoxRow($model, 'delete_image') : '' ?>

    <?= $single_correct ? $form->checkBoxRow($model, 'is_correct') : '' ?>

    <?= $form->numberFieldRow($model, 'position', ['class' => 'input-large']) ?>

    <div class="form-actions">
        <button type="submit" class="btn btn-primary"><?= $model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Save') ?></button>
        <button type="button" class="btn cancel-form"><?= Yii::t('admin', 'Cancel') ?></button>
    </div>

    <?php $this->endWidget(); ?>

</div>
