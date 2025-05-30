<?php
/** @var $this GtuController */
/** @var $posts GtuPost[] */
/** @var $show_more bool */
/** @var $counters int */
/** @var $post_id int */
?>

<div class="articles-grid">
    <div class="container post-container">
        <p class="articles-box-title"><?= Yii::t('app', 'On the main page') ?>:</p>
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
                }
            }
            ?>
        </div>
    </div>
</div>

<?php
if ($show_more):
    $url = $this->createUrl('/gtu/moreAdditional', [
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
