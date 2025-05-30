<?php
/* @var $this GtuPlaceController */
/* @var $model GtuPlace */

$this->pageTitle = Yii::t('app', 'Places');
$this->breadcrumbs = [
    Yii::t('app', 'Places'),
];
$this->menu = [
    ['label' => Yii::t('app', 'Add Place'), 'url' => ['create']],
];

$now = Yii::app()->db->createCommand('SELECT NOW()')->queryScalar();
?>

<h1><?= $this->pageTitle ?> <small><?= $now ?></small></h1>

<?php
$this->widget('bootstrap.widgets.TbExtendedGridView', [
    'id' => 'gtu-post-grid',
    'type' => 'striped bordered',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => [
        [
            'name' => 'title',
            'type' => 'raw',

        ],
        'lat',
        'lng',
        [
            'name' => 'type',
            'filter' => GtuPlace::getTypeOptions(),
            'value' => function ($data) {
                /** @var $data GtuPost */
                $options = GtuPlace::getTypeOptions();
                return isset($options[$data->type]) ? $options[$data->type] : '';
            },
        ],
        [
            'name' => 'language',
            'filter' => Yii::app()->params[Yii::app()->controller->langs],
            'value' => function ($data) {
                $languages = Yii::app()->params[Yii::app()->controller->langs];
                return isset($languages[$data->language]) ? $languages[$data->language] : '';
            },
        ],
        [
            'name' => 'description',
        ],
        [
            'class' => 'bootstrap.widgets.TbButtonColumn',
            'htmlOptions' => ['style' => 'width: 30px; text-align: center'],
            'template' => '{update}',
        ],
        [
            'class' => 'bootstrap.widgets.TbButtonColumn',
            'htmlOptions' => ['style' => 'width: 30px; text-align: center'],
            'template' => '{delete}',
        ],
    ],
]);
?>
