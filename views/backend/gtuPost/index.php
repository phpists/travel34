<?php
/* @var $this GtuPostController */
/* @var $model GtuPost */

$this->pageTitle = 'Посты';
$this->breadcrumbs = [
    'Посты',
];
$this->menu = [
    ['label' => 'Добавить пост', 'url' => ['create']],
];

$now = Yii::app()->db->createCommand('SELECT NOW()')->queryScalar();
?>

<h1><?= $this->pageTitle ?> <small><?= $now ?></small></h1>

<?php
$this->widget('bootstrap.widgets.TbExtendedGridView', [
    'id' => 'gtu-post-grid',
    'type' => 'striped bordered',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'rowHtmlOptionsExpression' => '["class"=>$data->date>"' . $now . '"?"warning":"foo"]',
    'columns' => [
        /*[
            'name' => 'id',
            'headerHtmlOptions' => ['style' => 'text-align: center; width: 30px'],
            'htmlOptions' => ['style' => 'text-align: center'],
        ],*/
        [
            'name' => 'title',
            'type' => 'raw',
            'value' => function ($data) {
                /** @var GtuPost $data */
                return CHtml::link($data->title, $data->getUrl(), ['target' => '_blank']);
            },
        ],
        [
            'class' => 'bootstrap.widgets.TbButtonColumn',
            'htmlOptions' => ['style' => 'width: 30px; text-align: center'],
            'template' => '{update}',
        ],
        [
            'name' => 'is_top',
            'header' => $model->getAttributeLabel('is_top') . ' (620x413)',
            'class' => 'bootstrap.widgets.TbToggleColumn',
            'filter' => GtuPost::getYesNoOptions(),
            'toggleAction' => 'toggle',
            'headerHtmlOptions' => ['style' => 'text-align: center; width: 70px'],
            'htmlOptions' => ['style' => 'text-align: center'],
            'uncheckedButtonLabel' => 'Нет',
            'checkedButtonLabel' => 'Да',
        ],
        [
            'name' => 'is_big_top',
            'header' => $model->getAttributeLabel('is_big_top') . ' (1920x500)',
            'class' => 'bootstrap.widgets.TbToggleColumn',
            'filter' => GtuPost::getYesNoOptions(),
            'toggleAction' => 'toggle',
            'headerHtmlOptions' => ['style' => 'text-align: center; width: 70px'],
            'htmlOptions' => ['style' => 'text-align: center'],
            'uncheckedButtonLabel' => 'Нет',
            'checkedButtonLabel' => 'Да',
        ],
        [
            'name' => 'is_home_supertop',
            'class' => 'bootstrap.widgets.TbToggleColumn',
            'filter' => GtuPost::getYesNoOptions(),
            'toggleAction' => 'toggle',
            'headerHtmlOptions' => ['style' => 'text-align: center; width: 70px'],
            'htmlOptions' => ['style' => 'text-align: center'],
            'uncheckedButtonLabel' => 'Нет',
            'checkedButtonLabel' => 'Да',
        ],
        [
            'name' => 'is_home_big_top',
            'header' => $model->getAttributeLabel('is_home_big_top') . ' (1920x500)',
            'class' => 'bootstrap.widgets.TbToggleColumn',
            'filter' => GtuPost::getYesNoOptions(),
            'toggleAction' => 'toggle',
            'headerHtmlOptions' => ['style' => 'text-align: center; width: 70px'],
            'htmlOptions' => ['style' => 'text-align: center'],
            'uncheckedButtonLabel' => 'Нет',
            'checkedButtonLabel' => 'Да',
        ],
        /*[
            'name' => 'is_supertop',
            'class' => 'bootstrap.widgets.TbToggleColumn',
            'filter' => GtuPost::getYesNoOptions(),
            'toggleAction' => 'toggle',
            'headerHtmlOptions' => ['style' => 'text-align: center; width: 70px'],
            'htmlOptions' => ['style' => 'text-align: center'],
            'uncheckedButtonLabel' => 'Нет',
            'checkedButtonLabel' => 'Да',
        ],*/
        //[
        //    'name' => 'type_id',
        //    'filter' => GtuPost::getTypeOptions(),
        //    'value' => function ($data) {
        //        /** @var $data GtuPost */
        //        $options = GtuPost::getTypeOptions();
        //        return isset($options[$data->type_id]) ? $options[$data->type_id] : '';
        //    },
        //],
        [
            'name' => 'language',
            'filter' => Yii::app()->params['gtuLanguages'],
            'value' => function ($data) {
                /** @var GtuBanner $data */
                $languages = Yii::app()->params['gtuLanguages'];
                return isset($languages[$data->language]) ? $languages[$data->language] : '';
            },
        ],
        [
            'name' => 'rubric_search',
            'value' => function ($data) {
                /** @var $data GtuPost */
                return $data->gtuRubric ? ($data->language == 'en' ? CHtml::encode($data->gtuRubric->title_en) : CHtml::encode($data->gtuRubric->title)) : '';
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
            'name' => 'image',
            'type' => 'raw',
            'header' => 'Картинка',
            'value' => function ($data) {
                return AdminHelper::gridPreview($data, 'image');
            },
            'headerHtmlOptions' => ['style' => 'width: 120px'],
        ],
        [
            'name' => 'status_id',
            'class' => 'bootstrap.widgets.TbToggleColumn',
            'filter' => GtuPost::getStatusOptions(),
            'toggleAction' => 'toggle',
            'headerHtmlOptions' => ['style' => 'text-align: center; width: 80px'],
            'htmlOptions' => ['style' => 'text-align: center'],
            'uncheckedButtonLabel' => 'Опубликовать',
            'checkedButtonLabel' => 'Черновик',
        ],
        'date',
        [
            'class' => 'bootstrap.widgets.TbButtonColumn',
            'htmlOptions' => ['style' => 'width: 30px; text-align: center'],
            'template' => '{delete}',
        ],
    ],
]);
?>
