<?php
/* @var $this GtuController */
/* @var $content string */

$themeUrl = Yii::app()->theme->baseUrl;

/** @var CClientScript $cs */
$cs = Yii::app()->clientScript;
$cs->registerPackage('jquery');

$cs->registerLinkTag('shortcut icon', 'image/vnd.microsoft.icon', $themeUrl . '/images/favicon.ico');
$cs->registerLinkTag('alternate', 'application/rss+xml', $this->createAbsoluteUrl('/feed/index'), null, ['title' => Yii::app()->name]);

$description = $this->getMetaDescription();
$keywords = $this->getMetaKeywords();
if (!empty($description)) {
    $cs->registerMetaTag($description, 'description');
}
if (!empty($keywords)) {
    $cs->registerMetaTag($keywords, 'keywords');
}

$index_page = $this->id == 'gtu' && $this->action->id == 'index';
/*if ($index_page) {
    $this->bodyClasses[] = 'index-page';
}*/
$supertop = !empty($this->topImage) && !empty($this->topTitle);

$cs->registerCssFile('https://fonts.googleapis.com/css?family=PT+Serif:400,400i,700,700i|Roboto+Condensed:400,400i,700,700i&subset=cyrillic&display=swap');
$cs->registerCssFile('https://fonts.googleapis.com/css2?family=Spectral:wght@500;700&display=swap');
$cs->registerCssFile(Common::assetsTime($themeUrl . '/css/vendor.css'));
if ($this->isViewPage) {
    $cs->registerCssFile(Common::assetsTime($themeUrl . '/css/new_post_template_gtu.css'));
    $cs->registerCssFile(Common::assetsTime($themeUrl . '/css/gtu_fonts.css'));
}
$cs->registerCssFile(Common::assetsTime($themeUrl . '/css/main_gtu_new_post.css'));
$cs->registerCssFile(Common::assetsTime($themeUrl . '/css/custom.css'));

$cs->registerScriptFile(Common::assetsTime($themeUrl . '/js/modernizr-custom.js'));
$cs->registerScriptFile(Common::assetsTime($themeUrl . '/js/imagesloaded.pkgd.min.js'));
$cs->registerScriptFile(Common::assetsTime($themeUrl . '/js/slick.min.js'));
$cs->registerScriptFile(Common::assetsTime($themeUrl . '/js/fastclick.min.js'));
$cs->registerScriptFile(Common::assetsTime($themeUrl . '/js/main_gtu.js'));

if ($this->interactive) {
    $cs->registerCssFile(Common::assetsTime($themeUrl . '/css/interactive.css'));
    $cs->registerScriptFile(Common::assetsTime($themeUrl . '/js/simple-share.min.js'));
    $cs->registerScriptFile(Common::assetsTime($themeUrl . '/js/interactive.js'));
}
if ($this->interactiveTest) {
    $cs->registerCssFile(Common::assetsTime($themeUrl . '/css/test.css'));
    $cs->registerScriptFile(Common::assetsTime($themeUrl . '/js/test.js'));
}

// page style
if (!empty($this->style['style'])) {
    $this->htmlClasses[] = 'branding-page';
    if (!empty($this->style['style_mobile'])) {
        $cs->registerCss('body_bkg', '@media (min-width:1025px) { .branding-page body{height:auto;' . $this->style['style'] . '} }');
        $cs->registerCss('body_bkg_mobile', '@media (max-width:1024px) { .branding-page body{height:auto;' . $this->style['style_mobile'] . '} }');
    } else {
        $cs->registerCss('body_bkg', '.branding-page body{height:auto;' . $this->style['style'] . '}');
    }
    $this->hideTopBanner = true;
}
if (!empty($this->style['url'])) {
    $cs->registerCss('body_bkg_cursor', 'body{cursor:pointer}body div,body footer,body header{cursor:auto}');
    $js = "$('body').on('click', function(e) { if (e.target != this) return; window.open('" . $this->style['url'] . "', '_blank'); });";
    $cs->registerScript('body_bkg_link', $js);
}

$app_lang = Yii::app()->language;

$gtu_telegram = BlocksHelper::get('gtu_telegram');
$gtu_instagram = BlocksHelper::get('gtu_instagram');

if (!empty($this->topImage) && !empty($this->topTitle)) {
    $this->allClasses[] = 'super-top';
}
?>
<!DOCTYPE html>
<html lang="<?= $app_lang ?>"<?php if (!empty($this->htmlClasses)): ?> class="<?= implode(' ', $this->htmlClasses) ?>"<?php endif; ?>>
<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb#">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= BlocksHelper::get('head_code') ?>
    <title><?= CHtml::encode($this->getPageTitle()) ?></title>
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="@34travelby">
    <meta name="twitter:title" content="<?= CHtml::encode($this->getPageTitle()) ?>">
    <meta name="twitter:description" content="<?= CHtml::encode($this->getMetaDescription()) ?>">
    <meta name="twitter:image" content="<?= $this->getPageOgImage() ?>">
    <meta property="og:image" content="<?= $this->getPageOgImage() ?>">
    <meta property="og:title" content="<?= CHtml::encode($this->getPageTitle()) ?>">
    <meta property="og:url" content="<?= $this->getUrl() ?>">
    <meta property="og:description" content="<?= CHtml::encode($this->getMetaDescription()) ?>">
    <meta property="fb:app_id" content="386369345035266">
    <meta name="verify-admitad" content="ad41f139f6">
    <script charset="UTF-8" src="//cdn.sendpulse.com/28edd3380a1c17cf65b137fe96516659/js/push/877b86dcdb36f7b75b8bae581a8fb9f2_1.js" async></script>
    <?php
    if (isset($this->bannerSystems[Banner::SYSTEM_ADFOX])) {
        $this->renderPartial('/layouts/_adfox');
    }
    ?>
