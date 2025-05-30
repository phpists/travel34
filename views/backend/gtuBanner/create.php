<?php
/* @var $this GtuBannerController */
/* @var $model GtuBanner */

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