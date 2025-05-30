<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form TbActiveForm */
?>

<div class="form">

    <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', [
        'id' => 'user-form',
        'enableAjaxValidation' => false,
        'type' => 'horizontal',
    ]); ?>

    <?= $form->errorSummary($model) ?>

    <?= $form->textFieldRow($model, 'username') ?>

    <?php //= $form->emailFieldRow($model, 'email') ?>

    <?= $form->passwordFieldRow($model, 'password', ['autocomplete' => 'new-password']) ?>

    <div class="form-actions">
        <button type="submit" class="btn btn-primary"><?= $model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Save') ?></button>
        <a href="<?= $this->createUrl('index') ?>" class="btn"><?= Yii::t('app', 'Cancel') ?></a>
    </div>

    <?php $this->endWidget(); ?>

</div>