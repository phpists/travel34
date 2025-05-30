<?php
/** @var int $item_id */

$styles = Style::getAllStylesByPageKey(Style::PAGE_KEY_POST, $item_id);
?>

<h4>Стили</h4>

<div class="elements-section">
    <div class="elements-container">
        <?php foreach ($styles as $one): ?>
            <?= $this->renderPartial('_style', ['model' => $one]) ?>
        <?php endforeach; ?>
    </div>
    <div class="new-element-container"></div>
    <div>
        <button type="button" data-href="<?= $this->createUrl('createStyle', ['id' => $item_id]) ?>" class="btn add-element">
            Добавить новый стиль
        </button>
    </div>
</div>
