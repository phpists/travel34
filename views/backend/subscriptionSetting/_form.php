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
    <?= $form->textFieldRow($model, 'title', ['class' => 'input-xxlarge']) ?>
    <?= $form->textFieldRow($model, 'price', ['class' => 'input-xxlarge']) ?>
    <?= $form->textFieldRow($model, 'old_price', ['class' => 'input-xxlarge']) ?>
    <?= $form->ckEditorRow($model, 'description', [
        'editorOptions' => Common::getCKEditorOptions(['height' => '500']),
    ], ['htmlOptions' => ['style' => 'max-width:1280px']]) ?>

    <?= $form->widgetRow('application.widgets.BootstrapSwitch', [
        'model' => $model,
        'attribute' => 'status_id',
        'onText' => Yii::t('app', 'Включено'),
        'offText' => Yii::t('app', 'Отключено'),
    ]) ?>

    <div class="form-actions">
        <button type="submit"
                class="btn btn-primary"><?= $model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Save') ?></button>
        <a href="<?= $this->createUrl('index') ?>" class="btn"><?= Yii::t('app', 'Cancel') ?></a>
    </div>

    <?php $this->endWidget(); ?>

</div>