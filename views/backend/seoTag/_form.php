<?php
/* @var $this SeoTagController */
/* @var $model SeoTag */
/* @var $form TbActiveForm */
?>

<div class="form">

    <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', [
        'id' => 'seo-tag-form',
        'enableAjaxValidation' => false,
        'type' => 'horizontal',
        'htmlOptions' => [
            'enctype' => 'multipart/form-data',
        ],
    ]); ?>

    <?= $form->errorSummary($model) ?>

    <?= $form->textFieldRow($model, 'path', ['class' => 'input-large']) ?>

    <?= $form->textFieldRow($model, 'title', ['class' => 'input-xxlarge']) ?>

    <?= $form->textAreaRow($model, 'description', ['class' => 'input-xxlarge', 'rows' => 3]) ?>

    <?= $form->fileFieldRow($model, 'image', [], [
        'hint' => AdminHelper::hintPreview($model, 'image', '1200x630, 600x315 или 200x200'),
    ]) ?>

    <div class="form-actions">
        <button type="submit" class="btn btn-primary"><?= $model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Save') ?></button>
        <a href="<?= $this->createUrl('index') ?>" class="btn"><?= Yii::t('app', 'Cancel') ?></a>
    </div>

    <?php $this->endWidget(); ?>

</div>