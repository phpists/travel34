<?php
/* @var $this PromoCodeController */
/* @var $model PromoCode */

$this->pageTitle = 'Создать промокод';
$this->breadcrumbs = [
    'Скидочные промокоды' => ['index'],
    'Создание',
];
$this->menu = [
    ['label' => 'Все промокоды', 'url' => ['index']],
];
?>

    <h1><?= $this->pageTitle ?></h1>

<?php $this->renderPartial('_form', ['model' => $model]); ?>