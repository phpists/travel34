<?php
/* @var $this TestQuestionController */
/* @var $model TestVariant */

$text = $model->text;
?>

<div class="element-container">
    <div class="element">
        <div class="well well-small">
            <div class="list-edit pull-right">
                <a href="#" data-href="<?= $this->createUrl('updateVariant', ['id' => $model->id]) ?>" class="edit-element" title="Редактировать"><i class="icon-pencil"></i></a>
                &nbsp;
                <a href="#" data-href="<?= $this->createUrl('deleteVariant', ['id' => $model->id]) ?>" class="delete-element" title="Удалить"><i class="icon-remove"></i></a>
            </div>
            <strong>ID <?= CHtml::encode($model->id) ?></strong>
            &nbsp; <span<?php if ($model->is_correct == 1): ?> class="text-success"<?php endif; ?>><?= CHtml::encode(strip_tags($model->text)) ?></span>
            <span class="label"><?= $model->position ?></span>
        </div>
    </div>
    <div class="edit-element-container"></div>
</div>
