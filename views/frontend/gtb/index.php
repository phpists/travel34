<?php
/** @var $this GtbController */
/** @var $home_top_post GtbPost */
/** @var $posts GtbPost[]|object[] */
/** @var $show_more bool */
/** @var $counters array */

$this->setUrl($this->createAbsoluteUrl('index'));
?>

<?php $this->renderPartial('_posts', array(
    'home_top_post' => $home_top_post,
    'posts' => $posts,
    'show_more' => $show_more,
    'counters' => $counters,
)); ?>
