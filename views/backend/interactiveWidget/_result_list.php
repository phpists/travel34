<?php
/** @var int $item_id */

$results = InteractiveWidget::getRelultsByID($item_id);
?>

<h4>Результаты</h4>

<div class="elements-section">
    <div class="elements-container">
        <?php foreach ($results as $one): ?>
            <?= $this->renderPartial('_result', ['model' => $one]) ?>
        <?php endforeach; ?>
    </div>
    <div class="new-element-container"></div>
    <div>
        <button type="button" data-href="<?= $this->createUrl('createResult', ['id' => $item_id]) ?>" class="btn add-element">
            Добавить новый результат
        </button>
    </div>
</div>
