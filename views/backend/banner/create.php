<?php
/* @var $this BannerController */
/* @var $model Banner */

$this->pageTitle = 'Добавление баннера';
$this->breadcrumbs = [
    'Баннеры' => ['index'],
    'Добавление',
];
$this->menu = [
    ['label' => 'Все баннеры', 'url' => ['index']],
];
?>

<h1><?= $this->pageTitle ?></h1>

<?php $this->renderPartial('_form', ['model' => $model]); ?>