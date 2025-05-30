<?php
/* @var $this FrontEndController */
/* @var $content string */

$themeUrl = Yii::app()->theme->baseUrl;

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

$index_page = $this->id == 'gtb' && $this->action->id == 'index';
if ($index_page) {
    $this->bodyClasses[] = 'index-page';
}
$supertop = !empty($this->topImage) && !empty($this->topTitle);

$cs->registerCssFile('https://fonts.googleapis.com/css?family=PT+Serif:400,400i,700,700i|Roboto+Condensed:400,400i,700,700i&subset=cyrillic&display=swap');
$cs->registerCssFile('https://fonts.googleapis.com/css2?family=Spectral:wght@500;700&display=swap');
$cs->registerCssFile(Common::assetsTime($themeUrl . '/css/vendor.css'));
$cs->registerCssFile(Common::assetsTime($themeUrl . '/css/style.css'));
$cs->registerCssFile(Common::assetsTime($themeUrl . '/css/main_gtb_new_post.css'));
if ($this->oldPostStyles) {
    $cs->registerCssFile(Common::assetsTime($themeUrl . '/css/gtb_old_post.css'));
}
$cs->registerCssFile(Common::assetsTime($themeUrl . '/css/custom.css'));

$cs->registerScriptFile(Common::assetsTime($themeUrl . '/js/modernizr-custom.js'));
$cs->registerScriptFile(Common::assetsTime($themeUrl . '/js/imagesloaded.pkgd.min.js'));
$cs->registerScriptFile(Common::assetsTime($themeUrl . '/js/slick.min.js'));
$cs->registerScriptFile(Common::assetsTime($themeUrl . '/js/fastclick.min.js'));
$cs->registerScriptFile(Common::assetsTime($themeUrl . '/js/main_gtb.js'));

