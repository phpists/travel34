<?php

class RubricController extends BackEndController
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

    public function actions()
    {
        return [
            'toggle' => [
                'class' => 'bootstrap.actions.TbToggleAction',
                'modelName' => 'Rubric',
            ],
        ];
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model = new Rubric;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Rubric'])) {
            $model->attributes = $_POST['Rubric'];

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

        if (isset($_POST['Rubric'])) {
            $model->attributes = $_POST['Rubric'];

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
        $model = new Rubric('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Rubric'])) {
            $model->attributes = $_GET['Rubric'];
        }

        $this->render('index', [
            'model' => $model,
        ]);
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Rubric the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = Rubric::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Rubric $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'rubric-form') {
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

        $es = new TbEditableSaver('Rubric');
        $es->onBeforeUpdate = function ($event) {
            $event->sender->setAttribute('updated_at', date('Y-m-d H:i:s'));
        };
        $es->update();
    }
}
