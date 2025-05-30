<?php
/* @var $this SpecialProjectController */
/* @var $model SpecialProject */
/* @var $form TbActiveForm */
?>

<div class="form">

    <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', [
        'id' => 'special-project-form',
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

    <?= $form->textFieldRow($model, 'url', ['class' => 'input-large'], [
        'prepend' => '/special/',
        'hint' => !$model->isNewRecord ? CHtml::link('<strong>Просмотр ссылки</strong>', $model->getUrl(), ['class' => 'btn', 'target' => '_blank']) : '',
    ]) ?>

    <?= $form->textFieldRow($model, 'title', ['class' => 'input-xxlarge']) ?>

    <?= $form->textAreaRow($model, 'description', ['class' => 'input-xxlarge', 'rows' => 3]) ?>

    <?= $form->fileFieldRow($model, 'image_list', [], [
        'hint' => AdminHelper::hintPreview($model, 'image_list'),
    ]) ?>

    <hr>

    <?= $form->checkBoxRow($model, 'is_new') ?>

    <?= $form->fileFieldRow($model, 'image', [], [
        'hint' => AdminHelper::hintPreview($model, 'image'),
    ]) ?>

    <?= $form->numberFieldRow($model, 'image_width', ['class' => 'input-small']) ?>

    <?= $form->numberFieldRow($model, 'position', ['class' => 'input-small']) ?>

    <?php if (!$model->isNewRecord): ?>
        <hr>
        <?php $this->renderPartial('/partials/_styles', ['page_key' => Style::PAGE_KEY_SPECIAL, 'item_id' => $model->id]); ?>
    <?php endif; ?>

    <div class="form-actions">
        <button type="submit" class="btn btn-primary"><?= $model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Save') ?></button>
        <a href="<?= $this->createUrl('index') ?>" class="btn"><?= Yii::t('app', 'Cancel') ?></a>
    </div>

    <?php $this->endWidget(); ?>

</div>