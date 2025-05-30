<?php
/** @var $this GtbController */
/* @var $post GtbPost */
?>
<div class="post-item medium-width equal">
    <a href="<?= $post->getUrl() ?>">
        <div class="img-wrap">
            <img src="<?= !empty($post->image_top) ? $post->getImageUrl('image_top') : $post->getImageUrl('image') ?>" alt="" class="medium-img">
            <img src="<?= $post->getImageUrl('image') ?>" alt="" class="small-img">
        </div>
        <div class="post-short-info">
            <?= !empty($post->gtbRubric) ? '<h3 class="post-category">' . $post->gtbRubric->getTitle() . '</h3>' : '' ?>
            <h2 class="post-title"><span><?= CHtml::encode($post->title) ?></span></h2>
            <?= $post->summary ?>
        </div>
    </a>
</div>
