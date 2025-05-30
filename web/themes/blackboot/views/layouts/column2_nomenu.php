<?php
/* @var $this BackEndController */
/* @var $content string */

$this->beginContent('//layouts/main_nomenu');
?>
<?php
if (!empty($this->menu)) {
    foreach ($this->menu as $k => $one) {
        $this->menu[$k]['linkOptions'] = array('class' => 'btn');
    }
}
$this->widget('zii.widgets.CMenu', array(
    'items' => $this->menu,
    'htmlOptions' => array('class' => 'inline'),
));
?>
<div class="main">
    <?= $content ?>
</div>
<?php $this->endContent(); ?>
