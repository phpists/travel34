<?php
/* @var $this BackEndController */
/* @var $content string */

$this->beginContent('//layouts/main');
?>
<?php
if (!empty($this->menu)) {
    foreach ($this->menu as $k => $one) {
        if (!isset($one['linkOptions'])) {
            $this->menu[$k]['linkOptions'] = ['class' => 'btn'];
        }
    }
}
$this->widget('zii.widgets.CMenu', [
    'items' => $this->menu,
    'htmlOptions' => ['class' => 'inline'],
]);
?>
<div class="main">
    <?= $content ?>
</div>
<?php $this->endContent(); ?>
