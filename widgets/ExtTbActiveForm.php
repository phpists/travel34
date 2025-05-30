<?php

Yii::import('bootstrap.widgets.TbActiveForm');

class ExtTbActiveForm extends TbActiveForm
{
    public function colorFieldRow($model, $attribute, $htmlOptions = [], $rowOptions = [])
    {
        $defaultHtmlOptions = ['class' => 'input-mini font-monospace', 'maxlength' => 6];
        $defaultRowOptions = [
            'prepend' => '#',
            'append' => AdminHelper::previewColor($model, $attribute),
        ];

        $htmlOptions = CMap::mergeArray($defaultHtmlOptions, $htmlOptions);
        $rowOptions = CMap::mergeArray($defaultRowOptions, $rowOptions);

        $this->initRowOptions($rowOptions);

        $fieldData = [[$this, 'textField'], [$model, $attribute, $htmlOptions]];

        return $this->customFieldRowInternal($fieldData, $model, $attribute, $rowOptions);
    }
}
