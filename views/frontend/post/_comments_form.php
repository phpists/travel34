<?php
/** @var $this FrontEndController */
/** @var $model Comment|GtbComment */
/** @var $form CActiveForm */
$isLoggedSocial = (!Yii::app()->user->isGuest && Yii::app()->user->getOAuthProfile());
?>
<a name="comment"></a>
<div class="b-comment__form">
    <h3><?= Yii::t('app', 'Write a comment') ?></h3>

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'comments-form',
        'enableClientValidation' => true,
        'clientOptions' => array(
            'validateOnSubmit' => true,
            'afterValidate' => 'js:function(form,data,hasError){if(!hasError){form.find(".btn").hide();form.find(".fake-btn").show();}return true;}',
        ),
        'action' => '#comment',
    ));
    ?>

    <?php if (!$isLoggedSocial): ?>
        <?= $form->textField($model, 'user_name', array('placeholder' => Yii::t('app', 'Name'))) ?>
        <?= $form->error($model, 'user_name') ?>
        <br>
        <?= $form->textField($model, 'email', array('placeholder' => 'Email')) ?>
        <?= $form->error($model, 'email') ?>
    <?php endif; ?>

    <?= !$isLoggedSocial ? '<div class="b-comment__auth">' : '' ?>
    <div class="social-profile">
        <?php $this->widget('ext.hoauth.widgets.HOAuth', [
            'imagesPath' => '/themes/travel/images',
            'popupWidth' => 680,
            'popupHeight' => 600,
        ]); ?>
    </div>
    <?= !$isLoggedSocial ? '</div>' : '' ?>

    <?= $form->textArea($model, 'content') ?>
    <?= $form->error($model, 'content') ?>

    <?php if (Yii::app()->user->isGuest): ?>
        <?= $form->textField($model, 'verifyCode') ?>
        <span class="b-comment__captcha"><?php $this->widget('CCaptcha'); ?></span>
        <?= $form->error($model, 'verifyCode') ?>
    <?php endif; ?>

    <?= $form->hiddenField($model, 'parent_id') ?>

    <?= CHtml::htmlButton(Yii::t('app', 'Publish'), array(
        'type' => 'submit',
        'class' => 'btn' . (!Yii::app()->user->isGuest ? ' rel' : ''),
        'disabled' => (isset($disabled) ? $disabled : false),
    )) ?>
    <?= CHtml::htmlButton(Yii::t('app', 'Publish'), array(
        'type' => 'button',
        'class' => 'btn' . (!Yii::app()->user->isGuest ? ' rel' : '') . ' fake-btn btn-waiting',
        'disabled' => true,
    )) ?>

    <?php $this->endWidget(); ?>
</div>