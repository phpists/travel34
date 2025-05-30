<?php
/* @var $this PostController */
/* @var $model Post */
/* @var $subscribeImage string */
/* @var $relatedPosts Post[] */
/* @var $newsBanner Banner */
/* @var $postBanner Banner */

$themeUrl = Yii::app()->theme->baseUrl;

$this->setPageTitle($model->page_title);
if (!empty($model->description)) {
    $this->setMetaDescription($model->description);
}
$this->setMetaKeywords($model->page_keywords);
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

$cs->registerCssFile(Common::assetsTime($themeUrl . '/css/bootstrap/bootstrap-grid.min.css'));
$cs->registerScriptFile(Common::assetsTime($themeUrl . '/js/comment.js'));
$js = "var socialLikesButtons={twitter:{counterUrl:'https://opensharecount.com/count.json?url={url}',convertNumber:function(data){return data.count;}}};";
$cs->registerScript('social-opensharecount', $js, CClientScript::POS_HEAD);
$cs->registerScriptFile(Common::assetsTime($themeUrl . '/js/social-likes.min.js'), CClientScript::POS_END);

if (preg_match_all('/Galleria.run\([^\)]+\);?/', $text, $m)) {
    $cs->registerCssFile(Common::assetsTime($themeUrl . '/css/galleria.classic.css'));
    $cs->registerScriptFile(Common::assetsTime($themeUrl . '/js/galleria-1.2.7.js'));
    $cs->registerScriptFile(Common::assetsTime($themeUrl . '/js/galleria.classic.js'));
    $gal = array_map(function ($val) {
        return preg_replace('/\\n[\\s]+/', "\n", $val);
    }, $m[0]);
    $js = implode("\n", $gal);
    $cs->registerScript('galleria-init', $js);
    $text = preg_replace('/Galleria.run\([^\)]+\);?/', '', $text);
}

if ($model->url == 'ruletka') {
    $this->roulette = $model->url;
}

// ulej
$cs->registerCssFile(Common::assetsTime($themeUrl . '/css/ulej-tips-styles.css'));
if ($has_ulej) {
    $cs->registerScriptFile(Common::assetsTime($themeUrl . '/js/ulej-tips-script.js'), CClientScript::POS_END);
}

