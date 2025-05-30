<?php
/* @var $this PostController */
/* @var $model Style */
/* @var $form TbActiveForm */
?>

<div class="form well">

    <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', [
        'id' => 'style-form',
        'enableAjaxValidation' => false,
        'type' => 'horizontal',
        'htmlOptions' => [
            'enctype' => 'multipart/form-data',
        ],
    ]); ?>

    <?= $form->errorSummary($model) ?>

    <?php if (!$model->isNewRecord): ?>
        <div class="control-group" id="item_link">
            <div class="controls">
                <?= CHtml::link('Редактировать стиль в отдельной вкладке', ['style/update', 'id' => $model->id], ['target' => '_blank']) ?>
            </div>
        </div>
        <div class="control-group" id="item_link">
            <label class="control-label">Прикреплено к</label>
            <div class="controls" style="padding-top: 5px;">
                <?php foreach ($model->styleAssigns as $assign): ?>
                    <?= StyleAssign::getItemLink($assign) ?><br>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

    <?= $form->dropDownListRow($model, 'status_id', [Style::YES => 'Включен', Style::NO => 'Выключен']) ?>

    <?= $form->textFieldRow($model, 'title', ['class' => 'input-xxlarge']) ?>

    <?= $form->dropDownListRow($model, 'background_type', Style::getBgTypeOptions(), ['class' => 'input-xxlarge']) ?>

    <?= $form->textFieldRow($model, 'background_color', ['class' => 'input-small', 'placeholder' => 'fff'], ['prepend' => '#']) ?>

    <?= $form->fileFieldRow($model, 'background_image', [], [
        'hint' => AdminHelper::hintPreview($model, 'background_image'),
    ]) ?>

    <?= $form->fileFieldRow($model, 'background_image_mobile', [], [
        'hint' => AdminHelper::hintPreview($model, 'background_image_mobile'),
    ]) ?>

    <?= $form->numberFieldRow($model, 'background_height', ['class' => 'input-small', 'min' => 0, 'step' => 1], ['append' => 'px']) ?>

    <?= $form->fileFieldRow($model, 'background_repeat_image', [], [
        'hint' => AdminHelper::hintPreview($model, 'background_repeat_image'),
    ]) ?>

    <?= $form->numberFieldRow($model, 'page_padding', ['class' => 'input-small', 'min' => 0, 'step' => 1], ['append' => 'px']) ?>

    <?= $form->numberFieldRow($model, 'page_padding_mobile', ['class' => 'input-small', 'min' => 0, 'step' => 1], ['append' => 'px']) ?>

    <?= $form->textFieldRow($model, 'url', ['class' => 'input-xxlarge'], ['prepend' => 'http://']) ?>

    <div class="form-actions">
        <button type="submit" class="btn btn-primary"><?= $model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Save') ?></button>
        <button type="button" class="btn cancel-form"><?= Yii::t('admin', 'Cancel') ?></button>
    </div>

    <?php $this->endWidget(); ?>

</div>
