<?php
/* @var $this BlockAfterPostController */
/* @var $model BlockAfterPost */
/* @var $form TbActiveForm */
?>

<div class="form">

    <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', [
        'id' => 'block-after-post-form',
        'enableAjaxValidation' => false,
        'type' => 'horizontal',
        'htmlOptions' => [
            'enctype' => 'multipart/form-data',
        ],
    ]); ?>

    <?= $form->errorSummary($model) ?>

    <?= $form->textFieldRow($model, 'title', ['class' => 'input-xxlarge']) ?>
    <?= $form->textAreaRow($model, 'text', ['class' => 'input-xxlarge', 'rows' => 3]) ?>
    <?= $form->textFieldRow($model, 'button_url', ['class' => 'input-xxlarge']) ?>
    <?= $form->textFieldRow($model, 'button_text', ['class' => 'input-xxlarge']) ?>
    <?= $form->colorPickerRow($model, 'background_color') ?>
    <?= $form->colorPickerRow($model, 'text_color') ?>

    <hr>
    <?= $form->colorPickerRow($model, 'button_color') ?>
    <?= $form->colorPickerRow($model, 'button_text_color') ?>
    <?= $form->colorPickerRow($model, 'button_hover_color') ?>

    <hr>

    <?= $form->fileFieldRow($model, 'image', [], [
        'hint' => AdminHelper::hintPreview($model, 'image'),
    ]) ?>

    <div class="form-actions">
        <button type="submit" class="btn btn-primary"><?= $model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Save') ?></button>
        <a href="<?= $this->createUrl('index') ?>" class="btn"><?= Yii::t('app', 'Cancel') ?></a>
    </div>

    <?php $this->endWidget(); ?>

</div>