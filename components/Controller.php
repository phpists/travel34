<?php

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{

    const STATIC_ACTION_NAME = 'static';
    /**
     * @var string the default layout for the controller view. Defaults to '//layouts/column1',
     * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
     */
    public $layout = '//layouts/column1';

    /**
     * @var array context menu items. This property will be assigned to {@link CMenu::items}.
     */
    public $menu = [];

    /**
     * @var array the breadcrumbs of the current page. The value of this property will
     * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
     * for more details on how to specify this property.
     */
    public $breadcrumbs = [];

    public function init()
    {
        parent::init();
    }

    protected function beforeAction($action)
    {
        if (defined('YII_DEBUG') && YII_DEBUG) {
            Yii::app()->assetManager->forceCopy = true;
        }
        return parent::beforeAction($action);
    }

    protected function afterRender($view, &$output)
    {
        $output = str_replace(['"/media/',"'/media/"],['"https://trevel34.loc/media/',"'https://trevel34.loc/media/"],$output);
        return parent::afterRender($view, $output);
    }

}
