<?php
/* @var $this InteractiveWidgetController */
/* @var $model InteractiveResult */

$text = $model->text;
$text = preg_replace('/<iframe[^>]*><\/iframe>/', 'IFRAME', $text);
$text = preg_replace('/<img[^>]*>/', 'IMAGE', $text);
$text = trim(strip_tags($text));
?>

<div class="element-container">
    <div class="element">
        <div class="well well-small">
            <div class="list-edit pull-right">
                <a href="#" data-href="<?= $this->createUrl('updateResult', ['id' => $model->id]) ?>" class="edit-element" title="Редактировать"><i class="icon-pencil"></i></a>
                &nbsp;
                <a href="#" data-href="<?= $this->createUrl('deleteResult', ['id' => $model->id]) ?>" class="delete-element" title="Удалить"><i class="icon-remove"></i></a>
            </div>
            <strong>ID <?= CHtml::encode($model->id) ?></strong>
            &nbsp; <?= CHtml::encode($text) ?>
        </div>
    </div>
    <div class="edit-element-container"></div>
</div>
