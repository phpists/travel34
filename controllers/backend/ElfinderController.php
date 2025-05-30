<?php

class ElfinderController extends BackEndController
{
    public $noBootstrap = true;

    /**
     * @return array
     */
    public function actions()
    {
        return [
            // path to elfinder connector
            'connector' => [
                'class' => 'ext.elfinder.ElFinderConnectorAction',
                'connectorOptions' => [
                    'roots' => [
                        [
                            'driver' => 'LocalFileSystem',
                            'path' => Yii::getPathOfAlias('webroot') . DIRECTORY_SEPARATOR . 'media' . DIRECTORY_SEPARATOR . 'upload',
                            'URL' => Yii::app()->request->baseUrl . '/media/upload/',
                            'mimeDetect' => 'internal',
                            'imgLib' => 'gd',
                            //'uploadMaxConn' => -1,
                            'accessControl' => function ($attr, $path) {
                                // hide files/folders which begins with dot
                                return (strpos(basename($path), '.') === 0) ? !($attr == 'read' || $attr == 'write') : null;
                            },
                        ],
                    ],
                ],
            ],
        ];
    }

    /**
     * Страница с elfinder
     */
    public function actionIndex()
    {
        // Get 'onlyMimes' value from GET parameter
        $filter = Yii::app()->request->getQuery('filter');
        $this->render('index', ['filter' => $filter]);
    }

    /**
     * Страница с elfinder для текстового поля
     * @param string $field_id
     */
    public function actionField($field_id)
    {
        // Get 'onlyMimes' value from GET parameter
        $filter = Yii::app()->request->getQuery('filter');
        $this->render('field', ['field_id' => $field_id, 'filter' => $filter]);
    }

    /**
     * Страница с elfinder для редактора
     */
    public function actionEditor()
    {
        // Get 'onlyMimes' value from GET parameter
        $filter = Yii::app()->request->getQuery('filter');
        $this->render('editor', ['filter' => $filter]);
    }
}
