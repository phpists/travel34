<?php
/* @var $this PromoCodeGiftController */
/* @var $model UserSubscriptionGift */

$this->pageTitle = 'Подарочные промокоды';
$this->breadcrumbs = [
    'Подарочные промокоды',
];
$this->menu = [
    ['label' => 'Создать подарочный промокод', 'url' => ['create']],
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
        'code',
        'expiry_date',
        'user_email',
        'gift_email',
        'number_activations',
        'available_activations',
        'date_create',
        [
            'name' => 'type_id',
            'value' => function ($data) {
                return UserSubscriptionGift::getTypesId($data);
            },
        ],
        [
            'name' => 'status_id',
            'value' => function ($data) {
                return $data->getStatus();
            },
        ],
        [
            'class' => 'bootstrap.widgets.TbButtonColumn',
            'htmlOptions' => ['style' => 'width: 80px'],
            'template' => '{update}{delete}{pause}{restore}',
            'buttons' => [
                'update' => [
                    'url' => 'Yii::app()->createUrl("promoCodeGift/update", ["id"=>$data->id])',
                ],
                'delete' => [
                    'url' => 'Yii::app()->createUrl("promoCodeGift/delete", ["id"=>$data->id])',
                ],
                'pause' => [
                    'label' => 'Приостановить',
                    'icon' => 'pause',
                    'url' => 'Yii::app()->createUrl("promoCodeGift/pause", ["id"=>$data->id])',
                    'visible' => '$data->status_id == 3',
                ],
                'restore' => [
                    'label' => 'Восстановить',
                    'icon' => 'play',
                    'url' => 'Yii::app()->createUrl("promoCodeGift/restore", ["id"=>$data->id])',
                    'visible' => '$data->status_id == 1',
                ],
            ],
        ],
    ],
]);
?>