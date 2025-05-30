<?php
/* @var $this TestWidgetController */
/* @var $model TestWidgetUser */

$this->pageTitle = 'Лог тестов';
$this->breadcrumbs = [
    'Виджеты тестов' => ['testWidget/index'],
    'Лог тестов'
];
?>

<h1><?= $this->pageTitle ?></h1>

<?php
$this->widget('bootstrap.widgets.TbExtendedGridView', [
    'id' => 'test-widget-user-grid',
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
            'name' => 'test_widget_id',
            'filter' => TestWidget::getItemsList(),
            'value' => function ($data) {
                /** @var TestWidgetUser $data */
                return $data->testWidget !== null ? $data->testWidget->title : null;
            },
        ],
        [
            'name' => 'test_result_id',
            'filter' => TestResult::getItemsList(),
            'value' => function ($data) {
                /** @var TestWidgetUser $data */
                return $data->testResult !== null ? $data->testResult->title : null;
            },
        ],
        'browser',
        [
            'name' => 'country',
            'filter' => Countries::getList(),
            'value' => function ($data) {
                /** @var TestWidgetUser $data */
                return Countries::getName($data->country);
            },
        ],
        [
            'name' => 'started_at',
            'filter' => false,
            'value' => function ($data) {
                /** @var TestWidgetUser $data */
                return $data->started_at > 0 ? date('d.m.Y H:i:s', $data->started_at) : null;
            },
        ],
        [
            'name' => 'finished_at',
            'filter' => false,
            'value' => function ($data) {
                /** @var TestWidgetUser $data */
                return $data->finished_at > 0 ? date('d.m.Y H:i:s', $data->finished_at) : null;
            },
        ],
    ],
]);
