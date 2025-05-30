<?php
/** @var $this PostController */
/** @var $relatedPosts Post[] */
if (count($relatedPosts) == 0) {
    return;
}
?>
<div class="b-main additional-posts">
    <h2 class="add-title"><?= Yii::t('app', 'Read more') ?></h2>
    <div class="b-news__short__list">
        <?php
        foreach ($relatedPosts as $post) {
            echo $this->renderPartial('//site/_post_simple', array('post' => $post));
        }
        ?>
    </div>
</div>
