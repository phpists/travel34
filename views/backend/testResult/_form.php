<?php
/* @var $this TestResultController */
/* @var $model TestResult */
/* @var $parent_model TestWidget */
/* @var $form ExtTbActiveForm */
?>

<div class="form">

    <?php $form = $this->beginWidget('application.widgets.ExtTbActiveForm', [
        'id' => 'test-result-form',
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

    <?php if ($parent_model->type != TestWidget::TYPE_ONE):
        $all_variants = $parent_model->getAllVariants();
        ?>

        <hr>

        <div class="control-group">
            <label class="control-label"><?= CHtml::encode($model->getAttributeLabel('variants')) ?></label>
            <div class="controls">
                <?php
                foreach ($all_variants as $question_id => $question_data) {
                    echo '<h5>' . CHtml::encode($question_data['title']) . '</h5>';
                    foreach ($question_data['variants'] as $variant_id => $variant) {
                        echo '<label class="radio">';
                        echo CHtml::activeRadioButton($model, "variants[$question_id]", ['value' => $variant_id, 'uncheckValue' => null]) . "\n";
                        echo $variant;
                        echo '</label>';
                    }
                }
                ?>
            </div>
        </div>

    <?php endif; ?>

    <?php if ($parent_model->type == TestWidget::TYPE_ONE): ?>

        <hr>

        <?= $form->dropDownListRow($model, 'correct_count', TestResult::getCorrectCountValues(), ['class' => 'input-xlarge']) ?>

    <?php endif; ?>

    <div class="form-actions">
        <button type="submit" class="btn btn-primary"><?= $model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Save') ?></button>
        <a href="<?= $this->createUrl('index', ['parent' => $parent_model->id]) ?>" class="btn"><?= Yii::t('app', 'Cancel') ?></a>
    </div>

    <?php $this->endWidget(); ?>

</div>
