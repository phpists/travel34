<?php
/** @var $this GtuController */
/** @var $home_top_post GtuPost */
/** @var $posts GtuPost[]|object[] */
/** @var $show_more bool */
/** @var $counters array */

$this->setUrl($this->createAbsoluteUrl('index'));
?>

<div class="articles-box">
    <?php $this->renderPartial('_posts', array(
        'home_top_post' => $home_top_post,
        'posts' => $posts,
        'show_more' => $show_more,
        'counters' => $counters,
    )); ?>
</div>
