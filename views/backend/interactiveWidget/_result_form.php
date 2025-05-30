<?php
/* @var $this InteractiveWidgetController */
/* @var $model InteractiveResult */
/* @var $form TbActiveForm */
?>

<div class="form well">

    <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', [
        'id' => 'interactive-result-form',
        'enableAjaxValidation' => false,
        'type' => 'horizontal',
        /*'htmlOptions' => [
            'enctype' => 'multipart/form-data',
        ],*/
    ]); ?>

    <?= $form->errorSummary($model) ?>

    <?= $form->ckEditorRow($model, 'text', [
        'editorOptions' => Common::getCKEditorOptions(),
    ], ['htmlOptions' => ['style' => 'max-width:1280px']]) ?>

    <div class="form-actions">
        <button type="submit" class="btn btn-primary"><?= $model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Save') ?></button>
        <button type="button" class="btn cancel-form"><?= Yii::t('admin', 'Cancel') ?></button>
    </div>

    <?php $this->endWidget(); ?>

</div>
