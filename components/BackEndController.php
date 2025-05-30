<?php

/**
 * Parent controller for all backends controllers
 */
class BackEndController extends Controller
{
    public $noBootstrap = false;

    public $layout = '/layouts/column2';
    public $menu = [];
    public $breadcrumbs = [];

    public function init()
    {
        Yii::app()->setLanguage('ru');
        $cookie = new CHttpCookie('language', 'ru');
        $cookie->expire = time() + 60 * 60 * 24 * 100;
        Yii::app()->request->cookies['language'] = $cookie;
        // instead config preload preload here
        if (!$this->noBootstrap) {
            Yii::app()->getComponent('bootstrap');
        }
        parent::init();
    }

    public function filters()
    {
        return [
            'accessControl',
        ];
    }

    public function accessRules()
    {
        return [
            [
                'allow',
                'users' => ['*'],
                'actions' => ['login', 'logout'],
            ],
            [
                'allow',
                'users' => ['@'],
                'expression' => 'Yii::app()->user->isAdmin()',
            ],
            [
                'deny',
                'users' => ['*'],
                'deniedCallback' => function () {
                    if (Yii::app()->user->isGuest) {
                        Yii::app()->controller->redirect(['/admin/login']);
                    } else {
                        Yii::app()->controller->redirect(Yii::app()->request->getBaseUrl(true));
                    }
                },
            ],
        ];
    }
}
