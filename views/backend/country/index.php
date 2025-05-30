<?php
/* @var $this CountryController */
/* @var $model Country */

$this->pageTitle = 'Страны';
$this->breadcrumbs = [
    'Страны',
];
$this->menu = [
    ['label' => 'Добавить страну', 'url' => ['create']],
];
?>

<h1><?= $this->pageTitle ?></h1>

<?php
$this->widget('bootstrap.widgets.TbExtendedGridView', [
    'id' => 'country-grid',
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
            'filter' => Country::getWorldPartOptions(),
            'value' => function ($data) {
                /** @var Country $data */
                $options = Country::getWorldPartOptions();
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