if ($this->roulette == 'vetliva') {
    $cs->registerCssFile(Common::assetsTime($themeUrl . '/css/roulette_gtb.css'));
    $cs->registerCssFile(Common::assetsTime($themeUrl . '/css/vetliva-roulette.css'));
    $cs->registerScriptFile(Common::assetsTime($themeUrl . '/js/festival.js'));
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

// page style
if (!empty($this->style['style'])) {
    $this->bodyClasses[] = 'boxed';
    if ($this->route != 'gtb/view' && !$index_page) {
        // fix boxed style for list pages
        $this->bodyClasses[] = 'index-page';
    }
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

$app_lang = Yii::app()->language;

$langPostfix = '';

switch ($app_lang) {
    case 'en':
    case 'be':
        $langPostfix = '_' . $app_lang;
        break;
}

?>
<!DOCTYPE html>
<html lang="<?= $app_lang ?>">
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
    <style type="text/css">
        .st0 {
            display: none;
        }

        .st1 {
            display: inline;
        }

        .st2 {
            display: inline;
            clip-path: url(#SVGID_00000131358097091792223140000012661068884628228286_);
        }

        .st3 {
            display: inline;
            clip-path: url(#SVGID_00000154412505037248134950000003972682076775274647_);
        }

        .st4 {
            display: inline;
            clip-path: url(#SVGID_00000021802016493571753940000010043108713440081816_);
        }

        .st5 {
            display: inline;
            clip-path: url(#SVGID_00000137089820643651600120000000594195985660563876_);
        }

        .st6 {
            display: inline;
            clip-path: url(#SVGID_00000128444959686999159780000013199225243388842428_);
        }

        .st7 {
            display: inline;
            clip-path: url(#SVGID_00000060018358461502594830000003257614582713946774_);
        }

        .st8 {
            display: inline;
            fill: none;
        }

        .st9 {
            fill: #FFFFFF;
        }
    </style>
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
            $banner = GtbBanner::getByPlace(GtbBanner::PLACE_GTB_HOME_TOP);
        } else {
            $banner = GtbBanner::getByPlace(GtbBanner::PLACE_GTB_TOP_ALL);
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

    <header>
        <div class="container clearfix">
            <div class="left-side">
                <div class="slogan">
                    <?= BlocksHelper::get('gtb_slogan' . ($app_lang == 'en' ? '_en' : '')) ?>
                </div>
                <div class="lang">
                    <?php $this->widget('application.widgets.GtbLangSelector'); ?>
                </div>
                <ul class="social">
                    <li><a href="https://www.instagram.com/gotobelarus/" class="icon-instagram" target="_blank"></a></li>
                </ul>
            </div>
            <?php if ($index_page): ?>
                <div class="logo"><span>GO TO<br> BELARUS!</span></div>
            <?php else: ?>
                <a href="<?= $this->createUrl('/gtb/index') ?>" class="logo"><span>GO TO<br> BELARUS!</span></a>
            <?php endif; ?>
            <div class="mob-slogan">
                <?= BlocksHelper::get('gtb_slogan' . ($app_lang == 'en' ? '_en' : '')) ?>
            </div>
            <div class="right-side">
                <?= BlocksHelper::get('gtb_promo_link' . ($supertop ? '_supertop' : '') . $langPostfix) ?>
                <div class="home">
                    <a href="/">
                        <div class="mobile-logo">
                            <svg version="1.1" id="_x3C_Layer_x3E_" xmlns="http://www.w3.org/2000/svg"
                                 xmlns:xlink="http://www.w3.org/1999/xlink" x="0px"
                                 y="0px" viewBox="0 0 591 623" style="enable-background:new 0 0 591 623;"
                                 xml:space="preserve">
                                <g class="st0">
                                    <defs>
                                        <rect id="SVGID_1_" x="461.6" y="28" width="115.2" height="39.2"/>
                                    </defs>
                                    <use xlink:href="#SVGID_1_"
                                         style="display:inline;overflow:visible;fill-rule:evenodd;clip-rule:evenodd;"/>
                                    <clipPath id="SVGID_00000037664243188774297150000002061586282131898775_"
                                              class="st1">
                                        <use xlink:href="#SVGID_1_" style="overflow:visible;"/>
                                    </clipPath>
                                    <g style="display:inline;clip-path:url(#SVGID_00000037664243188774297150000002061586282131898775_);">
                                        <defs>
                                            <rect id="SVGID_00000088111936582988862870000001603785814841439662_"
                                                  width="591" height="623"/>
                                        </defs>
                                        <use xlink:href="#SVGID_00000088111936582988862870000001603785814841439662_"
                                             style="overflow:visible;"/>
                                        <clipPath id="SVGID_00000044876383326379340820000009476330571475154087_">
                                            <use xlink:href="#SVGID_00000088111936582988862870000001603785814841439662_"
                                                 style="overflow:visible;"/>
                                        </clipPath>

                                        <image style="overflow:visible;clip-path:url(#SVGID_00000044876383326379340820000009476330571475154087_);"
                                               width="591" height="623" xlink:href="628E65E4ED2B38A6.jpg">
                                        </image>
                                    </g>
                                </g>
                                <g class="st0">
                                    <defs>
                                        <rect id="SVGID_00000033370891583635045170000008297813141840993436_" x="11.8"
                                              y="553.2" width="115.8" height="39.2"/>
                                    </defs>
                                    <clipPath id="SVGID_00000029733537105726322150000008803921682324811660_"
                                              class="st1">
                                        <use xlink:href="#SVGID_00000033370891583635045170000008297813141840993436_"
                                             style="overflow:visible;"/>
                                    </clipPath>
                                    <g style="display:inline;clip-path:url(#SVGID_00000029733537105726322150000008803921682324811660_);">
                                        <defs>
                                            <rect id="SVGID_00000116234121658054985700000017617949576783437719_"
                                                  width="591" height="623"/>
                                        </defs>
                                        <clipPath id="SVGID_00000092429724805733619800000001248793765278543748_">
                                            <use xlink:href="#SVGID_00000116234121658054985700000017617949576783437719_"
                                                 style="overflow:visible;"/>
                                        </clipPath>

                                        <image style="overflow:visible;clip-path:url(#SVGID_00000092429724805733619800000001248793765278543748_);"
                                               width="591" height="623" xlink:href="628E65E4ED2B38AA.jpg">
                                        </image>
                                    </g>
                                </g>
                                <g class="st0">
                                    <defs>
                                        <rect id="SVGID_00000054237475654494935090000005776003797002386608_" x="461.6"
                                              y="553.2" width="115.2" height="39.2"/>
                                    </defs>
                                    <clipPath id="SVGID_00000137840438147405309800000002866825705976936632_"
                                              class="st1">
                                        <use xlink:href="#SVGID_00000054237475654494935090000005776003797002386608_"
                                             style="overflow:visible;"/>
                                    </clipPath>
                                    <g style="display:inline;clip-path:url(#SVGID_00000137840438147405309800000002866825705976936632_);">
                                        <defs>
                                            <rect id="SVGID_00000044145739937309111790000005939782358153838209_"
                                                  width="591" height="623"/>
                                        </defs>
                                        <clipPath id="SVGID_00000149352693449848121680000017862496891583990692_">
                                            <use xlink:href="#SVGID_00000044145739937309111790000005939782358153838209_"
                                                 style="overflow:visible;"/>
                                        </clipPath>

                                        <image style="overflow:visible;clip-path:url(#SVGID_00000149352693449848121680000017862496891583990692_);"
                                               width="591" height="623" xlink:href="628E65E4ED2B38AD.jpg">
                                        </image>
                                    </g>
                                </g>
                                <g class="st0">
                                    <defs>
                                        <rect id="SVGID_00000052084064286647828650000008064508607901379259_" x="537.2"
                                              y="477.2" width="39.6" height="115.3"/>
                                    </defs>
                                    <clipPath id="SVGID_00000102507298361979098810000017837289214935824279_"
                                              class="st1">
                                        <use xlink:href="#SVGID_00000052084064286647828650000008064508607901379259_"
                                             style="overflow:visible;"/>
                                    </clipPath>
                                    <g style="display:inline;clip-path:url(#SVGID_00000102507298361979098810000017837289214935824279_);">
                                        <defs>
                                            <rect id="SVGID_00000003825024618235827340000006711561154603681921_"
                                                  width="591" height="623"/>
                                        </defs>
                                        <clipPath id="SVGID_00000104675091571173538030000011863985214173636026_">
                                            <use xlink:href="#SVGID_00000003825024618235827340000006711561154603681921_"
                                                 style="overflow:visible;"/>
                                        </clipPath>

                                        <image style="overflow:visible;clip-path:url(#SVGID_00000104675091571173538030000011863985214173636026_);"
                                               width="591" height="623" xlink:href="628E65E4ED2B38AE.jpg">
                                        </image>
                                    </g>
                                </g>
                                <g class="st0">
                                    <defs>
                                        <rect id="SVGID_00000073683262188008862740000012869361642228711810_" x="11.8"
                                              y="477.2" width="39.6" height="115.3"/>
                                    </defs>
                                    <clipPath id="SVGID_00000117669405460077346270000002249819170587734972_"
                                              class="st1">
                                        <use xlink:href="#SVGID_00000073683262188008862740000012869361642228711810_"
                                             style="overflow:visible;"/>
                                    </clipPath>
                                    <g style="display:inline;clip-path:url(#SVGID_00000117669405460077346270000002249819170587734972_);">
                                        <defs>
                                            <rect id="SVGID_00000117677133036266311380000006590335911856890520_"
                                                  width="591" height="623"/>
                                        </defs>
                                        <clipPath id="SVGID_00000152970411914304369860000014190431337399607991_">
                                            <use xlink:href="#SVGID_00000117677133036266311380000006590335911856890520_"
                                                 style="overflow:visible;"/>
                                        </clipPath>

                                        <image style="overflow:visible;clip-path:url(#SVGID_00000152970411914304369860000014190431337399607991_);"
                                               width="591" height="623" xlink:href="628E65E4ED2B38AC.jpg">
                                        </image>
                                    </g>
                                </g>
                                <g class="st0">
                                    <defs>
                                        <rect id="SVGID_00000111911791011236852220000007369919026054710950_" x="537.2"
                                              y="28" width="39.6" height="115.3"/>
                                    </defs>

                                    <use xlink:href="#SVGID_00000111911791011236852220000007369919026054710950_"
                                         style="display:inline;overflow:visible;fill-rule:evenodd;clip-rule:evenodd;"/>
                                    <clipPath id="SVGID_00000044859163894284082110000010454701709064875904_"
                                              class="st1">
                                        <use xlink:href="#SVGID_00000111911791011236852220000007369919026054710950_"
                                             style="overflow:visible;"/>
                                    </clipPath>
                                    <g style="display:inline;clip-path:url(#SVGID_00000044859163894284082110000010454701709064875904_);">
                                        <defs>
                                            <rect id="SVGID_00000027603054081953762510000016344227644069287812_"
                                                  width="591" height="623"/>
                                        </defs>
                                        <use xlink:href="#SVGID_00000027603054081953762510000016344227644069287812_"
                                             style="overflow:visible;"/>
                                        <clipPath id="SVGID_00000129899242864078639920000002167425238115697057_">
                                            <use xlink:href="#SVGID_00000027603054081953762510000016344227644069287812_"
                                                 style="overflow:visible;"/>
                                        </clipPath>

                                        <image style="overflow:visible;clip-path:url(#SVGID_00000129899242864078639920000002167425238115697057_);"
                                               width="591" height="623" xlink:href="628E65E4ED2B38AB.jpg">
                                        </image>
                                    </g>
                                </g>
                                <g class="st0">
                                    <polygon class="st8" points="383.8,344.8 383.8,260.5 327.1,344.8 	"/>
                                    <path class="st8"
                                          d="M284.6,342.3l-1.8,2.6v41.4h0.8c2.5-7.6,3.8-15.7,3.8-24.4C287.4,354.9,286.5,348.4,284.6,342.3z"/>
                                    <path class="st8" d="M282.8,344.9l1.8-2.6c-2.1-6.8-5.4-13-9.9-18.6c-8.5-10.5-19.8-17.3-33.9-20.4c23.7-12.9,35.5-30.2,35.5-51.8
		c0-15.3-5.8-28.9-17.3-41c-14-14.8-32.6-22.2-55.9-22.2c-13.6,0-25.8,2.6-36.8,7.7c-10.9,5.1-19.5,12.1-25.6,21
		c-6.1,8.9-10.7,20.8-13.7,35.7l43.6,7.4c1.2-10.8,4.7-19,10.4-24.6c5.7-5.6,12.6-8.4,20.7-8.4c8.2,0,14.7,2.5,19.7,7.4
		c4.9,4.9,7.4,11.6,7.4,19.9c0,9.8-3.4,17.6-10.1,23.5c-6.7,5.9-16.5,8.7-29.3,8.3l-5.2,38.5c8.4-2.4,15.6-3.5,21.7-3.5
		c9.2,0,17,3.5,23.4,10.4c6.4,7,9.6,16.4,9.6,28.3c0,12.6-3.3,22.5-10,29.9c-6.7,7.4-14.9,11.1-24.7,11.1c-9.1,0-16.8-3.1-23.2-9.3
		c-6.4-6.2-10.3-15.1-11.8-26.7l-45.8,5.6c2.4,20.7,10.9,37.5,25.6,50.4c14.7,12.8,33.2,19.3,55.5,19.3c23.6,0,43.2-7.6,59.1-22.9
		c9.5-9.2,16.1-19.5,19.9-31h-0.8V344.9z"/>
                                    <path class="st8" d="M429.5,344.8V188.3h-39.7l-105.2,154c1.9,6.1,2.8,12.6,2.8,19.6c0,8.6-1.3,16.8-3.8,24.4h100.1V436h45.8v-49.6
		h30.6v-41.6H429.5z M383.8,344.8h-56.7l56.7-84.3V344.8z"/>
                                </g>
                                <image style="display:none;overflow:visible;" width="591" height="623"
                                       xlink:href="628E65E4ED2B38A5.jpg" transform="matrix(1 0 0 1 -467.4586 -83.2565)">
                                </image>
                                <g class="st0">
                                    <polygon class="st8" points="-83.7,261.5 -83.7,177.2 -140.4,261.5 	"/>
                                    <path class="st8"
                                          d="M-182.9,259.1l-1.8,2.6v41.4h0.8c2.5-7.6,3.8-15.7,3.8-24.4C-180,271.7-181,265.1-182.9,259.1z"/>
                                    <path class="st8" d="M-184.7,261.7l1.8-2.6c-2.1-6.8-5.4-13-9.9-18.6c-8.5-10.5-19.8-17.3-33.9-20.4c23.7-12.9,35.5-30.2,35.5-51.8
		c0-15.3-5.8-28.9-17.3-41c-14-14.8-32.6-22.2-55.9-22.2c-13.6,0-25.8,2.6-36.8,7.7c-10.9,5.1-19.5,12.1-25.6,21
		c-6.1,8.9-10.7,20.8-13.7,35.7l43.6,7.4c1.2-10.8,4.7-19,10.4-24.6c5.7-5.6,12.6-8.4,20.7-8.4c8.2,0,14.7,2.5,19.7,7.4
		c4.9,4.9,7.4,11.6,7.4,19.9c0,9.8-3.4,17.6-10.1,23.5c-6.7,5.9-16.5,8.7-29.3,8.3l-5.2,38.5c8.4-2.4,15.6-3.5,21.7-3.5
		c9.2,0,17,3.5,23.4,10.4c6.4,7,9.6,16.4,9.6,28.3c0,12.6-3.3,22.5-10,29.9c-6.7,7.4-14.9,11.1-24.7,11.1c-9.1,0-16.8-3.1-23.2-9.3
		c-6.4-6.2-10.3-15.1-11.8-26.7l-45.8,5.6c2.4,20.7,10.9,37.5,25.6,50.4c14.7,12.8,33.2,19.3,55.5,19.3c23.6,0,43.2-7.6,59.1-22.9
		c9.5-9.2,16.1-19.5,19.9-31h-0.8V261.7z"/>
                                    <path class="st8" d="M-37.9,261.5V105.1h-39.7l-105.2,154c1.9,6.1,2.8,12.6,2.8,19.6c0,8.6-1.3,16.8-3.8,24.4h100.1v49.6h45.8
		v-49.6h30.6v-41.6H-37.9z M-83.7,261.5h-56.7l56.7-84.3V261.5z"/>
                                </g>
                                <g>
                                    <path class="st9" d="M433.2,342V185.6h-39.7l-105.2,154c-2.1-6.8-5.4-13-9.9-18.6c-8.5-10.5-19.8-17.3-33.9-20.4
		c23.7-12.9,35.5-30.2,35.5-51.8c0-15.3-5.8-28.9-17.3-41c-14-14.8-32.6-22.2-55.9-22.2c-13.6,0-25.8,2.6-36.8,7.7
		c-10.9,5.1-19.5,12.1-25.6,21c-6.1,8.9-10.7,20.8-13.7,35.7l43.6,7.4c1.2-10.8,4.7-19,10.4-24.6c5.7-5.6,12.6-8.4,20.7-8.4
		c8.2,0,14.7,2.5,19.7,7.4c4.9,4.9,7.4,11.6,7.4,19.9c0,9.8-3.4,17.6-10.1,23.5c-6.7,5.9-16.5,8.7-29.3,8.3l-5.2,38.5
		c8.4-2.4,15.6-3.5,21.7-3.5c9.2,0,17,3.5,23.4,10.4c6.4,7,9.6,16.4,9.6,28.3c0,12.6-3.3,22.5-10,29.9c-6.7,7.4-14.9,11.1-24.7,11.1
		c-9.1,0-16.8-3.1-23.2-9.3c-6.4-6.2-10.3-15.1-11.8-26.7l-45.8,5.6c2.4,20.7,10.9,37.5,25.6,50.4c14.7,12.8,33.2,19.3,55.5,19.3
		c23.6,0,43.2-7.6,59.1-22.9c9.5-9.2,16.1-19.5,19.9-31h100.1v49.6h45.8v-49.6h30.6V342H433.2z M387.4,342h-56.7l56.7-84.3V342z"/>
                                    <polygon class="st9"
                                             points="60.5,27.7 11.8,27.7 11.8,76.5 11.8,143.6 60.5,143.6 60.5,76.5 127.7,76.5 127.7,27.7 	"/>
                                    <polygon class="st9"
                                             points="577.1,76.5 577.1,27.7 528.4,27.7 461.3,27.7 461.3,76.5 528.4,76.5 528.4,143.6 577.1,143.6 	"/>
                                    <polygon class="st9"
                                             points="528.4,592.8 577.1,592.8 577.1,544 577.1,476.9 528.4,476.9 528.4,544 461.3,544 461.3,592.8 	"/>
                                    <polygon class="st9"
                                             points="11.8,544 11.8,592.8 60.5,592.8 127.7,592.8 127.7,544 60.5,544 60.5,476.9 11.8,476.9 	"/>
                                </g>
</svg>

                        </div>
                    </a>
                </div>
                <ul class="social">
                    <li><a href="https://www.instagram.com/gotobelarus/" class="icon-instagram inst-mobile" target="_blank"></a></li>
                </ul>
                <div class="search-box">
                    <button type="button" class="open-search"></button>
                </div>
                <a href="/" class="link-34travel"></a>
                <?php $this->renderPartial('/layouts/_search_form') ?>
            </div>
            <nav>
                <?php $this->widget('application.widgets.GtbRubricsMenu'); ?>
            </nav>
        </div>
    </header>

    <main>
        <?php if (!empty($this->topImage) && !empty($this->topTitle)) { ?>
            <div class="f-width-box super-post full-height">
                <div class="super-post-wrap" style="background-image: url('<?= CHtml::encode($this->topImage) ?>')">
                    <div class="post-descr">
                        <h2 class="post-title"><?= $this->topTitle ?></h2>
                        <a href="<?= $this->topLink ?>" class="go-article"></a>
                    </div>
                </div>
            </div>
        <?php } ?>

        <?= $content ?>
    </main>
    <div id="indent"></div>
</div>

<footer>
    <div class="container">
        <a href="" class="logo">

        </a>
        <div class="footer-content">
            <ul class="footer-nav footer-list">
                <?= BlocksHelper::get('gtb_footer_pages' . ($app_lang != 'ru' ? '_' . $app_lang : '')) ?>
            </ul>
            <ul class="social-links footer-list">
                <li>
                    <p class="title">
                        <svg width="22" height="21" viewBox="0 0 22 21" fill="none">
                            <path d="M21.8873 7.95257C21.6722 7.25917 21.2421 6.70449 20.5969 6.3809C19.7844 5.96485 18.8285 6.01106 18.1594 6.12663L16.7494 1.36522C16.6538 1.04163 16.391 0.787429 16.0564 0.718089C15.7219 0.648748 15.3634 0.741247 15.1244 0.995496C11.7071 4.69366 10.2972 5.59504 6.52147 7.18987L3.55822 8.02198C0.953435 8.76161 -0.552077 11.4197 0.188733 13.9391C0.54719 15.1641 1.38358 16.2042 2.55454 16.8282C3.29535 17.2212 4.10786 17.4291 4.92036 17.4291C5.30271 17.4291 5.70897 17.383 6.09132 17.2905L6.40198 18.3768C6.56926 18.9546 6.90382 19.4631 7.33396 19.8792L7.83581 20.3414C8.02699 20.5032 8.26596 20.5957 8.50493 20.5957C8.7678 20.5957 9.00677 20.5032 9.19795 20.3183C9.55641 19.9485 9.55641 19.3707 9.15015 19.0009L8.64831 18.5386C8.45713 18.3537 8.31376 18.1226 8.24207 17.8684L7.93139 16.782L9.31744 16.389C13.2844 15.8112 15.0766 15.8574 19.9277 17.198C20.0233 17.2211 20.095 17.2442 20.1906 17.2442C20.4296 17.2442 20.6925 17.1517 20.8597 16.9668C21.0987 16.7357 21.1943 16.389 21.0987 16.0654L19.6888 11.3272C20.3101 11.096 21.1465 10.68 21.6245 9.91722C22.0068 9.33938 22.1024 8.66909 21.8873 7.95257ZM3.51042 15.2333C2.79351 14.8635 2.29168 14.2164 2.05271 13.4768C1.59866 11.9051 2.53064 10.2871 4.10785 9.82479L6.25859 9.22381L7.23838 12.5753L7.9075 14.8866L5.75676 15.4876C5.01595 15.6956 4.20344 15.6031 3.51042 15.2333ZM13.2366 14.2164C12.1612 14.2164 11.0858 14.3088 9.81927 14.4706L8.43324 9.73236L8.09867 8.57668C11.1575 7.2361 12.7825 6.19597 15.4351 3.46857L18.8285 15.0022C16.5344 14.4475 14.9094 14.2164 13.2366 14.2164ZM20.0233 8.96966C19.88 9.2239 19.5215 9.40881 19.1869 9.54749L18.709 7.92955C19.0675 7.88332 19.4737 7.8833 19.7366 8.02198C19.8561 8.09132 19.9756 8.18373 20.0711 8.43798C20.1428 8.71534 20.0711 8.85409 20.0233 8.96966ZM13.9774 7.44414C14.2402 7.81396 14.1685 8.32243 13.7862 8.57668C12.902 9.17763 11.8983 9.70924 11.8505 9.73236C11.731 9.8017 11.5877 9.82479 11.4682 9.82479C11.1575 9.82479 10.8707 9.66302 10.7274 9.38565C10.5123 8.99272 10.6796 8.50729 11.0858 8.29927C11.0858 8.29927 12.0417 7.81391 12.8064 7.2823C13.1649 6.98183 13.6906 7.07433 13.9774 7.44414Z" fill="black"></path>
                        </svg>
                        <?= Yii::t('app', 'Social') ?> 34travel
                    </p>
                </li>
                <?= BlocksHelper::get('gtb_social') ?>
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
                    <a href="/gotoukraine" target="_blank">
                        <span>GO TO UKRAINE!</span>
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
                <?= BlocksHelper::get('gtb_footer_contacts') ?>
            </div>
            <div class="reprint-rules">
                <?= BlocksHelper::get('gtb_footer_text' . ($app_lang != 'ru' ? '_' . $app_lang : '')) ?>
            </div>
        </div>
    </div>
</footer>

<?= BlocksHelper::get('footer_code') ?>

</body>
</html>
