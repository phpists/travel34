<?php
/* @var $this GtuPostController */
/* @var $model GtuPost */
/* @var $form TbActiveForm */

$themeUrl = Yii::app()->theme->baseUrl;

/** @var CClientScript $cs */
$cs = Yii::app()->clientScript;

$cs->registerScriptFile(Common::assetsTime($themeUrl . '/js/gtu_post_edit.js'));

$cs->registerScriptFile(Common::assetsTime($themeUrl . '/js/jquery.form.min.js'));
$cs->registerScriptFile(Common::assetsTime($themeUrl . '/js/edit_items.js'));
?>

<div class="form">

    <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', [
        'id' => 'gtu-post-form',
        'enableAjaxValidation' => false,
        'type' => 'horizontal',
        'htmlOptions' => [
            'enctype' => 'multipart/form-data',
        ],
    ]); ?>

    <?= $form->errorSummary($model) ?>

    <?= CHtml::activeHiddenField($model, 'type_id', ['value' => GtuPost::TYPE_POST]) ?>

    <?= $form->widgetRow('application.widgets.BootstrapSwitch', [
        'model' => $model,
        'attribute' => 'status_id',
        'onText' => Yii::t('app', 'Enabled'),
        'offText' => Yii::t('app', 'Disabled'),
    ]) ?>

    <?= $form->dropDownListRow($model, 'language', Yii::app()->params['gtuLanguages']) ?>

    <?= $form->select2Row($model, 'author_id', [
        'data' => CHtml::listData(Author::model()->findAll(['order' => 'title']), 'id', 'title'),
        'options' => [
            'placeholder' => 'Без автора',
            'allowClear' => true,
        ],
    ]) ?>

    <?= $form->select2Row($model, 'gtu_rubric_id', [
        'data' => CHtml::listData(GtuRubric::model()->findAll(['order' => 'position, title']), 'id', 'title'),
        'options' => [
            'placeholder' => 'Без рубрики',
            'allowClear' => true,
        ],
    ]) ?>

    <?= $form->checkBoxRow($model, 'access_by_link') ?>

    <?= $form->textFieldRow($model, 'title', ['class' => 'input-xxlarge']) ?>

    <?php if (!$model->isNewRecord): ?>
        <?= $form->textFieldRow($model, 'url', ['class' => 'input-xxlarge'], [
            'prepend' => '/gotobelarus/post/',
            'hint' => CHtml::link('<strong>Просмотр ссылки</strong>', $model->getUrl(), ['class' => 'btn', 'target' => '_blank']),
        ]) ?>
    <?php endif; ?>

    <?= $form->textFieldRow($model, 'page_title', ['class' => 'input-xxlarge']) ?>

    <?= $form->textAreaRow($model, 'page_keywords', ['class' => 'input-xxlarge']) ?>

    <?= $form->textAreaRow($model, 'page_description', ['class' => 'input-xxlarge', 'rows' => 3]) ?>

    <?= $form->dateTimePickerRow($model, 'date', [
        'options' => [
            'format' => 'yyyy-mm-dd hh:ii',
            'autoclose' => true,
        ],
        'htmlOptions' => [
            'class' => 'input-xlarge',
        ],
    ]) ?>

    <?= $form->fileFieldRow($model, 'page_og_image', [], [
        'hint' => AdminHelper::hintPreview($model, 'page_og_image', '1200x630, 600x315 или 200x200'),
    ]) ?>

    <?= $form->fileFieldRow($model, 'image', [], [
        'hint' => AdminHelper::hintPreview($model, 'image', '400x400'),
    ]) ?>

    <hr>

    <?= $form->checkBoxRow($model, 'is_top') ?>

    <?= $form->fileFieldRow($model, 'image_top', [], [
        'hint' => AdminHelper::hintPreview($model, 'image_top', '620x413'),
    ]) ?>

    <hr>

    <?= $form->checkBoxRow($model, 'is_big_top') ?>

    <?= $form->fileFieldRow($model, 'image_big_top', [], [
        'hint' => AdminHelper::hintPreview($model, 'image_big_top', '1920x500'),
    ]) ?>

    <?= $form->checkBoxRow($model, 'is_home_big_top') ?>

    <hr>

    <?= $form->checkBoxRow($model, 'is_image_in_post') ?>

    <?= $form->fileFieldRow($model, 'image_in_post', [], [
        'hint' => AdminHelper::hintPreview($model, 'image_in_post', '940x'),
    ]) ?>

    <hr>

    <?= $form->checkBoxRow($model, 'is_supertop') ?>

    <?= $form->checkBoxRow($model, 'is_home_supertop') ?>

    <?= $form->fileFieldRow($model, 'image_supertop', [], [
        'hint' => AdminHelper::hintPreview($model, 'image_supertop'),
    ]) ?>

    <?= $form->fileFieldRow($model, 'image_home_supertop', [], [
        'hint' => AdminHelper::hintPreview($model, 'image_home_supertop'),
    ]) ?>

    <hr>

    <?= $form->ckEditorRow($model, 'summary', [
        'editorOptions' => Common::getCKEditorOptions([]),
    ], ['htmlOptions' => ['style' => 'max-width:1280px']]) ?>

    <?= $form->ckEditorRow($model, 'text', [
        'editorOptions' => Common::getCKEditorOptions(['height' => '500']),
    ], ['htmlOptions' => ['style' => 'max-width:1280px']]) ?>

    <hr>

    <?= $form->checkBoxRow($model, 'hide_banners') ?>

    <hr>

    <?= $form->checkBoxRow($model, 'hide_styles') ?>

    <hr>

    <?= $form->select2Row($model, 'related_posts_ids', [
        'data' => GtuPost::getItems(),
        'htmlOptions' => [
            'multiple' => 'multiple',
            'class' => 'input-xxlarge',
        ],
    ]) ?>

    <hr>

    <?= $form->textFieldRow($model, 'background_color', ['class' => 'input-small', 'placeholder' => 'fff'], ['prepend' => '#']) ?>

    <?= $form->fileFieldRow($model, 'background_image', [], [
        'hint' => AdminHelper::hintPreview($model, 'background_image'),
    ]) ?>

    <?= !empty($model->background_image) ? $form->checkBoxRow($model, 'del_background_image') : '' ?>

    <?php if ($model->isNewRecord || $model->language == 'ru'): ?>
        <hr>

        <?= $form->dropDownListRow($model, 'yandex_rss_genre', Post::yandexGenres(), ['prompt' => 'По умолчанию', 'class' => 'input-xlarge']) ?>

        <?= $form->checkBoxRow($model, 'hide_yandex_rss') ?>

        <hr>

        <?= $form->checkBoxListRow($model, 'yandex_zen_categories_array', Common::zenCatgories()) ?>

        <?php //= $form->checkBoxRow($model, 'yandex_zen_adult') ?>

        <?= $form->checkBoxRow($model, 'hide_yandex_zen') ?>
    <?php endif; ?>

    <div class="form-actions">
        <button type="submit" class="btn btn-primary"><?= $model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Save') ?></button>
        <a href="<?= $this->createUrl('index') ?>" class="btn"><?= Yii::t('app', 'Cancel') ?></a>
    </div>

    <?php $this->endWidget(); ?>

</div>

<?php if (!$model->isNewRecord): ?>
    <div class="form-items">
        <?php $this->renderPartial('_styles', ['item_id' => $model->id]); ?>
    </div>
<?php endif; ?>
