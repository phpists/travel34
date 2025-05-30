<?php
/* @var $this SubscriptionSettingController */
/* @var $model Subscription */

$this->pageTitle = 'Редактировать подписку';
$this->breadcrumbs = [
    'Настройки' => ['index'],
    'Редактирование',
];
$this->menu = [
    ['label' => 'Все подписки', 'url' => ['index']],
    ['label' => 'Добавить подписку', 'url' => ['create']],
];
?>

    <h1><?= $this->pageTitle ?> «<?= $model->title ?>»</h1>

<?php $this->renderPartial('_form', ['model' => $model]); ?>