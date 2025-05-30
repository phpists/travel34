<?php
/* @var $this TestWidgetController */
/* @var $model TestWidget */
/* @var $form ExtTbActiveForm */
?>

<div class="form">

    <?php $form = $this->beginWidget('application.widgets.ExtTbActiveForm', [
        'id' => 'test-widget-form',
        'enableAjaxValidation' => false,
        'type' => 'horizontal',
        'htmlOptions' => [
            'enctype' => 'multipart/form-data',
        ],
    ]); ?>

    <?= $form->errorSummary($model) ?>

    <?php if (!$model->isNewRecord): ?>
        <div class="control-group">
            <div class="controls">
                <samp class="copytext">[test id=<?= $model->id ?>]</samp>
            </div>
        </div>
    <?php endif; ?>

    <?= $form->dropDownListRow($model, 'type', TestWidget::getTypeOptions(), ['class' => 'input-xlarge']) ?>

    <?= $form->textAreaRow($model, 'title', ['rows' => 2, 'cols' => 50, 'class' => 'input-xxlarge']) ?>

    <?= $form->ckEditorRow($model, 'text', [
        'editorOptions' => Common::getCKEditorOptions(),
    ], ['htmlOptions' => ['style' => 'max-width:1280px']]) ?>

    <hr>

    <?= $form->colorFieldRow($model, 'background_color') ?>

    <?= $form->fileFieldRow($model, 'background_image', [], [
        'hint' => AdminHelper::hintPreview($model, 'background_image'),
    ]) ?>

    <?= !empty($model->background_image) ? $form->checkBoxRow($model, 'delete_background_image') : '' ?>

    <hr>

    <?= $form->colorFieldRow($model, 'step2_background_color') ?>

    <?= $form->fileFieldRow($model, 'step2_background_image', [], [
        'hint' => AdminHelper::hintPreview($model, 'step2_background_image'),
    ]) ?>

    <?= !empty($model->background_image) ? $form->checkBoxRow($model, 'delete_step2_background_image') : '' ?>

    <hr>

    <?= $form->colorFieldRow($model, 'step3_background_color') ?>

    <?= $form->fileFieldRow($model, 'step3_background_image', [], [
        'hint' => AdminHelper::hintPreview($model, 'step3_background_image'),
    ]) ?>

    <?= !empty($model->background_image) ? $form->checkBoxRow($model, 'delete_step3_background_image') : '' ?>

    <hr>

    <?= $form->checkBoxRow($model, 'has_border') ?>

    <?= $form->colorFieldRow($model, 'border_color', ['placeholder' => '000']) ?>

    <?= $form->colorFieldRow($model, 'step2_border_color', ['placeholder' => '000']) ?>

    <?= $form->colorFieldRow($model, 'step3_border_color', ['placeholder' => '000']) ?>

    <hr>

    <?= $form->colorFieldRow($model, 'step1_title_color') ?>

    <?= $form->checkBoxRow($model, 'step1_title_has_border') ?>

    <?= $form->colorFieldRow($model, 'step1_title_border_color', ['placeholder' => '000']) ?>

    <hr>

    <?= $form->colorFieldRow($model, 'step2_title_color') ?>

    <?= $form->checkBoxRow($model, 'step2_title_has_border') ?>

    <?= $form->colorFieldRow($model, 'step2_title_border_color', ['placeholder' => '000']) ?>

    <hr>

    <?= $form->colorFieldRow($model, 'step3_title_color') ?>

    <?= $form->checkBoxRow($model, 'step3_title_has_border') ?>

    <?= $form->colorFieldRow($model, 'step3_title_border_color', ['placeholder' => '000']) ?>

    <hr>

    <?= $form->colorFieldRow($model, 'step1_text_color') ?>

    <?= $form->colorFieldRow($model, 'step2_text_color') ?>

    <?= $form->colorFieldRow($model, 'step2_variants_text_color') ?>

    <?= $form->colorFieldRow($model, 'step3_text_color') ?>

    <hr>

    <?= $form->textFieldRow($model, 'step1_button_text', ['class' => 'input-xlarge']) ?>

    <?= $form->colorFieldRow($model, 'step1_button_text_color') ?>

    <?= $form->colorFieldRow($model, 'step1_button_color') ?>

    <?= $form->colorFieldRow($model, 'step1_button_border_color', ['placeholder' => '000']) ?>

    <?= $form->colorFieldRow($model, 'step1_button_shadow_color') ?>

    <?= $form->colorFieldRow($model, 'step1_button_hover_color') ?>

    <?= $form->colorFieldRow($model, 'step1_button_hover_shadow_color') ?>

    <hr>

    <?= $form->textFieldRow($model, 'step2_button_text', ['class' => 'input-xlarge']) ?>

    <?= $form->colorFieldRow($model, 'step2_button_text_color') ?>

    <?= $form->colorFieldRow($model, 'step2_button_color') ?>

    <?= $form->colorFieldRow($model, 'step2_button_border_color', ['placeholder' => '000']) ?>

    <?= $form->colorFieldRow($model, 'step2_button_shadow_color') ?>

    <?= $form->colorFieldRow($model, 'step2_button_hover_color') ?>

    <?= $form->colorFieldRow($model, 'step2_button_hover_shadow_color') ?>

    <hr>

    <?= $form->textFieldRow($model, 'step3_button_text', ['class' => 'input-xlarge']) ?>

    <?= $form->colorFieldRow($model, 'step3_button_text_color') ?>

    <?= $form->colorFieldRow($model, 'step3_button_color') ?>

    <?= $form->colorFieldRow($model, 'step3_button_border_color', ['placeholder' => '000']) ?>

    <?= $form->colorFieldRow($model, 'step3_button_shadow_color') ?>

    <?= $form->colorFieldRow($model, 'step3_button_hover_color') ?>

    <?= $form->colorFieldRow($model, 'step3_button_hover_shadow_color') ?>

    <hr>

    <?= $form->colorFieldRow($model, 'correct_answer_color', ['placeholder' => '45b173']) ?>

    <?= $form->colorFieldRow($model, 'wrong_answer_color', ['placeholder' => 'ff561b']) ?>

    <hr>

    <?= $form->checkBoxRow($model, 'has_top_branding') ?>

    <?= $form->fileFieldRow($model, 'top_branding_image', [], [
        'hint' => AdminHelper::hintPreview($model, 'top_branding_image', '940x или 920x для виджета с рамкой'),
    ]) ?>

    <?= $form->fileFieldRow($model, 'top_branding_mobile_image', [], [
        'hint' => AdminHelper::hintPreview($model, 'top_branding_mobile_image', '540x или 520x для виджета с рамкой'),
    ]) ?>

    <?= $form->textFieldRow($model, 'top_branding_url', ['class' => 'input-xxlarge', 'maxlength' => 255, 'placeholder' => 'http://example.com']) ?>

    <hr>

    <?= $form->checkBoxRow($model, 'has_bottom_branding') ?>

    <?= $form->fileFieldRow($model, 'bottom_branding_image', [], [
        'hint' => AdminHelper::hintPreview($model, 'bottom_branding_image', '940x или 920x для виджета с рамкой'),
    ]) ?>

    <?= $form->fileFieldRow($model, 'bottom_branding_mobile_image', [], [
        'hint' => AdminHelper::hintPreview($model, 'bottom_branding_mobile_image', '540x или 520x для виджета с рамкой'),
    ]) ?>

    <?= $form->textFieldRow($model, 'bottom_branding_url', ['class' => 'input-xxlarge', 'maxlength' => 255, 'placeholder' => 'http://example.com']) ?>

    <div class="form-actions">
        <button type="submit" class="btn btn-primary"><?= $model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Save') ?></button>
        <a href="<?= $this->createUrl('index') ?>" class="btn"><?= Yii::t('app', 'Cancel') ?></a>
    </div>

    <?php $this->endWidget(); ?>

</div>
