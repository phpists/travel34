<?php
/* @var $this SettingController */
/* @var $model Setting */
/* @var $form TbActiveForm */
?>

<div class="form">

    <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', [
        'id' => 'setting-form',
        'enableAjaxValidation' => false,
        'type' => 'horizontal',
        'htmlOptions' => [
            'enctype' => 'multipart/form-data',
        ],
    ]); ?>

    <?= $form->errorSummary($model) ?>
    <?= $form->textFieldRow($model, 'name', ['class' => 'input-xxlarge']) ?>

    <?= $form->ckEditorRow($model, 'description', [
        'editorOptions' => Common::getCKEditorOptions(['height' => '500']),
    ], ['htmlOptions' => ['style' => 'max-width:1280px']]) ?>

    <hr>

    <?= $form->textFieldRow($model, 'title_paywall', ['class' => 'input-xxlarge']) ?>

    <?= $form->ckEditorRow($model, 'description_paywall', [
        'editorOptions' => Common::getCKEditorOptions(['height' => '500']),
    ], ['htmlOptions' => ['style' => 'max-width:1280px']]) ?>

    <div class="form-actions">
        <button type="submit"
                class="btn btn-primary"><?= $model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Save') ?></button>
        <a href="<?= $this->createUrl('index') ?>" class="btn"><?= Yii::t('app', 'Cancel') ?></a>
    </div>

    <?php $this->endWidget(); ?>

</div>