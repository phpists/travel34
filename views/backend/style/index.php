<?php
/* @var $this StyleController */
/* @var $model Style */

$this->pageTitle = 'Стили';
$this->breadcrumbs = [
    'Стили',
];
$this->menu = [
    ['label' => 'Добавить стиль', 'url' => ['create']],
];
?>

<h1><?= $this->pageTitle ?></h1>

<?php
$this->widget('bootstrap.widgets.TbExtendedGridView', [
    'id' => 'style-grid',
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
        [
            'name' => 'page_keys',
            'filter' => false,
            'type' => 'raw',
            'value' => function ($data) {
                /** @var Style $data */
                $out = '';
                foreach ($data->styleAssigns as $assign) {
                    $out .= StyleAssign::getItemLink($assign) . "<br>\n";
                }
                return $out;
            },
        ],
        [
            'name' => 'geo_target',
            'filter' => false,
            'sortable' => false,
            'value' => function ($data) {
                /** @var Style $data */
                return $data->getGeoTargets();
            },
        ],
        [
            'name' => 'views_count',
            'class' => 'bootstrap.widgets.TbEditableColumn',
            'editable' => [
                'url' => $this->createUrl('editableSaver'),
            ],
            'headerHtmlOptions' => ['style' => 'width: 80px'],
        ],
        [
            'name' => 'status_id',
            'class' => 'bootstrap.widgets.TbToggleColumn',
            'filter' => Style::getStatusOptions(),
            'toggleAction' => 'toggle',
            'headerHtmlOptions' => ['style' => 'text-align: center; width: 150px'],
            'htmlOptions' => ['style' => 'text-align: center; width: 150px'],
            'uncheckedButtonLabel' => 'Опубликовать',
            'checkedButtonLabel' => 'Черновик',
        ],
        [
            'class' => 'bootstrap.widgets.TbButtonColumn',
            'htmlOptions' => ['style' => 'width: 50px'],
            'template' => '{update}{delete}',
        ],
    ],
]);
