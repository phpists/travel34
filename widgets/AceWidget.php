<?php

class AceWidget extends CInputWidget
{
    /**
     * @var string Ace mode
     */
    public $mode = 'html';
    /**
     * @var string Ace theme
     */
    public $theme = 'chrome';
    /**
     * @var array Ace options
     * @see https://github.com/ajaxorg/ace/wiki/Configuring-Ace
     */
    public $clientOptions = [
        'fontSize' => 14,
        'minLines' => 6,
        'maxLines' => 'js:Infinity',
        'useSoftTabs' => true
    ];
    /**
     * @var array Ace container options
     */
    public $containerOptions = [];

    /**
     * Widget's run function
     */
    public function run()
    {
        list($name, $id) = $this->resolveNameID();

        $this->htmlOptions['style'] = 'display:none';
        $this->containerOptions['id'] = $id . '-ace';

        echo CHtml::tag('div', $this->containerOptions, '');
        if ($this->hasModel()) {
            echo CHtml::activeTextArea($this->model, $this->attribute, $this->htmlOptions);
        } else {
            echo CHtml::textArea($name, $this->value, $this->htmlOptions);
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

        $assetsUrl = Yii::app()->assetManager->publish(Yii::getPathOfAlias('application.assets.widgets'));
        $cs->registerScriptFile($assetsUrl . '/admin-widgets.js');

        $encodedOptions = !empty($this->clientOptions) ? CJavaScript::encode($this->clientOptions) : '{}';

        $cs->registerScript(__CLASS__ . '#' . $this->getId(), "adminWidgets.ace('$id-ace', '$id', '{$this->mode}', '{$this->theme}', $encodedOptions);", CClientScript::POS_END);
    }
}
