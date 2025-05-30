<?php
/* @var $this CommentController */
/* @var $model Comment */
/* @var $form TbActiveForm */

Yii::import('ext.hoauth.models.*');
?>

<div class="form">

    <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', [
        'id' => 'comment-form',
        'enableAjaxValidation' => false,
        'type' => 'horizontal',
    ]); ?>

    <?= $form->errorSummary($model) ?>

    <?= $form->textAreaRow($model, 'content', ['rows' => 5, 'class' => 'input-xxxlarge']) ?>

    <div class="control-group">
        <?= $form->labelEx($model, 'post', ['class' => 'control-label']) ?>
        <div class="controls">
            <?= CHtml::link(CHtml::encode($model->post->title), $model->post->getUrl(), ['class' => 'btn', 'target' => '_blank']) ?>
        </div>
    </div>

    <?php
    $userOAuth = UserOAuth::model()->findUser($model->create_user_id);
    if (!empty($userOAuth[0])) {
        $authProfile = $userOAuth[0]->getProfile();
        $displayName = !empty($authProfile->displayName) ? $authProfile->displayName : $authProfile->firstName . ' ' . $authProfile->lastName;
        ?>
        <div class="control-group">
            <?= $form->labelEx($model, 'author', ['class' => 'control-label']) ?>
            <div class="controls">
                <img width="64" height="64" src="<?= CHtml::encode($authProfile->photoURL) ?>" alt="<?= CHtml::encode($displayName) ?>" class="avatar">
                <a href="<?= CHtml::encode($authProfile->profileURL) ?>" class="display-name" title="<?= CHtml::encode($displayName) ?>" target="_blank"><?= CHtml::encode($displayName) ?></a>
            </div>
        </div>
        <?php
    } else {
        ?>
        <div class="control-group">
            <?= $form->labelEx($model, 'user_name', ['class' => 'control-label']) ?>
            <div class="controls">
                <span class="uneditable-input input-xlarge"><?= CHtml::encode($model->user_name) ?></span>
            </div>
        </div>
        <div class="control-group">
            <?= $form->labelEx($model, 'email', ['class' => 'control-label']) ?>
            <div class="controls">
                <span class="uneditable-input input-xlarge"><?= CHtml::encode($model->email) ?></span>
            </div>
        </div>
        <?php
    }
    ?>

    <div class="form-actions">
        <button type="submit" class="btn btn-primary"><?= $model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Save') ?></button>
        <a href="<?= $this->createUrl('index') ?>" class="btn"><?= Yii::t('app', 'Cancel') ?></a>
    </div>

    <?php $this->endWidget(); ?>

</div>