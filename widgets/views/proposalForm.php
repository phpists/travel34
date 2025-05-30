<?php
/** @var $model ProposalForm */
/** @var $form CActiveForm */
/** @var $blockName string */

$js = <<<JS
function proposalFormSubmit(form, data, hasError) {
    if (!hasError) {
        form.find('button[type="submit"]').prop('disabled', true);
        jQuery.post(form.attr('action'), form.serialize() + '&submit=1', function (res) {
            form.find('button[type="submit"]').prop('disabled', false);
            if (res.success) {
                var result_msg = $('#proposal-form-result').html();
                form.html('<div class="form-title">' + result_msg + '</div>');
                form.addClass('done');
            }
        }, 'json').fail(function() {
            form.find('button[type="submit"]').prop('disabled', false);
        });
        return false;
    }
}
JS;
Yii::app()->clientScript->registerScript('form-submits', $js, CClientScript::POS_END);
?>

<?php $form = $this->beginWidget('CActiveForm', [
    'id' => 'proposal-form',
    'enableClientValidation' => true,
    'action' => ['/site/proposal'],
    'clientOptions' => [
        'validateOnSubmit' => true,
        'afterValidate' => 'js:proposalFormSubmit',
    ],
    'htmlOptions' => ['class' => 'bank-form'],
]); ?>

<div id="proposal-form-result" style="display:none">
    <?= BlocksHelper::get($blockName) ?>
</div>

<div class="form-title">
    <h3><span>Подать заявку</span></h3>
</div>

<?= CHtml::activeHiddenField($model, 'form_type') ?>

<div class="field-wrap">
    <?= $form->label($model, 'name', ['label' => 'Напиши свое имя и фамилию:']) ?>
    <?= $form->textField($model, 'name', ['class' => 'form-control']) ?>
    <?= $form->error($model, 'name') ?>
</div>

<div class="field-wrap">
    <?= $form->label($model, 'phone', ['label' => 'Оставь номер телефона:']) ?>
    <?= $form->textField($model, 'phone', ['class' => 'phone-input', 'autocomplete' => 'off']) ?>
    <?= $form->error($model, 'phone') ?>
</div>

<div class="field-wrap check-wrap">
    <?= $form->checkBox($model, 'confirmed') ?>
    <?= $form->label($model, 'confirmed', ['label' => 'Я согласен(-а) с обработкой персональных данных банком']) ?>
    <?= $form->error($model, 'confirmed') ?>
</div>

<button type="submit" disabled>Оставить заявку</button>

<?php $this->endWidget(); ?>
