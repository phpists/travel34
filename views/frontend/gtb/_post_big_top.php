<?php
/** @var $this GtbController */
/* @var $post GtbPost */

$img = $post->getImageUrl('image_big_top');
if (empty($img)) {
    $img = $post->getImageUrl('image_supertop');
}
if (empty($img)) {
    $img = $post->getImageUrl('image');
}
?>
<div class="f-width-box">
    <a href="<?= $post->getUrl() ?>" style="background-image: url('<?= $img ?>')">
        <div class="post-descr">
            <?= !empty($post->gtbRubric) ? '<h3 class="post-category">' . $post->gtbRubric->getTitle() . '</h3>' : '' ?>
            <h2 class="post-title"><?= CHtml::encode($post->title) ?></h2>
        </div>
    </a>
</div>
