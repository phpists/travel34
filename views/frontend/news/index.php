<?php
/* @var $this NewsController */
/* @var $models Post[] */
/* @var $pagination CPagination */
/* @var $newsBanner Banner */

/* @var $sorted_models Post[][] */
$sorted_models = [];
foreach ($models as $model) {
    $month = Yii::app()->locale->getMonthName(date('n', strtotime($model->date)), 'wide', true) . ' ' . date('Y', strtotime($model->date));
    $sorted_models[$month][] = $model;
}

$index = 0;
?>

<div class="b-main">
    <div class="b-main__months">
        <?php foreach ($sorted_models as $month => $month_models): ?>
            <div class="b-main__month">
                <h2><?= $month ?></h2>
                <div class="b-main__list b-main__list__top">
                    <?php
                    if ($index == 0 && $pagination->currentPage == 0 && $newsBanner !== null) {
                        echo '<div class="banner-new">' . BannerHelper::getHtml($newsBanner) . '</div>';
                    }
                    ?>
                    <ul class="news-list">
                        <?php foreach ($month_models as $post): ?>
                            <li>
                                <div class="b-main__list__image">
                                    <a href="<?= $post->getUrl() ?>">
                                        <img src="<?= $post->getImageUrl('image_news') ?>" alt="" width="60" height="60">
                                    </a>
                                </div>
                                <a href="<?= $post->getUrl() ?>" class="b-main__list__link">
                                    <time datetime="<?= date('c', strtotime($post->date)) ?>"><?= date('j.m', strtotime($post->date)) ?></time><?= $post->title ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    <br class="clearfloat">
                </div>
            </div>
            <?php
            $index++;
        endforeach; ?>
    </div>
    <div style="margin-top: 90px">
        <?php $this->widget('application.widgets.SitePager', array(
            'showMoreText' => 'Показать еще',
            'pages' => $pagination,
        )); ?>
    </div>
</div>
