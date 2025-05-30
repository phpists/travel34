<?php
/* @var $this PostController */
/* @var $model Post */
/* @var $subscribeImage string */
/* @var $relatedPosts Post[] */
/* @var $newsBanner Banner */
/* @var $postBanner Banner */

$this->isNewStyledPost = true;

$themeUrl = Yii::app()->theme->baseUrl;

$this->setPageTitle($model->page_title);
if (!empty($model->description)) {
    $this->setMetaDescription($model->description);
}
if (!$model->access_by_link) {
    $this->setMetaKeywords($model->page_keywords);
}
$this->setUrl($model->getUrl());

if (!empty($model->page_og_image)) {
    $this->setPageOgImage($model->getImageUrl('page_og_image'));
} elseif ($model->url == 'festivals') {
    $this->setPageOgImage($themeUrl . '/images/festival/festivals_fb.jpg');
} elseif ($model->isNews() && !empty($model->image_big_post)) {
    $this->setPageOgImage($model->getImageUrl('image_big_post'));
} elseif (!$model->isNews() && !empty($model->image)) {
    $this->setPageOgImage($model->getImageUrl('image'));
}

$text = Shortcodes::parse($model->text);

$ulej_shortcode_re = '/(?:<p[^>]*>[\s]*)?\[ULEJ\](?:[\s]*(?:<\/p>|<br(?: ?\/)?>(?:[\s]*<\/p>)?))?/';
$has_ulej = preg_match($ulej_shortcode_re, $text);
if ($has_ulej) {
    $ulej_shortcode = $this->renderPartial('_ulej', ['utm' => 'utm_source=web-donation&utm_medium=cpc&utm_campaign=34travel'], true);
    $text = preg_replace($ulej_shortcode_re, $ulej_shortcode, $text);
}

/** @var CClientScript $cs */
$cs = Yii::app()->clientScript;

if ($model->access_by_link) {
    $cs->registerMetaTag('noindex', 'robots');
}

$cs->registerCssFile(Common::assetsTime($themeUrl . '/css/bootstrap/bootstrap-grid.min.css'));
$cs->registerScriptFile(Common::assetsTime($themeUrl . '/js/comment.js'));
$cs->registerScriptFile(Common::assetsTime($themeUrl . '/js/social-likes.min.js'), CClientScript::POS_END);

if ($model->url != 'travelisnotdead') {
    $cs->registerCssFile(Common::assetsTime($themeUrl . '/css/ulej-tips-styles.css'));
}
if ($has_ulej) {
    $cs->registerScriptFile(Common::assetsTime($themeUrl . '/js/ulej-tips-script.js'), CClientScript::POS_END);
}

if (in_array($model->url, ['destinations2018', 'winter-roulette', 'business-trip'])) {
    $this->roulette = $model->url;
}

$bg_color = $model->getBgColor();
$bg_image = !empty($model->background_image) ? $model->getImageUrl('background_image') : '';

if (!empty($bg_image)) {
    $bg_style = 'background: scroll' . (!empty($bg_color) ? ' #' . $bg_color : '') . ' url(\'' . CHtml::encode($bg_image) . '\') repeat center top !important';
} elseif (!empty($bg_color)) {
    $bg_style = 'background-color: #' . $bg_color . ' !important';
}

if (!empty($bg_style)) {
    $cs->registerCss('post_bg', '.post-body{' . $bg_style . '}');
}

if (($model->isNews() || empty($relatedPosts)) && ($model->hide_comments == 1 || $model->comments_count == 0) && empty($additionalPosts)) {
    $cs->registerCss('post_body_padding', '.post-body{padding-bottom:0}');
}

$cs->registerMetaTag(date('c', strtotime($model->date)), null, null, ['property' => 'article:published_time']);
//if ($model->isNews()) {
//    $cs->registerMetaTag($model->getImageUrl('image_news', true), 'relap-image');
//}

