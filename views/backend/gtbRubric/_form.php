<?php
/* @var $this GtbRubricController */
/* @var $model GtbRubric */
/* @var $form TbActiveForm */
?>

<div class="form">

    <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', [
        'id' => 'gtb-rubric-form',
        'enableAjaxValidation' => false,
        'type' => 'horizontal',
        /*'htmlOptions' => [
            'enctype' => 'multipart/form-data',
        ],*/
    ]); ?>

    <?= $form->errorSummary($model) ?>

    <?= $form->widgetRow('application.widgets.BootstrapSwitch', [
        'model' => $model,
        'attribute' => 'status_id',
        'onText' => Yii::t('app', 'Enabled'),
        'offText' => Yii::t('app', 'Disabled'),
    ]) ?>

    <?= $form->textFieldRow($model, 'title', ['class' => 'input-xxlarge']) ?>

    <?= $form->textFieldRow($model, 'title_en', ['class' => 'input-xxlarge']) ?>

    <?= $form->textFieldRow($model, 'title_be', ['class' => 'input-xxlarge']) ?>

    <?= $form->textAreaRow($model, 'description', ['class' => 'input-xxlarge', 'rows' => 3]) ?>

    <?= $form->textAreaRow($model, 'description_en', ['class' => 'input-xxlarge', 'rows' => 3]) ?>

    <?= $form->textAreaRow($model, 'description_be', ['class' => 'input-xxlarge', 'rows' => 3]) ?>

    <?= $form->textFieldRow($model, 'url', ['class' => 'input-medium'], [
        'prepend' => '/gotobelarus/rubric/',
        'hint' => !$model->isNewRecord ? CHtml::link('<strong>Просмотр ссылки</strong>', $model->getUrl(), ['class' => 'btn', 'target' => '_blank']) : '',
    ]) ?>

    <?= $form->numberFieldRow($model, 'position') ?>

    <?= $form->checkBoxRow($model, 'hide_in_menu') ?>

    <?= $form->checkBoxRow($model, 'hide_in_menu_en') ?>

    <?= $form->checkBoxRow($model, 'hide_in_menu_be') ?>

    <?= $form->checkBoxRow($model, 'in_todo_list') ?>

    <?php if (!$model->isNewRecord): ?>
        <hr>
        <?php $this->renderPartial('/partials/_styles', ['page_key' => Style::PAGE_KEY_GTB_RUBRIC, 'item_id' => $model->id]); ?>
        <hr>
        <?php $this->renderPartial('/partials/_styles', ['page_key' => Style::PAGE_KEY_GTB_RUBRIC_EN, 'item_id' => $model->id, 'subtitle' => 'EN']); ?>
    <?php endif; ?>

    <div class="form-actions">
        <button type="submit" class="btn btn-primary"><?= $model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Save') ?></button>
        <a href="<?= $this->createUrl('index') ?>" class="btn"><?= Yii::t('app', 'Cancel') ?></a>
    </div>

    <?php $this->endWidget(); ?>

</div>