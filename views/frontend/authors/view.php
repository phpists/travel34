<?php
/* @var $this AuthorsController */
/* @var $author Author */
/* @var $dataProvider CActiveDataProvider */

/* @var $posts Post[] */
$posts = $dataProvider->getData();

$pagination = $dataProvider->getPagination();

if (!empty($author->page_title)) {
    $this->setPageTitle($author->page_title);
} else {
    $this->setPageTitle(Yii::app()->name . ' - ' . $author->title);
}
if (!empty($author->page_description)) {
    $this->setMetaDescription($author->page_description);
}
?>

<div class="b-main b-list-posts">
    <h1 class="b-post__title">@ <?php echo CHtml::encode($author->title) ?></h1>
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