</head>
<body<?php if (!empty($this->bodyClasses)): ?> class="<?= implode(' ', $this->bodyClasses) ?>"<?php endif; ?>>

<?php /*if ($this->relapCode): ?>
    <?= CHtml::value(Yii::app()->params, 'relap-body-code') ?>
<?php endif;*/ ?>

<div id="wrapper"<?php if ($supertop): ?> class="super-top"<?php endif; ?>>

    <?php
    if (!$supertop && !$this->hideTopBanner) {
        $banner = null;
        if ($index_page) {
            $banner = GtuBanner::getByPlace(GtuBanner::PLACE_GTU_HOME_TOP);
        } else {
            $banner = GtuBanner::getByPlace(GtuBanner::PLACE_GTU_TOP_ALL);
        }
        if (!empty($banner) && !empty($banner->url) && !empty($banner->image)) {
            ?>
            <div class="top-banner">
                <a href="<?= $banner->url ?>"<?php if ($banner->open_new_tab == 1): ?> target="_blank"<?php endif; ?>>
                    <img src="<?= $banner->getImageUrl('image') ?>" alt="">
                </a>
            </div>
            <?php
        }
    }
    ?>

    <div id="all"<?php if (!empty($this->allClasses)): ?> class="<?= implode(' ', $this->allClasses) ?>"<?php endif; ?>>

        <header>
            <div class="container clearfix">
                <div class="left-side">
                    <div class="slogan">
                        <?= BlocksHelper::get('gtu_slogan' . ($app_lang != 'uk' ? '_' . $app_lang : '')) ?>
                    </div>
                    <div class="lang">
                        <?php $this->widget('application.widgets.GtuLangSelector'); ?>
                    </div>
                    <ul class="social">
                        <?php if ($gtu_telegram): ?>
                            <li>
                                <a href="<?= CHtml::encode($gtu_telegram) ?>" class="icon-telegram" target="_blank">
                                    <svg width="23" height="20" viewBox="0 0 23 20" fill="none">
                                        <path d="M21.2973 0.00204778C21.0132 0.0220537 20.7344 0.0865647 20.4717 0.193064H20.4682C20.216 0.289857 19.0171 0.778105 17.1944 1.51819L10.6626 4.18128C5.97574 6.09145 1.36849 7.97249 1.36849 7.97249L1.42335 7.95193C1.42335 7.95193 1.1057 8.05301 0.773889 8.27314C0.568902 8.39942 0.392509 8.56465 0.255386 8.75882C0.0925789 8.9901 -0.0383742 9.34387 0.0102908 9.70962C0.0899245 10.3281 0.504019 10.699 0.801319 10.9037C1.10216 11.111 1.38884 11.2078 1.38884 11.2078H1.39592L5.71649 12.6168C5.91026 13.219 7.0331 16.7927 7.30297 17.6158C7.46223 18.1075 7.61708 18.415 7.81085 18.6497C7.90464 18.7696 8.01436 18.8698 8.1462 18.9504C8.21474 18.989 8.28782 19.0194 8.36386 19.0412L8.31962 19.0309C8.33289 19.0343 8.34351 19.0446 8.35325 19.048C8.38864 19.0574 8.41253 19.0609 8.45765 19.0677C9.14162 19.2682 9.69109 18.857 9.69109 18.857L9.72206 18.833L12.273 16.5845L16.5484 19.7598L16.6458 19.8001C17.5368 20.1787 18.4393 19.968 18.9162 19.5962C19.3967 19.2219 19.5834 18.7431 19.5834 18.7431L19.6143 18.666L22.9182 2.28054C23.012 1.87624 23.0359 1.49763 22.9324 1.13016C22.8256 0.758255 22.5792 0.438394 22.2414 0.233323C21.9577 0.0663893 21.6288 -0.0141856 21.2973 0.00204778ZM21.2079 1.75803C21.2044 1.81199 21.215 1.806 21.1902 1.90964V1.91906L17.9173 18.134C17.9031 18.1572 17.8792 18.2077 17.8137 18.2583C17.7447 18.3114 17.6899 18.3448 17.4023 18.2343L12.173 14.3531L9.0142 17.1404L9.67782 13.0374L18.2216 5.32824C18.5738 5.0113 18.4561 4.94449 18.4561 4.94449C18.4809 4.5556 17.9243 4.83057 17.9243 4.83057L7.15078 11.2917L7.14724 11.2746L1.98344 9.59142V9.58799L1.97016 9.58542C1.97922 9.58251 1.98808 9.57908 1.99671 9.57514L2.02502 9.56143L2.05245 9.55201C2.05245 9.55201 6.66324 7.67097 11.3501 5.76081C13.6967 4.80401 16.0609 3.84036 17.8792 3.09686C19.6975 2.35763 21.0415 1.81542 21.1176 1.7863C21.1902 1.75888 21.1557 1.75803 21.2079 1.75803Z" fill="black"/>
                                    </svg>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ($gtu_instagram): ?>
                            <li>
                                <a href="<?= CHtml::encode($gtu_instagram) ?>" class="icon-instagram" target="_blank">
                                    <svg width="21" height="21" viewBox="0 0 21 21" fill="none">
                                        <path d="M10.5 1.89263C13.3035 1.89263 13.636 1.90313 14.7438 1.95388C17.5893 2.08337 18.9184 3.4335 19.0479 6.258C19.0986 7.36487 19.1082 7.69738 19.1082 10.5009C19.1082 13.3053 19.0977 13.6369 19.0479 14.7438C18.9175 17.5656 17.5919 18.9184 14.7438 19.0479C13.636 19.0986 13.3053 19.1091 10.5 19.1091C7.6965 19.1091 7.364 19.0986 6.25712 19.0479C3.40462 18.9175 2.0825 17.5613 1.953 14.7429C1.90225 13.636 1.89175 13.3044 1.89175 10.5C1.89175 7.6965 1.90313 7.36487 1.953 6.25712C2.08338 3.4335 3.409 2.0825 6.25712 1.953C7.36487 1.90313 7.6965 1.89263 10.5 1.89263ZM10.5 0C7.64838 0 7.29138 0.01225 6.17137 0.063C2.35813 0.238 0.238875 2.35375 0.063875 6.1705C0.01225 7.29138 0 7.64838 0 10.5C0 13.3516 0.01225 13.7095 0.063 14.8295C0.238 18.6427 2.35375 20.762 6.1705 20.937C7.29138 20.9877 7.64838 21 10.5 21C13.3516 21 13.7095 20.9877 14.8295 20.937C18.6392 20.762 20.7638 18.6462 20.9361 14.8295C20.9877 13.7095 21 13.3516 21 10.5C21 7.64838 20.9877 7.29138 20.937 6.17137C20.7655 2.36162 18.6471 0.238875 14.8304 0.063875C13.7095 0.01225 13.3516 0 10.5 0V0ZM10.5 5.10825C7.52238 5.10825 5.10825 7.52238 5.10825 10.5C5.10825 13.4776 7.52238 15.8926 10.5 15.8926C13.4776 15.8926 15.8918 13.4785 15.8918 10.5C15.8918 7.52238 13.4776 5.10825 10.5 5.10825ZM10.5 14C8.56713 14 7 12.4338 7 10.5C7 8.56713 8.56713 7 10.5 7C12.4329 7 14 8.56713 14 10.5C14 12.4338 12.4329 14 10.5 14ZM16.1052 3.63563C15.4088 3.63563 14.8444 4.2 14.8444 4.89562C14.8444 5.59125 15.4088 6.15562 16.1052 6.15562C16.8009 6.15562 17.3644 5.59125 17.3644 4.89562C17.3644 4.2 16.8009 3.63563 16.1052 3.63563Z" fill="black"/>
                                    </svg>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                    <div class="js-open-nav">
                        <span class="open">
                            <svg width="23" height="14" viewBox="0 0 23 14" fill="none">
                                <path d="M0 1H16" stroke="black" stroke-width="2"/>
                                <path d="M0 7H23" stroke="black" stroke-width="2"/>
                                <path d="M0 13H12" stroke="black" stroke-width="2"/>
                            </svg>
                        </span>
                    </div>
                </div>
                <?php if ($index_page): ?>
                    <div class="logo">
                        <span>GO TO</span> <br>
                        <span>UKRAINE!</span>
                    </div>
                <?php else: ?>
                    <a href="<?= $this->createUrl('/gtu/index') ?>" class="logo">
                        <span>GO TO</span> <br>
                        <span>UKRAINE!</span>
                    </a>
                <?php endif; ?>
                <div class="mob-slogan">
                    <?= BlocksHelper::get('gtu_slogan' . ($app_lang != 'uk' ? '_' . $app_lang : '')) ?>
                </div>
                <div class="right-side">
                    <?php //= BlocksHelper::get('gtu_promo_link' . ($supertop ? '_supertop' : '') . ($app_lang != 'uk' ? '_' . $app_lang : '')) ?>
                    <ul class="social">
                        <?php if ($gtu_telegram): ?>
                            <li>
                                <a href="<?= CHtml::encode($gtu_telegram) ?>" class="icon-telegram" target="_blank">
                                    <svg width="23" height="20" viewBox="0 0 23 20" fill="none">
                                        <path d="M21.2973 0.00204778C21.0132 0.0220537 20.7344 0.0865647 20.4717 0.193064H20.4682C20.216 0.289857 19.0171 0.778105 17.1944 1.51819L10.6626 4.18128C5.97574 6.09145 1.36849 7.97249 1.36849 7.97249L1.42335 7.95193C1.42335 7.95193 1.1057 8.05301 0.773889 8.27314C0.568902 8.39942 0.392509 8.56465 0.255386 8.75882C0.0925789 8.9901 -0.0383742 9.34387 0.0102908 9.70962C0.0899245 10.3281 0.504019 10.699 0.801319 10.9037C1.10216 11.111 1.38884 11.2078 1.38884 11.2078H1.39592L5.71649 12.6168C5.91026 13.219 7.0331 16.7927 7.30297 17.6158C7.46223 18.1075 7.61708 18.415 7.81085 18.6497C7.90464 18.7696 8.01436 18.8698 8.1462 18.9504C8.21474 18.989 8.28782 19.0194 8.36386 19.0412L8.31962 19.0309C8.33289 19.0343 8.34351 19.0446 8.35325 19.048C8.38864 19.0574 8.41253 19.0609 8.45765 19.0677C9.14162 19.2682 9.69109 18.857 9.69109 18.857L9.72206 18.833L12.273 16.5845L16.5484 19.7598L16.6458 19.8001C17.5368 20.1787 18.4393 19.968 18.9162 19.5962C19.3967 19.2219 19.5834 18.7431 19.5834 18.7431L19.6143 18.666L22.9182 2.28054C23.012 1.87624 23.0359 1.49763 22.9324 1.13016C22.8256 0.758255 22.5792 0.438394 22.2414 0.233323C21.9577 0.0663893 21.6288 -0.0141856 21.2973 0.00204778ZM21.2079 1.75803C21.2044 1.81199 21.215 1.806 21.1902 1.90964V1.91906L17.9173 18.134C17.9031 18.1572 17.8792 18.2077 17.8137 18.2583C17.7447 18.3114 17.6899 18.3448 17.4023 18.2343L12.173 14.3531L9.0142 17.1404L9.67782 13.0374L18.2216 5.32824C18.5738 5.0113 18.4561 4.94449 18.4561 4.94449C18.4809 4.5556 17.9243 4.83057 17.9243 4.83057L7.15078 11.2917L7.14724 11.2746L1.98344 9.59142V9.58799L1.97016 9.58542C1.97922 9.58251 1.98808 9.57908 1.99671 9.57514L2.02502 9.56143L2.05245 9.55201C2.05245 9.55201 6.66324 7.67097 11.3501 5.76081C13.6967 4.80401 16.0609 3.84036 17.8792 3.09686C19.6975 2.35763 21.0415 1.81542 21.1176 1.7863C21.1902 1.75888 21.1557 1.75803 21.2079 1.75803Z" fill="black"/>
                                    </svg>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ($gtu_instagram): ?>
                            <li>
                                <a href="<?= CHtml::encode($gtu_instagram) ?>" class="icon-instagram" target="_blank">
                                    <svg width="21" height="21" viewBox="0 0 21 21" fill="none">
                                        <path d="M10.5 1.89263C13.3035 1.89263 13.636 1.90313 14.7438 1.95388C17.5893 2.08337 18.9184 3.4335 19.0479 6.258C19.0986 7.36487 19.1082 7.69738 19.1082 10.5009C19.1082 13.3053 19.0977 13.6369 19.0479 14.7438C18.9175 17.5656 17.5919 18.9184 14.7438 19.0479C13.636 19.0986 13.3053 19.1091 10.5 19.1091C7.6965 19.1091 7.364 19.0986 6.25712 19.0479C3.40462 18.9175 2.0825 17.5613 1.953 14.7429C1.90225 13.636 1.89175 13.3044 1.89175 10.5C1.89175 7.6965 1.90313 7.36487 1.953 6.25712C2.08338 3.4335 3.409 2.0825 6.25712 1.953C7.36487 1.90313 7.6965 1.89263 10.5 1.89263ZM10.5 0C7.64838 0 7.29138 0.01225 6.17137 0.063C2.35813 0.238 0.238875 2.35375 0.063875 6.1705C0.01225 7.29138 0 7.64838 0 10.5C0 13.3516 0.01225 13.7095 0.063 14.8295C0.238 18.6427 2.35375 20.762 6.1705 20.937C7.29138 20.9877 7.64838 21 10.5 21C13.3516 21 13.7095 20.9877 14.8295 20.937C18.6392 20.762 20.7638 18.6462 20.9361 14.8295C20.9877 13.7095 21 13.3516 21 10.5C21 7.64838 20.9877 7.29138 20.937 6.17137C20.7655 2.36162 18.6471 0.238875 14.8304 0.063875C13.7095 0.01225 13.3516 0 10.5 0V0ZM10.5 5.10825C7.52238 5.10825 5.10825 7.52238 5.10825 10.5C5.10825 13.4776 7.52238 15.8926 10.5 15.8926C13.4776 15.8926 15.8918 13.4785 15.8918 10.5C15.8918 7.52238 13.4776 5.10825 10.5 5.10825ZM10.5 14C8.56713 14 7 12.4338 7 10.5C7 8.56713 8.56713 7 10.5 7C12.4329 7 14 8.56713 14 10.5C14 12.4338 12.4329 14 10.5 14ZM16.1052 3.63563C15.4088 3.63563 14.8444 4.2 14.8444 4.89562C14.8444 5.59125 15.4088 6.15562 16.1052 6.15562C16.8009 6.15562 17.3644 5.59125 17.3644 4.89562C17.3644 4.2 16.8009 3.63563 16.1052 3.63563Z" fill="black"/>
                                    </svg>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                    <div class="search-box">
                        <button type="button" class="open-search"></button>
                    </div>
                    <a href="/" class="link-34travel"></a>
                    <div class="header-search-box">
                        <p class="logo">
                            <span>GO TO</span> <br>
                            <span>UKRAINE!</span>
                        </p>
                        <span class="js-close-search">
                            <svg width="18" height="19" viewBox="0 0 18 19" fill="none">
                                <path d="M1 17.2635L17.2635 1" stroke="black" stroke-width="2"/>
                                <path d="M17.2635 17.5269L1 1.26343" stroke="black" stroke-width="2"/>
                            </svg>
                        </span>
                        <form action="<?= $this->createUrl('/search/results') ?>" method="get" class="search-form">
                            <div class="form-wrap">
                                <input type="text" name="text" placeholder="<?= Yii::t('app', 'Search') ?>" required>
                            </div>
                            <button type="submit">
                                <span class="icon">
                                    <svg width="24" height="23" viewBox="0 0 24 23" fill="none">
                                        <circle cx="9" cy="9" r="7" stroke="white" stroke-width="3"/>
                                        <path d="M13.2545 13L21.9954 21.2823" stroke="white" stroke-width="4"/>
                                    </svg>
                                </span>
                                <span><?= Yii::t('app', 'SEARCH') ?></span>
                            </button>
                        </form>
                    </div>
                </div>
                <div class="nav-box">
                    <div class="js-close-nav">
                        <span class="close">
                            <svg width="18" height="19" viewBox="0 0 18 19" fill="none">
                                <path d="M1 17.2635L17.2635 1" stroke="black" stroke-width="2"></path>
                                <path d="M17.2635 17.5269L1 1.26343" stroke="black" stroke-width="2"></path>
                            </svg>
                        </span>
                    </div>
                    <p class="logo">
                        <span>GO TO</span> <br>
                        <span>Ukraine!</span>
                    </p>
                    <?php $this->widget('application.widgets.GtuLangSelector', ['ulClass' => 'langs-links']); ?>
                    <nav>
                        <?php $this->widget('application.widgets.GtuRubricsMenu'); ?>
                    </nav>
                    <div class="nav-box-links">
                        <a href="<?= $this->createUrl('/gtu/index') ?>" class="logo-link">
                            <img src="<?= $themeUrl ?>/images/34travel-logo-black.png" alt="">
                        </a>
                        <div class="social-links">
                            <?php if ($gtu_telegram): ?>
                                <a href="<?= CHtml::encode($gtu_telegram) ?>" target="_blank">
                                    <svg width="28" height="25" viewBox="0 0 28 25" fill="none">
                                        <path d="M25.9271 0.00255973C25.5813 0.0275672 25.2419 0.108206 24.9221 0.24133H24.9178C24.6108 0.362321 23.1512 0.972632 20.9323 1.89773L12.9806 5.2266C7.27481 7.61431 1.66598 9.96561 1.66598 9.96561L1.73277 9.93991C1.73277 9.93991 1.34607 10.0663 0.942126 10.3414C0.692576 10.4993 0.477837 10.7058 0.310904 10.9485C0.112705 11.2376 -0.0467164 11.6798 0.012528 12.137C0.109473 12.9101 0.613589 13.3737 0.975518 13.6296C1.34176 13.8887 1.69076 14.0097 1.69076 14.0097H1.69938L6.9592 15.7711C7.1951 16.5238 8.56203 20.9908 8.89057 22.0198C9.08446 22.6344 9.27296 23.0188 9.50886 23.3121C9.62304 23.462 9.75661 23.5873 9.91711 23.688C10.0005 23.7362 10.0895 23.7743 10.1821 23.8015L10.1282 23.7886C10.1444 23.7929 10.1573 23.8057 10.1692 23.81C10.2123 23.8218 10.2413 23.8261 10.2963 23.8346C11.1289 24.0852 11.7979 23.5712 11.7979 23.5712L11.8356 23.5413L14.941 20.7306L20.1459 24.6998L20.2644 24.7501C21.3491 25.2234 22.4478 24.96 23.0284 24.4953C23.6133 24.0274 23.8406 23.4288 23.8406 23.4288L23.8783 23.3325L27.9005 2.85067C28.0147 2.34529 28.0437 1.87204 27.9177 1.4127C27.7877 0.947818 27.4877 0.547992 27.0764 0.291654C26.7311 0.0829867 26.3307 -0.017732 25.9271 0.00255973ZM25.8183 2.19754C25.814 2.26499 25.8269 2.2575 25.7968 2.38705V2.39883L21.8123 22.6676C21.7951 22.6965 21.766 22.7596 21.6863 22.8228C21.6023 22.8892 21.5355 22.931 21.1854 22.7928L14.8193 17.9414L10.9738 21.4255L11.7817 16.2968L22.1829 6.6603C22.6116 6.26413 22.4683 6.18061 22.4683 6.18061C22.4985 5.69451 21.8209 6.03821 21.8209 6.03821L8.70529 14.1146L8.70099 14.0932L2.41462 11.9893V11.985L2.39846 11.9818C2.40948 11.9781 2.42027 11.9738 2.43078 11.9689L2.46525 11.9518L2.49864 11.94C2.49864 11.94 8.11177 9.58871 13.8175 7.20101C16.6742 6.00501 19.5524 4.80046 21.766 3.87107C23.9796 2.94704 25.6158 2.26927 25.7084 2.23287C25.7968 2.19861 25.7548 2.19754 25.8183 2.19754Z" fill="black"/>
                                    </svg>
                                </a>
                            <?php endif; ?>
                            <?php if ($gtu_instagram): ?>
                                <a href="<?= CHtml::encode($gtu_instagram) ?>" target="_blank">
                                    <svg width="26" height="27" viewBox="0 0 26 27" fill="none">
                                        <path d="M13 2.43338C16.471 2.43338 16.8827 2.44688 18.2542 2.51213C21.7772 2.67863 23.4228 4.4145 23.5831 8.046C23.6459 9.46912 23.6578 9.89663 23.6578 13.5011C23.6578 17.1068 23.6448 17.5331 23.5831 18.9563C23.4217 22.5844 21.7804 24.3236 18.2542 24.4901C16.8827 24.5554 16.4732 24.5689 13 24.5689C9.529 24.5689 9.11733 24.5554 7.74692 24.4901C4.21525 24.3225 2.57833 22.5788 2.418 18.9551C2.35517 17.532 2.34217 17.1056 2.34217 13.5C2.34217 9.8955 2.35625 9.46912 2.418 8.04488C2.57942 4.4145 4.22067 2.6775 7.74692 2.511C9.11842 2.44688 9.529 2.43338 13 2.43338ZM13 0C9.46942 0 9.02742 0.01575 7.64075 0.081C2.91958 0.306 0.29575 3.02625 0.0790833 7.9335C0.0151667 9.37463 0 9.83362 0 13.5C0 17.1664 0.0151667 17.6265 0.078 19.0665C0.294667 23.9692 2.91417 26.694 7.63967 26.919C9.02742 26.9842 9.46942 27 13 27C16.5306 27 16.9737 26.9842 18.3603 26.919C23.0772 26.694 25.7075 23.9737 25.9209 19.0665C25.9848 17.6265 26 17.1664 26 13.5C26 9.83362 25.9848 9.37463 25.922 7.93463C25.7097 3.03637 23.0869 0.307125 18.3614 0.082125C16.9737 0.01575 16.5306 0 13 0V0ZM13 6.56775C9.31342 6.56775 6.3245 9.67163 6.3245 13.5C6.3245 17.3284 9.31342 20.4334 13 20.4334C16.6866 20.4334 19.6755 17.3295 19.6755 13.5C19.6755 9.67163 16.6866 6.56775 13 6.56775ZM13 18C10.6069 18 8.66667 15.9862 8.66667 13.5C8.66667 11.0149 10.6069 9 13 9C15.3931 9 17.3333 11.0149 17.3333 13.5C17.3333 15.9862 15.3931 18 13 18ZM19.9398 4.67438C19.0775 4.67438 18.3788 5.4 18.3788 6.29437C18.3788 7.18875 19.0775 7.91437 19.9398 7.91437C20.8011 7.91437 21.4988 7.18875 21.4988 6.29437C21.4988 5.4 20.8011 4.67438 19.9398 4.67438Z" fill="black"/>
                                    </svg>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <main>
            <?php if (!empty($this->topImage) && !empty($this->topTitle)): ?>
                <div class="f-width-box super-post full-height">
                    <div class="super-post-wrap" style="background-image: url('<?= CHtml::encode($this->topImage) ?>')">
                        <div class="post-descr">
                            <h2 class="post-title"><?= $this->topTitle ?></h2>
                            <a href="<?= $this->topLink ?>" class="go-article"></a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <?= $content ?>

        </main>
    </div>


    <?php
    if ($this->relatedPosts) {
        $this->renderPartial('_related', ['relatedPosts' => $this->relatedPosts]);
    }
    ?>

    <?php
    if ($this->additionalPosts && !empty($this->additionalPosts['posts'])) {
        ?>
        <div class="articles-box">
            <?php $this->renderPartial('_additional_posts', $this->additionalPosts); ?>
        </div>
        <?php
    }
    ?>

    <div id="indent"></div>
