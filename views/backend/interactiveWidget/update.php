<?php
/* @var $this InteractiveWidgetController */
/* @var $model InteractiveWidget */

$this->pageTitle = 'Редактирование виджета';
$this->breadcrumbs = [
    'Интерактивные виджеты' => ['index'],
    'Редактирование',
];
$this->menu = [
    ['label' => 'Все виджеты', 'url' => ['index']],
    ['label' => 'Добавить виджет', 'url' => ['create']],
];
?>

<h1><?= $this->pageTitle ?> «<?= $model->title ?>»</h1>

<?php $this->renderPartial('_form', ['model' => $model]); ?>

<div class="preview-test-widget<?= isset($_COOKIE['hidden-test-widget']) && $_COOKIE['hidden-test-widget'] == '1' ? ' hidden-test-widget' : '' ?>">
    <div class="toggle-preview-test-widget" title="Скрыть/показать превью"><span class="icon-arrow-right"></span><span class="icon-arrow-left"></span></div>
    <iframe src="<?= Yii::app()->request->baseUrl ?>/site/previewInteractive/<?= $model->id ?>"></iframe>
</div>
