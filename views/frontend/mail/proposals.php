<?php
/** @var Proposal[] $models */

foreach ($models as $model) {
    echo '<p style="margin:0 0 20px">' . CHtml::encode($model->name) . "<br>\n" . CHtml::encode($model->phone) . "</p>\n\n";
}
