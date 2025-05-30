<?php
/* @var $this PromoCodeGiftController */
/* @var $model UserSubscriptionGift */
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
    <?= $form->textFieldRow($model, 'code', ['class' => 'input-xlarge']) ?>
    <?= $form->dateTimePickerRow($model, 'expiry_date', [
        'options' => [
            'format' => 'yyyy-mm-dd hh:ii',
            'autoclose' => true,
        ],
        'htmlOptions' => [
            'class' => 'input-large',
        ],
    ]) ?>
    <?= $form->textFieldRow($model, 'user_email', ['class' => 'input-xlarge']) ?>
    <?= $form->textFieldRow($model, 'gift_email', ['class' => 'input-xlarge']) ?>
    <?= $form->dropDownListRow($model, 'type_id', CHtml::listData(Subscription::model()->findAll(['order' => 'id ASC']), 'id', 'title'), ['class' => 'input-xlarge']) ?>
    <?= $form->dropDownListRow($model, 'status_id', UserSubscriptionGift::getStatuses(), ['class' => 'input-xlarge']) ?>

    <div class="form-actions">
        <button type="submit"
                class="btn btn-primary"><?= $model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Save') ?></button>
        <a href="<?= $this->createUrl('index') ?>" class="btn"><?= Yii::t('app', 'Cancel') ?></a>
    </div>

    <?php $this->endWidget(); ?>

</div>
