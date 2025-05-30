<?php
/* @var $this GtbBannerController */
/* @var $model GtbBanner */
/* @var $form TbActiveForm */
?>

<div class="form">

    <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', [
        'id' => 'gtb-banner-form',
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

    <?= $form->dropDownListRow($model, 'language', Yii::app()->params['gtbLanguages'], ['prompt' => 'Все языки']) ?>

    <?= $form->dropDownListRow($model, 'banner_place_id', GtbBanner::getBannerPlaceOptions(), ['class' => 'input-xlarge']) ?>

    <?= $form->textFieldRow($model, 'title', ['class' => 'input-xxlarge']) ?>

    <?= $form->textFieldRow($model, 'url', ['class' => 'input-xxlarge']) ?>

    <?= $form->checkBoxRow($model, 'open_new_tab') ?>

    <?= $form->fileFieldRow($model, 'image', [], [
        'hint' => AdminHelper::hintPreview($model, 'image'),
    ]) ?>

    <?= $form->fileFieldRow($model, 'image_mobile', [], [
        'hint' => AdminHelper::hintPreview($model, 'image_mobile'),
    ]) ?>

    <?= $form->numberFieldRow($model, 'grid_position') ?>

    <div class="form-actions">
        <button type="submit" class="btn btn-primary"><?= $model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Save') ?></button>
        <a href="<?= $this->createUrl('index') ?>" class="btn"><?= Yii::t('app', 'Cancel') ?></a>
    </div>

    <?php $this->endWidget(); ?>

</div>