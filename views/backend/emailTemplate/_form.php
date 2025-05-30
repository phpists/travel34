<?php
/* @var $this BlockController */
/* @var $model Block */
/* @var $form TbActiveForm */

$themeUrl = Yii::app()->theme->baseUrl;

/** @var CClientScript $cs */
$cs = Yii::app()->clientScript;

$cs->registerScriptFile(Common::assetsTime($themeUrl . '/js/post_edit.js'));
$cs->registerScriptFile(Common::assetsTime($themeUrl . '/js/jquery.form.min.js'));
$cs->registerScriptFile(Common::assetsTime($themeUrl . '/js/edit_items.js'));

$is_old = false;
if (!$model->isNewRecord) {
    $is_old = true;
    $cs->registerScript('old-34-styles', 'var old34styles = true;', CClientScript::POS_HEAD);
}
?>

<div class="form">

    <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', [
        'id' => 'block-form',
        'enableAjaxValidation' => false,
        'type' => 'horizontal',
    ]); ?>

    <?= $form->errorSummary($model) ?>

    <?= $form->textFieldRow($model, 'subject', ['class' => 'input-xlarge']) ?>

    <?= $form->ckEditorRow($model, 'description', [
        'editorOptions' => Common::getCKEditorOptions(['height' => '500'], $is_old),
    ], ['htmlOptions' => ['style' => 'max-width:1280px']]) ?>

    <div class="form-actions">
        <button type="submit"
                class="btn btn-primary"><?= $model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Save') ?></button>
        <a href="<?= $this->createUrl('index') ?>" class="btn"><?= Yii::t('app', 'Cancel') ?></a>
    </div>

    <?php $this->endWidget(); ?>

</div>