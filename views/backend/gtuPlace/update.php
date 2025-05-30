<?php
/* @var $this GtuPlaceController */
/* @var $model GtuPlace */

$this->pageTitle = Yii::t('app', 'Edit Place');
$this->breadcrumbs = [
    Yii::t('app', 'Places') => ['index'],
    Yii::t('app', 'Edit'),
];
$this->menu = [
    ['label' => Yii::t('app', 'All Places'), 'url' => ['index']],
    ['label' => Yii::t('app', 'Add Place'), 'url' => ['create']],
];
?>

<h1><?= $this->pageTitle ?> «<?= $model->title ?>»</h1>

<?php $this->renderPartial('_form', ['model' => $model]); ?>