?>
<div class="post-body post-bg" <?php if (!empty($bg_style)): ?> style="<?= $bg_style ?>" <?php endif; ?>>
    <div class="post-meta__faves_wrap">
        <div class="container">
            <div class="wide-box">
                <?php if ((int)$model->is_big_top != 1 || empty($model->image_top)): ?>
                    <h1 class="post-title"><?= $model->title ?></h1>
                <?php endif; ?>
                <div class="post-meta post-meta--no-border">
                    <div class="info-box info-box__separated">
                        <?php if (Yii::app()->userComponent->isAuthenticated()): ?>
                            <a href="#form_add_post_view"
                               class="post-meta__faves post-meta__faves_static popup-with-form addPostViewToFaves"
                               data-post_id="<?= $model->id ?>">
                                <svg class="svg_<?= $model->id ?>"
                                        width="20"
                                        height="19"
                                        viewBox="0 0 20 19"
                                        fill="<?= $model->isFavorite() ? 'black' : 'none' ?>"
                                        xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10.2872 14.5154L10 14.3139L9.71284 14.5154L4.15485 18.4147L6.22532 11.978L6.33572 11.6348L6.04494 11.4216L0.618485 7.44402H7.33734H7.69632L7.81109 7.10388L9.99989 0.61727L12.1887 7.10388L12.3035 7.44402H12.6624H19.3815L13.9551 11.4219L13.6643 11.635L13.7747 11.9782L15.8448 18.4145L10.2872 14.5154ZM19.5233 7.34006L19.5233 7.34011L19.5233 7.34006Z"
                                          fill="transperent" stroke="black"></path>
                                </svg>
                            </a>
                        <?php endif; ?>
                        <div class="post-meta-item">
                            <?php if (!empty($model->date)): ?>
                                <time datetime="<?= date('c', strtotime($model->date)) ?>"><?= date('d.m.Y', strtotime($model->date)) ?></time>
                            <?php endif; ?>
                            <?php if ($model->rubric): ?>
                                <div class="rubric">
                                    <p>
                                        РУБРИКА:
                                        <a href="<?= $model->rubric->getUrl() ?>"><?= $model->rubric->title ?></a>
                                    </p>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="post-meta-item">
                            <?php if ($model->author): ?>
                                <div class="author">
                                    <p>
                                        Автор:
                                        <a href="<?= $this->createUrl('authors/view', array('name' => $model->author->title)) ?>"><?= $model->author->title ?></a>
                                    </p>
                                </div>
                            <?php endif; ?>
                            <div class="meta">
                                <p class="views"><?= $model->views_count ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <?php if (!$model->isNews() && $model->need_image_big_post && $model->image_big_post) { ?>
                    <div class="post-img">
                        <img src="<?= $model->getImageUrl('image_big_post') ?>" alt="">
                    </div>
                <?php } elseif ($model->isNews()) { ?>
                    <div class="post-img post-news-img">
                        <?php
                        if ($model->hide_banners != 1 && $newsBanner !== null) {
                            echo '<div class="banner-new post-img-top">' . BannerHelper::getHtml($newsBanner) . '</div>';
                        }
                        ?>
                        <img src="<?= $model->getImageUrl('image_big_post') ?>" alt="">
                        <br class="clearfloat">
                    </div>
                <?php } ?>
            </div>

            <a id="post-text"></a>
            <?= $model->getPostText($model, $text) ?>

            <?php if ($model->isNews()) { ?>
                <div class="post-img post-news-img post-img-bottom">
                    <?php
                    if ($model->hide_banners != 1 && $newsBanner !== null) {
                        echo '<div class="banner-new">' . BannerHelper::getHtml($newsBanner) . '</div>';
                    }
                    ?>
                </div>
            <?php } ?>

            <?php
            if (!empty($model->countries) || !empty($model->cities)) {
                $tagsString = '';
                foreach ($model->countries as $country) {
                    $tagsString .= '<a href="' . $country->getUrl() . '">' . $country->title . '</a>, ';
                }
                foreach ($model->cities as $city) {
                    $tagsString .= '<a href="' . $city->getUrl() . '">' . $city->title . '</a>, ';
                }
                $tagsString = rtrim($tagsString, ', ');
                ?>
                <div class="b-post__geo">Тэги: <?= $tagsString ?></div>
            <?php } ?>

            <span class="goUp"></span>

            <?php if (!$model->access_by_link): ?>
                <? /*
                <div class="share-bottom">
                    <div class="label">
                        <p>ПОДЕЛИТЬСЯ:</p>
                    </div>
                    <div class="share-box">
                        <div class="social-likes social-likes_notext" data-url="<?= CHtml::encode($model->getUrl()) ?>" data-title="<?= CHtml::encode($model->title) ?>">
                            <div class="facebook" title="Поделиться ссылкой на Фейсбуке"></div>
                            <div class="twitter" title="Поделиться ссылкой в Твиттере"></div>
                            <div class="vkontakte" title="Поделиться ссылкой во Вконтакте"></div>
                        </div>
                    </div>
                    <div class="meta">
                        <p class="views"><?= $model->views_count ?></p>
                        <p class="comment"><?= $model->comments_count ?></p>
                    </div>
                </div>
            */ ?>
            <?php endif; ?>

            <?php
            if ($model->hide_banners != 1 && $postBanner !== null) {
                echo '<div class="wide-box banner-after-post">' . BannerHelper::getHtml($postBanner) . '</div>';
            }
            ?>

            <?php /*if ($model->isNews() && isset(Yii::app()->params['relap-news'])): ?>
            <div class="wide-box"><?= Yii::app()->params['relap-news'] ?></div>
        <?php endif;*/ ?>
        </div>
    </div>
</div>

<?php if (Yii::app()->userComponent->isAuthenticated() && !Yii::app()->userComponent->checkMySubscription()): ?>
    <?php $this->renderPartial('//layouts/_tariff', ['post' => $model]) ?>
<?php elseif ($model->status_paywall == true): ?>
    <?php $this->renderPartial('//layouts/_tariff', ['post' => $model]) ?>
<?php endif; ?>

<?php if (!$model->access_by_link && $model->isNews()): ?>
    <div class="post-body<?php if (!empty($bg_style)): ?> post-bg<?php endif; ?>"
         style="background-color: white !important;">
        <div class="post-meta__faves_wrap">
            <div class="container">
                <div class="wide-box">
                    <?php $this->widget('application.widgets.LatestNews', array(
                        'skipId' => $model->id,
                    )); ?>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>


<?php if (!$model->access_by_link): ?>
    <?php
    if (!$model->isNews()) {
        $this->renderPartial('_related', ['relatedPosts' => $relatedPosts]);
    }
    ?>

    <?php !$model->hide_comments && $this->renderPartial('_comments', ['model' => $model]); ?>

    <?php if (!empty($additionalPosts)): ?>
        <div class="b-main additional-posts">
            <h2 class="add-title"><?= Yii::t('app', 'On the main page') ?></h2>
            <?php $this->renderPartial('_posts', array(
                'resultPostsList' => $additionalPosts['resultPostsList'],
                'showMore' => $additionalPosts['showMore'],
                'counters' => $additionalPosts['counters'],
                'postID' => $model->id
            )); ?>
        </div>
    <?php endif; ?>
<?php endif; ?>
