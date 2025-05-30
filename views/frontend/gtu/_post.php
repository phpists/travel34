<?php
/** @var $this GtuController */
/* @var $post GtuPost */
?>
<div class="post-item small-width equal">
    <a href="<?= $post->getUrl() ?>">
        <div class="img-wrap">
            <img src="<?= !empty($post->image_top) ? $post->getImageUrl('image_top') : $post->getImageUrl('image') ?>" alt="" class="medium-img">
            <img src="<?= $post->getImageUrl('image') ?>" alt="" class="small-img">
        </div>
        <div class="post-short-info">
            <?= !empty($post->gtuRubric) ? '<h3 class="post-category">' . $post->gtuRubric->getTitle() . '</h3>' : '' ?>
            <h2 class="post-title"><span><?= CHtml::encode($post->title) ?></span></h2>
            <?= $post->summary ?>
        </div>
    </a>
</div>
