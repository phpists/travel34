<?php
/** @var string $page_key */
/** @var int $item_id */
?>
<div class="control-group">
    <label class="control-label">Стили<?= isset($subtitle) ? ' (' . $subtitle . ')' : '' ?></label>
    <div class="controls">
        <p><?= CHtml::link('Добавить новый стиль', ['style/create', 'page_key' => $page_key, 'item_id' => $item_id], ['class' => 'btn']) ?></p>
        <?php
        $styles = Style::getAllStylesByPageKey($page_key, $item_id);
        foreach ($styles as $one) {
            $geo_targets = $one->getGeoTargets();
            ?>
            <p>
                <?= CHtml::link($one->title, ['style/update', 'id' => $one->id]) ?>
                <?= $one->status_id == Style::STATUS_ENABLED ? '' : '(отключен)' ?>
                <?= (!empty($geo_targets) ? '(' . $geo_targets . ')' : '') ?>
            </p>
            <?php
        }
        ?>
    </div>
</div>
