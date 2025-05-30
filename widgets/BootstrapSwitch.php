<?php

class BootstrapSwitch extends CInputWidget
{
    /**
     * @var string the javascript function
     * function(event, state) {}
     */
    public $onChange;
    /**
     * @var string The checkbox size
     */
    public $size;
    /**
     * @var bool Animate the switch
     */
    public $animate;
    /**
     * @var bool Inverse switch direction
     */
    public $inverse;
    /**
     * @var string Text of the left side of the switch
     */
    public $onText;
    /**
     * @var string Text of the right side of the switch
     */
    public $offText;
    /**
     * @var string Color of the left side of the switch
     * Accepted values: 'primary', 'info', 'success', 'warning', 'danger', 'default'
     */
    public $onColor;
    /**
     * @var string the style of the toggle button disabled style
     * Accepted values: 'primary', 'info', 'success', 'warning', 'danger', 'default'
     */
    public $offColor;

    /**
     * Widget's run function
     */
    public function run()
    {
        list($name, $id) = $this->resolveNameID();

        if ($this->hasModel()) {
            echo CHtml::activeCheckBox($this->model, $this->attribute, $this->htmlOptions);
        } else {
            echo CHtml::checkBox($name, $this->value, $this->htmlOptions);
        }

        $this->registerClientScript($id);
    }

    /**
     * Registers required css and js files
     *
     * @param int $id the id of the toggle button
     */
    protected function registerClientScript($id)
    {
        $cs = Yii::app()->clientScript;
        $cs->registerCoreScript('jquery');

        $assetsUrl = Yii::app()->assetManager->publish(Yii::getPathOfAlias('application.assets.bootstrap-switch'));

        $cs->registerCssFile($assetsUrl . '/css/bootstrap2/bootstrap-switch.min.css');
        $cs->registerScriptFile($assetsUrl . '/js/bootstrap-switch.min.js');

        $config = CJavaScript::encode($this->getConfiguration());

        $cs->registerScript(__CLASS__ . '#' . $this->getId(), "$('#{$id}').bootstrapSwitch({$config});");
    }

    /**
     * @return array the configuration of the plugin
     */
    protected function getConfiguration()
    {
        if ($this->onChange !== null) {
            if ((!$this->onChange instanceof CJavaScriptExpression) && strpos($this->onChange, 'js:') !== 0) {
                $onChange = new CJavaScriptExpression($this->onChange);
            } else {
                $onChange = $this->onChange;
            }
        } else {
            $onChange = null;
        }

        $config = [
            'onSwitchChange' => $onChange,
            'size' => $this->size,
            'animate' => $this->animate,
            'inverse' => $this->inverse,
            'onText' => $this->onText,
            'offText' => $this->offText,
            'onColor' => $this->onColor,
            'offColor' => $this->offColor,
        ];
        foreach ($config as $key => $element) {
            if (empty($element)) {
                unset($config[$key]);
            }
        }
        return $config;
    }
}
