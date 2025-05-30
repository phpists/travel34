<?php
/* @var $this GtbController */
/* @var $model GtbRubric */
/* @var $dataProvider CActiveDataProvider */

/* @var $posts GtbPost[] */
$posts = $dataProvider->getData();

$pagination = $dataProvider->getPagination();
//$pagination = new CPagination(500);

$title = $model->getTitle();
$this->setPageTitle($title);

/** @var CClientScript $cs */
$cs = Yii::app()->clientScript;

//$this->bodyClasses[] = 'inner';
?>

<div class="container post-container">
    <h1 class="b-post__title">#<?= $title ?></h1>
    <div class="post-grid">
        <?php
        foreach ($posts as $post) {
            $this->renderPartial('_post', ['post' => $post]);
        }
        ?>
    </div>
</div>

<div class="pager pager-desktop">
    <?php $this->widget('application.widgets.GtbPager', array(
        'pages' => $pagination,
    )); ?>
</div>
<div class="pager pager-tablet">
    <?php $this->widget('application.widgets.GtbPager', array(
        'pages' => $pagination,
        'maxButtonCount' => 3,
    )); ?>
</div>
<div class="pager pager-mob">
    <?php $this->widget('application.widgets.GtbPager', array(
        'pages' => $pagination,
        'maxButtonCount' => 1,
    )); ?>
</div>
