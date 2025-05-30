<?php
/** @var $this GtbController */
/** @var $supertop_post GtbPost */
/** @var $home_top_post GtbPost */
/** @var $posts GtbPost[]|GtbBanner[] */
/** @var $show_more bool */
/** @var $counters array */

if ($home_top_post !== null) {
    $this->renderPartial('_post_big_top', array('post' => $home_top_post));
}
?>

<div class="container post-container">
    <div class="post-grid">
        <?php
        foreach ($posts as $post) {
            if (get_class($post) == 'GtbPost') {
                if ($post->display_as_big) {
                    echo '</div></div>';
                    $this->renderPartial('_post_big_top', array('post' => $post));
                    echo '<div class="container post-container"><div class="post-grid">';
                } elseif ($post->is_top == 1) {
                    $this->renderPartial('_post_top', ['post' => $post]);
                } else {
                    $this->renderPartial('_post', ['post' => $post]);
                }
            } elseif (get_class($post) == 'GtbBanner') {
                if ($post->banner_place_id == GtbBanner::PLACE_GTB_HOME_SMALL_POST) {
                    ?>
                    <div class="post-item small-width banner-item equal">
                        <a href="<?= $post->url ?>"<?php if ($post->open_new_tab == 1): ?> target="_blank"<?php endif; ?>>
                            <img src="<?= $post->getImageUrl('image') ?>" alt="">
                        </a>
                    </div>
                    <?php
                } elseif ($post->banner_place_id == GtbBanner::PLACE_GTB_HOME_FULL_WIDTH) {
                    echo '</div></div>';
                    ?>
                    <div class="f-width-box banner-box">
                        <a href="<?= $post->url ?>"<?php if ($post->open_new_tab == 1): ?> target="_blank"<?php endif; ?>>
                            <img src="<?= $post->getImageUrl('image') ?>" alt="">
                            <?php if (!empty($post->image_mobile)): ?><img src="<?= $post->getImageUrl('image_mobile') ?>" class="banner-mob" alt=""><?php endif; ?>
                        </a>
                    </div>
                    <?php
                    echo '<div class="container post-container"><div class="post-grid">';
                }
            }
        }
        ?>
    </div>
</div>

<?php
if ($show_more):
    $url = $this->createUrl('/gtb/more', ['excluded' => $counters['excluded'], 'otherCount' => $counters['other'], 'topCount' => $counters['top']]);
    ?>
    <div class="b-nav">
        <div class="b-nav__more">
            <a href="#" class="show-more-gtb-home-posts" data-url="<?= $url ?>">
                <span><?= Yii::t('app', 'Show more') ?></span>
            </a>
            <span class="more-waiting btn-waiting">
                <span><?= Yii::t('app', 'Show more') ?></span>
            </span>
        </div>
    </div>
<?php endif; ?>
