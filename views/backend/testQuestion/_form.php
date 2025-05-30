<?php
/* @var $this TestQuestionController */
/* @var $model TestQuestion */
/* @var $parent_model TestWidget */
/* @var $form ExtTbActiveForm */

if (!$model->isNewRecord) {
    $themeUrl = Yii::app()->theme->baseUrl;

    /** @var CClientScript $cs */
    $cs = Yii::app()->clientScript;

    $cs->registerScriptFile(Common::assetsTime($themeUrl . '/js/jquery.form.min.js'));
    $cs->registerScriptFile(Common::assetsTime($themeUrl . '/js/edit_items.js'));
}
?>

<div class="form">

    <?php $form = $this->beginWidget('application.widgets.ExtTbActiveForm', [
        'id' => 'test-question-form',
        'enableAjaxValidation' => false,
        'type' => 'horizontal',
        /*'htmlOptions' => [
            'enctype' => 'multipart/form-data',
        ],*/
    ]); ?>

    <?= $form->errorSummary($model) ?>

    <?= $form->textAreaRow($model, 'title', ['rows' => 2, 'cols' => 50, 'class' => 'input-xxlarge']) ?>

    <?= $form->ckEditorRow($model, 'text', [
        'editorOptions' => Common::getCKEditorOptions(),
    ], ['htmlOptions' => ['style' => 'max-width:1280px']]) ?>

    <?= $form->dropDownListRow($model, 'grid_variant', TestQuestion::getGridVariantOptions(), ['class' => 'input-xlarge']) ?>

    <?php if ($parent_model->type == TestWidget::TYPE_ONE): ?>

        <hr>

        <?= $form->textAreaRow($model, 'answer', ['rows' => 2, 'cols' => 50, 'class' => 'input-xxlarge']) ?>

        <?= $form->textFieldRow($model, 'correct_answer_text', ['class' => 'input-xlarge']) ?>

        <?= $form->textFieldRow($model, 'wrong_answer_text', ['class' => 'input-xlarge']) ?>

    <?php endif; ?>

    <hr>

    <?= $form->numberFieldRow($model, 'position', ['class' => 'input-large']) ?>

    <div class="form-actions">
        <button type="submit" class="btn btn-primary"><?= $model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Save') ?></button>
        <a href="<?= $this->createUrl('index', ['parent' => $parent_model->id]) ?>" class="btn"><?= Yii::t('app', 'Cancel') ?></a>
    </div>

    <?php $this->endWidget(); ?>

</div>
