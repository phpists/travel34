<?php
/* @var $this PostController */
/* @var $model Post */

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
    'id' => 'post-grid',
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
                /** @var Post $data */
                return CHtml::link($data->title, $data->getUrl(), ['target' => '_blank']);
            },
        ],
        [
            'class' => 'bootstrap.widgets.TbButtonColumn',
            'htmlOptions' => ['style' => 'width: 30px; text-align: center'],
            'template' => '{update}',
        ],
        /*[
            'header' => 'Топ',
            'type' => 'html',
            'value' => function ($data) {
                // @var $data Post
                $result = [];
                if ($data->is_small_top == Post::YES) {
                    $result[] = $data->getAttributeLabel('is_small_top');
                }
                if ($data->is_big_top == Post::YES) {
                    $result[] = $data->getAttributeLabel('is_big_top');
                }
                if ($data->is_home_top == Post::YES) {
                    $result[] = $data->getAttributeLabel('is_home_top');
                }
                if ($data->is_home_first_top == Post::YES) {
                    $result[] = $data->getAttributeLabel('is_home_first_top');
                }
                return '<p style="white-space: nowrap">' . implode('<br>', $result) . '</p>';
            },
        ],*/
        [
            'name' => 'is_small_top',
            'class' => 'bootstrap.widgets.TbToggleColumn',
            'filter' => Post::getYesNoOptions(),
            'toggleAction' => 'toggle',
            'headerHtmlOptions' => ['style' => 'text-align: center; width: 50px'],
            'htmlOptions' => ['style' => 'text-align: center'],
            'uncheckedButtonLabel' => 'Нет',
            'checkedButtonLabel' => 'Да',
        ],
        [
            'name' => 'is_home_top',
            'header' => $model->getAttributeLabel('is_home_top') . ' (1920x500)',
            'class' => 'bootstrap.widgets.TbToggleColumn',
            'filter' => Post::getYesNoOptions(),
            'toggleAction' => 'toggle',
            'headerHtmlOptions' => ['style' => 'text-align: center; width: 60px'],
            'htmlOptions' => ['style' => 'text-align: center'],
            'uncheckedButtonLabel' => 'Нет',
            'checkedButtonLabel' => 'Да',
        ],
        /*[
            'name' => 'is_big_top',
            'class' => 'bootstrap.widgets.TbToggleColumn',
            'filter' => Post::getYesNoOptions(),
            'toggleAction' => 'toggle',
            'headerHtmlOptions' => ['style' => 'text-align: center; width: 60px'],
            'htmlOptions' => ['style' => 'text-align: center'],
            'uncheckedButtonLabel' => 'Нет',
            'checkedButtonLabel' => 'Да',
        ],*/
        [
            'name' => 'is_home_first_top',
            'header' => $model->getAttributeLabel('is_home_first_top') . ' (1920x500)',
            'class' => 'bootstrap.widgets.TbToggleColumn',
            'filter' => Post::getYesNoOptions(),
            'toggleAction' => 'toggle',
            'headerHtmlOptions' => ['style' => 'text-align: center; width: 60px'],
            'htmlOptions' => ['style' => 'text-align: center'],
            'uncheckedButtonLabel' => 'Нет',
            'checkedButtonLabel' => 'Да',
        ],
        [
            'name' => 'type_id',
            'filter' => Post::getTypeOptions(),
            'value' => function ($data) {
                /** @var $data Post */
                $options = Post::getTypeOptions();
                return isset($options[$data->type_id]) ? $options[$data->type_id] : '';
            },
        ],
        [
            'name' => 'city_search',
            'value' => function ($data) {
                /** @var $data Post */
                $cities = $data->cities;
                $result = [];
                foreach ($cities as $city) {
                    $result[] = $city->title;
                }
                return implode(', ', $result);
            },
        ],
        [
            'name' => 'country_search',
            'value' => function ($data) {
                /** @var $data Post */
                $countries = $data->countries;
                $result = [];
                foreach ($countries as $country) {
                    $result[] = $country->title;
                }
                if (count($result) > 6) {
                    $result = array_slice($result, 0, 5);
                    return implode(', ', $result) . ' [...]';
                }
                return implode(', ', $result);
            },
            'headerHtmlOptions' => ['style' => 'width: 10%'],
        ],
        [
            'name' => 'rubric_search',
            'value' => function ($data) {
                /** @var $data Post */
                return $data->rubric ? $data->rubric->title : '';
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
                return !empty($data->image_news) ? AdminHelper::gridPreview($data, 'image_news') : AdminHelper::gridPreview($data, 'image');
            },
            'headerHtmlOptions' => ['style' => 'width: 120px'],
        ],
        [
            'name' => 'special_id',
            'filter' => Post::getSpecialOptions(),
            'value' => function ($data) {
                /** @var $data Post */
                $options = SpecialProject::getItems();
                return isset($options[$data->special_id]) && $data->special_id != 0 ? $options[$data->special_id] : '';
            },
        ],
        /*[
            'name' => 'geo_target',
            'filter' => false,
            'sortable' => false,
            'value' => function ($data) {
                return $data->getGeoTargets();
            },
        ],*/
        /*[
            'name' => 'is_gtb_post',
            'class' => 'bootstrap.widgets.TbToggleColumn',
            'filter' => Post::getStatusOptions(),
            'toggleAction' => 'toggle',
            'headerHtmlOptions' => ['style' => 'text-align: center; width: 50px'],
            'htmlOptions' => ['style' => 'text-align: center'],
        ],*/
        /*[
            'name' => 'is_gtu_post',
            'class' => 'bootstrap.widgets.TbToggleColumn',
            'filter' => Post::getStatusOptions(),
            'toggleAction' => 'toggle',
            'headerHtmlOptions' => ['style' => 'text-align: center; width: 50px'],
            'htmlOptions' => ['style' => 'text-align: center'],
        ],*/
        [
            'name' => 'status_id',
            'class' => 'bootstrap.widgets.TbToggleColumn',
            'filter' => Post::getStatusOptions(),
            'toggleAction' => 'toggle',
            'headerHtmlOptions' => ['style' => 'text-align: center; width: 50px'],
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
