<?php
/* @var $this GtuController */
/* @var $model GtuPost */
/* @var $postBanner Banner */

$this->isViewPage = true;

$app_lang = Yii::app()->language;

$themeUrl = Yii::app()->theme->baseUrl;

$this->setPageTitle($model->page_title ?: $model->title);
$this->setMetaDescription($model->page_description);
if (!$model->access_by_link) {
    $this->setMetaKeywords($model->page_keywords);
}$this->setUrl($model->getUrl());

if ($model->page_og_image) {
    $this->setPageOgImage($model->getImageUrl('page_og_image'));
} elseif ($model->image_top) {
    $this->setPageOgImage($model->getImageUrl('image_top'));
} elseif ($model->image) {
    $this->setPageOgImage($model->getImageUrl('image'));
}

$text = Shortcodes::parse($model->text);

$cs = Yii::app()->clientScript;
if ($model->access_by_link) {
    $cs->registerMetaTag('noindex', 'robots');
}
$cs->registerPackage('jquery');

$this->htmlClasses[] = 'article-page';
$this->bodyClasses[] = 'inner';

$bg_color = $model->getBgColor();
$bg_image = !empty($model->background_image) ? $model->getImageUrl('background_image') : '';

$bg_style = '';
if (!empty($bg_image)) {
    $bg_style = 'background: scroll' . (!empty($bg_color) ? ' #' . $bg_color : '') . ' url(\'' . CHtml::encode($bg_image) . '\') repeat center top !important';
} elseif (!empty($bg_color)) {
    $bg_style = 'background-color: #' . $bg_color . ' !important';
}

if (!empty($bg_style)) {
    $cs->registerCss('post_bg', '.post-body{' . $bg_style . '}');
}

$cs->registerMetaTag(date('c', strtotime($model->date)), null, null, ['property' => 'article:published_time']);
?>

<div class="gtu-post-box">
    <div class="post-body<?php if (!empty($bg_style)): ?> post-bg<?php endif; ?>">
        <?php if ($model->is_supertop == 1 && !empty($model->image_supertop)): ?>
            <div class="article-title-box main-screen-article">
                <div class="container">
                    <div class="img">
                        <img src="<?= $themeUrl ?>/i/article-full-size-ratio.gif" alt="">
                        <div class="sub-box">
                            <p class="h1 article-title"><?= CHtml::encode($model->title) ?></p>
                            <?php $this->renderPartial('_post_attrs', ['model' => $model]); ?>
                        </div>
                    </div>
                </div>
                <div class="bg" style="background-image: url('<?= $model->getImageUrl('image_supertop') ?>');">
                    <div class="gradient" style="background: linear-gradient(180deg, rgba(0, 0, 0, 0) 0%, #000000 100%);"></div>
                </div>
            </div>
        <?php else: ?>
            <div class="article-title-box no-bg-img">
                <div class="container">
                    <h1 class="article-title"><?= CHtml::encode($model->title) ?></h1>
                    <?php $this->renderPartial('_post_attrs', ['model' => $model]); ?>
                    <?php if ($model->is_image_in_post == 1 && $model->image_in_post): ?>
                        <img src="<?= $model->getImageUrl('image_in_post') ?>" class="main-post-img" alt="">
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>

        <div class="container post-container">
            <?php if ($model->is_supertop == 1 && !empty($model->image_supertop)): ?>
                <h1 class="article-title"><?= CHtml::encode($model->title) ?></h1>
            <?php endif; ?>

            <?= $text ?>

            <?php
            if ($model->hide_banners != 1 && $postBanner !== null) {
                echo '<div class="wide-box banner-after-post">' . BannerHelper::getHtml($postBanner) . '</div>';
            }
            ?>

            <?php $this->renderPartial('_post_attrs_bottom', ['model' => $model]); ?>
        </div>
    </div>
</div>
