<?php
/* @var $this StyleController */
/* @var $model Style */
/* @var $form TbActiveForm */

/** @var CClientScript $cs */
$cs = Yii::app()->clientScript;
$cs->registerCoreScript('jquery');
$cs->registerScriptFile(Common::assetsTime(Yii::app()->theme->baseUrl . '/js/style_selects.js'));

$all_items = $model->getAllItems();

$page_keys_attr = 'page_keys[]';
$item_ids_attr = 'item_ids[]';

$page_keys_name = CHtml::resolveName($model, $page_keys_attr);
$item_ids_name = CHtml::resolveName($model, $item_ids_attr);

// preselected values
if ($model->isNewRecord) {
    $selected_page_key = $model->page_keys ? reset($model->page_keys) : '';
    $selected_item_id = $model->item_ids ? reset($model->item_ids) : '';
} else {
    $selected_page_key = '';
    $selected_item_id = '';
}
?>

<div class="form">

    <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', [
        'id' => 'style-form',
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

    <?= $form->textFieldRow($model, 'title', ['class' => 'input-xxlarge']) ?>

    <hr>

    <div class="control-group">
        <label class="control-label">Прикрепить к</label>
        <div class="controls">

            <?= CHtml::dropDownList('_page_key', $selected_page_key, Style::getPageKeysAll(), ['id' => 'select_page_key']) ?>

            <?php foreach ($all_items as $page_key => $items): ?>
                <?= CHtml::dropDownList($page_key . '_values', $selected_page_key == $page_key ? $selected_item_id : '', $items, [
                    'empty' => '',
                    'id' => $page_key . '_values',
                    'style' => 'display:none;',
                ]) . "\n" ?>
            <?php endforeach; ?>

            <div style="display: inline-block" class="select_item_id_container">
                <?php $this->widget('bootstrap.widgets.TbSelect2', [
                    'name' => '_item_id',
                    'value' => '',
                    'data' => [],
                    'options' => [
                        'placeholder' => 'Выбрать',
                        'allowClear' => true,
                    ],
                    'htmlOptions' => ['id' => 'select_item_id', 'class' => 'input-xxlarge'],
                ]) ?>
            </div>

            <button type="button" class="btn add-style-page"
                    data-page-keys-name="<?= $page_keys_name ?>"
                    data-item-ids-name="<?= $item_ids_name ?>"
                    data-selected="<?= $selected_page_key ? '1' : '0' ?>">Прикрепить</button>

        </div>
    </div>

    <?= CHtml::activeHiddenField($model, 'page_keys', ['value' => '0', 'id' => 'page_keys_empty']) ?>
    <?= CHtml::activeHiddenField($model, 'item_ids', ['value' => '0', 'id' => 'item_ids_empty']) ?>

    <div class="control-group">
        <div class="controls" id="style_page_list">
            <?php
            if (!$model->isNewRecord) {
                foreach ($model->styleAssigns as $assign) {
                    ?>
                    <p class="style-page style-page-<?= $assign->page_key ?>-<?= (int)$assign->item_id ?>">
                        <input type="hidden" name="<?= $page_keys_name ?>" value="<?= $assign->page_key ?>">
                        <input type="hidden" name="<?= $item_ids_name ?>" value="<?= $assign->item_id ?>">
                        <a href="#" title="Убрать" class="remove-style-page"><i class="icon-remove"></i></a>
                        <?= StyleAssign::getItemLink($assign) ?>
                    </p>
                    <?php
                }
            }
            ?>
        </div>
    </div>

    <hr>

    <?= $form->dropDownListRow($model, 'background_type', Style::getBgTypeOptions(), ['class' => 'input-xxlarge']) ?>

    <?= $form->textFieldRow($model, 'background_color', ['class' => 'input-small', 'placeholder' => 'fff'], ['prepend' => '#']) ?>

    <hr>

    <?= $form->fileFieldRow($model, 'background_image', [], [
        'hint' => AdminHelper::hintPreview($model, 'background_image'),
    ]) ?>

    <?= $form->numberFieldRow($model, 'background_height', ['class' => 'input-small', 'min' => 0, 'step' => 1], ['append' => 'px']) ?>

    <?= $form->fileFieldRow($model, 'background_repeat_image', [], [
        'hint' => AdminHelper::hintPreview($model, 'background_repeat_image'),
    ]) ?>

    <hr>

    <?= $form->fileFieldRow($model, 'background_image_mobile', [], [
        'hint' => AdminHelper::hintPreview($model, 'background_image_mobile'),
    ]) ?>

    <?= $form->numberFieldRow($model, 'background_width_mobile', ['class' => 'input-small', 'min' => 0, 'step' => 1], ['append' => 'px']) ?>

    <hr>

    <?= $form->numberFieldRow($model, 'page_padding', ['class' => 'input-small', 'min' => 0, 'step' => 1], ['append' => 'px']) ?>

    <?= $form->numberFieldRow($model, 'page_padding_mobile', ['class' => 'input-small', 'min' => 0, 'step' => 1], ['append' => 'px']) ?>

    <?= $form->textFieldRow($model, 'url', ['class' => 'input-xxlarge'], ['prepend' => 'http://']) ?>

    <hr>

    <?= $form->checkBoxListRow($model, 'geo_target_codes', Yii::app()->params['countries'], ['labelOptions' => ['class' => 'checkbox inline']]) ?>

    <div class="form-actions">
        <button type="submit" class="btn btn-primary"><?= $model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Save') ?></button>
        <a href="<?= $this->createUrl('index') ?>" class="btn"><?= Yii::t('app', 'Cancel') ?></a>
    </div>

    <?php $this->endWidget(); ?>

</div>
