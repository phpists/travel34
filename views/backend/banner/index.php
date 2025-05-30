<?php
/* @var $this BannerController */
/* @var $model Banner */

$this->pageTitle = 'Баннеры';
$this->breadcrumbs = [
    'Баннеры',
];
$this->menu = [
    ['label' => 'Добавить баннер', 'url' => ['create']],
];
?>

<h1><?= $this->pageTitle ?></h1>

<?php
$this->widget('bootstrap.widgets.TbExtendedGridView', [
    'id' => 'banner-grid',
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
            'name' => 'banner_place_id',
            'filter' => Banner::getBannerPlaceOptions(),
            'value' => function ($data) {
                /** @var Banner $data */
                $options = Banner::getBannerPlaceOptions();
                return isset($options[$data->banner_place_id]) ? $options[$data->banner_place_id] : '';
            },
        ],
        [
            'name' => 'banner_system',
            'filter' => Banner::getBannerSystems(),
            'value' => function ($data) {
                /** @var Banner $data */
                $options = Banner::getBannerSystems();
                return isset($options[$data->banner_system]) ? $options[$data->banner_system] : '';
            },
        ],
        [
            'name' => 'geo_target',
            'filter' => false,
            'sortable' => false,
            'value' => function ($data) {
                /** @var Style $data */
                return $data->getGeoTargets();
            },
        ],
        [
            'name' => 'status_id',
            'class' => 'bootstrap.widgets.TbToggleColumn',
            'filter' => Banner::getStatusOptions(),
            'toggleAction' => 'toggle',
            'headerHtmlOptions' => ['style' => 'text-align: center; width: 150px'],
            'htmlOptions' => ['style' => 'text-align: center; width: 150px'],
            'uncheckedButtonLabel' => 'Разместить',
            'checkedButtonLabel' => 'Убрать',
        ],
        [
            'class' => 'bootstrap.widgets.TbButtonColumn',
            'htmlOptions' => ['style' => 'width: 50px'],
            'template' => '{update}{delete}',
        ],
    ],
]);
?>
