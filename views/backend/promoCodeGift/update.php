<?php
/* @var $this PromoCodeGiftController */
/* @var $model UserSubscriptionGift */

$this->pageTitle = 'Редактирование промокода';
$this->breadcrumbs = [
    'Подарочные промокоды' => ['index'],
    'Редактирование',
];
$this->menu = [
    ['label' => 'Все промокоды', 'url' => ['index']],
];
?>

    <h1><?= $this->pageTitle ?> «<?= $model->code ?>»</h1>

<?php $this->renderPartial('_form', ['model' => $model]); ?>