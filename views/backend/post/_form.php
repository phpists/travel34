<?php
/* @var $this PostController */
/* @var $model Post */
/* @var $form TbActiveForm */

$themeUrl = Yii::app()->theme->baseUrl;

/** @var CClientScript $cs */
$cs = Yii::app()->clientScript;

$cs->registerScriptFile(Common::assetsTime($themeUrl . '/js/post_edit.js'));

$cs->registerScriptFile(Common::assetsTime($themeUrl . '/js/jquery.form.min.js'));
$cs->registerScriptFile(Common::assetsTime($themeUrl . '/js/edit_items.js'));

$is_old = false;
if (!$model->isNewRecord && $model->is_new != 1) {
    $is_old = true;
    $cs->registerScript('old-34-styles', 'var old34styles = true;', CClientScript::POS_HEAD);
}
?>

<div class="form">

    <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', [
        'id' => 'post-form',
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

    <?= $form->dropDownListRow($model, 'type_id', $model->getTypeOptions()) ?>

    <?= $form->dropDownListRow($model, 'special_id', SpecialProject::getItems()) ?>

    <?= $form->select2Row($model, 'author_id', [
        'data' => CHtml::listData(Author::model()->findAll(['order' => 'title']), 'id', 'title'),
        'options' => [
            'placeholder' => 'Без автора',
            'allowClear' => true,
        ],
    ]) ?>

    <?= $form->select2Row($model, 'rubric_id', [
        'data' => CHtml::listData(Rubric::model()->findAll(['order' => 'title']), 'id', 'title'),
        'options' => [
            'placeholder' => 'Без рубрики',
            'allowClear' => true,
        ],
    ]) ?>

    <?= $form->checkBoxRow($model, 'status_paywall') ?>

    <?= $form->checkBoxRow($model, 'access_by_link') ?>

    <?= $form->textFieldRow($model, 'title', ['class' => 'input-xxlarge']) ?>

    <?php if (!$model->isNewRecord): ?>
        <?= $form->textFieldRow($model, 'url', ['class' => 'input-xxlarge'], [
            'prepend' => '/post/',
            'hint' => CHtml::link('<strong>Просмотр ссылки</strong>', $model->getUrl(), ['class' => 'btn', 'target' => '_blank']),
        ]) ?>
    <?php endif; ?>

    <?= $form->textFieldRow($model, 'page_title', ['class' => 'input-xxlarge']) ?>

    <?= $form->textAreaRow($model, 'page_keywords', ['class' => 'input-xxlarge']) ?>

    <?= $form->textAreaRow($model, 'description', ['class' => 'input-xxlarge', 'rows' => 3]) ?>

    <?= $form->dateTimePickerRow($model, 'date', [
        'options' => [
            'format' => 'yyyy-mm-dd hh:ii',
            'autoclose' => true,
        ],
        'htmlOptions' => [
            'class' => 'input-large',
        ],
    ]) ?>

    <hr>

    <?= $form->checkBoxRow($model, 'is_gtb_post') ?>

    <?= $form->select2Row($model, 'gtb_post_id', [
        'data' => GtbPost::getItems(),
        'htmlOptions' => [
            'class' => 'input-xxlarge',
        ],
    ]) ?>

    <hr>

    <?= $form->checkBoxRow($model, 'is_gtu_post') ?>

    <?= $form->select2Row($model, 'gtu_post_id', [
        'data' => GtuPost::getItems(),
        'htmlOptions' => [
            'class' => 'input-xxlarge',
        ],
    ]) ?>

    <hr>

    <?= $form->fileFieldRow($model, 'page_og_image', [], [
        'hint' => AdminHelper::hintPreview($model, 'page_og_image', '1200x630, 600x315 или 200x200'),
    ]) ?>

    <?= $form->fileFieldRow($model, 'image', [], [
        'hint' => AdminHelper::hintPreview($model, 'image', '620x413'),
    ]) ?>

    <?= $form->textFieldRow($model, 'news_link', ['class' => 'input-xxlarge'], ['prepend' => 'http://']) ?>

    <?= $form->textFieldRow($model, 'news_link_title', ['class' => 'input-xxlarge']) ?>

    <?= $form->fileFieldRow($model, 'image_news', [], [
        'hint' => AdminHelper::hintPreview($model, 'image_news', '60x60', 60),
    ]) ?>

    <?= $form->fileFieldRow($model, 'custom_icon', [], [
        'hint' => AdminHelper::hintPreview($model, 'custom_icon', '', 30),
    ]) ?>

    <hr>

    <?= $form->checkBoxRow($model, 'is_small_top') ?>

    <hr>

    <?= $form->checkBoxRow($model, 'is_home_top') ?>

    <?= $form->fileFieldRow($model, 'image_home_top', [], [
        'hint' => AdminHelper::hintPreview($model, 'image_home_top', '1920x500'),
    ]) ?>

    <hr>

    <?= $form->checkBoxRow($model, 'need_image_big_post') ?>

    <?= $form->fileFieldRow($model, 'image_big_post', [], [
        'hint' => AdminHelper::hintPreview($model, 'image_big_post', '940x или 670x400 для новости'),
    ]) ?>

    <?= $form->checkBoxRow($model, 'is_home_first_top') ?>

    <hr>

    <?= $form->checkBoxRow($model, 'is_big_top') ?>

    <?= $form->fileFieldRow($model, 'image_top', [], [
        'hint' => AdminHelper::hintPreview($model, 'image_top'),
    ]) ?>

    <hr>

    <?= $form->ckEditorRow($model, 'summary', [
        'editorOptions' => Common::getCKEditorOptions([], $is_old),
    ], ['htmlOptions' => ['style' => 'max-width:1280px']]) ?>

    <?= $form->ckEditorRow($model, 'text', [
        'editorOptions' => Common::getCKEditorOptions(['height' => '500'], $is_old),
    ], ['htmlOptions' => ['style' => 'max-width:1280px']]) ?>

    <hr>

    <?= $form->ckEditorRow($model, 'text_paywall', [
        'editorOptions' => Common::getCKEditorOptions(['height' => '500'], $is_old),
    ], ['htmlOptions' => ['style' => 'max-width:1280px']]) ?>

    <?= $form->textAreaRow($model, 'title_paywall', ['class' => 'input-xxlarge', 'rows' => 3]) ?>

    <?= $form->ckEditorRow($model, 'description_paywall', [
        'editorOptions' => Common::getCKEditorOptions(['height' => '500'], $is_old),
    ], ['htmlOptions' => ['style' => 'max-width:1280px']]) ?>

    <hr>

    <?= $form->select2Row($model, 'citiesIds', [
        'data' => CHtml::listData(City::model()->findAll(['order' => 'title']), 'id', 'title'),
        'htmlOptions' => [
            'class' => 'input-xxlarge',
            'multiple' => 'multiple',
        ],
    ]) ?>

    <?= $form->select2Row($model, 'countriesIds', [
        'data' => CHtml::listData(Country::model()->findAll(['order' => 'title']), 'id', 'title'),
        'htmlOptions' => [
            'class' => 'input-xxlarge',
            'multiple' => 'multiple',
        ],
    ]) ?>

    <hr>

    <?= $form->checkBoxListRow($model, 'geo_target_codes', Yii::app()->params['countries'], ['labelOptions' => ['class' => 'checkbox inline']]) ?>

    <hr>

    <?= $form->checkBoxRow($model, 'hide_banners') ?>

    <hr>

    <?= $form->checkBoxRow($model, 'hide_comments') ?>

    <hr>

    <?= $form->checkBoxRow($model, 'hide_styles') ?>

    <hr>

