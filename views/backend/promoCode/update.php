<?php
/* @var $this PromoCodeController */
/* @var $model PromoCode */

$this->pageTitle = 'Редактирование промокода';
$this->breadcrumbs = [
    'Скидочные промокоды' => ['index'],
    'Редактирование',
];
$this->menu = [
    ['label' => 'Все промокоды', 'url' => ['index']],
];
?>

    <h1><?= $this->pageTitle ?> «<?= $model->promo_code ?>»</h1>

<?php $this->renderPartial('_form', ['model' => $model]); ?>