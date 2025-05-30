<?php
/* @var $this BackEndController */
/* @var $content string */

$this->beginContent('//layouts/main_nomenu');
?>
<div class="row-fluid">
    <div class="span4"></div>
    <div class="span4">
        <div class="main">
            <?= $content ?>
        </div>
    </div>
    <div class="span4"></div>
</div>
<?php $this->endContent(); ?>
