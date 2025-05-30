<?php
/* @var $this FrontEndController */
/* @var $content string */

$themeUrl = Yii::app()->theme->baseUrl;
$route = Yii::app()->controller->getRoute();

/** @var CClientScript $cs */
$cs = Yii::app()->clientScript;
$cs->registerPackage('jquery');

$cs->registerLinkTag('shortcut icon', 'image/vnd.microsoft.icon', $themeUrl . '/images/favicon.ico');


$cs->registerLinkTag('alternate', 'application/rss+xml', $this->createAbsoluteUrl('/feed/index'), null, array('title' => Yii::app()->name));

$description = $this->getMetaDescription();
$keywords = $this->getMetaKeywords();
if (!empty($description)) {
    $cs->registerMetaTag($description, 'description');
}
if (!empty($keywords)) {
    $cs->registerMetaTag($keywords, 'keywords');
}

$index_page = $this->id == 'site' && $this->action->id == 'main';
if ($index_page) {
    $this->bodyClasses[] = 'index-page';
}

$has_style = (!empty($this->bodyClasses) && in_array('boxed', $this->bodyClasses));

$cs->registerCssFile(Common::assetsTime($themeUrl . '/css/ulej-tips-styles.css'));
$cs->registerCssFile('https://fonts.googleapis.com/css?family=PT+Serif:400,400i,700,700i|Roboto+Condensed:400,400i,700,700i&amp;amp;subset=cyrillic&amp;amp;display=swap');
$cs->registerCssFile('https://fonts.googleapis.com/css2?family=Spectral:wght@500;700&amp;amp;display=swap');
$cs->registerCssFile(Common::assetsTime($themeUrl . '/css/fonts.css'));
$cs->registerCssFile(Common::assetsTime($themeUrl . '/css/vendor.css'));
$cs->registerCssFile(Common::assetsTime($themeUrl . '/css/style.css'));
$cs->registerCssFile(Common::assetsTime($themeUrl . '/css/select2.css'));
$cs->registerCssFile(Common::assetsTime($themeUrl . '/css/main.css'));
$cs->registerCssFile(Common::assetsTime($themeUrl . '/css/slick.css'));
if ($this->isNewStyledPost) {
    $cs->registerCssFile(Common::assetsTime($themeUrl . '/css/new_post_template.css'));
}

if ($this->bodyClasses[0] != 'index-page') {
//    $cs->registerCssFile(Common::assetsTime($themeUrl . '/css/1.css'));
}

$cs->registerCssFile(Common::assetsTime($themeUrl . '/css/custom.css'));
$cs->registerCssFile(Common::assetsTime($themeUrl . '/css/jquery-ui.css'));

$cs->registerCssFile(Common::assetsTime($themeUrl . '/css/post.css'));

$cs->registerCssFile(Common::assetsTime($themeUrl . '/css/all_custom.css'));
$cs->registerCssFile(Common::assetsTime($themeUrl . '/css/magnific.min.css'));
$cs->registerCssFile(Common::assetsTime($themeUrl . '/css/custom2.css'));

$cs->registerCssFile(Common::assetsTime($themeUrl . '/css/custom-new.css'));

$cs->registerScriptFile(Common::assetsTime($themeUrl . '/js/modernizr-custom.js'));
$cs->registerScriptFile(Common::assetsTime($themeUrl . '/js/imagesloaded.pkgd.min.js'));
$cs->registerScriptFile(Common::assetsTime($themeUrl . '/js/jquery.maskedinput.min.js'));
$cs->registerScriptFile(Common::assetsTime($themeUrl . '/js/select2.full.min.js'));
$cs->registerScriptFile(Common::assetsTime($themeUrl . '/js/slick.min.js'));
if (empty($this->roulette)) {
    $cs->registerScriptFile(Common::assetsTime($themeUrl . '/js/fastclick.min.js'));
}
$cs->registerScriptFile(Common::assetsTime($themeUrl . '/js/main.js'));

if (!empty($this->roulette)) {
    $cs->registerCssFile(Common::assetsTime($themeUrl . '/css/roulette.css'));
    $cs->registerScriptFile(Common::assetsTime($themeUrl . '/js/roulette.js'));
}

if ($this->interactive) {
    $cs->registerCssFile(Common::assetsTime($themeUrl . '/css/interactive.css'));
    $cs->registerScriptFile(Common::assetsTime($themeUrl . '/js/simple-share.min.js'));
    $cs->registerScriptFile(Common::assetsTime($themeUrl . '/js/interactive.js'));
}
if ($this->interactiveTest) {
    $cs->registerCssFile(Common::assetsTime($themeUrl . '/css/test.css'));
    $cs->registerScriptFile(Common::assetsTime($themeUrl . '/js/test.js'));
}

