<?php
/** @var int $item_id */

$variants = TestQuestion::getVariantsByID($item_id);
?>

<h4>Варианты</h4>

<div class="elements-section">
    <div class="elements-container">
        <?php foreach ($variants as $one): ?>
            <?= $this->renderPartial('_variant', ['model' => $one]) ?>
        <?php endforeach; ?>
    </div>
    <div class="new-element-container"></div>
    <div>
        <button type="button" data-href="<?= $this->createUrl('createVariant', ['id' => $item_id]) ?>" class="btn add-element">
            Добавить новый вариант
        </button>
    </div>
</div>
