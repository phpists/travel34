<?php
/* @var $this GtuPlaceController */
/* @var $model GtuPlace */

$this->pageTitle = Yii::t('app', 'Adding Place');
$this->breadcrumbs = [
    Yii::t('app', 'Places') => ['index'],
    Yii::t('app', 'Addition'),
];
$this->menu = [
    ['label' => Yii::t('app', 'All Places'), 'url' => ['index']],
];
?>

<h1><?= $this->pageTitle ?></h1>

<?php $this->renderPartial('_form', ['model' => $model]); ?>