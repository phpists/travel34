<?php
/** @var ElfinderController $this */
/** @var string|array $filter */

$this->layout = '//layouts/elfinder';
$this->pageTitle = 'elFinder';

$callback = <<<JSEXP
js: function (file) {
    var reParam = new RegExp('(?:[\?&]|&amp;)CKEditorFuncNum=([^&]+)', 'i');
    var match = window.location.search.match(reParam);
    var funcNum = (match && match.length > 1) ? match[1] : '';
    window.opener.CKEDITOR.tools.callFunction(funcNum, file.url);
    window.close();
}
JSEXP;

$clientOptions = [
    'lang' => (in_array(Yii::app()->language, ['ru', 'be', 'by']) ? 'ru' : 'en'),
    'resizable' => false,
    'getFileCallback' => $callback,
];
if (!empty($filter)) {
    $clientOptions['onlyMimes'] = (array)$filter;
}
?>

<?php $this->widget('ext.elfinder.ElFinderWidget', [
    'clientOptions' => $clientOptions,
    'connectorRoute' => '/elfinder/connector',
]); ?>