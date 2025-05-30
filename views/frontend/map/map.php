<?php
/** @var string $url */
/** @var float $lat */
/** @var float $lng */

$cs = Yii::app()->clientScript;
$themeUrl = Yii::app()->theme->baseUrl;

$cs->registerScriptFile(Common::assetsTime($themeUrl . '/js/vendor.js'));
$cs->registerScriptFile(Common::assetsTime($themeUrl . '/js/leaflet.js'));
$cs->registerScriptFile(Common::assetsTime('https://cdnjs.cloudflare.com/ajax/libs/leaflet.markercluster/1.4.1/leaflet.markercluster.js'));
$cs->registerScriptFile(Common::assetsTime($themeUrl . '/js/L.Control.Locate.min.js'));
$cs->registerScriptFile(Common::assetsTime($themeUrl . '/js/swiper.min.js'));
$cs->registerScriptFile(Common::assetsTime($themeUrl . '/js/map.js'));

$cs->registerCssFile(Common::assetsTime($themeUrl . '/css/map/leaflet.css'));
$cs->registerCssFile(Common::assetsTime($themeUrl . '/css/map/L.Control.Locate.css'));
$cs->registerCssFile(Common::assetsTime($themeUrl . '/css/map/MarkerCluster.css'));
$cs->registerCssFile(Common::assetsTime($themeUrl . '/css/map/MarkerCluster.Default.css'));
$cs->registerCssFile(Common::assetsTime($themeUrl . '/css/map/map.css'));

?>

<div class="container">
    <div class="map-filter-box">
        <form action="" class="filter-form">
            <p class="title"><!--НА <МАПЕ--><?= Yii::t('app', 'On map')?>:</p>


            <?php foreach (GtuPlace::getTypeOptions() as $type => $label): ?>
                <div class="check-box">
                <input type="checkbox" id="cb-<?= $type ?>" data-type="<?= $type ?>">
                <label for="cb-<?= $type ?>">
                    <div class="icon">
                        <svg width="22" height="36" viewBox="0 0 22 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect width="22" height="25" rx="3" fill="<?= GtuPlace::getTypeColor($type) ?>"/>
                            <path d="M11 36L7.5359 24.75L14.4641 24.75L11 36Z" fill="<?= GtuPlace::getTypeColor($type) ?>"/>
                            <path d="M11 5L12.5716 9.83688H17.6574L13.5429 12.8262L15.1145 17.6631L11 14.6738L6.8855 17.6631L8.4571 12.8262L4.3426 9.83688H9.4284L11 5Z"
                                  fill="#CFBB75"/>
                        </svg>
                    </div>
                    <span class="text"><?= $label ?></span>
                </label>
            </div>
            <?php endforeach; ?>

            <div class="check-box">
                <input type="checkbox" id="cb4" data-type="">
                <label for="cb4">
                    <div class="icon">
                        <svg width="30" height="36" viewBox="0 0 30 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="8" width="22" height="25" rx="3" fill="#739B53"/>
                            <path d="M19 36L15.5359 24.75L22.4641 24.75L19 36Z" fill="#739B53"/>
                            <path d="M19 5L20.5716 9.83688H25.6574L21.5429 12.8262L23.1145 17.6631L19 14.6738L14.8855 17.6631L16.4571 12.8262L12.3426 9.83688H17.4284L19 5Z"
                                  fill="white"/>
                            <rect x="4" width="22" height="25" rx="3" fill="#A89016"/>
                            <path d="M15 36L11.5359 24.75L18.4641 24.75L15 36Z" fill="#A89016"/>
                            <path d="M15 5L16.5716 9.83688H21.6574L17.5429 12.8262L19.1145 17.6631L15 14.6738L10.8855 17.6631L12.4571 12.8262L8.3426 9.83688H13.4284L15 5Z"
                                  fill="white"/>
                            <rect width="22" height="25" rx="3" fill="black"/>
                            <path d="M11 36L7.5359 24.75L14.4641 24.75L11 36Z" fill="black"/>
                            <path d="M11 5L12.5716 9.83688H17.6574L13.5429 12.8262L15.1145 17.6631L11 14.6738L6.8855 17.6631L8.4571 12.8262L4.3426 9.83688H9.4284L11 5Z"
                                  fill="#CFBB75"/>
                        </svg>
                    </div>
                    <span class="text"><!--Усе <месцы--><?= Yii::t('app', 'All places')?></span>
                </label>
            </div>
        </form>
    </div>
</div>
<div class="map-box">
    <div id="map" data-url="<?= $url ?>" data-lat="<?= $lat ?>" data-lng="<?= $lng ?>"></div>
</div>

