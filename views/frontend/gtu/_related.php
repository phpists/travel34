<?php
/** @var $this GtuController */
/** @var $relatedPosts GtuPost[] */
if (count($relatedPosts) == 0) {
    return;
}
?>

<div class="sub-articles-box">
    <div class="container post-container">
        <p class="articles-box-title"><?= Yii::t('app', 'Read more') ?>:</p>
        <div class="post-grid">
            <?php
            foreach ($relatedPosts as $post) {
                echo $this->renderPartial('_post', ['post' => $post]);
            }
            ?>
        </div>
    </div>
</div>
