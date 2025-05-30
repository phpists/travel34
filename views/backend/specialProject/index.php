<?php
/* @var $this SpecialProjectController */
/* @var $model SpecialProject */

$this->pageTitle = 'Спецпроекты';
$this->breadcrumbs = [
    'Спецпроекты',
];
$this->menu = [
    ['label' => 'Добавить спецпроект', 'url' => ['create']],
];
?>

<h1><?= $this->pageTitle ?></h1>

<?php
$this->widget('bootstrap.widgets.TbExtendedGridView', [
    'id' => 'special-project-grid',
    'type' => 'striped bordered',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => [
        [
            'name' => 'id',
            'headerHtmlOptions' => ['style' => 'text-align: center; width: 30px'],
            'htmlOptions' => ['style' => 'text-align: center'],
        ],
        [
            'name' => 'url',
            'type' => 'raw',
            'value' => function ($data) {
                /** @var SpecialProject $data */
                return CHtml::link($data->url, $data->getUrl(), ['target' => '_blank']);
            },
        ],
        'title',
        'position',
        [
            'name' => 'is_new',
            'class' => 'bootstrap.widgets.TbToggleColumn',
            'filter' => SpecialProject::getStatusOptions(),
            'toggleAction' => 'toggle',
            'headerHtmlOptions' => ['style' => 'text-align: center; width: 150px'],
            'htmlOptions' => ['style' => 'text-align: center; width: 150px'],
            'uncheckedButtonLabel' => 'Сделать новым',
            'checkedButtonLabel' => 'В архив',
        ],
        [
            'name' => 'status_id',
            'class' => 'bootstrap.widgets.TbToggleColumn',
            'filter' => SpecialProject::getStatusOptions(),
            'toggleAction' => 'toggle',
            'headerHtmlOptions' => ['style' => 'text-align: center; width: 150px'],
            'htmlOptions' => ['style' => 'text-align: center; width: 150px'],
            'uncheckedButtonLabel' => 'Отобразить',
            'checkedButtonLabel' => 'Скрыть',
        ],
        [
            'class' => 'bootstrap.widgets.TbButtonColumn',
            'htmlOptions' => ['style' => 'width: 50px'],
            'template' => '{update}{delete}',
        ],
    ],
]);
?>
