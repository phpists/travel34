<?php
/* @var $this PromoCodeGiftController */
/* @var $model UserSubscriptionGift */

$this->pageTitle = 'Создать промокод';
$this->breadcrumbs = [
    'Подарочные промокоды' => ['index'],
    'Создание',
];
$this->menu = [
    ['label' => 'Все промокоды', 'url' => ['index']],
];
?>

    <h1><?= $this->pageTitle ?></h1>

<?php $this->renderPartial('_form', ['model' => $model]); ?>