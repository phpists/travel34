<?php
/* @var $this GtbController */
/* @var $model GtbPost */
/* @var $subscribeImage string */
/* @var $relatedPosts Post[] */
/* @var $additionalPosts array */
/* @var $postBanner Banner */

$is_new = $model->is_new == 1;

$app_lang = Yii::app()->language;

$themeUrl = Yii::app()->theme->baseUrl;

$this->setPageTitle($model->page_title);
if ($model->page_description) {
    $this->setMetaDescription($model->page_description);
}
if (!$model->access_by_link) {
    $this->setMetaKeywords($model->page_keywords);
}
$this->setUrl($model->getUrl());

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

$cs->registerScriptFile(Common::assetsTime($themeUrl . '/js/comment.js'));

if (preg_match_all('/Galleria.run\([^\)]+\);?/', $text, $m)) {
    $cs->registerCssFile($themeUrl . '/css/galleria.classic.css');
    //$cs->registerScriptFile($themeUrl . '/js/jquery-migrate-1.4.1.min.js');
    $cs->registerScriptFile($themeUrl . '/js/galleria-1.2.7.js');
    $cs->registerScriptFile($themeUrl . '/js/galleria.classic.js');
    $gal = array_map(function ($val) {
        return preg_replace('/\\n[\\s]+/', "\n", $val);
    }, $m[0]);
    $js = implode("\n", $gal);
    $cs->registerScript('galleria-init', $js);
    $text = preg_replace('/Galleria.run\([^\)]+\);?/', '', $text);

    // fix - add closing div
    $text = preg_replace('%(<div class="galleria-top-container"[^>]*>\s*(<img[^>]+>\s*)+)\s*<script[^>]*>[\s\S]*?</script>(\s*</div>)?%', '\1</div><!-- /div fix -->', $text);
}

if (!$is_new) {
    $this->oldPostStyles = true;
}

// ULEJ
if ($app_lang != 'en') {
    $cs->registerCssFile(Common::assetsTime($themeUrl . '/css/ulej-tips-styles.css'));
    //$cs->registerScriptFile(Common::assetsTime($themeUrl . '/js/ulej-tips-script.js'), CClientScript::POS_END);
}

/*if ($post->url == 'destinations2018') {
    $cs->registerCssFile($themeUrl . '/css/roulette_gtb.css');
    $cs->registerScriptFile($themeUrl . '/js/roulette.js');
}*/

if ($model->url == 'travelbelarus') {
    $this->roulette = 'vetliva';
}

$this->htmlClasses[] = 'article-page';

$this->bodyClasses[] = 'inner';

$bg_color = $model->getBgColor();
$bg_image = $model->background_image ? $model->getImageUrl('background_image') : '';

$bg_style = '';
if ($bg_image) {
    $bg_style = 'background: scroll' . ($bg_color ? ' #' . $bg_color : '') . ' url(\'' . CHtml::encode($bg_image) . '\') repeat center top !important';
} elseif ($bg_color) {
    $bg_style = 'background-color: #' . $bg_color . ' !important';
}

if ($bg_style) {
    if ($is_new) {
        $cs->registerCss('post_bg', '.post-body{' . $bg_style . '}');
    } elseif (empty($this->style['style'])) {
        // у старых постов с фоном мимикрируем под брендирование
        $this->style = [
            'style' => "padding-top: 0; $bg_style",
            'style_mobile' => "padding-top: 0; $bg_style",
            'url' => '',
        ];
    }
}

$cs->registerMetaTag(date('c', strtotime($model->date)), null, null, ['property' => 'article:published_time']);
?>

<a id="post-text"></a>
<div class="post-body<?php if ($bg_style): ?> post-bg<?php endif; ?>">
    <?php if ($model->is_supertop == 1 && $model->image_supertop): ?>
        <div class="post-title-box full-height title-overlay">
            <div class="post-title-img" style="background-image: url('<?= $model->getImageUrl('image_supertop') ?>')"></div>
            <div class="meta">
                <p class="h1 post-title"><?= CHtml::encode($model->title) ?></p>
                <?php $this->renderPartial('_post_attrs', ['model' => $model]); ?>
            </div>
        </div>
    <?php else: ?>
        <div class="article-title-box no-bg-img">
            <div class="container">
                <h1 class="article-title"><?= CHtml::encode($model->title) ?></h1>
                <?php $this->renderPartial('_post_attrs', ['model' => $model]); ?>
                <?php if ($model->is_image_in_post && $model->image_in_post): ?>
                    <div class="post-img">
                        <img src="<?= $model->getImageUrl('image_in_post') ?>" alt="" class="main-post-img">
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($is_new): ?>
        <div class="container">
            <?php if ($model->is_supertop == 1 && $model->image_supertop): ?>
                <h1 class="article-title"><?= CHtml::encode($model->title) ?></h1>
            <?php endif; ?>

            <?php
            if ($model->url == 'travelbelarus') {
                $this->renderPartial('_vetliva', ['text' => $text]);
            } else {
                echo $text;
            }
            ?>

            <?php
            if ($model->hide_banners != 1 && $postBanner !== null) {
                echo '<div class="wide-box banner-after-post">' . BannerHelper::getHtml($postBanner) . '</div>';
            }
            ?>
        </div>
    <?php else: ?>
        <div class="b-post">
            <div class="b-post__text">
                <div class="b-post__text__wrapper">
                    <?php if ($model->is_supertop == 1 && $model->image_supertop): ?>
                        <h1 class="article-title"><?= CHtml::encode($model->title) ?></h1>
                    <?php endif; ?>

                    <?php
                    if ($model->url == 'travelbelarus') {
                        $this->renderPartial('_vetliva', ['text' => $text]);
                    } else {
                        echo str_replace('wide-box', 'wide-box-not-for-old-post', $text);
                    }
                    ?>

                    <?php
                    if ($model->hide_banners != 1 && $postBanner !== null) {
                        echo '<div class="full-width banner-after-post">' . BannerHelper::getHtml($postBanner) . '</div>';
                    }
                    ?>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <div class="container">
        <?php $this->renderPartial('_post_attrs_bottom', ['model' => $model]); ?>
    </div>
</div>

<?php if (!$model->access_by_link): ?>
<?php
//$this->renderPartial('//post/_subscribe', ['subscribeImage' => $subscribeImage]);
if ($app_lang != 'en') {
    //$this->renderPartial('//post/_ulej', ['utm' => 'utm_source=web&utm_medium=cpc&utm_campaign=34travel']);
    $this->renderPartial('//post/_ulej_simple');
}
?>

<?php $this->renderPartial('_related', ['relatedPosts' => $relatedPosts]); ?>



<?php !$model->hide_comments && $this->renderPartial('_comments', ['model' => $model]); ?>

<?php
if (!empty($additionalPosts['posts'])) {
    ?>
    <div class="b-main additional-posts post-container">
        <h2 class="add-title"><?= Yii::t('app', 'On the main page') ?></h2>
        <?php $this->renderPartial('_additional_posts', $additionalPosts); ?>
    </div>
    <?php
}
?>
<?php endif; ?>


<span class="goUp"></span>
