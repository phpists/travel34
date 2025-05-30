<?php
/* @var $this PostController */
/* @var $model Style */
?>

<div class="element-container">
    <div class="element">
        <div class="well well-small">
            <div class="list-edit pull-right">
                <a href="#" data-href="<?= $this->createUrl('updateStyle', ['id' => $model->id]) ?>" class="edit-element" title="Редактировать"><i class="icon-pencil"></i></a>
                &nbsp;
                <a href="#" data-href="<?= $this->createUrl('deleteStyle', ['id' => $model->id]) ?>" class="delete-element" title="Удалить"><i class="icon-remove"></i></a>
            </div>
            <strong><?= CHtml::encode($model->title) ?></strong>
            <?= ($model->status_id == Style::STATUS_ENABLED ? '' : '(отключен)') ?>
            <small><?= Style::getBgTypeOptions()[$model->background_type] ?></small>
        </div>
    </div>
    <div class="edit-element-container"></div>
</div>
