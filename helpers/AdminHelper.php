<?php

class AdminHelper
{
    /**
     * @param TravelActiveRecord $model
     * @param string $attribute
     * @param string $hint
     * @param int $width
     * @return string
     */
    public static function hintPreview($model, $attribute, $hint = '', $width = 200)
    {
        if (!empty($model->$attribute)) {
            $url = $model->getImageUrl($attribute);
            $img = CHtml::link(CHtml::image($url, '', ['width' => $width]), $url, ['target' => '_blank']);
        } else {
            $img = '';
        }
        return $hint . "\n" . $img;
    }

    /**
     * @param TravelActiveRecord $model
     * @param string $attr
     * @return string
     */
    public static function gridPreview($model, $attr)
    {
        if (!empty($model->$attr)) {
            $url = $model->getImageUrl($attr);
            return CHtml::link(CHtml::image(ResizeHelper::init()->image($url)->fit(120, 80)), $url, ['target' => '_blank']);
        }
        return '';
    }

    /**
     * @param TravelActiveRecord $model
     * @param string $attribute
     * @return string|bool
     */
    public static function previewColor($model, $attribute)
    {
        if (!empty($model->$attribute)) {
            $color = '<span class="color-square" style="background: #' . $model->$attribute . '"></span>';
        } else {
            $color = false;
        }
        return $color;
    }
}
