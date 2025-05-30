<?php
/** @var $this GtbController */
/** @var $posts GtbPost[] */
/** @var $show_more bool */
/** @var $counters int */
/** @var $post_id int */
?>
<div class="post-grid">
    <?php
    foreach ($posts as $post) {
        $this->renderPartial('_post', array('post' => $post));
    }
    ?>
</div>

<?php
if ($show_more):
    $url = $this->createUrl('/gtb/moreAdditional', [
        'otherCount' => $counters['other'],
        'topCount' => $counters['top'],
        'postId' => $post_id,
    ]);
    ?>
    <div class="b-nav">
        <div class="b-nav__more">
            <a href="#" class="show-more-gtb-posts" data-url="<?= $url ?>">
                <span><?= Yii::t('app', 'Show more') ?></span>
            </a>
            <span class="more-waiting btn-waiting">
                <span><?= Yii::t('app', 'Show more') ?></span>
            </span>
        </div>
    </div>
<?php endif; ?>
