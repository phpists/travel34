<?php
/* @var $this BlockAfterPostController */
/* @var $model BlockAfterPost */

$this->pageTitle = 'Блок под постом';
$this->breadcrumbs = [
    'Блок под постом',
];
$this->menu = [
    ['label' => 'Добавить блок', 'url' => ['create']],
];
?>

    <h1><?= $this->pageTitle ?></h1>

<?php
$this->widget('bootstrap.widgets.TbExtendedGridView', [
    'id' => 'block-after-post-grid',
    'type' => 'striped bordered',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => [
        [
            'name' => 'id',
            'headerHtmlOptions' => ['style' => 'text-align: center; width: 30px'],
            'htmlOptions' => ['style' => 'text-align: center'],
        ],
        'title',
        'text',
        [
            'name' => 'button_url',
            'type' => 'raw',
            'value' => static function (BlockAfterPost $data) {
                return CHtml::link($data->button_url, $data->button_url, ['target' => '_blank']);
            },
        ],
        'button_text',

        [
            'class' => 'bootstrap.widgets.TbButtonColumn',
            'htmlOptions' => ['style' => 'width: 50px'],
            'template' => '{update}{delete}',
        ],
    ],
]);