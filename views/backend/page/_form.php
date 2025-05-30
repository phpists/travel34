<?php
/* @var $this PageController */
/* @var $model Page */
/* @var $form TbActiveForm */
?>

<div class="form">

    <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', [
        'id' => 'page-form',
        'enableAjaxValidation' => false,
        'type' => 'horizontal',
    ]); ?>

    <?= $form->errorSummary($model) ?>

    <?= $form->widgetRow('application.widgets.BootstrapSwitch', [
        'model' => $model,
        'attribute' => 'status_id',
        'onText' => Yii::t('app', 'Enabled'),
        'offText' => Yii::t('app', 'Disabled'),
    ]) ?>

    <?= $form->textFieldRow($model, 'title', ['class' => 'input-xxlarge']) ?>

    <?= $form->textFieldRow($model, 'url', ['class' => 'input-xlarge'], [
        'prepend' => '/page/',
        'hint' => !$model->isNewRecord ? CHtml::link('<strong>Просмотр ссылки</strong>', $model->getUrl(), ['class' => 'btn', 'target' => '_blank']) : '',
    ]) ?>

    <?= $form->textFieldRow($model, 'page_title', ['class' => 'input-xxlarge']) ?>

    <?= $form->textFieldRow($model, 'page_keywords', ['class' => 'input-xxlarge']) ?>

    <?= $form->textAreaRow($model, 'description', ['class' => 'input-xxlarge', 'rows' => 3]) ?>

    <?= $form->ckEditorRow($model, 'text', [
        'editorOptions' => Common::getCKEditorOptions(['height' => '500']),
    ], ['htmlOptions' => ['style' => 'max-width:1280px']]) ?>

    <?php if (!$model->isNewRecord): ?>
        <hr>
        <?php $this->renderPartial('/partials/_styles', ['page_key' => Style::PAGE_KEY_PAGE, 'item_id' => $model->id]); ?>
    <?php endif; ?>

    <div class="form-actions">
        <button type="submit" class="btn btn-primary"><?= $model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Save') ?></button>
        <a href="<?= $this->createUrl('index') ?>" class="btn"><?= Yii::t('app', 'Cancel') ?></a>
    </div>

    <?php $this->endWidget(); ?>

</div>