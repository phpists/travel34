<?php
/* @var $this GtbRubricController */
/* @var $model GtbRubric */

$this->pageTitle = 'Рубрики';
$this->breadcrumbs = [
    'Рубрики',
];
$this->menu = [
    ['label' => 'Добавить рубрику', 'url' => ['create']],
];
?>

<h1><?= $this->pageTitle ?></h1>

<?php
$this->widget('bootstrap.widgets.TbExtendedGridView', [
    'id' => 'gtb-rubric-grid',
    'type' => 'striped bordered',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => [
        [
            'name' => 'id',
            'headerHtmlOptions' => ['style' => 'text-align: center; width: 30px'],
            'htmlOptions' => ['style' => 'text-align: center'],
        ],
        'title',
        'title_en',
        'title_be',
        [
            'name' => 'url',
            'type' => 'raw',
            'value' => function ($data) {
                /** @var GtbRubric $data */
                return CHtml::link($data->url, $data->getUrl(), ['target' => '_blank']);
            },
        ],
        'position',
        [
            'name' => 'hide_in_menu',
            'class' => 'bootstrap.widgets.TbToggleColumn',
            'filter' => GtbRubric::getStatusOptions(),
            'toggleAction' => 'toggle',
            'uncheckedButtonLabel' => 'Скрыть из меню',
            'checkedButtonLabel' => 'Отобразить в меню',
        ],
        [
            'name' => 'hide_in_menu_en',
            'class' => 'bootstrap.widgets.TbToggleColumn',
            'filter' => GtbRubric::getStatusOptions(),
            'toggleAction' => 'toggle',
            'uncheckedButtonLabel' => 'Скрыть из меню',
            'checkedButtonLabel' => 'Отобразить в меню',
        ],
        [
            'name' => 'hide_in_menu_be',
            'class' => 'bootstrap.widgets.TbToggleColumn',
            'filter' => GtbRubric::getStatusOptions(),
            'toggleAction' => 'toggle',
            'uncheckedButtonLabel' => 'Скрыть из меню',
            'checkedButtonLabel' => 'Отобразить в меню',
        ],
        [
            'name' => 'status_id',
            'class' => 'bootstrap.widgets.TbToggleColumn',
            'filter' => GtbRubric::getStatusOptions(),
            'toggleAction' => 'toggle',
            'uncheckedButtonLabel' => 'Отобразить рубрику',
            'checkedButtonLabel' => 'Скрыть рубрику',
        ],
        [
            'name' => 'in_todo_list',
            'class' => 'bootstrap.widgets.TbToggleColumn',
            'filter' => GtbPost::getYesNoOptions(),
            'toggleAction' => 'toggle',
            'headerHtmlOptions' => ['style' => 'text-align: center; width: 70px'],
            'htmlOptions' => ['style' => 'text-align: center'],
            'uncheckedButtonLabel' => 'Нет',
            'checkedButtonLabel' => 'Да',
        ],
        [
            'class' => 'bootstrap.widgets.TbButtonColumn',
            'htmlOptions' => ['style' => 'width: 50px'],
            'template' => '{update}{delete}',
        ],
    ],
]);
?>
