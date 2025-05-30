<?php
/* @var $this PromoCodeController */
/* @var $model PromoCode */
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
    <?= $form->textFieldRow($model, 'promo_code', ['class' => 'input-xlarge']) ?>
    <?= $form->dropDownListRow($model, 'status_id', PromoCode::getStatuses(), ['class' => 'input-xlarge']) ?>
    <?= $form->select2Row($model, 'type_id', [
        'data' => CHtml::listData(Subscription::model()->findAll(['order' => 'id DESC']), 'id', 'title'),
        'htmlOptions' => [
            'multiple' => 'multiple',
            'class' => 'input-xxlarge',
        ],
    ]) ?>
    <?= $form->numberFieldRow($model, 'discount', ['class' => 'input-small', 'min' => 0, 'step' => 1, 'max' => 100], ['append' => '%']) ?>
    <?= $form->numberFieldRow($model, 'number_activations', ['class' => 'input-small', 'min' => 0, 'step' => 1]) ?>
    <?= $form->dateTimePickerRow($model, 'date_active', [
        'options' => [
            'format' => 'yyyy-mm-dd hh:ii',
            'autoclose' => true,
        ],
        'htmlOptions' => [
            'class' => 'input-large',
        ],
    ]) ?>


    <div class="form-actions">
        <button type="submit"
                class="btn btn-primary"><?= $model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Save') ?></button>
        <a href="<?= $this->createUrl('index') ?>" class="btn"><?= Yii::t('app', 'Cancel') ?></a>
    </div>

    <?php $this->endWidget(); ?>

</div>
