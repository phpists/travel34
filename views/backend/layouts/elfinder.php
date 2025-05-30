<?php
/** @var $this ElfinderController */
/** @var $content string */

/** @var CClientScript $cs */
$cs = Yii::app()->clientScript;
$css = <<<CSSEXP
html, body { height: 100%; margin: 0; padding: 0; overflow: hidden; }
body { background: #fff; }
.elfinder.ui-corner-all, .elfinder-toolbar.ui-corner-top, .elfinder-statusbar.ui-corner-bottom { border-radius: 0; }
CSSEXP;
$cs->registerCss('elFinderLayout', $css);

$pageTitle = !empty($this->pageTitle) ? $this->pageTitle : Yii::app()->name;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= CHtml::encode($pageTitle) ?></title>
</head>
<body>

<?= $content ?>

</body>
</html>