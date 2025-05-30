<?php
/** @var $this InteractiveController */
/** @var $model InteractiveResult */
/** @var $name string */
/** @var $shareUrl string */
?>

<div class="interactive-result">
    <?= $model->text ?>
    <div class="share-links" data-url="<?= CHtml::encode($shareUrl) ?>"></div>
</div>
