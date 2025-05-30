<?php
/* @var $this \AdminController */
/* @var $model ChangePasswordForm */
/* @var $form TbActiveForm */

$this->pageTitle = Yii::t('app', 'Change Password');

$this->breadcrumbs = [
    Yii::t('app', 'Change Password')
];
?>

<h1><?= $this->pageTitle ?></h1>

<div class="form">

    <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', [
        'id' => 'change-password-form',
        'enableAjaxValidation' => false,
        'type' => 'horizontal',
    ]); ?>

    <?= $form->errorSummary($model) ?>

    <?= $form->passwordFieldRow($model, 'pwd_current', ['class' => 'input-xlarge']) ?>
    <?= $form->passwordFieldRow($model, 'password', ['class' => 'input-xlarge']) ?>
    <?= $form->passwordFieldRow($model, 'pwd_confirm', ['class' => 'input-xlarge']) ?>

    <div class="form-actions">
        <button type="submit" class="btn btn-primary"><?= Yii::t('app', 'Save') ?></button>
    </div>


    <?php $this->endWidget(); ?>

</div>
