<?php
/* @var $this CityController */
/* @var $model City */

$this->pageTitle = 'Города';
$this->breadcrumbs = [
    'Города',
];
$this->menu = [
    ['label' => 'Добавить город', 'url' => ['create']],
];
?>

<h1><?= $this->pageTitle ?></h1>

<?php
$this->widget('bootstrap.widgets.TbExtendedGridView', [
    'id' => 'city-grid',
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
        [
            'name' => 'world_part_id',
            'filter' => City::getWorldPartOptions(),
            'value' => function ($data) {
                /** @var City $data */
                $options = City::getWorldPartOptions();
                return isset($options[$data->world_part_id]) ? $options[$data->world_part_id] : '';
            },
        ],
        'url',
        [
            'class' => 'bootstrap.widgets.TbButtonColumn',
            'htmlOptions' => ['style' => 'width: 50px'],
            'template' => '{update}{delete}',
        ],
    ],
]);
?>
