<?php
/* @var $this SearchController */
/* @var $results array */
/* @var $term string */
/* @var $total int */
/* @var $pagination CPagination */
/* @var $words array */
/* @var $banner Banner|array */

$this->setPageTitle(Yii::app()->name . ' - Поиск по сайту');
?>

<div class="b-main">
    <h1 class="b-search__title">Поиск по сайту</h1>
    <div class="b-search">
        <div class="b-search__form">
            <form action="<?= $this->createUrl('/search/results') ?>" method="get">
                <input type="text" name="text" value="<?= CHtml::encode($term) ?>" placeholder="" required>
                <button type="submit">Искать</button>
            </form>
        </div>

        <?php if ($total > 0): ?>
            <div class="b-search__result__number"><?= Yii::t('app', '{n} result|{n} results', $total) ?></div>
        <?php endif; ?>

        <?php if (!empty($term) && empty($yandex_search_id)): ?>

            <?php if (!empty($results)): ?>
                <div class="b-search__result">
                    <?php foreach ($results as $result):
                        if ($result['gtb']) {
                            $url = !empty($result['url']) ? Yii::app()->getBaseUrl(true) . '/gotobelarus/' . (!empty($result['language']) && $result['language'] == 'en' ? 'en/' : '') . 'post/' . $result['url'] : '#';
                        } elseif ($result['gtu']) {
                            $url = !empty($result['url']) ? Yii::app()->getBaseUrl(true) . '/gotoukraine/' . (!empty($result['language']) && $result['language'] != 'uk' ? $result['language'] . '/' : '') . 'post/' . $result['url'] : '#';
                        } else {
                            $url = !empty($result['url']) ? Yii::app()->getBaseUrl(true) . '/post/' . $result['url'] : '#';
                        }
                        ?>
                        <div class="b-search__result__single">
                            <h2><?= CHtml::link(SearchHelper::highlight($result['title'], $words, '<span class="b-search__result__word">$1</span>'), $url) ?></h2>
                            <div class="b-search__result__text">
                                <?= SearchHelper::highlightExcerpt(SearchHelper::cleanText($result['text']), $words, 180, '...', '...', '<span class="b-search__result__word">$1</span>') ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <?php $this->widget('application.widgets.SitePager', array(
                    'showMoreText' => 'Показать еще',
                    'pages' => $pagination,
                )); ?>

            <?php else: ?>
                <div class="b-search__result">
                    <div class="b-search__result__text">Поиск не дал результатов.</div>
                </div>
            <?php endif; ?>

        <?php endif; ?>

    </div>

    <div class="b-search__sidebar">
        <?php
        if ($banner !== null ) {
            echo '<div class="banner-new">' . BannerHelper::getHtml($banner) . '</div>';
        }
        ?>
    </div>

    <br class="clearfloat">
</div>