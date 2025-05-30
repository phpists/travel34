<?php
/* @var $this GtuController */
/* @var $model GtuRubric */
/* @var $dataProvider CActiveDataProvider */

/* @var $posts GtuPost[] */
$posts = $dataProvider->getData();

$pagination = $dataProvider->getPagination();
//$pagination = new CPagination(500);

$title = $model->getTitle();
$this->setPageTitle($title);

/** @var CClientScript $cs */
$cs = Yii::app()->clientScript;

//$this->bodyClasses[] = 'inner';
?>

<div class="articles-box">
    <div class="articles-grid">
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
    </div>

    <div class="pager pager-desktop">
        <?php $this->widget('application.widgets.GtuPager', array(
            'pages' => $pagination,
        )); ?>
    </div>
    <div class="pager pager-tablet">
        <?php $this->widget('application.widgets.GtuPager', array(
            'pages' => $pagination,
            'maxButtonCount' => 3,
        )); ?>
    </div>
    <div class="pager pager-mob">
        <?php $this->widget('application.widgets.GtuPager', array(
            'pages' => $pagination,
            'maxButtonCount' => 1,
        )); ?>
    </div>
</div>
