<?php
/** @var $this SiteController */
/** @var $firstHomeTopPost Post */
/** @var $otherHomeTopPosts Post[] */
/** @var $resultPostsList Post[]|object[] */
/** @var $showMore bool */
/** @var $counters array */

$col_count = 0;
$total_rows = Yii::app()->params['rowsPerHomePage'];

if ($firstHomeTopPost !== null) {
    $this->renderPartial('_post_home_top', array('post' => $firstHomeTopPost, 'hideViewCount' => true));
}

$scripts = [];
?>
<div class="b-main">
    <div class="b-news__short__list">
        <?php
        foreach ($resultPostsList as $post) {
            if ($col_count > 0 && $col_count % 12 == 0 && $col_count < $total_rows * 4) {
                echo '</div></div>';
                if ($col_count % 3 == 0 && !empty($otherHomeTopPosts)) {
                    $homeTopPost = reset($otherHomeTopPosts);
                    $k = key($otherHomeTopPosts);
                    $this->renderPartial('_post_home_top', array('post' => $homeTopPost, 'hideViewCount' => true));
                    unset($otherHomeTopPosts[$k]);
                }
                echo '<div class="b-main"><div class="b-news__short__list">';
            }
            if (get_class($post) == 'Post') {
                if ($post->is_small_top == Post::YES) {
                    $this->renderPartial('_post_small_top', array('post' => $post, 'hideViewCount' => true));
                    $col_count += 2;
                } else {
                    $this->renderPartial('_post_simple', array('post' => $post, 'hideViewCount' => true));
                    $col_count++;
                }
            } elseif ($post->type == 'news') {
                ?>
                <div class="b-news__short__block b-col__1 news-list">
                    <div class="b-main__list">
                        <ul>
                            <?php foreach ($post->value as $news) {
                                /** @var $news Post */
                                ?>
                                <li>
                                    <div class="b-main__list__image">
                                        <a href="<?= $news->getUrl() ?>">
                                            <img src="<?= $news->getImageUrl('image_news') ?>" alt="" title="" width="60" height="60">
                                        </a>
                                    </div>
                                    <a href="<?= $news->getUrl() ?>" class="b-main__list__link">
                                        <time datetime="<?= date('c', strtotime($news->date)) ?>"><?= date('j.m', strtotime($news->date)) ?></time><?= $news->title ?>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
                <?php
                $col_count++;
            } elseif ($post->type == 'banner') {
                $banner_content = $post->content;
                if (preg_match_all('/<script[\s\S]*?>[\s\S]*?<\/script>/i', $banner_content, $m)) {
                    foreach ($m[0] as $script) {
                        $scripts[] = $script;
                    }
                    $banner_content = preg_replace('/<script[\s\S]*?>[\s\S]*?<\/script>/i', '', $banner_content);
                }
                ?>
                <div class="b-news__short__block b-col__1 banner">
                    <div class="banner-new"><?= $banner_content ?></div>
                </div>
                <?php
                $col_count++;
            }
        }
        ?>
    </div>
    <?php if ($showMore):
        $url = $this->createUrl('/site/more', [
            'excluded' => $counters['excluded'],
            'newsCount' => $counters['news'],
            'otherCount' => $counters['other'],
            'smallTopCount' => $counters['smallTop'],
        ]);
        ?>
        <div class="b-nav">
            <div class="b-nav__more">
                <a href="#" class="show-more-home-posts" data-url="<?= $url ?>">
                    <span>Показать больше</span>
                </a>
                <span class="more-waiting btn-waiting">
                    <span>Показать больше</span>
                </span>
            </div>
        </div>
    <?php endif; ?>
</div>

<?= implode("\n", $scripts) ?>
