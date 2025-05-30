<?php
/** @var $this GtbController */
/** @var $relatedPosts GtbPost[] */
if (count($relatedPosts) == 0) {
    return;
}
?>
<div class="b-main additional-posts post-container">
    <h2 class="add-title"><?= Yii::t('app', 'Read more') ?></h2>
    <div class="post-grid">
        <?php
        foreach ($relatedPosts as $post) {
            echo $this->renderPartial('_post', array('post' => $post));
        }
        ?>
    </div>
</div>
