<?php
/* @var $this SiteController */
/* @var $firstHomeTopPost Post */
/* @var $otherHomeTopPosts Post[] */
/* @var $resultPostsList Post[] */
/* @var $showMore bool */
/* @var $counters array */

$this->pageTitle = Yii::app()->name . ' – журнал о новой культуре путешествий';

$this->bodyClasses[] = 'index-page';
?>

<?php $this->renderPartial('_posts', array(
    'firstHomeTopPost' => $firstHomeTopPost,
    'otherHomeTopPosts' => $otherHomeTopPosts,
    'resultPostsList' => $resultPostsList,
    'showMore' => $showMore,
    'counters' => $counters,
)); ?>
