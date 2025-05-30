<?php
/* @var $this AuthorController */
/* @var $model Author */
/* @var $form TbActiveForm */
?>

<div class="form">

    <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', [
        'id' => 'author-form',
        'enableAjaxValidation' => false,
        'type' => 'horizontal',
    ]); ?>

    <?= $form->errorSummary($model) ?>

    <?= $form->textFieldRow($model, 'title', ['class' => 'input-large']) ?>

    <?php if (!$model->isNewRecord): ?>
        <div class="control-group">
            <div class="controls">
                <?= CHtml::link('<strong>Просмотр ссылки</strong>', $model->getUrl(), ['class' => 'btn', 'target' => '_blank']) ?>
            </div>
        </div>
    <?php endif; ?>

    <?= $form->textFieldRow($model, 'page_title', ['class' => 'input-xxlarge']) ?>

    <?= $form->textFieldRow($model, 'page_description', ['class' => 'input-xxlarge']) ?>

    <div class="form-actions">
        <button type="submit" class="btn btn-primary"><?= $model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Save') ?></button>
        <a href="<?= $this->createUrl('index') ?>" class="btn"><?= Yii::t('app', 'Cancel') ?></a>
    </div>

    <?php $this->endWidget(); ?>

</div>