<?php
/* @var $this SettingController */
/* @var $model Setting */

$this->pageTitle = 'Настройки';
$this->breadcrumbs = [
    'Настройки',
];
$this->menu = [
    ['label' => 'Добавить настройку', 'url' => ['create']],
];
?>

<h1><?= $this->pageTitle ?></h1>

<?php
$this->widget('bootstrap.widgets.TbExtendedGridView', [
    'id' => 'setting-grid',
    'type' => 'striped bordered',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => [
        [
            'name' => 'id',
            'headerHtmlOptions' => ['style' => 'text-align: center; width: 30px'],
            'htmlOptions' => ['style' => 'text-align: center'],
        ],
        'name',
        [
            'name' => 'description',
            'value' => function($data) {
                return mb_strimwidth($data->description, 0, 200, '...');
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

