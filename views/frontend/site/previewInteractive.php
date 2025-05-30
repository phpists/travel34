<?php

/* @var $this SiteController */
/* @var $id int */

$this->layout = 'simple';
$this->interactive = true;

/** @var CClientScript $cs */
$cs = Yii::app()->clientScript;

$css = <<<CSS
body {
    background: #fff;
}
.post-body {
    padding-bottom: 0;
}
.post-body .wide-box {
    margin: 0;
    padding: 0;
}
.interactive-box {
    margin-top: 0;
}
CSS;
$cs->registerCss('interactive-fixes', $css);
?>

<div class="post-body">
    <div class="wide-box">
        <?= Shortcodes::parse('[interactive id=' . $id . ']') ?>
    </div>
</div>