$cs->registerScriptFile(Common::assetsTime($themeUrl . '/js/magnific.min.js'));
$cs->registerScriptFile(Common::assetsTime($themeUrl . '/js/cookies.min.js'));
$cs->registerScriptFile(Common::assetsTime($themeUrl . '/js/jquery.validate.min.js'));
$cs->registerScriptFile(Common::assetsTime($themeUrl . '/js/jquery-ui.min.js'));
$cs->registerScriptFile(Common::assetsTime($themeUrl . '/js/custom.js'));
$cs->registerScriptFile(Common::assetsTime($themeUrl . '/js/all_custom.js'));
$cs->registerScriptFile(Common::assetsTime($themeUrl . '/js/cookie.js'));


// page style
if (!empty($this->style['style'])) {
    $this->bodyClasses[] = 'boxed';
    if (!empty($this->style['style_mobile'])) {
        $cs->registerCss('body_bkg', '@media (min-width:1025px) { body{height:auto;' . $this->style['style'] . '} }');
        $cs->registerCss('body_bkg_mobile', '@media (max-width:1024px) { body{height:auto;' . $this->style['style_mobile'] . '} }');
    } else {
        $cs->registerCss('body_bkg', 'body{height:auto;' . $this->style['style'] . '}');
    }
    $this->hideTopBanner = true;
}
if (!empty($this->style['url'])) {
    $cs->registerCss('body_bkg_cursor', 'body{cursor:pointer}body div,body footer,body header{cursor:auto}');
    $js = "$('body').on('click', function(e) { if (e.target != this) return; window.open('" . $this->style['url'] . "', '_blank'); });";
    $cs->registerScript('body_bkg_link', $js);
}
?>
<!DOCTYPE html>
<html lang="<?= Yii::app()->language == 'by' ? 'be' : Yii::app()->language ?>">
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
    <meta name="p:domain_verify" content="11f736d0d99a68fb94ccccb8a3445b84"/>
    <script charset="UTF-8"
            src="//cdn.sendpulse.com/28edd3380a1c17cf65b137fe96516659/js/push/877b86dcdb36f7b75b8bae581a8fb9f2_1.js"
            async></script>
    <?php
    if (isset($this->bannerSystems[Banner::SYSTEM_ADFOX])) {
        $this->renderPartial('/layouts/_adfox');
    }
    ?>

    <style id="monica-reading-highlight-style">
        .monica-reading-highlight {
            animation: fadeInOut 1.5s ease-in-out;
        }

        @keyframes fadeInOut {

            0%,
            100% {
                background-color: transparent;
            }

            30%,
            70% {
                background-color: rgba(2, 118, 255, 0.20);
            }
        }
    </style>
</head>
<body<?php if (!empty($this->bodyClasses)): ?> class="<?= implode(' ', $this->bodyClasses) ?>"<?php endif; ?>>

<?php /*if ($this->relapCode): ?>
    <?= CHtml::value(Yii::app()->params, 'relap-body-code') ?>
<?php endif;*/ ?>

<?php if (!empty($this->topImage) && !empty($this->topTitle)) { ?>
    <div class="b-panorama"
         style="background:url(<?= CHtml::encode($this->topImage) ?>) no-repeat 0 0;background-size:cover">
        <div class="b-panorama__logo">
            <a href="/">34travel</a>
        </div>
        <div class="b-panorama__title">
            <h1 class="b-post__title<?php if ($this->topHome): ?> on_home<?php endif; ?>"><a
                        href="<?= $this->topLink ?>"><?= $this->topTitle ?></a></h1>
        </div>
    </div>
<?php } ?>


