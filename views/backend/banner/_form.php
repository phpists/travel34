<?php
/* @var $this BannerController */
/* @var $model Banner */
/* @var $form TbActiveForm */
?>

<div class="form">

    <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', [
        'id' => 'banner-form',
        'enableAjaxValidation' => false,
        'type' => 'horizontal',
        'htmlOptions' => [
            'enctype' => 'multipart/form-data',
        ],
    ]); ?>

    <?= $form->errorSummary($model) ?>

    <?= $form->widgetRow('application.widgets.BootstrapSwitch', [
        'model' => $model,
        'attribute' => 'status_id',
        'onText' => Yii::t('app', 'Enabled'),
        'offText' => Yii::t('app', 'Disabled'),
    ]) ?>

    <?= $form->textFieldRow($model, 'title', ['class' => 'input-xxlarge']) ?>

    <?= $form->dropDownListRow($model, 'banner_place_id', Banner::getBannerPlaceOptions(), ['class' => 'input-xlarge']) ?>

<!--    --><?php //= $form->dropDownListRow($model, 'banner_system', Banner::getBannerSystems(), ['class' => 'input-xlarge']) ?>

    <?= $form->textFieldRow($model, 'url', ['class' => 'input-xxlarge', 'placeholder' => 'http://example.com']) ?>

    <?= $form->checkBoxRow($model, 'open_new_tab') ?>

    <?= $form->fileFieldRow($model, 'image', [], [
        'hint' => !empty($model->image) ? CHtml::image($model->getImageUrl('image'), '', ['width' => 200]) : '',
    ]) ?>

    <hr>

    <?= $form->checkBoxListRow($model, 'geo_target_codes', Yii::app()->params['countries'], ['labelOptions' => ['class' => 'checkbox inline']]) ?>

    <div class="form-actions">
        <button type="submit" class="btn btn-primary"><?= $model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Save') ?></button>
        <a href="<?= $this->createUrl('index') ?>" class="btn"><?= Yii::t('app', 'Cancel') ?></a>
    </div>

    <?php $this->endWidget(); ?>

</div>