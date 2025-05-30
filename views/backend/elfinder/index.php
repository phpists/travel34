<?php
/** @var ElfinderController $this */
/** @var string|array $filter */

$this->layout = '//layouts/elfinder';
$this->pageTitle = 'elFinder';

$msg = Yii::t('app', 'Copy to clipboard: Ctrl+C, Enter');

$clientOptions = [
    'lang' => (in_array(Yii::app()->language, ['ru', 'be', 'by']) ? 'ru' : 'en'),
    'resizable' => false,
    'getFileCallback' => "js: function(file) { window.prompt(\"{$msg}\", file.url); }",
];
if (!empty($filter)) {
    $clientOptions['onlyMimes'] = (array)$filter;
}
?>

<?php $this->widget("ext.elfinder.ElFinderWidget", [
    'clientOptions' => $clientOptions,
    'connectorRoute' => '/elfinder/connector',
]); ?>