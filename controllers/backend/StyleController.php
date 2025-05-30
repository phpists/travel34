<?php

class StyleController extends BackEndController
{
    /**
     * @return array action filters
     */
    public function filters()
    {
        return [
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        ];
    }

    /**
     * @return array
     */
    public function actions()
    {
        return [
            'toggle' => [
                'class' => 'bootstrap.actions.TbToggleAction',
                'modelName' => 'Style',
            ],
        ];
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $page_key = Yii::app()->request->getQuery('page_key');
        $item_id = Yii::app()->request->getQuery('item_id');

        $model = new Style();

        if (in_array($page_key, Style::getPageKeysAllRange())) {
            $model->page_keys = [$page_key];
            $model->item_ids = [];
            if (in_array($page_key, Style::getPageKeysWithItemsRange()) && !empty($item_id)) {
                $item_id = (int)$item_id;
                $model->title = Style::getItemTitleById($page_key, $item_id);
                $model->item_ids = [$item_id];
            }
        }

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Style'])) {
            $model->attributes = $_POST['Style'];
            if ($model->save()) {
                $this->redirect(['update', 'id' => $model->id]);
            }
        }

        $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Style'])) {
            // empty by default
            $model->geo_target_codes = [];

            $model->attributes = $_POST['Style'];
            if ($model->save()) {
                $this->redirect(['update', 'id' => $model->id]);
            }
        }

        $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax'])) {
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : ['index']);
        }
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        $model = new Style('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Style'])) {
            $model->attributes = $_GET['Style'];
        }

        $this->render('index', [
            'model' => $model,
        ]);
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Style the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = Style::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Style $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'style-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /**
     * Editable saver function
     */
    public function actionEditableSaver()
    {
        Yii::import('bootstrap.widgets.TbEditableSaver');

        $es = new TbEditableSaver('Style');
        $es->onBeforeUpdate = function ($event) {
            $event->sender->setAttribute('updated_at', date('Y-m-d H:i:s'));
        };
        $es->update();
    }
}
