<?php
/* @var $this AdminController */
/* @var $model LoginForm */
/* @var $form TbActiveForm */

$this->pageTitle = Yii::app()->name . ' - ' . Yii::t('app', 'Login');
$this->breadcrumbs = [
    Yii::t('app', 'Login'),
];
?>

<h1><?= Yii::t('app', 'Login') ?></h1>

<div class="form">

    <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', [
        'id' => 'login-form',
        'enableClientValidation' => true,
        'type' => 'horizontal',
        'clientOptions' => [
            'validateOnSubmit' => true,
        ],
    ]); ?>

    <?= $form->textFieldRow($model, 'username') ?>

    <?= $form->passwordFieldRow($model, 'password') ?>

    <?= $form->checkboxRow($model, 'rememberMe') ?>

    <div class="form-actions">
        <button type="submit" class="btn btn-primary"><?= Yii::t('app', 'Login') ?></button>
    </div>

    <?php $this->endWidget(); ?>

</div>