$cs->registerMetaTag(date('c', strtotime($model->date)), null, null, ['property' => 'article:published_time']);
/*if ($model->isNews()) {
    $cs->registerMetaTag($model->getImageUrl('image_news', true), 'relap-image');
}*/
?>
<div class="b-main">
    <div class="b-content">
        <div class="b-post">
            <a id="post-text"></a>
            <?php if ((int)$model->is_big_top != 1 || empty($model->image_top)): ?>
                <h1 class="b-post__title"><?= $model->title ?></h1>
            <?php endif; ?>
            <div class="b-post__info <?= ((int)$model->is_big_top == 1 && !empty($model->image_top) ? 'b-post__info__pano' : ($model->isNews() ? 'b-post__info__news' : '')) ?>">
                <div class="b-post__share">
                    <div class="social-likes social-likes_notext" data-url="<?= CHtml::encode($model->getUrl()); ?>"
                         data-title="<?= CHtml::encode($model->title); ?>">
                        <div class="facebook" title="Поделиться ссылкой на Фейсбуке"></div>
                        <div class="twitter" title="Поделиться ссылкой в Твиттере"></div>
                        <div class="vkontakte" title="Поделиться ссылкой во Вконтакте"></div>
                    </div>
                </div>
                <div class="b-post__info__detail">
                    <?php if (!empty($model->date)) { ?>
                        <span class="b-post__date"><?= date('d.m.Y', strtotime($model->date)) ?></span>
                    <?php } ?>
                    <?php if ($model->rubric) { ?>
                        <span class="b-post__category">РУБРИКА: <a
                                    href="<?= $model->rubric->getUrl() ?>"><?= $model->rubric->title ?></a></span>
                    <?php } ?>
                    <?php if ($model->author) { ?>
                        <span class="b-post__author">Автор: <a
                                    href="<?= $this->createUrl('authors/view', array('name' => $model->author->title)) ?>"><?= $model->author->title ?></a></span>
                    <?php } ?>
                    <span class="b-news__short__view"><?= $model->views_count ?></span>
                    <?php /*<span class="b-news__short__comment"><?= $model->comments_count ?></span>*/ ?>
                    <?php if ($model->isNews()) { ?>
                        <?php if (!empty($model->news_link) && !empty($model->news_link_title)) { ?>
                            <span class="b-news__magazine">
                                <i class="b-icon__news"></i>
                                <a href="http://<?= $model->news_link ?>"
                                   target="_blank"><?= $model->news_link_title ?></a>
                            </span>
                        <?php } ?>
                    <?php } ?>
                </div>
                <br class="clearfloat"/>
            </div>
            <?php if (!$model->isNews() && $model->need_image_big_post && $model->image_big_post) { ?>
                <div class="b-post__image">
                    <?php if (Yii::app()->userComponent->isAuthenticated()): ?>
                        <a href="#form_add_post_view" class="post-meta__faves popup-with-form addPostViewToFaves"
                           data-post_id="<?= $model->id ?>">
                            <svg class="svg_<?= $model->id ?>" width="20" height="19" viewBox="0 0 20 19" fill="<?= $model->isFavorite() ? 'black' : 'none' ?>"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path d="M10.2872 14.5154L10 14.3139L9.71284 14.5154L4.15485 18.4147L6.22532 11.978L6.33572 11.6348L6.04494 11.4216L0.618485 7.44402H7.33734H7.69632L7.81109 7.10388L9.99989 0.61727L12.1887 7.10388L12.3035 7.44402H12.6624H19.3815L13.9551 11.4219L13.6643 11.635L13.7747 11.9782L15.8448 18.4145L10.2872 14.5154ZM19.5233 7.34006L19.5233 7.34011L19.5233 7.34006Z"
                                      fill="transperent" stroke="black"/>
                            </svg>
                        </a>
                    <?php endif; ?>
                    <img src="<?= $model->getImageUrl('image_big_post') ?>" alt="" title=""/>
                </div>
            <?php } elseif ($model->isNews()) { ?>
                <div class="b-news__image">
                    <div class="b-news__image__block">
                        <img src="<?= $model->getImageUrl('image_big_post') ?>" alt="">
                    </div>
                    <?php
                    if ($model->hide_banners != 1 && $newsBanner !== null) {
                        echo '<div class="banner-new">' . BannerHelper::getHtml($newsBanner) . '</div>';
                    }
                    ?>
                    <br class="clearfloat"/>
                </div>
            <?php } ?>

            <div class="b-post__text">
                <div class="b-post__text__wrapper">
                    <?php if (empty($model->need_image_big_post)): ?>
                        <?php if (Yii::app()->userComponent->isAuthenticated()): ?>
                            <a href="#form_add_post_view" class="post-meta__faves popup-with-form addPostViewToFaves"
                               data-post_id="<?= $model->id ?>">
                                <svg class="svg_<?= $model->id ?>" width="20" height="19" viewBox="0 0 20 19" fill="<?= $model->isFavorite() ? 'black' : 'none' ?>"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10.2872 14.5154L10 14.3139L9.71284 14.5154L4.15485 18.4147L6.22532 11.978L6.33572 11.6348L6.04494 11.4216L0.618485 7.44402H7.33734H7.69632L7.81109 7.10388L9.99989 0.61727L12.1887 7.10388L12.3035 7.44402H12.6624H19.3815L13.9551 11.4219L13.6643 11.635L13.7747 11.9782L15.8448 18.4145L10.2872 14.5154ZM19.5233 7.34006L19.5233 7.34011L19.5233 7.34006Z"
                                          fill="transperent" stroke="black"/>
                                </svg>
                            </a>
                        <?php endif; ?>
                    <?php endif; ?>
                    <?php
                    if ($model->url == 'ruletka') {
                        $this->renderPartial('//postparts/_ruletka', ['text' => $text]);
                    } else {
                        if ($model->url == 'festivals') {
                            $this->renderPartial('//postparts/_header_festival');
                        }
                        if ($model->url == 'calendar') {
                            $this->renderPartial('//postparts/_header_calendar');
                        }
                        echo $text;
                    }
                    ?>
                </div>


                <?php
                if ($model->hide_banners != 1 && $postBanner !== null) {
                    echo '<div class="banner-new">' . BannerHelper::getHtml($postBanner) . '</div>';
                }
                ?>

                <?php /*if ($model->isNews() && isset(Yii::app()->params['relap-news'])): ?>
                    <div class="full-width"><?= Yii::app()->params['relap-news'] ?></div>
                <?php endif;*/ ?>

                <?php if ($model->isNews()): ?>
                    <div class="full-width">
                        <?php $this->widget('application.widgets.LatestNews', array(
                            'skipId' => $model->id,
                        )); ?>
                    </div>
                <?php endif; ?>
            </div>
            <span class="goUp"></span>
        </div>
    </div>
</div>

<?php if (Yii::app()->userComponent->isAuthenticated()): ?>
    <?php $this->renderPartial('//layouts/_tariff', ['post' => $model]) ?>
<?php elseif ($model->status_paywall == true): ?>
    <?php $this->renderPartial('//layouts/_tariff', ['post' => $model]) ?>
<?php endif; ?>

<?php
//$this->renderPartial('_subscribe', array('subscribeImage' => $subscribeImage));
if (!$has_ulej) {
    //$this->renderPartial('_ulej', ['utm' => 'utm_source=web&utm_medium=cpc&utm_campaign=34travel']);
    $this->renderPartial('_ulej_simple');
}
?>

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
