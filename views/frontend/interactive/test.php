<?php
/** @var $this InteractiveController */
/** @var $widgetModel TestWidget */
/** @var $model TestResult */
?>

<p class="test-title">
    <?php if ($widgetModel->step3_title_has_border == 1): ?>
        <span><span class="border-position"><?= nl2br(CHtml::encode($model->title)) ?></span></span>
    <?php else: ?>
        <?= nl2br(CHtml::encode($model->title)) ?>
    <?php endif; ?>
</p>

<?= $model->text ?>