<div id="wrapper">
    <?php
    if (empty($this->topImage) || empty($this->topTitle) || $this->topHome) {
        ?>
        <header>
            <?php
            if (!$this->hideTopBanner) {
                $banner = null;
                if ($index_page) {
                    $banner = Banner::getByPlace(Banner::PLACE_HOME_TOP_WIDE);
                } else {
                    $banner = Banner::getByPlace(Banner::PLACE_OTHER_TOP_WIDE);
                }
                if (!empty($banner)) {
                    echo sprintf('<div class="top-baner">
                            <div class="container">%s</div>
                        </div>', BannerHelper::getHtml($banner));
                }
            }
            ?>
            <div class="header_container header_desktop <?php if (Yii::app()->userComponent->isAuthenticated()): ?> header_in-account<?php endif; ?>">
                <div class="header__section header__desktop_logo">
                    <a href="/" class="logo" title="34travel"></a>
                </div>
                <div class="header__section header__big_right">
                    <div class="header__top flex__wrap">
                        <div class="header_left_section flex__wrap">
                            <div class="header__projects">
                                <div class="header__projects_header">спецпроекты:</div>
                                <div class="header__projects_wrap flex__wrap">
                                    <a href="<?= $this->createUrl('/special/audioguides') ?>"
                                       class="header__projects_link flex__wrap  header__link">
                                        <svg width="24" height="18" viewBox="0 0 24 18" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path d="M2.68234 17.2163H4.12234V12.5575H4.15058V6.99512H2.68234V17.2163Z"
                                                  fill="#020202"/>
                                            <path d="M19.8494 15.7481V17.2163H21.3176V6.99512H19.8494V15.7481Z"
                                                  fill="#020202"/>
                                            <path d="M4.15058 1.85633H19.8494V5.21634H21.3176V0.359863H2.68234V5.21634H4.15058V1.85633Z"
                                                  fill="#020202"/>
                                            <path d="M23.5765 10.2422H19.8494V17.2163H23.5765V10.2422Z" fill="#020202"/>
                                            <path d="M4.15058 10.2422H0.423523V17.2163H4.15058V10.2422Z"
                                                  fill="#020202"/>
                                        </svg>
                                        Подкаст
                                    </a>
                                    <a href="<?= $this->createUrl('/special/audioguides') ?>"
                                       class="header__projects_link flex__wrap  header__link">
                                        <svg width="17" height="23" viewBox="0 0 17 23" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path d="M0.59375 9.34375V19.4062C0.59375 20.6493 1.34484 23 4.1875 23H9.9375C12.7802 23 13.5312 20.6493 13.5312 19.4062V18.6875H15.6875C16.0843 18.6875 16.4062 18.3655 16.4062 17.9688V12.2188C16.4062 11.822 16.0843 11.5 15.6875 11.5H13.5312V9.34375C13.5312 8.947 13.2093 8.625 12.8125 8.625H1.3125C0.91575 8.625 0.59375 8.947 0.59375 9.34375ZM14.9688 12.9375V17.25H13.5312V12.9375H14.9688ZM2.03125 10.0625H12.0938V19.4023C12.0898 19.7631 11.9665 21.5625 9.9375 21.5625H5.6825H4.1875C2.15847 21.5625 2.0352 19.7631 2.03125 19.4062V10.0625Z"
                                                  fill="black"/>
                                            <path d="M3.10938 4.3125C2.71262 4.3125 2.39062 4.6345 2.39062 5.03125V6.46875C2.39062 6.8655 2.71262 7.1875 3.10938 7.1875C3.50612 7.1875 3.82812 6.8655 3.82812 6.46875V5.75H6.70312C7.09987 5.75 7.42188 5.428 7.42188 5.03125V2.875C7.42188 2.47825 7.09987 2.15625 6.70312 2.15625H4.90625V0.71875C4.90625 0.322 4.58425 0 4.1875 0C3.79075 0 3.46875 0.322 3.46875 0.71875V2.875C3.46875 3.27175 3.79075 3.59375 4.1875 3.59375H5.98438V4.3125H3.10938Z"
                                                  fill="black"/>
                                            <path d="M8.85938 4.3125C8.46262 4.3125 8.14062 4.6345 8.14062 5.03125V6.46875C8.14062 6.8655 8.46262 7.1875 8.85938 7.1875C9.25612 7.1875 9.57812 6.8655 9.57812 6.46875V5.75H12.4531C12.8499 5.75 13.1719 5.428 13.1719 5.03125V2.15625C13.1719 1.7595 12.8499 1.4375 12.4531 1.4375H10.6562V0.71875C10.6562 0.322 10.3342 0 9.9375 0C9.54075 0 9.21875 0.322 9.21875 0.71875V2.15625C9.21875 2.553 9.54075 2.875 9.9375 2.875H11.7344V4.3125H8.85938Z"
                                                  fill="black"/>
                                        </svg>
                                        Зима
                                    </a>
                                </div>
                            </div>
                            <div class="header__links flex__wrap">
                                <a href="<?= $this->createUrl('/gotobelarus') ?>"
                                   class="header__links_link header__link">Go to<br>Belarus!</a>
                            </div>
                            <div class="header__social_wrap flex__wrap">
                                <div class="header__social_open header__link">
                                    <svg width="22" height="21" viewBox="0 0 22 21" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path d="M21.8873 7.5028C21.6722 6.78588 21.2421 6.2124 20.5969 5.87784C19.7844 5.44769 18.8285 5.49546 18.1594 5.61495L16.7494 0.692116C16.6538 0.357557 16.391 0.094735 16.0564 0.0230437C15.7219 -0.0486477 15.3634 0.0469874 15.1244 0.309856C11.7071 4.1334 10.2972 5.06534 6.52147 6.71424L3.55822 7.57456C0.953435 8.33926 -0.552077 11.0875 0.188733 13.6922C0.54719 14.9588 1.38358 16.0342 2.55454 16.6794C3.29535 17.0856 4.10786 17.3006 4.92036 17.3006C5.30271 17.3006 5.70897 17.2529 6.09132 17.1573L6.40198 18.2804C6.56926 18.8778 6.90382 19.4036 7.33396 19.8337L7.83581 20.3117C8.02699 20.479 8.26596 20.5746 8.50493 20.5746C8.7678 20.5746 9.00677 20.4789 9.19795 20.2878C9.55641 19.9054 9.55641 19.308 9.15015 18.9257L8.64831 18.4477C8.45713 18.2566 8.31376 18.0176 8.24207 17.7548L7.93139 16.6315L9.31744 16.2252C13.2844 15.6278 15.0766 15.6756 19.9277 17.0616C20.0233 17.0855 20.095 17.1095 20.1906 17.1095C20.4296 17.1095 20.6925 17.0139 20.8597 16.8227C21.0987 16.5837 21.1943 16.2253 21.0987 15.8907L19.6888 10.9918C20.3101 10.7528 21.1465 10.3227 21.6245 9.53405C22.0068 8.93662 22.1024 8.24361 21.8873 7.5028ZM3.51042 15.0304C2.79351 14.648 2.29168 13.979 2.05271 13.2143C1.59866 11.5893 2.53064 9.91643 4.10785 9.43849L6.25859 8.81714L7.23838 12.2822L7.9075 14.6719L5.75676 15.2933C5.01595 15.5084 4.20344 15.4127 3.51042 15.0304ZM13.2366 13.9789C12.1612 13.9789 11.0858 14.0746 9.81927 14.2418L8.43324 9.34292L8.09867 8.14806C11.1575 6.76203 12.7825 5.68664 15.4351 2.86678L18.8285 14.7914C16.5344 14.2179 14.9094 13.9789 13.2366 13.9789ZM20.0233 8.55436C19.88 8.81723 19.5215 9.00841 19.1869 9.15179L18.709 7.47899C19.0675 7.4312 19.4737 7.43117 19.7366 7.57456C19.8561 7.64625 19.9756 7.74179 20.0711 8.00466C20.1428 8.29142 20.0711 8.43488 20.0233 8.55436ZM13.9774 6.97713C14.2402 7.35948 14.1685 7.8852 13.7862 8.14806C12.902 8.76939 11.8983 9.31902 11.8505 9.34292C11.731 9.41461 11.5877 9.43849 11.4682 9.43849C11.1575 9.43849 10.8707 9.27123 10.7274 8.98446C10.5123 8.57821 10.6796 8.07633 11.0858 7.86125C11.0858 7.86125 12.0417 7.35944 12.8064 6.8098C13.1649 6.49914 13.6906 6.59478 13.9774 6.97713Z"
                                              fill="black"/>
                                    </svg>
                                    Соцсети
                                </div>
                                <ul class="header__social_list">
                                    <li class="header__social_item">
                                        <a target="_blank" href="https://www.instagram.com/34travel/"
                                           class="header__social_link header__link">Instagram
                                        </a>

                                    </li>
                                    <li class="header__social_item">
                                        <a target="_blank" href="https://www.facebook.com/34travel"
                                           class="header__social_link header__link">Facebook
                                        </a>

                                    </li>
                                    <li class="header__social_item">
                                        <a target="_blank" href="https://telegram.me/travel34"
                                           class="header__social_link header__link">Telegram
                                        </a>
                                    </li>
                                    <li class="header__social_item">
                                        <a target="_blank" href="https://twitter.com/34travelby"
                                           class="header__social_link header__link">Twitter
                                        </a>
                                    </li>
                                    <li class="header__social_item">
                                        <a target="_blank" href="/"
                                           class="header__social_link header__link">Patreon
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="header_right__section flex__wrap">
                            <div class="header__right_top flex__wrap">
                                <div class="header__subscription_wrap">
                                    <?php if (Yii::app()->userComponent->isAuthenticated()): ?>
                                        <a href="<?= $this->createUrl('subscription/f4/step-one') ?>"
                                           class="header__subscription_link header__link"><?= Yii::app()->userComponent->checkMySubscription() ? 'Подписаться' : 'Тарифы' ?></a>
                                    <?php else: ?>
                                        <a href="<?= $this->createUrl('subscription/f1/step-one') ?>"
                                           class="header__subscription_link header__link">Подписаться</a>
                                    <?php endif; ?>
                                </div>
                                <div class="header__account_wrap">
                                    <?php if (Yii::app()->userComponent->isAuthenticated()): ?>
                                        <a href="/" class="header__account_link_white header__link flex__wrap">
                                            <svg width="17" height="17" viewBox="0 0 17 17" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <circle cx="8.49999" cy="4.95833" r="2.83333" stroke="black"
                                                        stroke-width="2" stroke-linecap="round"/>
                                                <path d="M3.72571 13.2243C4.17686 11.0812 6.30991 9.91669 8.49999 9.91669V9.91669C10.6901 9.91669 12.8231 11.0812 13.2743 13.2243C13.3245 13.463 13.3668 13.7074 13.3981 13.955C13.462 14.4605 13.0453 14.875 12.5358 14.875H4.46417C3.95468 14.875 3.53803 14.4605 3.60191 13.955C3.63321 13.7074 3.67546 13.463 3.72571 13.2243Z"
                                                      stroke="black" stroke-width="2" stroke-linecap="round"/>
                                            </svg>
                                            Мой аккаунт
                                            <svg width="11" height="6" viewBox="0 0 11 6" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path d="M5.5 6L0.736861 0.75L10.2631 0.749999L5.5 6Z" fill="black"/>
                                            </svg>
                                        </a>
                                        <div class="header__account_list">
                                            <a href="<?= $this->createUrl('/profile/account') ?>"
                                               class="header__account_item header__link">Мой аккаунт</a>
                                            <a href="<?= $this->createUrl('/profile/collections') ?>"
                                               class="header__account_item header__link">Коллекции</a>
                                            <a href="<?= $this->createUrl('/profile/favorites') ?>"
                                               class="header__account_item header__link">Избранное</a>
                                            <a href="<?= $this->createUrl('/logout') ?>"
                                               class="header__account_item header__link">Выйти</a>
                                        </div>
                                    <?php else: ?>
                                        <a href="<?= $this->createUrl('/login') ?>"
                                           class="header__account_link header__link flex__wrap">
                                            <svg width="17" height="17" viewBox="0 0 17 17" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <circle cx="8.49999" cy="4.95833" r="2.83333" stroke="black"
                                                        stroke-width="2" stroke-linecap="round"/>
                                                <path d="M3.72571 13.2243C4.17686 11.0812 6.30991 9.91669 8.49999 9.91669V9.91669C10.6901 9.91669 12.8231 11.0812 13.2743 13.2243C13.3245 13.463 13.3668 13.7074 13.3981 13.955C13.462 14.4605 13.0453 14.875 12.5358 14.875H4.46417C3.95468 14.875 3.53803 14.4605 3.60191 13.955C3.63321 13.7074 3.67546 13.463 3.72571 13.2243Z"
                                                      stroke="black" stroke-width="2" stroke-linecap="round"/>
                                            </svg>
                                            Войти
                                        </a>
                                    <?php endif; ?>
                                </div>
                                <div class="header__search_wrap">
                                    <div class="search">
                                        <button type="button" class="open__search"></button>
                                    </div>
                                </div>
                                <form action="<?= $this->createUrl('/search/results') ?>" method="get"
                                      class="search__form">
                                    <div class="form-wrap">
                                        <input type="text" name="text" placeholder="" required="">
                                    </div>
                                    <button type="submit"></button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="header__bottom flex__wrap">
                        <nav class="clearfix">
                            <?php
                            $this->widget('zii.widgets.CMenu', [
                                'activateParents' => true,
                                'linkLabelWrapper' => 'span',
                                'items' => [
                                    ['label' => 'Гайды', 'url' => ['/guide/index'], 'active' => $this->id == 'guide'],
                                    ['label' => 'Страны и города', 'url' => ['/geo/index'], 'active' => $this->id == 'geo'],
                                    ['label' => 'Материалы', 'url' => ['/people/index'], 'active' => $this->id == 'people'],
                                    ['label' => 'Рубрики', 'url' => ['/rubric/index'], 'active' => $this->id == 'rubric'],
                                    ['label' => 'Новости', 'url' => ['/news/index'], 'active' => $this->id == 'news'],
                                ],
                            ]);
                            ?>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="flex__wrap header__mobile_visible">
                <div class="header__mobile">
                    <div class="inner">
                        <div id="menu-toggle-wrapper" class="menu-btn">
                            <div id="menu-toggle-top"></div>
                            <div id="menu-toggle"></div>
                            <div id="menu-toggle-bottom"></div>
                        </div>
                    </div>
                </div>
                <div class="header__mobile_logo header__mobile">
                    <a href="/" class="logo" title="34travel"></a>
                </div>
                <div class="header__mobile">
                    <div class="header__search_wrap">
                        <div class="search">
                            <button type="button" class="open__search"></button>
                        </div>
                    </div>
                    <form action="<?= $this->createUrl('/search/results') ?>" method="get" class="search__form">
                        <div class="form-wrap">
                            <input type="text" name="text" placeholder="" required="">
                        </div>
                        <button type="submit"><span>Искать</span></button>
                    </form>
                </div>
            </div>
            <div class="header_container header__mobile_wrap">
                <div class="header__mobile_light">
                    <?php
                    $this->widget('zii.widgets.CMenu', [
                        'activateParents' => true,
                        'linkLabelWrapper' => 'span',
                        'htmlOptions' => ['id' => 'yw0', 'class' => 'header__mobile_nav'],
                        'items' => [
                            ['label' => 'Гайды', 'url' => ['/guide/index'], 'active' => $this->id == 'guide', 'linkOptions' => ['class' => 'header__link']],
                            ['label' => 'Страны и города', 'url' => ['/geo/index'], 'active' => $this->id == 'geo', 'linkOptions' => ['class' => 'header__link']],
                            ['label' => 'Материалы', 'url' => ['/people/index'], 'active' => $this->id == 'people', 'linkOptions' => ['class' => 'header__link']],
                            ['label' => 'Рубрики', 'url' => ['/rubric/index'], 'active' => $this->id == 'rubric', 'linkOptions' => ['class' => 'header__link']],
                            ['label' => 'Новости', 'url' => ['/news/index'], 'active' => $this->id == 'news', 'linkOptions' => ['class' => 'header__link']],
                        ],
                    ]);
                    ?>
                </div>
                <?php if (Yii::app()->userComponent->isAuthenticated()): ?>
                    <div class="header__mobile_dark">
                        <div class="header__account_icon">
                            <svg width="17" height="17" viewBox="0 0 17 17" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <circle cx="8.49999" cy="4.95833" r="2.83333" stroke="black" stroke-width="2"
                                        stroke-linecap="round"/>
                                <path d="M3.72571 13.2243C4.17686 11.0811 6.30991 9.91667 8.49999 9.91667V9.91667C10.6901 9.91667 12.8231 11.0811 13.2743 13.2242C13.3245 13.4629 13.3668 13.7074 13.3981 13.955C13.462 14.4605 13.0453 14.875 12.5358 14.875H4.46417C3.95468 14.875 3.53803 14.4605 3.60191 13.955C3.63321 13.7074 3.67546 13.4629 3.72571 13.2243Z"
                                      stroke="black" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                        </div>
                        <ul class="header__account_list">
                            <li class="header__account_item">
                                <a href="<?= $this->createUrl('/profile/account') ?>" class="header__link">Мой
                                    аккаунт</a>
                            </li>
                            <li class="header__account_item">
                                <a href="<?= $this->createUrl('/profile/favorites') ?>"
                                   class="header__link">Избранное</a>
                            </li>
                            <li class="header__account_item">
                                <a href="<?= $this->createUrl('/logout') ?>" class="header__link">Выйти</a>
                            </li>
                        </ul>
                        <?php if (Yii::app()->userComponent->isAuthenticated()): ?>
                            <a href="<?= $this->createUrl('subscription/f4/step-one') ?>"
                               class="header__buy-subscribtion header__link">Купить подписку</a>
                        <?php else: ?>
                            <a href="<?= $this->createUrl('subscription/f1/step-one') ?>"
                               class="header__buy-subscribtion header__link">Купить подписку</a>
                        <?php endif; ?>
                    </div>
                <?php else: ?>
                    <div class="header__mobile_dark header__mobile_dark_big">
                        <div class="header__account_wrap">
                            <a href="<?= $this->createUrl('/login') ?>"
                               class="header__account_link header__link flex__wrap">
                                <svg width="17" height="17" viewBox="0 0 17 17" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="8.49999" cy="4.95833" r="2.83333" stroke="black" stroke-width="2"
                                            stroke-linecap="round"></circle>
                                    <path d="M3.72571 13.2243C4.17686 11.0812 6.30991 9.91669 8.49999 9.91669V9.91669C10.6901 9.91669 12.8231 11.0812 13.2743 13.2243C13.3245 13.463 13.3668 13.7074 13.3981 13.955C13.462 14.4605 13.0453 14.875 12.5358 14.875H4.46417C3.95468 14.875 3.53803 14.4605 3.60191 13.955C3.63321 13.7074 3.67546 13.463 3.72571 13.2243Z"
                                          stroke="black" stroke-width="2" stroke-linecap="round"></path>
                                </svg>
                                Войти
                            </a>
                        </div>
                        <?php if (Yii::app()->userComponent->isAuthenticated()): ?>
                            <a href="<?= $this->createUrl('subscription/f4/step-one') ?>"
                               class="header__buy-subscribtion header__link">Купить подписку</a>
                        <?php else: ?>
                            <a href="<?= $this->createUrl('subscription/f1/step-one') ?>"
                               class="header__buy-subscribtion header__link">Купить подписку</a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
                <div class="header__mobile_light">
                    <div class="header_left_section flex__wrap">
                        <div class="header__projects header__section">
                            <div class="header__projects_header">спецпроекты:</div>
                            <div class="header__projects_wrap flex__wrap">
                                <a href="<?= $this->createUrl('/special/audioguides') ?>"
                                   class="header__projects_link flex__wrap  header__link">
                                    <svg width="24" height="18" viewBox="0 0 24 18" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path d="M2.68234 17.2163H4.12234V12.5575H4.15058V6.99512H2.68234V17.2163Z"
                                              fill="#020202"/>
                                        <path d="M19.8494 15.7481V17.2163H21.3176V6.99512H19.8494V15.7481Z"
                                              fill="#020202"/>
                                        <path d="M4.15058 1.85633H19.8494V5.21634H21.3176V0.359863H2.68234V5.21634H4.15058V1.85633Z"
                                              fill="#020202"/>
                                        <path d="M23.5765 10.2422H19.8494V17.2163H23.5765V10.2422Z" fill="#020202"/>
                                        <path d="M4.15058 10.2422H0.423523V17.2163H4.15058V10.2422Z" fill="#020202"/>
                                    </svg>
                                    Подкаст
                                </a>
                                <a href="<?= $this->createUrl('/special/audioguides') ?>"
                                   class="header__projects_link flex__wrap  header__link">
                                    <svg width="17" height="23" viewBox="0 0 17 23" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path d="M0.59375 9.34375V19.4062C0.59375 20.6493 1.34484 23 4.1875 23H9.9375C12.7802 23 13.5312 20.6493 13.5312 19.4062V18.6875H15.6875C16.0843 18.6875 16.4062 18.3655 16.4062 17.9688V12.2188C16.4062 11.822 16.0843 11.5 15.6875 11.5H13.5312V9.34375C13.5312 8.947 13.2093 8.625 12.8125 8.625H1.3125C0.91575 8.625 0.59375 8.947 0.59375 9.34375ZM14.9688 12.9375V17.25H13.5312V12.9375H14.9688ZM2.03125 10.0625H12.0938V19.4023C12.0898 19.7631 11.9665 21.5625 9.9375 21.5625H5.6825H4.1875C2.15847 21.5625 2.0352 19.7631 2.03125 19.4062V10.0625Z"
                                              fill="black"/>
                                        <path d="M3.10938 4.3125C2.71262 4.3125 2.39062 4.6345 2.39062 5.03125V6.46875C2.39062 6.8655 2.71262 7.1875 3.10938 7.1875C3.50612 7.1875 3.82812 6.8655 3.82812 6.46875V5.75H6.70312C7.09987 5.75 7.42188 5.428 7.42188 5.03125V2.875C7.42188 2.47825 7.09987 2.15625 6.70312 2.15625H4.90625V0.71875C4.90625 0.322 4.58425 0 4.1875 0C3.79075 0 3.46875 0.322 3.46875 0.71875V2.875C3.46875 3.27175 3.79075 3.59375 4.1875 3.59375H5.98438V4.3125H3.10938Z"
                                              fill="black"/>
                                        <path d="M8.85938 4.3125C8.46262 4.3125 8.14062 4.6345 8.14062 5.03125V6.46875C8.14062 6.8655 8.46262 7.1875 8.85938 7.1875C9.25612 7.1875 9.57812 6.8655 9.57812 6.46875V5.75H12.4531C12.8499 5.75 13.1719 5.428 13.1719 5.03125V2.15625C13.1719 1.7595 12.8499 1.4375 12.4531 1.4375H10.6562V0.71875C10.6562 0.322 10.3342 0 9.9375 0C9.54075 0 9.21875 0.322 9.21875 0.71875V2.15625C9.21875 2.553 9.54075 2.875 9.9375 2.875H11.7344V4.3125H8.85938Z"
                                              fill="black"/>
                                    </svg>
                                    Зима
                                </a>
                            </div>
                        </div>
                        <div class="header__links flex__wrap header__section">
                            <div class="header__projects_header">Проекты:</div>
                            <a href="<?= $this->createUrl('/gotobelarus') ?>" class="header__links_link header__link">Go
                                to Belarus!</a>
                        </div>
                        <div class="header_social header__section">
                            <div class="header__social_open header__projects_header">
                                <svg width="22" height="21" viewBox="0 0 22 21" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path d="M21.8873 7.5028C21.6722 6.78588 21.2421 6.2124 20.5969 5.87784C19.7844 5.44769 18.8285 5.49546 18.1594 5.61495L16.7494 0.692116C16.6538 0.357557 16.391 0.094735 16.0564 0.0230437C15.7219 -0.0486477 15.3634 0.0469874 15.1244 0.309856C11.7071 4.1334 10.2972 5.06534 6.52147 6.71424L3.55822 7.57456C0.953435 8.33926 -0.552077 11.0875 0.188733 13.6922C0.54719 14.9588 1.38358 16.0342 2.55454 16.6794C3.29535 17.0856 4.10786 17.3006 4.92036 17.3006C5.30271 17.3006 5.70897 17.2529 6.09132 17.1573L6.40198 18.2804C6.56926 18.8778 6.90382 19.4036 7.33396 19.8337L7.83581 20.3117C8.02699 20.479 8.26596 20.5746 8.50493 20.5746C8.7678 20.5746 9.00677 20.4789 9.19795 20.2878C9.55641 19.9054 9.55641 19.308 9.15015 18.9257L8.64831 18.4477C8.45713 18.2566 8.31376 18.0176 8.24207 17.7548L7.93139 16.6315L9.31744 16.2252C13.2844 15.6278 15.0766 15.6756 19.9277 17.0616C20.0233 17.0855 20.095 17.1095 20.1906 17.1095C20.4296 17.1095 20.6925 17.0139 20.8597 16.8227C21.0987 16.5837 21.1943 16.2253 21.0987 15.8907L19.6888 10.9918C20.3101 10.7528 21.1465 10.3227 21.6245 9.53405C22.0068 8.93662 22.1024 8.24361 21.8873 7.5028ZM3.51042 15.0304C2.79351 14.648 2.29168 13.979 2.05271 13.2143C1.59866 11.5893 2.53064 9.91643 4.10785 9.43849L6.25859 8.81714L7.23838 12.2822L7.9075 14.6719L5.75676 15.2933C5.01595 15.5084 4.20344 15.4127 3.51042 15.0304ZM13.2366 13.9789C12.1612 13.9789 11.0858 14.0746 9.81927 14.2418L8.43324 9.34292L8.09867 8.14806C11.1575 6.76203 12.7825 5.68664 15.4351 2.86678L18.8285 14.7914C16.5344 14.2179 14.9094 13.9789 13.2366 13.9789ZM20.0233 8.55436C19.88 8.81723 19.5215 9.00841 19.1869 9.15179L18.709 7.47899C19.0675 7.4312 19.4737 7.43117 19.7366 7.57456C19.8561 7.64625 19.9756 7.74179 20.0711 8.00466C20.1428 8.29142 20.0711 8.43488 20.0233 8.55436ZM13.9774 6.97713C14.2402 7.35948 14.1685 7.8852 13.7862 8.14806C12.902 8.76939 11.8983 9.31902 11.8505 9.34292C11.731 9.41461 11.5877 9.43849 11.4682 9.43849C11.1575 9.43849 10.8707 9.27123 10.7274 8.98446C10.5123 8.57821 10.6796 8.07633 11.0858 7.86125C11.0858 7.86125 12.0417 7.35944 12.8064 6.8098C13.1649 6.49914 13.6906 6.59478 13.9774 6.97713Z"
                                          fill="#BDBDBD"/>
                                </svg>
                                Соцсети
                            </div>
                            <ul class="header__social_list">
                                <li class="header__social_item">
                                    <a target="_blank" href="https://www.instagram.com/34travel/"
                                       class="header__social_link header__link">Instagram
                                    </a>

                                </li>
                                <li class="header__social_item">
                                    <a target="_blank" href="https://www.facebook.com/34travel"
                                       class="header__social_link header__link">Facebook
                                    </a>

                                </li>
                                <li class="header__social_item">
                                    <a target="_blank" href="https://telegram.me/travel34"
                                       class="header__social_link header__link">Telegram
                                    </a>
                                </li>
                                <li class="header__social_item">
                                    <a target="_blank" href="https://twitter.com/34travelby"
                                       class="header__social_link header__link">Twitter
                                    </a>
                                </li>
                                <li class="header__social_item">
                                    <a target="_blank" href="/"
                                       class="header__social_link header__link">Patreon
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <?php
    }
    ?>

    <?= $content ?>

    <div id="indent"></div>
</div>

<?php $this->renderPartial('/layouts/_footer') ?>

<?php if (Yii::app()->userComponent->isAuthenticated()): ?>
    <?php $this->renderPartial('/modals/add_favorites_post_view') ?>
    <?php $this->renderPartial('/modals/add_collection_post_view') ?>
<?php endif; ?>
<?= BlocksHelper::get('footer_code') ?>
</body>
</html>