</div>

<footer id="footer">
    <div class="container">
        <a href="" class="logo">

        </a>
        <div class="footer-content">
            <ul class="footer-nav footer-list">
                <?= BlocksHelper::get('gtu_footer_pages' . ($app_lang != 'uk' ? '_' . $app_lang : '')) ?>
            </ul>
            <ul class="social-links footer-list">
                <li>
                    <p class="title">
                        <svg width="22" height="21" viewBox="0 0 22 21" fill="none">
                            <path d="M21.8873 7.95257C21.6722 7.25917 21.2421 6.70449 20.5969 6.3809C19.7844 5.96485 18.8285 6.01106 18.1594 6.12663L16.7494 1.36522C16.6538 1.04163 16.391 0.787429 16.0564 0.718089C15.7219 0.648748 15.3634 0.741247 15.1244 0.995496C11.7071 4.69366 10.2972 5.59504 6.52147 7.18987L3.55822 8.02198C0.953435 8.76161 -0.552077 11.4197 0.188733 13.9391C0.54719 15.1641 1.38358 16.2042 2.55454 16.8282C3.29535 17.2212 4.10786 17.4291 4.92036 17.4291C5.30271 17.4291 5.70897 17.383 6.09132 17.2905L6.40198 18.3768C6.56926 18.9546 6.90382 19.4631 7.33396 19.8792L7.83581 20.3414C8.02699 20.5032 8.26596 20.5957 8.50493 20.5957C8.7678 20.5957 9.00677 20.5032 9.19795 20.3183C9.55641 19.9485 9.55641 19.3707 9.15015 19.0009L8.64831 18.5386C8.45713 18.3537 8.31376 18.1226 8.24207 17.8684L7.93139 16.782L9.31744 16.389C13.2844 15.8112 15.0766 15.8574 19.9277 17.198C20.0233 17.2211 20.095 17.2442 20.1906 17.2442C20.4296 17.2442 20.6925 17.1517 20.8597 16.9668C21.0987 16.7357 21.1943 16.389 21.0987 16.0654L19.6888 11.3272C20.3101 11.096 21.1465 10.68 21.6245 9.91722C22.0068 9.33938 22.1024 8.66909 21.8873 7.95257ZM3.51042 15.2333C2.79351 14.8635 2.29168 14.2164 2.05271 13.4768C1.59866 11.9051 2.53064 10.2871 4.10785 9.82479L6.25859 9.22381L7.23838 12.5753L7.9075 14.8866L5.75676 15.4876C5.01595 15.6956 4.20344 15.6031 3.51042 15.2333ZM13.2366 14.2164C12.1612 14.2164 11.0858 14.3088 9.81927 14.4706L8.43324 9.73236L8.09867 8.57668C11.1575 7.2361 12.7825 6.19597 15.4351 3.46857L18.8285 15.0022C16.5344 14.4475 14.9094 14.2164 13.2366 14.2164ZM20.0233 8.96966C19.88 9.2239 19.5215 9.40881 19.1869 9.54749L18.709 7.92955C19.0675 7.88332 19.4737 7.8833 19.7366 8.02198C19.8561 8.09132 19.9756 8.18373 20.0711 8.43798C20.1428 8.71534 20.0711 8.85409 20.0233 8.96966ZM13.9774 7.44414C14.2402 7.81396 14.1685 8.32243 13.7862 8.57668C12.902 9.17763 11.8983 9.70924 11.8505 9.73236C11.731 9.8017 11.5877 9.82479 11.4682 9.82479C11.1575 9.82479 10.8707 9.66302 10.7274 9.38565C10.5123 8.99272 10.6796 8.50729 11.0858 8.29927C11.0858 8.29927 12.0417 7.81391 12.8064 7.2823C13.1649 6.98183 13.6906 7.07433 13.9774 7.44414Z" fill="black"/>
                        </svg>
                        <?= Yii::t('app', 'Social') ?> 34travel
                    </p>
                </li>
                <?= BlocksHelper::get('gtu_social') ?>
            </ul>
            <ul class="footer-sub-links footer-list">
                <li>
                    <p class="title">
                        <svg width="20" height="23" viewBox="0 0 20 23" fill="none">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M11.3982 0.809041C11.8054 0.980007 12.0473 1.39015 11.9923 1.81619L11.1328 8.46641H19C19.388 8.46641 19.741 8.6835 19.9056 9.02335C20.0702 9.3632 20.0166 9.76445 19.7682 10.0527L9.76822 21.6588C9.48403 21.9886 9.00902 22.0978 8.60181 21.9268C8.19459 21.7558 7.95266 21.3457 8.00772 20.9196L8.86722 14.2694H1.00001C0.611994 14.2694 0.259002 14.0523 0.0944227 13.7125C-0.0701569 13.3726 -0.0166119 12.9714 0.231791 12.6831L10.2318 1.07706C10.516 0.747223 10.991 0.638076 11.3982 0.809041ZM3.13505 12.3351H10C10.2868 12.3351 10.5599 12.4542 10.7497 12.6622C10.9395 12.8702 11.0279 13.1469 10.9923 13.4222L10.4153 17.8862L16.865 10.4008H10C9.71317 10.4008 9.44015 10.2816 9.25032 10.0737C9.0605 9.86569 8.97215 9.58889 9.00772 9.31362L9.58466 4.84964L3.13505 12.3351Z" fill="black"/>
                        </svg>
                        <?= Yii::t('app', 'Projects') ?>
                    </p>
                </li>
                <li>
                    <a href="/gotobelarus" target="_blank">
                        <span>GO TO BELARUS!</span>
                    </a>
                </li>
                <li>
                    <a href="https://34home.com.ua/" target="_blank">
                        <span>34 HOME</span>
                    </a>
                </li>
                <li>
                    <a href="https://34mag.net/" target="_blank">
                        <span>34 MAG.NET</span>
                    </a>
                </li>
                <li>
                    <a href="https://34mag.net/piarshak/" target="_blank">
                        <span>ПЯРШАК</span>
                    </a>
                </li>
                <li>
                    <a href="https://minsknotdead.com/" target="_blank">
                        <span>MINSK NOT DEAD</span>
                    </a>
                </li>
            </ul>
            <div class="footer-contacts">
                <p class="title">
                    <svg width="22" height="13" viewBox="0 0 22 13" fill="none">
                        <path d="M21.9043 1.4549C21.9043 1.43234 21.9043 1.38721 21.9043 1.36465C21.9043 1.3421 21.9043 1.31953 21.9043 1.29697C21.9043 1.27441 21.8804 1.25187 21.8804 1.20675C21.8804 1.1842 21.8565 1.13907 21.8565 1.11651C21.8565 1.09395 21.8326 1.07138 21.8087 1.04883C21.7848 1.02627 21.7848 0.981144 21.7608 0.958586V0.936032C21.7369 0.913474 21.7369 0.913485 21.713 0.890926C21.6891 0.868367 21.6652 0.845797 21.6413 0.823238C21.6174 0.80068 21.5935 0.778132 21.5696 0.778132C21.5457 0.755573 21.5218 0.732998 21.4978 0.732998C21.4739 0.710439 21.45 0.71045 21.4261 0.687891C21.4022 0.665333 21.3782 0.665344 21.3543 0.642785C21.3304 0.642785 21.2826 0.620204 21.2587 0.620204C21.2348 0.620204 21.2108 0.597651 21.163 0.597651C21.1391 0.597651 21.0913 0.597651 21.0674 0.597651C21.0435 0.597651 21.0196 0.597651 20.9956 0.597651H0.908684C0.884771 0.597651 0.860875 0.597651 0.836962 0.597651C0.813049 0.597651 0.765217 0.597651 0.741304 0.597651C0.717391 0.597651 0.693472 0.620204 0.645646 0.620204C0.621733 0.620204 0.573901 0.642785 0.549988 0.642785C0.526075 0.642785 0.50218 0.665333 0.478267 0.687891C0.454354 0.71045 0.430429 0.710439 0.406516 0.732998C0.382603 0.755557 0.358707 0.755573 0.334794 0.778132C0.310881 0.800691 0.286957 0.823238 0.263043 0.823238C0.23913 0.845797 0.215206 0.868367 0.191293 0.890926C0.16738 0.913485 0.167391 0.913474 0.143478 0.936032V0.958586C0.119565 0.981144 0.0956639 1.02627 0.0956639 1.04883C0.0717508 1.07138 0.0717333 1.09395 0.0478202 1.11651C0.0239072 1.13907 0.023913 1.16164 0.023913 1.20675C0.023913 1.22931 5.83815e-06 1.25185 5.83815e-06 1.29697C5.83815e-06 1.31953 5.83815e-06 1.3421 5.83815e-06 1.36465C5.83815e-06 1.38721 5.83815e-06 1.43234 5.83815e-06 1.4549V1.47745V11.8545C5.83815e-06 12.3508 0.430441 12.7568 0.956528 12.7568H21.0435C21.5695 12.7568 22 12.3508 22 11.8545L21.9043 1.4549C21.9043 1.47745 21.9043 1.4549 21.9043 1.4549ZM18.0543 2.3798L10.9043 7.38784L3.75434 2.3798H18.0543ZM1.81739 10.9521V3.28215L10.3304 9.23767C10.4978 9.35047 10.6891 9.41813 10.9043 9.41813C11.1196 9.41813 11.3109 9.35047 11.4783 9.23767L19.9913 3.28215V10.9521H1.81739Z" fill="black"/>
                    </svg>
                    <?= Yii::t('app', 'Contact an Editor') ?>
                </p>
                <?= BlocksHelper::get('gtu_footer_contacts') ?>
            </div>
            <div class="reprint-rules">
                <?= BlocksHelper::get('gtu_footer_text' . ($app_lang != 'uk' ? '_' . $app_lang : '')) ?>
            </div>
        </div>
    </div>
</footer>

<?php if ($this->isViewPage): ?>
    <span class="goUp mnd-goUp" title="Up">
        <svg viewBox="0 0 23 34" width="23" height="34"><polygon fill-rule="evenodd" fill="#4d585b" points="11.5 0 0 11.8 0 18.48 9.2 9.04 9.2 34 13.79 34 13.79 9.04 22.99 18.48 22.99 11.8 11.5 0"></polygon></svg>
    </span>
<?php endif; ?>

<?= BlocksHelper::get('footer_code') ?>

</body>
</html>
