<?php
/* @var $this GtuPlaceController */
/* @var $model GtuPlace */
/* @var $form TbActiveForm */

$themeUrl = Yii::app()->theme->baseUrl;

/** @var CClientScript $cs */
$cs = Yii::app()->clientScript;

?>

<div class="form">

    <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', [
        'id' => 'gtu-place-form',
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

    <?= $form->dropDownListRow($model, 'language', Yii::app()->params[Yii::app()->controller->langs]) ?>

    <?= $form->textFieldRow($model, 'title', ['class' => 'input-xxlarge']) ?>

    <?= $form->textFieldRow($model, 'lat', ['class' => 'input-xxlarge']) ?>

    <?= $form->textFieldRow($model, 'lng', ['class' => 'input-xxlarge']) ?>

    <?= $form->dropDownListRow($model, 'type', GtuPlace::getTypeOptions()) ?>

    <?= $form->textAreaRow($model, 'description', ['rows' => 3, 'cols' => 50, 'class' => 'input-xxlarge']) ?>

    <div class="control-group">
        <div class="controls">
            <a target="_blank" tabindex="-1" href="/admin/elfinder">elFinder</a>
        </div>
    </div>


    <?= $form->textAreaRow($model, 'images', ['rows' => 3, 'cols' => 50, 'class' => 'input-xxlarge']) ?>

    <hr>

    <?= $form->select2Row($model, 'related_posts_ids', [
        'data' => CHtml::listData(Post::model()->enabled()->not_news()->findAll(['order' => 'date DESC, created_at DESC']), 'id', 'title'),
        'htmlOptions' => [
            'multiple' => 'multiple',
            'class' => 'input-xxlarge',
        ],
    ]) ?>

    <?= $form->select2Row($model, 'related_posts_gtu_ids', [
        'data' => GtuPost::getItems(),
        'htmlOptions' => [
            'multiple' => 'multiple',
            'class' => 'input-xxlarge',
        ],
    ]) ?>

    <?= $form->select2Row($model, 'related_posts_gtb_ids', [
        'data' => GtbPost::getItems(),
        'htmlOptions' => [
            'multiple' => 'multiple',
            'class' => 'input-xxlarge',
        ],
    ]) ?>

    <hr>

    <div class="form-actions">
        <button type="submit"
                class="btn btn-primary"><?= $model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Save') ?></button>
        <a href="<?= $this->createUrl('index') ?>" class="btn"><?= Yii::t('app', 'Cancel') ?></a>
    </div>

    <?php $this->endWidget(); ?>

</div>