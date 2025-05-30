<?php
/* @var $this PromoCodeController */
/* @var $model PromoCode */

$this->pageTitle = 'Скидочные промокоды';
$this->breadcrumbs = [
    'Скидочные промокоды',
];
$this->menu = [
    ['label' => 'Создать скидочный промокод', 'url' => ['create']],
];
?>
<h1><?= $this->pageTitle ?></h1>
<?php
$this->widget('bootstrap.widgets.TbExtendedGridView', [
    'id' => 'block-grid',
    'type' => 'striped bordered',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => [
        'promo_code',
        [
            'name' => 'status_id',
            'value' => function ($data) {
                return $data->getStatus();
            },
        ],
        'date_create',
        [
            'name' => 'type_id',
            'value' => function ($data) {
                return PromoCode::getTypesId($data);
            },
        ],
        'date_create',
        [
            'name' => 'discount',
            'value' => function ($data) {
                return $data->discount . '%';
            },
        ],
        'number_activations',
        'available_activations',
        'date_active',
        [
            'class' => 'bootstrap.widgets.TbButtonColumn',
            'htmlOptions' => ['style' => 'width: 80px'],
            'template' => '{update}{delete}{pause}{restore}',
            'buttons' => [
                'update' => [
                    'url' => 'Yii::app()->createUrl("promoCode/update", ["id"=>$data->id])',
                ],
                'delete' => [
                    'url' => 'Yii::app()->createUrl("promoCode/delete", ["id"=>$data->id])',
                ],
                'pause' => [
                    'label' => 'Приостановить',
                    'icon' => 'pause',
                    'url' => 'Yii::app()->createUrl("promoCode/pause", ["id"=>$data->id])',
                    'visible' => '$data->status_id == 1',
                ],
                'restore' => [
                    'label' => 'Восстановить',
                    'icon' => 'play',
                    'url' => 'Yii::app()->createUrl("promoCode/restore", ["id"=>$data->id])',
                    'visible' => '$data->status_id == 2',
                ],
            ],
        ],
    ],
]);
?>