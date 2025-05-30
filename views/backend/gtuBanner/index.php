<?php
/* @var $this GtuBannerController */
/* @var $model GtuBanner */

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
            'filter' => GtuBanner::getBannerPlaceOptions(),
            'value' => function ($data) {
                /** @var GtuBanner $data */
                $options = GtuBanner::getBannerPlaceOptions();
                return isset($options[$data->banner_place_id]) ? $options[$data->banner_place_id] : '';
            },
        ],
        [
            'name' => 'language',
            'filter' => Yii::app()->params['gtuLanguages'],
            'value' => function ($data) {
                /** @var GtuBanner $data */
                $languages = Yii::app()->params['gtuLanguages'];
                return isset($languages[$data->language]) ? $languages[$data->language] : '';
            },
        ],
        [
            'name' => 'image',
            'type' => 'raw',
            'value' => function ($data) {
                /** @var GtuBanner $data */
                return !empty($data->image) ? CHtml::image(ResizeHelper::init()->image($data->getImageUrl('image'))->fit(120, 80)) : '';
            },
        ],
        [
            'name' => 'status_id',
            'class' => 'bootstrap.widgets.TbToggleColumn',
            'filter' => GtuBanner::getStatusOptions(),
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
