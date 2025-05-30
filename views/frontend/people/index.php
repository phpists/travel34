<?php
/* @var $this PeopleController */
/* @var $dataProvider CActiveDataProvider */

/* @var $posts Post[] */
$posts = $dataProvider->getData();

$pagination = $dataProvider->getPagination();
?>
<div class="b-main b-list-posts">
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