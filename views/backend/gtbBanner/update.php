<?php
/* @var $this GtbBannerController */
/* @var $model GtbBanner */

$this->pageTitle = 'Редактирование баннера';
$this->breadcrumbs = [
    'Баннеры' => ['index'],
    'Редактирование',
];
$this->menu = [
    ['label' => 'Все баннеры', 'url' => ['index']],
    ['label' => 'Добавить баннер', 'url' => ['create']],
];
?>

<h1><?= $this->pageTitle ?> «<?= $model->title ?>»</h1>

<?php $this->renderPartial('_form', ['model' => $model]); ?>