<?php
    $items = Post::model()->enabled()->not_news()->findAll(['order' => 'date DESC, created_at DESC']); 
    $listData = CHtml::listData($items, 'id', 'title');
    echo $form->select2Row($model, 'related_posts_ids', [
        'data' => $listData,
        'htmlOptions' => [
            'multiple' => 'multiple',
            'class' => 'input-xxlarge',
        ],
    ]);?>

    <hr>

    <?= $form->textFieldRow($model, 'background_color', ['class' => 'input-small', 'placeholder' => 'fff'], ['prepend' => '#']) ?>

    <?= $form->fileFieldRow($model, 'background_image', [], [
        'hint' => AdminHelper::hintPreview($model, 'background_image'),
    ]) ?>

    <?= !empty($model->background_image) ? $form->checkBoxRow($model, 'del_background_image') : '' ?>

    <hr>

    <?= $form->dropDownListRow($model, 'yandex_rss_genre', Post::yandexGenres(), ['prompt' => 'По умолчанию', 'class' => 'input-xlarge']) ?>

    <?= $form->checkBoxRow($model, 'hide_yandex_rss') ?>

    <hr>

    <?= $form->checkBoxListRow($model, 'yandex_zen_categories_array', Common::zenCatgories()) ?>

    <?php //= $form->checkBoxRow($model, 'yandex_zen_adult') ?>

    <?= $form->checkBoxRow($model, 'hide_yandex_zen') ?>

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
