<?php
/* @var $this SeoTagController */
/* @var $model SeoTag */

$this->pageTitle = 'SEO-теги';
$this->breadcrumbs = [
    'SEO-теги',
];
$this->menu = [
    ['label' => 'Добавить тег', 'url' => ['create']],
];
?>

<h1><?= $this->pageTitle ?></h1>

<?php
$this->widget('bootstrap.widgets.TbExtendedGridView', [
    'id' => 'seo-tag-grid',
    'type' => 'striped bordered',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => [
        [
            'name' => 'id',
            'headerHtmlOptions' => ['style' => 'text-align: center; width: 30px'],
            'htmlOptions' => ['style' => 'text-align: center'],
        ],
        'path',
        'title',
        'description',
        [
            'name' => 'image',
            'type' => 'raw',
            'value' => function ($data) {
                /** @var SeoTag $data */
                return !empty($data->image) ? CHtml::image(ResizeHelper::init()->image($data->getImageUrl('image'))->fit(120, 80)) : '';
            },
        ],
        [
            'class' => 'bootstrap.widgets.TbButtonColumn',
            'htmlOptions' => ['style' => 'width: 50px'],
            'template' => '{update}{delete}',
        ],
    ],
]);
?>
