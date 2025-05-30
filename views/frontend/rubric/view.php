<?php
/* @var $this RubricController */
/* @var $model Rubric */
/* @var $dataProvider CActiveDataProvider */

/* @var $posts Post[] */
$posts = $dataProvider->getData();

$pagination = $dataProvider->getPagination();

$this->setPageTitle(Yii::app()->name . ' - ' . $model->title);

/** @var CClientScript $cs */
$cs = Yii::app()->clientScript;
?>

<div class="b-main b-list-posts">
    <h1 class="b-post__title">#<?php echo $model->title; ?></h1>
    <div class="b-news__short__list">
        <?php
        foreach ($posts as $post) {
            $this->renderPartial('//site/_post_simple', array('post' => $post));
        }
        ?>
    </div>
    <?php $this->widget('application.widgets.SitePager', array(
        'showMoreText' => 'Показать еще',
        'pages' => $pagination,
    )); ?>
</div>