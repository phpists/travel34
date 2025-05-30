<?php
/* @var $this CommentController */
/* @var $model Comment */

$this->pageTitle = 'Комментарии';
$this->breadcrumbs = [
    'Комментарии',
];
?>

<h1><?= $this->pageTitle ?></h1>

<?php
$this->widget('bootstrap.widgets.TbExtendedGridView', [
    'id' => 'comment-grid',
    'type' => 'striped bordered',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => [
        [
            'name' => 'id',
            'headerHtmlOptions' => ['style' => 'text-align: center; width: 30px'],
            'htmlOptions' => ['style' => 'text-align: center'],
        ],
        'created_at',
        'content',
        [
            'name' => 'post_title_search',
            'value' => function ($data) {
                /** @var Comment $data */
                return $data->post->title;
            },
        ],
        [
            'name' => 'post_url_search',
            'type' => 'raw',
            'value' => function ($data) {
                /** @var Comment $data */
                return CHtml::link($data->post->url, $data->post->getUrl(), ['target' => '_blank']);
            },
        ],
        'likes_count',
        'dislikes_count',
        [
            'name' => 'status_id',
            'class' => 'bootstrap.widgets.TbToggleColumn',
            'filter' => Comment::getStatusOptions(),
            'toggleAction' => 'toggle',
            'headerHtmlOptions' => ['style' => 'text-align: center; width: 150px'],
            'htmlOptions' => ['style' => 'text-align: center; width: 150px'],
            'uncheckedButtonLabel' => 'Отобразить текст',
            'checkedButtonLabel' => 'Скрыть текст',
        ],
        [
            'class' => 'bootstrap.widgets.TbButtonColumn',
            'htmlOptions' => ['style' => 'width: 50px'],
            'template' => '{update}{delete}',
        ],
    ],
]);
?>
