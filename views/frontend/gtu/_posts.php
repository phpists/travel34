<?php
/** @var $this GtuController */
/** @var $supertop_post GtuPost */
/** @var $home_top_post GtuPost */
/** @var $posts GtuPost[]|GtuBanner[] */
/** @var $show_more bool */
/** @var $counters array */

?>

<div class="articles-grid">
    <?php
    if ($home_top_post !== null) {
        $this->renderPartial('_post_big_top', array('post' => $home_top_post));
    }
    ?>
    <div class="container post-container">
        <div class="post-grid">
            <?php
            foreach ($posts as $post) {
                if (get_class($post) == 'GtuPost') {
                    if ($post->display_as_big) {
                        echo '</div></div>';
                        $this->renderPartial('_post_big_top', array('post' => $post));
                        echo '<div class="container post-container"><div class="post-grid">';
                    } elseif ($post->is_top == 1) {
                        $this->renderPartial('_post_top', ['post' => $post]);
                    } else {
                        $this->renderPartial('_post', ['post' => $post]);
                    }
                } elseif (get_class($post) == 'GtuBanner') {
                    if ($post->banner_place_id == GtuBanner::PLACE_GTU_HOME_SMALL_POST) {
                        ?>
                        <div class="post-item small-width banner-item equal">
                            <a href="<?= $post->url ?>"<?php if ($post->open_new_tab == 1): ?> target="_blank"<?php endif; ?>>
                                <img src="<?= $post->getImageUrl('image') ?>" alt="">
                            </a>
                        </div>
                        <?php
                    } elseif ($post->banner_place_id == GtuBanner::PLACE_GTU_HOME_FULL_WIDTH) {
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
</div>

<?php
if ($show_more):
    $url = $this->createUrl('/gtu/more', [
        'excluded' => $counters['excluded'],
        'otherCount' => $counters['other'],
        'topCount' => $counters['top'],
    ]);
    ?>
    <a href="#" class="js-show-more-articles" data-url="<?= $url ?>">
        <svg width="36" height="19" viewBox="0 0 36 19" fill="none"><path fill-rule="evenodd" clip-rule="evenodd" d="M18.0377 11.5619L0.551025 0.48669L0.55094 7.5887L18.0377 18.6641L35.5244 7.58882L35.5244 0.486691L18.0377 11.5619Z" fill="black"></path></svg>
        <?= Yii::t('app', 'Show more') ?>
    </a>
<?php endif; ?>
