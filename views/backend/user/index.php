<?php
/* @var $this UserController */
/* @var $model User */

$this->pageTitle = 'Пользователи';
$this->breadcrumbs = [
    'Пользователи',
];
$this->menu = [
    ['label' => 'Добавить пользователя', 'url' => ['create']],
];
?>

<h1><?= $this->pageTitle ?></h1>

<?php
$this->widget('bootstrap.widgets.TbExtendedGridView', [
    'id' => 'user-grid',
    'type' => 'striped bordered',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => [
        [
            'name' => 'id',
            'headerHtmlOptions' => ['style' => 'text-align: center; width: 30px'],
            'htmlOptions' => ['style' => 'text-align: center'],
        ],
        'username',
        //'email',
        'last_login_time',
        'created_at',
        'updated_at',
        [
            'name' => 'role',
            'class' => 'bootstrap.widgets.TbEditableColumn',
            'filter' => User::getRoleOptions(),
            'editable' => [
                'url' => $this->createUrl('editableSaver'),
                'type' => 'select',
                'source' => User::getRoleOptions(),
            ],
        ],
        [
            'class' => 'bootstrap.widgets.TbButtonColumn',
            'template' => '{update} {delete}',
            'htmlOptions' => ['style' => 'width: 50px'],
        ],
    ],
]);
?>
